# ferramentas uteis
sudo apt install net-tools meld

# java
sudo apt install openjdk-11-jdk

# android studio
sudo apt update && sudo apt upgrade && sudo apt-add-repository ppa:maarten-fonville/android-studio && sudo apt update && sudo apt install android-studio 

# [Attention] - Open android studio to complete the installation

# setup Android path
export ANDROID_HOME=/home/`whoami`/Android/Sdk && export PATH=$PATH:$ANDROID_HOME/tools && cd $ANDROID_HOME/tools/bin && ./sdkmanager --licenses && java --version

# angular and correct node permissions
sudo apt-get install nodejs && sudo apt-get install npm && sudo npm install -g @angular/cli && sudo npm install -g typescript && sudo chown -R `whoami` /usr/local && sudo chown -R `whoami` /usr/local/lib/node_modules /usr/local/bin /usr/local/share && ng -v

# docker
sudo apt install apt-transport-https ca-certificates curl software-properties-common && curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add - && sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu artful stable" && sudo apt update && sudo apt install docker-ce && docker -v

# criar estrutura projeto
sudo mkdir /servidor && sudo chown danilo:danilo /servidor && mkdir /servidor/logs && mkdir /servidor/sites && mkdir /servidor/projetos && chown danilo:danilo /servidor/ -Rfv && chmod 777 /servidor/logs && ls /servidor/ -lha

# ionic
npm install --g ionic && ionic login daniloborgespereira@gmail.com && chmod 755 /home/danilo/.ionic/config.json & npm install --g cordova

# install ssh and github key
sudo apt-get install ssh && ssh-keygen -t rsa -b 4096 -C "danilo4web@gmail.com" && ssh-add ~/.ssh/id_rsa && cat ~/.ssh/id_rsa.pub

# Attention: Know, you need to update the pub key on github! #

# pull all projects
cd /servidor/projetos/ && git clone https://github.com/danilo4web/til.git && git clone https://github.com/danilo4web/ionic.git && git clone https://github.com/danilo4web/angular.git && git clone https://github.com/danilo4web/docker.git && git clone https://github.com/danilo4web/curso-docker.git

# github config
git config --global user.email "danilo4web@gmail.com"
git config --global user.name "Danilo"

# spotify
sudo snap install spotify

# Install by .deb Packages

Chrome
https://www.google.com.br/chrome/index.html

Opera
https://www.opera.com/pt-br/download

VScode
https://code.visualstudio.com/

workbeanch
https://www.mysql.com/products/workbench/

dropbox
https://www.dropbox.com/install-linux
  
