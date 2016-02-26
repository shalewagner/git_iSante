<?php
$_REQUEST['noid'] = 'true'; 
chdir('..');
include "backend.php";

$qry = "select count(*) as cnt from config where name = 'replicationTargets'";
$targets = 'itechConsolidated,https://isante-consolidated.cirg.washington.edu/receiver/receive-file.pl,identified,papConsolidated,https://isante.ugp.ht/consolidatedId/receiver/receive-file.pl,identified';
$rows = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC); 
if ($rows[0]['cnt'] > 0) {
	$qry = "update config set value = ? where name = ?"; 
	echo $qry . "\n";
	$valArray = array($targets, 'replicationTargets');
} else {
	$qry = "insert into config (name, value) values (?,?)";
	echo $qry . "\n"; 
	$valArray = array('replicationTargets',$targets);
} 
$retVal = database()->query($qry, $valArray)->rowCount();
echo " rows updated: " . $retVal . "\n"; 
// set up new universal backup encryption key
$qry = "update config set value = ? where name = ?";
$retVal = database()->query($qry, array('P3pf@r2016.ht','backupEncryptionKey'))->rowCount();
if ($retVal === 1) echo "backup encryption key reset\n";
else echo "failed to update backup encryption key\n";
?>  
