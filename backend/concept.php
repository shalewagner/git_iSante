<?php 
	
/*** get all concept data for an encounter from the obs table 
 *** load it to the existingData global 
 ***/
function getConceptData ($eid, $lid) {
	/*** TODO:
	 *** stop using concept dictionary and start using isanteConcepts
	 *** handle _specify and _date cases 
	 ***/
	 
	$queryStmt = "SELECT c.short_name as fieldName, o.*
		FROM obs o, concept c, concept_datatype cc
		WHERE encounter_id = " . $eid . " AND o.location_id = " . $lid . " AND o.concept_id = c.concept_id and c.datatype_id = cc.concept_datatype_id"; 
	 
	/***	
	$queryStmt = "
		select c.conceptKey as fieldName, o.*
		from obs o, isanteConcepts c
		where o.encounter_id = " . $eid . " and 
		o.location_id = " . $lid . " and
		o.concept_id = c.concept_id";
	 ***/
	 
	$result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search obs table.");  
	
	while ($row = psRowFetch ($result)) {
	  $lab = $row['fieldName'];
	  $val = '';
	  if (!empty($row['value_boolean'])) {
	    $val = $row['value_boolean']; 
	  } else if (!empty($row['value_numeric'])) {
	    $val = $row['value_numeric'];
	  } else if (!empty($row['value_coded'])) {
	    $val = $row['value_coded'];
	  } else if (!empty($row['value_datetime'])) {
	    $val = $row['value_datetime'];
	  } else if ($row['value_text'] != '') {
	    $val = $row['value_text'];
	  }
	  $GLOBALS['existingData'][$lab] = rtrim ($val);
	}
} 

/* fetches the newest occurrance of each tb concept 
 * (should only be called when a new form is initialized, not with updates to forms)
 */
function fetchSaveCarryForwardData () {
	$pid = $GLOBALS['existingData']['patientID']; 
	$eid = $GLOBALS['existingData']['eid'];
	$sql = "
		SELECT c.short_name as fieldName, ymdtodate(e.visitdateyy,e.visitdatemm,e.visitdatedd) as visitdate, 
			o.value_boolean, o.value_numeric, o.value_coded, o.value_datetime, o.value_text
		FROM obs o, concept c, concept_datatype cc, encValidAll e
		WHERE o.encounter_id = e.encounter_id AND 
		o.location_id = e.sitecode AND
		o.concept_id = c.concept_id and 
		c.datatype_id = cc.concept_datatype_id and
		(c.short_name like 'tb%' or short_name in ('propCotrimoxazole','propAzythromycine','propFluconazole','propINHprim','INH secondaire')) and 
		e.patientid = ? order by 1,2 desc
	";    
	 
	$arr = databaseSelect()->query($sql,array($pid))->fetchAll(PDO::FETCH_ASSOC);   
	$userConcepts = array();   
	foreach ($arr as $row) {
		  $lab = $row['fieldName'];
		  if (array_key_exists ( $lab , $userConcepts)) continue;
		  $usedConcepts[] = $lab;
		  $val = '';
		  if (!empty($row['value_boolean'])) {
		    $val = $row['value_boolean']; 
		  } else if (!empty($row['value_numeric'])) {
		    $val = $row['value_numeric'];
		  } else if (!empty($row['value_coded'])) {
		    $val = $row['value_coded'];
		  } else if (!empty($row['value_datetime'])) {
		    $val = $row['value_datetime'];
		  } else if ($row['value_text'] != '') {
		    $val = $row['value_text'];
		  }
		  $GLOBALS['existingData'][$lab] = rtrim ($val);
	}
	$sql = "select currentTreatNo, currentTreatFac, visitdate from a_tbStatus where patientid = ? order by 3 desc limit 1";
	$arr = databaseSelect()->query($sql,array($pid))->fetchAll(PDO::FETCH_ASSOC);
	foreach ($arr as $row) {
		$GLOBALS['existingData']['currentTreatNo'] = $row['currentTreatNo'];
		$GLOBALS['existingData']['currentTreatFac'] = $row['currentTreatFac']; 
		database()->query('insert into tbStatus (sitecode, patientid, visitdateyy, visitdatemm, visitdatedd, seqnum, dbsite, currentTreatNo, currentTreatFac) values (?,?,?,?,?,?,?,?,?)', 
		      array($GLOBALS['existingData']['siteCode'], $pid, date("y"), date("m"), date("d"), $GLOBALS['existingData']['seqNum'], DB_SITE, $row['currentTreatNo'], $row['currentTreatFac']));
	} 
	$cfArray = $GLOBALS['existingData'];
	$cfArray['site'] = $GLOBALS['existingData']['siteCode'];
	$cfArray['type'] = $GLOBALS['existingData']['encounterType'];
	$cfArray['pid'] = $pid;
	$cfArray['eid'] = $eid;
        $cfArray['version'] = $formVersion[$type]; 
	$cfArray['visitDateYy'] = date("y");
	$cfArray['visitDateMm'] = date("m");
	$cfArray['visitDateDd'] = date("d"); 
	insertConceptValues($cfArray);
}

