<?php
  include 'inc/header.php';
 
  $id=$_GET['id'];
  $lec=$_GET['readings'];
  $name=$_GET['name'];
 ?>

<?php


   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "db_admin";
   
   $cadena=explode(",", $lec);
   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
       die("Database Connection failed: " . $conn->connect_error);
   }

   $result = mysqli_query($conn, "SELECT *FROM  $name ");
   $chart_data = '';
while($row = mysqli_fetch_array($result))
{

 //$chart_data .= "{ year:'".$row["cur_time"]."', temperatura:".$row["temperatura"].", humedad:".$row["humedad"]."},";
 $chart_data .= "{ year:'".$row["cur_time"]."' ";
  for ($i=0; $i <count($cadena) ; $i++) { 
      $temp2=$cadena[$i];

      $chart_data .=", $temp2:".$row[$temp2]." ";
      
     }
 $chart_data.="},";

}
$chart_data = substr($chart_data, 0, -1);

?>


<!DOCTYPE html>
<html>
 <head>
  <title>chart with PHP & Mysql | lisenme.com </title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 align="center"><?php echo $lec; ?></h2>
   <h3 align="center">Char</h3>   
   <br /><br />
   <div id="chart"></div>
  </div>
 </body>
</html>

<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:[<?php $cadena=explode(",", $lec);
        $nueva="";
        for ($i=0; $i < count($cadena); $i++) { 
          $nueva.="'";
          $nueva.=$cadena[$i];
          $nueva.="'";
          $nueva.=",";
          
        }
        $nueva = substr($nueva, 0, -1);
        echo $nueva?>],
 labels:[<?php $cadena=explode(",", $lec);
        $nueva="";
        for ($i=0; $i < count($cadena); $i++) { 
          $nueva.="'";
          $nueva.=$cadena[$i];
          $nueva.="'";
          $nueva.=",";
          
        }
        $nueva = substr($nueva, 0, -1);
        echo $nueva?>],
 hideHover:'auto',
 stacked:true
});
</script>

<?php
  include 'inc/footer.php';

?>
