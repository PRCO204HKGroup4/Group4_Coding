<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $history_id = $_POST["history_id"];
    $comment = $_POST["comment"];
    $rating = $_POST["rating"];
}

$stmt1 = $mysqli->prepare("select ACCOMMODATION_ID from HISTORY where HISTORY_ID =?");
$stmt1->bind_param("s", $history_id);
$stmt1->execute();
$stmt1->bind_result($accommodation_id);
$stmt1->fetch();
$stmt1->close();

$comment_id = hash('SHA256', "c".date('YmdHis'));
$stmt2 = $mysqli->prepare("insert into COMMENT (COMMENT_ID, ACCOUNT_ID, CM_CONTENT, RATING, HISTORY_ID, ACCOMMODATION_ID) values (?, ?, ?, ?, ?, ?)");
$stmt2->bind_param("sssiss", $comment_id, $_COOKIE["user_id"], $comment, $rating, $history_id, $accommodation_id);
$stmt2->execute();
$stmt2->close();

$evaluation = 'Y';
$stmt3 = $mysqli->prepare("update HISTORY set EVALUATION =? where HISTORY_ID =?");
$stmt3->bind_param("ss", $evaluation, $history_id);
$stmt3->execute();
$stmt3->close();

?>