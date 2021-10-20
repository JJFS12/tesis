 #include "ESP8266WiFi.h"
#include "WiFiClient.h"
#include"ESP8266WebServer.h"
#include"ESP8266HTTPClient.h"
const char* ssid = "YOUR SSID NAME";
const char* password = "SSID PASSWORD";
const char *host = "http://192.168.0.12/";
const char *server=  "localhost";
String id=78;
const char type     clase_iot;
#define attribute0=location;
#define attribute1=humedad;
int cont=2;
void setup() {
Serial.begin(115200);
WiFi.begin(ssid, password);
Serial.begin(9600);
Serial.println("test!");
Serial.println("Connecting");
while (WiFi.status() != WL_CONNECTED) {
elay(500);
Serial.print(".");
  }
Serial.println("");
Serial.print("Connected to ");
Serial.println(ssid);
Serial.print("IP address: ");
Serial.println(WiFi.localIP());
  }
void loop() {
HTTPClient http;
WiFiClient client;
String postData;
String Link;
String param;
param="&location"+String (attribute0)"&humedad"+String (attribute1);
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
