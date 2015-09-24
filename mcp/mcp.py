#!/usr/bin/python
import time;
import RPi.GPIO as GPIO
from mcp3008 import MCP3008

RELAIS = 22


GPIO.cleanup() 
GPIO.setmode(GPIO.BCM)
GPIO.setup(RELAIS, GPIO.OUT)

mcp3008 = MCP3008()	
ch = 0

	
	#GPIO.output(RELAIS, GPIO.HIGH)
	#time.sleep(delay)
	#GPIO.output(RELAIS, GPIO.LOW)
	

	
while True:
	value = mcp3008.readAnalogData(ch)
	print value
	time.sleep(1)
