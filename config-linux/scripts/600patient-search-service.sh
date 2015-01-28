#!/bin/sh -vx

#make sure tomcat isn't running
invoke-rc.d tomcat5.5 stop &>/dev/null

patientSearchAppDir=/var/lib/tomcat5.5/webapps/PatientSearchService
rm -rf $patientSearchAppDir
mkdir -p $patientSearchAppDir/META-INF
mkdir -p $patientSearchAppDir/WEB-INF/lib

confFiles="$patientSearchAppDir/META-INF/context.xml /etc/tomcat5.5/Catalina/localhost/PatientSearchService.xml"
for confFile in $confFiles; do
    cp -f templates-output/PatientSearchService.xml $confFile
    chown tomcat55:adm $confFile
    chmod 640 $confFile
done

systemJars="commons-logging.jar jaxme2.jar jaxmeapi.jar jaxmejs.jar jaxmepm.jar jaxmexs.jar"
for systemJar in $systemJars; do
    ln -sf /usr/share/java/$systemJar $patientSearchAppDir/WEB-INF/lib
done

(cd $patientSearchAppDir && jar xf /usr/share/isante/htdocs/PatientSearchService/PatientSearchService.war)
