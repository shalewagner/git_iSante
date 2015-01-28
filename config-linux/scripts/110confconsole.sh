#!/bin/sh -vx

cp -f templates-output/services.txt /etc/confconsole/services.txt

if [ ! $UPGRADE ]; then
    cp -f templates-output/services-password.txt /etc/confconsole/services-password.txt
fi

if [ -f /etc/confconsole/services-password.txt ]; then
    cat /etc/confconsole/services-password.txt >> /etc/confconsole/services.txt
fi
