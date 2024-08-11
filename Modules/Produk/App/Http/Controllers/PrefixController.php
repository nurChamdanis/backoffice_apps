<?php

namespace Modules\Produk\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Produk\App\Models\Kategori;
use Modules\Produk\App\Models\Prefix;
use Yajra\DataTables\Facades\DataTables;

class PrefixController extends Controller
{
    public function getData()
    {
        $data = Prefix::orderBy('id', 'asc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-info btn-sm editPost">Edit</a>
                <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm btn-delete">Hapus</a>';
            return $actionBtn;
        })
        ->addColumn('operator', function($row){
            $t = '<span>'.$row->operator->name.'</span>';
            return $t;
        })
        ->addColumn('prefix', function($row){
            $t = '<span>'.$row->prefix.'</span>';
            return $t;
        })
        ->rawColumns(['action', 'operator', 'prefix'])
        ->make();

        return $dt;
    }

    public function index()
    {
        $operator = Kategori::where('type', 'PULSA')->get();
        return view('produk::prefix.index', compact('operator'));
    }

    public function create()
    {
        return view('produk::create');
    }

    public function store(Request $request)
    {
        try {
            $prefix = $request->prefix;
            $opId   = $request->operator;
    
            $cek = Prefix::where('prefix', $prefix)->first();
            if(isset($cek)){
                $pr = $cek;
            }else {
                $pr = new Prefix();
            }
    
            $pr->operator_id    = $opId;
            $pr->prefix         = $prefix;
            $pr->save();
    
            return successResponse('Prefix berhasil disimpan', 200);
        } catch (\Throwable $th) {
            
            return errorResponApi($th->getMessage(), 401);
        }
    }

    public function show($id)
    {
        return view('produk::show');
    }

    public function edit($id)
    {
        $data = Prefix::where('id', $id)->with('operator')->first();
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Prefix::find($id);

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
