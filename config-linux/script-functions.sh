#!/bin/sh

#This file contains common functions used by multiple setup scripts.

#Move a config file owned by a Debian package out of the way.
divert () {
    targetFile=$1
    if [ ! `dpkg-divert --list $targetFile` ]
    then
        dpkg-divert --rename --add $targetFile
    fi
    #Version of dpkg before 1.15 have a problem that cause *.distrib.dpkg-new to be created when they aren't needed. Fix that here.
    if [ -e $targetFile.distrib.dpkg-new ]
    then
        mv -f $targetFile.distrib.dpkg-new $targetFile.distrib
    fi
}

