@include('emails.layouts.header')

<body>
    <table role="presentaton" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td style="text-align: center;padding-top: 2px;" colspan="2">
                <img src="{{ $logo }}" width="150px" alt="">
            </td>
        </tr>
        <tr>
            <td class="container">
                <div class="content">
                    <table role="" class="main">
                        <td>
                            <td class="wrapper">
                                <table role="" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="2">
                                            <p style="font-weight: bold">Hallo, {{ $user->first_name }}</p>
                                            <br>
                                            <p>Selamat Anda telah bergabung di {{config('app.name')}} sebagai <b>{{Str::upper($user->getRoleNames()->first())}}</b></p>
                                            <p>Berikut adalah credential untuk masuk ke portal dashboard {{config('app.name')}} :</p>
                                            <td>
                                                <tr>
                                                    <td>
                                                        <span>Email : {{$user->email}}</span>
                                                    </td>
                                                </tr>
                                            </td>
                                            <td>
                                                <tr>
                                                    <td>
                                                        <span>Password : {{$pass}}</span>
                                                    </td>
                                                </tr>
                                            </td><br>
                                            <p>
                                                Jika tidak pernah merasa melakukan pendaftaran Bilpay, segera hubungi customer service kami.
                                            </p>
                                            <br>
                                            <span>Salam,</span><br>
                                            <span style="font-weight: bold">{{ $app }}</span>
                                        </td>
                                    </tr><br><br>
                                    @include('emails.layouts.footer_company')
                                </table>
                            </td>
                        </td>
                    </table>
                    @include('emails.layouts.footer')
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
        crossorigin="anonymous">
    </script>
</body>

</html>
