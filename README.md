OpenShack-AutomationWeb


Part of the larger OpenShack project, this repository is for the code for html/php interface, python scripts for sensor data to be displayed in that interface, etc.

This repository focuses primarily on items that would be used on a machine dedicated to "automation" or "control" functions.


Important Notes:
 - Files in gitignore hold "secrets" data etc.  you would need to create the same files on your server, but with your info.
 - Audio streaming currently in place is done using icecast2 and darkice.  See man pages etc. for those packages to set that up
 - PowerMonitorArduinoMegaReader.py should be set to run as a system service using systemd
 - the user set up for your web server (i.e. www-data) will need access to dialout group so that serial data can be accessed
