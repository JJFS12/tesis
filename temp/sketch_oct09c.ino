#include <dht.h>

dht DHT;

#define DHT11_PIN 7

void setup(){
  Serial.begin(9600);
}

void loop(){
  int chk = DHT.read11(DHT11_PIN);
  Serial.print("Temperature = ");
  Serial.println(DHT.temperature);
  Serial.print("Humidity = ");
  Serial.println(DHT.humidity);
  delay(1000);
}
double ;
String id="";
void loop() {
HTTPClient http;
WiFiClient client;
String postData;
String Link;
String param;
param=+"&"+String ();
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