/*** fetch a set of values from the concept dictionary 
 *** match them with the current POST (simple fields)
 ***/
function insertConceptValues ($valueArray) {
	/*** TODO:
	 *** stop using concept dictionary and start using isanteConcepts
	 *** handle _specify and _date cases 
	 ***/
	$lang = "fr";
	$pid = $valueArray['pid'];
	$eid = $valueArray['eid'];
	$site = $valueArray['site'];
	$type = $valueArray['type'];
	$version = $valueArray['version'];
	if ($eid != "") { 
	  $qry = "delete from obs where encounter_id = " . $eid . " and location_id = " . $site;
	  dbQuery ($qry); 
	}

	$qry = "select distinct n.concept_id, n.short_name, d.name 
		from concept_name n, concept c, concept_datatype d 
		where n.concept_id = c.concept_id and 
		c.datatype_id = d.concept_datatype_id";  

/*
	$qry = "select distinct i.concept_id, i.conceptKey as short_name, d.name 
	from isanteConcepts i, concept_datatype d 
	where i.datatype_id = d.concept_datatype_id"; 
*/
	$result = dbQuery($qry);

	$conceptArray = array();
	while ($row = psRowFetch($result)) {
	  $conceptArray[$row[1]] = array($row[0],$row[2]);
	}

	$i = 0;
	foreach ($conceptArray as $conceptName => $conceptType) {
		if (isset($valueArray[$conceptName]) && !empty($valueArray[$conceptName])) {
			$i++;
			$dt = $conceptType[1];
			$dtVal = $valueArray[$conceptName];
			switch ($dt) {
			    case "Date":
			    case "Datetime":
				$dtCol = "value_datetime";
				break;
			    case "Coded":
				$dtCol = "value_coded";
				break;
			    case "Numeric":
				$dtCol = "value_numeric"; 
				if (strcasecmp($valueArray[$conceptName], "On") == 0) {
					$dtVal = 1;
				} else {
					if (!is_numeric($dtVal)) $dtVal = '';
				}
				break;
			    case "Boolean":
				$dtCol = "value_boolean";
				if (strcasecmp($valueArray[$conceptName], "On") == 0 || $dtVal == 1) $dtVal = 1;
				else $dtVal = '';
				break;
			    default:
				$dtCol = "value_text";      
			}
			if ($dtVal != '') {
				dbQuery("insert into obs (person_id, concept_id, encounter_id, location_id, $dtCol) values (" . substr($pid,5) . ", $conceptType[0], $eid, $site, '$dtVal')");
			}
		}
	}  
} 
/*** insert a single row to the obs table
 *** parameters: concept_id, type, and value, insert to the obs table  
 ***/
function singletonConceptInsert($pid, $cid, $eid, $site, $type, $value) {
	if ($type == 'value_text') $value = "'" . $value . "'"; 
	$qry = "insert into obs (person_id, concept_id, encounter_id, location_id, " . $type . ") 
		values (" . substr($pid,5) . ", " . $cid . ", " . $eid . ", " . $site . "," . $value . ")";
	return (dbQuery ($qry) or die('failed'));	
} 


