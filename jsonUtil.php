<?php   

include ("backend.php");

$task = ($_REQUEST['task']) ? ($_REQUEST['task']) : null;

switch($task){
    case "read":
        showData();
        break;
    case "saveData":
    case "update":
    case "insert":
	saveData();
	break;
    case "delete":
        deleteData();
        break;
    case "encounterKeysChanged":
	util($tables);
	break; 
    case "exam":
    case "habits":
    case "relatives":
    case "blood":
    case "vaccines":
    case "vitals":
    case "dx":
    case "femmes":
    case "results": 
    case "symptoms": 
	conceptUpdate ($task);
	break;
    case "updateDD":
	updateDD();
	break;
    case "readDD":
	readDD();
	break; 
    case "toggleHivStatus":
	toggleHivStatus();
	break;   
    default:
        echo "{failure:true}";
        break;
}//end switch
    
function showData(){ 
    $sql = stripslashes($_REQUEST['query']);
    $result = dbSelectQuery($sql);
    $rows = 0;
    while($rec = psRowFetchAssoc($result)) {
        $rec['conditionComment'] = stripslashes($rec['conditionComment'] );
        $arr[] = $rec;
        $rows++;
    }

    $data = json_encode($arr);  
    echo '({"total":"' . $rows . '","results":' . $data . '})';
}//end showData 

