#!/bin/sh -vx

if [ $UPGRADE ]; then
    if [ -f /etc/default/isante-live-config ]; then
        #When upgrading from a version older then 9.0RC2 (5412) we need to explicitly disable isante-live-config because it was not used when the system was initally setup.
	rm -f /etc/default/isante-live-config
	touch /etc/default/isante-live-config
    fi
fi
