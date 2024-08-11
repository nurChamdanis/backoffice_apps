<?php

namespace Modules\Admin\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        if(config('app.env') == 'local'){

            $request->validate([
                $this->username() => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'Email tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
            ]);

        }else {

            $request->validate([
                $this->username() => ['required', 'email'],
                'password' => ['required'],
                'g-recaptcha-response' => ['required', 'captcha']
            ], [
                'email.required' => 'Email tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
                'g-recaptcha-response.required' => 'Silahkan verifikasi bahwa Anda bukan robot.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
            ]);
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Data anda tidak kami temukan'],
            'password' => ['Password anda salah'],
            'g-recaptcha-response' => ['Silahkan Ceklis Captcha']
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function loginView()
    {
        return view('auth.login');
    }
}
