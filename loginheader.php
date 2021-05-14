<?php
session_start();
date_default_timezone_set('Asia/Hong_Kong');
    
if(!isset($_SESSION['user_id']))
{   
    header('Location: https://monistic-hotel.com');
}else{
    $user_id = $_SESSION["user_id"];
    $img_url = $_SESSION["img_url"];
}
?>
