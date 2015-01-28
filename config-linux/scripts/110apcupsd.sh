#!/bin/sh -vx

. ./script-functions.sh

#Edit apcupsd config files and restart service.
apcdConf=/etc/apcupsd/apcupsd.conf
divert $apcdConf
cp -f $apcdConf.distrib $apcdConf
sed -i -re "s/^UPSCABLE (.*)/UPSCABLE usb/g" $apcdConf
sed -i -re "s/^UPSTYPE (.*)/UPSTYPE usb/g" $apcdConf
sed -i -re "s/^DEVICE (.*)/#DEVICE \1/g" $apcdConf

apcdDefault=/etc/default/apcupsd
divert $apcdDefault
cp -f $apcdDefault.distrib $apcdDefault
sed -i -re "s/^ISCONFIGURED=(.*)/ISCONFIGURED=yes/g" $apcdDefault

invoke-rc.d apcupsd stop
invoke-rc.d apcupsd start

#Make UPS monitoring CGI script avaliable to the web server.
ln -snf /usr/lib/cgi-bin/apcupsd /var/www/apcupsd

#remove symlink that may have been created by accident
rm -f /usr/lib/cgi-bin/apcupsd/apcupsd
