
float calibVoltValue = 5.110/1024.000; //used to calibrate main volt sense
float calibMainCurrentValue = 5.000/1024.000; //used to calibrate main volt sense
float calibRigCurrentValue = 5.005/1024.000; //used to calibrate main volt sense
float mainVR1 = 78800.0; //used in voltage divider calc for volt sense
float mainVR2 = 14860.0; //used in voltage divider calc for volt sense
int throttle = 0; //used to throttle serial output speed if desired


void setup(){
  Serial.begin(9600);
}

void loop(){
  String requestedValue;
  String junkCollection;
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
