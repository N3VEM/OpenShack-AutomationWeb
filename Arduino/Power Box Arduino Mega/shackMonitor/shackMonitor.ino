
float calibVoltValue = 5.110/1024.000; //used to calibrate main volt sense
float calibMainCurrentValue = 5.000/1024.000; //used to calibrate main volt sense
float calibRigCurrentValue = 5.005/1024.000; //used to calibrate main volt sense
float mainVR1 = 78800.0; //used in voltage divider calc for volt sense
float mainVR2 = 14860.0; //used in voltage divider calc for volt sense
int throttle = 0; //used to throttle serial output speed if desired
//next chunk for fan stuff
const int fan_control_pin = 9;
int count = 0;
unsigned long start_time;
int rpm;
//temperature sense stuff
int tempPin = A3;


void setup(){
  Serial.begin(9600);
  pinMode(fan_control_pin,OUTPUT);
  analogWrite(fan_control_pin, 0);
  attachInterrupt(2, counter, RISING);

}

void loop(){
  String requestedValue;
  String junkCollection;
  int speedValue;
  int value = 1.2;

  while(!Serial.available()){}
  
  junkCollection = Serial.readStringUntil('{');
  requestedValue = Serial.readStringUntil('}');
  
  if(requestedValue == "mainCurrent"){
    sendResponseNum(requestedValue, getMainCurrent());
  }
  else if (requestedValue == "rigCurrent"){
    sendResponseNum(requestedValue, getRigCurrent());
  }
  else if (requestedValue == "mainVoltage"){
    sendResponseNum(requestedValue, getMainVoltage());
  }
  else if (requestedValue == "fanCycle"){
    fanCycle();
  }
  else if (requestedValue.startsWith("setFan:")){
    speedValue = requestedValue.substring(7).toInt();
    sendResponseNum("setFan",setFanSpeed(speedValue));
  }
  else if (requestedValue == "boxTemp"){
    sendResponseNum(requestedValue, getBoxTemp());
  }
  else if (requestedValue == "boxTempF"){
    sendResponseNum(requestedValue, getBoxTempF());
  }  
}

void sendResponseNum(String valueType, float value){
  Serial.print("{\"");
  Serial.print(valueType);
  Serial.print("\":");
  Serial.print(value);
  Serial.println("}");
  Serial.flush();
}

void sendResponseText(String valueType, String value){
  Serial.print("{\"");
  Serial.print(valueType);
  Serial.print("\":\"");
  Serial.print(value);
  Serial.println("\"}");
  Serial.flush();
}

float getMainCurrent(){
  int mainCurrentSensorValue = analogRead(A0);
  float mainCurrentSensorVoltage = mainCurrentSensorValue * calibMainCurrentValue;
  float mainCurrent = ((2.5 - mainCurrentSensorVoltage)/2)*100;
  return mainCurrent;
}

float getRigCurrent(){
  int rigCurrentSensorValue = analogRead(A2);
  float rigCurrentSensorVoltage = rigCurrentSensorValue * calibRigCurrentValue;
  float rigCurrent = -((2.5 - rigCurrentSensorVoltage)/2)*100;
  return rigCurrent;
}

float getMainVoltage(){
  int mainVoltageSensorValue = analogRead(A1);
  float mainVoltageSensorVoltage = mainVoltageSensorValue * calibVoltValue;
  float mainVoltage = mainVoltageSensorVoltage / (mainVR2/(mainVR1+mainVR2));
  return mainVoltage;
  
}

void fanCycle(){
 for(int pwm = 0; pwm <=255; pwm+=51){
   analogWrite(fan_control_pin,pwm);
   delay(5000);
   start_time = millis();
   count = 0;
   while((millis() - start_time) < 1000){
   }
   rpm = count +30;
   Serial.print(map(pwm,0,255,0,100));
   Serial.print(" ");
   Serial.println(rpm);
 } 
 analogWrite(fan_control_pin,0);
}

float setFanSpeed(int pct){
  int pwmValue;
  pwmValue = pct*2.55;
  analogWrite(fan_control_pin,pwmValue);
  return pct;
}

void counter(){
  count++;
}

float getBoxTemp(){
  int boxTempSenseValue = analogRead(tempPin);
  float voltage = boxTempSenseValue * 5.0;
  voltage /= 1024.0;
  float tempC = (voltage - 0.5)*100;
  
  return tempC;
}

float getBoxTempF(){
  float C = getBoxTemp();
  float F = (C * 9/5) + 32;
  
  return F;
}
