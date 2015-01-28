#!/bin/sh -vx

if [ $UPGRADE ]; then
    #removed as of 9.0RC2
    rm -f /etc/apt/sources.list-example
fi

cp -f templates-output/sources.list /etc/apt/sources.list

cp -f templates-output/apt.conf.d-unattended-upgrades /etc/apt/apt.conf.d/50unattended-upgrades
