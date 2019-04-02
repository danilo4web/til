#!/usr/bin/env python
# -*- coding: utf-8 -*-
import sys
import os
import commands
import subprocess

output = subprocess.check_output(["php", "-v"]);
phpOld = output[4:7]
phpNew = sys.argv[1]

print("From: " + phpOld + " To: " + phpNew)

print("Starting PHP Version Switching")
print

print("Disabling php" + phpOld)
os.system("sudo a2dismod php" + phpOld)

print("Activating php" + phpNew)
os.system("sudo a2enmod php" + phpNew)

print("Defining PHP shortcuts")
os.system("sudo update-alternatives --set php /usr/bin/php" + phpNew)

print("Restart Apache")
os.system("sudo systemctl restart apache2")

print("Loading Configuration PHP Files")
os.system("php -i | grep \"Loaded Configuration File\"")

print
print
print

print(os.system("php -v"))
