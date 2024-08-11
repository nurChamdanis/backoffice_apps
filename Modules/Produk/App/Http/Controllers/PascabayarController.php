<?php

namespace Modules\Produk\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Produk\App\Models\Produk;
use Yajra\DataTables\Facades\DataTables;

class PascabayarController extends Controller
{
    public function getData()
    {
        $data = Produk::where('prabayar', 0)->orderBy('id', 'asc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm btn-delete">Hapus</a>';
            return $actionBtn;
        })
        ->addColumn('code', function($row){
            $t = '<span>'.$row->code.'</span>';
            return $t;
        })
        ->addColumn('name', function($row){
            $t = '<span>'.$row->name.'</span>';
            return $t;
        })
        ->addColumn('desc', function($row){
            $t = '<span>'.$row->description.'</span>';
            return $t;
        })
        ->addColumn('price', function($row){
            $t = '<span>'.rupiah($row->price).'</span>';
            return $t;
        })
        ->addColumn('margin', function($row){
            $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="showEditMarkup">
                '.rupiah($row->margin).'
                <em class="icon ni ni-edit ml-2 text-warning" style="margin-left:5px"></em>
            </a>';
            return $btn;
        })
        ->addColumn('sale_price', function($row){
            $t = '<span>'.rupiah($row->sale_price).'</span>';
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->status == 0){
                $t = '<span class="text-danger">GANGGUAN</span>';
            }else {
                $t = '<span class="text-success">AKTIF</span>';
            }
            return $t;
        })
        ->rawColumns(['action', 'name', 'code', 'type', 'desc', 'price', 'margin', 'sale_price', 'status'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('produk::pascabayar.index');
    }

    public function create()
    {
        return view('produk::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('produk::show');
    }

    public function edit($id)
    {
        $k = Produk::find($id);
        return response()->json($k);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Produk::find($id);

        if($k->delete()){
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully'; 
        }else{
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }

        return response()->json($response);
    }

    public function editMarkup(Request $request)
    {
        try {
            $id = $request->produk_id;
            $val = $request->value;
    
            $d = Produk::where('id', $id)->first();
            $d->margin = $val;
            $d->sale_price = intval($d->price) + intval($val);
            $d->save();
    
            return successResponse('Shared Fee berhasil disimpan', 200);
        } catch (\Throwable $th) {
            return errorResponApi($th->getMessage(), 401);
        }
    }

    public function editMarkupBulk(Request $request)
    {
        $p = Produk::where('prabayar', 0)->get();
        foreach ($p as $i) {

            $price = intval($i->price) + intval($request->value);            
            $i->margin      = $request->value;
            $i->sale_price  = $price;
            $i->save();
        }

        return successResponse('Singkronisasi produk berhasil', null, true);
    }
}
