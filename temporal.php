<?php
use Symfony\Component\Yaml\Yaml;
include 'inc/header.php';
Session::CheckSession();
$is=$_GET['id']
?>

<html>
  <body> 
    <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id'];?>" method="post" enctype="multipart/form-data">
      
      <input type="file" name="file" size="60" />
      <input type="submit" value="Read Contents" />
    </form>
  </body>
</html>

<?php
if ($_FILES) {
  $is=$_GET['id'];
  $getUinfo = $devices->getDeviceInfoById($is);
    //Checking if file is selected or not
    if ($_FILES['file']['name'] != "") {
  
      /*Checking if the file is plain text or not
      if (isset($_FILES) && $_FILES['file']['type'] != 'text/plain') {
          echo "<span>File could not be accepted ! Please upload any '*.txt' file.</span>";
          exit();
      } 
      */
      echo "<center><span id='Content'>Contents of ".$_FILES['file']['name']." File</span></center>";
    
      //Getting and storing the temporary file name of the uploaded file
      $fileName = $_FILES['file']['tmp_name'];
      $target_dir = "temp/";
	    $file = $_FILES['file']['name'];
	    $path = pathinfo($file);
	    $filename = $path['filename'];
	    $ext = $path['extension'];
	    $temp_name = $_FILES['file']['tmp_name'];
	    $path_filename_ext = $target_dir.$filename.".".$ext;
      echo $path_filename_ext;
      $c2="";
      $cont=0;
      $content2 = "";
      $n=explode(",",$getUinfo->readings);
      for ($i=0; $i < count($n) ; $i++) { 
        $content2 .= "double ".$n[$i].";"."\n";
        $cont+=1;
      }
      $content2 .= 'String id="'.$is.'";'."\n";
      $content2 .= "void loop() {"."\n";
        
        $content2 .= "HTTPClient http;"."\n";
        $content2 .= "WiFiClient client;"."\n";
        
        $content2 .= "String postData;"."\n";
        $content2 .= "String Link;"."\n";
        $content2 .= "String param;"."\n";
        for ($i=0; $i < count($n) ; $i++) { 
          $c2 .= "+".'"'.'&'.$n[$i].'"'."+String ($n[$i])";

        }
        $content2 .= "param=". $c2.";"."\n";
        $content2 .= 'Link += String ("http://192.168.0.12/tesis/datos2.php?")+id + param;'."\n";
        $content2 .= "if(http.begin(client, Link)){"."\n";
          $content2 .= "int httpCode = http.GET();"."\n";
          $content2 .= "if(httpCode > 0){"."\n";
            $content2 .= "  Serial.println(Link);"."\n";
          $content2 .= "  }else{"."\n";
            $content2 .= 'Serial.printf("error");'."\n";
          $content2 .= "  }"."\n";
        $content2 .= "  }"."\n";
        $content2 .= "  http.end();"."\n";
        $content2 .= "   delay(5000);"."\n";
      $content2 .= "  }"."\n";
      error_log("======FILE path ====$fileName======");
      file_put_contents($fileName, $content2.PHP_EOL,  FILE_APPEND | LOCK_EX);


      //Throw an error message if the file could not be open
      $file = fopen($fileName,"r") or exit("Unable to open file!");
      ?>
      <div class="form-group">
              <div class="bg-card dark shadow rounded mb-4 p-4 ng-star-inserted">

                <link rel="stylesheet" href="css/style2.css" />
                <div class="header"> Arduino CODE</div>
                <div class="control-panel">
                  <select id="languages" class="languages" onchange="changeLanguage()">
                              <option value="cpp"> c </option>
                          </select>
                </div>

                <div class="editor" id="editor"> <?php while(!feof($file)) {
        echo fgets($file). "";
      }; ?></div>

                <div class="button-container">
                <button><a href="download.php?path=<?php echo $path_filename_ext;?>"> download</a></button>
                  
                </div>

                <div class="output"></div>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="lib/ace.js"></script>
                <script src="lib/theme-monokai.js"></script>
                <script src="ide.js"></script>
              </div>
              </div>

      <?php
      /*Reading a .txt file character by character
      while(!feof($file)) {
        echo fgetc($file);
      }
      */
      fclose($file);
  } else {
      if (isset($_FILES) && $_FILES['file']['type'] == '')
        echo "<span>Please Choose a file by click on 'Browse' or 'Choose File' button.</span>";
    }
  
 
// Check if file already exists
if (file_exists($path_filename_ext)) {
 echo "";
 }else{
 move_uploaded_file($temp_name,$path_filename_ext);
 echo "";
 }
    
}
?>


<?php
include 'inc/footer.php';

?>
