#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import sys

RELAIS = 22

def main(duration):
	
	GPIO.setmode(GPIO.BCM)
	
	GPIO.setup(RELAIS, GPIO.OUT)


	GPIO.output(RELAIS, GPIO.HIGH)
	#time.sleep(1)
	GPIO.output(RELAIS, GPIO.LOW)
	
	
	
	#GPIO.output(RELAIS, GPIO.HIGH)
	#time.sleep(duration)
	#GPIO.output(RELAIS, GPIO.LOW)


arg_count = len(sys.argv)

if arg_count < 2:
	print("Frist argument missing: duration")
	sys.exit()
print(int(sys.argv[1]))
	
GPIO.setmode(GPIO.BCM)
GPIO.setup(RELAIS, GPIO.OUT)

GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(3)
GPIO.output(RELAIS, GPIO.LOW)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(3)
GPIO.output(RELAIS, GPIO.LOW)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(3)
GPIO.output(RELAIS, GPIO.LOW)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(3)
GPIO.output(RELAIS, GPIO.LOW)
GPIO.output(RELAIS, GPIO.HIGH)
time.sleep(3)
GPIO.output(RELAIS, GPIO.LOW)
	
print("done")
