<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('template_title')@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
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
        @include('sweetalert::alert')
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
    <body class="nk-body ui-rounder has-sidebar ">
        <div class="nk-app-root">
            <div class="nk-main ">

                @auth
                @include('partials.sidebar')
                @endauth
                
                <div class="nk-wrap ">
                    @auth
                    @include('partials.nav')
                    @endauth
                    <div class="nk-content nk-content-fluid">
                        <div class="container-xxl wide-xxl" style="width: 100%">
                            @include('components.alert')
                            <div class="nk-content-body>
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <audio id="chatAudio">
                <source src="{{ asset('sound.mp3') }}" type="audio/mpeg">
            </audio>

        </div>
        @if(config('settings.googleMapsAPIStatus'))
            {!! HTML::script('//maps.googleapis.com/maps/api/js?key='.config("settings.googleMapsAPIKey").'&libraries=places&dummy=.js', array('type' => 'text/javascript')) !!}
        @endif
        <script src="{{asset('js/bundle.js?ver=3.2.3')}}"></script>
        <script src="{{asset('js/scripts.js?ver=3.2.3')}}"></script>
        <script src="{{asset('js/toastr.js')}}"></script>
        <script src="{{asset('js/editors.js?ver=3.2.3')}}"></script>

        <link rel="stylesheet" href="{{ asset('css/editors/summernote.css?ver=3.2.3')}}">
        <script src="{{asset('js/libs/editors/summernote.js?ver=3.2.3')}}"></script>
        <script src="{{asset('js/charts/gd-campaign.js?ver=3.2.3')}}"></script>
        @yield('footer_scripts')
        @yield('js')

        <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script>
            // Your web app's Firebase configuration
            var firebaseConfig = {
                apiKey: "AIzaSyCOhkfag0YwhgfJewZfQ_YEb0qzeFt0URU",
                authDomain: "bilpay-f48f1.firebaseapp.com",
                projectId: "bilpay-f48f1",
                storageBucket: "bilpay-f48f1.appspot.com",
                messagingSenderId: "912465607868",
                appId: "1:912465607868:web:9c402a7719639d00e864b9",
                measurementId: "G-V9FGB30FYY"
            };
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);

            const messaging = firebase.messaging();

            function initFirebaseMessagingRegistration() {
                messaging.requestPermission().then(function() {
                    return messaging.getToken()
                }).then(function(token) {

                    axios.post("{{ route('fcmToken') }}", {
                        _method: "PATCH",
                        token
                    }).then(({
                        data
                    }) => {
                        console.log('FCM UPDATE')
                    }).catch(({
                        response: {
                            data
                        }
                    }) => {
                        console.error(data)
                    })

                }).catch(function(err) {
                    console.log(`Token Error ::`);
                });
            }

            initFirebaseMessagingRegistration();

            Audio.prototype.play = (function(play) {
                return function() {
                    var audio = this,
                        args = arguments,
                        promise = play.apply(audio, args);
                    if (promise !== undefined) {
                        promise.catch(_ => {
                            var el = document.createElement("button");
                            el.innerHTML = "Play";
                            el.addEventListener("click", function() {
                                play.apply(audio, args);
                            });
                            this.parentNode.insertBefore(el, this.nextSibling)
                        });
                    }
                };
            })(Audio.prototype.play);

            messaging.onMessage(function(payload) {
                
                const title = payload.data.title;
                const options = {
                    body: payload.data.body,
                    icon: payload.data.icon,
                };

                NioApp.Toast(title, 'info', {
                    position: 'top-center'
                });
                
                tableTrx.draw();
                new Notification(title, options);
                var audio = document.getElementById('chatAudio');
                audio.play()

            });

            function play() {
                var audio = document.getElementById('chatAudio');
                audio.play()
            }
        </script>

    </body>
</html>
