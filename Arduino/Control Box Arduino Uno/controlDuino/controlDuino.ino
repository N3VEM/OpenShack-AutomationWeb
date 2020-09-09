/*---------global variables-------------------------------------------------------------*/

  //variables for definining pinds
  int vuPowerPin = 6; //for overall power to VU meter control boards
  int vuOneLight = 2; //HF rig
  int vuTwoLight = 3; //go kit rig
  int vuThreeLight = 4; //shack box
  int vuFourLight = 5; //laptop
  int deskLight = 12; //desk lights (under montiors)
  int taskLight = 13; //task lights (above monitors)
  
  //variables for use with serial reading
  String incomingCommand = "";
  bool statusChange = false;
  
  //variables for VU meter lighting & timing
  int vuOneMaxCycles = 1000; //used to set maxhold light on for iterations of main loop
  int vuOneCycleCount = vuOneMaxCycles;  
  double vuOneSenseThreshold = 40; //set level for vuOne where counter tics down
  double vuOneSense = vuOneSenseThreshold + 10; //value of meter deflection

  int vuTwoMaxCycles = 1000; //used to set maxhold light on for iterations of main loop
  int vuTwoCycleCount = vuTwoMaxCycles;
  double vuTwoSenseThreshold = 40; //set level for vuOne where counter tics down
  double vuTwoSense = vuTwoSenseThreshold + 10; //value of meter deflection

  int vuThreeMaxCycles = 1000; //used to set maxhold light on for iterations of main loop
  int vuThreeCycleCount = vuThreeMaxCycles;
  double vuThreeSenseThreshold = 5; //set level for vuOne where counter tics down
  double vuThreeSense = vuThreeSenseThreshold + 10; //value of meter deflection

  int vuFourMaxCycles = 1000; //used to set maxhold light on for iterations of main loop
  int vuFourCycleCount = vuFourMaxCycles;
  double vuFourSenseThreshold = 10; //set level for vuOne where counter tics down
  double vuFourSense = vuFourSenseThreshold + 10; //value of meter deflection
  
/*--------setup stuff-----------------------------------------------------------------*/
void setup() {

  for (int i = 2; i<=13; i++){
    pinMode(i, OUTPUT);
    digitalWrite(i, HIGH);
  }

  delay(5000); //delay time allows capacitors in meters to discharge if they had been on prior to rebooting card
  
  powerVuMetersOn();

  Serial.begin(9600);
  Serial.flush();

}

/*--------main loop------------------------------------------------------------------*/
void loop() {

//--check serial for incoming commands--
  if (Serial.available() > 0) {
    // read the incoming byte:
    incomingCommand = Serial.readString();
    incomingCommand.trim();
    statusChange = true;

    // say what you got:
    Serial.println("{\"command received\":\""+incomingCommand+"\"}");
  }  

//--actions here based on serial input--
  if(statusChange){
    if(incomingCommand.equals("vu off") ){
      powerVuMetersOff();
      Serial.println("{\"response\":\"vu meters off\"}");
    }
  else if(incomingCommand.equals("vu on") ){
      powerVuMetersOn();
      Serial.println("{\"response\":\"vu meters on\"}");      
    }
  else if(incomingCommand.equals("desk lights on") ){
      lightOn(deskLight);
      Serial.println("{\"response\":\"desk lights on\"}");      
    }
  else if(incomingCommand.equals("desk lights off") ){
      lightOff(deskLight);
      Serial.println("{\"response\":\"desk lights off\"}");      
    }
  else if(incomingCommand.equals("task lights on") ){
      lightOn(taskLight);
      Serial.println("{\"response\":\"task lights on\"}");      
    }
  else if(incomingCommand.equals("task lights off") ){
      lightOff(taskLight);
      Serial.println("{\"response\":\"desk lights off\"}");      
    }
  else if(incomingCommand.equals("clickclack") ){
      Serial.println("{\"response\":\"cycling relays\"}");
      clickityclackity();
    }
  else{
      Serial.println("{\"response\":\"unknown command\"}");
  }
  statusChange = false;
  }

//--Read sensors to collect inputs--
  
  vuOneSense = analogRead(0);
  vuTwoSense = analogRead(1);
  vuThreeSense = analogRead(2);
  vuFourSense = analogRead(3);
  delay(10);
  
//--actions here based on sensor data--
  vuMeterLighting(vuOneSense, vuOneSenseThreshold, vuOneMaxCycles, vuOneCycleCount, vuOneLight);
  vuMeterLighting(vuTwoSense, vuTwoSenseThreshold, vuTwoMaxCycles, vuTwoCycleCount, vuTwoLight);
  vuMeterLighting(vuThreeSense, vuThreeSenseThreshold, vuThreeMaxCycles, vuThreeCycleCount, vuThreeLight);
  vuMeterLighting(vuFourSense, vuFourSenseThreshold, vuFourMaxCycles, vuFourCycleCount, vuFourLight);

}


/*------functions-------------------------------------------------------------------*/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void powerVuMetersOn(){
  digitalWrite(vuPowerPin, LOW);

  //setting all to max timeout when powering up, for initial hold
  vuOneCycleCount = vuOneMaxCycles;
  vuTwoCycleCount = vuTwoMaxCycles;
  vuThreeCycleCount = vuThreeMaxCycles;
  vuFourCycleCount = vuFourMaxCycles;

  //this is completely unecesary, but its fun to watch the lights blink when powering up
  for (int i = 0; i<3; i++){
    delay(100);
    VuLightOn(vuOneLight);
    delay(100);
    VuLightOff(vuOneLight);
    VuLightOn(vuTwoLight);
    delay(100);
    VuLightOff(vuTwoLight);
    VuLightOn(vuThreeLight);
    delay(100);
    VuLightOff(vuThreeLight);
    VuLightOn(vuFourLight);
    delay(100);
    VuLightOff(vuFourLight);
    VuLightOn(vuThreeLight);
    delay(100);
    VuLightOff(vuThreeLight);
    VuLightOn(vuTwoLight);
    delay(100);
    VuLightOff(vuTwoLight);
  }

  //this is technically all that I really need, to just turn them on in sequence
  VuLightOn(vuOneLight);
  delay(100);
  VuLightOn(vuTwoLight);
  delay(100);
  VuLightOn(vuThreeLight);
  delay(100);
  VuLightOn(vuFourLight);
  delay(100);

}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void powerVuMetersOff(){
  digitalWrite(vuPowerPin, HIGH);
  delay(5000); //it takes about 5 secnods for capicitors in meters to discharge
}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void VuLightOn(int lightPin){
  digitalWrite(lightPin, LOW);
}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void VuLightOff(int lightPin){
  digitalWrite(lightPin, HIGH);
}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void lightOn(int lightPin){
  digitalWrite(lightPin, LOW);
}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void lightOff(int lightPin){
  digitalWrite(lightPin, HIGH);
}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void clickityclackity(){
  delay(3000);
  for (int i = 2; i<=13; i++){
    digitalWrite(i, LOW);
  delay(500);
  }
  for (int i = 2; i<=13; i++){
    digitalWrite(i, HIGH);
  delay(500);
  }
}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
void vuMeterLighting(double vuSense, double vuSenseThreshold, int vuMaxCycles, int& vuCycleCount, int vuLight){
  
  if(vuSense > vuSenseThreshold){
    vuCycleCount = vuMaxCycles;
    VuLightOn(vuLight);
  }
  if((vuSense < vuSenseThreshold) && (vuCycleCount > 0)){
    vuCycleCount--;
  }
  if(vuCycleCount == 0){
    VuLightOff(vuLight);  
  }
}
