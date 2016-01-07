sudo apt-get update
sudo apt-get upgrade
sudo apt-get install python-dateutil
sudo apt-get install python-MySQLdb
sudo apt-get install python gpsd gpsd-clients
sudo mkdir /lib/firmware/rtlwifi; sudo wget -O /lib/firmware/rtlwifi/rtl8188efw.bin https://github.com/OpenELEC/wlan-firmware/blob/master/firmware/rtlwifi/rtl8188efw.bin?raw=true
sudo wget -O /lib/firmware/rtlwifi/rtl8188eufw.bin https://github.com/OpenELEC/wlan-firmware/blob/master/firmware/rtlwifi/rtl8188eufw.bin?raw=true
sudo apt-get install bc
sudo modprobe w1-gpio
sudo modprobe w1-therm
