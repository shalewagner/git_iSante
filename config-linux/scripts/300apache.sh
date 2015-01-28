#!/bin/sh -vx

. ./script-functions.sh

#initialize temporary directory used by the application
appTempDir=/tmp/itech
rm -rf $appTempDir
mkdir -p $appTempDir
chmod 750 $appTempDir
chown www-data:www-data $appTempDir

#enable needed apache modules
a2enmod authnz_ldap
a2enmod deflate
a2enmod proxy
a2enmod proxy_ajp
a2enmod rewrite
a2enmod ssl

#make mod_deflate more useful
cp -f templates-output/apache-deflate-extra.conf /etc/apache2/conf.d/deflate-extra.conf

#need to divert and modify /etc/apache2/mods-available/proxy.conf
divert /etc/apache2/mods-available/proxy.conf
cp -f /etc/apache2/mods-available/proxy.conf.distrib /etc/apache2/mods-available/proxy.conf
sed --in-place 's/Deny from all/Deny from none # was all/' /etc/apache2/mods-available/proxy.conf

#listen on 443
divert /etc/apache2/ports.conf
cp -f templates-output/apache-ports.conf /etc/apache2/ports.conf

#turn on global ldap auth, adjust a few other settings, make sure no other sites are enabled
cp -f templates-output/apache-isante.conf /etc/apache2/sites-available/isante
find /etc/apache2/sites-available -type f -printf "%f\n" | xargs -i a2dissite {}
a2ensite isante
