
#create new project (Ionic and Angular)
ionic start project_name tabs --type=ionic-angular



#GEO LOCALIZACAO

sudo ionic cordova plugin add cordova-plugin-nativegeocoder
npm install --save @ionic-native/native-geocoder
 
sudo ionic cordova plugin add cordova-plugin-geolocation
npm install --save @ionic-native/geolocation

sudo ionic plugin add cordova-plugin-request-location-accuracy
npm install @ionic-native/location-accuracy --save