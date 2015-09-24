#!/usr/bin/python
import time; 
import MySQLdb
from peewee import *

db = MySQLDatabase('beeromat', user='beeromat',passwd='raspi')
class DATABASE:
	# Log Nachrichten
	LOG_BUCKET_EMPTY = "Eimer leer"
	LOG_WATERING_AUTO = "Erdbeeren wurden gegossen - automatisch"
	LOG_WATERING_MANUELL = "Erdbeeren wurden gegossen - manuell"
	
	STATUS_OK = "OK"
	STATUS_BUCKET_EMPTY = "Eimer leer"
	
	def __init__(self):
		db.connect()
		
	def saveSoilMoisture(self,_mositure):
		#bm_soil_mositure.create_table()
		entry = bm_soil_mositure(mositure=_mositure)
		entry.save()
		
	def saveWatering(self,WATERING_TIME):	
		#bm_soil_mositure.create_table()
		query_latest_temperature = bm_temperature.select().order_by(bm_temperature.timestamp.desc())
		entry_latest_temperature = query_latest_temperature.get()
		
		query_latest_mositure = bm_soil_mositure.select().order_by(bm_soil_mositure.timestamp.desc())
		entry_latest_mositure = query_latest_mositure.get()
		
		#print "bm_temperature ID:"
		#print entry_latest_temperature.tID
		#print entry_latest_mositure.smID
		
		entry = bm_watering.create(watering_time=WATERING_TIME, fk_smID = entry_latest_mositure.smID, fk_tID = entry_latest_temperature.tID)
		#print entry
		entry.save()
		self.saveLog(self.LOG_WATERING_AUTO)
	
	def saveBucketEmpty(self):
		db.execute_sql('INSERT INTO bm_bucket(bID ,timestamp) VALUES (NULL ,CURRENT_TIMESTAMP)')
		self.saveLog(self.LOG_BUCKET_EMPTY)
		self.saveStatus(self.STATUS_BUCKET_EMPTY)
		
	def saveLog(self,message):
		entry = bm_log.create(message=message)
		entry.save()
	
	def saveStatus(self,status):
		entry = bm_status(sID=1)
		entry.status = status;
		entry.save()
		#entry.execute()
		
	def getLatestHumidity(self):
		query_latest_humidity = bm_temperature.select().order_by(bm_temperature.timestamp.desc())
		entry_latest_humidity = query_latest_humidity.get()
		
		return entry_latest_humidity.humidity;
		
			 
class BaseModel(Model):
    class Meta:
        database = db

class bm_temperature(BaseModel):
	tID = PrimaryKeyField()
	temperature = DecimalField()
	humidity = DecimalField()
	timestamp = DateTimeField()
	
class bm_soil_mositure(BaseModel):
	smID = PrimaryKeyField()
	mositure = IntegerField()
	timestamp = DateTimeField()
	
class bm_watering(BaseModel):
	wID = PrimaryKeyField()
	timestamp = DateTimeField()
	watering_time = IntegerField()
	fk_smID = ForeignKeyField(bm_soil_mositure, db_column='fk_smID')
	fk_tID = ForeignKeyField(bm_temperature, db_column='fk_tID')
	
class bm_bucket(BaseModel):
	bID = PrimaryKeyField()
	timestamp = DateTimeField()
	
class bm_log(BaseModel):
	lID = PrimaryKeyField()
	message = CharField()
	timestamp = DateTimeField()
	
class bm_status(BaseModel):
	sID = PrimaryKeyField()
	status = CharField()
	timestamp = DateTimeField()