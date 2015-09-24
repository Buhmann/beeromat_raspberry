#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import sys
from mcp3008 import MCP3008


GPIO.cleanup()
GPIO.setmode(GPIO.BCM)	
SOIL_MOSITURE_SENSOR = 7

GPIO.setup(SOIL_MOSITURE_SENSOR,GPIO.OUT)

# mcp Chip initialisieren
print "Bodensensor Test"
mcp3008 = MCP3008()	
ch = 0
i = 0
while i < 10:
	GPIO.output(SOIL_MOSITURE_SENSOR,GPIO.HIGH)
	time.sleep(1)
	value = mcp3008.readAnalogData(ch)
	GPIO.output(SOIL_MOSITURE_SENSOR,GPIO.LOW)
	print "Return Wert: " + str(value)
	i = i + 1
	time.sleep(1)
	
		
	
