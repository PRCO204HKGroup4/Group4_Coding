<?php

if(!isset($_SERVER['HTTP_REFERER']) || !isset($_COOKIE["user_id"])){
    header('location: https://monistic-hotel.com');
    exit;
}

$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
$now = date("Y-m-d");

if ($_GET["adults"] > 10) {
    $adults = 0;
} else {
    $adults = $_GET["adults"];
}

if ($_GET["children"] > 10) {
    $children = 0;
} else {
    $children = $_GET["children"];
}

if ($_GET["infants"] > 10) {
    $infants = 0;
} else {
    $infants = $_GET["infants"];
}

if ($_GET["check_in"] < $now || $_GET["check_out"] < $now || $_GET["check_out"] < $_GET["check_in"] || $_GET["check_in"] == "" || $_GET["check_out"] == "") {
    $check_in = "";
    $check_out = "";
} else {
    $check_in = $_GET["check_in"];
    $check_out = $_GET["check_out"];
}

$datediff = strtotime($check_out) - strtotime($check_in);
$days = round($datediff / (60 * 60 * 24));

if ($days > 1) {
    $night = "nights";
} else {
    $night = "night";
}

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Confirm and pay</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="cache-control" content="max-age=86400, public" />
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id"
        content="270203284440-h0uk50qsngj7976gfl5ihmie64cf643u.apps.googleusercontent.com">
    <link href="images/logo.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/book.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<body style="overflow-x: hidden;">
    <header id="header" style="height: 100px; z-index: 1000; position: fixed;top: 0;width: 100%;">
        <div class="container" style="text-align: center;margin-left: auto;margin-right: auto;">
            <nav class="">
                <a href="/"><img src="images/logo.png" alt="" title="" width="120" /></a>
            </nav>
        </div>
    </header>

    <main id="main" style="margin-top: 150px;">
        <?php 
            
        $query = mysqli_query($mysqli, "select * from ACCOMMODATION where ACCOMMODATION_ID = '".$_GET["id"]."'") or die(mysqli_error($mysqli));
        $row = mysqli_fetch_array($query);
        $price = number_format($row["PRICE"] * $days);
        $total_price = number_format($row["PRICE"] * $days + 80);
        $room_name = $row["ROOM_NAME"];
        $room_livestyle = $row["ROOM_LIVESTYLE"];
        $accommodation_id = $row["ACCOMMODATION_ID"];
            
        echo'
        <div class="container">
            <h1 style="display: inline-block;"><a href="javascript:history.go(-1)" class="fas fa-arrow-left" style="text-decoration:none"></a></h1>
            <h1 style="display: inline-block;margin-left: 10px;">Confirm and pay</h1>
        </div>
        <div class="container">
            <div class="booking-record">
                <div class="row">
                    <div style="width: fit-content;">
                        <img src="images/rooms/'.$accommodation_id.'/'.$accommodation_id.'-1.jpg" style="width: 13vw;" />
                    </div>
                    <div class="col-9" style="width: auto;">
                        <div style="border-bottom: 1px solid #DDDDDD !important;">
                            <span class="room-name">'.$room_name.'</span>
                            <span class="room-des">('.$room_livestyle.' in Hong Kong)</span>
                        </div>
                        <div>
                            <h3 style="font-weight: bold;">Price Details</h3>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-6" id="all-fee">
                                    <h5>$'.$row["PRICE"].' x <span id="nights">'.$days.' '.$night.'</span></h5>
                                    <h5 style="margin-top: 10px;">Service fee</h5>
                                    <h5 style="margin-top: 10px;">Total</h5>
                                </div>
                                <div class="col-5" id="fee-area">
                                    <h5>$ <span id="night-fee">'.$price.'</span></h5>
                                    <h5 style="margin-top: 10px;">$ <span id="service-fee">80</span></h5>
                                    <h5 style="margin-top: 10px;">$ <span id="total">'.$total_price.'</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="payment-detail">
                <h2 style="font-weight: bold;">Your trip</h2>
                <div>
                    <form method="post" id="payment-form" onsubmit="return check_payment()" name="payment_form">
                        <div class="trip-detail">
                            <div class="form-group">
                                <span class="form-label">Dates</span>
                                <input type="text" value="'.$check_in.' - '.$check_out.'" label="Start" id="date_range" name="date_range" class="form-control" readonly required style="text-align: center;display: inline-block;min-width: 250px;width: 25vw;">
                            </div>
                            <div class="form-group">
                                <span class="form-label">Guests</span>
                                <input class="form-control" id="guest" type="text" readonly onclick="show_guests()" value="'.$guests.'" required>
                            </div>
                            <div id="guest_detail">
                                <div class="guest_type">
                                    <span class="fas fa-male" style="width: 25px;display: inline-block;"></span>
                                    <span
                                        style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;display: inline-block;width: 50px;">adult</span>
                                    <button class="input_number fa fa-minus" onclick="decrease(this)" type="button"></button>
                                    <span class="guest_no" id="adult">'.$adults.'</span>
                                    <button class="input_number fa fa-plus" onclick="increase(this)" type="button"></button>
                                </div>
                                <div class="guest_type">
                                    <span class="fas fa-child" style="width: 25px;display: inline-block;"></span>
                                    <span
                                        style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;display: inline-block;width: 50px;">child</span>
                                    <button class="input_number fa fa-minus" onclick="decrease(this)" type="button"></button>
                                    <span class="guest_no" id="child">'.$children.'</span>
                                    <button class="input_number fa fa-plus" onclick="increase(this)" type="button"></button>
                                </div>
                                <div class="guest_type">
                                    <span class="fas fa-baby" style="width: 25px;display: inline-block;"></span>
                                    <span
                                        style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;display: inline-block;width: 50px;">infant</span>
                                    <button class="input_number fa fa-minus" onclick="decrease(this)" type="button"></button>
                                    <span class="guest_no" id="infant">'.$infants.'</span>
                                    <button class="input_number fa fa-plus" onclick="increase(this)" type="button"></button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="form-label">First Name</span>
                            <input type="text" name="first_name" class="form-control mb-3 StripeElement StripeElement--empty" required pattern="[A-Za-z]+">
                            <span class="form-label">Last Name</span>
                            <input type="text" name="last_name" class="form-control mb-3 StripeElement StripeElement--empty" required pattern="[A-Za-z]+">
                            <span class="form-label">Credit Card</span>
                            <div id="card-element" class="form-control">
                            </div>
                    
                            <div id="card-errors" role="alert"></div>
                        </div>
                    
                        <button class="payment-submit" type="submit">Submit Payment</button>
                        <!--<div id="google_pay" style="display: none;"></div>-->
                    </form>
                  </div>
            </div>
        </div>
        ';
        
        $query2 = mysqli_query($mysqli, "select CHECK_IN, CHECK_OUT from HISTORY where (CHECK_IN > now() or now() < CHECK_OUT) and ACCOMMODATION_ID = '".$accommodation_id."'");
        $disable_date_array = array();
        $disable_dates = "";
        
        while ($row2 = mysqli_fetch_array($query2)) {
            $query3 = mysqli_query($mysqli, "select * from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                    where selected_date between '".$row2["CHECK_IN"]."' and '".$row2["CHECK_OUT"]."'");
                    
            while ($row3 = mysqli_fetch_array($query3)) {
                array_push($disable_date_array, '"'.$row3["selected_date"].'"');
            }
            
            $disable_dates = implode(",",$disable_date_array);
        }
        
        ?>


        <footer class="footer">
            <div class="container">
                <span style="text-align: center;display: block;">Copyright @2021 Designed With by Monistic-Hotel
                    Company</span>
            </div>
        </footer>

        <a href="#" class="back-to-top fa fa-chevron-up"></a>
    </main>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/payment.js"></script>
    <script src="js/script.js"></script>
    <script>

        naArray = [<?php echo $disable_dates; ?>];
        
        function isDateAvailable(date){
            return naArray.indexOf(date.format('YYYY-MM-DD')) > -1;
        }
        
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            "startDate": check_in,
            "endDate": check_out,
            "autoApply": true,
            "opens": 'right',
            "minDate": new Date(),
            "autoUpdateInput": false,
            isInvalidDate: isDateAvailable
        }, function (start, end, label) {
        });
    
    </script>
    <script src="js/book.js"></script>

</body>

</html>