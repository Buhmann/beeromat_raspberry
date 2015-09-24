#!/usr/bin/python
import time;
import RPi.GPIO as GPIO
from mcp3008 import MCP3008

RELAIS = 22


GPIO.cleanup() 
GPIO.setmode(GPIO.BCM)
GPIO.setup(RELAIS, GPIO.OUT)

time.sleep(5)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(5)
GPIO.output(RELAIS, GPIO.LOW)
time.sleep(5)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(5)
GPIO.output(RELAIS, GPIO.LOW)
#time.sleep(2)
