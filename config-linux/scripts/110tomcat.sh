#!/bin/sh -vx

. ./script-functions.sh

# #These are for openelis which we are not configuring anymore.
#FILES="haitiOpenElis.xml openreports.xml"
#CATCONF=/etc/tomcat5.5/Catalina/localhost
#for FILE in $FILES
#do
#    cp -f templates-output/openelis-$FILE $CATCONF/$FILE
#    chown tomcat55:adm $CATCONF/$FILE
#    chmod 640 $CATCONF/$FILE
#done

tomcatDefault=/etc/default/tomcat5.5
divert $tomcatDefault
cp -f $tomcatDefault.distrib $tomcatDefault
sed -i -re "s/#?TOMCAT5_SECURITY=.*/TOMCAT5_SECURITY=no/" $tomcatDefault

# #Not sure if this is needed anymore.
#echo -n "
#if [ -d \$JAVA_HOME/jre/lib/i386 ]; then
#  # Workaround for Sun JVM bug
#  export LD_LIBRARY_PATH=\$JAVA_HOME/jre/lib/i386/
#fi
#
#" >> $tomcatDefault

ln -sf ../../../java/mysql-connector-java.jar /usr/share/tomcat5.5/common/lib/mysql-connector-java.jar
