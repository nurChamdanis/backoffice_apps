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
                                    <td bgcolor="#eef2f6" style="padding:40px 30px 40px 30px">
                                        <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td style="color:#333">Halo,<strong>{{$user->first_name}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#333;font-size:11px">
                                                        Berikut ini adalah informasi
                                                        transaksi yang telah Anda lakukan di Aplikasi {{config('app.name')}}.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table><br>
                                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <img src="https://ci3.googleusercontent.com/meips/ADKq_NbRVZZDy7vOTzjeciOPNaAFr22o1Pp9HnW1INJ79ZxEW0h9j2M-xJbzmCUBhr2C8LNvEJymiTnhQWZNddshPuOc8brfLN7gee4binN_BmklqWFUYh7YCfmSgN0=s0-d-e1-ft#https://s3.brimo.bri.co.id/brimo-asset/email-notif/header_tickets.png"
                                                            style="display:block" width="100%" class="CToWUd"
                                                            data-bit="iit">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table style="background-color: white" border="0" width="100%"
                                            cellspacing="0" cellpadding="10">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3"
                                                        style="padding:0;color:#333;font-size:16px;font-weight:700"
                                                        align="center">Transaksi {{ucwords($data->status)}}</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Tanggal</td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">{{$data->created_at}}</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Nomor Referensi
                                                    </td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">
                                                        <span class="">{{$data->ref_id}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center">
                                                        <hr style="border:1px dashed #d9e7e8!important">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Sumber Dana</td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">
                                                        {{Str::upper($user->first_name)}}
                                                        <br>
                                                        {{$user->phone}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Jenis Transaksi
                                                    </td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">Transfer Saldo Bilpay</td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Nomor Tujuan</td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">
                                                        <span class="">{{$data->account_number}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Nama Tujuan</td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">
                                                        {{$data->account_holder_name}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Alias Penerima
                                                    </td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="190">
                                                        <span class="">-</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Catatan</td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">
                                                        <span class="">
                                                            {{$data->disbursement_description}}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center">
                                                        <hr style="border:1px dashed #d9e7e8!important">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" width="260">Nominal</td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700" align="right" valign="top"
                                                        width="260">
                                                        Rp {{rupiah($data->nominal)}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="padding:0" align="center">
                                                        <img
                                                            src="https://ci3.googleusercontent.com/meips/ADKq_NZulMwz6CPpxvBPZr5T4r_83O44q3U2TbuL28kMIjMrqFh8qt9OhxG62Im75jEiTPPY9H4wAUzpZNQvOdT7TTmiE66wPQlgg3ppcm0aIHjRre2IqA=s0-d-e1-ft#https://s3.brimo.bri.co.id/brimo-asset/email-notif/dotted2.PNG"
                                                            width="100%" style="display:block" class="CToWUd"
                                                            data-bit="iit"
                                                        >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top"
                                                        style="font-weight:700;color:#333;font-size:16px"
                                                        width="260"><strong>Total</strong></td>
                                                    <td style="font-size:0;line-height:0" width="20"> </td>
                                                    <td style="font-weight:700;color:#E71111;font-size:16px"
                                                        align="right" valign="top" width="260">
                                                        <strong>Rp {{rupiah($data->nominal)}}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" width="100%" cellspacing="0" cellpadding="10">
                                            <tbody>
                                                <tr>
                                                    <td style="padding:0" align="center" colspan="3">
                                                        <img
                                                            style="display:block"
                                                            src="https://ci3.googleusercontent.com/meips/ADKq_NZNDvQzh_hIB_-KAmhPXp84VpPBilxyR9lMuubLKDTtXNTcSjDazE9rM50-YbdzTE4C1RT4NYyNhuR6VNivlwFrcFMM4CrsnO1dl0rrSqT3HsqC=s0-d-e1-ft#https://s3.brimo.bri.co.id/brimo-asset/email-notif/footer.png"
                                                            width="100%" height="50px" class="CToWUd"
                                                            data-bit="iit"
                                                        >
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td style="color:#333;font-size:11px;font-family:'Avenir Next'">
                                                        <p align="justify"><br>
                                                            Semoga informasi ini dapat bermanfaat
                                                            bagi Anda. Untuk informasi lebih lanjut, silahkan
                                                            menghubungi kami melalui fasilitas Hubungi Kami di Aplikasi
                                                            {{config('app.name')}}, <br>
                                                            Hormat Kami,
                                                            <br>
                                                            <strong>{{config('app.name')}}</strong>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <br><br>
                                                <tr>
                                                    <td>
                                                        @include('emails.layouts.footer_company')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
