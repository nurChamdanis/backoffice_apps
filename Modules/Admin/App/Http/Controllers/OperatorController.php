<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\NewOperator;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class OperatorController extends Controller
{
    public function getData()
    {
        $data = Admin::orderBy('id', 'desc')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){

            $actBtn = '<ul class="nk-tb-actions p-0">
<li class="">
    <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-sm reset-password" data-toggle="tooltip" data-placement="top" title="Reset Password">
        <em class="icon ni ni-cc-secure-fill"></em>
    </a>
</li>
            
                <li class="">
                    <a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-danger btn-sm btn-delete">Hapus</a>
                </li>
            </ul>';
            return $actBtn;
        })

        ->addColumn('name', function($row){
            $t = '<span>'.$row->name.'</span>';
            return $t;
        })
        ->addColumn('phone', function($row){
            $t = '<span>'.$row->phone.'</span>';
            return $t;
        })
        ->addColumn('email', function($row){
            $t = '<span>'.$row->email.'</span>';
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->activated == true){
                $t = '<span class="text-success">ACTIVE</span>';
            }else {
                $t = '<span class="text-danger">INACTIVE</span>';
            }
            return $t;
        })
        ->addColumn('join', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->addColumn('last_login', function($row){
            $t = '<span>'.$row->updated_at.'</span>';
            return $t;
        })
        ->addColumn('role', function($row){
            $t = '<span>'.$row->getRoleNames()->first().'</span>';
            return $t;
        })
        ->rawColumns(['action','name', 'phone', 'email', 'status', 'join', 'last_login', 'role'])
        ->make();

        return $dt;
    }

    public function index()
    {
        $role = Role::all();
        return view('admin::operator.index', compact('role'));
    }

    public function create()
    {
        return view('admin::create');
    }

    public function store(Request $request)
    {
        $phone = $request->phone;
        $password = 'Bilpay2024@';

        $ad = new Admin();
        $ad->name = $request->name;
        $ad->phone = $request->email;
        $ad->email = $request->email;
        $ad->activated = $request->activated;;
        $ad->password = Hash::make($password);
        $ad->save();

        $ad->assignRole($request->roleName);

        Mail::to($ad->email)->send(new NewOperator($ad, $password));
        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin::show');
    }

        public function edit(string $id)
    {
        //
        $mber=admin::findorfail($id);
        return view('admin::operator.edit-operator', compact('mber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     $mber = Admin::findOrFail($id);
    
    // Update the fields based on the request data
    $mber->update($request->except('password'));
    
    // Check if a new password is provided in the request
    if ($request->has('password')) {
        // Hash and update the password
        $mber->password = Hash::make($request->password);
        $mber->save();
    }

        return redirect('v2/main-dashboard/admins')->with('info', 'Update Berhasil Tersimpan');
    }

public function resetPassword(Request $request)
    {
        $userId = $request->post('id');

        // Retrieve the user by ID
        $admin = Admin::find($userId);

        // Check if admin exists
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Operator not found'
            ]);
        }

        // Generate a new random password
        $newPassword = 'Bilpay2024@'; // You can adjust the password length as needed

        // Update admin's password
        $admin->password = Hash::make($newPassword);
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully',
            'new_password' => $newPassword // You can return the new password to display it to the user
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        $k = Admin::find($id);

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
