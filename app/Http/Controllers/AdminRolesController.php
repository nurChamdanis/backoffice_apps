<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB; 
use App\Models\Adminroles;

class AdminRolesController extends Controller
{
      public function index()
    {

        $roles = DB::select('SELECT * from roles;');
        //return view('pages.user.home', compact('transaction'));
        //return response()->json($transaction);
 return view('pages.admin_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('pages.admin_roles.create');
    }

public function store(Request $request)
    {
        //
       // dd($request->all());

        Adminroles::create([
            'name'=>$request->name,
           'guard_name'=>$request->guard_name,

        ]);
        return redirect('admin-roles')->with('info', 'Data Berhasil Tersimpan');
    }



    public function edit($id)
    {
    $mber = DB::table('roles')->where('id', $id)->first();
    return view('pages.admin_roles.edit', compact('mber'));
    }

public function update(Request $request, string $id)
{
    // Menghapus _token dari data request
    $data = $request->except('_token');

    // Mendapatkan data yang ingin diupdate
    $mber = DB::table('roles')->where('id', $id)->first();

    // Jika data tidak ditemukan, lempar pengecualian
    if (!$mber) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }

    // Melakukan pembaruan data dengan data yang sudah dihapus _token
    DB::table('roles')->where('id', $id)->update($data);

    // Redirect dengan pesan sukses
    return redirect('admin-roles')->with('info', 'Update Berhasil Tersimpan');
}

public function destroy($id)
{
    // // Mengambil entri dari tabel role_has_permissions
    // $mber = DB::table('role_has_permissions')->where('permission_id', $permission_id)->first();

    // // Jika tidak ada entri yang ditemukan, mungkin Anda ingin menangani kasus ini
    // if (!$mber) {
    //     // Logika jika tidak ada entri ditemukan
    // }

    // // Menghapus entri menggunakan Query Builder
    // DB::table('role_has_permissions')->where('permission_id', $permission_id)->delete();

    // // Redirect kembali dengan pesan sukses
    // return back()->with('info', 'Data Berhasil Dihapus');
}
}
