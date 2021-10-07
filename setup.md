Setup of Machine:
small computer, Ubuntu Server

Install LAMP Stack
 '''
 Sudo apt update
 '''
 - Files in gitignore hold "secrets" data etc.  you would need to create the same files on your server, but with your info.
 
 - Audio streaming currently in place is done using icecast2 and darkice.  See man pages etc. for those packages to set that up
   - note - audio streaming is currently disabled in my shack. I haven't reinstalled the above two packages since a server update, and I'm not sure I will, due to their inherent latency. I'll probably set them back up, but ultimatley want something with near-zero latency to make interacting with the radio remotely more natural.
   
 - PowerMonitorArduinoMegaReader.py should be set to run as a system service using systemd
 
 - the user set up for your web server (i.e. www-data) will need access to dialout group so that serial data can be accessed
 
 - for the rig control in these pages to work, rigctld must be running on the machine that the rig is connected to.  See README in N3VEM/shackBox respository.
