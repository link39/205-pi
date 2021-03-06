#! /usr/bin/python
# Written by Dan Mandle http://dan.mandle.me September 2012
# License: GPL 2.0

import os
from gps import *
from time import *
import time
import threading
import MySQLdb
import dateutil.parser

# Open database connection
db = MySQLdb.connect("localhost","root","bananapi","bdc" )

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
        time.sleep(3)
        gpsp.start() # start it up
        while True:
            os.system('clear')
            fix = gpsd.fix.mode
            if fix == 1:          
                print "Pas de fix"
                sqlUpdate = "UPDATE Instantane SET fix=0"
                try:
                    # Execute the SQL command
                    cursor.execute(sqlUpdate)
                    # Commit your changes in the database
                    db.commit()
                except:
                    # Rollback in case there is any error
                    print "erreur"
                    db.rollback()
            else:
                latitude = round(gpsd.fix.latitude, 3)
                longitude = round(gpsd.fix.longitude, 3)
                timegps = gpsd.utc
                altitude = int(round(gpsd.fix.altitude))
                #track = int(round(gpsd.fix.track))
                track = 0
		vitesse = round(gpsd.fix.speed * 3.6)
                dateparse = dateutil.parser.parse(timegps)
                #print dateparse
		sqlUpdate = "UPDATE Instantane SET latitude='%s', longitude='%s', altitude='%s',track='%s',time='%s',vitesse='%s',fix='%s'" % (latitude,longitude,altitude,track,dateparse,vitesse,1)
                try:
                    # Execute the SQL command
                    cursor.execute(sqlUpdate)
                    # Commit your changes in the database
                    db.commit()
                except:
                    # Rollback in case there is any error
                    print "erreur"
                    db.rollback()
            time.sleep(1)
    except (KeyboardInterrupt, SystemExit): #when you press ctrl+c
        print "\nKilling Thread..."
        gpsp.running = False
        gpsp.join() # wait for the thread to finish what it's doing
    db.close() # disconnect from server
    print "Done.\nExiting."
