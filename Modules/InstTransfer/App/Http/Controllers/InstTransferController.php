<?php

namespace Modules\InstTransfer\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Klick\App\Http\Controllers\KlickController;
use Yajra\DataTables\Facades\DataTables;

class InstTransferController extends Controller
{
    public function getData()
    {
        $data = Disbursement::whereNotIn('bank_code', ['BILPAY'])->orderBy('id', 'desc')->limit(5000)->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm btn-delete">Hapus</a>
            <a href="javascript:void(0)" data-id="'.$row->ref_id.'" class="btn btn-warning btn-sm btn-cek">Cek Status</a>';
            return $actionBtn;
        })
        ->addColumn('username', function($row){
            $t = '<span>'.$row->user->name.'</span>';
            return $t;
        })
        ->addColumn('ref_id', function($row){
            $t = '<span>'.Str::upper($row->ref_id).'</span>';
            return $t;
        })
        ->addColumn('swift', function($row){
            $t = '<span>'.$row->bank_code.'</span>';
            return $t;
        })
        ->addColumn('tujuan', function($row){
            $t = '<span>'.$row->account_number.'</span>';
            return $t;
        })
        ->addColumn('hold_name', function($row){
            $t = '<span>'.$row->account_holder_name.'</span>';
            return $t;
        })
        ->addColumn('nominal', function($row){
            $t = '<span>'.rupiah($row->nominal).'</span>';
            return $t;
        })
        ->addColumn('desc', function($row){
            $t = '<span>'.$row->disbursement_description.'</span>';
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->status == 'INQUIRY'){
                $t = '<span class="text-warning">'.Str::upper($row->status).'</span>';
            }else {
                $t = '<span class="text-success">'.Str::upper($row->status).'</span>';
            }

            return $t;
        })
        ->addColumn('trx_date', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->rawColumns([
            'action',
            'username',
            'ref_id',
            'swift',
            'tujuan',
            'hold_name',
            'nominal',
            'desc',
            'status',
            'trx_date'
        ])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('insttransfer::index');
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

    public function cekStatus(Request $request, KlickController $klik)
    {
        $d = $klik->cekStatus(Str::lower($request->ref_id));
        $k = Disbursement::where('ref_id', Str::lower($request->ref_id))->first();
        $k->status = $d[0]->data->status;
        $k->save();
        return successResponse('Sukses', $d);
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Disbursement::find($id);

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
