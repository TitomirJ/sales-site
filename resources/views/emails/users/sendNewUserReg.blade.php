<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minty-Multipurpose Responsive Email Template</title>
    <style type="text/css">
        /* Client-specific Styles */
        #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
        /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
        .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
        img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        .image_fix {display:block;}
        p {margin: 0px 0px !important;}

        table td {border-collapse: collapse;}
        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
        /*a {color: #e95353;text-decoration: none;text-decoration:none!important;}*/
        /*STYLES*/
        table[class=full] { width: 100%; clear: both; }

        /*################################################*/
        /*IPAD STYLES*/
        /*################################################*/
        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }
            table[class=devicewidth] {width: 440px!important;text-align:center!important;}
            table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
            table[class="sthide"]{display: none!important;}
            img[class="bigimage"]{width: 420px!important;height:219px!important;}
            img[class="col2img"]{width: 420px!important;height:258px!important;}
            img[class="image-banner"]{width: 440px!important;height:106px!important;}
            td[class="menu"]{text-align:center !important; padding: 0 0 10px 0 !important;}
            td[class="logo"]{padding:10px 0 5px 0!important;margin: 0 auto !important;}
            img[class="logo"]{padding:0!important;margin: 0 auto !important;}

        }
        /*##############################################*/
        /*IPHONE STYLES*/
        /*##############################################*/
        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }
            .br {
                display: block!important;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }
            table[class=devicewidth] {width: 280px!important;text-align:center!important;}
            table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
            table[class="sthide"]{display: none!important;}
            img[class="bigimage"]{width: 260px!important;height:136px!important;}
            img[class="col2img"]{width: 260px!important;height:160px!important;}
            img[class="image-banner"]{width: 280px!important;height:68px!important;}

        }
    </style>


</head>
<body>

{{--head--}}
<div class="block">
    <!-- image + text -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="bigimage">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#E9E9E9" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                <tbody>
                                <tr>
                                    <!-- start of image -->
                                    <td align="center">
                                        <a target="_blank" href="{{asset('/')}}"><img width="540" border="0" height="282" alt="" style="display:block; border:none; outline:none; text-decoration:none;" src="{{asset('/public/images/top.png')}}" class="bigimage"></a>
                                    </td>
                                </tr>
                                <!-- end of image -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- title -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center;line-height: 20px;" st-title="rightimage-title">
                                        Вы зарегистрировались на BigSales!
                                    </td>
                                </tr>
                                <!-- end of title -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- content -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #000; text-align:center;line-height: 24px;" st-content="rightimage-paragraph">
                                        Данные для входа:<br>
                                        Ваша почта: <span style="color:#000">{{$user->email}}</span><br>
                                        Ваш пароль:	<span style="color:#000">{{$password}}</span>
                                    </td>
                                </tr>
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #000; text-align:right;line-height: 24px;" st-content="rightimage-paragraph">
                                        С уважением,<br>
                                        команда BigSales
                                    </td>
                                </tr>
                                <!-- end of content -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
{{--private cabinet--}}
<div class="block">
    <!-- start textbox-with-title -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fulltext">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#3F4666" width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" modulebg="edit">
                    <tbody>
                    <!-- Spacing -->
                    <tr>
                        <td width="100%" height="30"></td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                        <td>
                            <table width="540" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                <tbody>
                                <!-- Title -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #fff; text-align:center;line-height: 20px;" st-title="fulltext-title">
                                        Не забывайте:
                                    </td>
                                </tr>
                                <!-- End of Title -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- button -->
                                <tr>
                                    <td>
                                        <table height="36" align="left" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" st-button="edit">
                                            <tbody>
                                            <tr>
                                                <td width="auto" align="left" valign="middle" height="36" style=" border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:left;  color:#ffffff; font-weight: 300; padding-left:25px; padding-right:25px;">
                                                    <div style="padding-bottom: 10px;font-size:18px">1. Всегда храните свои данные в безопасности.</div>
                                                    <div style="padding-bottom: 10px;font-size:18px">2. Никогда не передавайте никому свои данные для входа.</div>

                                                    <div style="padding-bottom: 10px;font-size:18px">3. Регулярно меняйте пароль.</div>

                                                    <div style="font-size:18px">4. Если вы подозреваете, что кто-то использует вашу учетную запись незаконно, пожалуйста, немедленно сообщите нам.</div>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- /button -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="30"></td>
                                </tr>
                                <!-- Spacing -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- end of textbox-with-title -->
