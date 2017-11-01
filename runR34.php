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

#adding for the alert.
printLog('generatePatientAlert() started');
if (getConfig('serverRole') != 'consolidated') generatePatientAlert();
printLog('generatePatientAlert() finished  (' . $stopwatch->elapsed() . ' total seconds elapsed)');

$start = $argv[1];
if (getConfig('defsitecode') == '31100') {
	printLog('runR34 started'); 
	runR34($start);
	printLog('runR34 finished  (' . $stopwatch->elapsed() . ' total seconds elapsed)');
}

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
