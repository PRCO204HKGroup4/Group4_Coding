<?php

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
session_start();
$now = date("Y-m-d");

if(isset($_COOKIE["user_id"])) {
    $query1 = mysqli_query($mysqli, "select * from ACCOUNT where ACCOUNT_ID = '".$_COOKIE["user_id"]."'") or die(mysqli_error($mysqli));
    $row1 = mysqli_fetch_array($query1);
    $surname = $row1["SURNAME"];
    $given_name = $row1["GIVEN_NAME"];
    $email = $row1["EMAIL"];
    $password = $row1["PASSWORD"];
    $dob = date("m/d/Y", strtotime($row1["DOB"]));
    $mobile = $row1["MOBILE"];
    $sex = $row1["SEX"];
    $sex_select = "sex_select[0].selectize.setValue('".$sex."');";
    
    if ($row1["IMG_URL"] != null) {            
        $img_url = $row1["IMG_URL"];  
    } else {
        $img_url = "images/user.png";
    }
    $type = $row1["TYPE"];
} else {
    $sex = "";
    $sex_select = "";
}

if (isset($_GET["livestyle"])) {
    $district = "";
    $infants = 0;
    $adults = 0;
    $children = 0;
    $guests = "";
    $check_in = "";
    $check_out = "";
} else {
    $district = $_GET["district"];    
    
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
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Monistic-Hotel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="cache-control" content="max-age=86400, public" />
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="270203284440-h0uk50qsngj7976gfl5ihmie64cf643u.apps.googleusercontent.com">
    <link href="images/logo.ico" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/little-widgets.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/result.css" />
    <link rel="stylesheet" type="text/css" href="css/splide.min.css" />
    <link rel="stylesheet" type="text/css" href="css/selectize.css" />
    <link rel="stylesheet" type="text/css" href="css/pagination.css" />
    <link rel="stylesheet" type="text/css" href="css/profile.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="js/pagination.js"></script>

<body style="overflow-x: hidden;overflow-y: overlay">
    <header id="header" style="height: 100px; z-index: 994; position: fixed;top: 0;width: 100%;">
        <div class="container">
            <div id="nav-item">
                <nav class="navbar">
                    <a href="https://monistic-hotel.com"><img src="images/logo.png" alt="" title="" width="120" /></a>
                    <div class="form-group" style="display: none;" id="search_header_bar">
                        <span class="fa fa-search search_header_clear"> Where are you going?</span>
                    </div>
                    <?php
                        
                        if(!isset($_COOKIE["user_id"])) {
                            echo '
                            <div style="width:120px">
                                <a class="fas fa-users" data-lw-onclick="#login" id="login_button"></a>
                            </div>    
                            ';
                        } else {
                            echo '
                            <div style="position: relative;">
                                <img src="'.$img_url.'" id="user_icon" onclick="show_userfunction()">
                                <div id="user_function">
                                    <a data-lw-onclick="#profile" id="profile_button">Profile</a>
                                    <a href="history">History</a>
                                    <a href="host">Host</a>
                                    <a onclick="logout()">Logout</a>
                                </div>
                            </div>
                            ';
                        }
                     
                    ?>
                </nav>
            </div>
        </div>
    </header>

    <?php

    if(!isset($_COOKIE["user_id"])) {
        echo'
        <div class="lw-widget lw-widget_fullscreen" id="login">
            <div class="lw-overlay" data-lw-close id="close"></div>
            <div class="lw-container" style="border-radius: 10px;">
                <div class="lw-item lw-item_bg"><button id="clear" class="lw-close" type="button" data-lw-close><i
                        class="fa fa-times" style="font-size: 50px;"></i></button>
                    <form class="login100-form validate-form" method="POST" autocomplete="off">
                        <h1 style="text-align: center;">SIGN IN</h1>
                        <div class="wrap-input100 validate-input" data-validate="Wrong Email" style="margin-top: 50px;">
                            <input class="input100" type="email" name="email" id="email">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Email</span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Wrong Password">
                            <input class="input100" type="password" name="password" id="password">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password</span>
                        </div>
                        <div class="container-login100-form-btn" style="margin-top: 50px;">
                            <button type="button" class="login100-form-btn" id="myBtn" onclick="login()">SIGN IN</button>
                        </div>
                        <div>
                            <span style="text-align: center;display: block;margin-top: 20px;">No account? <button type="button" data-lw-close data-lw-onclick="#register"style="color: #3CCDDC">Register now</button></span>
                        </div>
                        <div id="gSignInWrapper">
                            <div id="google_login" class="customGPlusSignIn customBtn">
                              <span class="google_icon"></span>
                              <span class="buttonText">Sign in with Google</span>
                            </div>
                            <div id="facebook_login" class="customGPlusSignIn customBtn" scope="public_profile,email" onclick="loginFB()">
                              <span class="facebook_icon"></span>
                              <span class="buttonText">Sign in with Facebook</span>
                            </div>
                        </div>
                        <div class="" data-max-rows="1" data-size="large" data-button-type="continue_with" data-use-continue-as="true" scope="public_profile,email" onlogin="checkLoginState();"></div>
                    </form>
                </div>
            </div>
        </div>
        ';
    } else {
        if ($type == "mh") {
            echo'
            <div class="lw-widget lw-widget_fullscreen" id="profile">
                <div class="lw-overlay" data-lw-close id="close"></div>
                <div class="lw-container" style="border-radius: 10px;">
                    <div class="lw-item lw-item_bg" style="width:800px;margin-right:auto;marign-left:auto;text-align:center"><button id="clear" class="lw-close" type="button" data-lw-close><i class="fa fa-times" style="font-size: 50px;"></i></button>
                        <div class="container emp-profile">
                            <form method="post" action="edit_profile" autocomplete="off" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-img">
                                            <img src="'.$img_url.'" id="profile_img"/>
                                            <div class="file btn btn-lg btn-primary">
                                                <span>Change Photo<span>
                                                <input type="file" name="file" accept="image/*" id="profile_file"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7" style="text-align:left">
                                        <label for="surname">Surname</label>
                                        <input id="surname" name="surname" required type="text" class="profile-input" value="'.$surname.'" minlength="2" maxlength="15" pattern="[A-Za-z]*$" />
                                        <label for="given_name">Given Name</label>
                                        <input id="given_name" name="given_name" required type="text" class="profile-input" value="'.$given_name.'" minlength="3" maxlength="15" pattern="[A-Za-z\sA-Za-z]*$" />
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="profile-input" readOnly value="'.$email.'" />
                                        <label for="password">Password</label>
                                        <input id="password" name="password" type="password" class="profile-input" minlength="8" maxlength="16" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*)(]{8,}$" />
                                        <label for="dob">Date of Birth</label>
                                        <input id="dob" name="dob" type="text" required class="profile-input" value="'.$dob.'" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" readOnly />
                                        <label for="mobile">Mobile Phone</label>
                                        <input id="mobile" name="mobile" type="text" required class="profile-input" value="'.$mobile.'" />
                                        <label for="sex">Sex</label>
                                        <select id="sex" name="sex" required>
                                            <option value=""></option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                            <option value="O">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <button id="edit_profile" type="submit">Edit</button>
                            </form>           
                        </div>
                    </div>
                </div>
            </div>
            ';
        } else {
            echo'
            <div class="lw-widget lw-widget_fullscreen" id="profile">
                <div class="lw-overlay" data-lw-close id="close"></div>
                <div class="lw-container" style="border-radius: 10px;">
                    <div class="lw-item lw-item_bg" style="width:800px;margin-right:auto;marign-left:auto;text-align:center"><button id="clear" class="lw-close" type="button" data-lw-close><i class="fa fa-times" style="font-size: 50px;"></i></button>
                        <div class="container emp-profile">
                            <form method="post" action="edit_profile" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-img">
                                            <img src="'.$img_url.'"/>
                                        </div>
                                    </div>
                                    <div class="col-md-7" style="text-align:left">
                                        <label for="surname">Surname</label>
                                        <input id="surname" name="surname" required type="text" class="profile-input" value="'.$surname.'" minlength="2" maxlength="15" pattern="[A-Za-z]*$" />
                                        <label for="given_name">Given Name</label>
                                        <input id="given_name" name="given_name" required type="text" class="profile-input" value="'.$given_name.'" minlength="3" maxlength="15" pattern="[A-Za-z\sA-Za-z]*$" />
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="profile-input" readOnly value="'.$email.'" />
                                        <label for="dob">Date of Birth</label>
                                        <input id="dob" name="dob" type="text" required class="profile-input" value="'.$dob.'" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" readOnly />
                                        <label for="mobile">Mobile Phone</label>
                                        <input id="mobile" name="mobile" type="text" required class="profile-input" value="'.$mobile.'" maxlength="8" pattern="[0-9]{8}" />
                                        <label for="sex">Sex</label>
                                        <select id="sex" name="sex" required>
                                            <option value=""></option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                            <option value="O">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <button id="edit_profile" type="submit">Edit</button>
                            </form>           
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        
    }
    
    ?>

    <div class="lw-widget lw-widget_fullscreen" id="register">
        <div class="lw-overlay" data-lw-close></div>
        <div class="lw-container" style="border-radius: 10px;">
            <div class="lw-item lw-item_bg" style="width: 370px;margin-right:auto;marign-left:auto;text-align:center"><button id="clear" class="lw-close" type="button" data-lw-close><i class="fa fa-times" style="font-size: 50px;"></i></button>
                <div class="container emp-profile">
                    <form method="post" id="register_form">
                        <div class="row">
                            <div class="col-md-12" style="text-align:left">
                                <label for="r_surname">Surname</label>
                                <input id="r_surname" name="surname" required type="text" class="profile-input" minlength="2" maxlength="15" pattern="[A-Za-z]*$" />
                                <label for="r_given_name">Given Name</label>
                                <input id="r_given_name" name="given_name"  type="text" class="profile-input" minlength="3" maxlength="15" pattern="[A-Za-z\sA-Za-z]*$" />
                                <label for="r_email">Email</label>
                                <input id="r_email" name="email" required type="email" class="profile-input" />
                                <label for="r_password">Password</label>
                                <input id="r_password" name="password" required type="password" class="profile-input" minlength="8" maxlength="16" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?!.*\s)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*)(]+$"  />
                                <label for="r_retypepassword">Retype-Password</label>
                                <input id="r_retypepassword" name="retypepassword" required type="password" class="profile-input" minlength="8" maxlength="16" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?!.*\s)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*)(]+$" />
                                <label for="r_dob">Date of Birth</label>
                                <input id="r_dob" name="dob" required type="text" class="profile-input" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" readOnly />
                                <label for="r_mobile">Mobile Phone</label>
                                <input id="r_mobile" name="mobile" required type="text" class="profile-input" maxlength="8" pattern="[0-9]{8}" />
                                <label for="r_sex">Gender</label>
                                <select id="r_sex" name="sex" required>
                                    <option value=""></option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="login100-form-btn" style="margin-top:20px" id="register_button">Register</button>
                        <div>
                            <span style="text-align: center;display: block;margin-top: 20px;">Have account? <button type="button" data-lw-close data-lw-onclick="#login" style="color: #3CCDDC">Login now</button></span>
                        </div>
                    </form>           
                </div>
            </div>
        </div>
    </div>

    <main id="main" style="margin-top: 150px;">
        <?php 
        
        echo'
        <div class="booking-form">
            <div class="container">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <span class="form-label">Location</span>
                            <div style="text-align:left;">
                                <select id="district" name="district" required>
                                	<option value=""></option>
                                    <option value="Central and Western District">Central and Western District</option>
                                    <option value="Eastern District">Eastern District</option>
                                    <option value="Southern District">Southern District</option>
                                    <option value="Wan Chai District">Wan Chai District</option>
                                    <option value="Kowloon City District">Kowloon City District</option>
                                    <option value="Kwun Tong District">Kwun Tong District</option>
                                    <option value="Sham Shui Po District">Sham Shui Po District</option>
                                    <option value="Wong Tai Sin District">Wong Tai Sin District</option>
                                    <option value="Yau Tsim Mong District">Yau Tsim Mong District</option>
                                    <option value="Islands District">Islands District</option>
                                    <option value="Kwai Tsing District">Kwai Tsing District</option>
                                    <option value="North District">North District</option>
                                    <option value="Sai Kung District">Sai Kung District</option>
                                    <option value="Sha Tin District">Sha Tin District</option>
                                    <option value="Tai Po District">Tai Po District</option>
                                    <option value="Tsuen Wan District">Tsuen Wan District</option>
                                    <option value="Tuen Mun District">Tuen Mun District</option>
                                    <option value="Yuen Long District">Yuen Long District</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <span class="form-label">Guests</span>
                            <input class="form-control" id="guest" type="text" readonly onclick="show_guests()" value="'.$guests.'">
                        </div>
                        <div id="guest_detail">
                            <div class="guest_type">
                                <span class="fas fa-male" style="width: 25px;display: inline-block;"></span>
                                <span style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;display: inline-block;width: 50px;">adult</span>
                                <button class="input_number fa fa-minus" onclick="decrease(this)" type="button"></button>
                                <span class="guest_no" id="adult">'.$adults.'</span>
                                <button class="input_number fa fa-plus" onclick="increase(this)" type="button"></button>
                            </div>
                            <div class="guest_type">
                                <span class="fas fa-child" style="width: 25px;display: inline-block;"></span>
                                <span style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;display: inline-block;width: 50px;">child</span>
                                <button class="input_number fa fa-minus" onclick="decrease(this)" type="button"></button>
                                <span class="guest_no" id="child">'.$children.'</span>
                                <button class="input_number fa fa-plus" onclick="increase(this)" type="button"></button>
                            </div>
                            <div class="guest_type">
                                <span class="fas fa-baby" style="width: 25px;display: inline-block;"></span>
                                <span style="font-family: Arial, Helvetica, sans-serif;font-size: 20px;display: inline-block;width: 50px;">infant</span>
                                <button class="input_number fa fa-minus" onclick="decrease(this)" type="button"></button>
                                <span class="guest_no" id="infant">'.$infants.'</span>
                                <button class="input_number fa fa-plus" onclick="increase(this)" type="button"></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <span class="form-label">Check In</span>
                            <input type="text" value="'.$check_in.'" label="Start" id="start" name="start" class="form-control" readonly style="text-align: center;">
                            <!--<span id="start_clear" class="fa fa-times calendarclear"></span>-->
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <span class="form-label">Check out</span>
                            <input type="text" value="'.$check_out.'" label="End" id="end" name="end" class="form-control" readonly style="text-align: center;"> 
                            <!--<span id="end_clear" class="fa fa-times calendarclear"></span>-->
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-btn">
                            <button class="submit-btn fas fa-search" id="search_submit"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 50px;">
            <div class="row">
                <h1 style="width: auto;">Places to stay near you</h1>
            </div>
        </div>
        
        <div class="container" style="margin-bottom: 50px">
            <div class="row" id="data-container">
            ';
            
            if (isset($_GET["livestyle"])) {
                $query2 = mysqli_query($mysqli, "select a.ACCOMMODATION_ID, a.ROOM_NAME, a.PRICE, sum(b.RATING)/count(b.RATING) as 'RATING', count(b.RATING) as 'C_RATING' from ACCOMMODATION a left join COMMENT b on a.ACCOMMODATION_ID = b.ACCOMMODATION_ID left join HISTORY c on a.ACCOMMODATION_ID = c.ACCOMMODATION_ID where a.ROOM_LIVESTYLE = '".$_GET["livestyle"]."' group by a.ACCOMMODATION_ID");
            } else {
                $people = intval($adults + $childre + $infants);
                $query2 = mysqli_query($mysqli, "select a.ACCOMMODATION_ID, a.ROOM_NAME, a.PRICE, sum(b.RATING)/count(b.RATING) as 'RATING', count(b.RATING) as 'C_RATING' from ACCOMMODATION a left join COMMENT b on a.ACCOMMODATION_ID = b.ACCOMMODATION_ID where a.ACCOMMODATION_ID not in (select a.ACCOMMODATION_ID from ACCOMMODATION a left join HISTORY c on c.ACCOMMODATION_ID = a.ACCOMMODATION_ID where a.DISTRICT = '".$district."' and ".$people." <= a.MAX_OF_PEOPLE and (c.CHECK_IN <= '".$check_out."'  and '".$check_in."' <= c.CHECK_OUT) group by a.ACCOMMODATION_ID) and a.DISTRICT = '".$district."' and ".$people." <= a.MAX_OF_PEOPLE group by a.ACCOMMODATION_ID");
            }

            while ($row2 = mysqli_fetch_array($query2)) {
                $r_id = $row2["ACCOMMODATION_ID"];
                $r_price = number_format($row2["PRICE"]);
                $r_name = $row2["ROOM_NAME"];
                
                if ($row2["C_RATING"] == 1) {
                    $c_rating = $row2["C_RATING"].' review';
                } else {
                    $c_rating = $row2["C_RATING"].' reviews';
                }
                
                if ($row2["RATING"] == null) {
                    $r_rating = "No Rating Yet";
                } else {
                    $r_rating = '<span class="fa fa-star" style="color:#3CCDDC"></span>'.number_format($row2["RATING"],2).' ('.$c_rating.')';
                }
                
                if (isset($_GET["livestyle"])) {
                    echo'
                    <div class="col-3" style="margin-top: 50px;">
                        <a href="details?id='.$r_id.'&adults=1&children=0&infants=0" class="property" target="_blank">
                            <img class="property_img" src="images/rooms/'.$r_id.'/'.$r_id.'-1.jpg">
                            <h5 class="property_name">'.$r_name.'</h5>
                            <h5 class="property_fee">$'.$r_price.'／night</h5>
                            <h6 class="property_rating">'.$r_rating.'</h6>
                        </a>
                    </div>
                    ';
                } else {
                    echo'
                    <div class="col-3" style="margin-top: 50px;">
                        <a href="details?id='.$r_id.'&adults='.$adults.'&children='.$children.'&infants='.$infants.'&check_in='.$check_in.'&check_out='.$check_out.'" class="property" target="_blank">
                            <img class="property_img" src="images/rooms/'.$r_id.'/'.$r_id.'-1.jpg">
                            <h5 class="property_name">'.$r_name.'</h5>
                            <h5 class="property_fee">$'.$r_price.'／night</h5>
                            <h6 class="property_rating">'.$r_rating.'</h6>
                        </a>
                    </div>
                    ';
                }
            }
            
            echo'
            </div>
        </div>

        <div>
            <div id="pagination-container" style="width: fit-content;margin: auto;"></div>
        </div>
        
        ';

        ?>

        <footer class="footer" style="position: fixed;bottom: 0">
            <div class="container">
                <span style="text-align: center;display: block;">Copyright @2021 Designed With by Monistic-Hotel Company</span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/api:client.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/little-widgets.js"></script>
    <script src="js/other-login.js"></script>
    <script src="js/login.js"></script>
    <script src="js/splide.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/selectize.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.3/rangeslider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/result.js"></script>
    <script>
        

        $('#sex').selectize();
        var sex_select = $('#sex').selectize();
        <?php echo $sex_select; ?>
        


    </script>

</body>

</html>