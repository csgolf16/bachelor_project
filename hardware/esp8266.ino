#include <OneWire.h>
#include <DallasTemperature.h>
#define ONE_WIRE_BUS 12
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

#define DC_FAN 13
int dutyCycle = 0;

#define BUZZER 14

#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x3F, 16, 2);

#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecureAxTLS.h> 
ESP8266WiFiMulti WiFiMulti;
const char* wifiSSID = "AndroidAPA";
const char* wifiPassword = "root_password";
const char* tokenLINE = "d9rG7ZVo1oud8LTkRZFBKwZNzZy46CUmDyl1k6GbVeP";
int readyAlert = 0;

void setup() {
  sensors.begin();
  
  pinMode(DC_FAN, OUTPUT);
  analogWriteRange(100);
  analogWriteFreq(10000);

  pinMode(BUZZER, OUTPUT);
  digitalWrite(BUZZER, HIGH);

  Serial.begin(9600);
  Serial.println();
  for (uint8_t t = 4; t > 0; t--) {
    Serial.printf("[SETUP] WAIT %d...\n", t);
    Serial.flush();
    delay(1000);
  }
  
  lcd.begin();
  lcd.backlight();
  lcd.clear();
  
  WiFiMulti.addAP(wifiSSID, wifiPassword);
  Serial.print("ConnectingToWiFi");
  Serial.print(wifiSSID);
  lcd.setCursor(0, 0);
  lcd.print("ConnectingToWiFi");
  lcd.setCursor(0, 1);
  lcd.print(wifiSSID);
  for (int i = 0; i <= 60; i++) {
    if (WiFiMulti.run() == WL_CONNECTED) {
      lcd.clear();
      lcd.setCursor(0, 0);
      Serial.println("WiFiConnected"); 
      lcd.print("WiFiConnected"); 
      delay(1000);
      break;
    } else if (i == 60) {
      lcd.clear();
      lcd.setCursor(0, 0);
      Serial.println("WiFiDisconnected");
      lcd.println("WiFiDisconnected");
      delay(1000);
      break; 
    }
    delay(1000);
  }
  randomSeed(50);
  
  lcd.clear();
}

void loop() {
  Serial.println();
  
  sensors.requestTemperatures();
  float sensorTemp = sensors.getTempCByIndex(0);
  
  float fanSpeedPercent;
  if (sensorTemp >= 2 && sensorTemp <= 8) {
    fanSpeedPercent = map(sensorTemp, 2, 8, 50, 100);
  } else if (sensorTemp > 8) {
    fanSpeedPercent = 100;
  }
  analogWrite(DC_FAN, fanSpeedPercent);

  Serial.print("TEMP (*C): ");  
  Serial.println(sensorTemp);
  Serial.print("SPEED (%):");
  Serial.println(fanSpeedPercent);
  lcd.setCursor(0, 0);
  lcd.print("TEMP (*C): ");  
  lcd.println(sensorTemp);
  lcd.setCursor(0, 1);
  lcd.print("SPEED (%):");
  lcd.println(fanSpeedPercent);

  if (sensorTemp == -127) {
    digitalWrite(BUZZER, LOW);
    LINENotify("Have problem with DS18B20 sensor, Please check the circuit");
    Serial.println("LINENotify: Have problem with DS18B20 sensor, Please check the circuit");
  } else {
    digitalWrite(BUZZER, HIGH);
  }
  if (sensorTemp <= 7.5 && readyAlert == 0) {
    readyAlert = 1;
    LINENotify("The temperature is already ready for use (temperature < 8 *C)");
    Serial.println("LINENotify: The temperature is already ready for use (temperature < 8 *C)");
  }
  if (sensorTemp > 8.5 && readyAlert == 1) {
    readyAlert = 0;
    digitalWrite(BUZZER, LOW);
    LINENotify("The temperature is not within the specified range (temperature > 8 *C), Please check the circuit");
    Serial.println("LINENotify: The temperature is not within the specified range (temperature > 8 *C), Please check the circuit");
  } else {
    digitalWrite(BUZZER, HIGH);
  }

  ESP8266Cloud(sensorTemp, fanSpeedPercent);
  
  delay(1000);
}

void LINENotify(String message) {
  axTLS::WiFiClientSecure client;
  if (!client.connect("notify-api.line.me", 443)) {
    Serial.println("LINENotifyDisConnected");
    return;   
  } else {
    Serial.println("LINENotifyConnected");
  }
  String req = "";
  req += "POST /api/notify HTTP/1.1\r\n";
  req += "Host: notify-api.line.me\r\n";
  req += "Authorization: Bearer " + String(tokenLINE) + "\r\n";
  req += "Cache-Control: no-cache\r\n";
  req += "User-Agent: ESP8266\r\n";
  req += "Connection: close\r\n";
  req += "Content-Type: application/x-www-form-urlencoded\r\n";
  req += "Content-Length: " + String(String("message=" + message).length()) + "\r\n";
  req += "\r\n";
  req += "message=" + message;
  Serial.println(req);
  client.print(req);
  delay(50);
  while(client.connected()) {
    String line = client.readStringUntil('\n');
    if (line == "\r") {
      break;
    }
    Serial.println(line);
  }
}

void ESP8266Cloud(float sensorTemp, float fanSpeedPercent) {
  HTTPClient http;
  String url = "http://rfs-monitoring.000webhostapp.com/insert.php?sensorTemp="+String(sensorTemp)+"&fanSpeedPercent="+String(fanSpeedPercent);
  Serial.println(url);
  http.begin(url);
  int httpCode = http.GET();
  if (httpCode > 0) {
    Serial.printf("[HTTP] GET... code: %d\n", httpCode);
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println(payload);
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  http.end();
}
