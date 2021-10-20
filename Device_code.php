<?php

use Symfony\Component\Yaml\Yaml;
include 'inc/header.php';
Session::CheckSession();
$i=$_GET['id'];
 ?>


 <div class="card ">
   <div class="card-header">
          <h3>FIWARE Code<span class="float-right"> <a href="index.php" class="btn btn-primary">Back</a> </h3>
        </div>
        <div class="card-body">

    <?php
    $getUinfo = $devices->getDeviceInfoById($i);
    if ($getUinfo) {

     ?>


          <div style="width:600px; margin:0px auto">

          <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].$_SERVER['id='].$i)?>" method="POST">
              <div class="form-group">
                <label for="name">Device name</label>
                <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">readings</label>
                <input type="text" name="readings" value="<?php echo $getUinfo->readings; ?>" class="form-control">
              </div>

              <div class="form-group">
                <label for="username">Orion Context Broker address</label>
                <input type="text" name="OCB" value="<?php echo $getUinfo->ocba; ?>" class="form-control">
              </div>


              <?php
                $c2="";
                $cont=0;
                $content2 = "";
             
                $content2 .= " #include ".'"ESP8266WiFi.h"'."\n";
                $content2 .= "#include ".'"WiFiClient.h"'."\n";
                $content2 .= "#include". '"ESP8266WebServer.h"'."\n";
                $content2 .= "#include". '"ESP8266HTTPClient.h"'."\n";
                $content2 .= 'const char* ssid = "YOUR SSID NAME";'."\n";
                $content2 .= 'const char* password = "SSID PASSWORD";'."\n";
                $content2 .= 'const char *host = "http://192.168.0.12/";'."\n";
                $content2 .= "const char *server=  ".'"'.$getUinfo->ocba.'"'.";"."\n";
                $content2 .= "String id=".$i.";"."\n";
                $content2 .= "const char type     clase_iot;"."\n";
                $n=explode(",",$getUinfo->readings);
                for ($i=0; $i < count($n) ; $i++) { 
                  $content2 .= "#define attribute".$i."=".$n[$i].";"."\n";
                  $cont+=1;
                }
                $content2 .= "int cont=".$cont.";"."\n";
                $content2 .= "void setup() {"."\n";
                  $content2 .= "Serial.begin(115200);"."\n";
                  $content2 .= "WiFi.begin(ssid, password);"."\n";
                  $content2 .= "Serial.begin(9600);"."\n";
                  $content2 .= 'Serial.println("test!");'."\n";
                  $content2 .= 'Serial.println("Connecting");'."\n";
                  $content2 .= 'while (WiFi.status() != WL_CONNECTED) {'."\n";
                    $content2 .= "elay(500);"."\n";
                    $content2 .= 'Serial.print(".");'."\n";
                  $content2 .= "  }"."\n";
                  $content2 .= 'Serial.println("");'."\n";
                  $content2 .= 'Serial.print("Connected to ");'."\n";
                  $content2 .= 'Serial.println(ssid);'."\n";
                  $content2 .= 'Serial.print("IP address: ");'."\n";
                  $content2 .= 'Serial.println(WiFi.localIP());'."\n";
                $content2 .= "  }"."\n";
                $content2 .= "void loop() {"."\n";
                  $content2 .= "HTTPClient http;"."\n";
                  $content2 .= "WiFiClient client;"."\n";
                  $content2 .= "String postData;"."\n";
                  $content2 .= "String Link;"."\n";
                  $content2 .= "String param;"."\n";
                  for ($i=0; $i < count($n) ; $i++) { 
                    $c2 .= '"'.'&'.$n[$i].'"'."+String (attribute".$i.")";

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
                $file2 = 'arduino.ino';
                error_log("======FILE path ====$file2======");
                file_put_contents($file2, $content2, LOCK_EX);
              ?>
              <div class="form-group">
              <div class="bg-card dark shadow rounded mb-4 p-4 ng-star-inserted">

                <link rel="stylesheet" href="css/style2.css" />
                <div class="header"> FIWARE CONNECTION CODE</div>
                <div class="control-panel">
                  <select id="languages" class="languages" onchange="changeLanguage()">
                              <option value="cpp"> c </option>
                          </select>
                </div>

                <div class="editor" id="editor"> <?php echo file_get_contents( "arduino.ino" ); ?></div>

                <div class="button-container">
                  <button class="btn" onclick="executeCode()"> n </button>
                </div>

                <div class="output"></div>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="lib/ace.js"></script>
                <script src="lib/theme-monokai.js"></script>
                <script src="ide.js"></script>
              </div>
              </div>




              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">submit</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Delete</a>
              </div>
            <?php } elseif(Session::get("roleid") == '2') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">n</button>

              </div>

              <?php   }else{ ?>
                  <div class="form-group">

                    <a class="btn btn-primary" href="index.php">Submit</a>
                  </div>
                <?php } ?>


          </form>
        </div>




      </div>
    </div>


  <?php
  include 'inc/footer.php';

  ?>
