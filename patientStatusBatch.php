<?php

$_REQUEST['noid'] = 'true';

require_once 'backend/materializedViews.php';
require_once 'backend/encounterSnapshot.php';
require_once 'backend/dataWarehouse.php';
require_once 'r34/r34Daily.php';

function printLog($message) {
  print strftime('%Y-%m-%d %H:%M:%S') . ' ' . $message . "\n";
  flush();
}


// Start StatusBatch Script
$stopwatch = new StopWatch();
printLog('patientStatusBatch.php started');
recordEvent('patientStatusBatchSt', array()); 

printLog('Starting pediatric to adult switch');
$toAdultCount = pediatricToAdult();
$toAdultCountText = ($toAdultCount == 0) ? '' : " (switched $toAdultCount to adults)"; 

printLog('Pediatric to adult switch finished' . $toAdultCountText . '...starting encounterSnapshot refresh (' . $stopwatch->elapsed() . ' total seconds elapsed)');  

$dow = date("w");
$truncate = false;
if ($dow == 6) $truncate = true; // if this is running on Saturday, truncate the encounter snapshot table to make sure it's still accurate
$lastModified = updateEncounterSnapshot ($truncate); 

printLog('Encounter snaphot refresh finished...starting data warehouse refresh (' . $stopwatch->elapsed() . ' total seconds elapsed)');

if (getConfig('serverRole') != 'consolidated') { // stop running dataWarehouse on consolidated sites starting with 17.4
	updateDataWarehouse('nutrition', $truncate, $lastModified); 
	updateDataWarehouse('malaria', $truncate, $lastModified); 
	if ($dow == 6) updateDataWarehouse('tb', $truncate, $lastModified); 
	updateDataWarehouse('obgyn', $truncate, $lastModified); 
	if ($dow == 6) updateDataWarehouse('dataquality', $truncate, $lastModified);
	if (getConfig('serverRole') == 'consolidated') updateDataWarehouse('mer', $truncate, $lastModified); 
}

printLog('Data warehouse refresh finished...starting PepfarTable refresh (' . $stopwatch->elapsed() . ' total seconds elapsed)');

updatePepfarTable(); 

printLog('PepfarTable refresh finished...starting patient status update (' . $stopwatch->elapsed() . ' total seconds elapsed)');

$times = 25;
$currDate = date('Y-m-d');
updatePatientStatus(2, $currDate);
for ($i=1; $i <= $times; $i++) {
  $endDate = date('Y-m-d', strtotime('-1 second',strtotime('- ' . ($i-1) . ' month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
  updatePatientStatus(2, $endDate);
} 

#adding for the alert.
printLog('generatePatientAlert() started');
if (getConfig('serverRole') != 'consolidated') generatePatientAlert();
printLog('generatePatientAlert() finished  (' . $stopwatch->elapsed() . ' total seconds elapsed)');

#adding r34 daily run.
if (getConfig('defsitecode') == '31100') {
	printLog('runR34 started');
	runR34('NOW()');
	printLog('runR34 finished  (' . $stopwatch->elapsed() . ' total seconds elapsed)');
}

printLog('Patient status update finished (' . $stopwatch->elapsed() . ' total seconds elapsed)');

recordEvent('patientStatusBatchFi', array('duration' => $stopwatch->elapsed()));


class StopWatch { 
    public $total; 
    public $time; 
    
    public function __construct() { 
        $this->total = $this->time = round(microtime(true)); 
    } 
    
    public function clock() { 
        return -$this->time + ($this->time = round(microtime(true))); 
    } 
    
    public function elapsed() { 
        return round(microtime(true)) - $this->total; 
    } 
    
    public function reset() { 
        $this->total=$this->time=round(microtime(true)); 
    } 
} 

?>
