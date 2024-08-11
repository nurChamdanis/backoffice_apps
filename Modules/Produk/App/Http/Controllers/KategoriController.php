<?php

namespace Modules\Produk\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Produk\App\Models\Kategori;
use Modules\Produk\App\Models\Menu;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function getData()
    {
        $data = Kategori::orderBy('id', 'asc')->get();
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
        ->addColumn('type', function($row){
            $t = '<span>'.$row->type.'</span>';
            return $t;
        })
        ->addColumn('icon', function($row){
            $t = '<img src="'.$row->icon.'" alt="image" style="width: 100px; height:50px;object-fit: contain;">';
            return $t;
        })
        ->rawColumns(['action', 'name', 'code', 'type', 'icon'])
        ->make();

        return $dt;
    }

    public function index()
    {
        $type = Menu::all();
        return view('produk::kategori.index', compact('type'));
    }

    public function create()
    {
        return view('produk::create');
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $code = $request->code;
        $type = $request->type;
        $file = $request->file('icon');
        
        try {
            
            if($request->hasFile('icon')){

                publicUpload('source/' . $file->getFilename() . '.png', $file);
                $filename = $file->getFilename() . '.png';
    
                $data = new Kategori();
                $data->name = $name;
                $data->code = $code;
                $data->type = $type;
                $data->icon = $filename;
                $data->save();
    
                return successResponse('Data berhasil disimpan', 200);
            }else {

                return errorResponApi('upload File GAGAL!!!', 201);
            }

        } catch (\Throwable $th) {
            return errorResponApi($th->getMessage(), 201);
        }
    }

    public function show($id)
    {
        return view('produk::show');
    }

    public function edit($id)
    {
        return view('produk::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Kategori::find($id);

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
