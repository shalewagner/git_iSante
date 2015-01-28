<?php

require_once 'backend.php'; 

function unescapeSpecial ($in) {
  // Convert any special characters pulled from the replication-style file
  // before writing to database
  if ($in == "\\0") {
    return null;
  } else {
    $in = str_replace ("\\\\", "\\", $in);
    $in = str_replace ('\\"', '"', $in);
    $in = str_replace ("\\n", "\r\n", $in);
    if (CHARSET != "UTF-8") {
      $in = iconv ("UTF-8", CHARSET, $in);
    }
    return ($in);
  }
}

function readEncounters ($fn) {
  $records = explode ("\n", file_get_contents ("$fn"));
  $dataVals = array ();
  $j = 0;
  foreach ($records as $record) {
    if (strlen ($record) < 1) {
      continue;
    }
    $recordData = explode ("\",\"", $record);
    $recordData[0] = ltrim ($recordData[0], "\"");
    $recordData[count ($recordData) - 1] = rtrim ($recordData[count ($recordData) - 1], "\"");
    if ($recordData[0] == "obs") $j++;
    for ($i = 0; $i < count ($recordData); $i++) {
      if ($i === 0) {
        $dataVals[$recordData[$i] == "obs" ? $recordData[$i] . $j : $recordData[$i]] = array ();
      } else if (($i % 2) == 1) {
        $dataVals[$recordData[0] == "obs" ? $recordData[0] . $j : $recordData[0]][$recordData[$i]] = unescapeSpecial ($recordData[$i + 1]);
      }
    }
  }
  return ($dataVals);
}

function updateEncounterRecord ($data, $pid) {
  foreach ($data as $k => $v) {
    switch ($k) {
      case "encounter_id":
      case "dbSite":
        unset ($data[$k]);
        break;
      case "patientID":
        $data[$k] = $pid;
        break;
      case "visitDateDd":
        $data[$k] = date ("d");
        break;
      case "visitDateMm":
        $data[$k] = date ("m");
        break;
      case "visitDateYy":
        $data[$k] = date ("y");
        break;
      case "visitDate":
        $data[$k] = date ("Y-m-d");
        break;
      case "lastModified":
      case "createDate":
        $data[$k] = date ("Y-m-d H:i:s");
        break;
    }
  }
  return ($data);
}

function updateNonEncounterRecord ($id, $data, $eData, $pid, $eid) {
  foreach ($data as $k => $v) {
    switch ($k) {
      case $id:
        unset ($data[$k]);
        break;
      case "patientID":
        $data[$k] = $pid;
        break;
      case "person_id":
        $data[$k] = substr ($pid, 5);
        break;
      case "visitDateDd":
      case "visitDateMm":
      case "visitDateYy":
      case "visitDate":
      case "seqNum":
        $data[$k] = $eData[$k];
        break;
      case "encounter_id":
        $data[$k] = $eid;
        break;
      case "obs_datetime":
        $data[$k] = date ("Y-m-d");
        break;
      case "value_text":
        $data[$k] = $data["concept_id"] == 8090 ? $pid : $data[$k];
        break;
    }
  }

  // Add dbsite, if not already present (not for obs records, however)
  if ($id != "obs_id" && empty ($data["dbSite"])) $data["dbSite"] = DB_SITE;
    
  return ($data);
}

function nonEncounterInsert ($table, $data) {
  $queryStmt = "INSERT $table ";
  $cnt = 0;
  $cols = "(";
  $vals = "(";
  foreach ($data as $k => $v) {
    $cols .= $k;
    if ($v === NULL) $vals .= "NULL";
    else $vals .= "'$v'";
    $cnt++;
    if (count ($data) > $cnt) {
      $cols .= ", ";
      $vals .= ", ";
    }
  }
  $queryStmt .= $cols. ") VALUES " . $vals . ")";

  $id = dbQuery ($queryStmt . "; SELECT SCOPE_IDENTITY() AS id");
  $rows = psRowFetch ($id);
  return $rows['id'];
}

$pid = !empty ($_REQUEST['newpid']) ? $_REQUEST['newpid'] : "";
$passid = "";

