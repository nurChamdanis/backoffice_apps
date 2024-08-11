<?php

namespace Modules\Produk\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Produk\App\Models\Menu;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function getData()
    {
        $data = Menu::orderBy('position', 'asc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-danger btn-sm btn-delete">Hapus</a> 
            <a href="'.route('menu.edit', [$row->id]).'" class="edit btn btn-warning btn-sm btn-edit">Edit</a>';
            return $actionBtn;
        })
        ->addColumn('name', function($row){
            $t = '<span>'.$row->name.'</span>';
            return $t;
        })
        ->addColumn('screen_name', function($row){
            $t = '<span>'.$row->screen_name.'</span>';
            return $t;
        })
        ->addColumn('type', function($row){
            $t = '<span>'.$row->type.'</span>';
            return $t;
        })
        ->addColumn('status', function($row){
            $y = '<span class="text-success">ACTIVE</span>';
            $t = '<span class="text-danger">INACTIVE</span>';
            return $row->active == 0 ? $t : $y;
        })
        ->addColumn('ready', function($row){
            $y = '<span class="text-success">YA</span>';
            $t = '<span class="text-danger">TDK</span>';
            return $row->ready == 0 ? $t : $y;
        })
        ->addColumn('position', function($row){
            $t = '<span>'.$row->position.'</span>';
            return $t;
        })
        ->addColumn('icon', function($row){
            $t = '<img src="'.$row->icon.'" alt="image" style="width: 100px; height:50px;object-fit: contain;">';
            return $t;
        })
        ->rawColumns(['action', 'name', 'screen_name', 'type', 'status', 'ready', 'position', 'icon'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('produk::menu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $scrName = $request->screen_name;
        $type = $request->type;
        $active = $request->status;
        $ready = $request->ready == 'on' ? 1 : 0;
        $position = $request->position;
        $file = $request->file('icon');
        
        try {
            
            if($request->hasFile('icon')){

                publicUpload('source/' . $file->getFilename() . '.png', $file);
                $filename = $file->getFilename() . '.png';
    
                $data = new Menu();
                $data->name = $name;
                $data->screen_name = $scrName;
                $data->type = $type;
                $data->active = $active;
                $data->ready = $ready;
                $data->position = $position;
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

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('produk::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Menu::find($id);
        return view('produk::menu.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $name = $request->name;
        $scrName = $request->screen_name;
        $type = $request->type;
        $active = $request->status;
        $ready = $request->ready == 'on' ? 1 : 0;
        $position = $request->position;
        $file = $request->file('icon');
        
        $data = Menu::find($id);
        try {
            
            if($request->hasFile('icon')){

                publicUpload('source/' . $file->getFilename() . '.png', $file);
                $filename = $file->getFilename() . '.png';
                $data->icon = $filename;
    
            }

            $data->name = $name;
            $data->screen_name = $scrName;
            $data->type = $type;
            $data->active = $active;
            $data->ready = $ready;
            $data->position = $position;

            $data->save();
            return redirect()->back()->with('sukses', 'Data berhasil disimpan');

        } catch (\Throwable $th) {
            return  redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Menu::find($id);

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
