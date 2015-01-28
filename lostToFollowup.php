<?
error_reporting(E_ALL); 
$_REQUEST['noid'] = 'true';
require_once 'backend.php';
$start = '2010-12-01';
echo '<table border="1">';
echo "<tr><th>Cohort</th><th>Still In (Numerator)</th><th>Original Count (Denominator)</th><th>Lost To Followup %</th></tr>";   
for ($cohort = 1; $cohort < 15; $cohort ++) {
	$cbegin = $cohort + 4;
	$cend = $cohort + 6;
	$denInterval = $cohort + 5;
	$cohortDate = "date_add('" . $start . "', INTERVAL " . $denInterval . " MONTH)";
	$begin =      "date_add('" . $start . "', INTERVAL " . $cbegin . " MONTH)";
	$end   =      "date_add('" . $start . "', INTERVAL " . $cend . " MONTH)"; 
	// cohort here is any hiv+ patient that had a visit in the $cohort month
	// but not any registrations, discontinuations, referrals, or selection committee reports
	$qry = "create temporary table steveCohort 
		select distinct patientid from encounter 
		where encounterType not in (9,10,11,12,15) and encountertype < 20 and 
		month(ymdtodate(visitdateyy,visitdatemm,visitdatedd)) = month(" . $cohortDate . ") and year(ymdtodate(visitdateyy,visitdatemm,visitdatedd)) = year(" . $cohortDate . ")"; 
	//echo $qry;
	$result = dbQuery($qry);
	$qry = "select " . $cohortDate . ",count(*) from steveCohort";
	$result = dbQuery($qry);
	$coll = psRowFetch($result);
	$cDate = $coll[0];
	$denominator = $coll[1]; 
	// find any patient with a visit 
	$qry = "select count(distinct s.patientid) from encounter e, steveCohort s 
		where e.patientid = s.patientid and  
		encounterType not in (9,10,11,12,15) and encountertype < 20 and
		ymdtodate(visitdateyy,visitdatemm,visitdatedd) between " . $begin . " and " . $end; 
	//echo "<p>" . $qry;
	$coll = psRowFetch($result);
	$result = dbQuery($qry);
	$coll = psRowFetch($result);
	$numerator = $coll[0];
	$qry = "drop table steveCohort";
	$result = dbQuery($qry);
	echo "<tr><td>" . $cDate . '</td><td align="right">' . $numerator . '</td><td align="right">' . $denominator . '</td><td align="right">' . round(100*($denominator-$numerator)/$denominator) . "</td></tr>";   
	//break;
} 
echo '</table>';
/***
 *** Various queries to satisfy IRM output requirements 
 *** # of sites with most current version installed/total # of sites with internet connection
select dbVersion, count(distinct sitecode) from clinicLookup where incphr = 1 group by 1; 
 ***
 *** Active #users, # super-users, #admin
select case 
when privLevel = 0 then 'readOnly' 
when privLevel = 1 then 'readWrite' 
when privLevel = 2 then 'admin' 
when privLevel = 3 then 'superuser' 
else 'unknown' end as UserType, count(distinct lastmodifier) 
from encounter e left join userPrivilege u on e.lastModifier = u.username 
group by 1;  
select count(distinct concat(sitecode,lastmodifier)) from encValidAll where year(visitdate) = 2011 and month(visitdate) between 7 and 9; 
 ***
 *** Number of sites with local server out of all sites 
select case when dbsite > 0 then 'localServer' else 'ASP' end as SiteType, count(*) 
from clinicLookup
where incphr = 1
group by 1;
 ***
 *** Number of each available report generated or transferred
See routine outputEvents.php 
 ***
 *** 6. Number of patient transfer generated
select count(*) from encValidAll where encounterType = 30;
 ***
 *** 7a. Counts of patients by service area
select case 
when encountertype in (27,28,29,31) then 'primarycare' 
when encountertype in (24,25,26) then 'obgyn' 
when encountertype in (1,2,3,4,7,9,11,12,14,16,17,20,21) then 'hiv' end as servicearea, 
count(distinct patientid)
from encValidAll where year(visitdate) = 2011 and month(visitdate) between 4 and 6
group by 1 order by 2 desc; 
 *** 7b. Count of number of patients with HIV, primary care, and OB/GYN data (overlapped)

select t1.yr, t1.qtr, count(distinct t1.patientid) from 
(select year(visitdate) as yr, quarter(visitdate) as qtr, patientid from encValidAll where encountertype in (27,28,29,31) and year(visitdate) in (2011,2012)) t1,
(select year(visitdate) as yr, quarter(visitdate) as qtr, patientid from encValidAll where encountertype in (24,25,26) and year(visitdate) in (2011,2012)) t2,
(select year(visitdate) as yr, quarter(visitdate) as qtr, patientid from encValidAll where encountertype in (1,2,3,4,7,9,11,12,14,16,17,20,21) and year(visitdate) in (2011,2012)) t3 
where t1.patientid = t2.patientid and t1.patientid = t3.patientid
and t1.yr = t2.yr and t1.yr = t3.yr and t1.qtr = t2.qtr and t1.qtr = t3.qtr group by 1,2 order by 1,2; 

select t1.yr, t1.qtr, count(distinct t1.patientid) from 
(select year(visitdate) as yr, quarter(visitdate) as qtr, patientid from encValidAll where encountertype between 24 and 31 and year(visitdate) in (2011,2012)) t1,
(select year(visitdate) as yr, quarter(visitdate) as qtr, patientid from encValidAll where encountertype in (1,2,3,4,7,9,11,12,14,16,17,20,21) and year(visitdate) in (2011,2012)) t2 
where t1.patientid = t2.patientid 
and t1.yr = t2.yr and t1.qtr = t2.qtr group by 1,2 order by 1,2;

 *** 8. Number of forms per module
select case when encounterType in (24,25,26) then 'ob-gyn'
when encounterType in (27,28,29,31) then 'primary care'
when encounterType < 24 then 'hiv'
else 'transfer' end as formType, count(*)
from encValidAll where encountertype not in (10,15,5,6,18,19) and year(visitdate) = 2011 and month(visitdate) between 7 and 9 group by 1;
 *** 9. [Average] Number of forms per patient 
select avg(cnt) as avgAllTime from (select patientid, count(*) as cnt from encValidAll group by 1) a;
select avg(cnt) as avgThisQrt from (select patientid, count(*) as cnt from encValidAll where year(visitdate) = 2011 and month(visitdate) between 7 and 9 group by 1) a;              
 *** 10. [Average] Number of forms per patient by Form
select enname as form, round(avg(cnt)) as avgCnt from encTypeLookup l, (select patientid, encountertype, count(*) as cnt from encValidAll where year(visitdate) = 2011 and month(visitdate) between 7 and 9 group by 1,2) a where a.encountertype = l.encountertype group by 1;

 *** 11. amt of backlog
select clinic, count(*) as formCnt, avg(datediff(createdate,visitdate)) as difDays from encValidAll e, clinicLookup l where year(visitdate) = 2011 and month(visitdate) between 7 and 9 and datediff(createdate,visitdate) >= 0 and e.sitecode = l.sitecode group by 1 order by 3
 *** 12. sites replicating
select 'July', clinic from clinicLookup where incphr = 1 and sitecode not in (select distinct sitecode from encValidAll where year(visitdate) = 2011 and month(visitdate) = 7)
union
select 'August', clinic from clinicLookup where incphr = 1 and sitecode not in (select distinct sitecode from encValidAll where year(visitdate) = 2011 and month(visitdate) = 8)
union
select 'September', clinic from clinicLookup where incphr = 1 and sitecode not in (select distinct sitecode from encValidAll where year(visitdate) = 2011 and month(visitdate) = 9);
 *** 13. # of results sent electronically / all results in system
 ***
 *** 14. Time between lab order (patient visit) and lab results data entry * by mechanism (data entry v electronic transfer)
select avg(datediff(ymdtodate(resultdateyy,resultdatemm,resultdatedd),ymdtodate(visitdateyy,visitdatemm,visitdatedd))) 
from labs 
where 
isdate(ymdtodate(resultdateyy,resultdatemm,resultdatedd)) = 1 and 
isdate(ymdtodate(visitdateyy,visitdatemm,visitdatedd)) = 1 and 
year(ymdtodate(resultdateyy,resultdatemm,resultdatedd)) = 2011 and
month(ymdtodate(resultdateyy,resultdatemm,resultdatedd)) between 7 and 9;
 ***/
?>
