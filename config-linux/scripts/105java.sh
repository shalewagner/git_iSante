#!/bin/sh -vx

#make sure Sun's java is the default
update-alternatives --set java /usr/lib/jvm/java-6-sun/jre/bin/java
update-alternatives --set keytool /usr/lib/jvm/java-6-sun/jre/bin/keytool
update-alternatives --set jar /usr/lib/jvm/java-6-sun/bin/jar
