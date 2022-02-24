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





<div class="embed-responsive embed-responsive-16by9">
    <iframe class="embed-responsive-item" src="http://192.168.0.12:3003/dashboard/new?orgId=1" allowfullscreen></iframe>
</div>
<?php
  include 'inc/footer.php';

?>
