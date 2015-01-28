#!/bin/sh -vx

. ./script-functions.sh

#cert and key file locations
fileBaseName=ssl-cert-itech
certFile=/etc/ssl/certs/$fileBaseName.pem
keyFile=/etc/ssl/private/$fileBaseName.key

#if this is not an upgrade then we need to generate an SSL certificate
if [ ! $UPGRADE ]
then
    template="/usr/share/ssl-cert/ssleay.cnf"
    CountryName="HT"
    StateName="x"
    LocalityName="x"
    OrganisationName="x"
    OUName="x"
    HostName="$(hostname)"
    Email="root@$HostName"
    
    TMPFILE=`mktemp`
    sed -e s#@CountryName@#"$CountryName"# \
     -e s#@StateName@#"$StateName"# \
     -e s#@LocalityName@#"$LocalityName"# \
     -e s#@OrganisationName@#"$OrganisationName"# \
     -e s#@OUName@#"$OUName"# \
     -e s#@HostName@#"$HostName"# \
     -e s#@Email@#"$Email"# \
     $template > $TMPFILE

     export RANDFILE=/dev/random

     openssl req -config $TMPFILE -new -x509 -nodes \
	 -out $certFile -keyout $keyFile -days 3650 > /dev/null 2>&1
     chmod 644 $certFile
     chmod 640 $keyFile
     chown root:ssl-cert $keyFile

     cd /etc/ssl/certs/
     ln -sf $fileBaseName.pem `openssl x509 -hash -noout -in $fileBaseName.pem`
     
     rm -f $TMPFILE
fi

#Add certificate to java's keystore. (needed for Jasper renderer)
keyStoreFile=/etc/java-6-sun/security/cacerts

#We are going to modify $keyStoreFile which is a config file of the java package.
#So use dpkg-divert to move package version out of the way
divert $keyStoreFile
cp -f $keyStoreFile.distrib $keyStoreFile
keytool -import -noprompt -alias itechca -file $certFile -storepass changeit -keystore $keyStoreFile
