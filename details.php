<?php

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
    $booking_button = '<button class="check-availability-button" style="width:200px;margin-top: 32px;" id="check_availability">Check availability</button>';
    $go_booking_button = '<button class="check-availability-button" id="check-availability">Check availability</button>';
} else {
    $booking_button = '<button class="check-availability-button" style="width:200px;margin-top: 32px;" data-lw-onclick="#login">Please Login First</button>';
    $go_booking_button = '<button class="check-availability-button" data-lw-onclick="#login">Please Login First</button>';
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
    
    if (isset($_GET["check_in"]) || isset($_GET["check_out"])) {
        if ($_GET["check_in"] < $now || $_GET["check_out"] < $now || $_GET["check_out"] < $_GET["check_in"] || $_GET["check_in"] == "" || $_GET["check_out"] == "") {
            $check_in = "";
            $check_out = "";
        } else {
            $check_in = $_GET["check_in"];
            $check_out = $_GET["check_out"];
        }
    } else {
        $check_in = "";
        $check_out = "";
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

$query2 = mysqli_query($mysqli, "select a.ACCOMMODATION_ID, a.ROOM_NAME, a.ROOM_DESC, a.ROOM_LIVESTYLE, a.PRICE, a.ACCOUNT_ID, a.LOCATION, a.RULES, a.AMENITIES, a.NO_OF_ROOM, a.NO_OF_BATHROOM, a.NO_OF_BED, a.MAX_OF_PEOPLE, b.IMG_URL, b.SURNAME, b.GIVEN_NAME, b.IMG_URL from ACCOMMODATION a left join ACCOUNT b on b.ACCOUNT_ID = a.ACCOUNT_ID where a.ACCOMMODATION_ID = '".$_GET["id"]."'");
$row2 = mysqli_fetch_array($query2);
$room_name = $row2["ROOM_NAME"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $room_name; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="cache-control" content="max-age=86400, public" />
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="270203284440-h0uk50qsngj7976gfl5ihmie64cf643u.apps.googleusercontent.com">
    <link href="images/logo.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/little-widgets.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/detail.css" />
    <link rel="stylesheet" type="text/css" href="css/splide.min.css" />
    <link rel="stylesheet" type="text/css" href="css/profile.css" />
    <link rel="stylesheet" type="text/css" href="css/selectize.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

<body style="overflow-x: hidden;overflow-y:overlay">
    <header id="header" style="height: 100px; z-index: 994; position: fixed;top: 0;width: 100%;">
        <div class="container">
            <div id="nav-item">
                <nav class="navbar">
                    <a href="/"><img src="images/logo.png" alt="" title="" width="120" /></a>
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
                                            <img src="'.$img_url.'"/ id="profile_img">
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
                                        <input id="email" name="email" type="email" class="profile-input" readOnly value="'.$email.'" />
                                        <label for="password">Password</label>
                                        <input id="password" name="password" type="password" class="profile-input" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*)(]{8,}$" />
                                        <label for="dob">Date of Birth</label>
                                        <input id="dob" name="dob" type="text" class="profile-input" value="'.$dob.'" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" oninput="DateOfBirthChecking()" readOnly />
                                        <label for="mobile">Mobile Phone</label>
                                        <input id="mobile" name="mobile" type="text" class="profile-input" value="'.$mobile.'" />
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
                                        <input id="email" name="email" type="email" class="profile-input" readOnly value="'.$email.'" />
                                        <label for="dob">Date of Birth</label>
                                        <input id="dob" name="dob" type="text" class="profile-input" value="'.$dob.'" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" oninput="DateOfBirthChecking()" readOnly />
                                        <label for="mobile">Mobile Phone</label>
                                        <input id="mobile" name="mobile" type="text" class="profile-input" value="'.$mobile.'" maxlength="8" pattern="[0-9]{8}" />
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

        $accommodation_id = $row2["ACCOMMODATION_ID"];
        $room_desc = $row2["ROOM_DESC"];
        $no_of_room = $row2["NO_OF_ROOM"];
        $account_id = $row2["ACCOUNT_ID"];
        $rules = $row2["RULES"];
        $price = number_format($row2["PRICE"]);
        $total = number_format($row2["PRICE"] + 80);
        $no_of_bed = $row2["NO_OF_BED"];
        $no_of_bathroom = $row2["NO_OF_BATHROOM"];
        $room_livestyle = $row2["ROOM_LIVESTYLE"];
        $amenities = $row2["AMENITIES"];
        $single_bed = explode(".", $no_of_bed)[0];
        $double_bed = explode(".", $no_of_bed)[1];
        $location = $row2["LOCATION"];
        $surname = $row2["SURNAME"];
        $given_name = $row2["GIVEN_NAME"];
        $all_rules = "";
        $all_amenities = "";
        
        if (strpos($account_id, 'go') !== false || strpos($account_id, 'fb') !== false || $row2["IMG_URL"] != null) {
            $post_img_url = $row2["IMG_URL"];
        } else {
            $post_img_url = "images/user.png";
        }
        
        $rules_array = explode(",", $rules);
        $amenities_array = explode(",", $amenities);
        
        foreach ($rules_array as $rules_value) {
            if ($rules_value == "no_smoking") {
                $rules_name = "No smoking";
            } elseif ($rules_value == "no_party") {
                $rules_name = "No Party";
            } elseif ($rules_value == "no_children") {
                $rules_name = "No children";
            } elseif ($rules_value == "no_pets") {
                $rules_name = "No pets";
            } elseif (strpos($rules_value,"After ") !== false) {
                $rules_name = "Check in: ".substr($rules_value, 0, 11)." , Check out: ".substr($rules_value, 12, 12);
                $rules_value = "check_date";
            } 
            
            $all_rules = $all_rules.'<h5 style="vertical-align: middle;" class="amenities"><img src="images/rules/'.$rules_value.'.png" class="property_img"/>'.$rules_name.'</h5>';
        }
        
        foreach ($amenities_array as $amenities_value) {
            if ($amenities_value == "wifi") {
                $amenities_name = "Wifi";
            } elseif ($amenities_value == "air_conditioner") {
                $amenities_name = "Air Conditioner";
            } elseif ($amenities_value == "shower") {
                $amenities_name = "Shower";
            } elseif ($amenities_value == "kitchen") {
                $amenities_name = "Kitchen";
            } elseif ($amenities_value == "parking") {
                $amenities_name = "Parking";
            } elseif ($amenities_value == "hair_dryer") {
                $amenities_name = "Hair Dryer";
            } elseif ($amenities_value == "microwave") {
                $amenities_name = "Microwave";
            } elseif ($amenities_value == "hangers") {
                $amenities_name = "Hangers";
            } elseif ($amenities_value == "bathtub") {
                $amenities_name = "Bathtub";
            } elseif ($amenities_value == "shampoo") {
                $amenities_name = "Shampoo";
            } elseif ($amenities_value == "toilet_paper") {
                $amenities_name = "Toilet Paper";
            } elseif ($amenities_value == "towels") {
                $amenities_name = "Towels";
            } elseif ($amenities_value == "tv") {
                $amenities_name = "TV";
            } elseif ($amenities_value == "soap") {
                $amenities_name = "Soap";
            } elseif ($amenities_value == "balcony") {
                $amenities_name = "Balcony";
            } elseif ($amenities_value == "radiator") {
                $amenities_name = "Radiator";
            } elseif ($amenities_value == "washing_machine") {
                $amenities_name = "Washing Machine";
            } elseif ($amenities_value == "table") {
                $amenities_name = "Table";
            } 
            
            $all_amenities = $all_amenities.'<h5 style="vertical-align: middle;display: inline-block;" class="amenities"><img src="images/Amenities/'.$amenities_value.'.png" class="property_img"/>'.$amenities_name.'</h5>';
        }


        $dir = "images/rooms/".$accommodation_id;
        $images =  glob($dir . "/*.jpg");

        echo'
        
        <div class="container">
            <div class="row">
                <h1 style="width: auto;">'.$room_name.'</h1>
            </div>
        </div>
        <div class="container" style="margin-top: 20px;margin-left: auto;margin-right: auto;text-align: center;margin-bottom: 150px;">
            <div class="p-example__splide">
                <div id="sync" class="splide js-splide-primary p-splide p-splide--primary splide--fade splide--ltr splide--draggable is-active" data-splide={"type":"fade","heightRatio":0.5,"pagination":false,"arrows":false,"cover":true,"lazyLoad":"sequential"} tabindex="0" style="visibility: visible">
                    <div class="splide__track" id="sync-track">
                        <ul class="splide__list" id="sync-list">
                        ';
                        
                        for ($x = 0; $x <= sizeof($images) - 1; $x++) {
                            if($x == 0) {
                                echo'
                                <li class="splide__slide p-splide__slide" id="example-sync-slide01" aria-hidden="true" tabindex="-1" style="margin-right: 36px;width: 628px;height: 314px;transition: opacity 400ms cubic-bezier(0.42, 0.65, 0.27, 0.99) 0s;">
                                    <img alt="Sample Image 01" src="'.$images[$x].'"/>
                                </li>
                                '; 
                            } else {
                                echo'
                                <li class="splide__slide p-splide__slide is-active is-visible" id="example-sync-slide'.$x.'" style="margin-right: 36px;width: 628px;height: 314px;transition: opacity 400ms cubic-bezier(0.42, 0.65, 0.27, 0.99) 0s;" aria-hidden="false" tabindex="0">
                                    <img style="display: none" src="'.$images[$x].'"/>
                                </li>
                                ';
                            }

                        }

                        echo'
                        </ul>
                    </div>
                </div>
                <div id="thumbnail" class="splide js-splide-secondary p-splide p-splide--secondary splide--slide splide--ltr splide--draggable splide--nav is-active" data-splide={"rewind":true,"fixedWidth":100,"fixedHeight":60,"isNavigation":true,"gap":5, "focus":"center","pagination":true,"cover":true,"lazyLoad":"sequential","breakpoints":{"600":{"fixedWidth":66,"fixedHeight":40}}} tabindex="0" style="visibility: visible">
                    <div class="splide__track" id="thumbnail-track">
                        <ul class="splide__list" id="thumbnail-list" style="transform: translateX(0px)">
                        ';
                        
                        for ($x = 0; $x <= sizeof($images) - 1; $x++) {
                            if($x == 0) {
                                echo'
                                <li class="splide__slide p-splide__slide is-visible" id="thumbnail-slide01" style="margin-right: 10px;width: 100px;height: 60px;" aria-hidden="false" tabindex="0" role="button" aria-controls="slide01">
                                    <img src="'.$images[$x].'"/>
                                </li>
                                '; 
                            } else {
                                echo'
                                <li class="splide__slide p-splide__slide is-visible is-active" id="thumbnail-slide02" style="margin-right: 10px;width: 100px;height: 60px;" aria-hidden="false" tabindex="0" role="button" aria-controls="slide02" aria-current="true">
                                    <img style="display: none;" src="'.$images[$x].'"/>
                                </li>
                                ';
                            }

                        }

                        echo'
                        </ul>
                    </div>
                    <div class="splide__arrows p-splide__arrows">
                        <button class="main_splide__arrow p-splide__arrow splide__arrow--prev p-splide__arrow--prev fas fa-arrow-left" aria-controls="thumbnail-track" id="img-prev">
                            <span class="spi-angle-left"></span>
                        </button>
                        <button class="main_splide__arrow p-splide__arrow splide__arrow--next p-splide__arrow--next fas fa-arrow-right" aria-controls="thumbnail-track" id="img-next">
                            <span class="spi-angle-right"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-top: 50px;text-align: left;">
                <div class="row" style="border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 30px;">
                    <h2 style="font-weight: bold;width: auto;">'.$room_livestyle.' hosted by '.$given_name.' '.$surname.'</h2>
                    <div class="hoster-icon">
                        <img class="hoster-icon" src="'.$post_img_url.'">
                    </div>
                    <a class="contact-host-button" href="mailto:EMAILADDRESS">Contact Host</a>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <h4 style="font-weight: bold;">About this space</h4>
                    <h5 class="description">'.$room_desc.'</h5>
                </div>
                <div class="row" style="margin-top: 30px;border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 30px;">
                    <div class="col-5">
                        <h4 style="font-weight: bold;">House rules</h4>
                        '.$all_rules.'
                    </div>
                    <div class="col-7">
                        <div class="booking-form">
                            <div class="row">
                                <div class="col-md-2" style="width: 270px;">
                                    <div class="form-group">
                                        <span class="form-label">Check In</span>
                                        <input type="text" value="'.$check_in.'" label="Start" id="start" name="start" class="form-control" readonly style="text-align: center;">
                                        <!--<span id="start_clear" class="fa fa-times calendarclear"></span>-->
                                    </div>
                                </div>
                                <div class="col-md-2" style="width: 270px;">
                                    <div class="form-group">
                                        <span class="form-label">Check out</span>
                                        <input type="text" value="'.$check_out.'" label="End" id="end" name="end" class="form-control" readonly style="text-align: center;"> 
                                        <!--<span id="end_clear" class="fa fa-times calendarclear"></span>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div style="width: 225px;">
                                    <div class="form-group">
                                        <span class="form-label">Guests</span>
                                        <input class="form-control" id="guest" type="text" readonly onclick="show_guests()" value="'.$guests.'">
                                        <!--<span id="guest_clear" class="fa fa-times guestclear"></span>-->
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
                                <div class="col-md-1">
                                    <div class="form-btn">'.$booking_button.'</div>
                                </div>
                                <div class="row">
                                    <div class="col-5" id="all-fee">
                                        <h5>$'.$price.' x <span id="nights">1 night</span></h5>
                                        <h5 style="margin-top: 10px;">Service fee</h5>
                                        <h5 style="margin-top: 10px;">Total</h5>
                                    </div>
                                    <div class="col-5" id="fee-area">
                                        <h5>$ <span id="night-fee">'.$price.'</span></h5>
                                        <h5 style="margin-top: 10px;">$ <span id="service-fee">80</span></h5>
                                        <h5 style="margin-top: 10px;">$ <span id="total">'.$total.'</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 30px;">
                    <div class="col-6" style="border-right: 1px solid rgb(221, 221, 221);">
                        <h4 style="font-weight: bold;">Number of rooms</h4>
                        <img src="images/Amenities/room.png"/>
                        <h5><span>'.$no_of_room.'</span> Rooms</h5>
                    </div>
                    <div class="col-6">
                        <h4 style="font-weight: bold;">Number of bathrooms</h4>
                        <img src="images/Amenities/bathroom.png"/>
                        <h5><span>'.$no_of_bathroom.'</span> bathroom</h5>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 30px;">
                    <div class="col-4" style="border-right: 1px solid rgb(221, 221, 221);">
                        <h4 style="font-weight: bold;">Sleeping arrangements</h4>
                        <div class="double_bed">
                            <img src="images/Amenities/double_bed.png"/>
                            <h5><span>'.$double_bed.'</span> Double Bed</h5>
                        </div>
                        <div class="single_bed">
                            <img src="images/Amenities/single_bed.png"/>
                            <h5><span>'.$single_bed.'</span> Single Bed</h5>
                        </div>
                    </div>
                    <div class="col-8">
                        <h4 style="font-weight: bold;">Amenities</h4>
                        '.$all_amenities.'
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 30px;">
                    <h4 style="font-weight: bold;">Location</h4>
                    <iframe id="location" width="100%" height="500" frameborder="0" style="margin-top: 20px;" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAiVvscBR9sAcav7pI6pFsNU-cnMuESL5s&q='.$location.'&zoom=15" allowfullscreen></iframe>
                </div>
                <div class="row" style="margin-top: 30px;border-bottom: 1px solid rgb(221, 221, 221);padding-bottom: 30px;overflow-x: scroll;max-height: 400px;">
                ';  
                                                    
                    $query3 = mysqli_query($mysqli, "select SUM(RATING)/COUNT(RATING) as RATING from COMMENT where ACCOMMODATION_ID = '".$_GET["id"]."'");
                    $row3 = mysqli_fetch_array($query3);
                    
                    if ($row3["RATING"] == 0) {
                        echo '<h1 style="text-align:center">No comments yet</h1>';
                    } else {
                        echo '<h4 style="font-weight: bold;">Ratings <span id="rating">'.number_format($row3["RATING"],1).'</span></h4>';
                                
                        $query4 = mysqli_query($mysqli, "select a.ACCOUNT_ID, a.CM_CONTENT, a.RATING, b.IMG_URL, b.SURNAME, b.GIVEN_NAME from COMMENT a left join ACCOUNT b on a.ACCOUNT_ID = b.ACCOUNT_ID where a.ACCOMMODATION_ID = '".$_GET["id"]."'");
                        
                        while($row4 = mysqli_fetch_array($query4)) {
                            $c_account_id = $row4["ACCOUNT_ID"];
                            $c_surname = $row4["SURNAME"];
                            $c_given_name = $row4["GIVEN_NAME"];
                            $content = $row4["CM_CONTENT"];
        
                            if (strpos($c_account_id, 'go') !== false || strpos($c_account_id, 'fb') !== false || $row4["IMG_URL"] != null) {
                                $c_img_url = $row4["IMG_URL"];
                            } else {
                                $c_img_url = "images/user.png";
                            }
                            
                            echo'
                                <div class="col-6">
                                    <div style="margin-top: 15px;margin-bottom: 15px;">
                                        <img class="comment-icon" src="'.$c_img_url.'">
                                        <h5 class="comment-user">'.$c_given_name.' '.$c_surname.'</h5>
                                        <p class="comment">'.$content.'</p>
                                    </div>
                                </div>                    
    
                            ';
                        }
                    }
                    
                echo'  
                </div>
                <div class="row" style="margin-top: 30px;">
                    <h4 style="font-weight: bold;">Here are the other places</h4>
                    <div class="p-example__body" style="margin-top: 50px;">
                        <div class="p-example__splide">
                            <div id="other-choice" class="splide js-splide p-splide splide--slide splide--ltr splide--draggable is-active" data-splide={"arrows":true,"perPage":4,"height":"15rem","rewind":true,"breakpoints":{"600":{"height":"6rem"}}} style="visibility: visible;">
                                <div class="splide__track" id="multiple-track">
                                    <ul class="splide__list" id="multiple-list" style="transform: translateX(0px);">
                                    ';
                                    
                                    $query5 = mysqli_query($mysqli, "select ACCOMMODATION_ID, ROOM_NAME, PRICE from ACCOMMODATION where ACCOMMODATION_ID not in ('".$_GET["id"]."') ORDER BY RAND() LIMIT 8");
                
                                    while($row5 = mysqli_fetch_array($query5)) {
                                        $o_accommodation_id = $row5["ACCOMMODATION_ID"];
                                        $o_room_name = $row5["ROOM_NAME"];
                                        $o_price = $row5["PRICE"];
                                        
                                        if (isset($_GET["check_in"]) || isset($_GET["check_out"])) {
                                            echo'
                                            <li class="splide__slide p-splide__slide" id="example-multiple-slide01" style="padding:10px" aria-hidden="false" tabindex="0">
                                                <a href="https://monistic-hotel.com/details?id='.$o_accommodation_id.'&adults='.$adults.'&children='.$children.'&infants='.$infants.'&check_in='.$check_in.'&check_out='.$check_out.'">
                                                    <img class="other-img" src="images/rooms/'.$o_accommodation_id.'/'.$o_accommodation_id.'-1.jpg">
                                                    <h6 class="other-name">'.$o_room_name.'</h6>
                                                    <h6 style="color:#000;padding:5px">$'.$o_price.'</h6>
                                                </a>
                                            </li>
                                            '; 
                                        } else {
                                            echo'
                                            <li class="splide__slide p-splide__slide" id="example-multiple-slide01" style="padding:10px" aria-hidden="false" tabindex="0">
                                                <a href="https://monistic-hotel.com/details?id='.$o_accommodation_id.'&adults='.$adults.'&children='.$children.'&infants='.$infants.'">
                                                    <img class="other-img" src="images/rooms/'.$o_accommodation_id.'/'.$o_accommodation_id.'-1.jpg">
                                                    <h6 class="other-name">'.$o_room_name.'</h6>
                                                    <h6 style="color:#000;padding:5px">$'.$o_price.'</h6>
                                                </a>
                                            </li>
                                            ';
                                        }
                                    }

                                    echo'
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
        
        ?>
        
        <?php
        
        echo'
        <div id="" class="check-availability">
            <div class="container">
                <div style="float:left;position: absolute; top:25%">
                    <h3>$<span id="price">'.$price.'</span>／night</h3>
                </div>
                <div style="float:right;padding: 10px;">'.$go_booking_button.'</div>
            </div>
        </div>
        ';
        
        $query6 = mysqli_query($mysqli, "select CHECK_IN, CHECK_OUT from HISTORY where (CHECK_IN > now() or now() < CHECK_OUT) and ACCOMMODATION_ID = '".$accommodation_id."'");
        $disable_date_array = array();
        $disable_dates = "";
        
        while ($row6 = mysqli_fetch_array($query6)) {
            $query7 = mysqli_query($mysqli, "select * from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                    where selected_date between '".$row6["CHECK_IN"]."' and '".$row6["CHECK_OUT"]."'");
                    
            while ($row7 = mysqli_fetch_array($query7)) {
                array_push($disable_date_array, '"'.$row7["selected_date"].'"');
            }
            
            $disable_dates = implode(",",$disable_date_array);
        }
        
        ?>

        <footer class="footer">
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
    <script src="https://apis.google.com/js/api:client.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/little-widgets.js"></script>
    <script src="js/other-login.js"></script>
    <script src="js/login.js"></script>
    <script src="js/script.js"></script>
    <script src="js/selectize.js"></script>
    <script src="js/splide.min.js"></script>
    <script>
        naArray = [<?php echo $disable_dates; ?>];
        $('#sex').selectize();
        var sex_select = $('#sex').selectize();
        <?php echo $sex_select; ?>
    </script>
    <script src="js/details.js"></script>

</body>

</html>