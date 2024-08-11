@extends('layouts.app')

@section('content')

<div class="nk-content">
    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="#" class="logo-link">
                <img class="logo-light logo-img logo-img-lg" src="{{logoRed()}}" srcset="{{logoRed()}} 2x" alt="logo">
                <img class="logo-dark logo-img logo-img-lg" src="{{logoRed()}}" srcset="{{logoRed()}} 2x" alt="logo-dark">
            </a>
        </div>
        <div class="card">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Sign-In</h4>
                    </div>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="email">Email</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Masukan alamat email Anda">
                            @if ($errors->has('email'))
                                <span class="help-block text-danger italic">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Masukan password Anda">
                        </div>
                    </div>
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block text-danger italic">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif

                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block mt-3">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
