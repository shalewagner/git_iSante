<?php

// By-pass auth check
$_REQUEST["noid"] = true;

require_once ("backend.php");

$continue = SERVER_ROLE == "consolidated" ? false : true;

// If GET request, assume someone's testing the connection, reply appropriately
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  echo _('Connexion réussie. C´est le service de réception de laboratoire résultat pour iSanté.');
  exit;
}

// Read and parse XML string in from POST data
$results = file_get_contents ("php://input");

if ($results === false || strlen ($results) < 1) {
  // Couldn't read POST data or it's empty, send an error to the sender
  header ("HTTP/1.1 500 Internal Server Error");
  $continue = false;
}

// Don't make the sender wait for processing of the POST, just send OK
// and close the connection
header ("Content-Length: 0");
header ("Content-Type: text/html; charset=utf-8");
header ("Connection: close");
flush ();

if (!$continue) exit;

$resultsXml = simplexml_load_string ($results);
$siteName = $resultsXml->xpath ("sending-site-name");
$siteCode = $resultsXml->xpath ("sending-site-id");
$xferDate = $resultsXml->xpath ("transmission-date");

database()->query ('
  INSERT INTO labMessageStorage (dbSite, senderName, senderSiteCode, receiptDateTime,
   originalXmitDateTime, message) VALUES (?, ?, ?, ?, ?, ?)',
	array (DB_SITE, $siteName[0], $siteCode[0], date ("c"), $xferDate[0], $resultsXml->asXML()));

$data = database()->query ('SELECT last_insert_id() AS id')->fetchAll();
$storageID = $data[0]["id"];

// Loop through results and store them in the labs table
$nodeCnt = 0;
$skips = array ();
$resultNodes = $resultsXml->xpath ("test-results");
foreach ($resultNodes as $node) {
  $nodeCnt++;

  // Workaround for a bug in the generation of the lab results XML. If a test
  // has more than one result, the XML will contain duplicate <test-results>
  // blocks, one for each result, i.e. 3 <results> blocks = 3 <test-results>
  // blocks (all with the same 3 <results> blocks). So, we need to keep track
  // of a list of <test-results> nodes to skip.
  if (in_array ($nodeCnt, $skips)) continue;

  // Pull specific data out of the <test-results> node
  $guid = $node->xpath ("patient-guid");
  $testDate = $node->xpath ("test-date");
  $accNo = $node->xpath ("accession-number");
  $status = $node->xpath ("status");
  $sampType = $node->xpath ("sample-type");
  $res = $node->xpath ("results");
  $range = $node->xpath ("normal-range");
  $test = $node->xpath ("test");
  $section = $node->xpath ("test-section");
  $valid = $node->xpath ("valid-range");
  $notes = $node->xpath ("test-notes");
  $orderId = $node->xpath ("referring-order-number");

  // If multiple results, add duplicates to skip list (see comment above)
  for ($i = 1; $i < count ($res); $i++) {
    $skips[] = $nodeCnt + $i;
  }

  // Lookup the patientID based on their GUID
  $pid = getPidByOtherID ($guid[0], "", "patGuid");
  // If the patient is not found, log error and skip processing this result
  if (empty ($pid)) {
    logError ("labResultPidError", array ("patGuid" => $guid[0]));
    continue;
  }

  // Lookup the encounter_id for the patient's 'external lab results' encounter
  $eid = getExternalLabEncID ($pid);

  // If the encounter is not found, try to create it now
  if (empty ($eid)) {
    $eid = addEncounter ($pid, date ("d"), date ("m"), date ("y"), substr ($pid, 0, 5), date ("Y-m-d H:i:s"), 13, "External Lab Results Container", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, date ("Y-m-d H:i:s"));
    // If empty here, log error and skip
    if (empty ($eid)) {
      logError ("labResultEidError", array ("pid" => $pid));
      continue;
    }
  }

  // This will populate a SQL 'where' clause that can be used to update an
  // existing lab result (if the incoming result is marked as an 'update').
  // It also populates the database key fields in the $GLOBALS["existingData"]
  // array (which is useful for later call to 'setByEncounterID').
  $encWhere = " WHERE " . getEncounterWhere ($eid, $pid);

  // Find a matching lab test to use for storing this result, or store in
  // the 'otherLabs' table if no match found.
  // Only have name to match on now, should use LOINC when available
  $tblName = "";
  $insertVals = array ();
  $lookupData = findMatchingTest ((string) $test[0]->attributes()->displayName,
                                  (string) $sampType[0]->attributes()->displayName);

  // Loop over results and append multiple elements into a single string
  $tblName = "";
  $finalResult = "";
  $finalType = "";
  $finalStatus = "";
  foreach ($res as $r) {
    // Pull out data elements from the <results> node
    $type = $r->xpath ("type");
    $updStatus = $r->xpath ("update-status");
    $result = $r->xpath ("result");

    $finalType = decodeType ($type[0]);
    $finalStatus = (string) $updStatus[0];
    if (strlen ($finalResult) > 0) $finalResult .= ", ";
    $finalResult .= (string) $result[0]->attributes()->displayName;
  }

  // Data elements common to matched and non-matched tests
  $ts = date ("U", strtotime ((string) $xferDate[0]));
  $data = database()->query ('SELECT FROM_UNIXTIME(?) AS localStamp', array ($ts))->fetchAll();
  $insertVals["accessionNumber"] = (string) $accNo[0];
  $insertVals["externalResultType"] = sqlEscape ($finalType);
  $insertVals["labGroup"] = sqlEscape ((string) $section[0]);
  $insertVals["labMessageStorage_id"] = $storageID;
  $insertVals["labMessageStorage_seq"] = $nodeCnt;
  $insertVals["loincCode"] = (string) $test[0]->attributes()->code;
  if (!empty ($range[0])) {
    $insertVals["minValue"] = sqlEscape ((string) $range[0]->attributes()->low);
    $insertVals["maxValue"] = sqlEscape ((string) $range[0]->attributes()->high);
    $insertVals["units"] = sqlEscape ((string) $range[0]->attributes()->units);
  }
  $insertVals["result"] = sqlEscape ($finalResult);
  $insertVals["resultDateDd"] = date ("d", strtotime ($data[0]["localStamp"]));
  $insertVals["resultDateMm"] = date ("m", strtotime ($data[0]["localStamp"]));
  $insertVals["resultDateYy"] = date ("y", strtotime ($data[0]["localStamp"]));
  $insertVals["resultRemarks"] = str_replace(
    array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
    array('\\\\', '\\0', '\\n', '\\r', "''", '\\"', '\\Z'),
    (string) $notes[0]);
  $insertVals["resultTimestamp"] = $data[0]["localStamp"];
  $insertVals["sampleType"] = sqlEscape ((string) $sampType[0]->attributes()->displayName);
  $insertVals["sendingSiteName"] = sqlEscape ((string) $siteName[0]);
  $insertVals["sendingSiteID"] = sqlEscape ((string) $siteCode[0]);
  if (!empty ($valid[0])) {
    $insertVals["validRangeMin"] = sqlEscape ((string) $valid[0]->attributes()->low);
    $insertVals["validRangeMax"] = sqlEscape ((string) $valid[0]->attributes()->high);
  }

  // Set non-common values, then store the row
  if (!empty ($lookupData["labID"])) {
    $tblName = "labs";
    $insertVals["labID"] = $lookupData["labID"];
    $insertVals["testNameFr"] = sqlEscape ((string) $test[0]->attributes()->displayName);

    // If an updated result, set resultStatus = 1 and also update any previous
    // tests marking them as superseded (resultStatus = 2).
    if ($finalStatus == "update") {
      $insertVals["resultStatus"] = 1;
      supersedeResults ($pid, $insertVals["testNameFr"], $insertVals["sampleType"], $data[0]["localStamp"]);
    }
  } else {
    $tblName = "otherLabs";
    $insertVals["labName"] = sqlEscape ((string) $test[0]->attributes()->displayName);
  }
  if (!empty ($insertVals)) {
#    print_r ($insertVals);
    setByEncounterID ($eid, " WHERE false", $tblName, $insertVals);

    // And update the lastModified date in the encounter record for replication
    setByEncounterID ($eid, $encWhere, "encounter", array ("lastModified" => date("c")));

    // Finally, enter the accession number into the encounterQueue table if
    // an existing lab order with matching id exists there.  This will help
    // us link incoming results back to their original order.
    if (!empty ($insertVals["accessionNumber"]) && !empty ($orderId[0])) {
      setQueueAccessionAndStatusById (substr (stristr ((string) $orderId[0], "-"), 1), substr ($insertVals["accessionNumber"], 0, strpos ($insertVals["accessionNumber"], "-")), 6);
    }
  } else {
    logError ("labResultInsError", array ("pid" => $pid, "eid" => $eid, "tblName" => $tblName));
  }
}

