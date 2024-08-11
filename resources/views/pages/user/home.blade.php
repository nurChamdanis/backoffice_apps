@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' User Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1" style="width: auto !important;margin-left: 0 !important;">

                @include('panels.welcome-panel')

            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
@endsection
