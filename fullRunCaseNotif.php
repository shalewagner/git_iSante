<?php
parse_str(implode('&',array_slice($argv,1)),$_REQUEST);
set_time_limit(0);
$startCode = $_REQUEST["startSitecode"];
$endCode = $_REQUEST["endSitecode"];

$_REQUEST["noid"] = 'true';

include_once ("backend.php");
include_once ("backend/caseNotif.php");
include_once ("backend/sharedRptFunctions.php");

// In case this is run in a browser
header ("Content-type: text/plain; charset=utf-8");

// Variable defs
#$today = isset ($argv[1]) ? $argv[1] : date ("Y-m-d");
#$yest = isset ($argv[2]) ? $argv[2] : date ("Y-m-d", strtotime ($today) - 86400);
$today = date ("Y-m-d");
$yest = date ("Y-m-d", strtotime ($today) - 86400);
$stor_dir = "/var/backups/itech/case-notifications";
//$sent_dir = $stor_dir . "/sent/" . date ("Y/m", strtotime ($today));
$sent_dir = $stor_dir . "/sent/newFile.xml";
$temp_dir = $stor_dir . "/temp";
$queue_dir = $stor_dir . "/queue";
$user = "itech";
$pwd = ""; // get from Jim S. if not present
$notifier = "jsibley@uw.edu";
$to_notify = "jsibley@uw.edu";

// Calculate which sites to run for
$sites = array ();
$qry = "SELECT siteCode FROM clinicLookup WHERE inCPHR = 1 AND siteCode between " . $startCode . " AND " . $endCode;
echo $qry;
$result = dbQuery ($qry);
while ($row = psRowFetch ($result)) {
  $sites[] = $row[0];
}

// Populate pregnancy data tables
$tempTables = createTempTables ("#tempCaseNotif", 2, array ("patientID varchar(11), maxDate date", "patientID varchar(11), lmpDate date, eligDate date"), "pat_idx::patientID");
fillLmpTable ($tempTables[2], $sites, $today, 98);
fillPregnancyTable ($tempTables[1], $sites, monthDiff (-3, $today), $today, $tempTables[2]);

// Generate one XML file per site
if (is_dir ($temp_dir)) {
  array_map ("unlink", glob ($temp_dir . "/*"));
  rmdir ($temp_dir);
}
if (!mkdir ($temp_dir, 0770, true)) logIt ("ERROR: couldn't create dir: $temp_dir", 1, 1);
foreach ($sites as $site) {
  $fn = "isante_case_notifications_" . $site . "_" . $today . ".xml";

  $xml = caseNotif ($site, $today, $yest, $tempTables);
  if (!empty ($xml)) {
    $fp = fopen ($temp_dir . "/" . $fn, "w");
    fwrite ($fp, $xml);
    fclose ($fp);
  }
}

// If any XML files generated, zip 'em up, transfer 'em and queue for transfer
$files = scandir ($temp_dir);
if (count ($files) > 2) {
  chdir ($stor_dir);

  // Zip files up
  $ziph = new ZipArchive ();
  $zip_fn = "isante_case_notifications_newFile.zip";
  if ($ziph->open ($zip_fn, ZIPARCHIVE::CREATE) !== true) {
    logIt ("ERROR: couldn't create zip archive: $zip_fn", 1, 1);
  }
  chdir ($temp_dir);
  foreach ($files as $file) {
    if (preg_match ("/\.xml$/", $file)) $ziph->addFile ($file);
  }
  $ziph->close();

  // Move zip archive file to queue directory
  if (!is_dir ($queue_dir)) {
    if (!mkdir ($queue_dir, 0770, true)) logIt ("ERROR: couldn't create dir: $queue_dir", 1, 1);
  }
  if (!rename ($stor_dir . "/" . $zip_fn, $queue_dir . "/" . $zip_fn)) {
    logIt ("ERROR: couldn't move file: $zip_fn to $queue_dir", 1);
  } else {
    logIt ("Successfully queued file: $zip_fn");
  }

  // Try to transfer any files waiting in the queue, if successful, archive
  $archives = scandir ($queue_dir);
  if (count ($archives) > 2) {
    chdir ($queue_dir);

    // Loop through archives
    foreach ($archives as $archive) {
      if (!preg_match ("/\.zip$/", $archive)) continue;
      $file_handle = fopen ($archive, "r");
      $xfer_url = "ftps://207.198.118.249:990/$archive";
      $xfer_handle = curl_init ();
      curl_setopt ($xfer_handle, CURLOPT_URL, $xfer_url);
      curl_setopt ($xfer_handle, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt ($xfer_handle, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt ($xfer_handle, CURLOPT_HEADER, 0);
      curl_setopt ($xfer_handle, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($xfer_handle, CURLOPT_CONNECTTIMEOUT, 60);
      curl_setopt ($xfer_handle, CURLOPT_TIMEOUT, 60);
      curl_setopt ($xfer_handle, CURLOPT_USERPWD, $user . ":" . $pwd);
      curl_setopt ($xfer_handle, CURLOPT_FTPSSLAUTH, CURLFTPAUTH_SSL);
      curl_setopt ($xfer_handle, CURLOPT_UPLOAD, 1);
      curl_setopt ($xfer_handle, CURLOPT_INFILE, $file_handle);
      curl_setopt ($xfer_handle, CURLOPT_INFILESIZE, filesize ($archive));
      $res = curl_exec ($xfer_handle);
#      $res = 0;
      if ($res !== false) {
        logIt ("Successfully transferred file: $archive");
        if (!is_dir ($sent_dir)) {
          if (!mkdir ($sent_dir, 0770, true)) logIt ("ERROR: couldn't create dir: $sent_dir", 1);
        }
        if (!rename ($archive, $sent_dir . "/" . $archive)) {
          logIt ("ERROR: couldn't move file: $archive to $sent_dir", 1);
        } else {
          logIt ("Successfully archived file: $archive");
        }
      } else {
        $err = curl_errno ($xfer_handle);
        logIt ("ERROR: transfer error: $err for file: $archive", 1);
      }
      fclose ($file_handle);
      curl_close ($xfer_handle);
    }
  }
} else {
  logIt ("No files generated");
}

function logIt ($in, $notify = 0, $quit = 0) {
  global $notifier, $to_notify;
  print date (DATE_W3C) . ' - ' . $in . "\n";
  flush();
  if ($notify) {
    logIt ("Notifying $to_notify");
    $headers = "From: $notifier\r\nReply-To: $notifier\r\nX-Mailer: PHP/" . phpversion ();
    mail ($to_notify, "NOTIFICATION: isante case notifications - ERROR", $in, $headers);
  }
  if ($quit) exit;
}

?>
