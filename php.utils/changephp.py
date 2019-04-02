# how to use
# sudo apt install -y php5.6 libapache2-mod-php5.6 php5.6-curl php5.6-gd php5.6-mbstring php5.6-mcrypt php5.6-mysql php5.6-xml php5.6-xmlrpc php-xdebug php5.6-zip php5.6-imap php5.6-soap php5.6-ssh2
# sudo apt install -y php7.1 libapache2-mod-php7.1 php7.1-curl php7.1-gd php7.1-mbstring php7.1-mcrypt php7.1-mysql php7.1-xml php7.1-xmlrpc php-xdebug php7.1-zip php7.1-imap php7.1-soap php7.1-ssh2
#
# sudo chmod +x changephp.py
# ./changephp.py 5.6
# ./changephp.py 7.1

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
