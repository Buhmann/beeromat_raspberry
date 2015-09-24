#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import MySQLdb
import sys
from peewee import *
from mcp3008 import MCP3008
from database import DATABASE


TIMER_SOIL_MOISTURE = 600			# Zeitintervall nachdem eine Bodenfeuchtigkeitsmessung erfolgt
SOIL_MOISTURE_WATERING_VALUE = 200	# Trockenheitsgrenze (0-1023) Je Trockener desto groesser der Wert
WATERING_TIME = 10		# Giesszeit in Sekunden

# Pinbelegung
RELAIS = 22
SENSOR_BUCKET_PIN = 24



def isBucketEmpty():
	# 0 = nass, 1 = trocken
	input_sensor  = GPIO.input(SENSOR_BUCKET_PIN)
	#Bis Schwimmer eingetroffen ist
	return False
	if input_sensor == 1:
		return True
	else:
		return False
	


def main():

	GPIO.cleanup() 
	GPIO.setmode(GPIO.BCM)
	#Relais als Ausgang schalten
	GPIO.setup(RELAIS, GPIO.OUT)
	#Eimersensor als Eingang schalten
	GPIO.setup(SENSOR_BUCKET_PIN,GPIO.IN)
	
	# mcp Chip initialisieren
	mcp3008 = MCP3008()	
	#Datenbank initialisieren
	db = DATABASE()
	ch = 0

	#db.saveSoilMoisture(3)
	#db.saveBucketEmpty()
	#db.saveStatus("OK1")
	#sys.exit()
	while True:
		value = mcp3008.readAnalogData(ch)
		#print value
		# Bodenfeuchtigkeit speichern
		db.saveSoilMoisture(value)
		
		# Checken ob Wasser im Eimer ist
		if isBucketEmpty():
			db.saveBucketEmpty()
		else:
			db.saveStatus("OK")
		# Giessen wenn Trockenheitsgrenze ueberschritten wird
		#if value > SOIL_MOISTURE_WATERING_VALUE:
		#	db.saveWatering(WATERING_TIME)
		#	GPIO.output(RELAIS, GPIO.HIGH)
		#	time.sleep(WATERING_TIME)
		#	GPIO.output(RELAIS, GPIO.LOW)
		#else:
		#	GPIO.output(RELAIS, GPIO.LOW)		
#		time.sleep(1)
		time.sleep(TIMER_SOIL_MOISTURE)
		
main()
