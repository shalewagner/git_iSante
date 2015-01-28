<?php
parse_str(implode('&', array_slice($argv, 1)), $_REQUEST);
set_time_limit (0); 
ini_set ('memory_limit','1024M');
$_REQUEST['noid'] = 'true';
$key = $_REQUEST['key'];

if ($key == 'all') $keyList = array('nutrition','malaria','tb','dataquality','obgyn');
else $keyList = array($key);

$truncateFlag = $_REQUEST['truncateFlag'];

require_once 'backend/materializedViews.php';
require_once 'backend/encounterSnapshot.php';
require_once 'backend/dataWarehouse.php'; 

$stopwatch = new StopWatch();
printLog('...starting encounterSnapshot refresh (' . $stopwatch->elapsed() . ' total seconds elapsed)'); 
$encArray = updateEncounterSnapshot ($truncateFlag); 
printLog($encArray['rowCount'] . ' rows changed in encounter...');

foreach ($keyList as $key) {
	printLog('starting ' . $key . ' refresh (' . $stopwatch->elapsed() . ' total seconds elapsed)');  
	$truncateFlag = true; 
	updateDataWarehouse($key, $truncateFlag, $encArray['lastModified']);
}    

printLog(' refresh finished (' . $stopwatch->elapsed() . ' total seconds elapsed)');

function printLog($message) {
  print strftime('%Y-%m-%d %H:%M:%S') . ' ' . $message . "\n";
  flush();
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
