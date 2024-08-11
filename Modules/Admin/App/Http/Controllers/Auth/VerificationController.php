<?php

namespace Modules\Admin\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    protected $redirectTo = '//com.lst.bilpay';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        $us = User::where('id',$request->route('id'))->first();
        if(!isset($us)){
            throw new AuthorizationException;
        }else {

            $strSign = $us->id.$us->email;
            $sign = hash_hmac('sha256', $strSign, $us->id);
            if (! hash_equals((string) $request->route('sign'), $sign)) {
                throw new AuthorizationException;
            }

            $us->email_verified_at = Carbon::now();
            $us->activated = true;
            $us->status = 'ACTIVE';
            $us->save();
            return redirect()->route('verify.success');
        }

    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? new JsonResponse([], 202)
            : back()->with('resent', true);
    }
    
    public function verifySuccess()
    {
        return view('admin::other.success_verify');
    }
}
