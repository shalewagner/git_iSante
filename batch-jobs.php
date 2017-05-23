<?php

$_REQUEST['noid'] = 'true';

require_once 'backendAddon.php';
require_once 'backend/materializedViews.php';
require_once 'backend/fixZeroVisitDates.php';
#this allows nice output if run from the web browser
header('Content-type: text/plain; charset=utf-8');

#Couple of functions to make logging easier.
$__timer = round(microtime(true));
function startTimer() {
  global $__timer;
  $__timer = round(microtime(true));
}
function getTimer() {
  global $__timer;
  $newTime = round(microtime(true));
  return $newTime - $__timer;
}

function printLog($message) {
  print strftime('%Y-%m-%d %H:%M:%S') . ' ' . $message . "\n";
  flush();
}

# Run the lab order queue, even if no encounters have been modified
$startTime = round(microtime(true));
startTimer();
printLog('runEncounterQueue() started');
runEncounterQueue ();
printLog('runEncounterQueue() finished (' . getTimer() . ' seconds elapsed)');
recordEvent('runEncounterQueue', array('seconds' => getTimer ()));

#If no encounters have been modified since the last run then there is no need to run this.
#You can force it to run anyway by giving -f as a command line option.
$sql = '
select case when max(lastModified) < lastRun then 0 else 1 end as flag
 from encounter, lastJobRun
 group by lastRun';
$result = dbQuery($sql);
$row = psRowFetch($result);
if ( ($row['flag'] == 0)
     && ($argv[1] != '-f') 
     && (!array_key_exists('force', $_REQUEST)) ) {
  printLog('Skipping 10 minute job because no encounters were updated.');
  exit;
}

$startTime = round(microtime(true));
printLog('Starting 10 minute job.');
recordEvent('10MinuteJobStart', array());

$result = dbQuery('select getDate() as dbStartDate');
$row = psRowFetch($result);
$dbStartDate = $row['dbStartDate'];

startTimer();
printLog('fixZeroVisitDates() started');
fixZeroVisitDates();
printLog('fixZeroVisitDates() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('updateAges() started');
updateAges();
printLog('updateAges() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('genCD4table() started');
genCD4table();
printLog('genCD4table() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('genEligibility() started');
genEligibility();
printLog('genEligibility() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('genDiscDates() started');
genDiscDates();
printLog('genDiscDates() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('bloodEval(1, null) started');
bloodEval(1, null);
printLog('bloodEval(1, null) finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('whoInit() started');
whoInit();
printLog('whoInit() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('updatePatientStatus(1, null) started');
updatePatientStatus(1, null);
printLog('updatePatientStatus(1, null) finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('generateSplashArray() started');
generateSplashArray();
printLog('generateSplashArray() finished (' . getTimer() . ' seconds elapsed)');

startTimer();
printLog('generateMarkerArray() started');
generateMarkerArray();
printLog('generateMarkerArray() finished (' . getTimer() . ' seconds elapsed)');


#Record the time that this job was run.
dbQuery("update lastJobRun set lastRun = '$dbStartDate'");

$duration = round(microtime(true)) - $startTime;
printLog('Finished 10 minute job. (' . $duration . ' total seconds elapsed)');
recordEvent('10MinuteJobFinish', array('duration' => $duration));

?>
