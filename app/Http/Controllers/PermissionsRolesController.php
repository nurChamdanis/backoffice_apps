<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB; 
use App\Models\AdminPermission;

class PermissionsRolesController extends Controller
{
      public function index()
    {

        $roles = DB::select('SELECT r.permission_id as pid, r.role_id, p.name as pname, y.name as yname
                                 FROM role_has_permissions as r
                                 INNER JOIN permissions AS p ON r.permission_id = p.id
                                 INNER JOIN roles AS y ON r.role_id = y.id
                                 ORDER BY r.role_id ASC;');
        //return view('pages.user.home', compact('transaction'));
        //return response()->json($transaction);
 return view('pages.permissions_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('pages.permissions_roles.create');
    }

public function store(Request $request)
    {
        //
       // dd($request->all());

        AdminPermission::create([
            'permission_id'=>$request->permission_id,
           'role_id'=>$request->role_id,

        ]);
        return redirect('permissions-roles')->with('info', 'Data Berhasil Tersimpan');
    }

    public function edit($permission_id)
    {
    $mber = DB::table('role_has_permissions')->where('permission_id', $permission_id)->first();
    return view('pages.permissions_roles.edit', compact('mber'));
    }

public function update(Request $request, string $permission_id)
{
    // Menghapus _token dari data request
    $data = $request->except('_token');

    // Mendapatkan data yang ingin diupdate
    $mber = DB::table('role_has_permissions')->where('permission_id', $permission_id)->first();

    // Jika data tidak ditemukan, lempar pengecualian
    if (!$mber) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }

    // Melakukan pembaruan data dengan data yang sudah dihapus _token
    DB::table('role_has_permissions')->where('permission_id', $permission_id)->update($data);

    // Redirect dengan pesan sukses
    return redirect('permissions-roles')->with('info', 'Update Berhasil Tersimpan');
}

public function destroy($permission_id)
{
    // Mengambil entri dari tabel role_has_permissions
    $mber = DB::table('role_has_permissions')->where('permission_id', $permission_id)->first();

    // Jika tidak ada entri yang ditemukan, mungkin Anda ingin menangani kasus ini
    if (!$mber) {
        // Logika jika tidak ada entri ditemukan
    }

    // Menghapus entri menggunakan Query Builder
    DB::table('role_has_permissions')->where('permission_id', $permission_id)->delete();

    // Redirect kembali dengan pesan sukses
    return back()->with('info', 'Data Berhasil Dihapus');
}
}
