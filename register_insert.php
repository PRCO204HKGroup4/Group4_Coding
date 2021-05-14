<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/PHPMailer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/SMTP.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/Exception.php');

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = "mh";
    $surname = $_POST["surname"];
    $given_name = $_POST["given_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rtpassword = $_POST["retypepassword"];
    $dob = date('Y-m-d',strtotime($_POST["dob"]));
    $mobile = $_POST["mobile"];
    $accountid = date("YmdHis");
    $sex = $_POST["sex"];
}

//$sql = new mysqli("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
//$dbemail = mysqli_query($sql, "SELECT TYPE, EMAIL FROM ACCOUNT WHERE TYPE='mh' and EMAIL='".$_POST["email"]."'");

$type = "mh";

$stmt1 = $mysqli->prepare("select TYPE, EMAIL from ACCOUNT where TYPE =? and EMAIL =?");
$stmt1->bind_param("ss", $type, $email);
$stmt1->execute();
$stmt1->store_result();
$row_count = $stmt1->num_rows;
$stmt1->close();

//$row = mysqli_num_rows($dbemail);
$age = date_diff(date_create($dob), date_create('today'))->y;
$existingdate = Date("Y-m-d");

function MobileNumChecking($mobile)
{
    return preg_match('/^[4-9]\d{7}$/', $mobile);

    if(MobileNumChecking($mobile) == true){
        return true;
    }
    else {
        return false;
    }
}

