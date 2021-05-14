<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST["surname"];
    $given_name = $_POST["given_name"];
    $password = $_POST["password"];
    $dob = date("Y-m-d", strtotime($_POST["dob"]));
    $mobile = $_POST["mobile"];
    $sex = $_POST["sex"];
    $account_id = $_COOKIE["user_id"];
    $type = $_COOKIE["type"];
}

if (isset($_FILES["file"])) {
    move_uploaded_file($_FILES["file"]["tmp_name"], "images/users/".$account_id.".jpg");
    $img_url= "https://monistic-hotel.com/images/users/".$account_id.".jpg";
}

if ($type == "mh") {
    if ($password != "" || isset($password)) {
        $encrypt_password = hash('SHA256', $password);
        $stmt = $mysqli->prepare("update ACCOUNT set SURNAME =?, GIVEN_NAME =?, PASSWORD =?, DOB =?, MOBILE =?, SEX =?, IMG_URL =? where ACCOUNT_ID =?");
        $stmt->bind_param("ssssisss", $surname, $given_name, $encrypt_password, $dob, $mobile, $sex, $img_url, $account_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $mysqli->prepare("update ACCOUNT set SURNAME =?, GIVEN_NAME =?, DOB =?, MOBILE =?, SEX =?, IMG_URL =? where ACCOUNT_ID =?");
        $stmt->bind_param("sssisss", $surname, $given_name, $dob, $mobile, $sex, $img_url, $account_id);
        $stmt->execute();
        $stmt->close();
    }
} else {
    $stmt = $mysqli->prepare("update ACCOUNT set SURNAME =?, GIVEN_NAME =?, DOB =?, MOBILE =?, SEX =? where ACCOUNT_ID =?");
    $stmt->bind_param("sssiss", $surname, $given_name, $dob, $mobile, $sex, $account_id);
    $stmt->execute();
    $stmt->close();
}

header("location: ".$_SERVER['HTTP_REFERER']);

?>
