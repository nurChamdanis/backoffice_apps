<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Notifications\TrxNotif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Selamat Datang Kembali';
        $message = 'Dashboard Bilpay';
        $admin = Admin::where('id', 1)->first();
        if(isset($admin->fcm)){
            $fcmTokens = $admin->fcm;
            Notification::send($admin, new TrxNotif($title, $message, null, $fcmTokens, 'DASHBOARD'));
        }
        return view('pages.user.home');
    }
}
