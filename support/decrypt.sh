#!/bin/bash
key=$1
efile=$2
outfile=$3
echo $key
echo $efile
echo $outfile
cd ../replication
perl util-aes-file.pl decrypt $key $efile $outfile
tar -C /tmp -xf $outfile 