if (empty ($_REQUEST['source']) || empty ($_REQUEST['pid']) || empty ($_REQUEST['target'])) {
  echo "Required parameter missing!";
} else {
  $tmp_dir = getPatientTransferDir () . "/incomingTransfers";
  $fname = "transfer_" . $_REQUEST['pid'] . "_" . $_REQUEST['source'] . "_" . $_REQUEST['target'] . ".tgz";
  if (!is_file ("$tmp_dir/$fname") || !is_readable ("$tmp_dir/$fname")) {
    echo "File not found or not readable!";
  } else {
    // Unpack the tar file in a temporary location for now
    chdir ($tmp_dir);
    exec ("rm -rf encounters html");
    exec ("tar xzf $fname");
    if (is_dir ("$tmp_dir/encounters/")) {
      if ($dir_handle = opendir ("$tmp_dir/encounters/")) {
        while (($file = readdir ($dir_handle)) !== false) {
          $files[$file] = $file;
        }
        closedir ($dir_handle);
        sort ($files);
        foreach ($files as $file) {
          if (stripos ($file, "_registration_") > 0) {
            // Add a new patient
            if (!empty ($pid)) {
              echo "Registration record found, but PID also supplied.  Ignoring registration record.";
            } else {
              if (!is_file ("$tmp_dir/encounters/$file") || !is_readable ("$tmp_dir/encounters/$file")) {
                echo "Encounter file not found or not readable!";
              } else {
                $data = readEncounters ("$tmp_dir/encounters/$file"); 

                // Process patient record first
                $pid = addPatient ($data["patient"]["location_id"], $data["patient"]);
                updateMasterPid ($pid, $data["patient"]["masterPid"]);

                // Update values in encounter record, then insert in db
                $regEncData = updateEncounterRecord ($data["encounter"], $pid);
                $eid = addEncounter ($pid, $regEncData["visitDateDd"], $regEncData["visitDateMm"], $regEncData["visitDateYy"], $regEncData["siteCode"], $regEncData["lastModified"], $regEncData["encounterType"], "", "", "", "",  "", "", "", $regEncData["formVersion"], "", $regEncData["createDate"]);

                // Pass back the registration encounter id
                $passid = $eid;

                // Mark registration encounter as having an error since
                // clinicPatientID will never be set initially
                $res = setStatusByEncounterID ($eid, 1,"", FALSE);
                $res = insertFormErrors ($eid, "clinicPatientID", "43");

                // Update values in allowedDisclosures record, then insert in db
                if (!empty ($data["allowedDisclosures"])) {
                  $discData = updateNonEncounterRecord ("allowedDisclosures_id", $data["allowedDisclosures"], $regEncData, $pid, $eid);
                  $discid = nonEncounterInsert ("allowedDisclosures", $discData);
                }
              }
            }
          } else if (stripos ($file, "_transfer_") > 0) {
            // Add transfer encounter
            if (empty ($pid)) {
              echo "No PID supplied.";
            } else {
              if (!is_file ("$tmp_dir/encounters/$file") || !is_readable ("$tmp_dir/encounters/$file")) {
                echo "Encounter file not found or not readable!";
              } else {
                $data = readEncounters ("$tmp_dir/encounters/$file"); 

                // Need to update masterPid if this is for an existing patient
                if ($pid == $_REQUEST['newpid']) {
                  $mpid = "";
                  foreach ($data as $k => $v) {
                    if (!empty ($v["concept_id"]) && $v["concept_id"] == "8089") $mpid = $v["value_text"];
                  }
                  if (!empty ($mpid)) {
                    updateMasterPid ($pid, $mpid);
                  } else {
                    echo "Could not find value to use for masterPid.";
                  }
                }

                // Update values in encounter record, then insert in db
                $xferEncData = updateEncounterRecord ($data["encounter"], $pid);
                $xferid = addEncounter ($pid, $xferEncData["visitDateDd"], $xferEncData["visitDateMm"], $xferEncData["visitDateYy"], $xferEncData["siteCode"], $xferEncData["lastModified"], $xferEncData["encounterType"], "", "", "", "",  "", "", "", $xferEncData["formVersion"], "", $xferEncData["createDate"]);

                // Pass back the transfer encounter id, unless already populated
                if (empty ($passid)) $passid = $xferid;

                // Update values in obs records, then insert in db
                for ($i = 1; $i <= 4; $i++) {
                  $obsData = updateNonEncounterRecord ("obs_id", $data["obs$i"], $xferEncData, $pid, $xferid);
                  $obsid = nonEncounterInsert ("obs", $obsData);
                }
              }
            }
          }
        }
      } else {
        echo "Failure opening encounters directory.";
      }
    } else {
      echo "Failure untarring file.";
    }

    // Copy clinical summary files to the proper location
    $files = array ();
    mkdir (getEncounterFilePath ($xferid, ""), 0770, true);
    if (is_dir ("$tmp_dir/html/")) {
      if ($dir_handle = opendir ("$tmp_dir/html/")) {
        while (($file = readdir ($dir_handle)) !== false) {
          $files[$file] = $file;
        }
        closedir ($dir_handle);
        foreach ($files as $file) {
          if ($file == '.' || $file == '..') continue;
          copy ("$tmp_dir/html/$file", getEncounterFilePath ($xferid, "") . "$file");
        }
      } else {
        echo "Failure opening html directory.";
      }
    }

    // Clean up
    chdir ($tmp_dir);
    exec ("rm -rf encounters html " . substr ($fname, 0, strlen ($fname) - 3) . "tar");
    if (!empty ($pid) && !empty ($xferid)) {
      mkdir (getPatientTransferDir () . "/processed/", 0770, true);
      copy ("$tmp_dir/$fname", getPatientTransferDir () . "/processed/$fname-" . date ("YmdHis"));
      unlink ("$tmp_dir/$fname");
    }
  }
}

if (!empty ($pid) && !empty ($passid)) {
  // program returns pid and eid for launching patienttabs 
  if ($progress) {
	list($usec, $sec) = explode(' ', microtime());
	$script_end = (float) $sec + (float) $usec;
	$elapsed2 = round($script_end - $script_start, 5);
	$total = round($script_end - $script_begin, 5);       
	$timing = "{ \"exportTime\" : \"" . $elapsed . "\", \"importTime\" : \"" . $elapsed2 . "\" }";
  } else {
	$elapsed = "";
	$elapsed2 = "";
  }
  $output = "{\"success\" : true, \"pid\" : \"" . $pid . "\", \"eid\" : \"" . $passid . "\" , \"exportTime\" : \"" . $elapsed . "\", \"importTime\" : \"" . $elapsed2 . "\"}";
} else {
  $output = "{\"failure\" : true }";
}
echo $output;

?>
