<?php
include ("include/standardHeader.php");
$time_start = microtime_float();
set_time_limit(600);
echo "
<title>Load form field errors to database table (one time use)</title>
<body>
<form name=\"mainForm\">
 <table class=\"header\">
   <tr>
	<td class=\"m_header\">Load form field errors to database table (one time use)</td>
   </tr>
 </table>";
// loop through each type of form
for ($encTypeCounter = 2; $encTypeCounter < 3; $encTypeCounter++) {
	$formErrorsOfTypeCounter = 0;
	// Hit database to get list of fields that need to be validated
    $valData1 = getValidations ($encTypeCounter, "formVersion = 1");
    $valData0 = getValidations ($encTypeCounter, "(formVersion = 0 OR formVersion IS NULL)");
	// query to get all encounters for the site
	$qry = "select e.encounter_id as eid, e.formVersion from encounter e, encounter f where 
		e.patientid = f.patientid and f.encounterType in (10,15) and e.sitecode = '" . $site . "' and
		e.encountertype = " . $encTypeCounter . " and
		e.encStatus < 255 order by 1";
	$result = dbQuery ($qry) or die ("FATAL ERROR: Couldn't search encounter.");
	// for each encounter of the current type
	while ($row = psRowFetch ($result)) {
		// load an form at a time into the $existingData array
		$eid = $row['eid'];
		$fv = $row['formVersion'];
		$existingData = array();
		getExistingData ($eid, $tables);
		// submit the record to the validation check
		$errors = array();
		if ($fv == 1)
			$errors = getMyErrors ($existingData, $encTypeCounter, $valData1, $time_start);
		else
			$errors = getMyErrors ($existingData, $encTypeCounter, $valData0, $time_start);
		if (!empty($errors)) {
			$kstring = "";
			$vstring = "";
			foreach ($errors as $k => $v) {
				if ($kstring != "") $kstring .= "," . $k;
				else $kstring = $k;
				if ($vstring != "") $vstring .= "," . $v;
				else $vstring = $v;
			   $formErrorsOfTypeCounter++;
			}
			insertFormErrors ($eid, $kstring, $vstring);
		}
	}
	if ($formErrorsOfTypeCounter > 0)
		echo "Total: " . $encType[$lang][$encTypeCounter] . ": " . $formErrorsOfTypeCounter . "<br>";
}
set_time_limit(30);
echo "
    </form>
  </body>
</html>";
function getMyErrors (&$arr, $type = 0, $valData, $time_start) {
  $errors = array ();
  // Populate error message list if any errors found
  $mand_missing = 0;
  foreach ($valData as $row) {
    $err_list = array ();
    // Trim the data field, if empty several validation checks can be skipped
    $t = (isset ($arr[$row['fieldName']]) && strlen ($arr[$row['fieldName']]) > 0) ? trim ($arr[$row['fieldName']]) : "";
	if (strlen ($t) < 1) $lenFlag = true;
	else $lenFlag = false;
	$currError = false;
    // Check if field is mandatory
    if ($row['fieldMandatory']) {
      if ($lenFlag) {
        if (!in_array ('nonBlank', $err_list)) {
			array_push ($err_list, 'fieldMandatory');
			$currError = true;
		}
      }
    }

	if (!$currError) {
	    // Check if non-mandatory field must be non-blank
	    if ($row['fieldMandatory'] != 1 && $row['fieldMustNotBeBlank']) {
	      if ($lenFlag) {
	        if (!in_array ('nonBlank', $err_list)) {
				array_push ($err_list, 'nonBlank');
				$currError = true;
			}
	      }
	    }
	}

	if (!$currError) {
	    // Check value against field's regex, if exists
	    if (!empty ($row['fieldRegEx']) && !$lenFlag) {
	      if (!preg_match ($row['fieldRegEx'], $t)) {
	        if (!in_array ('badValue', $err_list)) { 
				array_push ($err_list, 'badValue');
				$currError = true;
			}
	      }
	    }
	}
	if (!$currError) {	
	    // Check value against upper and lower bounds, if they exist
	    if (!empty ($row['fieldLowerBound']) && !$lenFlag) {
	      // This check only makes sense for numeric data
	      if (is_numeric (str_replace (',', '.', $t)) && $t < $row['fieldLowerBound']) {
	        if (!in_array ('badValue', $err_list)) {
				array_push ($err_list, 'LowerBoundViolation');
				$currError = true;
			}
		  }
	    }
	}
	if (!$currError) {
	    if (!empty ($row['fieldUpperBound']) && !$lenFlag) {
	      // This check only makes sense for numeric data
	      if (is_numeric (str_replace (',', '.', $t)) && $t > $row['fieldUpperBound']) {
	        if (!in_array ('badValue', $err_list)) { 
				array_push ($err_list, 'UpperBoundViolation');
				$currError = true;
			}
	      }
	    }
	}
	if (!$currError) {
	    // Check linked fields or arbitrary SQL query, if exists
	    $bracket = '';
	    if (!empty ($row['fieldLinkage']) &&
	        ($row['checkLinkageIfBlank'] == 1 || !$lenFlag)) {
	      $res = doValidationQuery ($arr['eid'], $row['fieldLinkage']);
	      if (strpos($row['fieldLinkage'], 'Checkbox')) {
	        $bracket = '[]';
	      }
	      foreach ($res as $r) {
	        if (!in_array ($r, $err_list)) { 
				array_push ($err_list, $r);
				$currError = true;
			}
	      }
	    }
	}

    if ($currError) {
      $errors[$row['fieldName'] . $bracket] = $err_list;
    }
  }
  return ($errors);
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
?>