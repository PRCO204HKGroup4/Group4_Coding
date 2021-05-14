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

$stmt = $mysqli->prepare("select ROOM_NAME, ROOM_DESC, RULES, PRICE, MAX_OF_PEOPLE, NO_OF_ROOM, NO_OF_BED, NO_OF_BATHROOM, LOCATION, ROOM_LIVESTYLE, AMENITIES, DISTRICT from ACCOMMODATION where ACCOMMODATION_ID = ?"); 
$stmt->bind_param("s", $accommodation_id);
$stmt->execute();
$stmt->bind_result($room_name, $room_desc, $rules, $price, $max_of_people, $no_of_room, $no_of_bed, $no_of_bathroom, $location, $room_livestyle, $amenities, $district);
$stmt->fetch();

$check_in = substr($rules, 6, 5);
$check_out = substr($rules, 19, 5);

$dir = "images/rooms/".$accommodation_id;
$images =  glob($dir . "/*.jpg");

$room_array = array("room_name"=>$room_name, "room_desc"=>$room_desc, "check_in"=>$check_in, "check_out"=>$check_out, "rules"=>$rules, "price"=>$price, "max_of_people"=>$max_of_people, "no_of_room"=>$no_of_room, "single_bed"=> explode(".",$no_of_bed)[0], "double_bed"=> explode(".",$no_of_bed)[1], "no_of_bathroom"=>$no_of_bathroom, "location"=>$location, "room_livestyle"=>$room_livestyle, "amenities"=>$amenities, "files"=>$images, "district"=>$district);

echo json_encode($room_array);

?>