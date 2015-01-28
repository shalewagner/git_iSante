#!/bin/sh -vx

#Shut down services so that we know no one is using iSante during the upgrade
invoke-rc.d confconsole stop
invoke-rc.d cron stop
invoke-rc.d tomcat5.5 stop &>/dev/null
#Do not shutdown apache. If this is an upgrade then the upgrade script should have reconfigured apache to show a maintenance message by this point.
#invoke-rc.d apache2 stop
invoke-rc.d slapd stop
