import serial
import datetime
import time
import N3VEMShackRW as shackConnection
import json

#-----setup-----#

shackCursor = shackConnection.conn.cursor()
lastSample = datetime.datetime.now()
mainVlist = []
mainIlist = []
rigIlist = []
sampleFrequency = 5

#remark the next lines out (or delete them) for the live show
shackCursor.execute("SELECT VERSION()")
version = shackCursor.fetchone()
#print(version[0])

powerMonitorArduino = serial.Serial('/dev/ttyACM1')
time.sleep(1)
powerMonitorArduino.reset_input_buffer()
#print("ready")

#-----Functions---------------------------------------------------#

#-----Serial Reading-----#

def getSensorReadings(sensor):
    sensorRequest = "{"+sensor+"}"
    #print(sensorRequest)
    powerMonitorArduino.write(sensorRequest.encode())
    #print("requested")
    powMonArdSer = powerMonitorArduino.readline()
    #print(powMonArdSer)
    return powMonArdSer

#-----building json package of sensor values-----#
def createSensorJson():
    sensorDict = {}
    sensorDict.update(eval(getSensorReadings("mainCurrent")))
    sensorDict.update(eval(getSensorReadings("mainVoltage")))
    sensorDict.update(eval(getSensorReadings("rigCurrent")))
    sensorDict.update(eval(getSensorReadings("boxTemp")))

    if(sensorDict['mainCurrent'] < 0):
        sensorDict['mainCurrent'] = 0
    if(sensorDict['mainVoltage'] < 0):
        sensorDict['mainVoltage'] = 0
    if(sensorDict['rigCurrent']<0):
        sensorDict['rigCurrent'] = 0

    sensorJson = json.dumps(sensorDict, indent = 4)
    #print(sensorJson)

    return sensorJson

#------averaging a list----------#
def Average(lst): 
    return sum(lst) / len(lst)

#------min avg max of list-------#
def minAvgMax(lst):
    minValue = round(min(lst),2)
    maxValue = round(max(lst),2)
    avgValue = round(Average(lst),2)
    return minValue, avgValue, maxValue

#-------def insert 4-pack values--------
def insert3(procedure, item1, item2, item3):
    sqlStoreReadings = "CALL {}('{}', {}, {}, {})".format(
        procedure,
        datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
        item1,
        item2,
        item3)
    #print(sqlStoreReadings)
    shackCursor.execute(sqlStoreReadings)
    shackConnection.conn.commit()

def translate(value, leftMin, leftMax, rightMin, rightMax):
    # Figure out how 'wide' each range is
    leftSpan = leftMax - leftMin
    rightSpan = rightMax - rightMin

    # Convert the left range into a 0-1 range (float)
    valueScaled = float(value - leftMin) / float(leftSpan)

    # Convert the 0-1 range into a value in the right range.
    return rightMin + (valueScaled * rightSpan)

#-----Main--------------------------------------------------------#

while True:



    try:       
        sensorPackage = createSensorJson()
        #print(sensorPackage)
        with open("//var/www/currentSensorData.json","w") as outfile:
            outfile.write(sensorPackage)
        
        sensorsDict = json.loads(sensorPackage)
        mainVlist.append(sensorsDict['mainVoltage'])
        mainIlist.append(sensorsDict['mainCurrent'])
        rigIlist.append(sensorsDict['rigCurrent'])

        if (datetime.datetime.now() - lastSample).total_seconds() > sampleFrequency:
	# at frequency defined by sample frequency, do some stuff:

	    #get temperature information and set fans etc.
            temperatureFile = open("/sys/class/thermal/thermal_zone0/temp", "r")
            cpuTemp = int(int(temperatureFile.readline ()) / 1000)
            boxTemp = int(sensorsDict['boxTemp'])

            if cpuTemp > 70:
	        #if the temp of the CPU gets this high, have the cpu temp regulate fan speed
                fanSpeed = int(translate(cpuTemp, 70, 80, 0, 100))
                if fanSpeed < 0: fanSpeed = 0
                if fanSpeed > 100: fanSpeed = 100
                fanSetPoint = getSensorReadings("setFan:"+str(fanSpeed))
            else:
	        #if CPU is below range above, just use ambient box temp to control fan speed
                fanSpeed = int(translate(boxTemp, 25, 37, 0, 100))
                if fanSpeed < 0: fanSpeed = 0
                if fanSpeed > 100: fanSpeed = 100
                fanSetPoint = getSensorReadings("setFan:"+str(fanSpeed))

            #for verification during testing unremark:
            #print(str(cpuTemp))
            #print(str(boxTemp))
            #print(str(fanSpeed))

            #next chunk of stuff is to store some info in the db for future evaluation 
            mainVmin, mainVavg, mainVmax = minAvgMax(mainVlist)
            mainImin, mainIavg, mainImax = minAvgMax(mainIlist)
            rigImin, rigIavg, rigImax = minAvgMax(rigIlist)

            lastSample = datetime.datetime.now()

            insert3("addMainVoltageValues", mainVmin, mainVavg, mainVmax)
            insert3("addMainCurrentValues", mainImin, mainIavg, mainImax)
            insert3("addHFrigCurrentValues", rigImin, rigIavg, rigImax)

    except:
        shackCursor.close()
        shackConnection.conn.close()
        print("\nInterrupt")
        break
    
