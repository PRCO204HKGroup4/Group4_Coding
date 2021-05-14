<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
require_once('init.php');

\Stripe\Stripe::setApiKey('sk_test_51If5ivKFdZ9QrhLVmAyRSJ8z7l7lpa8QYtkoOr9hFutRsaCR5gcZGJGeJ2hvwG07iaN1aTsjxI3yXTkT5sUqC8h900vR4lUGLh');

include_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/PHPMailer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/SMTP.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/Exception.php');

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
    
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$accommodation_id = $_GET['id'];
$check_in = $_GET['check_in'];
$check_out = $_GET['check_out'];
$guests = intval($_GET["adults"] + $_GET["children"] + $_GET["infants"]);
$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$token = $POST['stripeToken'];
$account_id = $_COOKIE["user_id"];

if (($_GET["adults"] > 1 || ($_GET["adults"] >= 1 && $_GET["children"] >= 1)) && $_GET["infants"] > 1) {
    $guests = $_GET["adults"] + $_GET["children"]." guests, ".$_GET["infants"]." infants";
} elseif (($_GET["adults"] > 1 || ($_GET["adults"] >= 1 && $_GET["children"] >= 1)) && $_GET["infants"] == 1) {
    $guests = $_GET["adults"] + $_GET["children"]." guests, 1 infant";
} elseif (($_GET["adults"] > 1 || ($_GET["adults"] >= 1 && $_GET["children"] >= 1)) && $_GET["infants"] == 1) {
    $guests = $_GET["adults"] + $_GET["children"]." guests, 1 infant";
} elseif ($_GET["adults"] > 1 && $_GET["infants"] > 1) {
    $guests = $_GET["adults"]." guests, ".$_GET["infants"]." infants";
} elseif ($_GET["adults"] == 1 && $_GET["infants"] == 1) {
    $guests = "1 guest, 1 infant";
} elseif (($_GET["adults"] > 1 || ($_GET["adults"] >= 1 && $_GET["children"] >= 1))) {
    $guests = $_GET["adults"] + $_GET["children"]." guests";
} else {
    $guests = "1 guest";
}

$stmt1 = $mysqli->prepare("select EMAIL, DOB, MOBILE, SURNAME, GIVEN_NAME from ACCOUNT where ACCOUNT_ID = ?");
$stmt1->bind_param("s", $account_id);
$stmt1->execute();
$stmt1->bind_result($user_email, $dob, $mobile, $user_surname, $user_given_name);
$stmt1->fetch();
$stmt1->close();

$age = date_diff(date_create($dob), date_create('today'))->y;
$days = round((strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24));