function sqlEscape ($in) {
  return (str_replace ("'", "''", $in));
}

function getExternalLabEncID ($pid) {
  // Return the encounter_id for the patient's external lab results encounter
  $result = database()->query ('
    SELECT encounter_id AS eid
    FROM encounter
    WHERE encounterType = ?
     AND patientID = ?',
    array (13, $pid))->fetchAll();
  return ($result[0]["eid"]);
}

function findMatchingTest ($name, $sampType) {
  $data = database()->query ('
    SELECT labID, labGroup
    FROM labLookup
    WHERE LCASE(testNameFr) = LCASE(?)
     AND labID > 1000
     AND LCASE(sampleType) = LCASE(?)',
    array ($name, $sampType))->fetchAll();
  return (array ("labID" => $data[0]["labID"],
                 "labGroup" => $data[0]["labGroup"]));
}

function logError ($label, $params = array ()) {
  $defaultParams = array ("siteName" => $siteName[0],
                          "siteCode" => $siteCode[0],
                          "xferDate" => $xferDate[0],
                          "storageID" => $storageID,
                          "storageSeq" => $nodeCnt
                   );
  recordEvent ($label, array_merge ($params, $defaultParams));
}

function decodeType ($in) {
  $decodedType = "";
  switch ($in) {
    case "NM":
      $decodedType = "Numeric";
      break;
    case "TX":
      $decodedType = "Free Text";
      break;
    default:
      $decodedType = "";
      break;
  }
  return ($decodedType);
}

function supersedeResults ($pid, $labName, $sampleType, $ts) {
  database()->query ('
    UPDATE labs
    SET resultStatus = 2, supersededDate = ?
    WHERE patientID = ?
     AND labID > 1000
     AND LCASE(testNameFr) = ?
     AND LCASE(sampleType) = ?
     AND (resultStatus = 0 OR resultStatus = 1)
     AND supersededDate IS NULL',
  array ($ts, $pid, strtolower (str_replace ("''", "'", $labName)), strtolower (str_replace ("''", "'", $sampleType))));
}

?>
