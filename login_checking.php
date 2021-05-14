<?php
 
if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: https://monistic-hotel.com');
    exit;
}

session_start();
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $img_url = $_POST["img_url"];
        $given_name = $_POST["given_name"];
        $surname = $_POST["surname"];
        //$token = $_POST["token"];

        if (strpos($img_url, 'google') !== false) {
            $type = "go";
            
        } elseif (strpos($img_url, 'facebook') !== false) {
            $type = "fb";
        }
        $user_id = $type.$id;
    } else {
        $password = $_POST["password"];
        $type = "mh";
    }
}

if ($type == "fb" || $type == "go") {
    $stmt1 = $mysqli->prepare("select ACCOUNT_ID from ACCOUNT where ACCOUNT_ID = ?");
    $stmt1->bind_param("s", $user_id);
    $stmt1->execute();
    $stmt1->store_result();
    $row_count = $stmt1->num_rows;
    $stmt1->bind_result($account_id);
    $stmt1->fetch();
    $stmt1->close();

    if ($row_count == 0) {
        $status = 1;
        $stmt2 = $mysqli->prepare("insert into ACCOUNT (TYPE, SURNAME, GIVEN_NAME, EMAIL, IMG_URL, DOB, ACCOUNT_ID, STATUS) values (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("sssssssi", $type, $surname, $given_name, $email, $img_url, $birthday, $account_id, $status);
        $stmt2->execute();
        $stmt2->close();
    }
    echo "OS";
    
    setcookie("user_id", $account_id, time() + (86400 * 30));
    setcookie("type", $type, time() + (86400 *30));
    
} elseif ($type == "mh") {
    $stmt1 = $mysqli->prepare("select ACCOUNT_ID from ACCOUNT where EMAIL =? and TYPE =?");
    $stmt1->bind_param("ss", $email, $type);
    $stmt1->execute();
    $stmt1->store_result();
    $row_count1 = $stmt1->num_rows;
    $stmt1->close();
    
    if ($row_count1 == 0) {
        echo "OA";
    } else {
        $encrypt_password = hash('SHA256', $password);
        
        $stmt2 = $mysqli->prepare("select ACCOUNT_ID, STATUS, PASSWORD from ACCOUNT where EMAIL =? and TYPE =?");
        $stmt2->bind_param("ss", $email, $type);
        $stmt2->execute();
        $stmt2->bind_result($account_id, $status, $account_password);
        $stmt2->fetch();
        $stmt2->close();

        if ($encrypt_password != $account_password) {
            echo "OP";
        } else {
            if ($status == 0) {
                echo "OB";
            } else {
                echo "OS";
                
                setcookie("user_id", $account_id, time() + (86400 * 30));
                setcookie("type", $type, time() + (86400 *30));
            }
        }
    }

}

?>