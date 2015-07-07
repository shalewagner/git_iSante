<?
set_time_limit (0); 
ini_set ('memory_limit','1024M');
require_once ("pregnancyRanges.php");
require_once ("malaria.php");
require_once ("tb.php");
require_once ("nutrition.php"); 
require_once ("obgyn.php");
require_once ("dataquality.php");
require_once ("mer.php");

$tempTableNames = array ();

function updateDataWarehouse ($key, $truncate, $lastModified) {
  echo "\nStarting update of warehouse key '$key': " . date('h:i:s') . "\n";
  if ($truncate) {
    truncateTable ('dw_' . $key . '_snapshot');
    $lastModified = "2003-01-01";
  }
  if ($key == "nutrition") {
    truncateTable ("dw_pregnancy_ranges");
    updatePregnancyRanges();

    $GLOBALS['tempTableNames'] = createTempTables ("tempNutrition", 5, array ("patientID varchar(11), dob date", "patientID varchar(11), visitDate date, dob date, ageInMos smallint unsigned, vitalWeight decimal(5,2), pedVitBirWt decimal(5,2), vitalHeight decimal(4,2), pedVitBirLen decimal(4,2), pedVitCurBracCirc decimal(5,2)", "patientID varchar(11), visitDate date", "patientID varchar(11), visitDate date, prevHtDate date", "patientID varchar(11), visitDate date, prevHt decimal(4,2)"), "pat_idx::patientID");
  }
 if ($key == "dataquality") {
    $GLOBALS['tempTableNames'] = createTempTables ("tempQuality", 1, array ("patientID varchar(11),maxDate date,concept_id varchar(7)"), "pat_idx::patientID");
  }
 
  call_user_func ("update" . ucfirst ($key) . "Snapshot", $lastModified);
  refreshSlices ($key);
  dropTempTables ($GLOBALS['tempTableNames']);
}

function truncateTable ($name) {
  database()->exec ('TRUNCATE TABLE ' . $name);
}

function refreshSlices($key) {
	$orgType = array(
		"Haiti" => "1", 
		"Department" => "department",
		"Commune" => "concat(department,?,commune)",
		"Network" => "network",
		"Sitecode" => "sitecode"
	); 
	$time_period = array(
		"Year",
		"Month",
		"Week"
	);
	
	// re-compute slices daily
	truncateTable ("dw_" . $key . "_slices");
	truncateTable ("dw_" . $key . "_patients"); 

	switch ($key) {
		case "nutrition":
		nutritionSlices($key, $orgType, $time_period);
		break;
		case "malaria":
		malariaSlices($key, $orgType, $time_period);
		break;
		case "tb":
		tbSlices($key, $orgType, $time_period);
		break;
		case "obgyn":
		obgynSlices($key, $orgType, $time_period);
		break;
		case "dataquality":
		dataqualitySlices($key, $orgType, $time_period);
		break;
        case "mer":
		merSlices($key, $orgType, $time_period);
		break;
		
	}
}

function generatePidLists ($key, $indicator, $query, $period) {
	if (count($query) == 1) { 
		$inda = $query[0];
		$operator = "x";       
	} else {
		$inda = $query[0];
		$indb = $query[1];
		$operator = $query[2];
	} 
	$sql = "insert into dw_" . $key . "_patients 
			select " . $indicator . ", time_period, year, period, patientid 
			from dw_" . $key . "_patients 
			where time_period = ? ";
	$argArray = array($period);
	switch ($operator) {
		case 'x': 
		$sql .= " and indicator = " . $inda;
		break;
	case 'join':  
		$sql .= " and indicator = " . $inda . " and patientid in (
			select distinct patientid from dw_" . $key . "_patients where indicator = " . $indb . " and time_period = ?)";
		$argArray[] = $period; 
		break;
	case 'not': 
		$sql .= " and indicator = " . $inda . " and patientid not in (
			select distinct patientid from dw_" . $key . "_patients where indicator = " . $indb . " and time_period = ?)";
		$argArray[] = $period; 
		break;
	case 'union':
		$sql .= " and indicator in (" . $inda . "," . $indb . ")";
		break;
	}
	$rc = database()->query($sql, $argArray)->rowCount();
	if (DEBUG_FLAG) {
		echo "<br>Generate Pid List for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>";
		print_r ($argArray); 
	}
} 

