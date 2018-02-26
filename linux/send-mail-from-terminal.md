
#To send mail from the terminal.


sudo apt-get install ssmtp
gksu gedit /etc/ssmtp/ssmtp.conf

#Append the following text:
============================
root=username@gmail.com
mailhub=smtp.gmail.com:465
rewriteDomain=gmail.com
AuthUser=username
AuthPass=password
FromLineOverride=YES
UseTLS=YES
Run ssmtp and provide the recipient email address:
============================

ssmtp recepient_name@gmail.com

Provide the message details as follows:
========================
To: recipient_name@gmail.com
From: username@gmail.com
Subject: Sent from a terminal!

Your content goes here. Lorem ipsum dolor sit amet, consectetur adipisicing.
(Notice the blank space between the subject and the body.)
========================

Press Ctrl + D to send.

#You can also put the text in file and send it as follows:

ssmtp recipient_name@gmail.com < filename.txt