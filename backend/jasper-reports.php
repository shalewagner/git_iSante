<?php

require_once 'backend/config.php';
require_once 'backendAddon.php';
require_once 'backend/report.php';

//Figures out the URL of the application. Really only useful for figuring out how to call the CGI version of sqlProcess.
function getApplicationRootUrl() {
  if (array_key_exists('HTTPS', $_SERVER)
      && ($_SERVER['HTTPS'] == 'on') ) {
    $url = 'https://';
  } else {
    $url = 'http://';
  }

  $url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/';

  //Find the location of this file relative to the DOCUMENT_ROOT.
  $thisFilePath = dirname($_SERVER['SCRIPT_FILENAME']);
  $docRoot = $_SERVER['DOCUMENT_ROOT'];
  $docRoot = preg_replace("/\\\/", "\\\\\\", $docRoot);
  $docRoot = preg_replace("/\//", "\\\/", $docRoot);
  $pageRoot = preg_replace("/^$docRoot/i", '', $thisFilePath);
  $pageRoot = preg_replace("/\\\/", "/", $pageRoot);
  $url .= $pageRoot . '/';
  return $url;
}

function renderReportToFile($argumentsArray, $recordEvent = true) {
  //Generate $queryTable, $queryChart
  $rtype = $argumentsArray['rtype'];
  $report = $argumentsArray['report'];
  
  $xml = loadXMLFile("jrxml/reports.xml");
  $xpath = "reportSet/reportSubSet/report[@id='$report']";
  $xmlRep = $xml->xpath($xpath);
  
  $lang = $argumentsArray['lang'];
  $site = $argumentsArray['site'];
  $pStatus = $argumentsArray['pStatus'];
  $tStatus = $argumentsArray['tStatus'];
  $tType = $argumentsArray['tType'];
  
  $gLevel = $argumentsArray['gLevel'];
  $oLevel = $argumentsArray['oLevel'];
  $start = $argumentsArray['start'];
  $end = $argumentsArray['end'];
  $pid = $argumentsArray['pid'];
  $ddValue = $argumentsArray['ddValue'];
  
  $nForms = isset($argumentsArray['nForms']) ? $argumentsArray['nForms'] : '';
  $creator = isset($argumentsArray['creator']) ? $argumentsArray['creator'] : '';
  $order = isset($argumentsArray['order']) ? $argumentsArray['order'] : '';
  $oDir = isset($argumentsArray['oDir']) ? $argumentsArray['oDir'] : '';
  $user = $argumentsArray['user'];
  
  list($queryTable, $queryChart, $tableName,
       $start, $end, $pStatus, $tStatus, $tType,
       $gLevel, $oLevel, $ddValue) =
    prepareReportQueries($xmlRep, $rtype, $report, $lang, $site, $pStatus, $tStatus, $tType,
			 $gLevel, $oLevel, $start, $end, $pid, $ddValue,
			 $nForms, $creator, $order, $oDir, $user);
  
  $argumentsArray['queryTable'] = transformSql($queryTable);
  $argumentsArray['queryChart'] = transformSql($queryChart);
  if (isset($tableName)) $argumentsArray['tableName'] = $tableName;
  if (isset($start)) $argumentsArray['start'] = $start;
  if (isset($end)) $argumentsArray['end'] = $end;
  if (isset($pStatus)) $argumentsArray['pStatus'] = $pStatus;
  if (isset($tStatus)) $argumentsArray['tStatus'] = $tStatus;
  if (isset($tType)) $argumentsArray['tType'] = $tType;
  if (isset($gLevel)) $argumentsArray['gLevel'] = $gLevel;
  if (isset($oLevel)) $argumentsArray['oLevel'] = $oLevel;
  if (isset($ddValue)) $argumentsArray['ddValue'] = $ddValue;

  //remove any old data so that nothing is return if this fails
  if (file_exists (getTempFileName('jasperReport', 'bin'))) {
    unlink(getTempFileName('jasperReport', 'bin'));
  }

  #build java command

  //build up the java class path, include all needed jar files
  $jarDirectory = 'jrapp' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
  $classpath = 'jrapp/lib:';
  if ($jarDirectoryHandle = opendir($jarDirectory)) {
    $classpathSeparator = ':';
    while (($file = readdir($jarDirectoryHandle)) !== false) {
      if (is_file($jarDirectory . $file)) {
	$classpath .= $jarDirectory . $file . $classpathSeparator;
      }
    }
    closedir($jarDirectoryHandle);
  }
  $classpath .= 'jrapp' . DIRECTORY_SEPARATOR . 'ITECH_Reports.jar';

  $javaPath = 'java'; //Does this always work on Windows?
  $command = $javaPath . ' -cp ' . $classpath;
  $command .= ' edu.washington.cirg.web.jasper.ReportViewerCgi ';
  $command .= TEMP_DIR . ' ';
  $command .= ereg_replace('[^A-Za-z0-9]', '', getSessionUser());
  $argumentsArray['execCommand'] = $command;

  #add some additional required arguments
  $argumentsArray['applicationRootUrl'] = getApplicationRootUrl();
  $argumentsArray['configFileLocation'] = DB_CONFIG_FILE;

  //write each argument out to the temp file alternating between keys and values
  $argumentsFileName = getTempFileName('jasperArguments', 'txt');
  $argumentsFile = fopen($argumentsFileName, 'w');
  foreach ($argumentsArray as $key => $value) {
    fwrite($argumentsFile, $key . "\n");
    fwrite($argumentsFile, $value . "\n");
  }
  fclose($argumentsFile);

  #record an event
  if ($recordEvent) {
    recordEvent('jrReport', $argumentsArray);
  }

  #execute the java command
  //This method should work perfectly but doesn't work at all on Windows.
  $descriptorspec = array( 0 => array('pipe', 'r'), //stdin
			   1 => array('pipe', 'w'), //stdout
			   2 => array('file', getTempFileName('jasperErrors', 'txt'), 'a') ); //stderr
  $cwd = getcwd();
  $env = array();
  $process = proc_open($command, $descriptorspec, $pipes,
		       $cwd, $env, array('bypass_shell' => TRUE));
  
  if (is_resource($process)) {
    fpassthru($pipes[1]);
  }

  return getTempFileName('jasperReport', 'bin');
}

?>
