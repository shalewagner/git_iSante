#!/bin/sh -vx

#force a disk integrity check every 6 days or every 6th mount

ROOT_DEV=`mount | grep ext | grep -o "/dev/[a-zA-Z0-9]*" | head -n 1`
tune2fs -c 6 -i 6d $ROOT_DEV
