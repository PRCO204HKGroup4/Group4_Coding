<?php

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
session_start();
$now = date("Y-m-d");

if(!isset($_COOKIE["user_id"])) {
    header('location: https://monistic-hotel.com');
    exit;
} else {
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
    <meta name="google-signin-client_id"
        content="270203284440-h0uk50qsngj7976gfl5ihmie64cf643u.apps.googleusercontent.com">
    <link href="images/logo.ico" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/little-widgets.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/result.css" />
    <link rel="stylesheet" type="text/css" href="css/host_table.css" />
    <link rel="stylesheet" type="text/css" href="css/profile.css" />
    <link rel="stylesheet" type="text/css" href="css/selectize.css" />
    <link rel="stylesheet" type="text/css" href="css/kvinput.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-material-datetimepicker.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="js/selectize.js"></script>

<body style="overflow-x: hidden;background-image: url('images/homepage.jpg');background-repeat:no-repeat;background-attachment:fixed;background-size:100% 100%;overflow: overlay;">
    <header id="header" style="height: 100px; z-index: 994; position: fixed;top: 0;width: 100%;">
        <div class="container">
            <div id="nav-item">
                <nav class="navbar">
                    <a href="/"><img src="images/logo.png" alt="" title="" width="120" /></a>
                    <?php
                        
                        if(isset($_COOKIE["user_id"])) {
                            echo '
                            <div style="position: relative;">
                                <img src="'.$img_url.'" id="user_icon" onclick="show_userfunction()">
                                <div id="user_function">
                                    <a href="/">Main</a>
                                    <a data-lw-onclick="#profile" id="profile_button">Profile</a>
                                    <a href="history">History</a>
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
                                        <input id="email" name="email" type="email" class="profile-input" readOnly value="'.$email.'" />
                                        <label for="password">Password</label>
                                        <input id="password" name="password" type="password" class="profile-input" />
                                        <label for="dob">Date of Birth</label>
                                        <input id="dob" name="dob" type="text" class="profile-input" value="'.$dob.'" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" readOnly />
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
        
        ?>

    <div class="lw-widget lw-widget_fullscreen" id="edit_widget">
        <div class="lw-overlay" id="close"></div>
        <div class="lw-container" style="border-radius: 10px;">
            <div class="lw-item lw-item_bg" style="width: 750px"><button id="clear" class="lw-close" type="button" data-lw-close><i class="fa fa-times" style="font-size: 50px;"></i></button>
                <form class="login100-form validate-form" method="POST" autocomplete="off" action="update_host" enctype="multipart/form-data">
                    <h1 style="text-align: center;width:auto">EDIT</h1>
                    <label for="e_room_name">Room Name</label>
                    <input id="o_room_name" name="o_room_name" type="hidden" />
                    <input id="e_room_name" name="room_name" required type="text" class="profile-input" />
                    <label for="e_room_desc">Room Desc</label>
                    <textarea id="e_room_desc" name="room_desc" required class="profile-input" style="height:200px;font-size:18px" /></textarea>
                    <label for="e_district" style="display:block">District</label>
            		<select id="e_district" name="district" required>
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
                    <label for="e_location">Location</label>
                    <textarea id="e_location" name="location" required class="profile-input" style="font-size:18px" /></textarea>
                    <label for="e_room_livestyle">Live Style</label>
                    <input id="e_room_livestyle" name="room_livestyle" required type="text" class="profile-input" />
                    <label for="e_price">Price</label>
                    <input id="e_price" name="price" type="number" min="1" required class="profile-input" style="width:100px" />
                    <label for="e_no_of_room">No of Rooms</label>
                    <input id="e_no_of_room" name="no_of_room" type="number" min="0" required class="profile-input" style="width:100px" />
                    <label for="e_no_of_bathroom">No of Bathrooms</label>
                    <input id="e_no_of_bathroom" name="no_of_bathroom" type="number" min="1" required class="profile-input" style="width:100px" />
                    <label for="e_single_bed">Single Beds</label>
                    <input id="e_single_bed" name="single_bed" type="number" min="0" required class="profile-input" style="width:100px" />
                    <label for="e_double_bed">Double Beds</label>
                    <input id="e_double_bed" name="double_bed" type="number" min="0" required class="profile-input" style="width:100px" />
                    <label for="e_max_of_people">Max of People</label>
                    <input id="e_max_of_people" name="max_of_people" type="number" min="1" max="20" required class="profile-input" style="width:100px" />
                    <div style="display:inline-block">
                        <label for="e_checkin_time">Check in after</label>
                        <input type="text" id="e_checkin_time" class="profile-input floating-label"  style="font-weight: bold;display:block" name="checkin_time" readonly required>
                    </div>
                    <div style="display:inline-block">
                        <label for="e_checkout_time">Check out before</label>
                        <input type="text" id="e_checkout_time" class="profile-input floating-label"  style="font-weight: bold;display:block" name="checkout_time" readonly required>
                    </div>
            		<label for="e_amenities" style="display:block">Amenities</label>
            		<select id="e_amenities" name="amenities[]" multiple>
            			<option value=""></option>
            			<option value="air_conditioner">Air Conditioner</option>
            			<option value="balcony">Balcony</option>
            			<option value="bathtub">Bathtub</option>
            			<option value="hair_dryer">Hair Dryer</option>
            			<option value="hangers">Hangers</option>
            			<option value="kitchen">Kitchen</option>
            			<option value="microwave">Microwave</option>
            			<option value="parking">Parking</option>
            			<option value="radiator">Radiator</option>
            			<option value="shampoo">Shampoo</option>
            			<option value="shower">Shower</option>
            			<option value="soap">Soap</option>
            			<option value="table">Table</option>
            			<option value="toilet_paper">Toilet Paper</option>
            			<option value="towels">Towels</option>
            			<option value="tv">TV</option>
            			<option value="washing_machine">Washing Machine</option>
            			<option value="wifi">Wifi</option>
            		</select>
            		<label for="e_rules" style="display:block">Rules</label>
            		<select id="e_rules" name="rules[]" multiple>
            			<option value=""></option>
            			<option value="no_children">No Children</option>
            			<option value="no_party">No Party</option>
            			<option value="no_pets">No Pets</option>
            			<option value="no_smoking">No Smoking</option>
            		</select>
            		<label for="e_image" style="display:block">Images</label>
            		<input type="file" class="file" accept="image/*" multiple name="image[]" id="e_image" style="height:24px">
                    <div class="container-login100-form-btn" style="margin-top: 50px;">
                        <button type="submit" class="login100-form-btn" id="myBtn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="lw-widget lw-widget_fullscreen" id="create_widget">
        <div class="lw-overlay" id="close"></div>
        <div class="lw-container" style="border-radius: 10px;">
            <div class="lw-item lw-item_bg" style="width: 750px"><button id="clear" class="lw-close" type="button" data-lw-close><i class="fa fa-times" style="font-size: 50px;"></i></button>
                <form class="login100-form validate-form" method="POST" autocomplete="off" action="create_host" enctype="multipart/form-data">
                    <h1 style="text-align: center;">Host a new accommodation</h1>
                    <label for="room_name">Room Name</label>
                    <input id="room_name" name="room_name" required type="text" class="profile-input" />
                    <label for="room_desc">Room Desc</label>
                    <textarea id="room_desc" name="room_desc" required class="profile-input" style="height:200px;font-size:18px" /></textarea>
                    <label for="district" style="display:block">District</label>
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
                    <label for="location">Location</label>
                    <textarea id="location" name="location" required class="profile-input" style="font-size:18px" /></textarea>
                    <label for="room_livestyle">Live Style</label>
                    <input id="room_livestyle" name="room_livestyle" required type="text" class="profile-input" />
                    <label for="price">Price</label>
                    <input id="price" name="price" type="number" min="1" required class="profile-input" style="width:100px" />
                    <label for="no_of_room">No of Rooms</label>
                    <input id="no_of_room" name="no_of_room" type="number" min="0" required class="profile-input" style="width:100px" />
                    <label for="no_of_bathroom">No of Bathrooms</label>
                    <input id="no_of_bathroom" name="no_of_bathroom" type="number" min="1" required class="profile-input" style="width:100px" />
                    <label for="single_bed">Single Beds</label>
                    <input id="single_bed" name="single_bed" type="number" min="0" required class="profile-input" style="width:100px" />
                    <label for="double_bed">Double Beds</label>
                    <input id="double_bed" name="double_bed" type="number" min="0" required class="profile-input" style="width:100px" />
                    <label for="max_of_people">Max of People</label>
                    <input id="max_of_people" name="max_of_people" type="number" min="1" max="20" required class="profile-input" style="width:100px" />
                    <div style="display:inline-block">
                        <label for="checkin_time">Check in after</label>
                        <input type="time" id="checkin_time" class="profile-input floating-label" style="font-weight: bold;display:block" name="checkin_time"  required>
                    </div>
                    <div style="display:inline-block">
                        <label for="checkout_time">Check out before</label>
                        <input type="time" id="checkout_time" class="profile-input floating-label" style="font-weight: bold;display:block" name="checkout_time"  required>
                    </div>
            		<label for="amenities" style="display:block">Amenities</label>
            		<select id="amenities" name="amenities[]" multiple required>
            			<option value=""></option>
            			<option value="air_conditioner">Air Conditioner</option>
            			<option value="balcony">Balcony</option>
            			<option value="bathtub">Bathtub</option>
            			<option value="hair_dryer">Hair Dryer</option>
            			<option value="hangers">Hangers</option>
            			<option value="kitchen">Kitchen</option>
            			<option value="microwave">Microwave</option>
            			<option value="parking">Parking</option>
            			<option value="radiator">Radiator</option>
            			<option value="shampoo">Shampoo</option>
            			<option value="shower">Shower</option>
            			<option value="soap">Soap</option>
            			<option value="table">Table</option>
            			<option value="toilet_paper">Toilet Paper</option>
            			<option value="towels">Towels</option>
            			<option value="tv">TV</option>
            			<option value="washing_machine">Washing Machine</option>
            			<option value="wifi">Wifi</option>
            		</select>
            		<label for="rules" style="display:block">Rules</label>
            		<select id="rules" name="rules[]" multiple required>
            			<option value=""></option>
            			<option value="no_children">No Children</option>
            			<option value="no_party">No Party</option>
            			<option value="no_pets">No Pets</option>
            			<option value="no_smoking">No Smoking</option>
            		</select>
            		<label for="image" style="display:block">Images</label>
            		<input type="file" class="file" accept="image/*" multiple name="image[]" id="image" style="height:24px" required>
                    <div class="container-login100-form-btn" style="margin-top: 50px;">
                        <button type="submit" class="login100-form-btn" id="myBtn">Host</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <main id="main" style="margin-top: 150px;">
        <div class="container">
            <button style="font-size:35px;margin-bottom:20px;color:#3098a2" class="fa fa-plus-circle" data-lw-onclick="#create_widget"></button>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrap">
                        <table class="table table-responsive-xl">
                            <thead>
                                <tr style="background-color: #f8f9fd;">
                                    <th>Name</th>
                                    <th>User Name</th>
                                    <th>Status</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                        
                                $result1 = mysqli_query($mysqli, "select ROOM_NAME, ACCOMMODATION_ID from ACCOMMODATION WHERE ACCOUNT_ID = '".$_COOKIE["user_id"]."'");
                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                    $accommodation_id = $row1["ACCOMMODATION_ID"];
                                    $room_name = $row1["ROOM_NAME"];
                                                 
                                    $result2 = mysqli_query($mysqli, "select b.SURNAME, b.GIVEN_NAME from HISTORY a left join ACCOUNT b on b.ACCOUNT_ID = a.ACCOUNT_ID where a.ACCOMMODATION_ID = '".$accommodation_id."' and (now() >= a.CHECK_IN and now() <= a.CHECK_OUT)");
                                    $row_count = mysqli_num_rows($result2);
                                    $row2 = mysqli_fetch_assoc($result2);
                                    
                                    if ($row_count > 0) {
                                        echo'
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <img src="images/rooms/'.$accommodation_id.'/'.$accommodation_id.'-1.jpg" style="object-fit: cover;width:220px;height:150px;border-radius:10px">
                                                <div class="pl-3 name">
                                                    <span style="font-size:15px">'.$room_name.'</span>
                                                </div>
                                            </td>
                                            <td>'.$row2["SURNAME"].' '.$row2["GIVEN_NAME"].'</td>
                                            <td class="status"><span class="waiting">Living</span></td>
                                            <td>Cannot be modified during living</td>
                                        </tr>
                                        ';
                                    } else {
                                        echo'
                                        <tr id="'.$accommodation_id.'">
                                            <td class="d-flex align-items-center">
                                                <img src="images/rooms/'.$accommodation_id.'/'.$accommodation_id.'-1.jpg" style="object-fit: cover;width:220px;height:150px;border-radius:10px">
                                                <div class="pl-3 name">
                                                    <span style="font-size:15px">'.$room_name.'</span>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td class="status"><span class="active">Active</span></td>
                                            <td style="font-size:20px">
                                                <button class="fa fa-edit edit" title="Edit" data-lw-onclick="#edit_widget"></button>
                                                <button class="fa fa-minus-circle delete" title="Delete"></button>
                                            </td>
                                        </tr>
                                        ';
                                    } 
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer" style="position: fixed;bottom: 0;">
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
    <script src="js/bootstrap-material-datetimepicker.js"></script>
    <script src="js/little-widgets.js"></script>
    <script src="js/kvinput.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/script.js"></script>
    <script src="js/host.js"></script>
    <script>
        $('#sex').selectize();
        var sex_select = $('#sex').selectize();
        <?php echo $sex_select; ?>
    </script>

</body>

</html>