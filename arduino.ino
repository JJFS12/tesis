double temperatura;
double humedad;
String id="80";
void loop() {
HTTPClient http;
WiFiClient client;
String postData;
String Link;
String param;
param=+"&temperatura"+String (temperatura)+"&humedad"+String (humedad);
Link += String ("http://192.168.0.12/tesis/datos2.php?")+id + param;
if(http.begin(client, Link)){
int httpCode = http.GET();
if(httpCode > 0){
  Serial.println(Link);
  }else{
Serial.printf("error");
  }
  }
  http.end();
   delay(5000);
  }
