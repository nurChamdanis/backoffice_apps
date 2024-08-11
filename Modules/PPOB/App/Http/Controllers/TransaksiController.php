<?php

namespace Modules\PPOB\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Transaksi\App\Models\Transaksi;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function getData()
    {
        $data = Transaksi::orderBy('id', 'desc')->limit(5000)->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm btn-delete">Hapus</a>
            <a href="javascript:void(0)" data-id="'.$row->seller_ref.'" class="btn btn-warning btn-sm btn-cek">Cek Status</a>';
            return $actionBtn;
        })
        ->addColumn('username', function($row){
            $t = '<span>'.$row->user->name.'</span>';
            return $t;
        })
        ->addColumn('invoice', function($row){
            $t = '<span>'.$row->invoice.'</span>';
            return $t;
        })
        ->addColumn('produk_id', function($row){
            $t = '<span>'.$row->produk->code.'</span>';
            return $t;
        })
        ->addColumn('produk_name', function($row){
            $t = '<span>'.$row->produk->name.'</span>';
            return $t;
        })
        ->addColumn('tujuan', function($row){
            $t = '<span>'.$row->tujuan.'</span>';
            return $t;
        })
        ->addColumn('sale_price', function($row){
            $t = '<span>'.rupiah($row->harga).'</span>';
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->status == 'PENDING'){
                $t = '<span class="text-warning">'.Str::upper($row->status).'</span>';
            }else if($row->status == 'GAGAL'){
                $t = '<span class="text-danger">'.Str::upper($row->status).'</span>';
            }else {
                $t = '<span class="text-success">'.Str::upper($row->status).'</span>';
            }

            return $t;
        })
        ->addColumn('trx_date', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->addColumn('sn', function($row){
            $t = '<span>'.Str::limit($row->sn, 80, '...').'</span>';
            return $t;
        })
        ->rawColumns(['action', 'username', 'invoice', 'produk_id', 'produk_name', 'tujuan', 'sale_price', 'margin', 'total', 'status', 'trx_date', 'sn'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('ppob::transaksi.index');
    }

    public function create()
    {
        return view('ppob::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('ppob::show');
    }

    public function edit($id)
    {
        return view('ppob::edit');
    }

    public function cekStatus(Request $request)
    {
        $d = cekStatusNukar($request->seller_id);
        $k = Transaksi::where('seller_ref', $request->seller_id)->first();
        $k->sn      = $d[0]->data->sn;
        $k->status  = $d[0]->data->status;
        $k->save();
        return successResponse('Sukses', $d);
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Transaksi::find($id);

        if($k->delete()){
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully'; 
        }else{
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }

        return response()->json($response);
    }
}
