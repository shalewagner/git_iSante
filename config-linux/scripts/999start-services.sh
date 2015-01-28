#!/bin/sh -vx

#restart services
invoke-rc.d slapd start
invoke-rc.d apache2 restart
invoke-rc.d tomcat5.5 start &>/dev/null
invoke-rc.d cron start
invoke-rc.d confconsole start &>/dev/null
