<?php

require_once 'backend/jasper-reports.php';
require_once 'backend.php';
require_once 'backend/primCareSummaryFunctions.php';

function escapeSpecial ($in) {
  // Convert any special characters pulled from the database before writing
  // to replication-style file
  if (is_null ($in)) {
    return "\\0";
  } else {
    $in = str_replace ("\\", "\\\\", $in);
    $in = str_replace ('"', '\\"', $in);
    $in = str_replace ("'", "''", $in);
    $in = str_replace ("\r\n", "\\n", $in);
    return ($in);
  }
}

if (empty ($_REQUEST['source']) || empty ($_REQUEST['pid']) || empty ($_REQUEST['lang']) || empty ($_REQUEST['type']) || empty ($_REQUEST['target'])) {
  echo "Required parameter missing!";
  exit;
} else {

  if (getHivPositive ($_REQUEST['pid'])) {
    $argumentsArray = array (
      "report" => "214",
      "format" => "html",
      "siteName" => $_REQUEST['source'],
      "pid" => $_REQUEST['pid'],
      "lang" => $_REQUEST['lang'],
      "site" => $_REQUEST['source'],
      "transferTo" => $_REQUEST['target'],
      "source" => "genRecordsRequest.php"
    );

    $clinsum = file_get_contents(renderReportToFile($argumentsArray,
  						    empty($_REQUEST['donotlog'])));

    // Bump up font sizes
    $clinsum = preg_replace_callback ('/\d+\.0px/', create_function ('$matches', 'return (substr ($matches[0], 0, strpos ($matches[0], ".")) + 2) . substr ($matches[0], strpos ($matches[0], "."));'), $clinsum);

    // Grab image ids
    $cnt = preg_match_all ('/<img src="jrImage.php\?image=img_(\d+)_(\d+)_(\d+)"/', $clinsum, $imgs);

    // Replace image filenames
    $clinsum = preg_replace ('/jrImage\.php\?image=px/', 'jasperpx.png', $clinsum);
    $clinsum = preg_replace_callback ('/jrImage\.php\?image=img_\d+_\d+_\d+/', create_function ('$matches', 'return ("jasperimg_" . substr ($matches[0], 22) . ".png");'), $clinsum);

    // Touch up some of the HTML so that IE displays it properly
    $clinsum = preg_replace ('/ align="center"/', '', $clinsum);
    $clinsum = preg_replace ('/JR_PAGE_ANCHOR_0_1"\/>/', 'JR_PAGE_ANCHOR_0_1"></a>', $clinsum);

  } else {
    $argumentsArray = array (
      "username" => getSessionUser(),
      "pid" => $_REQUEST['pid'],
      "lang" => $_REQUEST['lang'],
      "site" => $_REQUEST['source'],
      "transferTo" => $_REQUEST['target'],
      "source" => "genRecordsRequest.php"
    );

    $clinsum = generatePrimCareSummary ($_REQUEST['pid'], $_REQUEST['source'], $_REQUEST['lang']);
    $imgs = array (array ());
    recordEvent ("primCareSummary", $argumentsArray);
  }

  // Create a new directories to hold summary files and generated encounters
  $dir_name = $_REQUEST['pid'] . "_" . date ("YmdHis");
  $trans_dir = getPatientTransferDir () . "/" . date ("Y") . "/" . date ("m") . "/" . $_REQUEST['target'] . "/$dir_name";
  mkdir ("$trans_dir/html", 0770, true);
  mkdir ("$trans_dir/encounters", 0770, true);

  // Copy clinical summary files into holding directory
  $handle = fopen ("$trans_dir/html/jasperReport.html", "w");
  fwrite ($handle, $clinsum);
  fclose ($handle);
  if (getHivPositive ($_REQUEST['pid'])) {
    copy (getTempFileName('jasperpx', 'png'), "$trans_dir/html/jasperpx.png");
  }
  foreach (array_keys ($imgs[0]) as $i) {
    copy (getTempFileName('jasperimg' . $imgs[1][$i] . $imgs[2][$i] . $imgs[3][$i], 'png'), "$trans_dir/html/jasperimg_" . $imgs[1][$i] . "_" . $imgs[2][$i] . "_" . $imgs[3][$i] . '.png');
  }

  // Generate replication-style encounters to be inserted on local server

  // First, a registration encounter (if applicable)
  // Read data from db for patient
  if (empty ($_REQUEST['newpid'])) {
    $reg_enc = array ();
    $sql = "SELECT * FROM encounter WHERE encounterType IN (10, 15) AND patientID = '" . $_REQUEST['pid'] . "' AND encStatus < 255";
    $result = dbQuery ($sql) or die ("FATAL ERROR: Couldn't search encounter table.");
    while ($row = psRowFetch ($result)) {
      foreach ($row as $name => $val) {
        $reg_enc[$name] = escapeSpecial ($val);
      }
    }
  
    $reg_pat = array ();
    $sql = "SELECT * FROM patient WHERE patientID = '" . $_REQUEST['pid'] . "'";
    $result = dbQuery ($sql) or die ("FATAL ERROR: Couldn't search patient table.");
    while ($row = psRowFetch ($result)) {
      foreach ($row as $name => $val) {
        $reg_pat[$name] = escapeSpecial ($val);
      }
    }
  
    $reg_disc = array ();
    $sql = "SELECT a.* FROM allowedDisclosures a, encounter e WHERE e.patientID = a.patientID AND e.visitDateDd = a.visitDateDd AND e.visitDateMm = a.visitDateMm AND e.visitDateYy = a.visitDateYy AND e.seqNum = a.seqNum AND e.siteCode = a.siteCode AND a.patientID = '" . $_REQUEST['pid'] . "' AND e.encounterType IN (10, 15) AND e.encStatus < 255";
    $result = dbQuery ($sql) or die ("FATAL ERROR: Couldn't search allowedDisclosures table.");
    while ($row = psRowFetch ($result)) {
      foreach ($row as $name => $val) {
        $reg_disc[$name] = escapeSpecial ($val);
      }
    }
  
    // Output to file
    $handle = fopen ("$trans_dir/encounters/" . date ("Y-m-d") . "_registration_" . $_REQUEST['pid'] . "_" . $_REQUEST['source'] . "_" . $_REQUEST['target'] . ".csv", "w");
    fputs ($handle, implode (",",
     array (
      "\"encounter\"",
      "\"encounter_id\"", "\"??\"",
      "\"siteCode\"", "\"" . $_REQUEST['target'] . "\"",
      "\"patientID\"", "\"??\"",
      "\"visitDateDd\"", "\"??\"",
      "\"visitDateMm\"", "\"??\"",
      "\"visitDateYy\"", "\"??\"",
      "\"lastModified\"", "\"??\"",
      "\"encounterType\"", "\"" . $reg_enc['encounterType'] . "\"",
      "\"encStatus\"", "\"0\"",
      "\"formVersion\"", "\"" . $reg_enc['formVersion'] . "\"",
      "\"createDate\"", "\"??\"",
      "\"badVisitDate\"", "\"0\"",
      "\"isRegistry\"", "\"0\"",
      "\"visitDate\"", "\"??\""
     )
    ) . "\n");
   
    fputs ($handle, implode (",",
     array (
      "\"patient\"",
      "\"masterPid\"", "\"" . $_REQUEST['pid'] . "\"",
      "\"location_id\"", "\"" . $_REQUEST['target'] . "\""
     )
    ) . ",");
    foreach ($reg_pat as $k => $v) {
      if ($k == "location_id" || $k == "person_id" || $k == "patientID" || 
          $k == "clinicPatientID" || $k == "stid" || $k == "homeDirections" ||
          $k == "patientStatus" || $k == "patGuid" || is_numeric ($k)) continue;
      fputs ($handle, implode (",", array ("\"$k\"", "\"$v\"")) . ","); 
    }
    fseek ($handle, -1, SEEK_CUR);
    fputs ($handle, "\n");
  
    // Only need allowedDisclosures record if there was data present
    if (count ($reg_disc) > 0) {
      fputs ($handle, implode (",",
       array (
        "\"allowedDisclosures\"",
        "\"allowedDisclosures_id\"", "\"??\"",
        "\"siteCode\"", "\"" . $_REQUEST['target'] . "\"",
        "\"patientID\"", "\"??\"",
        "\"visitDateDd\"", "\"??\"",
        "\"visitDateMm\"", "\"??\"",
        "\"visitDateYy\"", "\"??\""
       )
      ) . ",");
      foreach ($reg_disc as $k => $v) {
        if ($k == "allowedDisclosures_id" || $k == "siteCode" || $k == "seqNum" || 
            $k == "patientID" || $k == "visitDateDd" || $k == "visitDateMm" ||
            $k == "visitDateYy" || $k == "dbSite" || is_numeric ($k)) continue;
        fputs ($handle, implode (",", array ("\"$k\"", "\"$v\"")) . ","); 
      }
      fseek ($handle, -1, SEEK_CUR);
      fputs ($handle, "\n");
      fclose ($handle);
    }
  }

  // Next, generate the "transfer" encounter
  // Output to file
  $handle = fopen ("$trans_dir/encounters/" . date ("Y-m-d") . "_transfer_" . $_REQUEST['pid'] . "_" . $_REQUEST['source'] . "_" . $_REQUEST['target'] . ".csv", "w");
  fputs ($handle, implode (",",
   array (
    "\"encounter\"",
    "\"encounter_id\"", "\"??\"",
    "\"siteCode\"", "\"" . $_REQUEST['target'] . "\"",
    "\"patientID\"", "\"??\"",
    "\"visitDateDd\"", "\"??\"",
    "\"visitDateMm\"", "\"??\"",
    "\"visitDateYy\"", "\"??\"",
    "\"lastModified\"", "\"??\"",
    "\"encounterType\"", "\"30\"",
    "\"encStatus\"", "\"0\"",
    "\"formVersion\"", "\"" . $formVersion['30'] . "\"",
    "\"createDate\"", "\"??\"",
    "\"badVisitDate\"", "\"0\"",
    "\"isRegistry\"", "\"0\"",
    "\"visitDate\"", "\"??\""
   )
  ) . "\n");
 
  fputs ($handle, implode (",",
   array (
    "\"obs\"",
    "\"obs_id\"", "\"??\"",
    "\"person_id\"", "\"??\"",
    "\"concept_id\"", "\"8089\"",
    "\"encounter_id\"", "\"??\"",
    "\"obs_datetime\"", "\"??\"",
    "\"location_id\"", "\"" . $_REQUEST['target'] . "\"",
    "\"value_text\"", "\"" . $_REQUEST['pid'] . "\"",
    "\"voided\"", "\"0\""
   )
  ) . "\n");

  fputs ($handle, implode (",",
   array (
    "\"obs\"",
    "\"obs_id\"", "\"??\"",
    "\"person_id\"", "\"??\"",
    "\"concept_id\"", "\"8090\"",
    "\"encounter_id\"", "\"??\"",
    "\"obs_datetime\"", "\"??\"",
    "\"location_id\"", "\"" . $_REQUEST['target'] . "\"",
    "\"value_text\"", "\"" . (!empty ($_REQUEST['newpid']) ? $_REQUEST['newpid'] : "??") . "\"",
    "\"voided\"", "\"0\""
   )
  ) . "\n");

  fputs ($handle, implode (",",
   array (
    "\"obs\"",
    "\"obs_id\"", "\"??\"",
    "\"person_id\"", "\"??\"",
    "\"concept_id\"", "\"8091\"",
    "\"encounter_id\"", "\"??\"",
    "\"obs_datetime\"", "\"??\"",
    "\"location_id\"", "\"" . $_REQUEST['target'] . "\"",
    "\"value_text\"", "\"" . $_REQUEST['source'] . " \"",
    "\"voided\"", "\"0\""
   )
  ) . "\n");

  fputs ($handle, implode (",",
   array (
    "\"obs\"",
    "\"obs_id\"", "\"??\"",
    "\"person_id\"", "\"??\"",
    "\"concept_id\"", "\"8092\"",
    "\"encounter_id\"", "\"??\"",
    "\"obs_datetime\"", "\"??\"",
    "\"location_id\"", "\"" . $_REQUEST['target'] . "\"",
    "\"value_text\"", "\"" . $_REQUEST['target'] . " \"",
    "\"voided\"", "\"0\""
   )
  ) . "\n");
  fclose ($handle);

  // Lastly, if this is a transfer, generate discontinuation data for genericsave
  // Output to file
  if ($_REQUEST['type'] == 2) {

    $discontinuationDirectory = getPatientTransferDir()
      . "/discontinuationsPending/$_REQUEST[source]";
    mkdir($discontinuationDirectory, 0770, true);

    $discontinuationFileName = "$discontinuationDirectory/discontinuation-" 
      . date("Y-m-d") . '_' . $_REQUEST['pid'] . '.genericsave';

    $discontinuationParameters = 
      array('site' => $_REQUEST['source'],
	    'type' => $reg_pat['isPediatric'] == "1" ? 21 : 12,
	    'pid' => $_REQUEST['pid'],
	    'version' => $reg_pat['isPediatric'] == "1" ? $formVersion['21'] : $formVersion['12'],

	    'badVisitDate' => 0,
	    'isRegistry' => 0,

	    'discRemarks' => 'This discontinuation was automatically generated as part of a patient transfer.',
	    'reasonDiscTransfer' => 1,
	    'clinicName' => $_REQUEST['target'],
	    'partStop' => 1,
	    
	    'oldTransferPid' => $_REQUEST['pid'],
	    'oldSitecode' => $_REQUEST['source'],
	    'newSitecode' => $_REQUEST['target']
	    );

    foreach (array('disEnroll', 'visitDate', 'transferDate', 'lastContact') as $datePrefix) {
      $discontinuationParameters[$datePrefix . 'Yy'] = date('y');
      $discontinuationParameters[$datePrefix . 'Mm'] = date('m');
      $discontinuationParameters[$datePrefix . 'Dd'] = date('d');
    }

    $flatParameters = array();
    foreach ($discontinuationParameters as $key => $value) {
      array_push($flatParameters, "\"$key\",\"$value\"");
    }
    
    $handle = fopen($discontinuationFileName, "w");
    fputs($handle, '"' . APP_VERSION . '",' . implode(',', $flatParameters) . "\n");
    fclose($handle);
  }

  // TAR up the output directory into a nice little bundle, return to user
  exec ("cd $trans_dir;tar czf ../$dir_name.tgz .");
  header ("Content-type: application/octet-stream");
  header ("Content-Transfer-Encoding: binary");
  readfile ("$trans_dir/../$dir_name.tgz");
  exec ("rm -rf $trans_dir");
}

?>
