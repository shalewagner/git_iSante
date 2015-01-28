#!/bin/sh -vx

. ./script-functions.sh

usbmountConf=/etc/usbmount/usbmount.conf
divert $usbmountConf
cp -f $usbmountConf.distrib $usbmountConf
sed -i -re "s/^FILESYSTEMS=(.*)/FILESYSTEMS=\"ext2 ext3 vfat\"/g" $usbmountConf
sed -i -re "s/^FS_MOUNTOPTIONS=(.*)/FS_MOUNTOPTIONS=\"-fstype=vfat,uid=itech,gid=itech\"/g" $usbmountConf
sed -i -re "s/^VERBOSE=(.*)/VERBOSE=\"yes\"/g" $usbmountConf
