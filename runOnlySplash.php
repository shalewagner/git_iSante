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

startTimer();
printLog('generateSplashArray() started');
generateSplashArray();
printLog('generateSplashArray() finished (' . getTimer() . ' seconds elapsed)');

?>