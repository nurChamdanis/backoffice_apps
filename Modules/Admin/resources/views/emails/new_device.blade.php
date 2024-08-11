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
                                            <p style="font-weight:700;color:#333;font-size:12px" width="260">
                                                Perangkat baru <b>{{$user->unique_id}} {{$user->device_name}}</b> terdeteksi berhasil masuk aplikasi {{config('app.name')}}
                                                pada tanggal {{\Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i')}} <br><br>
                                            </p>
                                            <p style="font-weight:700;color:#333;font-size:12px;margin-top: 10px" width="260">
                                                Jika tidak pernah merasa melakukan aktifitas ini, segera hubungi customer service kami.
                                            </p>
                                            <br>
                                            <span>Hormat Kami,</span><br>
                                            <span style="font-weight: bold">{{ $app }}</span>
                                        </td>
                                    </tr><br><br>
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
