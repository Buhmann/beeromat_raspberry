#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import MySQLdb
import sys
from peewee import *
from mcp3008 import MCP3008
from database import DATABASE


TIMER_SOIL_MOISTURE = 3586		# Zeitintervall nachdem eine Bodenfeuchtigkeitsmessung erfolgt
SOIL_MOISTURE_WATERING_VALUE_MAX = 445	# Trockenheitsgrenze (0-1023) Je Trockener desto kleiner der Wert
SOIL_MOISTURE_WATERING_VALUE_MIN = 380
WATERING_TIME = 17		# Giesszeit in Sekunden 1 Sekunde = 30 ml

# Pinbelegung
RELAIS = 22
SENSOR_BUCKET_PIN = 24
SOIL_MOSITURE_SENSOR = 7


def isBucketEmpty():
	# 0 = nass, 1 = trocken
	input_sensor  = GPIO.input(SENSOR_BUCKET_PIN)
	if input_sensor == 0:
		return True
	else:
		return False
	
def getAverangeMositure(mcp, ch):
	values = []
	for x in range(0, 9):
		value = mcp.readAnalogData(ch)
		values.append(value)
		time.sleep(1)
	
	# Liste sortieren
	values.sort()
	# min und max von Liste entfernen
	values.pop(0)
	values.pop()
	
	sum = 0
	for i in values:
		sum += i

	avg = sum / len(values)
	return avg;
	

def main():

	GPIO.cleanup() 
	GPIO.setmode(GPIO.BCM)
	#Relais als Ausgang schalten
	GPIO.setup(RELAIS, GPIO.OUT)
	#Eimersensor als Eingang schalten
	GPIO.setup(SENSOR_BUCKET_PIN,GPIO.IN)
	#Feuchtigkeitssensor als Eingang schalten
	GPIO.setup(SOIL_MOSITURE_SENSOR,GPIO.OUT)
	
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
		# Bodensensor Strom anschalten
		GPIO.output(SOIL_MOSITURE_SENSOR,GPIO.HIGH)
		time.sleep(3)
		# Bodensensor lesen
		#value = mcp3008.readAnalogData(ch)
		value = getAverangeMositure(mcp3008,ch)
		time.sleep(1)
		# Bodensensor abschalten
		GPIO.output(SOIL_MOSITURE_SENSOR,GPIO.LOW)
		# Bodenfeuchtigkeit speichern
		db.saveSoilMoisture(value)
		
		# Checken ob Wasser im Eimer ist
		if isBucketEmpty():
			db.saveBucketEmpty()
		else:
			db.saveStatus("OK")
			# Giessen wenn Trockenheitsgrenze ueberschritten wird
			if value > SOIL_MOISTURE_WATERING_VALUE_MIN and value < SOIL_MOISTURE_WATERING_VALUE_MAX:
				db.saveWatering(WATERING_TIME)
				GPIO.output(RELAIS, GPIO.HIGH)
				time.sleep(WATERING_TIME)
				GPIO.output(RELAIS, GPIO.LOW)
			else:
				GPIO.output(RELAIS, GPIO.LOW)		
#		time.sleep(1)
		time.sleep(TIMER_SOIL_MOISTURE)
		
main()
