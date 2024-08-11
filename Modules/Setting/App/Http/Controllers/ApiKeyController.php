<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\ApiKey;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function getData()
    {
        $data = ApiKey::orderBy('id', 'desc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-info btn-sm editPost">Edit</a>
                <a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-danger btn-sm btn-delete">Hapus</a>';
            return $actionBtn;
        })
        ->addColumn('provider', function($row){
            $t = '<span>'.$row->provider.'</span>';
            return $t;
        })
        ->addColumn('api_key', function($row){
            $t = '<span>'.$row->key.'</span>';
            return $t;
        })
        ->addColumn('secret', function($row){
            $t = '<span>'.$row->secret.'</span>';
            return $t;
        })
        ->addColumn('api_url', function($row){
            $t = '<span>'.$row->api_url.'</span>';
            return $t;
        })
        ->addColumn('callback_url', function($row){
            $t = '<span>'.$row->callback_url.'</span>';
            return $t;
        })
        ->rawColumns(['action', 'provider', 'api_key', 'secret', 'api_url', 'callback_url'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('setting::index');
    }


    public function create()
    {
        return view('setting::create');
    }

    public function store(Request $request)
    {
        try {
            $data = new ApiKey();
            $data->provider = Str::upper($request->name);
            $data->key = $request->api_key;
            $data->secret = $request->secret;
            $data->api_url = $request->api_url;
            $data->username = $request->username;
            $data->callback_url = $request->callback;
            $data->ip_address = $request->ip_address;
            $data->save();

            return successResponse('Data berhasil disimpan', 200);
        } catch (\Throwable $th) {
            return errorResponApi($th->getMessage(), 201);
        }
    }

    public function show($id)
    {
        return view('setting::show');
    }

    public function edit($id)
    {
        $post = ApiKey::find($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = ApiKey::where('id', $id)->first();

            $data->provider = Str::upper($request->name);
            $data->key = $request->api_key;
            $data->secret = $request->secret;
            $data->api_url = $request->api_url;
            $data->username = $request->username;
            $data->callback_url = $request->callback;
            $data->ip_address = $request->ip_address;
            $data->save();

            return successResponse('Data berhasil diperbarui', 200);
        } catch (\Throwable $th) {
            return errorResponApi($th->getMessage(), 201);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = ApiKey::find($id);

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
