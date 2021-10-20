


<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "temp";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM readings ";

$result = $conn->query($sql);
/*
while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
    $value[] = json_encode(array_reverse(array_column($sensor_data, 'value')), JSON_NUMERIC_CHECK);
}
*/
while($row = $result->fetch_assoc()) {
  echo "EMP ID :{$row['id']}  <br> ".
     "EMP NAME : {$row['temperature']} <br> ".
     "EMP SALARY : {$row['humedad']} <br> ".
     "--------------------------------<br>";
}

// ******* Uncomment to convert readings time array to your timezone ********
/*$i = 0;
foreach ($readings_time as $reading){
    // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
    $readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading - 1 hours"));
    // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
    //$readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading + 4 hours"));
    $i += 1;
}*/

/*
$value1 = json_encode(array_reverse(array_column($sensor_data, 'value1')), JSON_NUMERIC_CHECK);
$value2 = json_encode(array_reverse(array_column($sensor_data, 'value2')), JSON_NUMERIC_CHECK);
$value3 = json_encode(array_reverse(array_column($sensor_data, 'value3')), JSON_NUMERIC_CHECK);
*/
foreach ($value as $stuff) {
  echo $stuff, "\n";
}
for ($i=0; $i < 4; $i++) { 
    echo $value;
}
/*echo $value1;
echo $value2;
echo $value3;
echo $reading_time;*/

$result->free();
$conn->close();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <style>
    body {
      min-width: 310px;
    	max-width: 1280px;
    	height: 500px;
      margin: 0 auto;
    }
    h2 {
      font-family: Arial;
      font-size: 2.5rem;
      text-align: center;
    }
  </style>
  <body>

    <h2>ESP Weather Station</h2>
    <div id="demo"></div>
    <script>
        var x ="", i;
        for (i=0; i<4; i++) {
            x = x + "<div"+ "id=chart"+ + i + ">Heading " + i + "</div>";
        }
        document.getElementById("demo").innerHTML = x;
    </script>
<script>



var reading_time = <?php echo $reading_time; ?>;
for (var i = 0; i < 4; i++) {
    var value[i] = <?php echo $value[i]; ?>;

    var chartH = new Highcharts.Chart({
  chart:{ renderTo:'chart'+=i },
  title: { text: 'BME280 Humidity' },
  series: [{
    showInLegend: false,
    data: value[i]
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    }
  },
  xAxis: {
    title: { text: 'Humidity (%)' }
  },
  yAxis: {
    title: { text: 'Humidity (%)' }
  },
  credits: { enabled: false }
});
}


</script>
</body>
</html>