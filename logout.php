<?php   

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

session_start();

unset($_COOKIE["user_id"]);
setcookie("user_id", null, -1, '/');

exit();
?>