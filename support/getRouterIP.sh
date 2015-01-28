#!/bin/bash
echo
echo " External IP: "`python /usr/share/isante/htdocs/support/findIP.py` 
echo " Internal IP: `/sbin/ifconfig | grep 'inet adr:'| grep -v '127.0.0.1' | cut -d: -f2 | awk '{ print $1}'`"
echo
exit 0