function readDD(){
	$formVersion =  $_REQUEST['formVersion'];
	$encType =  $_REQUEST['encType'];
	$conceptKey = $_REQUEST['conceptKey'];
	$fieldLabel = $_REQUEST['fieldLabel'];
	if ($formVersion == "%") 
		$sql = stripslashes("select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.concept_id as conceptOrTable, c.class_id as concept_class_id, 
			c.datatype_id as concept_datatype_id from isanteForms e left join concept c on e.conceptKey = c.short_name 
		where conceptKey not in (select column_name from staticConcepts) and (e.conceptKey like '%" . $conceptKey . "%' and (e.labelEn like '%" . $fieldLabel . "%' or e.labelFr like '%" . $fieldLabel . "%')) union 
		select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.table_name, c.concept_class_id, c.concept_datatype_id from isanteForms e, staticConcepts c 
		where e.conceptKey = c.column_name and (e.conceptKey like '%" . $conceptKey . "%' and (e.labelEn like '%" . $fieldLabel . "%' or e.labelFr like '%" . $fieldLabel . "%')) order by 1,3,4"); 
	else
		$sql = stripslashes("select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.concept_id as conceptOrTable, c.class_id as concept_class_id, 
			c.datatype_id as concept_datatype_id from isanteForms e left join concept c on e.conceptKey = c.short_name 
		where e.encType = " . $encType . " and e.formVersion = " . $formVersion . " union 
		select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.table_name, c.concept_class_id, c.concept_datatype_id from isanteForms e, staticConcepts c 
		where e.conceptKey = c.column_name and e.encType = "  . $encType . " and e.formVersion = " . $formVersion . " order by 1,3,4");	
    $result = dbQuery($sql);
    $rows = 0;
    while($rec = psRowFetchAssoc($result)) {
        $arr[] = $rec;
        $rows++;
    }
    $data = json_encode($arr);  
    echo '({"total":"' . $rows . '","results":' . $data . '})';
} //end readDD

function saveData(){
	$table = $_REQUEST['table'];  
	$records = json_decode($_REQUEST['data']);  

	$jj = 0;
	$count = 0;
	foreach($records as $record) {
		$nameString = '';
		$valueString = '';
		$updateString = '';   
	    $ii = 0;
		foreach($record as $key => $value) {
			if ($nameString != '') {
				$nameString .=  ",";
				$valueString .= ","; 
			}
			$nameString .= $key;
			$valueString .= "'" . $value . "'";
			if ($updateString != '') $updateString .= ",";  
			$updateString .= $key . " = '" . $value . "'";
			if ($ii == 0) $where =  " where " . $key . " = '" . $value . "' ";
			if ($ii == 1) $where .= " and " . $key . " = '" . $value . "'";
			$ii++;
		}
		$query = "update " . $table . " set " . $updateString . $where;
		//echo $query . "\n"; 
		$result = dbQuery($query);
		if (!psModifiedCount($result)) {  
			$query = "INSERT INTO " . $table . "(" . $nameString . ") VALUES (" . $valueString . ")";
			//echo $query . "\n";
			$result = dbQuery($query);      
	    }
		if ($result) $count++;
		$jj++; 
	}   
	if ($count > 0) echo "{success:true, result:" . $count . "}";
	else echo "{failure:true, result:0}";
}    

function deleteData(){
    $table = "conditions";
    $c_id = $_REQUEST['conditions_id'];

        $query = "DELETE FROM  " . $table. " where conditions_id = $c_id ;";

        $result = dbQuery($query); 
        if ($result) $count++;
       
    if ($count > 0) 
        echo "{success:true, result:$count}";
     else 
        echo "{failure:true, result:0}";
    
}  

function util ($tables) {
	// params are site, eid, pid, day, mo, year
	$paramArray = explode(',', $_REQUEST['params']); 
	$site = $paramArray[0];
	$eid = $paramArray[1];
	$pid = $paramArray[2];
	$day = $paramArray[3];
	$mo = $paramArray[4];
	$yr = $paramArray[5];	
	$where = encounterKeysChanged($site, $eid, $day, $mo, $yr);
	if ($where != "") {
		// If key fields for visitDatexx have changed, update the keys
        // Need to find highest value of seqNum for any existing
        // encounters with the new keys and inc. by 1. Use 0 if none.
        $newSeqNum = 0;
		$newWhere = " WHERE siteCode = '$site' AND patientID = '$pid' AND visitDateDd = '$day' AND visitDateMm = '$mo' AND visitDateYy = '$yr'";
        $queryStmt = "SELECT TOP 1 seqNum FROM encounter " . $newWhere . " ORDER BY seqNum DESC";
        $result = dbQuery ($queryStmt); 
        $keys = psRowFetch ($result);
        if (is_numeric($keys['seqNum'])) $newSeqNum = $keys['seqNum'] + 1; 
		foreach ($tables as $tab) { 
			updEncounterKeys ($eid, $tab, $day, $mo, $yr, $newSeqNum, $where);
		}
		updEncounterKeys ($eid, "encounter", $day, $mo, $yr, $newSeqNum, $where);
		echo "{success:true, result:'good'}";
	} else echo "{failure:true, result:'bad'}";
} 

function conceptUpdate ($task) {
	$qry = "delete from obs where encounter_id =" . $_REQUEST['eid'] . " and location_id = " . $_REQUEST['site'] . " and concept_id between " . $_REQUEST['startId'] . " and  " . $_REQUEST['endId'];
	dbQuery($qry);
	$records = json_decode(stripslashes($_REQUEST['data']),true);
	//print_r($records);  
	foreach ($records as $rec) {
		if ($task == 'habits' || $task == 'vitals' || $task == 'blood') { 
			$dt = 'value_text';
			if (isset($rec[value_coded])) $dt = 'value_coded';
			if (isset($rec[value_boolean])) $dt = 'value_boolean';
			$result = singletonConceptInsert($_REQUEST['pid'], $rec['concept_id'], $_REQUEST['eid'], $_REQUEST['site'], $dt, $rec[$dt]);
		} else if ($task == 'exam') { 
			//print_r($rec);
			$curVal = $rec['answer']; 
			if ($curVal == 1 || $curVal == 2 || $curVal == 4) $dt = "value_coded";
			else $dt = "value_text";
			$result = singletonConceptInsert($_REQUEST['pid'], $rec['concept_id'], $_REQUEST['eid'], $_REQUEST['site'], $dt, $curVal);			
		} else 
			$result = singletonConceptInsert($_REQUEST['pid'], $rec['concept_id'], $_REQUEST['eid'], $_REQUEST['site'], 'value_boolean', 1); 
	}
	if ($result) echo "{result: 1}";
	else echo "{result: 0}";
	
}

function updateDD () {
	$flag = 0; 
	$records = json_decode($_REQUEST['data'],true);
	$defValue = 4;  
	foreach($records as $record) {
		if ($record['deleteFlag']) {
			$qry = "delete from isanteForms where encType = " . $record['encType'] . " and formVersion = " . $record['formVersion'] . " and 
				section = " . $record['section'] . " and field = " . $record['field'];
			$result = dbQuery($qry);
			if (psModifiedCount($result) > 0) $flag = 1;
		} else {
			$qry = "UPDATE isanteForms SET conceptKey = '" . $record['conceptKey'] . "', labelEn = '" . $record['labelEn'] . "', labelFr = '" . $record['labelFr'] . "', 
						default_value = '" . $defValue . "', conceptOrTable = '" . $record['conceptOrTable'] . "' 
					WHERE encType = " . $record['encType'] . " and formVersion = " . $record['formVersion'] . " and section = " . $record['section'] . " and  field = " . $record['field'];
			$result = dbQuery($qry);
			if (psModifiedCount($result) == 0) { 
				$qry = "
					INSERT INTO isanteForms (encType, formVersion, section, field, labelEn, labelFr, conceptKey, default_value, conceptOrTable) 
					VALUES (" . $record['encType'] . "," . $record['formVersion'] . "," . $record['section'] . "," . $record['field'] . ",'" . $record['labelEn'] . "', '" . 
						$record['labelFr'] . "', '" . $record['conceptKey'] . "','" . $defValue . "', '" . $record['conceptOrTable'] . "')";
				$result = dbQuery($qry);
				if (psModifiedCount($result) > 0) {
					$flag = 1;
				} else {
					$flag = 0;
				}
			} else {
				$flag = 1;
			} 
		}            
	}
	echo "{result: " . $flag . "}";
} 

function toggleHivStatus () {
	$pid = $_REQUEST['pid'];
	$value = $_REQUEST['value'];
	$qry = "update patient set hivPositive = " . $value . " where patientid = '" . $pid . "'";
	$result = dbQuery($qry);
}

?>