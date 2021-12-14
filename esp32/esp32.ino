#include <HTTPClient.h>
#include "DHT.h"
#include <WiFi.h>

#define DHTTYPE DHT11
#define DHTPIN 4
#define RETRY_LIMIT  20
DHT dht(DHTPIN, DHTTYPE);
const char* ssid = "myRouter";
const char* password = "myPassword";

void setup()
{
  dht.begin();
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP Address");
  Serial.println(WiFi.localIP());

}

void loop()
{
  int rtl = RETRY_LIMIT;
  float h =  dht.readHumidity();
  float t = dht.readTemperature();

  delay(500);
  while (isnan(t) || isnan(h)) {
    Serial.println("Check sensor again - " + rtl);
    h =  dht.readHumidity();
    t = dht.readTemperature();
    delay(500);
    if (--rtl < 1) {
      ESP.restart();
    }
  }

  HTTPClient http;
  //membuat koneksi dengan server
  http.begin("http://kado.atwebpages.com/iot/upload.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  //format data yang dikirim
  int httpResponseCode = http.POST("temperature=" + String(t) + "&humidity=" + String(h));

  if (httpResponseCode > 0) {
    //cek respon http
    String response = http.getString();
    Serial.println(httpResponseCode);
    Serial.println(response);
  }
  else {
    Serial.print("Error on sending post");
    Serial.println(httpResponseCode);
  }
  //mengakhiri koneki http
  http.end();

  Serial.println("Temp = " + String(t));
  Serial.println("humidity = " + String(h));

  delay(15000);

}
