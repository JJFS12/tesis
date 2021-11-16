
<?php
include 'inc/header.php';
//$id=htmlspecialchars ($_POST["datos2"]);
$id=$_GET["id"];
//echo $id;
//Creates new record as per request
    //Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_admin";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    $result = mysqli_query($conn, "SELECT name, readings FROM tbl_device WHERE id=$id");
    while($res = mysqli_fetch_array($result))

    {
        $name = $res['name'];
        $readings = $res['readings'];  
    }
    $cadena=explode(",", $readings);
    for ($i=0; $i <count($cadena) ; $i++) { 
        $temp2=$cadena[$i];
    }

    if (!empty($_GET[$temp2])) {
        
        $query="INSERT INTO $name ($readings,link,cur_time) VALUES (" ;
        for($i=0; $i<count($cadena) ;$i=$i+1){ $temp=$cadena[$i];$query .= "$_GET[$temp],"  ; } $query .= " $id,NOW()); ";
        echo $query;
        if($conn->query($query) === TRUE){
            echo "OK";
        }else{
            echo "error";
        }
    }

    $query = mysqli_query($conn,"SHOW COLUMNS FROM $name");
    echo "<table id=example class=table table-striped table-bordered style=width:100%>";
        echo "<thead>";
            echo "<tr>";
            while($res = mysqli_fetch_array($query ))
            {

                echo "<th  class=text-center>".$res[0]."</th>";
            }

                
            echo "</tr>";
        echo "</thead>";
    echo "<tr>";
        $result = mysqli_query($conn, "SELECT * FROM  $name");
            while($res = mysqli_fetch_array($result))
            {
                    for ($i=0; $i < 5; $i++) { 
                        echo "<th class=text-center>".$res[$i]."<br>"."</th>";
                        //echo "<br>";
                    }
                    //echo "<br>";
                echo "</tr>";
            }
    echo "<table>";

      $result = mysqli_query($conn, "SELECT * FROM device");
      if($result){
         $rowcount=mysqli_num_rows($result);
      }
      $cad= " {\n  \"description\": \"Suscripcion $name\",\n  \"subject\": {\n    \"entities\": [\n      {\n        \"idPattern\": \".*\",\n        \"type\": \"$name\"\n      }\n    ],\n    \"condition\": {\n      \"attrs\": [\n ";
      for ($i=0; $i < count($cadena); $i++) { 
        $temp=$cadena[$i];
        $cad.="\"$cadena[$i]\",";
      }
      $cad= substr_replace($cad,"",-1);

      $cad.="]\n    }\n  },\n  \"notification\": {\n    \"attrs\": [\n      \"id\",\n  ";
        for ($i=0; $i < count($cadena) ; $i++) { 
            $temp=$cadena[$i];
            $cad.="\"$cadena[$i]\",";
        }
        $cad= substr_replace($cad,"",-1);
        $cad.="],\n    \"http\": {\n      \"url\": \"http:\/\/192.168.0.12:8668/v2\/notify\"\n    }\n  },\n  \"throttling\": 0\n}";
        echo $cad;

        $url = "http://192.168.0.12:1026/v2/subscriptions";
        $headers = array('Content-Type: application/json');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $cad);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
        echo 'Error:' . curl_error($curl); die;
        }
        curl_close($curl);
        $result = mysqli_query($conn, "SELECT * FROM device");
        $contador=0;
        while($res = mysqli_fetch_array($result)){
            $id=$res['id'];
            $payload = "{\"id\":\"$name\",\"type\":\"$name\"";
            
            if ($contador==0) {
                $contador=1;
                for ($i=0; $i <count($cadena) ; $i++) {
                    $temp=$cadena[$i];
                  $payload.=",\"$cadena[$i]\":{\"value\":$res[$temp],\"type\":\"Number\",\"metadata\":{}}";
                }
                $payload.="}";
                //echo $payload;
              $url = "http://192.168.0.12:1026/v2/entities";
              $headers = array('Content-Type: application/json');
              $curl = curl_init();
              curl_setopt($curl, CURLOPT_URL, $url);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
              curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
              $response = curl_exec($curl);
              if (curl_errno($curl)) {
              echo 'Error:' . curl_error($curl); die;
              }
              curl_close($curl);
            }else{
                for ($i=0; $i < count($cadena); $i++) { 
                    $pay="{ \"$cadena[$i]\": { \"value\": $res[$temp], \"type\": \"Number\" },";
                }
                $pay= substr_replace($pay,"",-1);
                $pay.="}";
                $url = "http://192.168.0.12:1026/v2/entities/$name/attrs";
                $headers = array('Content-Type: application/json');
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $pay);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($curl);
                curl_close($curl);
            }
        }
          $conn->close();





    include 'inc/footer.php';

?>

