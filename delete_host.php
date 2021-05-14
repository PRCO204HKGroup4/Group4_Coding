<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

session_start();
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accommodation_id = $_POST["accommodation_id"];
}

$stmt = $mysqli->prepare("delete from ACCOMMODATION where ACCOMMODATION_ID = ?"); 
$stmt->bind_param("s", $accommodation_id);
$stmt->execute();

?>