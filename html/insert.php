<?php

    require './dbcon.php';

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connect Failed: " . $conn->connect_error . "<hr>");
    }
    echo "Connect Successfully" . "<hr>";
    
    $uniqid          = uniqid();
    $sensorTemp      = $_GET['sensorTemp'];
    $fanSpeedPercent = $_GET['fanSpeedPercent'];
    date_default_timezone_set('Asia/Bangkok');
    $stamp  = date("Y-m-d H:i:s");
    $sql    = "INSERT INTO esp8266 (uniqid, sensorTemp, fanSpeedPercent, stamp) VALUES ('".$uniqid."', '".$sensorTemp."', '".$fanSpeedPercent."', '".$stamp."')";
    if($conn->query($sql) == TRUE) {
        echo "Query Successfully" . "<hr>";
    } else {
        echo "Query Failed: " . $sql . $conn->error . "<hr>"; 
    }
    $conn->close();
?>