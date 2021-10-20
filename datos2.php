
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
    echo $res[0];
    }
    $cadena=explode(",", $readings);
    for ($i=0; $i <count($cadena) ; $i++) { 
        $temp= $cadena[$i];
        //echo $temp;


    }
    
    if (!empty($_GET[$temp])) {
        echo "hols";
        $query="INSERT INTO $name ($readings,link) VALUES (" ;
        for($i=0; $i<count($cadena) ;$i=$i+1){$query .= "$_GET[$temp],"  ;} $query .= " $id); ";
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
                    for ($i=0; $i < 4; $i++) { 
                        echo "<th class=text-center>".$res[$i]."<br>"."</th>";
                        //echo "<br>";
                    }
                    //echo "<br>";
                echo "</tr>";
            }
    echo "<table>";

    $conn->close();

    include 'inc/footer.php';

?>

