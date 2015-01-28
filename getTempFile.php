<?php

require_once 'backendAddon.php';

$baseName = $_REQUEST['baseName'];
$extension = $_REQUEST['extension'];

$tempFileName = getTempFileName($baseName, $extension);

//It looks like this mime type stuff isn't needed because the browser gets it correct
//based on Content-Disposition.
//Leave it here anyway just in case.
/*
$mimeMap = array('csv' => 'application/vnd.ms-excel',
		 'png' => 'image/png');
*/

if (is_file($tempFileName)) {
  /*
  if (array_key_exists($extension, $mimeMap)) {
    header('Content-type: ' . $mimeMap[$extension]);
  }
  */
  header('Content-Disposition: attachment; filename="' . $baseName . '.' . $extension . '"');
  readfile($tempFileName);
}

?>