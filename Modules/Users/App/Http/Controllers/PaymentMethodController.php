<?php

namespace Modules\Users\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Users\App\Models\PaymentMethod;
use Yajra\DataTables\Facades\DataTables;

class PaymentMethodController extends Controller
{
    public function getData()
    {
        $data = PaymentMethod::orderBy('id', 'desc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-danger btn-sm btn-delete">Hapus</a>';
            return $actionBtn;
        })
        ->addColumn('code', function($row){
            $t = '<span>'.$row->code.'</span>';
            return $t;
        })
        ->addColumn('swift_code', function($row){
            $t = '<span>'.$row->swift_code.'</span>';
            return $t;
        })
        ->addColumn('description', function($row){
            $t = '<span>'.$row->description.'</span>';
            return $t;
        })
        ->addColumn('type', function($row){
            $t = '<span>'.$row->type.'</span>';
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->status == 1){
                $t = '<span class="text-success">ACTIVE</span>';
            }else {
                $t = '<span class="text-danger">INACTIVE</span>';
            }
            return $t;
        })
        ->addColumn('icon', function($row){
            $t = '<img src="'.$row->icon.'" alt="image" style="width: 100px; height:50px;object-fit: contain;">';
            return $t;
        })
        ->rawColumns(['action', 'code', 'swift_code', 'type', 'description', 'status', 'icon'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('users::payment.index');
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
        $code = $request->code;
        $swift_code = $request->swift_code;
        $description = $request->description;
        $type = $request->type;
        $status = $request->status == 'on' ? 1 : 0;
        $file = $request->file('icon');

        try {
            if($request->hasFile('icon')){

                publicUpload('source/' . $file->getFilename() . '.png', $file);
                $filename = $file->getFilename() . '.png';
    
                $data = new PaymentMethod();
                $data->code         = $code;
                $data->swift_code   = $swift_code;
                $data->description  = $description;
                $data->type         = $type;
                $data->status       = $status;
                $data->icon         = $filename;
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
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = PaymentMethod::find($id);

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
