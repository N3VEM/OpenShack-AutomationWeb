
#!usr/bin/env python

import serial
import datetime
import time
import json
import argparse
import os


controlArduino = serial.Serial('/dev/ttyACM1')
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
    print("00 - Exit Terminal Mode")
    print("01 - Turn VU Meters On")
    print("02 - Turn VU Meters Off")
    command = input("Select: ")
    if(command == 1):
        sendCommand("vu on")
    elif(command == 2):
        sendCommand("vu off")
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



