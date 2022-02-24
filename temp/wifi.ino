/* DHT Pro Shield - Simple
 *
 * Example testing sketch for various DHT humidity/temperature sensors
 * Written by ladyada, public domain
 *
 * Depends on Adafruit DHT Arduino library
 * https://github.com/adafruit/DHT-sensor-library
 */
#include "ESP8266WiFi.h"
#include "WiFiClient.h" 
#include "ESP8266WebServer.h"
#include "ESP8266HTTPClient.h"
const char* ssid = "IZZI-F506";
const char* password = "%%Mu_12%%.?";
const char *host = "http://192.168.0.16/"; 
const char *server=  "localhost";
int sensorPin = D5; // select the input pin for the potentiometer
double temperatura;
double humedad;
String id="id=82";
double Thermistor(int RawADC) {
  double Temp;
  Temp = log(10000.0*((1024.0/RawADC-1))); 
  Temp = 1 / (0.001129148 + (0.000234125 + (0.0000000876741 * Temp * Temp ))* Temp );
  Temp = Temp - 273.15;            // Convert Kelvin to Celcius
   //Temp = (Temp * 9.0)/ 5.0 + 32.0; // Convert Celcius to Fahrenheit
   return Temp;
}
void setup() {
  Serial.begin(115200);

  WiFi.begin(ssid, password);

  Serial.begin(9600);
  Serial.println("test!");

  Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
 
  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to your ESP

}
void loop() {

int readVal=analogRead(sensorPin);
  double temperatura =  Thermistor(readVal);
 //Serial.println(readVal);  // display tempature
  Serial.println(temperatura);  // display tempature
if (digitalRead(2) == HIGH){
  humedad = 1;
  //Serial.println("Sensor is touched");
}
HTTPClient http;
WiFiClient client;
String postData;
String Link;
String param;
param=+"&temperatura="+String (temperatura)+"&humedad="+String (humedad);
Link += String ("http://192.168.0.16/tesis/datos2.php?")+id + param;
Serial.println(Link);
if(http.begin(client, Link)){
int httpCode = http.GET();
if(httpCode > 0){
  Serial.println(Link);
  }else{
Serial.printf("error");
  }
  }
  http.end();
}