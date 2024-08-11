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
                                            <p style="font-weight: bold">Hallo, {{ $user['first_name'] }}</p>
                                            <br>
                                            <p>Segera verifikasi akun {{config('app.name')}} dibawah ini</p>

                                            <div class="center p-0 align mb-3">
                                                <div class="col-lg-6 p-0">
                                                    <a href="{{$url}}" class="btn btn-danger bg-danger btn-sm active" role="button" aria-pressed="true">
                                                        <span class="text-white">
                                                            VERIFIKASI
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>

                                            <p>
                                                Jika tidak pernah merasa melakukan pendaftaran Bilpay, segera hubungi customer service kami.
                                            </p>
                                            <br>
                                            <span>Salam,</span><br>
                                            <span style="font-weight: bold">{{ $app }}</span>
                                        </td>
                                    </tr>
                                    @include('emails.layouts.footer_company')
                                </table>
                            </td>
                        </td>
                    </table><br><br>
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
