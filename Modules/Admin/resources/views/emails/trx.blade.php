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
                                            <p style="color:#222222;font-size:12px">Berikut adalah informasi transaksi yang telah Anda lakukan di Aplikasi
                                                {{ config('app.name') }}</p>

                                            <div class="center p-0 align mb-3">
                                                <div class="col-lg-6 p-0">
                                                    <span style="color:#222222;font-size:13px">
                                                        <b>{{ $data->created_at }}</b>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="center p-0 align mb-3">
                                                <div class="col-lg-12">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3"
                                                                style="padding:0 0 0 90;color:#333;font-size:12px;font-weight:700"
                                                                align="center">Total Transaksi<br><br><strong
                                                                    style="font-weight:700;color:#E71111;font-size:20px">Rp
                                                                    {{ rupiah($data->harga) }}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" valign="top" width="260">No. Ref</td>
                                                            <td style="font-size:0;line-height:0" width="20"> </td>
                                                            <td style="font-weight:700" align="right" valign="top"
                                                                width="260">
                                                                <span class="">{{ $data->ref_id }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <table class="" border="0" style="border-radius: 20px" width="100%" cellspacing="0" cellpadding="3">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="left" valign="top" colspan="2"
                                                                                style="vertical-align:middle">
                                                                                <p style="margin-top:5px">
                                                                                    <b>Sumber Dana</b>
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" align="left"
                                                                                valign="center" width="460">
                                                                                <strong>{{ Str::upper($user->first_name) }}</strong>
                                                                                <br>{{ $user->phone }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" align="center">
                                                                                <hr style="border:1px solid #b97979!important">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="right" valign="top" colspan="2"
                                                                                style="vertical-align:middle">
                                                                                <p>
                                                                                    <b>Tujuan</b>
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" align="right"
                                                                                valign="center" width="460">
                                                                                <strong>{{ $data->tujuan }}</strong><br>
                                                                                {{ $produk->name }}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" valign="top" width="260">Jenis Transaksi
                                                            </td>
                                                            <td style="font-size:0;line-height:0" width="20"> </td>
                                                            <td style="font-weight:700" align="right" valign="top"
                                                                width="260">Pembelian/Pembayaran {{ $produk->name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" valign="top" width="260">Keterangan</td>
                                                            <td style="font-size:0;line-height:0" width="20"> </td>
                                                            <td style="font-weight:700" align="right" valign="top"
                                                                width="260">{{ $data->sn }} -
                                                                @if ($data->status == 'SUKSES' || $data->status == 'SUCCESS')
                                                                <span style="color:#00d87e;">
                                                                    {{ ucwords($data->status) }}
                                                                </span>
                                                                @else
                                                                <span style="color:#b90202;">
                                                                    {{ ucwords($data->status) }}
                                                                </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" valign="top" width="260">Catatan</td>
                                                            <td style="font-size:0;line-height:0" width="20"> </td>
                                                            <td style="font-weight:700" align="right" valign="top"
                                                                width="260"><span class="">-</span>
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
                                                                width="260">Rp {{ rupiah($data->harga) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" valign="top" width="260">
                                                                Biaya Admin
                                                            </td>
                                                            <td style="font-size:0;line-height:0" width="20"> </td>
                                                            <td style="font-weight:700" align="right" valign="top"
                                                                width="260">
                                                                Rp 0
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="center">
                                                                <hr style="border:1px dashed #d9e7e8!important">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="padding:0" align="center"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="left" valign="top"
                                                                style="color:#777;font-size:11px" width="260">
                                                                <strong>INFORMASI:</strong><br><br>Biaya Termasuk PPN
                                                                (Apabila Dikenakan/Apabila Ada)
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="padding:0" align="center"> </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="center">
                                                                <hr style="border:1px #ff9d9d!important">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </div>
                                            </div>
                                            <tr style="margin-top: 15px">
                                                <td>
                                                    <p style="color:#222222;font-size:12px">
                                                        Semoga informasi ini dapat bermanfaat bagi Anda. Untuk
                                                        informasi lebih
                                                        lanjut, silahkan menghubungi kami melalui fasilitas
                                                        Hubungi Kami di Aplikasi
                                                        {{ config('app.name') }}
                                                    </p>
                                                    <br>
                                                    <span style="color:#222222;font-size:12px">Salam, Dengan
                                                        senang hati kami akan melayani Anda</span>
                                                    <span style="color:#222222;font-size:12px">Terimaksih</span><br><br>
                                                    <span style="color:#222222;font-size:12px">Hormat Kami,
                                                    </span><br>
                                                    <span style="font-weight: bold; margin-bottom:10px">{{ $app }}
                                                    </span>
                                                </td>
                                            </tr>

                                        </td>
                                    </tr>
                                    <br><br>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