function generatePercentsOld ($key, $indicator, $org_unit, $org_value, $query) {
	if ($key == 'tb') $inda = $query[1][0];
	else $inda = $indicator;
	$indb = $query[2][0]; 
	if (DEBUG_FLAG) echo "Indicator: " . $indicator . " IndicatorA: " . $inda . " IndicatorB: " . $indb . "<br>";
	$sql = "insert into dw_" . $key . "_slices (org_unit , org_value , indicator , time_period, year, period, gender, denominator) 
        select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid) 
        from dw_" . $key . "_patients p, clinicLookup, patient t 
        where p.patientid = t.patientid and t.sex in (1,2) and sitecode = left(p.patientid,5) and indicator = " . $indb . " group by 1,2,3,4,5,6,7";
	if ($org_unit == 'Commune') $qArray = array($org_unit, "-");
	else $qArray = array($org_unit); 
	$rc = database()->query($sql, $qArray)->rowCount();
	if (DEBUG_FLAG) {
		echo "<br>Generate denominators for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>";
		print_r($qArray); 
	} 
	$sql = "update dw_" . $key . "_slices m inner join (
        select ? as org_unit, " . $org_value . " as org_value, " . $indicator . " as indicator, 
        time_period, year, period, t.sex as gender, count(distinct p.patientid) as cnt
        from dw_" . $key . "_patients p, clinicLookup, patient t 
        where p.patientid = t.patientid and t.sex in (1,2) and sitecode = left(p.patientid,5) and indicator = " . $indicator . " 
        group by 1,2,3,4,5,6,7) x on m.org_unit = x.org_unit and m.org_value = x.org_value and 
        m.indicator = x.indicator and m.time_period = x.time_period and m.period = x.period and m.gender = x.gender
        set m.value = x.cnt";
	if ($org_unit == 'Commune') $qArray = array($org_unit, "-");
	else $qArray = array($org_unit); 
	$rc = database()->query($sql, $qArray)->rowCount();
	if (DEBUG_FLAG) {
		echo "<br>Generate numerators for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>";
		print_r($qArray); 
	}

}

