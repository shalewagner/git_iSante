#!/bin/bash
key=$1
efile=$2
outfile=$3
echo $key
echo $efile
echo $outfile
cd ../replication
perl util-aes-file.pl decrypt $key $efile $outfile  
# example one-liner
# perl util-aes-file.pl decrypt stevePassword /home/itech/isante-backups/E_isante-backup-2015-03-22_12-01-18-d99s99999.tar /home/shw2/x.tar
tar -C /tmp -xf $outfile 
