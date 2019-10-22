<br>

<table class="table table-bordered" width="400px">
    <thead>
        <tr>
            <th>sensorTemp</th>
            <th>fanSpeedPercent</th>
            <th>time</th>
        </tr>
    </thead>
    <?php 
        $i = 1; 
        while($row = mysqli_fetch_array($result)) {
            if($i == 1) {
                echo "<tr class='success'>";
                    echo "<td>" . number_format($row['sensorTemp'],2) . "</td>";
                    echo "<td>" . number_format($row['fanSpeedPercent'],2) . "</td>";
                    echo "<td>" . $row['time'] . "</td>"; 
                echo "</tr>";
            } else {
                echo "<tr>";
                    echo "<td>" . number_format($row['sensorTemp'],2) . "</td>";
                    echo "<td>" . number_format($row['fanSpeedPercent'],2) . "</td>";
                    echo "<td>" . $row['time'] . "</td>"; 
                echo "</tr>";
            }
            $i += 1;
        }
        $conn->close();
    ?>
</table>