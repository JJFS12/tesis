<?php
$file_handle = fopen('arduino.ino', 'a+');
fwrite($file_handle, '#include <Orion.h> ');
fwrite($file_handle, "\n");
fwrite($file_handle, '#include <SoftwareSerial.h>');
fwrite($file_handle, "\n");
fwrite($file_handle, 'Orion orion;  ');
fwrite($file_handle, "\n");
fwrite($file_handle, '#define port      "1026" ');
fwrite($file_handle, "\n");
fwrite($file_handle, '#define server    "170.84.209.242"');
fwrite($file_handle, "\n");
fwrite($file_handle, '#define id        "PUCV"
#define type      "clase_iot"
#define attribute1 "Grupo8"
#define attribute2 "humedad"');
fwrite($file_handle, "\n");
fwrite($file_handle, 'void setup() {
  orion.Conectar(server, port);
  orion.Post(id,type,attribute1,attribute2,"0","0");
}');
fwrite($file_handle, "\n");
fwrite($file_handle, 'void loop() {

  orion.Conectar(server, port);
  orion.Put(id, type, attribute1, tempconver);
  delay(1000);
  orion.Put(id, type, attribute2, humyconver);

}
');
fclose($file_handle);

if(isset($_GET['path']))
{
//Read the url
$url = $_GET['path'];

//Clear the cache
clearstatcache();

//Check the file path exists or not
if(file_exists($url)) {

//Define header information
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($url).'"');
header('Content-Length: ' . filesize($url));
header('Pragma: public');

//Clear system output buffer
flush();

//Read the size of the file
readfile($url,true);

//Terminate from the script
die();
}
else{
echo "File path does not exist.";
}
}
echo "File path is not defined.";

?>
