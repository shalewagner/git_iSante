#!/bin/sh -vx

cp -f templates-output/sudoers /etc/sudoers
chown root:root /etc/sudoers
chmod 440 /etc/sudoers
