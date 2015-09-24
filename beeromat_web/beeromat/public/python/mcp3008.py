#!/usr/bin/python
import time
import RPi.GPIO as GPIO
import spidev

RELAIS = 22

class MCP3008:
	def __init__(self,bus=0,client=0):
		self.spi = spidev.SpiDev()		
		self.spi.open(bus,client)
		#self.spi.max_speed_hz=(1000000)
		
	def readAnalogData(self,channel):
		if channel not in range(8):
			return -1
		
		rBytes = self.spi.xfer2([1,(8 + channel) << 4,0])
		adcValue = ((rBytes[1] & 3) << 8) + rBytes[2]
		return adcValue
		

