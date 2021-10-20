
<?php
include 'inc/header.php';

Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}

$id=$_GET["id"];
$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);
?>
<?php
 echo $_GET['temperatura'];
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

    $result = mysqli_query($conn, "SELECT name FROM tbl_device WHERE id=$id");

    while($res = mysqli_fetch_array($result))

    {

    $name = $res['name'];
    
    }
    //you can display more row data by id
    $result = mysqli_query($conn, "SHOW COLUMNS FROM $name FROM $dbname");
    while($row = mysqli_fetch_array($result)){

        $row['Field']."<br>";
    }
   
    
	$conn->close();
?>



<?php
include 'inc/footer.php';

?>
