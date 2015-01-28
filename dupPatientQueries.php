<?php    
$_REQUEST['noid'] = 'true';
$runType = (isset($_REQUEST['runType']) && $_REQUEST['runType'] == "ui") ? "ui":"batch";
if ($runType == "ui") $numDups = 5;
else {
    if (isset($_REQUEST['dupMax']))
        $numDups = $_REQUEST['dupMax'];
    else $numDups = 100;
}
include ("backend.php");
error_reporting (8183);     
if ($runType != 'ui') {
	dbQuery("create table #patDup (lname varchar(25), fname varchar(25), dob varchar(10), fnamemother varchar(50), dupCount int)");
	dbQuery("insert into #patDup (lname, fname, dob, fnamemother, dupCount)
		select ltrim(rtrim(lname)) as lname, ltrim(rtrim(fname)) as fname, dbo.ymdtodate(dobyy,dobmm,dobdd), fnamemother, count(*)
		from patient a, encValid b
		where a.patientid = b.patientid and b.encountertype in (10, 15) AND a.lname is not null and a.lname <> '' 
		group by lname, fname, dbo.ymdtodate(dobyy,dobmm,dobdd), fnamemother having count(*) > 1");
	dbQuery("create table #patDup2 (patientid varchar(11), lname varchar(25), fname varchar(25), lastModified datetime)");
	dbQuery("insert into #patDup2
			select e.patientid,
				upper(ltrim(rtrim(p.lname))), 
				upper(ltrim(rtrim(p.fname))),  
				max(e.lastModified)
			from  patient p, #patDup d, encValid e
			where p.patientid = e.patientid and 
					upper(p.lname) = upper(d.lname) and p.lname is not null and p.lname <> '' and
					upper(p.fname) = upper(d.fname) and p.fname is not null and p.fname <> '' and
					(upper(p.fnamemother) = upper(d.fnamemother) or (p.fnamemother is null and d.fnamemother is null)) 
			group by e.patientid, upper(ltrim(rtrim(p.lname))), upper(ltrim(rtrim(p.fname)))
			order by 1, 3 desc");
	$qry = "select lname, fname, patientid, lastModified from #patDup2 order by 1 desc,2 desc,3 desc"; 
	$result = dbQuery($qry);
	$ii = 0;
	while ($row = psRowFetchAssoc($result)) {
		echo "<br />";
		foreach ($row as $name => $value) 
			echo $name . "-" . $value . " | "; 
		$ii++;
		if ($ii > $numDups) break;
	}   
} else {
	// get attributes for user to choose
	$qry = "select distinct column_name from information_schema.columns where table_name = 'patient'";
	$result = dbQuery($qry);
	$tmpArray = displayResult($qry, $result);    

	// run query to find duplicates based upon select attributes
	$attrString = "lname, fname, dobYy, dobMm, dobDd, fnameMother";
	$qry = "select " . $attrString . ", count(*) as dupCount
			from patient p, encValid e 
			where p.patientid = e.patientid and e.encountertype in (10, 15) and (lname + fname) <> '' 
			group by " . $attrString . "
			having count(*) > 1
			order by 7 desc";
	$result = dbQuery($qry);
	$tmpArray = displayResult($qry, $result);   

	// display the first 5 rows that are dups
	$tmpString = ''; 
	$ii = 0;  
	echo "<table width=\"50%\" border=\"1\"><tr>"; 
	foreach ($tmpArray as $row) {
		foreach ($row as $attrName => $value) { 
			$currLabel = getLabel($name); 
			echo "<th>" . $attrName . "(" . $currLabel['fr'][1] . ")</th>";
		} 
		break;
	} 
	echo "</tr>";               
	foreach ($tmpArray as $row) {
		echo "<tr>";
		$flag = true;
		foreach ($row as $name => $value) {
			if ($flag) {
				echo "<td><input type=\"radio\" name=\"choosePatient\">&nbsp;" . $value . "</td>";
				$flag = false;
			} else echo "<td>" . $value . "</td>"; 
		}
		echo "</tr>"; 
		$ii++; 
		if ($ii > $numDups) break;
	}
	echo "</table>";

	// build name/value string    (for selected row only)
	$selectedAttributes = $tmpArray;
	$attrNameValueString = '';
	foreach ($tmpArray as $row) {
		foreach ($row as $name => $value) {
			if ($value != '' && $name != 'dupCount')  {
				$tmpString = $name . " = '" . $value . "' ";
			 	if ($attrNameValueString == '') $attrNameValueString = $tmpString;
			 	else $attrNameValueString .= "and " . $tmpString; 
			}
		} 
		break;
	}

	// get patientids for selected duplicate patient 
	// try to get them in chronological order
	$qry = "select p.patientid, max(lastModified) from patient p, encValid v 
		where p.patientid = v.patientid and " . $attrNameValueString . " group by p.patientid order by 2"; 
	$result = dbQuery($qry);
	$tmpArray = displayResult($qry, $result); 
	$idList = '';
	$lastMod = array();
	foreach ($tmpArray as $row) {
		foreach ($row as $name => $value) {
			$tmpString = "'" . $value . "' ";
			if ($idList == '') $idList = $tmpString;
			else $idList .= ", " . $tmpString; 
		}   
	}
	echo "<br>" . $idList . "<p>";
	// get all attributes for set of patientids
	$qry = "select c.clinic, p.*, c.clinic from patient p, clinicLookup c where c.sitecode = left(p.patientid,5) and p.patientid in (" . $idList . ")";
	$result = dbQuery($qry);
	$tmpArray = displayResult($qry, $result); 

	// generate final array   
	$final = array();
	foreach ($tmpArray as $row) {
		foreach ($row as $name => $value) {
			if (!array_key_exists($name,$selectedAttributes[0]) && $name != "stid" && $name != "patientID" && $name != "location_id" && $name != "patGuid" && $name != "person_id") {
				if (array_key_exists($name,$final)) 
					array_push($final[$name],$value); 
				else 
					$final[$name] = array($value); 
			}
		} 
	} 
	// display attribute/value pairs used to find duplicate records
	echo "<p>"; 
	echo "<table width=\"25%\" border=\"1\">";
	foreach ($selectedAttributes as $row) {
		foreach ($row as $name => $value)
			echo "<tr><td>" . $name . "</td><td>" . $value . "</td></tr>";
		break;
	} 
	// display alternate values for other attributes
	echo "</table>";
	echo "<table width=\"50%\" border=\"1\">";
	foreach ($final as $name => $value) {   
		$currLabel = getLabel($name);
		echo "<tr><td>" . $name . "</td><td>" . $currLabel['fr'][1] . "</td>";
		for ($i = 0; $i < count($value); $i++) echo "<td><nobr><input type=\"radio\" name=\"radio" . $name .  "[]\" value=\"" . $i . "\" id=\"" . $name . $i . "\"><input name=\"" . $name . $i . "\" value=\"" . $value[$i] . "\" type=\"text\" size=\"25\" maxlength=\"25\"><nobr></td>";
		echo "</tr>";
	} 
	echo "</table>"; 
}

function displayResult($qry, $result) {  
	echo "<br>" . $qry . "<p>";
	while ($row = psRowFetchAssoc($result))
		$tmpArray[] = $row; 
	//print_r($tmpArray); 
	return ($tmpArray);
}  
?>