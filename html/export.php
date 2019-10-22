<?php

    require './dbcon.php';

    if (isset($_POST["export"])) {  
        $connect = mysqli_connect($servername, $username, $password, $database);  
        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename=data.csv');  
        $output = fopen("php://output", "w");  
        fputcsv($output, array('uniqid', 'sensorTemp', 'fanSpeedPercent', 'stamp'));  
        $query = "SELECT * from esp8266 ORDER BY stamp DESC";  
        $result = mysqli_query($connect, $query);  
        while ($row = mysqli_fetch_assoc($result)) {  
            fputcsv($output, $row);  
        }  
        fclose($output);  
    }  
 ?>  