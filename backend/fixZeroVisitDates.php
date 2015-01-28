<?php
function fixZeroVisitDates() {
	#$fp = fopen("fixZeroVisits.log", "w");
	#fwrite($fp, "started: " . date("h:i:s") . "\n");
	$sql = "select count(*) from encounter where visitdateyy = ''";
	$result = dbQuery($sql);
	$row = psRowFetch($result);
	#fwrite($fp, "Current count of rows with zero date: " . $row[0] . "\n\n");
	if ($row[0] == 0) return;
	$sql = "
	select patientid, encounter_id, lastmodified, rtrim(ltrim(visitdateyy)) as visitdateyy, visitdatemm, visitdatedd, dbSite, encounterType as encType, seqNum, siteCode
	from encounter where patientid in (select patientid from encounter where rtrim(ltrim(visitdateyy)) = '')
	order by patientid, encounter_id";
	$result = dbQuery($sql);
	while ($row = psRowFetch($result)) {
		$finalArray[] = $row;
	}
	$countFixedRecords = 0;
	for ($i = 1; $i < count($finalArray)-1; $i++) {
		if ( $finalArray[$i]['visitdateyy'] == "") {
			#fwrite($fp, "\n" . $finalArray[$i-1]['encounter_id'] . "\n");
			#for ($j = 0; $j < 6; $j++) 
				#fwrite($fp, $finalArray[$i][$j] . " ");
			#fwrite($fp, "\n");
			#fwrite($fp, $finalArray[$i+1]['encounter_id']);
			if ($finalArray[$i-1]['patientid'] == $finalArray[$i]['patientid']) $beforeDiff = intval($finalArray[$i]['encounter_id']) - intval($finalArray[$i-1]['encounter_id']);
			else $beforeDiff = 0;
			if ($finalArray[$i+1]['patientid'] == $finalArray[$i]['patientid']) $afterDiff = intval($finalArray[$i+1]['encounter_id']) - intval($finalArray[$i]['encounter_id']);
			else $afterDiff  = 0;
			#fwrite($fp, "    Diffs: " . $beforeDiff . " " . $afterDiff . "\n");
			if (($beforeDiff != 0 && $beforeDiff <= $afterDiff) || ($afterDiff == 0 && $beforeDiff > 0)) 
				updateModule($finalArray[$i]['encounter_id'], $finalArray[$i]['patientid'], $finalArray[$i]['dbSite'], $finalArray[$i-1]['visitdateyy'], $finalArray[$i-1]['visitdatemm'], $finalArray[$i-1]['visitdatedd'], $finalArray[$i]['encType'], $finalArray[$i]['seqNum'], $finalArray[$i]['siteCode']);
			else if (($afterDiff != 0 && $afterDiff < $beforeDiff) || ($beforeDiff == 0 && $afterDiff > 0)) 
				updateModule($finalArray[$i]['encounter_id'], $finalArray[$i]['patientid'], $finalArray[$i]['dbSite'], $finalArray[$i+1]['visitdateyy'], $finalArray[$i+1]['visitdatemm'], $finalArray[$i+1]['visitdatedd'], $finalArray[$i]['encType'], $finalArray[$i]['seqNum'], $finalArray[$i]['siteCode']);
			$countFixedRecords++;
		} else {
			#for ($j = 0; $j < 6; $j++) 
				#fwrite($fp, $finalArray[$i][$j] . " ");
			#fwrite($fp, "\n");			
		}
	}
	#fwrite($fp, "Fixed " . $countFixedRecords . " record(s) Ended: " . date("h:i:s"));
}
function updateModule($eid, $pid, $dbSite, $yr, $mo, $day, $encType, $seqNum, $siteCode) {
	if ($yr == "") {
		#fwrite($fp, "\nXXXXXXgot null values in the updateModule: " . $eid . " " . $pid . "\n");
		return;
	}
	#fwrite($fp, $eid . "\t" . $pid . "\t" . $dbSite . "\t" . $yr . "\t" . $mo . "\t" . $day . "\t" . $encType . "\t" . $seqNum . "\t" . $siteCode . "\n");

	$tables = array ("adherenceCounseling", "allergies", "allowedDisclosures", "arvAndPregnancy", "arvEnrollment", "buddies", "comprehension", "conditions", "discEnrollment", "drugs", "followupTreatment", "homeCareVisits", "householdComp", "immunizations", "labs", "medicalEligARVs", "needsAssessment", "otherDrugs", "otherLabs", "otherPrescriptions", "patientEducation", "pedHistory", "pedLabs", "prescriptions", "referrals", "tbStatus", "vitals", "riskAssessment", "riskAssessments", "prescriptionOtherFields");

	$beforeWhere = getEncounterWhere ($eid, $pid);
	
	$qry = "select count(*) from encounter where patientid = '" . $pid . "' and visitdateyy = '" . $yr . "' and visitdatemm = '" . $mo . "' and visitdatedd = '" . $day . "' and encounterType = " . $encType . " and seqNum = " .  $seqNum . " and sitecode = '" .  $siteCode . "'";
	$result = dbQuery ($qry);
	$row = psRowFetch($result);
	if ($row[0] == 1) {
		#fwrite($fp, "row already exists, don't really have a problem with this row and will delete the null date one");
		$qry = "delete from encounter where " . $beforeWhere; 
		#fwrite($fp, "\n" . $qry);
		$result = dbQuery($qry) or die ("failed to delete blank encounter record");
		return;
	} 

	$qry = "update encounter set visitdateyy = '" . $yr . "', visitdatemm = '" . $mo . "', visitdatedd = '" . $day . "' where encounter_id = " . $eid . " and dbSite = " . $dbSite;
	#fwrite($fp, "\n" . $qry); 
	$result = dbQuery($qry) or die ("failed to update encounter");
	
	$afterWhere = getEncounterWhere ($eid, $pid);
	
	if ($afterWhere != "") {
		// do update for each record with matching keys
		foreach ($tables as $table) {
			// need _id to determine if correctDate records are older or newer than blankdate records
			// in the case of normalized tables--assume that the first record that comes back is a good proxy for the _id range
	    	$qry = "select " . $table . "_id from " . $table . " where " . $afterWhere;
	    	#fwrite($fp, "\n" . $qry); 
	    	$result = dbQuery($qry);
			$correctID = 0;
			if ($result) {
	    		$row = psRowFetch ($result);
				$correctID = $row[0];
			}
	    	$qry = "select " . $table . "_id from " . $table . " where " . $beforeWhere;
	    	#fwrite($fp, "\n" . $qry); 
	    	$result = dbQuery($qry);
			$blankID = 0;
			if ($result) {
	    		$row = psRowFetch ($result);
				$blankID = $row[0];
			}
			if ($blankID > $correctID) { // blank one is newer
			    if ($correctID > 0) { // must delete the afterID(s) so unique logical key constraint is not violated
					$qry = "delete from $table where " . $afterWhere; 
					#fwrite($fp, "\n" . $qry);
	    			$result = dbQuery($qry) or die ("failed to delete row " . $correctID . " from table " . $table); 
			    }
				$qry = "update " . $table . " set visitdateyy = '" . $yr . "', visitdatemm = '" . $mo . "', visitdatedd = '" . $day . "' where " . $beforeWhere;
				#fwrite($fp, "\n" . $qry); 
				$result = dbQuery($qry) or die ("failed to update table " . $table);
			} 
		}
	}
}
?>
