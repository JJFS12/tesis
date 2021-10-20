
<?php


    if (!empty($_GET['temperatura'])) {
        $temperatura = $_GET[0];
    	$humedad = $_GET[1];
        $data="temperatura".$temperatura."-humedad".$humedad;
        $file="temp.php";
        file_put_contents($file,$data);

    }

?>



