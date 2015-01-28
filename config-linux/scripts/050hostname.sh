#!/bin/sh -vx

#update /etc/hosts
#if this isn't done things that ask for the machines FQDN will be slow
NEW_HOSTNAME=`head -n 1 templates-output/hostname`
OLD_HOSTNAME=`hostname`

#update machine hostname
sed -i -e "s/^.*$OLD_HOSTNAME.*$/127.0.1.1\t$NEW_HOSTNAME\.unassigned\t$NEW_HOSTNAME/" /etc/hosts
hostname --file templates-output/hostname
cp -f templates-output/hostname /etc/hostname
