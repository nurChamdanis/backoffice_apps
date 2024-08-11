<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB; 

class DropdownController extends Controller
{
public function permission()
{
    $permissions = DB::select('SELECT * FROM permissions;');
    return response()->json($permissions);
}

        public function roles()
    {
        $roles = DB::select('SELECT *
                                FROM roles;');
        return response()->json($roles);
    }
}

