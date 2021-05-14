<?php

date_default_timezone_set('Asia/Hong_Kong');
$mysqli = mysqli_connect("103.13.51.188", "mon10003_james", "3wp9kBk1kqfd", "mon10003_mh");
mysqli_query($mysqli, 'SET NAMES utf8');

$account = $_GET['account'];

//if(isset($_GET['$account'])) {
    $type = "mh";
    $o_status = 0;
    
    $stmt1 = $mysqli->prepare("select ACCOUNT_ID from ACCOUNT where TYPE =? and ACCOUNT_ID =? and STATUS =?");
    $stmt1->bind_param("ssi", $type, $account, $o_status);
    $stmt1->execute();
    $stmt1->store_result();
    $row_count = $stmt1->num_rows;
    $stmt1->close();

    if ($row_count > 0) {
        $status = 1;
        $stmt2 = $mysqli->prepare("update ACCOUNT set STATUS =? where ACCOUNT_ID =?");
        $stmt2->bind_param("is", $status, $account);
        $stmt2->execute();
        $stmt2->close();
        
    
    }
    
    header("location: https://monistic-hotel.com");

//} 

?>