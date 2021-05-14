<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/logo.ico" rel="icon">
    <title>Payment Fail</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/payment.css" />
</head>

<body>

    <div id="payment" style="z-index: 2;">
        <div class="payment">
            <div class="payment-content">
                <div style="width: 100%">
                    <img src="images/logo.png" /> 
                </div>

                
                <img src="images/cross.png" style="width:200px;margin-top:50px" />
                <h2>Please note that your mobile phone number and date of birth have been entered into your profile!</h2>
                <h2>Also, please input the correct number of guests, check in and check out date, Thank you!</h2>
                <a href="javascript:history.go(-2)" style="margin-top: 100px;font-size: 30px;display: block;width: auto;background:#3CCDDC">GO TO CHECK AGAIN</a>
            </div>
            <div style="margin-top: 250px">
                <p style="font-size: 20px;color: #3CCDDC;">Copyright &copy; 2021 Designed With by Monistic-Hotel Company All rights reserved.</p>
            </div>
        </div>
    </div>

</body>
</html>
