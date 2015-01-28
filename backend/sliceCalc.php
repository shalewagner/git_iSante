<?
parse_str(implode('&', array_slice($argv, 1)), $_REQUEST);
set_time_limit (0); 
ini_set ('memory_limit','1024M');
$_REQUEST['noid'] = 'true';
require_once 'backend.php';

$indKey = $_REQUEST['key'];
$orgs = array( 
	'Haiti' => '1',
	'Dept' => 'c.department',
	'Commune' => 'concat(c.department,?,c.commune)',
	'Sitecode' => 'c.sitecode',
	'Network' => 'c.network'  
);

foreach($orgs as $key => $value) {  
	$sql = "insert into dw_" . $indKey . "_slices (org_unit , org_value , indicator , time_period, year, period, gender, denominator) 
	select ?, " . $value . ", l.indicator, time_period, year, period, case when t.sex in (1,2) then t.sex else 4 end as sex, count(distinct p.patientid) 
	from dw_" . $indKey . "ReportLookup l, dw_" . $indKey . "_patients p, patient t, clinicLookup c 
	where l.indicatorType = 1 and 
	p.indicator = l.indicatorDenominator and 
	left(p.patientid,5) = t.location_id and substr(p.patientid,6) = t.person_id and  
	c.sitecode = t.location_id 
	group by 1,2,3,4,5,6,7";
	$qArray = array($key); 
	if ($key == 'Commune') $qArray[] = "-";
	$rc = database()->query($sql, $qArray)->rowCount(); 
        echo "\n" . $key . " Denominators: " . $sql . "\n" . date('h:i:s') . " Rowcount: " . $rc . "\n"; 

	$sql = "drop table if exists xxx";
	$rc = database()->query($sql);
	
	$sql = "create table xxx
	select ? as org_unit, " . $value . " as org_value, p.indicator, 
	time_period, year, period, case when t.sex in (1,2) then t.sex else 4 end as gender, count(distinct p.patientid) as cnt
	from dw_" . $indKey . "ReportLookup l, dw_" . $indKey . "_patients p, patient t, clinicLookup c
	where l.indicatorType = 1 and
	l.indicator = p.indicator and 
	left(p.patientid,5) = t.location_id and substr(p.patientid,6) = t.person_id and 
	c.sitecode = t.location_id  
	group by 1,2,3,4,5,6,7";
	$qArray = array($key); 
	if ($key == 'Commune') $qArray[] = "-";   
	$rc = database()->query($sql, $qArray)->rowCount(); 
	
	$sql = "insert into dw_" . $indKey . "_slices (org_unit , org_value , indicator , time_period, year, period, gender, value)
	select * from xxx on duplicate key update value = cnt";
	
	$rc = database()->query($sql, $qArray)->rowCount();
	echo "\n" . $key . " Numerators: " . $sql . "\n" . date('h:i:s') . " Rowcount: " . $rc . "\n";
} 
?>    
