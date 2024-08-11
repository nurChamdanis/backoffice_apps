<?php

namespace Modules\Users\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Users\App\Models\Banner;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    public function getData()
    {
        $data = Banner::orderBy('id', 'desc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-danger btn-sm btn-delete">Hapus</a>';
            return $actionBtn;
        })
        ->addColumn('title', function($row){
            $t = '<span>'.$row->title.'</span>';
            return $t;
        })
        ->addColumn('subtitle', function($row){
            $t = '<span>'.$row->subtitle.'</span>';
            return $t;
        })
        ->addColumn('type', function($row){
            $t = '<span>'.$row->type.'</span>';
            return $t;
        })
        ->addColumn('link', function($row){
            $t = '<span>'.$row->link.'</span>';
            return $t;
        })
        ->addColumn('image', function($row){
            $t = '<img src="'.$row->image.'" alt="image" style="width: 100px; height:50px;object-fit: contain;">';
            return $t;
        })
        ->rawColumns(['action', 'title', 'subtitle', 'type', 'link', 'image'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('users::banner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = $request->title;
        $subtitle = $request->subtitle;
        $type = $request->type;
        $link = $request->link;
        $file = $request->file('image');

        try {
            if($request->hasFile('image')){

                publicUpload('source/' . $file->getFilename() . '.png', $file);
                $filename = $file->getFilename() . '.png';
    
                $data = new Banner();
                $data->title    = $title;
                $data->subtitle = $subtitle;
                $data->type     = $type;
                $data->link     = $link;
                $data->image    = $filename;
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
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Banner::where('id', $id)->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Banner::find($id);

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
