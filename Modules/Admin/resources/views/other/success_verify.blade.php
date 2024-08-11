@extends('layouts.fe_no_sidebar')

@section('style')
<link rel="stylesheet" href="{{asset('css/fe.css')}}">
@endsection

@section('content')
<section class="nk-section nk-section-cta ">
    <div class="container">
        <div class="nk-cta-card card-mask card-mask-two bg-primary-soft p-5 px-md-5 py-md-7 p-lg-7 rounded-3">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center pb-5 pb-lg-7">
                        <h2 class="display-12 mb-4 text-white">Verifikasi Berhasil</h2>
                        <h4 class="display-6 mb-1 text-white">Sudah siap untuk transaksi ?</h4>
                        <p class="text-white opacity-75">Segera kembali ke aplikasi dan lanjutkan transaksi bersama {{config('app.name')}}</p>
                    </div>
                </div>
                <div class="col-lg-12 col-xxl-6">
                    <div class="align-center center">
                        <a href="#" class="btn btn-md btn-white">
                            <span>Kembali Ke Aplikasi</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection