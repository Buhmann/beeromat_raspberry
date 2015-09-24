#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import sys
from mcp3008 import MCP3008

SOIL_MOSITURE_SENSOR = 7


GPIO.setmode(GPIO.BCM)	
GPIO.setup(SOIL_MOSITURE_SENSOR,GPIO.OUT)
	
# mcp Chip initialisieren
print "Bodensensor Test"
mcp3008 = MCP3008()	
ch = 0
GPIO.output(SOIL_MOSITURE_SENSOR,GPIO.HIGH)
time.sleep(1)
# Bodensensor lesen
value = mcp3008.readAnalogData(ch)
# Bodensensor abschalten
GPIO.output(SOIL_MOSITURE_SENSOR,GPIO.LOW)
print "Return Wert: " + str(value)
		
	
