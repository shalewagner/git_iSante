<?
require_once "backend.php";
/*** routines to check for the existence of a concept, add, modify, delete concepts
 *** routines to read and write the concept dictionary
 ***/
$what = $_REQUEST['what'];
$conceptName = $_REQUEST['conceptName'];
$enLabel = $_REQUEST['enLabel'];
$frLabel = $_REQUEST['frLabel'];
$classId = $_REQUEST['classId'];
$datatypeId = $_REQUEST['datatypeId'];
$description = $_REQUEST['description'];
$conceptId = $_REQUEST['conceptId'];

switch ($what) {
	case 'exists':
	echo isConcept($conceptName);
	break;
	case 'get':
	print_r (getConcept($conceptId));
	break;
	case 'add':
	echo addConcept($conceptName, $enLabel, $frLabel, $description, $classId, $datatypeId);
	break;
	case 'modify':
	echo modifyConcept($conceptId, $enLabel, $frLabel, $description, $classId, $datatypeId);
	break;
	case 'delete':
	echo deleteConcept($conceptId);
	break; 
	case "updateDD":
	updateDD();
	break;
	case "readDD":
	readDD();
	break;
}  

function readDD(){
	$formVersion =  $_REQUEST['formVersion'];
	$encType =  $_REQUEST['encType'];
	$conceptKey = $_REQUEST['conceptKey'];
	$fieldLabel = $_REQUEST['fieldLabel'];
	$arr = array(); 
	if ($formVersion == "%") {
		$sql = "select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.concept_id as conceptOrTable, c.class_id as concept_class_id, c.datatype_id as concept_datatype_id from isanteForms e left join concept c on e.conceptKey = c.short_name where conceptKey not in (select column_name from staticConcepts) and (e.conceptKey like ? and (e.labelEn like ? or e.labelFr like ?)) union select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.table_name, c.concept_class_id, c.concept_datatype_id from isanteForms e, staticConcepts c where e.conceptKey = c.column_name and (e.conceptKey like ? and (e.labelEn like ? or e.labelFr like ?)) order by 1,3,4"; 
		$arr = database()->query($sql, array('%' . $conceptKey . '%', '%' . $fieldLabel . '%', '%' . $fieldLabel . '%', '%' . $conceptKey . '%', '%' . $fieldLabel . '%', '%' . $fieldLabel . '%'))->fetchAll();
	} else {
		$sql = "select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.concept_id as conceptOrTable, c.class_id as concept_class_id, c.datatype_id as concept_datatype_id from isanteForms e left join concept c on e.conceptKey = c.short_name where e.encType = ? and e.formVersion = ? union select e.encType, e.formVersion, e.section, e.field, e.labelEn, e.labelFr, e.conceptKey, c.table_name, c.concept_class_id, c.concept_datatype_id from isanteForms e, staticConcepts c where e.conceptKey = c.column_name and e.encType = ? and e.formVersion = ? order by 1,3,4";
		$arr = database()->query($sql, array($encType, $formVersion, $encType, $formVersion))->fetchAll();
	}
	$data = json_encode($arr);  
	echo '({"total":"' . count($arr) . '","results":' . $data . '})';
} //end readDD

function updateDD () {
	$flag = 0; 
	$records = json_decode($_REQUEST['data'],true);
	$defValue = 4;              
	foreach($records as $record) {
		if ($record['deleteFlag']) {
			$rowCnt = database()->query("delete from isanteForms where encType = ? and formVersion = ? and section = ? and field = ?", array($record['encType'], $record['formVersion'], $record['section'], $record['field']))->rowCount(); 
			if ($rowCnt > 0) $flag = 1;
			/*$qry = "delete from isanteForms where encType = " . $record['encType'] . " and formVersion = " . $record['formVersion'] . " and 
				section = " . $record['section'] . " and field = " . $record['field'];
			$result = dbQuery($qry);
			if (psModifiedCount($result) > 0) $flag = 1;*/ 
		} else { 
			$rowCnt = database()->query("UPDATE isanteForms SET conceptKey = ?, labelEn = ?, labelFr = ?, default_value = ?, conceptOrTable = ? WHERE encType = ? and formVersion = ? and section = ? and field = ?", array($record['conceptKey'], $record['labelEn'], $record['labelFr'], $defValue, $record['conceptOrTable'], $record['encType'], $record['formVersion'], $record['section'], $record['field']))->rowCount();
			/*$qry = "UPDATE isanteForms SET conceptKey = '" . $record['conceptKey'] . "', labelEn = '" . $record['labelEn'] . "', labelFr = '" . $record['labelFr'] . "', default_value = '" . $defValue . "', conceptOrTable = '" . $record['conceptOrTable'] . "' WHERE encType = " . $record['encType'] . " and formVersion = " . $record['formVersion'] . " and section = " . $record['section'] . " and  field = " . $record['field'];
			$result = dbQuery($qry);
			if (psModifiedCount($result) == 0) { */ 
			if ($rowCnt == 0) {
				$rowCnt = database()->query("INSERT INTO isanteForms (encType, formVersion, section, field, labelEn, labelFr, conceptKey, default_value, conceptOrTable) VALUES (?,?,?,?,?,?,?,?,?)", array($record['encType'], $record['formVersion'], $record['section'], $record['field'], $record['labelEn'], $record['labelFr'], $record['conceptKey'], $defValue, $record['conceptOrTable']))->rowCount();
			       /* $qry = "INSERT INTO isanteForms (encType, formVersion, section, field, labelEn, labelFr, conceptKey, default_value, conceptOrTable) VALUES (" . $record['encType'] . "," . $record['formVersion'] . "," . $record['section'] . "," . $record['field'] . ",'" . $record['labelEn'] . "', '" . $record['labelFr'] . "', '" . $record['conceptKey'] . "','" . $defValue . "', '" . $record['conceptOrTable'] . "')";
				$result = dbQuery($qry);
				if (psModifiedCount($result) > 0) {  */
				if ($rowCnt > 0) {
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

?>
