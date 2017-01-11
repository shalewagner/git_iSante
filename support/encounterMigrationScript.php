<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$username="cirgadmin";
$password="Viebuetai7";
$database="openmrs";
print system('date') . "<br>";
$con = mysqli_connect('localhost',$username,$password);
mysqli_select_db($con, $database) or die("Unable to select database");

// make an array of all tables we want to migrate
//$tables = array( 'vitals', 'arvAndPregnancy', 'arvEnrollment ', 'a_conditions ', 'a_drugs ', 'medicalEligARVs', 'a_riskAssessments', 'tbStatus');
$tables = array('medicalEligARVs');
//$tables = array('temp');
$savedCellCounter = 0;
for ($i = 0; $i < count($tables); $i++) {
	
	// Outer query: for each table, join to OpenMRS encounter and iSante table to retrieve key info and table row info for insert
	$query = "select e.encounter_id, e.patient_id, e.location_id, t.*
		from encounter e, itech.encounter f, itech." . $tables[$i] .  " t
		where e.uuid = f.encGuid and
		f.patientid = t.patientid and f.sitecode = t.sitecode and f.visitdateyy = t.visitdateyy and f.visitdatemm = t.visitdatemm and f.visitdatedd = t.visitdatedd and f.seqNum = t.seqNum
	    order by 1 desc";

	$result = mysqli_query($con,$query);

	// generate array of columns from the $row query	
	$columns = array();
	// don't care about key fields for matching $row data columns, so skip them in the $column array
	$skip_col = array($tables[$i] . '_id', 'encounter_id', 'patient_id', 'location_id', 'patientID', 'siteCode', 'visitDateYy', 'visitDateMm', 'visitDateDd', 'seqNum', 'dbSite');
	while ($col=mysqli_fetch_field($result)) {
		if ( ! in_array($col->name,$skip_col,TRUE)) {
				$columns[] = $col->name;
		}
	}
	
	// Fetch the spreadsheetMap columns for the current table into an array
	/* create statement for spreadsheetMap table:
		create table spreadsheetMap (
		isante_field varchar(100),
		isante_value varchar(100),
		question int,
		answer int,
		group_id int,
		obsColumn varchar(25)
		)
		*/
	$qry2 = "select isante_field, ifnull(isante_value,0) as isante_value, question, ifnull(answer,0) as answer, group_id, obsColumn 
		from spreadsheetMap 
		where isante_table = '" . $tables[$i] . "' 
		order by 1";
	$result2 = mysqli_query($con,$qry2);
	$spreadsheetArray = array();
	while ($row2 = mysqli_fetch_assoc($result2)) {
		$spreadsheetArray[] = $row2;
	}
	mysqli_free_result($result2);

	// loop on $row data
	$rowFieldCounter = 0;
	$savedCellCounter = 0;
	while ($row = mysqli_fetch_assoc($result)) {
		// for each iSanté field in table, compare against spreadsheet; construct obs insert statement; and execute it
		foreach ($columns as $rowColumn) {
			$rowFieldCounter++;
		  	if ($row[$rowColumn] === '' || is_null($row[$rowColumn]) || $row[$rowColumn] === NULL || $row[$rowColumn] === 0 || $row[$rowColumn] === '0') continue;
			foreach ($spreadsheetArray as $spreadsheetRow) {
					// multiple isante values possible
					// check for date field
					$spreadsheetColumn = $spreadsheetRow['isante_field'];
					$dateFldArray = array();
					$dateFldArray = explode(",", $spreadsheetColumn);
					if (count($dateFldArray) > 1) {
						$row[$rowColumn] = combineDateFields($dateFldArray, array($row[$dateFldArray[0]],$row[$dateFldArray[1]],$row[$dateFldArray[2]])); 
						$spreadsheetColumn = $dateFldArray[0];
					}
					if (strcmp($spreadsheetColumn,$rowColumn) === 0) {
						if ($row[$rowColumn] == $spreadsheetRow['isante_value'] && $spreadsheetRow['answer'] > 0) {
							$sql = "insert into obs (encounter_id, person_id, location_id, obs_datetime, concept_id," . $spreadsheetRow['obsColumn'] . ",creator,date_created) 
								values (" . $row['encounter_id'] . "," . $row['patient_id'] . "," . $row['location_id'] . ",ymdToDate(" . $row['visitDateYy'] . "," . $row['visitDateMm'] . "," . $row['visitDateDd'] . ")," . $spreadsheetRow['question'] . "," . $spreadsheetRow['answer'] . ",1,now())";
							print "case 1: " . $sql;
							print "<br>";
							if ($con->query($sql) != TRUE) {
								print "<br>";
								print $con->error;
								exit;
							}
							$savedCellCounter++;
						} 
						if ($spreadsheetRow['answer'] <= 0) {
							$sql = "insert into obs (encounter_id, person_id, location_id, obs_datetime, concept_id," . $spreadsheetRow['obsColumn'] . ",creator,date_created) 
								values (" . $row['encounter_id'] . "," . $row['patient_id'] . "," . $row['location_id'] . ",ymdToDate(" . $row['visitDateYy'] . "," . $row['visitDateMm'] . "," . $row['visitDateDd'] . ")," . $spreadsheetRow['question'] . "," . $row[$rowColumn] . ",1,now())";
							print "case 2: " . $sql;
							print "<br>";
							if ($con->query($sql) != TRUE) {
								print "<br>";
								print $con->error;
								exit;
							}
							$savedCellCounter++;
						}
		/* for each matching field in spreadsheetMap, do the correct insert
			 * determine which case we are dealing with
			 * if table is obs, then ciel_id 
			 * 1. iSanté de-normalized table and specific column value --> specific CEIL concept_id value
			 * 2. iSanté concept (short_name) obs value                --> specific CEIL concept_id value
			 * 3. iSanté normalized table with foreign key             --> CEIL concept_id or question/answer id pair
			 * 4. iSanté table/column coded value                      --> CEIL concept_id or question/answer id pair  
			 * 5. iSanté concept coded value                           --> CEIL concept_id or question/answer id pair 
			 * 6. iSanté repeating (non-normalized) values             --> CEIL concept_id or question/answer id pair
		*/
					}
			}	
		}
		//print "<br>Count so far: " . $savedCellCounter . "<br>";
		//if ($rowFieldCounter > 500000) break;
	}
	mysqli_free_result($result);
        print "<br>all cells: " . $rowFieldCounter;
        print "<br>non-null cells: " . $savedCellCounter;
        print "<br>ratio: " . $savedCellCounter/$rowFieldCounter . "<br>" . system('date');
}
function combineDateFields($inFields,$outFields) {
	$yy = (is_numeric($inFields[0])) ? $outFields[0]:2016;
	$mm = (is_numeric($inFields[1])) ? $outFields[1]:1;
	$dd = (is_numeric($inFields[2])) ? $outFields[2]:1;
	return "ymdTodate(" . $yy . "," . $mm . "," . $dd . ")";
}
?>
