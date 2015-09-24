#!/usr/bin/python
import time; 
import RPi.GPIO as GPIO
import sys
from database import DATABASE

WATERING_TIME = 15		# Giesszeit in Sekunden
HUMIDITY_LIMIT = 80 # Luftfeuchtigkeit Grenzwert
# Pinbelegung
RELAIS = 22
SENSOR_BUCKET_PIN = 24




def isBucketEmpty():
	# 0 = nass, 1 = trocken
	input_sensor  = GPIO.input(SENSOR_BUCKET_PIN)
	if input_sensor == 0:
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

	#Datenbank initialisieren
	db = DATABASE()
	# Aktuelle Luftfeuchtigkeit holen
	humidity = db.getLatestHumidity()
	
	# Checken ob Wasser im Eimer ist
	if isBucketEmpty():
		db.saveBucketEmpty()
	else:
		db.saveStatus("OK")
		# Giessen wenn Luftfeuchtigkeit unter 90 %
		if humidity < HUMIDITY_LIMIT:
			db.saveWatering(WATERING_TIME)
			GPIO.output(RELAIS, GPIO.HIGH)
			time.sleep(WATERING_TIME)
			GPIO.output(RELAIS, GPIO.LOW)
		else:
			GPIO.output(RELAIS, GPIO.LOW)		
	
		
main()
