
setup-isante.pl 
Script that is placed in /usr/bin when Debian package is installed. Asks the user questions and process template files. Then executes other scripts to setup individual applications. 

templates/ - template files with variable place holders
templates-output/ - to hold templates processed by setup-isante.pl

scripts/
Everything in here is executed in order after the templates are generated. They are executed from config-linux/
001stop-services.sh - stop services used by iSante to make sure the application isn't being used
050hostname.sh - update machine host name
105itech-user.sh - add itech system user to a couple of groups
105java.sh - set's SUN's java as the default (vs. gcj)
110apcupsd.sh - install basic config for USB APC UPSs
110apt.sh - populate /etc/apt/sources.list and enable unattended-upgrades
110confconsole.sh - configure the Turnkey confconsole package
110isante-live-config.sh - disable isante-live-config for upgrades
110locale.sh - set system locale to fr_FR.UTF-8
110logrotate.sh - install logrotate.d files
(disabled) 110pgsql.sh - setup postgresql (for OpenELIS)
110php5.sh - update php5 configuration options
110phpmyadmin.sh - install phpmyadmin's config.inc.php
110resolvconf.sh - add Google DNS to end of resolv.conf file
110ssl-cert.sh - setup a self signed ssl cert for apache
110sudo.sh - setup /etc/sudoers
110tomcat.sh - setup tomcat for patient search service
110tune2fs.sh - force a disk integrity check every 6 days or every 6th mount
110usbmount.sh - configure usbmount to work
110var.sh - setup some directories in /var
120cirg-backdoor.sh - add cirgadmin system account and connection to isante-discovery VPN
200ldap.sh - configure basic ldap directory
300apache.sh - configure apache to use ldap auth
400mysql.sh - configure mysql permissions and populate initial database
500cron.sh - install crontab file and setup a few things the cron jobs need
600patient-search-service.sh - install and configure patient search service
999start-services.sh - start services stoped by 001stop-services.sh

script-functions.sh - common functions used by scripts in scripts/
