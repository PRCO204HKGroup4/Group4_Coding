<?php

if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $o_room_name = $_POST["o_room_name"];
    $room_name = $_POST["room_name"];
    $room_desc = $_POST["room_desc"];
    $location = $_POST["location"];
    $room_livestyle = $_POST["room_livestyle"];
    $price = intval($_POST["price"]);
    $no_of_room = intval($_POST["no_of_room"]);
    $no_of_bathroom = intval($_POST["no_of_bathroom"]);
    $max_of_people = intval($_POST["max_of_people"]);
    $single_bed = $_POST["single_bed"];
    $double_bed = $_POST["double_bed"];
    $checkin_time = $_POST["checkin_time"];
    $checkout_time = $_POST["checkout_time"];
    $amenities = implode(",", $_POST["amenities"]);
    $account_id = $_COOKIE["user_id"];
    $district = $_POST["district"];
}

$stmt1 = $mysqli->prepare("select ACCOMMODATION_ID from ACCOMMODATION where ROOM_NAME =?");
$stmt1->bind_param("s", $room_name);
$stmt1->execute();
$stmt1->store_result();
$row_count = $stmt1->num_rows;
$stmt1->bind_result($accommodation_id);
$stmt1->fetch();
$stmt1->close();

if ($row_count > 0) {
    $bed = floatval($_POST["double_bed"].".".$_POST["single_bed"]);

    if (!file_exists('images/rooms/'.$accommodation_id)) {
        mkdir('images/rooms/'.$accommodation_id, 0777, true);
    }
    
    $image_count = count($_FILES['image']['name']);
    
    if ($image_count > 1) {
        $files = glob('images/rooms/'.$accommodation_id.'/*');
        foreach($files as $file){ 
            if(is_file($file)) {
                unlink($file);
            }
        }
        
        for ($i = 0; $i < $image_count; $i++) {
            move_uploaded_file($_FILES["image"]["tmp_name"][$i],"images/rooms/".$accommodation_id."/".$accommodation_id."-".$i.".jpg");
        }
    }

    if ($max_of_people > 20) {
        $max_of_people = 20;
    } elseif ($max_of_people < 1) {
        $max_of_people = 1;
    }
    
    $rules = "After ".$checkin_time."-Before ".$checkout_time.",".implode(",", $_POST["rules"]);
    
    echo $rules;
    echo $amenities;
    
    $stmt = $mysqli->prepare("update ACCOMMODATION set ROOM_NAME=?, ROOM_DESC=?, RULES=?, PRICE=?, MAX_OF_PEOPLE=?, NO_OF_ROOM=?, NO_OF_BED=?, NO_OF_BATHROOM=?, LOCATION=?, ROOM_LIVESTYLE=?, AMENITIES=?, DISTRICT=? where ROOM_NAME =?");
    $stmt->bind_param("sssiiidisssss", $room_name, $room_desc, $rules, $price, $max_of_people, $no_of_room, $bed, $no_of_bathroom, $location, $room_livestyle, $amenities, $district, $o_room_name);
    $stmt->execute();
}

header('Location: host');

?>