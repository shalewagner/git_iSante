#!/bin/sh -vx

# Copy custom slapd config file
cp -f templates-output/slapd.conf /etc/ldap/slapd.conf

if [ ! $UPGRADE ]
then
    # For new installs populate a fresh ldap database.
    #make sure slapd isn't running
    invoke-rc.d slapd stop
    rm -f /var/lib/ldap/*.bdb
    rm -f /var/lib/ldap/__db.*
    rm -f /var/lib/ldap/alock
    rm -f /var/lib/ldap/log.*
    slapadd < templates-output/ldap-users
    chown openldap:openldap /var/lib/ldap/*
fi
