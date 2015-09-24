#!/usr/bin/python
#import time; 
from datetime import datetime, date, time
import RPi.GPIO as GPIO
import MySQLdb
import sys
from peewee import *
from mcp3008 import MCP3008
from database import DATABASE


foo = time()

print foo
print datetime.now().time()