if ($mobile == null || $dob == null || $age < 18) {
    header('Location: payment_fail');
} else {
    $stmt2 = $mysqli->prepare("select distinct(a.ROOM_NAME), a.PRICE, a.MAX_OF_PEOPLE, c.SURNAME, c.GIVEN_NAME, c.EMAIL from ACCOMMODATION a left join HISTORY b on b.ACCOMMODATION_ID = a.ACCOMMODATION_ID left join ACCOUNT c on a.ACCOUNT_ID = c.ACCOUNT_ID where a.ACCOMMODATION_ID = ? and ((? < b.CHECK_IN and ? < b.CHECK_IN) or (? > b.CHECK_OUT and ? > b.CHECK_OUT))");
    $stmt2->bind_param("sssss", $accommodation_id, $check_in, $check_out, $check_in, $check_out);
    $stmt2->execute();
    $stmt2->bind_result($room_name, $price, $max_of_people, $surname, $given_name, $email);
    $stmt2->fetch();
    $stmt2->close();
    
    if ($days >= 1 && $guests <= $max_of_people) {
        $customer = \Stripe\Customer::create(array(
            "email" => $user_email,
            "source" => $token
        ));
        
        $charge = \Stripe\Charge::create(array(
            "amount" => $price*$days*100,
            "currency" => "hkd",
            "description" => $given_name." ".$surname."'s ".$room_name,
            "customer" => $customer->id
        ));
        
        $customerData = [
            'id' => $charge->customer,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $user_email
        ];
        
        $history_id = hash('SHA256', "h".date('YmdHis'));
        $evaluation = 'N';
        $booking_date = date("Y-m-d");
        $stmt3 = $mysqli->prepare("insert into HISTORY (HISTORY_ID, CHECK_IN, CHECK_OUT, NO_OF_PEOPLE, ACCOMMODATION_ID, ACCOUNT_ID, BOOKING_DATE, EVALUATION) values (?,?,?,?,?,?,?,?)");
        $stmt3->bind_param("sssissss", $history_id, $check_in, $check_out, $guests, $accommodation_id, $account_id, $booking_date, $evaluation);
        $stmt3->execute();
        $stmt3->close();
        
        $o_accommodation_array = array();
        $o_accommodation_price = array();
        $o_accommodation_name = array();
        $o_accommodation_style = array();
        $stmt4 = $mysqli->prepare("select ACCOMMODATION_ID, ROOM_NAME, PRICE, ROOM_LIVESTYLE from ACCOMMODATION where ACCOMMODATION_ID <> ? order by rand() limit 3");
        $stmt4->bind_param("s", $accommodation_id);
        $stmt4->execute();
        $stmt4->bind_result($o_a_id, $o_a_name, $o_a_price, $o_a_style);
        while ($row = $stmt4->fetch()) {
            array_push($o_accommodation_array, $o_a_id);
            array_push($o_accommodation_price, $o_a_price);
            array_push($o_accommodation_name, $o_a_name);
            array_push($o_accommodation_style, $o_a_style);
        }
        $stmt4->close();
        
        $mail1 = new PHPMailer\PHPMailer\PHPMailer;
        $body1 = '
        <!DOCTYPE html>
        <html style="width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
        
        <head>
            <meta charset="UTF-8">
            <meta content="width=device-width, initial-scale=1" name="viewport">
            <meta name="x-apple-disable-message-reformatting">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="telephone=no" name="format-detection">
            <title></title>
            
        </head>
        
        <body style="width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
            <div class="es-wrapper-color" style="background-color: #f6f6f6;">
                <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-image: ;background-repeat: repeat;background-position: center top;">
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
                                                                                            <td class="esd-block-image es-p10t" align="center" style="font-size: 0;padding: 0;margin: 0;padding-top: 10px;"><img class="adapt-img" src="cid:booking" style="border-radius: 5px 5px 0px 0px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="660"></td>
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
                                                <table class="es-content-body" width="660" cellspacing="0" cellpadding="0" bgcolor="#fefefe" align="center" style="border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p20b es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-bottom: 20px;padding-top: 40px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-text es-m-txt-c" style="padding: 0;margin: 0;">
                                                                                                <h1 style="margin: 0;line-height: 120%;font-size: 40px;font-style: normal;font-weight: normal;color: #444444;">We have received your booking and booking is success</h1>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 40px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-text es-m-txt-c" style="padding: 0;margin: 0;">
                                                                                                <h2 style="margin: 0;line-height: 120%;font-size: 28px;font-style: normal;font-weight: bold;color: #444444;">'.$room_name.'</h2>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p20t es-p20b es-p15r es-p15l" align="center" esdev-config="h5" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 20px;padding-bottom: 20px;">
                                                                <table cellspacing="0" cellpadding="0" align="left" class="es-left" style="border-collapse: collapse;border-spacing: 0px;float: left;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Name</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Check in</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Check out</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Guests</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="border-collapse: collapse;border-spacing: 0px;float: right;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$user_given_name.' '.$user_surname.'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$check_in.'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$check_out.'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$guests.'</p>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 40px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-text es-m-txt-c" style="padding: 0;margin: 0;">
                                                                                                <h3 style="margin: 0;line-height: 120%;font-size: 18px;font-style: normal;font-weight: normal;color: #444444;">Price Details</h3>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p20t es-p20b es-p15r es-p15l" align="center" esdev-config="h5" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 20px;padding-bottom: 20px;">
                                                                <table cellspacing="0" cellpadding="0" align="left" class="es-left" style="border-collapse: collapse;border-spacing: 0px;float: left;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">$'.number_format($price).' x '.$days.' nights</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Service fee</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Total</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="border-collapse: collapse;border-spacing: 0px;float: right;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">HKD$ '.number_format($price*$days).'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">HKD$ 80</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">HKD$ '.number_format($price*$days+80).'</p>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-button es-m-txt-l" style="padding: 0;margin: 0;">
                                                                                                <span class="msohide es-button-border"><a href="https://monistic-hotel.com/history" class="es-button" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none !important;color: #ffffff;font-size: 16px;border-style: solid;border-color: #3CCDDC;border-width: 15px 25px 15px 25px;display: inline-block;background: #3CCDDC;border-radius: 28px;font-weight: normal;font-style: normal;line-height: 120%;width: auto;text-align: center;">View Records</a></span>
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
                                <table class="es-content-body" width="660" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;">
                                    <tbody>
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-structure es-p20t es-p10b es-p20r es-p20l" esd-general-paddings-checked="false" esd-custom-block-id="2107" style="padding: 0;margin: 0;padding-bottom: 10px;padding-top: 20px;padding-left: 20px;padding-right: 20px;">
                                                <table class="es-center" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;border-spacing: 0px;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="es-m-p20b esd-container-frame" width="240" align="center" style="padding: 0;margin: 0;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text" align="center" style="padding: 0;margin: 0;">
                                                                                <h2 style="color: #333333;margin: 0;line-height: 120%;font-size: 28px;font-style: normal;font-weight: bold;">Other recommendations</h2>
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
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-structure es-p20t es-p20r es-p20l" esd-custom-block-id="2557" align="left" style="padding: 0;margin: 0;padding-top: 20px;padding-left: 20px;padding-right: 20px;">
                                                <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse: collapse;border-spacing: 0px;float: left;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="es-m-p20b esd-container-frame" esd-custom-block-id="2560" width="195" align="left" esdev-config="h4" style="padding: 0;margin: 0;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-image" align="center" style="font-size: 0;padding: 0;margin: 0;"><a target="_blank" href="https://monistic-hotel.com/details?id='.$o_accommodation_array[0].'&adults=1&children=0&infants=0" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none;color: #75b6c9;font-size: 16px;"><img class="adapt-img" src="cid:1img" style="display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="174"></a></td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p10t es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-top: 10px;">
                                                                                <h4 style="margin: 0;line-height: 120%;">'.$o_accommodation_name[0].'</h4>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p10t es-p10b es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-top: 10px;padding-bottom: 10px;">
                                                                                <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;"><span class="product-description">'.$o_accommodation_style[0].'</span></p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p15b es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-bottom: 15px;">
                                                                                <h4 style="color: #999999;margin: 0;line-height: 120%;">$'.number_format($o_accommodation_price[0]).'／night</h4>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="es-hidden" width="20" style="padding: 0;margin: 0;"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse: collapse;border-spacing: 0px;float: left;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="es-m-p20b esd-container-frame" width="195" align="left" esdev-config="h5" style="padding: 0;margin: 0;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-image" align="center" style="font-size: 0;padding: 0;margin: 0;"><a target="_blank" href="https://monistic-hotel.com/details?id='.$o_accommodation_array[1].'&adults=1&children=0&infants=0" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none;color: #75b6c9;font-size: 16px;"><img class="adapt-img" src="cid:2img" style="display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="173"></a></td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p10t es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-top: 10px;">
                                                                                <h4 style="margin: 0;line-height: 120%;">'.$o_accommodation_name[1].'</h4>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p10t es-p10b es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-top: 10px;padding-bottom: 10px;">
                                                                                <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;"><span class="product-description">'.$o_accommodation_style[1].'</span></p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p15b es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-bottom: 15px;">
                                                                                <h4 style="color: #999999;margin: 0;line-height: 120%;">$'.number_format($o_accommodation_price[1]).'／night</h4>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse: collapse;border-spacing: 0px;float: right;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="es-m-p20b esd-container-frame" width="195" align="left" esdev-config="h6" style="padding: 0;margin: 0;">
                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-image" align="center" style="font-size: 0;padding: 0;margin: 0;"><a target="_blank" href="https://monistic-hotel.com/details?id='.$o_accommodation_array[2].'&adults=1&children=0&infants=0" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none;color: #75b6c9;font-size: 16px;"><img class="adapt-img" src="cid:3img" style="display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="173"></a></td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p10t es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-top: 10px;">
                                                                                <h4 style="margin: 0;line-height: 120%;">'.$o_accommodation_name[2].'</h4>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p10t es-p10b es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-top: 10px;padding-bottom: 10px;">
                                                                                <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;"><span class="product-description">'.$o_accommodation_style[2].'</span></p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-block-text es-p15b es-m-txt-c" align="left" style="padding: 0;margin: 0;padding-bottom: 15px;">
                                                                                <h4 style="color: #999999;margin: 0;line-height: 120%;">$'.number_format($o_accommodation_price[2]).'／night</h4>
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
                                <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="border-collapse: collapse;border-spacing: 0px;width: 100%;background-color: transparent;background-image: ;background-repeat: repeat;background-position: center top;table-layout: fixed !important;">
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
        $mail1->isSMTP();                                       
        $mail1->Host = 'mail.monistic-hotel.com';                  
        $mail1->SMTPAuth = false;
        $mail1->Charset = 'UTF-8';                                
        $mail1->Priority = 1;
        $mail1->setFrom('booking_system@monistic-hotel.com','Monistic-hotel');
        $mail1->addAddress($user_email);
        $mail1->isHTML(true);
        $mail1->Subject = "Register Successfully of Monistic-hotel";
        $mail1->Body = $body1;
        $mail1->AddEmbeddedImage("images/logo.png","logo");
        $mail1->AddEmbeddedImage("images/rooms/".$accommodation_id."/".$accommodation_id."-1.jpg","booking");
    
        for($x=0;$x<sizeof($o_accommodation_array);$x++) {
            $mail1->AddEmbeddedImage("images/rooms/".$o_accommodation_array[$x]."/".$o_accommodation_array[$x]."-1.jpg",($x+1)."img");
        }
        
        $mail1->send();
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
        $mail2 = new PHPMailer\PHPMailer\PHPMailer;
        $body2 = '
        <!DOCTYPE html>
        <html style="width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
        
        <head>
            <meta charset="UTF-8">
            <meta content="width=device-width, initial-scale=1" name="viewport">
            <meta name="x-apple-disable-message-reformatting">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="telephone=no" name="format-detection">
            <title></title>
            
        </head>
        
        <body style="width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;padding: 0;margin: 0;">
            <div class="es-wrapper-color" style="background-color: #f6f6f6;">
                <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-image: ;background-repeat: repeat;background-position: center top;">
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
                                                                                            <td class="esd-block-image es-p10t" align="center" style="font-size: 0;padding: 0;margin: 0;padding-top: 10px;"><img class="adapt-img" src="cid:booking" style="border-radius: 5px 5px 0px 0px;display: block;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" width="660"></td>
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
                                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;border-spacing: 0px;width: 100%;table-layout: fixed !important;margin-bottom:20px">
                                    <tbody>
                                        <tr style="border-collapse: collapse;">
                                            <td class="esd-stripe" align="center" style="padding: 0;margin: 0;">
                                                <table class="es-content-body" width="660" cellspacing="0" cellpadding="0" bgcolor="#fefefe" align="center" style="border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;">
                                                    <tbody>
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p20b es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-bottom: 20px;padding-top: 40px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-text es-m-txt-c" style="padding: 0;margin: 0;">
                                                                                                <h1 style="margin: 0;line-height: 120%;font-size: 40px;font-style: normal;font-weight: normal;color: #444444;">Someone is booked your accommodation</h1>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 40px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-text es-m-txt-c" style="padding: 0;margin: 0;">
                                                                                                <h2 style="margin: 0;line-height: 120%;font-size: 28px;font-style: normal;font-weight: bold;color: #444444;">'.$room_name.'</h2>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p20t es-p20b es-p15r es-p15l" align="center" esdev-config="h5" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 20px;padding-bottom: 20px;">
                                                                <table cellspacing="0" cellpadding="0" align="left" class="es-left" style="border-collapse: collapse;border-spacing: 0px;float: left;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Name</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Check in</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Check out</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Guests</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="border-collapse: collapse;border-spacing: 0px;float: right;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$user_given_name.' '.$user_surname.'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$check_in.'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$check_out.'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">'.$guests.'</p>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p40t es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 40px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-text es-m-txt-c" style="padding: 0;margin: 0;">
                                                                                                <h3 style="margin: 0;line-height: 120%;font-size: 18px;font-style: normal;font-weight: normal;color: #444444;">Price Details</h3>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p20t es-p20b es-p15r es-p15l" align="center" esdev-config="h5" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;padding-top: 20px;padding-bottom: 20px;">
                                                                <table cellspacing="0" cellpadding="0" align="left" class="es-left" style="border-collapse: collapse;border-spacing: 0px;float: left;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">$'.number_format($price).' x '.$days.' nights</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Service fee</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="right" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;color: #999999;font-size: 16px;">Total</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="border-collapse: collapse;border-spacing: 0px;float: right;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td class="esd-container-frame" width="265" valign="top" align="center" style="padding: 0;margin: 0;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">HKD$ '.number_format($price*$days).'</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">HKD$ 80</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="left" class="esd-block-text" style="padding: 0;margin: 0;">
                                                                                                <p class="b_description" style="font-weight: bold;color: #3CCDDC;margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;line-height: 150%;font-size: 16px;">HKD$ '.number_format($price*$days+80).'</p>
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
                                                        <tr style="border-collapse: collapse;">
                                                            <td class="esd-structure es-p15r es-p15l" align="left" style="padding: 0;margin: 0;padding-left: 15px;padding-right: 15px;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                    <tbody>
                                                                        <tr style="border-collapse: collapse;">
                                                                            <td width="570" class="esd-container-frame" align="center" valign="top" style="padding: 0;margin: 0;">
                                                                                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;border-spacing: 0px;">
                                                                                    <tbody>
                                                                                        <tr style="border-collapse: collapse;">
                                                                                            <td align="center" class="esd-block-button es-m-txt-l" style="padding: 0;margin: 0;">
                                                                                                <span class="msohide es-button-border"><a href="https://monistic-hotel.com/host" class="es-button" style="-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-decoration: none !important;color: #ffffff;font-size: 16px;border-style: solid;border-color: #3CCDDC;border-width: 15px 25px 15px 25px;display: inline-block;background: #3CCDDC;border-radius: 28px;font-weight: normal;font-style: normal;line-height: 120%;width: auto;text-align: center;">View Records</a></span>
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
                                <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="border-collapse: collapse;border-spacing: 0px;width: 100%;background-color: transparent;background-image: ;background-repeat: repeat;background-position: center top;table-layout: fixed !important;">
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
        $mail2->isSMTP();                                       
        $mail2->Host = 'mail.monistic-hotel.com';                  
        $mail2->SMTPAuth = false;
        $mail2->Charset = 'UTF-8';                                
        $mail2->Priority = 1;
        $mail2->setFrom('booking_system@monistic-hotel.com','Monistic-hotel');
        $mail2->addAddress($email);
        $mail2->isHTML(true);
        $mail2->Subject = "Register Successfully of Monistic-hotel";
        $mail2->Body = $body2;
        $mail2->AddEmbeddedImage("images/logo.png","logo");
        $mail2->AddEmbeddedImage("images/rooms/".$accommodation_id."/".$accommodation_id."-1.jpg","booking");
        $mail2->send();
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
        
        header('Location: payment_success');
    } else {
        header('Location: payment_fail');
    }

    
    //$customer = new Customer();
    
    //$customer->addCustomer($customerData);
    
    /*$transactionData = [
        'id' => $charge->id,
        'customer_id' => $charge->customer,
        'product' => $charge->description,
        'amount' => $charge->amount,
        'currency' => $charge->currency,
        'status' => $charge->status,
    ];
    
    $transaction = new Transaction();
    
    $transaction->addTransaction($transactionData);*/
    //header('Location: payment_success');
}

?>