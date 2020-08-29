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
print(version[0])

powerMonitorArduino = serial.Serial('/dev/ttyACM0')
time.sleep(1)
powerMonitorArduino.reset_input_buffer()
print("ready")

#-----Functions---------------------------------------------------#

#-----Serial Reading-----#

def getSensorReadings(sensor):
    sensorRequest = "{"+sensor+"}"
    #print(sensorRequest)
    powerMonitorArduino.write(sensorRequest)
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
        mainImin,
        mainIavg,
        mainImax)
    #print(sqlStoreReadings)
    shackCursor.execute(sqlStoreReadings)
    shackConnection.conn.commit()

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
            mainVmin, mainVavg, mainVmax = minAvgMax(mainVlist)
            mainImin, mainIavg, mainImax = minAvgMax(mainIlist)
            rigImin, rigIavg, rigImax = minAvgMax(mainIlist)

            lastSample = datetime.datetime.now()

            insert3("addMainVoltageValues", mainVmin, mainVavg, mainVmax)
            insert3("addMainCurrentValues", mainImin, mainIavg, mainImax)

    except:
        shackCursor.close()
        shackConnection.conn.close()
        print("\nInterrupt")
        break
    