/*** helper function to populate Ext javascript widgets with current value
 *** parameters: concept, xtype, [value of radio item if radio array]
 ***/
function genExtWidget($concept, $xtype, $value) {
  static $alreadyUsedConcepts = array();

  #uniquely identify concept being rendered and make sure it has never been used before on this form
  $conceptUniqueName = $concept;
  if ($xtype == 'radio') {
    $conceptUniqueName = $concept . $value;
  }
/*
  if (array_key_exists($conceptUniqueName, $alreadyUsedConcepts)) {
    print("\nbadconcept: Concept $concept already used on this form. \n");
    #die("Concept $concept already used on this form.");
  } else {
    $alreadyUsedConcepts[$conceptUniqueName] = true;
  }
*/
  $obsValue = $GLOBALS['existingData'][$concept];
  $output = "\t\tid: '" . $concept . $value . "'
	\t\t,name: '" . $concept . "'
	\t\t,xtype: '" . $xtype . "'\n";
  if ($obsValue != '') {
    switch ($xtype) {
    case 'textfield':
    case 'textarea':
      $output .= "\t\t,value: " . json_encode($obsValue) . "\n";
      break;
    case 'datefield':
      $output .= "\t\t,value: " . json_encode(date("d/m/Y", strtotime($obsValue))) . "\n";
      break;
    case 'checkbox':
      if ($obsValue == 1) {
	$output .= "\t\t,checked: true\n";
      }
      break;
    case 'radio':
      $output .= "\t\t,inputValue: " . $value . "\n";
      if ($value == $obsValue) {
	$output .= "\t\t,checked: true\n";
      }
      break;
    case 'numberfield':
      $output .= "\t\t,value: " . json_encode($obsValue) . "\n";
      break;
    } 
  } else {
    switch ($xtype) {
    case 'textfield':
    case 'datefield':
    case 'textarea':
      $output .= "\t\t,value: ''\n";
      break;
    case 'checkbox':
      $output .= "\t\t,checked: false\n";
      break;
    case 'radio':
      $output .= "\t\t,inputValue: " . $value . "\n";
      break;
    }
  }
  return $output;
}

/*** helper function to populate initial array of RadioColumn values
 *** parameters: concept_id, encounter_id
 ***/
function getRadioColumnValue ($curVal) {
	if ($curVal != null) 
		echo $curVal;
	else
		echo "0";
} 

/*** helper function to populate initial array of CheckboxColumn values
 *** parameters: concept_id, encounter_id
 ***/
function getCheckboxColumnValue ($curVal) {
	if ($curVal == "true") 
		echo "true";
	else
		echo "false";
}

/*** fetch the datatype stored for a specific concept
 ***/
function getConceptDatatype ($concept_id) {
	//$qry = "select name from isanteConcepts c, concept_datatype d where c.concept_id = " . $concept_id . " and c.datatype_id = d.concept_datatype_id";
	$qry = "select name from concept c, concept_datatype d where c.concept_id = " . $concept_id . " and c.datatype_id = d.concept_datatype_id";
	$result = dbQuery ($qry);
	$row = psRowFetch ($result);
	return $row[0];
}  

/*** given conceptName, returns concept_id or table_name 
 ***/
function isConcept($conceptName) {
	// check for concept first
	//$qry = "select concept_id from isanteConcepts where conceptKey = '" . $conceptName . "'";
	$qry = "select concept_id from concept where short_name = '" . $conceptName . "'";
	$result = dbQuery($qry); 
	$row = psRowFetch($result);
	$conceptId = $row['concept_id'];
	if (!empty($conceptId)) return ($conceptId);
	else return(isTable($conceptName));
} 