if (($mysqli) && ($password != $rtpassword)) {
    echo 'WP';
    //echo 'The Retype password is not the same with the password.';
}
else if (($mysqli) && ($row_count > 0)) {
    echo 'WE';
    //echo 'The email is used, please use the another email address to register."); </script>';
}
else if (($mysqli) && (MobileNumChecking($mobile) == false)) {
    echo 'WM';
    //echo '<script> alert("The Mobile number is wrong, you must start from 4-9."); </script>';
}
else if (($mysqli) && ($dob > $existingdate)) {
    echo 'WA';
    //echo '<script> alert("You have not enough 18 years old.");</script>';
}
else {
    $encrypt_password = hash('SHA256', $password);
    $encrypt_accountid = "mh".hash('SHA256', $accountid);

    echo 'WS';
    
    $status = 0;

    $stmt2 = $mysqli->prepare("insert into ACCOUNT (TYPE, SURNAME, GIVEN_NAME, EMAIL, PASSWORD, DOB, MOBILE, ACCOUNT_ID, SEX, STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssssssissi", $type, $surname, $given_name, $email, $encrypt_password, $dob, $mobile, $encrypt_accountid, $sex, $status);
    $stmt2->execute();
    
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    
    $body = '
        <!DOCTYPE html>
        <html style="width: 100%;font-family: helvetica, arial, sans-serif;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
        <body style="width: 100%;font-family: helvetica, arial, sans-serif;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
        
        <head>
            <meta charset="UTF-8">
            <meta content="width=device-width, initial-scale=1" name="viewport">
            <meta name="x-apple-disable-message-reformatting">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="telephone=no" name="format-detection">
            <title></title>
            
        </head>
        </body><body style="width: 100%;font-family: helvetica, arial, sans-serif;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
            <div class="es-wrapper-color" style="background-color: #f6f6f6;">
                <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-repeat: repeat;background-position: center top;">
                    <tbody>
                        <tr style="border-collapse: collapse;">
                            <td class="esd-email-paddings" valign="top" style="padding: 0;margin: 0;">
                                <table class="es-header" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;width: 100%;background-color: transparent;background-repeat: repeat;background-position: center top;table-layout: fixed !important;">
                                    <tbody>
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-stripe esd-checked" align="center" style="padding: 0;margin: 0;">
                                                <table class="es-header-body" style="background-color: transparent;border-collapse: collapse;border-spacing: 0px;" width="700" cellspacing="0" cellpadding="0" align="center">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p10t es-p20r es-p20l" align="left" style="padding: 0;margin: 0;padding-top: 10px;padding-left: 20px;padding-right: 20px;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="700" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-image es-p40t es-p40b" align="center" style="font-size: 0;padding: 0;margin: 0;padding-top: 40px;padding-bottom: 40px;"><a href="https://monistic-hotel.com" target="_blank" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none;color: #b7bdc9;font-size: 20px;"><img src="cid:logo" style="display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" alt="Logo" title="monistic-hotel" width="150"></a></td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-image es-p10t" align="center" style="font-size: 0;padding: 0;margin: 0;padding-top: 10px;"><img class="adapt-img" src="cid:homepage" style="border-radius: 5px 5px 0px 0px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="660"></td>
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
                                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;border-spacing: 0px;width: 100%;table-layout: fixed !important;">
                                    <tbody>
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-stripe" esd-custom-block-id="6586" align="center" style="padding: 0;margin: 0;">
                                                <table class="es-content-body" style="background-color: transparent;border-collapse: collapse;border-spacing: 0px;" width="700" cellspacing="0" cellpadding="0" align="center">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p20r es-p20l" esd-custom-block-id="6568" align="left" style="padding: 0;margin: 0;padding-left: 20px;padding-right: 20px;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="600" valign="top" align="center" esdev-config="h1" style="padding: 0;margin: 0;">
                                                                                <table style="border-radius: 3px;border-collapse: separate;background-color: #ffffff;border-spacing: 0px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-text es-p25t es-p5b es-p20r es-p20l" align="center" style="padding: 0;margin: 0;padding-bottom: 5px;padding-left: 20px;padding-right: 20px;padding-top: 25px;">
                                                                                                <h3 style="margin: 0;line-height: 120%;font-family: helvetica, arial, sans-serif;font-size: 18px;font-style: normal;font-weight: normal;color: #444444;">Thanks for registering with Monistic-hotel. Please click the button below to complete your registration</h3>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-text es-p10t es-p15b es-p20r es-p20l" align="center" style="padding: 0;margin: 0;padding-top: 10px;padding-bottom: 15px;padding-left: 20px;padding-right: 20px;">
                                                                                                <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;font-family: helvetica, arial, sans-serif;line-height: 150%;color: #999999;font-size: 16px;"><span class="product-description"></span></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-button es-p15t es-p25b es-p10r es-p10l" align="center" style="padding: 0;margin: 0;padding-left: 10px;padding-right: 10px;padding-top: 15px;padding-bottom: 25px;"><span class="es-button-border"><a href="https://monistic-hotel.com/emailactive.php?account='.$encrypt_accountid.'" class="es-button" target="_blank" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none !important;color: #ffffff;font-size: 16px;border-style: solid;border-color: #3CCDDC;border-width: 15px 25px 15px 25px;display: inline-block;background: #3CCDDC;border-radius: 28px;font-family: helvetica, arial, sans-serif;font-weight: normal;font-style: normal;line-height: 120%;width: auto;text-align: center;">Confirm Register</a></span></td>
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
                                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;border-spacing: 0px;width: 100%;table-layout: fixed !important;">
                                    <tbody>
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-stripe" align="center" style="padding: 0;margin: 0;">
                                                <table class="es-content-body" style="background-color: #f6f6f6;border-collapse: collapse;border-spacing: 0px;" width="640" cellspacing="0" cellpadding="0" bgcolor="#f6f6f6" align="center">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p10t es-p20r es-p20l" align="left" style="padding: 0;margin: 0;padding-top: 10px;padding-left: 20px;padding-right: 20px;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="600" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-spacer es-p10t es-p10b" align="center" style="font-size: 0;padding: 0;margin: 0;padding-top: 10px;padding-bottom: 10px;">
                                                                                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                                    <tbody>
                                                                                                        <tr style="border-collapse: collapse;">
                                                                                                            <td style="border-bottom: 1px solid #f6f6f6;background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height: 1px;width: 100%;margin: 0px;padding: 0;"></td>
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
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="border-collapse: collapse;border-spacing: 0px;width: 100%;background-color: transparent;background-repeat: repeat;background-position: center top;table-layout: fixed !important;">
                                    <tbody>
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-stripe" esd-custom-block-id="6564" align="center" style="padding: 0;margin: 0;">
                                                <table class="es-footer-body" width="640" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;border-spacing: 0px;background-color: #f6f6f6;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p40b es-p20r es-p20l" align="left" style="padding: 0;margin: 0;padding-left: 20px;padding-right: 20px;padding-top: 40px;padding-bottom: 40px;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="600" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-image es-p5b" align="center" style="font-size: 0;padding: 0;margin: 0;padding-bottom: 5px;"><a target="_blank" href="https://monistic-hotel.com" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none;color: #999999;font-size: 14px;"><img src="cid:logo" alt="Logo" style="display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" title="Logo" width="70"></a></td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td class="esd-block-text es-p15t es-p15b" align="center" style="padding: 0;margin: 0;padding-top: 15px;padding-bottom: 15px;">
                                                                                                <span style="text-align: center;display: block;">Copyright @2021 Designed With by Monistic-Hotel Company</span>
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
        </body>
        </html>
    ';
    
    try {   
        $mail->isSMTP();                                       
        $mail->Host = 'mail.monistic-hotel.com';                  
        $mail->SMTPAuth = false;
        $mail->Charset = 'UTF-8';                                
        $mail->Priority = 1;
        $mail->setFrom('booking_system@monistic-hotel.com','Monistic-hotel');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Register Successfully of Monistic-hotel";
        $mail->Body = $body;
        $mail->AddEmbeddedImage("images/logo.png","logo");
        $mail->AddEmbeddedImage("images/homepage.jpg","homepage");

        $mail->send();

    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}  



    


?>