</div>
{{--our contacts--}}
<div class="block">
    <!-- start textbox-with-title -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fulltext">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#839AC3" width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" modulebg="edit">
                    <tbody>
                    <!-- Spacing -->
                    <tr>
                        <td width="100%" height="30"></td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                        <td>
                            <table width="540" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                <tbody>
                                <!-- Title -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif;font-weight: bold; font-size: 18px; color: #fff; text-align:center;line-height: 20px;" st-title="fulltext-title">
                                        НАШИ КОНТАКТЫ
                                    </td>
                                </tr>
                                <!-- End of Title -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="30"></td>
                                </tr>
                                <!-- Spacing -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- end of textbox-with-title -->
</div>
{{--phones and email--}}
<div class="block">
    <!-- Full + text -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fullimage">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#434A6B" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                <tbody>
                                <!-- title -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #fff; text-align:left;line-height: 20px;" st-title="rightimage-title">
                                        Телефоны: <br class="br" style="display: none;"><a href="tel:067 523 54 86" style="font-weight: 300;color:#fff;text-decoration: none;">067 523 54 86;  <a href="tel:099 777 25 50" style="font-weight: 300;color:#fff;text-decoration: none;">099 777 25 50</a>
                                    </td>
                                </tr>
                                <!-- end of title -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- content -->
                                <tr>
                                    <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #fff; text-align:left;line-height: 20px;" st-title="rightimage-title">
                                        Электронная почта: <a href="mailto:support@peace-it.info" style="font-weight: 300;color:#fff;text-decoration: none;">info@bigsales.pro</a>
                                    </td>
                                </tr>
                                <!-- end of content -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
{{--icons--}}
<div class="block">
    <!-- Full + text -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="fullimage">
        <tbody>
        <tr>
            <td>
                <table bgcolor="#7AA1E3" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit">
                    <tbody>
                    <tr>
                        <td width="100%" height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                <tbody>
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- Spacing -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="10"></td>
                                </tr>
                                <!-- button -->
                                <tr>
                                    <td>
                                        <table height="30" align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" st-button="edit">
                                            <tbody>
                                            <tr>
                                                <td width="auto" align="center" valign="middle" height="30" style="border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;">
                                                   <span style="color: #ffffff; font-weight: 300;">
                                                      <a href="https://www.facebook.com/bigsalespro">
                                                         <img src="{{asset('/public/images/face.png')}}" alt="facebook">
                                                      </a>
                                                   </span>
                                                </td>
                                                <td width="auto" align="center" valign="middle" height="30" style="border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;">
                                                   <span style="color: #ffffff; font-weight: 300;">
                                                      <a href="https://www.instagram.com/_bigsales.pro_/?hl=ru" style="padding: 0 10px">
                                                          <img src="{{asset('/public/images/insta.png')}}" alt="instagram">
                                                      </a>
                                                   </span>
                                                </td>
                                                <td width="auto" align="center" valign="middle" height="30" style="border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;">
                                                   <span style="color: #ffffff; font-weight: 300;">
                                                     <a href="https://www.youtube.com/channel/UCFtNu_9QMoXOhc1g_jApaHw?view_as=subscriber">
                                                         <img src="{{asset('/public/images/youtube.png')}}" alt="youtube">
                                                     </a>
                                                   </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- /button -->
                                <!-- Spacing -->
                                <tr>
                                    <td width="100%" height="20"></td>
                                </tr>
                                <!-- Spacing -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>


</body>
</html>