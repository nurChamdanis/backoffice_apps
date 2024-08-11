@include('emails.layouts.header')

<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table role="presentation" class="main">
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding: 15px 20px; text-align: center;" colspan="2">
                                            <img src="{{ $logo }}" width="150px" alt="">
                                        </td>
                                    </tr>
                                    <br>
                                    <tr>
                                        <td colspan="2">
                                            @yield('mail_content')
                                        </td>
                                    </tr>
                                    @include('emails.layouts.footer_company')
                                </table>
                            </td>
                        </tr>
                    </table>
                    @include('emails.layouts.footer')
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>
