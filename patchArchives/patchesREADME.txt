Apply a patch like this:

cd /var/www
sudo tar zxvf isante_version_xx.x.x_patch.tgz isante

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