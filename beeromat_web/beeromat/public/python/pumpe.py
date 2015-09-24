#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import sys

RELAIS = 22
SLEEP_TIME = 10

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(RELAIS, GPIO.OUT)


print "Pumpentest, GPIO PIN: " + str(RELAIS)
print "Sende Signal HIGH"
print "Wartezeit " + str(SLEEP_TIME)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(SLEEP_TIME)
GPIO.output(RELAIS, GPIO.LOW)
print "Sende Signal LOW"
print "Fertig!"


	

