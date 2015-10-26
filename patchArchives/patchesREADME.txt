Apply a patch like this:

as itech, copy file to /home/itech
sudo sh
mv <file> /var/www/isante/
cd /var/www/isante
tar -xvf <file>

Contents of various patches:

13.1.1
	Force 10-minute job to run daily on consolidated servers
	Optimization of whoInit() data warehousing function

13.2.1
	Changes to definitions/calculations for INH Prophylaxis HEALTHQUAL indicator
	Changes to definitions/calculations for CD4 Monitoring HEALTHQUAL indicator
	Changes to definitions/calculations for Ped. Early HIV Detection HEALTHQUAL indicator

13.2.2 
	Repairs to the lab order message creation code (removing telephone numbers)

OpenElisSchemaPatch.sql
	OE database modifications also needed separately from the 13.2.2 patch 

13.2.3
	Smartcard integration and updates to fingerprinting

13.2.4 
	Replication patch so sites replicate directly to PaP consolidated server 
	
14.2.1
	Corrects the print function for the lab form – when you click on the "print order" button, you are redirected to a new page with the list of lab tests for the current order.

15.1
	[Patch file 15.1.tar.gz] implements 15.1. After running the tar file, execute the following :
	
	sh support/upgrade-database.sh
	cd support/
	php setTargets.php