
#!usr/bin/env python

import serial
import datetime
import time
import json
import argparse
import os


controlArduino = serial.Serial('/dev/ttyACM0')
time.sleep(.5)
controlArduino.reset_input_buffer()

#---------Functions-------------------------------------

def sendCommand(cmnd):
    controlArduino.write(cmnd)

def readResponse():
    response = controlArduino.readline()
    return response

def controlTerminal():
    os.system('cls' if os.name == 'nt' else 'clear')
    print("00 - Exit Terminal Mode          11 - Speakers On")
    print("01 - Turn VU Meters On           12 - Speakers Off")
    print("02 - Turn VU Meters Off")
    print("03 - Desk Lights On")
    print("04 - Desk Lights Off")
    print("05 - Task Lights On")
    print("06 - Task Lights Off")
    print("07 - Main Rig On")
    print("08 - Main Rig Off")
    print("09 - Audio Equipment On")
    print("10 - Audio Equipment Off")
    command = input("Select: ")
    if(command == 1):
        sendCommand("vu on")
    elif(command == 2):
        sendCommand("vu off")
    elif(command == 3):
        sendCommand("desk lights on")
    elif(command == 4):
        sendCommand("desk lights off")
    elif(command == 5):
        sendCommand("task lights on")
    elif(command == 6):
        sendCommand("task lights off")
    elif(command == 7):
        sendCommand("main rig power on")
    elif(command == 8):
        sendCommand("main rig power off")
    elif(command == 9):
        sendCommand("audio power on")
    elif(command == 10):
        sendCommand("audio power off")
    elif(command == 11):
        sendCommand("audio power on")
        time.sleep(2)
        sendCommand("speaker power on")
    elif(command == 12):
        sendCommand("speaker power off")
    elif(command == 0):
        return 0
    controlTerminal()

    
#---main stuff--------------------------------------------
parser = argparse.ArgumentParser(description='Shack Control')
parser.add_argument("--cmnd", type=str, default="none", help="used to indicate a control command will follow")

args = parser.parse_args()
command = args.cmnd

if(command == 'none'):
    controlTerminal()
elif (command == 'test'):
    print("test command received")
elif (command== 'vuon'):
    sendCommand('vu on')
    check = readResponse()
    confirm = readResponse()
elif (command== 'vuoff'):
    sendCommand('vu off')
    check = readResponse()
    confirm = readResponse()
elif (command== 'desklighton'):
    sendCommand('desk lights on')
    check = readResponse()
    confirm = readResponse()
elif (command== 'desklightoff'):
    sendCommand('desk lights off')
    check = readResponse()
    confirm = readResponse()
elif (command== 'tasklighton'):
    sendCommand('task lights on')
    check = readResponse()
    confirm = readResponse()
elif (command== 'tasklightoff'):
    sendCommand('task lights off')
    check = readResponse()
    confirm = readResponse()
elif (command== 'mainrigon'):
    sendCommand('main rig power on')
    check = readResponse()
    confirm = readResponse()
elif (command== 'mainrigoff'):
    sendCommand('main rig power off')
    check = readResponse()
    confirm = readResponse()
elif (command== 'audioon'):
    sendCommand('audio power on')
    check = readResponse()
    confirm = readResponse()
elif (command== 'audiooff'):
    sendCommand('audio power off')
    check = readResponse()
    confirm = readResponse()
elif (command== 'speakerson'):
    sendCommand('speaker power on')
    check = readResponse()
    confirm = readResponse()
elif (command== 'speakersoff'):
    sendCommand('speaker power off')
    check = readResponse()
    confirm = readResponse()
elif (command== 'hello'):
    sendCommand('audio power on')
    check = readResponse()
    confirm = readResponse()
    sendCommand('vu on')
    check = readResponse()
    confirm = readResponse()
    sendCommand('desk lights on')
    check = readResponse()
    confirm = readResponse()
    sendCommand('task lights on')
    check = readResponse()
    confirm = readResponse()    
    sendCommand('main rig power on')
    check = readResponse()
    confirm = readResponse()
    sendCommand('speaker power on')
    check = readResponse()
    confirm = readResponse()        
elif (command== 'goodbye'):
    sendCommand('speaker power off')
    check = readResponse()
    confirm = readResponse()   
    sendCommand('main rig power off')
    check = readResponse()
    confirm = readResponse()
    sendCommand('desk lights off')
    check = readResponse()
    confirm = readResponse()
    sendCommand('task lights off')
    check = readResponse()
    confirm = readResponse()
    sendCommand('audio power off')
    check = readResponse()
    confirm = readResponse()
    sendCommand('vu off')
    check = readResponse()
    confirm = readResponse()