function generatePercents ($indKey) {  
        // only need to do sitecode; derive other org units in extendSlices below
	$key = 'Sitecode';
	$value  = 't.location_id';

	// denominators first
	echo "\n" . date('h:i:s') . " start denominators...";  
	$sql = "insert into dw_" . $indKey . "_slices (org_unit , org_value , indicator , time_period, year, period, gender, denominator) 
	select ?, " . $value . ", l.indicator, time_period, year, period, case when t.sex in (1,2) then t.sex else 4 end as sex, count(distinct p.patientid) 
	from dw_" . $indKey . "ReportLookup l, dw_" . $indKey . "_patients p, patient t 
	where l.indicatorType = 1 and p.indicator = l.indicatorDenominator and p.patientid = t.patientid group by 3,4,1,2,5,6,7";
	$rc = database()->query($sql, array($key))->rowCount(); 
        echo "\n" . $key . " Denominators: " . $sql . "\n" . date('h:i:s') . " Rowcount: " . $rc . "\n"; 
        
	// now numerators 
	$sql = "drop table if exists xxx";
	$rc = database()->query($sql);

	$sql = "create table xxx
	select ? as org_unit, " . $value . " as org_value, p.indicator, 
	time_period, year, period, case when t.sex in (1,2) then t.sex else 4 end as gender, count(distinct p.patientid) as cnt
	from dw_" . $indKey . "ReportLookup l, dw_" . $indKey . "_patients p, patient t
	where l.indicatorType = 1 and
	l.indicator = p.indicator and 
	p.patientid = t.patientid 
	group by 3,4,1,2,5,6,7";
	$qArray = array($key); 
	if ($key == 'Commune') $qArray = array('Sitecode','-'); 
	$rc = database()->query($sql, $qArray)->rowCount(); 
        // take advantage of the insert on duplicate key syntax
	$sql = "insert into dw_" . $indKey . "_slices (org_unit , org_value , indicator , time_period, year, period, gender, value)
	select * from xxx on duplicate key update value = cnt";
	$rc = database()->query($sql, $qArray)->rowCount();
	echo "\n" . $key . " Numerators: " . $sql . "\n" . date('h:i:s') . " Rowcount: " . $rc . "\n"; 
	echo "\n Starting extend slices:" . date('h:i:s'); 
	extendSlices($indKey);
 
}
function extendSlices($indKey) {
	$orgs = array( 
		'Haiti' => '1',
		'Department' => 'c.department',
		'Commune' => 'concat(c.department,?,c.commune)',
		'Network' => 'c.network'  
	);
	// use the sitecode org_unit to generate the others
	foreach ($orgs as $key => $value) {
		$rc = database()->query("drop table if exists xxx");
		$sql = "create table xxx 
		select ? as org_unit, " . $value . " as org_value, p.indicator, p.time_period, p.year, p.period, p.gender, sum(value) as value1, sum(denominator) denominator1
		from dw_" . $indKey . "_slices p, clinicLookup c
		where p.org_unit = ? and p.org_value = c.sitecode
		group by 3,4,1,2,5,6,7";
		$qArray = array($key, 'Sitecode'); 
		if ($key == 'Commune') $qArray = array($key, '-', 'Sitecode');  
		echo "\n" . $indKey . "/" . $key . " : " . $sql;
		$rc = database()->query($sql, $qArray)->rowCount();
		$rc = database()->query("insert into dw_" . $indKey . "_slices select * from xxx on duplicate key update value=value1,denominator=denominator1")->rowCount();
		echo "\n" . $indKey . "/" . $key . ": " . $rc . " slices inserted.";
	}
} 

function generateAmongSlices ($key, $indicator, $org_unit, $org_value, $query) {
	if ($query[2] == NULL) { 
		$sql = "insert into dw_" . $key . "_slices 
			select ?, " . $org_value . ", " . $indicator . ", time_period, year, period, t.sex, count(distinct p.patientid), 0 
			from dw_" . $key . "_patients p, clinicLookup c, patient t 
			where p.patientid = t.patientid and t.sex in (1,2) and indicator = ? and c.sitecode = left(p.patientid,5) group by 1,2,3,4,5,6,7";
		if ($org_unit == 'Commune') $argArray = array($org_unit, "-", $indicator);
		else $argArray = array($org_unit, $indicator);
	} else {  
		$sql = "insert into dw_" . $key . "_slices 
			select ?, " . $org_value . ", " . $indicator . ", p.time_period, p.year, p.period, t.sex, count(distinct p.patientid), 0 
			from dw_" . $key . "_patients p, dw_" . $key . "_patients q, clinicLookup c, patient t 
			where p.patientid = t.patientid and t.sex in (1,2) and p.indicator = ? and q.indicator = ? and 
			p.time_period = q.time_period and p.year = q.year and 
			p.period = q.period and c.sitecode = left(p.patientid,5) and 
			p.patientid = q.patientid group by 1,2,3,4,5,6,7";
		if ($org_unit == 'Commune') $argArray = array($org_unit, "-", $indicator, $query[2][0]);
		else $argArray = array($org_unit, $indicator, $query[2][0]); 
	} 
	$rc = database()->query($sql, $argArray)->rowCount();
       	if (DEBUG_FLAG) {
		echo "<br>Generate among for: " . $indicator . " :" . $sql . " Rows inserted: " . $rc . "<br>"; 
		print_r ($argArray);
	}  
}

?>
