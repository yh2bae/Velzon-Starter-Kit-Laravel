<div class="col-12">
    <table class="body-wrap"
        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                valign="top"></td>
            <td class="container" width="600"
                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                valign="top">
                <div class="content"
                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope
                        itemtype="http://schema.org/ConfirmAction"
                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                        <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                            <td class="content-wrap"
                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;"
                                valign="top">
                                <meta itemprop="name" content="Confirm Email"
                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <tr
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                            valign="top">
                                            <div style="text-align: center;margin-bottom: 15px;">
                                                {{-- <img src="assets/images/logo-dark.png" alt=""
                                                        height="23"> --}}
                                                <h3 style="font-family: 'Roboto', sans-serif; font-weight: 800;">
                                                    VELZON STARTER
                                                </h3>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;"
                                            valign="top">
                                            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 500;">
                                                Silahkan Verifikasi Email Anda
                                            </h4>
                                        </td>
                                    </tr>
                                    <tr
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block"
                                            style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 26px; text-align: center;"
                                            valign="top">
                                            Hallo, {{ $name }}
                                            <p style="margin-bottom: 13px;">
                                                Silahkan klik tombol dibawah ini untuk memverifikasi alamat email
                                                Anda.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" itemprop="handler" itemscope
                                            itemtype="http://schema.org/HttpActionHandler"
                                            style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 22px; text-align: center;"
                                            valign="top">
                                            <a href="{{ $verificationUrl }}" itemprop="url"
                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem; color: #FFF; text-decoration: none; font-weight: 400; text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #4b38b3; margin: 0; border-color: #4b38b3; border-style: solid; border-width: 1px; padding: .5rem .9rem;box-shadow: 0 3px 3px rgba(56,65,74,0.1);">
                                                Verifikasi Email
                                            </a>
                                        </td>
                                    </tr>
                                    <tr
                                        style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block"
                                            style="color: #878a99; text-align: center;font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 5px"
                                            valign="top">
                                            <p style="margin-bottom: 10px;">
                                                Atau klik link dibawah ini:
                                            </p>
                                            <a href="{{ $verificationUrl }}" target="_blank">
                                                {{ url('/verifikasi') }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <!-- end table -->
</div>
