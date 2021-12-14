<?php
include('config.php');
    $conn =  mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_NAME) or die("Unable to connect to MySQL");

    if (mysqli_real_escape_string($conn,$_POST['temperature']) ==NULL ||mysqli_real_escape_string($conn,$_POST['temperature']) ==NAN){
        $temperature="NULL";
    }else{
        $temperature=mysqli_real_escape_string($conn,$_POST['temperature']);
    }
    if (mysqli_real_escape_string($conn,$_POST['humidity']) ==NULL){
        $humidity="NULL";
    }else{
        $humidity=mysqli_real_escape_string($conn,$_POST['humidity']);
    }
     date_default_timezone_set('Asia/Jakarta');
    $logdate= date("Y-m-d H:i:s");

    $insertSQL="INSERT into ".TB_ENV." (logdate,temperature,humidity) values ('".$logdate."',".$temperature.",".$humidity.")";
    mysqli_query($conn,$insertSQL) or die("INSERT Query has Failed - ".$insertSQL );

?>