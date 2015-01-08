#! /usr/bin/python
# Written by Dan Mandle http://dan.mandle.me September 2012
# License: GPL 2.0
 
import os
from gps import *
from time import *
from numpy import *
import time
import threading
import MySQLdb

# Open database connection
db = MySQLdb.connect("localhost","root","bananapi","Voiture" )

# prepare a cursor object using cursor() method
cursor = db.cursor()
 
gpsd = None #seting the global variable
 
os.system('clear') #clear the terminal (optional)
 
class GpsPoller(threading.Thread):
  def __init__(self):
    threading.Thread.__init__(self)
    global gpsd #bring it in scope
    gpsd = gps(mode=WATCH_ENABLE) #starting the stream of info
    self.current_value = None
    self.running = True #setting the thread running to true
 
  def run(self):
    global gpsd
    while gpsp.running:
      gpsd.next() #this will continue to loop and grab EACH set of gpsd info to clear the buffer
 
if __name__ == '__main__':
  gpsp = GpsPoller() # create the thread
  try:
    gpsp.start() # start it up
    while True:
      #It may take a second or two to get good data
      #print gpsd.fix.latitude,', ',gpsd.fix.longitude,'  Time: ',gpsd.utc
		os.system('clear')
		# print gpsd.fix.speed
		speed = round(gpsd.fix.speed * 3.6)
		# print speed
	  # Prepare SQL query to INSERT a record into the database.
		sqlUpdate = "UPDATE Instantane SET vitesse=%s" % (speed)
        
		try:
			# Execute the SQL command
			cursor.execute(sqlUpdate)
			# Commit your changes in the database
			db.commit()
			
		except:
			# Rollback in case there is any error
			db.rollback()		
		time.sleep(1) #set to whatever
 
  except (KeyboardInterrupt, SystemExit): #when you press ctrl+c
    print "\nKilling Thread..."
    gpsp.running = False
    gpsp.join() # wait for the thread to finish what it's doing
  db.close() # disconnect from server
  print "Done.\nExiting."
