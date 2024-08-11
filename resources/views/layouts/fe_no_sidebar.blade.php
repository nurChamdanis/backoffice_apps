<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>
        <meta name="description" content="">
        <meta name="author" content="Digitcode Studio">
        <link rel="shortcut icon" href="{{favicon()}}">
        <link rel="preconnect" href="https://fonts.bunny.net">

        <link rel="stylesheet" href="{{asset('css/dashlite.css?ver=3.2.3')}}">
        <link id="skin-default" rel="stylesheet" href="{{asset('css/theme.css?ver=3.2.3')}}">

        @yield('template_linked_fonts')
        @yield('style')
        @vite([])
        @yield('template_linked_css')
        <style type="text/css">
            @yield('template_fastload_css')
            @if (Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0))
                .user-avatar-nav {
                    background: url({{ Gravatar::get(Auth::user()->email) }}) 50% 50% no-repeat;
                    background-size: auto 100%;
                }
            @endif
        </style>        
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
        @if (Auth::User() && (Auth::User()->profile) && $theme->link != null && $theme->link != 'null')
            <link rel="stylesheet" type="text/css" href="{{ $theme->link }}">
        @endif
        @yield('head')
        @include('scripts.ga-analytics')
    </head>
    <body class="nk-body ui-rounder">
        <div class="nk-app-root">
            <div class="nk-main ">
                <div class="nk-wrap ">
                    <div class="nk-content nk-content-fluid">
                        <div class="container-xl wide-xxl">
                            <div class="nk-content-body>
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('js/bundle.js?ver=3.2.3')}}"></script>
        <script src="{{asset('js/scripts.js?ver=3.2.3')}}"></script>
        <script src="{{asset('js/toastr.js')}}"></script>
        <script src="{{asset('js/charts/gd-campaign.js?ver=3.2.3')}}"></script>
    </body>
</html>
