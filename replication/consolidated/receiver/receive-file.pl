#!/usr/bin/perl -w

use strict;
use warnings;

use CGI;
use Data::Dumper;
use File::Path 'mkpath';
#use Mail::SendEasy;

=begin comment
 -this program receives files from source databases via curl and places them in /home/itech/replication/data 
 
 -a server that will act as a receiver needs some special setup (all commands in a root shell): 

	1. Add receiver location to apache config:
	
		cd /etc/apache2/sites-available/
		vi isante

		  <Location /receiver>
		    AuthType basic
		    AuthName "iSante Consolidated Replication"
		    AuthBasicProvider file
		    AuthUserFile "/home/itech/consolidated-replication.htpasswd"
		    Require valid-user
		    AddHandler cgi-script .pl
		    Options +ExecCGI
		  </Location>  
		  
		  <Location /discontinuation>
                    AuthType basic
                    AuthName "iSante Consolidated Discontinuation"
                    AuthBasicProvider file
                    AuthUserFile "/home/itech/consolidated-replication.htpasswd"
                    Require valid-user
                    AddHandler cgi-script .pl
                    Options +ExecCGI
                  </Location>

	2. Make a link between the receiver location and the directory containing the receive-file.pl script: 
	
		cd /var/www/
		ln -s /var/www/isante/replication/consolidated/receiver receiver
	 
	3. Change permissions on '/var/www/receiver/receive-file.pl':

                chmod +x /var/www/receiver/receive-file.pl
                 
	4. Create the password file associated with the receiver location:

		cd /home/itech
		htpasswd -c consolidated-replication.htpasswd itech
		(at prompt enter the string listed on line 43 of the file /var/www/isante/replication/LocalConfig.pm)

	5. Make sure the permissions on the directory /home/itech/replication/data are set correctly: 
	
	        cd /home/itech/replication/
		chmod g+w data
		chown itech.www-data data

	6. Reload apache:
	
		sudo /etc/init.d/apache2 force-reload

	7. Add the following entry to the isante cron (/etc/cron.d/isante):

		30 19  * * *    itech   /var/www/isante/replication/consolidated/apply-received-files.pl
=cut

my $uploadDirectory = '/home/itech/replication/data';
my $query = new CGI;
print $query->header;

#Save the uploaded files to disk.
foreach my $fileParameterName ('dataFileName', 'reportFileName', 'errorFileName') {
    my $uploadedFileHandle = $query->upload($fileParameterName);
    my $uploadedFileName = $query->param($fileParameterName);

    if (defined $uploadedFileHandle) {
	my $localFileHandle;
	my $localFileName = $uploadDirectory . '/' . $uploadedFileName;
	open($localFileHandle, '>', $localFileName);
	binmode($localFileHandle);
	if (! defined $localFileHandle) {
	    print "Can not open target file $localFileName.\n";
	    exit;
	}
	
	while (my $line = <$uploadedFileHandle>) {
	    print $localFileHandle $line;
	}

	close($localFileHandle);
    } else {
	print "Can not open uploaded file. ($fileParameterName)\n";
	exit;
    }
}

#Write a file containing any other parameters that were sent with the files.
{
    my %parameterHash;
    map {$parameterHash{$_} = $query->param($_) . ''} $query->param;
    # the . '' thing is to make file references strings rather then filehandlers

    my $metaFileName = $uploadDirectory . '/' . $parameterHash{dataFileName} . '-meta.txt';
    my $metaFileHandle;
    open($metaFileHandle, '>', $metaFileName);
    if (! defined $metaFileHandle) {
	print "Can not open meta data file.\n";
	exit;
    }

    local $Data::Dumper::Indent = 0;
    print $metaFileHandle (Data::Dumper->Dump([\%parameterHash], ['parameterHash']) . "\n");

    close($metaFileHandle);
}

#If we make it this far everything went ok. So send back a 'success' message.
print 'success';
