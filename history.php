<?php

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
session_start();

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
    <meta name="google-signin-client_id" content="270203284440-h0uk50qsngj7976gfl5ihmie64cf643u.apps.googleusercontent.com">
    <link href="images/logo.ico" rel="icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/little-widgets.css" />
    <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <link rel="stylesheet" type="text/css" href="css/splide.min.css" />
    <link rel="stylesheet" type="text/css" href="css/history.css" />
    <link rel="stylesheet" type="text/css" href="css/profile.css" />
    <link rel="stylesheet" type="text/css" href="css/selectize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-material-datetimepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

<body style="overflow-x: hidden;overflow: overlay;">
    <header id="header" style="height: 150px; z-index: 994; position: fixed;top: 0;width: 100%;">
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
                                    <a href="/">Main</a>
                                    <a data-lw-onclick="#profile" id="profile_button">Profile</a>
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
                                            <img src="'.$img_url.'"/>
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
        }
        
        ?>
        
        <div class="tab_header">
            <div class="tab_all">
                <div class="tab tab1 active">
                    <div class="block">Unrated History</div>
                </div>
                <div class="tab tab2">
                    <div class="block">History</div>
                </div>
                <div class="indicator"></div>
            </nav>
        </div>
    </header>
    
    <div class="tab_body" style="margin-top: 200px;">
        <main>
            <div class="tab_reel">
                <div class="tab_panel1">
                    <?php
                    
                    $query2 = mysqli_query($mysqli, "select a.ACCOMMODATION_ID, a.HISTORY_ID, a.CHECK_IN, a.CHECK_OUT, a.BOOKING_DATE, a.NO_OF_PEOPLE, b.ROOM_NAME from HISTORY a left join ACCOMMODATION b on b.ACCOMMODATION_ID = a.ACCOMMODATION_ID where a.ACCOUNT_ID = '".$_COOKIE["user_id"]."' and a.EVALUATION = 'N'");
                    
                    while ($row2 = mysqli_fetch_array($query2)) {
                        $uh_accommodation_id = $row2["ACCOMMODATION_ID"];
                        $uh_check_in = $row2["CHECK_IN"];
                        $uh_check_out = $row2["CHECK_OUT"];
                        $uh_booking_date = $row2["BOOKING_DATE"];
                        $uh_no_of_people = $row2["NO_OF_PEOPLE"];
                        $uh_history_id = $row2["HISTORY_ID"];
                        $uh_room_name = $row2["ROOM_NAME"];
                        
                        if ($uh_check_out > date('Y-m-d')) {
                            $comment_button = '';
                        } else {
                            $comment_button = '<button class="comment_button">Rate and Comment</button>';
                        }
                        
                        echo'
                        <div class="card card_list">
                            <div class="container">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="images/rooms/'.$uh_accommodation_id.'/'.$uh_accommodation_id.'-1.jpg" class="history_img">
                                    </div>
                                    <div class="col-7 content">
                                        <h3 style="display: inline-block">'.$uh_room_name.'</h3>
                                        '.$comment_button.'
                                        <h4 style="margin-top:20px">Booking date: '.$uh_booking_date.'</h4>
                                        <h4 style="margin-top:20px;display:inline-block;">Check in: '.$uh_check_in.'</h4>
                                        <h4 style="margin-top:20px;display:inline-block;margin-left:20px">Check out: '.$uh_check_out.'</h4>
                                        <h4 style="margin-top:20px">No of people: '.$uh_no_of_people.'</h4>
                                        <input type="hidden" value="'.$uh_history_id.'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }

                    ?>
                </div>
                <div class="tab_panel2">
                    <?php
                    
                    $query3 = mysqli_query($mysqli, "select a.ACCOMMODATION_ID, a.CHECK_IN, a.CHECK_OUT, a.BOOKING_DATE, b.RATING, b.CM_CONTENT, c.ROOM_NAME from HISTORY a left join COMMENT b on b.ACCOMMODATION_ID = a.ACCOMMODATION_ID left join ACCOMMODATION c on a.ACCOMMODATION_ID = c.ACCOMMODATION_ID where a.ACCOUNT_ID = '".$_COOKIE["user_id"]."' and b.ACCOUNT_ID = '".$_COOKIE["user_id"]."' and a.EVALUATION = 'Y'");
                    
                    while ($row3 = mysqli_fetch_array($query3)) {
                        $h_accommodation_id = $row3["ACCOMMODATION_ID"];
                        $h_check_in = $row3["CHECK_IN"];
                        $h_check_out = $row3["CHECK_OUT"];
                        $h_booking_date = $row3["BOOKING_DATE"];
                        $h_rating = number_format($row3["RATING"],1);
                        $h_cm_content = $row3["CM_CONTENT"];
                        $h_room_name = $row3["ROOM_NAME"];
                        
                        echo'
                        <div class="card card_list">
                            <div class="container">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="images/rooms/'.$h_accommodation_id.'/'.$h_accommodation_id.'-1.jpg" class="history_img">
                                    </div>
                                    <div class="col-8">
                                        <h3 style="display: inline-block">'.$h_room_name.'</h3>
                                        <h2 style="position:absolute;right:10px;display:inline-block">Rating <span style="color:red">'.$h_rating.'</span></h2>
                                        <h4 style="margin-top:20px">Booking date: '.$h_booking_date.'</h4>
                                        <h4 style="margin-top:20px;display:inline-block">Check in: '.$h_check_in.'</h4>
                                        <h4 style="margin-top:20px;display:inline-block;margin-left:20px">Check out: '.$h_check_out.'</h4>
                                        <h4 style="margin-top:20px">Comment:</h4>
                                        <h6>'.$h_cm_content.'</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }

                    ?>
                </div>
            </div>
        </main>
    </div>

    <main id="main" style="margin-top: 150px;">
        <footer class="footer" style="position:fixed;bottom:0;">
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
    <!--<script src="https://apis.google.com/js/api:client.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>-->
    <script src="js/little-widgets.js"></script>
    <!--<script src="js/other-login.js"></script>-->
    <script src="js/splide.min.js"></script>

    <script src="js/tab.js"></script>
    <script src="js/selectize.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/history.js"></script>
    <script>
        
        $('#sex').selectize();
        var sex_select = $('#sex').selectize();
        <?php echo $sex_select; ?>
    </script>

</body>

</html>