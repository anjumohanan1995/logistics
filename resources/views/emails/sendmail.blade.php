<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Passport Expiry Reminder</title>
    <style>
        table {
            margin: auto;
            margin-top: auto;
            margin-bottom: auto;
            border: 2px solid #b78c4d;
            border-radius: 4px;
            margin-top: 10px;
            margin-bottom: 10px;
            font-family: Helvetica, Arial, sans-serif;

        }

        table td {
            padding: 35px;
            text-align: left;
            font-size: 15px;
            line-height: 20px;
            color: #555555;
        }
    </style>
    </style>
</head>

<body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;">

    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff">
        <tbody>
            <tr>
                <td align="center" style="padding:0">
                    <table role="presentation"
                        style="width:602px;border-collapse:collapse;border:1px solid #b78c4d;border-radius: 4px;border-spacing:0;text-align:left">
                        <tbody>

                            <tr>
                                <td style="padding:36px 30px 42px 30px">
                                    <table role="presentation"
                                        style="width:100%;border-collapse:collapse;border:0;border-spacing:0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>Dear {{ $name }},</p>
                                                    <p>Your passport is expiring on {{ $expiryDate }}.</p>
                                                    <p>Please renew it before then.</p>
                                                    <p>If you have any questions or need assistance, feel free to
                                                        contact our support team.</p>
                                                    <p>Best regards,</p>
                                                    <p>Your Logistics Team</p>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:30px;background:#b78c4d">
                                    <table role="presentation"
                                        style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif">
                                        <tbody>
                                            <tr>
                                                <td style="/*! padding:0; *//*! width:50% */" align="left">
                                                    <p
                                                        style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff">
                                                        ®© Copyrights 2023 Logistics Developed by Kawika Technologies.
                                                        All
                                                        rights
                                                        reserved.<br>
                                                    </p>
                                                </td>
                                                <td style="/*! padding:0; *//*! width:50% */" align="right">
                                                    <table role="presentation"
                                                        style="border-collapse:collapse;border:0;border-spacing:0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding:0 0 0 10px;width:38px">
                                                                    <a href="http://www.twitter.com/"
                                                                        style="color:#ffffff" target="_blank"
                                                                        data-saferedirecturl="https://www.google.com/url?q=http://www.twitter.com/&amp;source=gmail&amp;ust=1715156398240000&amp;usg=AOvVaw23CyPQM2jjQRKHc_ihV2zG"><img
                                                                            src="https://ci3.googleusercontent.com/meips/ADKq_NbhpNuT5jt7WzgrXs5qb4bJdnyQT82yrwLzcjEwXCtHDMar7dM22L17GGcEvbJ9tNOMGeGLFRHr7-iICT2JKw=s0-d-e1-ft#https://assets.codepen.io/210284/tw_1.png"
                                                                            alt="Twitter" width="38"
                                                                            style="height:auto;display:block;border:0"
                                                                            class="CToWUd" data-bit="iit"></a>
                                                                </td>
                                                                <td style="padding:0 0 0 10px;width:38px">
                                                                    <a href="http://www.facebook.com/"
                                                                        style="color:#ffffff" target="_blank"
                                                                        data-saferedirecturl="https://www.google.com/url?q=http://www.facebook.com/&amp;source=gmail&amp;ust=1715156398240000&amp;usg=AOvVaw2D5fkyma0iqq3U1zgK0oxA"><img
                                                                            src="https://ci3.googleusercontent.com/meips/ADKq_NYE6ehvLSaI3LhYle3bpa95n4cYbycsXcaPrTjNxX5lPAFaX5NBa84IiG3sv_JNSpwhkOr9oqa7mSufIjxn4Q=s0-d-e1-ft#https://assets.codepen.io/210284/fb_1.png"
                                                                            alt="Facebook" width="38"
                                                                            style="height:auto;display:block;border:0"
                                                                            class="CToWUd" data-bit="iit"></a>
                                                                </td>
                                                            </tr>
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
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
