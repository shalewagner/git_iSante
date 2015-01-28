#!/bin/sh -vx

cp -f templates-output/resolvconf-tail /etc/resolvconf/resolv.conf.d/tail

invoke-rc.d resolvconf restart
