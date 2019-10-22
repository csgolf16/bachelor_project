<?php
    session_start(); 
    if (!isset($_SESSION['login_username'])) {
        header("Location: ./index.php");
    }
    
    require './dbcon.php';

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connect Failed: " . $conn->connect_error . "<hr>");
    }
 
    $sql         = "SELECT sensorTemp AS sensorTemp, fanSpeedPercent AS fanSpeedPercent, DATE_FORMAT(stamp, '%T') AS time FROM esp8266 ORDER BY stamp DESC LIMIT 15";
    $result      = $conn->query($sql);
    $resultchart = $conn->query($sql);

    $sensorTemp      = array();
    $fanSpeedPercent = array();
    $time            = array();
    while($rs = mysqli_fetch_array($resultchart)){ 
        $sensorTemp[]      = "\"".$rs['sensorTemp']."\"";
        $fanSpeedPercent[] = "\"".$rs['fanSpeedPercent']."\"";
        $time[]            = "\"".$rs['time']."\"";  
    }  
    $sensorTemp              = array_reverse($sensorTemp);
    $fanSpeedPercent         = array_reverse($fanSpeedPercent);
    $time                    = array_reverse($time);
    $sensorTempScale         = end($sensorTemp);
    $sensorTempScale         = str_replace("\"", " ", $sensorTempScale);
    $sensorTempScale         = intval(trim($sensorTempScale));
    $sensorTempScaleMin      = intval($sensorTempScale) - 3;
    $sensorTempScaleMax      = intval($sensorTempScale) + 3;
    $fanSpeedPercentScale    = end($fanSpeedPercent);
    $fanSpeedPercentScale    = str_replace("\"", " ", $fanSpeedPercentScale);
    $fanSpeedPercentScale    = intval(trim($fanSpeedPercentScale));
    $fanSpeedPercentScaleMin = intval($fanSpeedPercentScale) - 3;
    $fanSpeedPercentScaleMax = intval($fanSpeedPercentScale) + 3;
    $sensorTemp              = implode(",", $sensorTemp);
    $fanSpeedPercent         = implode(",", $fanSpeedPercent);
    $time                    = implode(",", $time);
    
    date_default_timezone_set('Asia/Bangkok');
    $date  = date("Y-m-d");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="30">
    <title>Monitoring | ESP8266Cloud</title>
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <script src="./public/js/jquery.min.js"></script>
    <script src="./public/js/bootstrap.min.js"></script>
    <script src="./public/js/Chart.bundle.js"></script>
    <style>
        table,
        thead,
        tr,
        tbody,
        th,
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <br>
        <div align="right">
            <?php echo "welcome ".$_SESSION['login_username']." "; ?>
            <a href="dashboard_logout.php" style="color: #FF0000;">logout</a>
            <br>
            <br>
            <form method="POST" action="./export.php" align="right">  
                <input type="submit" name="export" value="CSV Export All" class="btn btn-danger" />  
            </form> 
        </div>
        <hr>
        <h1 align="center">Date: <?php echo "$date"; ?></h1>
        <div class="container">
            <ul class="nav nav-tabs" style="text-align: center;">
                <li class="active"><a data-toggle="tab" href="#chart_tab">Chart Monitor</a></li>
                <li><a data-toggle="tab" href="#table_tab">Table Monitor</a></li>
            </ul>
            <div class="tab-content is_center">
                <div class="tab-pane fade in active" id="chart_tab">
                    <?php require './read_chart.php' ?>
                </div>
                <div class="tab-pane fade" id="table_tab">
                    <?php require './read_table.php' ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
</body>

</html>

<script>
    var ctx1 = document.getElementById("myChart1").getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: [<?php echo $time; ?>],
            datasets: [{
                label: 'Temperature (*C)',
                data: [<?php echo $sensorTemp; ?>],
                backgroundColor: "rgba(0,0,255,0.8)",
                borderColor: "rgba(0,0,255,0.8)",
                fill: false,
                lineTension: 0,
                pointRadius: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: <?php echo $sensorTempScaleMin; ?>,
                        max: <?php echo $sensorTempScaleMax; ?>,
                        stepSize: 2
                    }
                }]
            }
        }
    });

    var ctx2 = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: [<?php echo $time; ?>],
            datasets: [{
                label: 'Fanspeed (%)',
                data: [<?php echo $fanSpeedPercent; ?>],
                backgroundColor: "rgba(0,128,0,1)",
                borderColor: "rgba(0,128,0,1)",
                fill: false,
                lineTension: 0,
                pointRadius: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: <?php echo $fanSpeedPercentScaleMin; ?>,
                        max: <?php echo $fanSpeedPercentScaleMax; ?>,
                        stepSize: 2
                    }
                }]
            }
        }
    });
</script>