function isTable($conceptName) { 
	// check for column in table
	$qry = "select table_name, concept_class_id as concept_class, concept_datatype_id as data_type from staticConcepts 
		where column_name = '" . $conceptName . "'";
	$result = dbQuery($qry);
	$row = psRowFetch($result); 
	if (!empty($row)) {
		$table = $row['table_name'];
		$conceptClass = $row['concept_class'];
		$conceptDatatype = $row['data_type'];
		return ($table . ":" . $tableClass['$table'] . ":" . $dt);	
		// TODO: also check whether this is coming from a normalized table  
	} 
	else return("");	                                                                   
}

/*** given conceptName, returns all it's attributes in an array
 *** for concepts only, not table columns
 ***/
function getConcept($conceptId) {
	$thisConcept = array();
	// direct concept attributes
	$qry = "select * from concept where concept_id = '" . $conceptId . "'";
	$result = dbQuery($qry);  
	$row = psRowFetch($result);
	$thisConcept['concept'] = $row;
	// concept_name attributes
	$qry = "select * from concept_name where concept_id = '" . $conceptId . "'";	
	$result = dbQuery($qry); 
	while ($row = psRowFetch($result)) {
		if ($row['locale'] == 'en') $thisConcept['nameEn'] = $row;
		else $thisConcept['nameFr'] = $row;
	} 
	return ($thisConcept);
}

/*** TODO 
 *** the rest of these function need to operate on BOTH the concept dictionary AND the isanteConcepts table, keeping them in sync 
 *** after we have started maintaining the concepts properly
 ***/
 
/*** given conceptName, english and french labels, class, datatype; creates new concept
 ***/
function addConcept($conceptName, $enLabel = "", $frLabel = "", $description = "", $classId = 4, $datatypeId = 10) {
	$conceptId = isConcept($conceptName);  
	if (!empty($conceptId)) {
		$retVal = modifyConcept($conceptId, $enLabel, $frLabel, $description, $classId, $datatypeId);  
	} else {
		$qry = "select max(concept_id) + 1 as newId from concept";
		$result = dbQuery($qry);
		$row = psRowFetch($result);
		$conceptId = $row['newId'];
		   $qry = "insert into concept (concept_id, short_name, description, class_id, datatype_id, date_created) 
			values (" . $conceptId . ",\"" . $conceptName . "\",\"" . $description . "\"," . $classId . "," . $datatypeId . ",getDate())";
		$result = dbQuery($qry);
		$qry = "insert into concept_name (concept_id, name, short_name, description, locale, date_created) 
			values (" . $conceptId . ",\"" . $enLabel . "\",\"" . $conceptName . "\",\"" . $description . "\",\"en\",getDate())"; 
		$result = dbQuery($qry); 
		$qry = "insert into concept_name (concept_id, name, short_name, description, locale, date_created) 
			values (" . $conceptId . ",\"" . $frLabel . "\",\"" . $conceptName . "\",\"" . $description . "\",\"fr\",getDate())";
		$result = dbQuery($qry); 
	}	
	return ($conceptId);	
}

/*** change labels, class, datatype, and description for a concept
 ***/ 
function modifyConcept($conceptId, $enLabel = "", $frLabel = "", $description = "", $classId = 4, $datatypeId = 10) {
	$qry = "update concept set description = \"" . $description . "\" , class_id = " . $classId . ", datatype_id = " . $datatypeId . " where concept_id = " . $conceptId;
	$result = dbQuery($qry);
	$qry = "update concept_name set name = \"" . $enLabel . "\", description = \"" . $description . "\" where concept_id = " . $conceptId . " and locale = \"en\"";
	$result = dbQuery($qry);
	$qry = "update concept_name set name = \"" . $frLabel . "\", description = \"" . $description . "\" where concept_id = " . $conceptId . " and locale = \"fr\"";
	$result = dbQuery($qry);
	return (true);
}  

/*** deletes an existing concepts
 ***/
function deleteConcept($conceptId) {
	$qry = "delete from concept where concept_id = " . $conceptId;
	$result = dbQuery($qry);
	$qry = "delete from concept_name where concept_id = " . $conceptId;
	$result = dbQuery($qry);
	return (true);	
}

?>
