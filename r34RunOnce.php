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
// install schema
$mysqlCommandPrefix = 'mysql --defaults-file=' . DB_CONFIG_FILE;
system($mysqlCommandPrefix . ' < /var/www/isante/r34/r34Schema.sql');

// Start StatusBatch Script
$stopwatch = new StopWatch();

printLog('runR34 180 day run started'); 
for ($i = 0; $i < 181; $i++) {
	$start = 'date_add(now(),interval - ' . $i . ' day)';
	runR34($start);
}
	
printLog('runR34 finished  (' . $stopwatch->elapsed() . ' total seconds elapsed)');
	
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
