<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
	public function index(){
		return view('auth.login');
	}
	
	//logout
	public function logout(){
		// dd('oke');
		return view('auth.logout');
	}
}
