<?php
function doPepfarPrep ($siteCode, $lang, $dstart, $dend) {
	include 'labels/reportSetupLabels.php';
	include 'labels/report.php';
	define ("STANDARD_CASE_STATEMENT",  "case 
				when ageYears > 14 and sex = 2 and pregnant <> 1 then 'mo14'
				when ageYears > 14 and sex = 1 and pregnant <> 1 then 'no14np'
				when sex = 1 and pregnant = 1 then 'pf'
				when ageYears <= 14 and ageYears > 0 and sex = 2 and pregnant <> 1  then 'xu14' 
				when ageYears <= 14 and ageYears > 0 and sex = 1 and pregnant <> 1 then 'yu14'
				else 'zother' end");
				
	// put date in YYMM format
	// dates come in as yyyy-mm-dd
	$startDate = substr($dstart,2,2) . substr($dstart,4,3);

	$endDate = substr($dend,2,2) . substr($dend,4,3);
	//$startDate = substr($dstart,2,2) . substr($dstart,5,2);
	//$startDate = substr($dstart,6,2) . substr($dstart,0,2);
	//$endDate = substr($dend,2,2) . substr($dend,5,2);
	//$endDate = substr($dend,6,2) . substr($dend,0,2);
	//$year = '20' . substr($dstart,6,2);
	$year = substr($dstart,0,4);

	//$month = substr($dstart,0,2);
	$month = substr($dstart,5,2);

	$unixStartDate = mktime(0,0,0, $month, 1, $year);

	//$year = '20' . substr($dend,6,2);
	$year = substr($dend,0,4);
	$month = substr($dend,5,2);

	
	//$month = substr($dend,0,2);
	$unixEndDate = mktime(0,0,0, $month, 1, $year);

	global $one;
	global $two;
	global $three;
	global $four;
	global $five;
	global $six;
	global $seven;
	global $eight;
	global $nine;

	genTempTables ($siteCode, $startDate, $endDate, $unixStartDate, $unixEndDate);
	reportGen($lang,$siteCode,$startDate,$endDate, $unixStartDate, $unixEndDate,$localizedMonths);
}

function genTempTables ($siteCode, $startDate, $endDate, $unixStartDate, $unixEndDate) {
	// computes aggregate data for the report

	global $one;
	global $two;
	global $three;
	global $four;
	global $five;
	global $six;
	global $seven;
	global $eight;
	global $nine;

	/* calculate ages */
	updateAges();

	dbQuery("update encounter set badvisitdate = 1 where isdate(dbo.ymdToDate(visitdateyy, visitdatemm, visitdatedd)) <> 1");
	//dbQuery("sp_whoInit");
	
	/* generate maxVitals for previous and current month */
	//$sDate = substr($startDate,2,2) . "/" . date("t",$unixStartDate) . "/" . substr($startDate,0,2);
	//$eDate = substr($endDate,2,2) . "/" . date("t",$unixEndDate) . "/" . substr($endDate,0,2);

	$sDate = "20" . substr($startDate,0,2) . "-" . substr($startDate,3,2) . "-" . date("t",$unixStartDate);

	$eDate = "20" . substr($endDate,0,2) . "-" . substr($endDate,3,2) . "-" . date("t",$unixEndDate);

	
	/* previous month */

	generateMaxVitals("#pMaxVitals", $siteCode, $sDate);
	/* generate for the current month */

	generateMaxVitals("#cMaxVitals", $siteCode, $eDate);

    if (DEBUG_FLAG) print "***********initOne all patients**********<br>";
    initOne();
    if (DEBUG_FLAG) print "***********initTwo ART patients**********<br>";
	initTwo($sDate, $eDate);
    if (DEBUG_FLAG) print "***********initThree transfers in**********<br>";
	initThree($sDate, $eDate);
	if (DEBUG_FLAG) print "***********initFour INH**********<br>";
	initFour($sDate, $eDate);
	if (DEBUG_FLAG) print "***********initFive CTX**********<br>";
	initFive($sDate, $eDate);
	if (DEBUG_FLAG) print "***********initSix ADI (AIDs-defining illness**********<br>";
	initSix($sDate, $eDate);
	if (DEBUG_FLAG) print "***********initSeven Anti-TB treatment**********<br>";
	initSeven($sDate, $eDate);
    if (DEBUG_FLAG) print "***********initEight Regimen during month**********<br>";
	initEight($eDate, $endDate);
	if (DEBUG_FLAG) print "***********initNine Discontinuation**********<br>";
	initNine($eDate);
}

function reportGen ($lang,$siteCode,$startDate,$endDate, $unixStartDate, $unixEndDate,$localizedMonths) {
    // generates the report's individual cells
	global $one;
	global $two;
	global $three;
	global $four;
	global $five;
	global $six;
	global $seven;
	global $eight;
	global $nine;

	$month = $localizedMonths[$lang][date("n", $unixEndDate) - 1];
	$year =	"20" . substr($endDate,0,2);
	$facility = escapeSingleQuotes(getSiteName($siteCode, $lang));
	$location = escapeSingleQuotes(getSiteLocation($siteCode));
	$grantee = "I-TECH";
	$country = "Haiti";
//	$eDate = substr($endDate,3,2) . "/" . date("t",$unixEndDate) . "/" . substr($endDate,0,2);
	$eDate = "20" . substr($endDate,0,2) . "-" . substr($endDate,3,2) . "-" . date("t",$unixEndDate);

//	$sDate = substr($startDate,3,2) . "/" . date("t",$unixStartDate) . "/" . substr($startDate,0,2);
	$sDate = "20" . substr($startDate,0,2) . "-" . substr($startDate,3,2) . "-" . date("t",$unixStartDate);

//clear the table
dbQuery("delete from pepfarRecords");
//fill in the header info
insertToPep (-12, 1, "Month: ", $month, "Year: ", $year,"");
//insertToPep (-11, 1, "--------------------------------------------------","-------------------------------","-------------------------------", "-------------------------------");
insertToPep (-10, 1, "Grantee: ", $grantee, "Facility: ", $facility);
//insertToPep (-9, 1, "--------------------------------------------------","-------------------------------","-------------------------------", "-------------------------------");
insertToPep (-8, 1, "Location: ", $location, "Country: ", $country);
//insertToPep (-7, 1, "--------------------------------------------------","-------------------------------","-------------------------------", "-------------------------------");
insertToPep (-6, 1, "","" , "", "" );

//fill in the #1 table
insertToPep (99,  1, "1. HIV care (non-ART and ART)-new","and cumulative number","of persons enrolled","");
//insertToPep (100, 1, "--------------------------------------------------","-------------------------------","-------------------------------", "-------------------------------");
insertToPep (101, 1, "","Cumulative number of" , "New", "Cumulative number of");
insertToPep (102, 1, "","persons enrolled in HIV" , "persons enrolled in HIV", "persons enrolled in HIV");
insertToPep (103, 1, "","care at this facility" , "care at this facility", "care at this facility");
insertToPep (104, 1, "","at beginning of month" , " during the month", "at end of month");
//insertToPep (105, 1, "--------------------------------------------------","-------------------------------","-------------------------------", "-------------------------------");
insertToPep (110, 1, "1. Males (>14 years)",                "   a. " . $one["1.a"], "   g. " . $one["1.g"], "   m. " . $one["1.m"]);
insertToPep (120, 1, "2. Non-pregnant females (>14 years)", "   b. " . $one["1.b"], "   h. " . $one["1.h"], "   n. " . $one["1.n"]);
insertToPep (130, 1, "3. Pregnant females",                 "   c. " . $one["1.c"], "   i. " . $one["1.i"], "   o. " . $one["1.o"]);
insertToPep (140, 1, "4. Boys (0-14 years)",                "   d. " . $one["1.d"], "   j. " . $one["1.j"], "   p. " . $one["1.p"]);
insertToPep (150, 1, "5. Girls (0-14 years)",               "   e. " . $one["1.e"], "   k. " . $one["1.k"], "   q. " . $one["1.q"]);
insertToPep (151, 1, "------Total",                         "   f. " . $one["1.f"], "   l. " . $one["1.l"], "   r. " . $one["1.r"]);
//insertToPep (152, 1, "", "-------------------------------", "-------------------------------", "-------------------------------");
$qry = "select count(*) as 'theValue' from #cMaxVitals 
	where patientid not in (select patientid from pepfarTable where visitDate between '$sDate' and '" . $eDate . "' AND (forPepPmtct = 0 OR forPepPmtct IS NULL)) and patientid in (
		select patientid from eligibility where visitdate between '$sDate' and '$eDate' and reason in ('cd4LT200', 'tlcLT1200', 'WHOIII', 'WHOIV', 'PMTCT', 'medEligHAART', 'estPrev', 'former', 'PEP', 'eligByAge', 'eligByCond', 'eligPcr', 'WHOIII-2', 'WHOIIICond', 'OptionB+') and (('$eDate' <= '2009-12-31' and criteriaVersion = 1) or ('$eDate' between '2009-12-31' and '2012-03-31' and criteriaVersion = 2) or ('$eDate' > '2012-03-31' and criteriaVersion in (2, 3))))";
/*
        select patientid from cd4Table where cd4 < 350 and cd4 != 0 and visitdate between '$sDate' and '$eDate'
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select s.patientID from symptoms s, encounter e where s.pedSympWhoWtLoss2 = 1 and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and s.patientID = e.patientID and s.siteCode = e.siteCode and s.visitDateDd = e.visitDateDd and s.visitDateMm = e.visitDateMm and s.visitDateYy = e.visitDateYy and s.seqNum = e.seqNum) and patientID in (select patientID from cd4table where cd4 < 350 and cd4 != 0 and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select m.patientID from medicalEligARVs m, encounter e where m.currentHivStage in (4, 5, 6, 7, 12, 13, 14, 15) and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and m.patientID = e.patientID and m.siteCode = e.siteCode and m.visitDateDd = e.visitDateDd and m.visitDateMm = e.visitDateMm and m.visitDateYy = e.visitDateYy and m.seqNum = e.seqNum) and patientID in (select patientID from cd4table where cd4 < 350 and cd4 != 0 and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select patientID from v_conditions where whoStage = 'Stage IV' and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select s.patientID from symptoms s, encounter e where s.pedSympWhoWtLoss3 = 1 and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and s.patientID = e.patientID and s.siteCode = e.siteCode and s.visitDateDd = e.visitDateDd and s.visitDateMm = e.visitDateMm and s.visitDateYy = e.visitDateYy and s.seqNum = e.seqNum)
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select m.patientID from medicalEligARVs m, encounter e where m.currentHivStage > 7 and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and m.patientID = e.patientID and m.siteCode = e.siteCode and m.visitDateDd = e.visitDateDd and m.visitDateMm = e.visitDateMm and m.visitDateYy = e.visitDateYy and m.seqNum = e.seqNum)
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select patientID from v_medicalEligARVs where medElig in (1, 3, 5, 7) and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where isPediatric = 1 and patientID in (select patientID from v_medicalEligARVs where pedMedEligCd4Cnt = 1 or pedMedEligTlc = 1 or pedMedEligWho3 = 1 or pedMedEligWho4 = 1 or pedMedEligPmtct = 1 or pedMedEligFormerTherapy = 1 and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select patientID from v_labsCompleted where testNameEn = 'lymphocytes' and result <= '1200' and result != '' and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select patientID from v_conditions where whoStage = 'Stage III' and visitdate between '$sDate' and '$eDate') and patientID in (select patientID from cd4table where cd4 < 350 and cd4 != 0 and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select s.patientID from symptoms s, encounter e where (s.weightLossPlusTenPercMo = 1 or s.feverPlusMo = 1 or s.diarrheaPlusMo = 1) and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and s.patientID = e.patientID and s.siteCode = e.siteCode and s.visitDateDd = e.visitDateDd and s.visitDateMm = e.visitDateMm and s.visitDateYy = e.visitDateYy and s.seqNum = e.seqNum) and patientID in (select patientID from cd4table where cd4 < 350 and cd4 != 0 and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select m.patientID from medicalEligARVs m, encounter e where e.formVersion = 1 and m.currentHivStage in (4, 5, 6, 7, 12, 13, 14, 15) and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and m.patientID = e.patientID and m.siteCode = e.siteCode and m.visitDateDd = e.visitDateDd and m.visitDateMm = e.visitDateMm and m.visitDateYy = e.visitDateYy and m.seqNum = e.seqNum) and patientID in (select patientID from cd4table where cd4 < 350 and cd4 != 0 and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select patientID from v_conditions where whoStage = 'Stage IV' and visitdate between '$sDate' and '$eDate')
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select s.patientID from symptoms s, encounter e where s.wtLossTenPercWithDiarrMo = 1 and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and s.patientID = e.patientID and s.siteCode = e.siteCode and s.visitDateDd = e.visitDateDd and s.visitDateMm = e.visitDateMm and s.visitDateYy = e.visitDateYy and s.seqNum = e.seqNum)
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select m.patientID from medicalEligARVs m, encounter e where (((e.formVersion != 1 or e.formVersion is NULL) and m.currentHivStage > 3) or m.currentHivStage > 7) and e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and m.patientID = e.patientID and m.siteCode = e.siteCode and m.visitDateDd = e.visitDateDd and m.visitDateMm = e.visitDateMm and m.visitDateYy = e.visitDateYy and m.seqNum = e.seqNum)
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select m.patientID from medicalEligARVs m, encounter e where e.encStatus < 255 and ((e.badVisitDate != 1 or e.badVisitDate is NULL) and convert(datetime, case when (e.badVisitDate != 1 or e.badVisitDate is NULL) then e.visitDateMm + '/' + e.visitDateDd + '/' + e.visitDateYy else getdate() end) between '$sDate' and '$eDate') and e.siteCode = m.siteCode and e.visitDateDd = m.visitDateDd and e.visitDateMm = m.visitDateMm and e.visitDateYy = m.visitDateYy and e.patientID = m.patientID and e.seqNum = m.seqNum and ((medElig in (1, 2, 3, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15) and (e.formVersion != 1 or e.formVersion is NULL)) or (medElig in (1, 3, 5, 7) and e.formVersion = 1)))
        union all
        select patientID from patient where (isPediatric != 1 or isPediatric is NULL) and patientID in (select patientID from v_medicalEligARVs where  (cd4LT200 = 1 or tlcLT1200 = 1 or WHOIII = 1 or WHOIV = 1 or PMTCT = 1 or formerARVtherapy = 1 or PEP = 1 or medEligHAART = 1) and visitdate between '$sDate' and '$eDate')
)";
*/
//	(
//		patientid in (select patientid from cd4Table where cd4 < 350 and cd4 != 0 and cd4 is not null) or 
//	 	patientid in (select patientid from v_labsCompleted where testnameen = 'lymphocytes' and result <= '1200' and result != '') or 
//		(patientid in (select patientid from cd4Table where cd4 < 350 and cd4 != 0 and cd4 is not null) and 
//			patientid in (select patientid from v_conditions where conditionGroup = 3)) or 
//		patientid in (select patientid from v_conditions where conditionGroup = 4) or 
//		patientid in (select distinct patientid from medicalEligARVs where medElig in (1,2))
if (DEBUG_FLAG) {
	print "***********qualified but not on ARV**********<br>";
	print $qry . "<br>";
}
$result = dbQuery ($qry);
$value = 0;
while ($row = psRowFetchAssoc ($result)) {
	$value = $row['theValue'];
}
insertToPep (154, 1, "","Total persons enrolled" , "and eligible for ART", "");
insertToPep (155, 1, "","but have not been" , "started on ART", "   s. " . $value);
//insertToPep (156, 1, "","-------------------------------","-------------------------------", "-------------------------------");
// three blanks after each major section
insertToPep (157, 0, "","" , "", "" );

//fill in the #2 table
insertToPep (199, 2, "2. ART care - new and cumulative","number of persons","started","");
insertToPep (201, 2, "","Cumulative number of" , "New", "Cumulative number of");
insertToPep (202, 2, "","persons started on" , "persons started on", "persons started on");
insertToPep (203, 2, "","ART at this facility" , "ART at this facility", "ART at this facility");
insertToPep (204, 2, "","at beginning of month" , "during the month", "at end of month");
insertToPep (210, 2, "1. Males (>14 years)",                "   a. " . $two["2.a"], "   g. " . $two["2.g"], "   m. " . $two["2.m"]);
insertToPep (220, 2, "2. Non-pregnant females (>14 years)", "   b. " . $two["2.b"], "   h. " . $two["2.h"], "   n. " . $two["2.n"]);
insertToPep (230, 2, "3. Pregnant females",                 "   c. " . $two["2.c"], "   i. " . $two["2.i"], "   o. " . $two["2.o"]);
insertToPep (240, 2, "4. Boys (0-14 years)",                "   d. " . $two["2.d"], "   j. " . $two["2.j"], "   p. " . $two["2.p"]);
insertToPep (250, 2, "5. Girls (0-14 years)",               "   e. " . $two["2.e"], "   k. " . $two["2.k"], "   q. " . $two["2.q"]);
insertToPep (251, 2, "------Total",                         "   f. " . $two["2.f"], "   l. " . $two["2.l"], "   r. " . $two["2.r"]);

$beginM = date("Y-m-d", $unixEndDate);
$endM = date("Y-m-d", strtotime("+1 months",$unixEndDate));
$qry = "select count(distinct patientid) from pepfarTable where rtrim(sitecode) = '" . $siteCode . "' AND (forPepPmtct = 0 OR forPepPmtct IS NULL) and
	patientid in (select patientid from v_vitals where transferin = 1 and visitdate between '" . $beginM  . "' and '" . $endM . "')";
$result = dbQuery($qry);
if (DEBUG_FLAG) echo "<br />*****Transfers in********<br />" . date('h:i:s A') . $qry . "<br />";
$row = psRowFetch ($result);
$value = $row[0];
insertToPep (254, 2, "","No. of persons on ART" , "already enrolled", "");
insertToPep (255, 2, "","who transferred into" , "facility last month", "   s. " . $value);
//insertToPep (256, 2, "","-------------------------------","-------------------------------", "-------------------------------");

$beginM = date("Y-m-d", $unixEndDate);
$endM = date("Y-m-d", strtotime("+1 months",$unixEndDate));
$twoM = date("Y-m-d", strtotime("-1 months",$unixEndDate));
$threeM = date("Y-m-d", strtotime("-2 months",$unixEndDate));
$qry = "select count(distinct p.patientid) from pepfarTable p, cohortTable s where rtrim(p.sitecode) = '" . $siteCode . "' and
	p.patientid = s.patientid and visitdate between '" . $beginM  . "' and '" . $endM . "' AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) and p.patientid not in (
		select patientid from pepfarTable where visitDate = '" . $twoM . "' and  firstVisit <= '" . $threeM . "' AND (forPepPmtct = 0 OR forPepPmtct IS NULL))";
$result = dbQuery($qry);
if (DEBUG_FLAG) echo "<br />****Restarted*********<br />" . date('h:i:s A') . $qry . "<br />";
$row = psRowFetch ($result);
$value = $row[0];
insertToPep (257, 2, "","No. of persons who" , "restarted ART during", "");
insertToPep (258, 2, "","month after stopping" , "for at least 1 month", "   t. " . $value);
//insertToPep (260, 2, "","-------------------------------","-------------------------------", "-------------------------------");

$qry = "create table #cohort (patientid varchar(11))";
dbQuery($qry);
if (DEBUG_FLAG) echo "<br />****Baseline CD4 counts/Median CD4 values<br />" . date('h:i:s A') . $qry . "<br />";
$qry = "insert into #cohort select patientid from v_prescriptions d, drugLookup l where d.drugid = l.drugid and l.druggroup in ('Pls','NNRTIs','NRTIs')
 and d.sitecode like '" . $siteCode . "' group by patientid having month(min(d.visitdate)) = month('" . $beginM . "') and year(min(d.visitdate)) = year('" . $beginM . "')";
dbQuery($qry);
if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
$qry = "select count(distinct c.patientid) as numPatients, avg(cd4) as medianCD4 from #cohort c, cd4Table t where c.patientid = t.patientid and t.visitdate < '" . $endM . "'";
$result = dbQuery($qry);
if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
$row = psRowFetchAssoc ($result);
$numPatients = $row['numPatients'];
$medianCD4 = $row['medianCD4'];
insertToPep (261, 2, "","No. of baseline CD4*" , "counts for persons who", "");
insertToPep (262, 2, "","started ART in the" , " last month", "   u. " . $numPatients);

insertToPep (264, 2, "","Median baseline CD4* count" , "for persons who started ART", "");
insertToPep (265, 2, ""," in the last" , "month", "   v. " . $medianCD4);
insertToPep (266, 0, "","" , "", "" );

/*fill in the #3 table
insertToPep (280, 3, "3. Change in CD4 count and","adherence to ART for 6-","mo and 12-mo cohorts","");
insertToPep (282, 3, "For persons who have completed" , "6 months of ART", "12 months of ART", "");
insertToPep (285, 3, "Cohort started in (month/year)",   "   a. " . $three["3.a"], "   i. " . $three["3.i"], "");
insertToPep (286, 3, "Number of persons in cohort",      "   b. " . $three["3.b"], "   j. " . $three["3.j"], "");
insertToPep (287, 3, "Number of baseline CD4 counts",   "   c. " . $three["3.c"], "   k. " . $three["3.k"], "");
insertToPep (288, 3, "Median baseline CD4 count",       "   d. " . $three["3.d"], "   l. " . $three["3.l"], "");
insertToPep (307, 3, "" , "after 6 months of ART", "after 12 months of ART", "");
insertToPep (309, 3, "Number of persons in cohort",      "   e. " . $three["3.e"], "   m. " . $three["3.m"], "");
insertToPep (310, 3, "Number of CD4 counts",            "   f. " . $three["3.f"], "   n. " . $three["3.n"], "");
insertToPep (311, 3, "Median CD4 count",                "   g. " . $three["3.g"], "   o. " . $three["3.o"], "");
insertToPep (312, 3, "Number of persons who picked up ARVs", "", "", "");
insertToPep (313, 3, "each month for 6 months", "   h. " . $three["3.h"], "", "");
insertToPep (314, 3, "Number of persons who picked up ARVs","", "", "");
insertToPep (315, 3, "each month for 12 months","", "   p. " . $three["3.p"], "");
*/

//fill in the #3 table
insertToPep (300, 2, "3. Nombre de personnes", " sous ARV et enrole dans le ", "progamme qui ete refere ","par un autre site au cours du");
insertToPep (301, 2, "","Nombre cumule de" , "Nombre de", "Nombre cumule de");
insertToPep (302, 2, "","personnes referees" , "Personnes referees", "personnes referees par un");
insertToPep (303, 2, "","par un autre site" , "par un autre site", "autre site a la fin du mois");
insertToPep (304, 2, "","durant le mois" , "durant le mois du rapport", "de ce rapport");
insertToPep (310, 2, "1. Males (>14 years)",                "   a. " . $three["3.a"], "   g. " . $three["3.g"], "   m. " . $three["3.m"]);
insertToPep (320, 2, "2. Non-pregnant females (>14 years)", "   b. " . $three["3.b"], "   h. " . $three["3.h"], "   n. " . $three["3.n"]);
insertToPep (330, 2, "3. Pregnant females",                 "   c. " . $three["3.c"], "   i. " . $three["3.i"], "   o. " . $three["3.o"]);
insertToPep (340, 2, "4. Boys (0-14 years)",                "   d. " . $three["3.d"], "   j. " . $three["3.j"], "   p. " . $three["3.p"]);
insertToPep (350, 2, "5. Girls (0-14 years)",               "   e. " . $three["3.e"], "   k. " . $three["3.k"], "   q. " . $three["3.q"]);
insertToPep (351, 2, "------Total",                         "   f. " . $three["3.f"], "   l. " . $three["3.l"], "   r. " . $three["3.r"]);
insertToPep (352, 0, "","" , "", "" );

//fill in the #4 table
insertToPep (400, 2, "4. Personnes prises en charge", "placees  sous INH", "prophylactique","");
insertToPep (401, 2, "","Cumulative number of" , "New", "Cumulative number of");
insertToPep (402, 2, "","persons started on" , "persons started on", "persons started on");
insertToPep (403, 2, "","INH at this facility" , "INH at this facility", "INH at this facility");
insertToPep (404, 2, "","at beginning of month" , "during the month", "at end of month");
insertToPep (410, 2, "1. Males (>14 years)",                "   a. " . $four["4.a"], "   g. " . $four["4.g"], "   m. " . $four["4.m"]);
insertToPep (420, 2, "4. Non-pregnant females (>14 years)", "   b. " . $four["4.b"], "   h. " . $four["4.h"], "   n. " . $four["4.n"]);
insertToPep (430, 2, "3. Pregnant females",                 "   c. " . $four["4.c"], "   i. " . $four["4.i"], "   o. " . $four["4.o"]);
insertToPep (440, 2, "4. Boys (0-14 years)",                "   d. " . $four["4.d"], "   j. " . $four["4.j"], "   p. " . $four["4.p"]);
insertToPep (450, 2, "5. Girls (0-14 years)",               "   e. " . $four["4.e"], "   k. " . $four["4.k"], "   q. " . $four["4.q"]);
insertToPep (451, 2, "------Total",                         "   f. " . $four["4.f"], "   l. " . $four["4.l"], "   r. " . $four["4.r"]);
insertToPep (452, 0, "","" , "", "" );

//fill in the #5 table
insertToPep (500, 2, "5. Personnes prises  en"," charge places sours ", "CTX prophylactique","");
insertToPep (501, 2, "","Cumulative number of" , "New", "Cumulative number of");
insertToPep (502, 2, "","persons started on" , "persons started on", "persons started on");
insertToPep (503, 2, "","CTX at this facility" , "CTX at this facility", "CTX at this facility");
insertToPep (504, 2, "","at beginning of month" , "during the month", "at end of month");
insertToPep (510, 2, "1. Males (>14 years)",                "   a. " . $five["5.a"], "   g. " . $five["5.g"], "   m. " . $five["5.m"]);
insertToPep (520, 2, "2. Non-pregnant females (>14 years)", "   b. " . $five["5.b"], "   h. " . $five["5.h"], "   n. " . $five["5.n"]);
insertToPep (530, 2, "3. Pregnant females",                 "   c. " . $five["5.c"], "   i. " . $five["5.i"], "   o. " . $five["5.o"]);
insertToPep (540, 2, "4. Boys (0-14 years)",                "   d. " . $five["5.d"], "   j. " . $five["5.j"], "   p. " . $five["5.p"]);
insertToPep (550, 2, "5. Girls (0-14 years)",               "   e. " . $five["5.e"], "   k. " . $five["5.k"], "   q. " . $five["5.q"]);
insertToPep (551, 2, "------Total",                         "   f. " . $five["5.f"], "   l. " . $five["5.l"], "   r. " . $five["5.r"]);
insertToPep (552, 0, "","" , "", "" );

//fill in the #6 table
insertToPep (600, 2, "6. Personnes prises en ","charge qui ont developpe  ", "une ADI aucours de","leur suivi ");
insertToPep (601, 2, "","Nombre Cumule de personnes qui" , "Nombre nouvellement de personnes", "Nombre cumule de personnes qui");
insertToPep (602, 2, "","ont developpe une ADI au" , "qui ont developpe une ADI au", "ont developpe une ADI  au");
insertToPep (603, 2, "","niveau du site au dernier jour" , "niveau du site au cours du mois", "niveau du site a la fin du");
insertToPep (604, 2, "","du mois precedant ce rapport" , "de ce rapport", "mois de ce rapport");
insertToPep (610, 2, "1. Hommes (>14 years)",                "   a. " . $six["6.a"], "   g. " . $six["6.g"], "   m. " . $six["6.m"]);
insertToPep (620, 2, "2. Femmes non enceintes (>14 years)", "   b. " . $six["6.b"], "   h. " . $six["6.h"], "   n. " . $six["6.n"]);
insertToPep (630, 2, "3. Femmes enceintes",                 "   c. " . $six["6.c"], "   i. " . $six["6.i"], "   o. " . $six["6.o"]);
insertToPep (640, 2, "4. Garcons (0-14 years)",                "   d. " . $six["6.d"], "   j. " . $six["6.j"], "   p. " . $six["6.p"]);
insertToPep (650, 2, "5. Filles (0-14 years)",               "   e. " . $six["6.e"], "   k. " . $six["6.k"], "   q. " . $six["6.q"]);
insertToPep (651, 2, "------Total",                         "   f. " . $six["6.f"], "   l. " . $six["6.l"], "   r. " . $six["6.r"]);
insertToPep (652, 0, "","" , "", "" );

//fill in the #7 table
insertToPep (700, 2, "7. Nombre de personnes VIH+ ","ayant recu to traitement", "anti-TB","");
insertToPep (701, 2, "","Cumulative number of" , "New", "Cumulative number of");
insertToPep (702, 2, "","persons started on" , "persons started on", "persons started on");
insertToPep (703, 2, "","anti-TB at this facility" , "anti-TB at this facility", "anti-TB at this facility");
insertToPep (704, 2, "","at beginning of month" , "during the month", "at end of month");
insertToPep (710, 2, "1. Males (>14 years)",                "   a. " . $seven["7.a"], "   g. " . $seven["7.g"], "   m. " . $seven["7.m"]);
insertToPep (720, 2, "2. Non-pregnant females (>14 years)", "   b. " . $seven["7.b"], "   h. " . $seven["7.h"], "   n. " . $seven["7.n"]);
insertToPep (730, 2, "3. Pregnant females",                 "   c. " . $seven["7.c"], "   i. " . $seven["7.i"], "   o. " . $seven["7.o"]);
insertToPep (740, 2, "4. Boys (0-14 years)",                "   d. " . $seven["7.d"], "   j. " . $seven["7.j"], "   p. " . $seven["7.p"]);
insertToPep (770, 2, "5. Girls (0-14 years)",               "   e. " . $seven["7.e"], "   k. " . $seven["7.k"], "   q. " . $seven["7.q"]);
insertToPep (771, 2, "------Total",                         "   f. " . $seven["7.f"], "   l. " . $seven["7.l"], "   r. " . $seven["7.r"]);
insertToPep (772, 0, "","" , "", "" );

//fill in the #8 table
insertToPep (800, 4, "8. Regimen at end of month","Male","Female","Total");
insertToPep (801, 4, "On 1st-Line ART regimen","","","");
insertToPep (803, 4, "8.1 Adults (>14 years)", "", "", "");
insertToPep (805, 4, "---d4T-3TC-NVP",   "   a. " . $eight["8.1.a"], "   j. " . $eight["8.1.j"], "");
insertToPep (806, 4, "---d4T-3TC-EFV",   "   b. " . $eight["8.1.b"], "   k. " . $eight["8.1.k"], "");
insertToPep (807, 4, "---ZDV-3TC-NVP",   "   c. " . $eight["8.1.c"], "   l. " . $eight["8.1.l"], "");
insertToPep (808, 4, "---ZDV-3TC-EFV",   "   d. " . $eight["8.1.d"], "   m. " . $eight["8.1.m"], "");
insertToPep (809, 4, "---ZDV-3TC-ABC",   "   e. " . $eight["8.1.e"], "   n. " . $eight["8.1.n"], "");
insertToPep (810, 4, "Adults on 1st-Line regimens",   "   i. " . $eight["8.1.i"], "   r. " . $eight["8.1.r"], "   s. " . $eight["8.1.s"]);
insertToPep (811, 4, "8.2 Children (0-14 years)", "", "", "");
insertToPep (812, 4, "---d4T-3TC-NVP",   "   a. " . $eight["8.2.a"], "   j. " . $eight["8.2.j"], "");
insertToPep (813, 4, "---d4T-3TC-EFV",   "   b. " . $eight["8.2.b"], "   k. " . $eight["8.2.k"], "");
insertToPep (814, 4, "---ZDV-3TC-NVP",   "   c. " . $eight["8.2.c"], "   l. " . $eight["8.2.l"], "");
insertToPep (815, 4, "---ZDV-3TC-EFV",   "   d. " . $eight["8.2.d"], "   m. " . $eight["8.2.m"], "");
insertToPep (815, 4, "---ZDV-3TC-ABC",   "   e. " . $eight["8.2.e"], "   n. " . $eight["8.2.n"], "");
insertToPep (816, 4, "Children on 1st-Line regimens",   "   i. " . $eight["8.2.i"], "   s. " . $eight["8.2.s"], "   u. " . $eight["8.2.u"]);
insertToPep (818, 4, "Total on 1st-Line regimens",   "   j. " . $eight["8.2.j"], "   t. " . $eight["8.2.t"], "   v. " . $eight["8.2.v"]);
insertToPep (819, 4, "", "" , "", "" );
insertToPep (821, 4, "", "" , "", "" );
insertToPep (822, 4, "On 2nd-line ART regimen","","","");
insertToPep (824, 4, "8.3 Adults (>14 years)", "", "", "");
insertToPep (826, 4, "---ZDV-ddI-LPV/r", "   a. " . $eight["8.3.a"], "   i. " . $eight["8.3.i"], "");
insertToPep (827, 4, "---d4T-ddI-LPV/r", "   b. " . $eight["8.3.b"], "   j. " . $eight["8.3.j"], "");
insertToPep (829, 4, "Adults on 2nd-Line regimens", "   h. " . $eight["8.3.h"], "   p. " . $eight["8.3.p"], "   q. " . $eight["8.3.q"]);
insertToPep (831, 4, "8.4 Children (0-14 years)", "", "", "");
insertToPep (833, 4, "---ZDV-ddI-LPV/r", "   a. " . $eight["8.4.a"], "   k. " . $eight["8.4.k"], "");
insertToPep (834, 4, "---d4T-ddI-LPV/r", "   b. " . $eight["8.4.b"], "   l. " . $eight["8.4.l"], "");
insertToPep (836, 4, "Children on 2nd-Line regimens", "   h. " . $eight["8.4.h"], "   r. " . $eight["8.4.r"], "   u. " . $eight["8.4.u"]);
insertToPep (838, 4, "Total on 2nd-Line regimens",   "   i. " . $eight["8.4.i"], "   s. " . $eight["8.4.s"], "   v. " . $eight["8.4.v"]);
insertToPep (839, 4, "", "" , "", "" );
insertToPep (840, 4, "Total on all regimens",        "   j. " . $eight["8.4.j"], "   t. " . $eight["8.4.t"], "   w. " . $eight["8.4.w"]);
insertToPep (852, 0, "","" , "", "" );

//fill in the #9 table
insertToPep (900, 5, "9. Numbre patients ","ayant arrete la ","prise des ARV","");
insertToPep (910, 5, "", "Hommes","Femmes","Total");
insertToPep (920, 5, "D&eacute;c&eacute;d&eacute;s","a. " . $nine["9.a"], "f. " . $nine["9.f"], "k. " . $nine["9.k"]);
insertToPep (930, 5, "Discontinuations"            ,"b. " . $nine["9.b"], "g. " . $nine["9.g"], "l. " . $nine["9.l"]);
insertToPep (940, 5, "Perte de vue"                ,"c. " . $nine["9.c"], "h. " . $nine["9.h"], "m. " . $nine["9.m"]);
insertToPep (950, 5, "Refere ailleurs"             ,"d. " . $nine["9.d"], "i. " . $nine["9.i"], "n. " . $nine["9.n"]);
insertToPep (960, 5, "Total patients Perdu de vue" ,"e. " . $nine["9.e"], "j. " . $nine["9.j"], "o. " . $nine["9.o"]);
insertToPep (962, 0, "", "" , "", "" );
insertToPep (963, 0, "", "" , "", "" );

/*fill in the #5 table
insertToPep (500, 5, "5.1 Number of persons who did not","","","5.2 Of those who did not");
insertToPep (501, 5, "pick up their ART regimens","Male","Female","pick up regimen in last 1");
insertToPep (502, 5, "1. For last 1 month (only)",   "   a. " . $five["5.1.a"], "   e. " . $five["5.1.e"], " month (optional)");
insertToPep (503, 5, "2. For last 2 month (only)",   "   b. " . $five["5.1.b"], "   f. " . $five["5.1.f"],
													"1. Lost to followup " . $five["5.2.a"]);
insertToPep (504, 5, "3. For last 3 or more months", "   c. " . $five["5.1.c"], "   g. " . $five["5.1.g"],
													"2. Died " . $five["5.2.b"]);
insertToPep (505, 5, "   Subtotal",                  "   d. " . $five["5.1.d"], "   h. " . $five["5.1.h"],
													"3. Stopped ART " . $five["5.2.c"]);
insertToPep (506, 5, "   Total persons who did not pick" ,"up their ART regimens", "   i. " . $five["5.1.i"], "8. Transferred out " . $five["5.2.d"]);
*/
}

function initOne () {
	// cumulative persons enrolled in care
	global $one;
	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$cellArray = array (
			array ("mo14" => "1.a", "no14np" => "1.b", "pf" => "1.c", "xu14" => "1.d", "yu14" => "1.e"),
			array ("mo14" => "1.m", "no14np" => "1.n", "pf" => "1.o", "xu14" => "1.p", "yu14" => "1.q")
	);
	for ($j = 0; $j < 2; $j++) {
		$qry = "select left(patientid,5) as sitecode, " .
			STANDARD_CASE_STATEMENT . " as 'theGroup',
			count(distinct patientid) as 'theCount'
			from " . $tableName[$j] . "
			group by left(patientid,5), " .
			STANDARD_CASE_STATEMENT . " 
			order by 1,2";
			// TODO : don't know what to do with "zother"
		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
		$result = dbQuery ($qry);
		while ($row = psRowFetch ($result)) {
			foreach ($cellArray[$j] as $key => $cell)
				if ($row['theGroup'] == $key) $one[$cell] = $row['theCount'];
		}
	}
	$one["1.f"] = $one["1.a"] + $one["1.b"] + $one["1.c"] + $one["1.d"] + $one["1.e"];
	$one["1.g"] = (($one["1.m"] - $one["1.a"]) < 0 ? 0 : ($one["1.m"] - $one["1.a"]));
	$one["1.h"] = (($one["1.n"] - $one["1.b"]) < 0 ? 0 : ($one["1.n"] - $one["1.b"]));
	$one["1.i"] = (($one["1.o"] - $one["1.c"]) < 0 ? 0 : ($one["1.o"] - $one["1.c"]));
	$one["1.j"] = (($one["1.p"] - $one["1.d"]) < 0 ? 0 : ($one["1.p"] - $one["1.d"]));
	$one["1.k"] = (($one["1.q"] - $one["1.e"]) < 0 ? 0 : ($one["1.q"] - $one["1.e"]));
	$one["1.l"] = $one["1.g"] + $one["1.h"] + $one["1.i"] + $one["1.j"] + $one["1.k"];
	$one["1.r"] = $one["1.f"] + $one["1.l"];
}

function initTwo ($sDate, $eDate) {
	// cumulative persons on ART
	global $two;
	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$theDate = array($sDate, $eDate);
	$cellArray = array (
			array ("mo14" => "2.a", "no14np" => "2.b", "pf" => "2.c", "xu14" => "2.d", "yu14" => "2.e"),
			array ("mo14" => "2.m", "no14np" => "2.n", "pf" => "2.o", "xu14" => "2.p", "yu14" => "2.q")
	);
	for ($j = 0; $j < 2; $j++) {
		$qry = "select left(patientid,5) as sitecode, " .
			STANDARD_CASE_STATEMENT . " as 'theGroup',
			count(patientid) as 'theCount'
			from " . $tableName[$j] . "
			where patientid in (select patientid from pepfarTable where visitdate <= '" . $theDate[$j] . "' AND (forPepPmtct = 0 OR forPepPmtct IS NULL))
			group by left(patientid,5), " .
			STANDARD_CASE_STATEMENT . " 
			order by 1,2";
			// TODO : don't know what to do with "zother"
			if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
			$result = dbQuery ($qry);
			while ($row = psRowFetchAssoc ($result)) {
				foreach ($cellArray[$j] as $key => $cell)
					if ($row['theGroup'] == $key) $two[$cell] = $row['theCount'];
		}
	}
	
	$two["2.f"] = $two["2.a"] + $two["2.b"] + $two["2.c"] + $two["2.d"] + $two["2.e"];
	$two["2.g"] = (($two["2.m"] - $two["2.a"]) < 0 ? 0 : ($two["2.m"] - $two["2.a"]));
	$two["2.h"] = (($two["2.n"] - $two["2.b"]) < 0 ? 0 : ($two["2.n"] - $two["2.b"]));
	$two["2.i"] = (($two["2.o"] - $two["2.c"]) < 0 ? 0 : ($two["2.o"] - $two["2.c"]));
	$two["2.j"] = (($two["2.p"] - $two["2.d"]) < 0 ? 0 : ($two["2.p"] - $two["2.d"]));
	$two["2.k"] = (($two["2.q"] - $two["2.e"]) < 0 ? 0 : ($two["2.q"] - $two["2.e"]));
	$two["2.l"] = $two["2.g"] + $two["2.h"] + $two["2.i"] + $two["2.j"] + $two["2.k"];
	$two["2.r"] = $two["2.f"] + $two["2.l"];
}

function initThree ($sDate, $eDate) {
	// cumulative persons transferred from another facility
	global $three;
	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$theDate = array($sDate, $eDate);
	$cellArray = array (
			array ("mo14" => "3.a", "no14np" => "3.b", "pf" => "3.c", "xu14" => "3.d", "yu14" => "3.e"),
			array ("mo14" => "3.m", "no14np" => "3.n", "pf" => "3.o", "xu14" => "3.p", "yu14" => "3.q")
	);
	for ($j = 0; $j < 2; $j++) {
	$qry = "select left(patientid,5), " .
		STANDARD_CASE_STATEMENT . " as 'theGroup', 
		count(distinct patientid) as 'theCount' from " . $tableName[$j] . " m 
		where patientid in (select patientid from v_vitals where transferin = 1 and encounterType in (1,16) and visitdate <= '" . $theDate[$j] . "')
		group by left(patientid,5), " . 				
		STANDARD_CASE_STATEMENT . "  
		order by 1,2";
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
	$result = dbQuery ($qry);
	while ($row = psRowFetchAssoc ($result)) {
		foreach ($cellArray[$j] as $key => $cell)
			if ($row['theGroup'] == $key) $three[$cell] = $row['theCount'];
	}
	}
	
	$three["3.f"] = $three["3.a"] + $three["3.b"] + $three["3.c"] + $three["3.d"] + $three["3.e"];
	$three["3.g"] = (($three["3.m"] - $three["3.a"]) < 0 ? 0 : ($three["3.m"] - $three["3.a"]));
	$three["3.h"] = (($three["3.n"] - $three["3.b"]) < 0 ? 0 : ($three["3.n"] - $three["3.b"]));
	$three["3.i"] = (($three["3.o"] - $three["3.c"]) < 0 ? 0 : ($three["3.o"] - $three["3.c"]));
	$three["3.j"] = (($three["3.p"] - $three["3.d"]) < 0 ? 0 : ($three["3.p"] - $three["3.d"]));
	$three["3.k"] = (($three["3.q"] - $three["3.e"]) < 0 ? 0 : ($three["3.q"] - $three["3.e"]));
	$three["3.l"] = $three["3.g"] + $three["3.h"] + $three["3.i"] + $three["3.j"] + $three["3.k"];
	$three["3.r"] = $three["3.f"] + $three["3.l"];
}

function initFour ($sDate, $eDate) {
	// INH prophylactique

	global $four;

	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$theDate = array($sDate, $eDate);
	$cellArray = array (
			array ("mo14" => "4.a", "no14np" => "4.b", "pf" => "4.c", "xu14" => "4.d", "yu14" => "4.e"),
			array ("mo14" => "4.m", "no14np" => "4.n", "pf" => "4.o", "xu14" => "4.p", "yu14" => "4.q")
	);
	for ($j = 0; $j < 2; $j++) {
		$qry = "select d.siteCode, " .
			STANDARD_CASE_STATEMENT . " as 'theGroup', 
			count(distinct m.patientid) as 'theCount' 
			from drugLookup l, v_prescriptions d, " . $tableName[$j] . " m 
			where drugGroup = 'Anti-TB' and l.drugid = d.drugid and 
			m.patientid = d.patientid and
			d.visitdate <= '" . $theDate[$j] . "' 
			group by d.siteCode, " . 
				STANDARD_CASE_STATEMENT . "  
			order by 1,2";
		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
		$result = dbQuery ($qry);
		while ($row = psRowFetchAssoc ($result)) {
			foreach ($cellArray[$j] as $key => $cell)
				if ($row['theGroup'] == $key) $four[$cell] = $row['theCount'];
		}
	}
	$four["4.f"] = $four["4.a"] + $four["4.b"] + $four["4.c"] + $four["4.d"] + $four["4.e"];
	$four["4.g"] = (($four["4.m"] - $four["4.a"]) < 0 ? 0 : ($four["4.m"] - $four["4.a"]));
	$four["4.h"] = (($four["4.n"] - $four["4.b"]) < 0 ? 0 : ($four["4.n"] - $four["4.b"]));
	$four["4.i"] = (($four["4.o"] - $four["4.c"]) < 0 ? 0 : ($four["4.o"] - $four["4.c"]));
	$four["4.j"] = (($four["4.p"] - $four["4.d"]) < 0 ? 0 : ($four["4.p"] - $four["4.d"]));
	$four["4.k"] = (($four["4.q"] - $four["4.e"]) < 0 ? 0 : ($four["4.q"] - $four["4.e"]));
	$four["4.l"] = $four["4.g"] + $four["4.h"] + $four["4.i"] + $four["4.j"] + $four["4.k"];
	$four["4.q"] = $four["4.e"] + $four["4.k"];

	$four["4.r"] = $four["4.f"] + $four["4.l"];
}

function initFive ($sDate, $eDate) {
	// CTX prophylactique

	global $five;

	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$theDate = array($sDate, $eDate);
	$cellArray = array (
			array ("mo14" => "5.a", "no14np" => "5.b", "pf" => "5.c", "xu14" => "5.d", "yu14" => "5.e"),
			array ("mo14" => "5.m", "no14np" => "5.n", "pf" => "5.o", "xu14" => "5.p", "yu14" => "5.q")
	);
	for ($j = 0; $j < 2; $j++) {
		$qry = "select d.siteCode, " .
			STANDARD_CASE_STATEMENT . " as 'theGroup', 
			count(distinct m.patientid) as 'theCount' 
			from v_prescriptions d, " . $tableName[$j] . " m 
			where drugID in (9,69,70) and 
			m.patientid = d.patientid and
			d.visitdate <= '" . $theDate[$j] . "' 
			group by d.siteCode, " .
				STANDARD_CASE_STATEMENT . " 
			order by 1,2";
		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
		$result = dbQuery ($qry);
		while ($row = psRowFetchAssoc ($result)) {
			foreach ($cellArray[$j] as $key => $cell)
				if ($row['theGroup'] == $key) $five[$cell] = $row['theCount'];
		}
	}
	$five["5.f"] = $five["5.a"] + $five["5.b"] + $five["5.c"] + $five["5.d"] + $five["5.e"];
	$five["5.g"] = (($five["5.m"] - $five["5.a"]) < 0 ? 0 : ($five["5.m"] - $five["5.a"]));
	$five["5.h"] = (($five["5.n"] - $five["5.b"]) < 0 ? 0 : ($five["5.n"] - $five["5.b"]));
	$five["5.i"] = (($five["5.o"] - $five["5.c"]) < 0 ? 0 : ($five["5.o"] - $five["5.c"]));
	$five["5.j"] = (($five["5.p"] - $five["5.d"]) < 0 ? 0 : ($five["5.p"] - $five["5.d"]));
	$five["5.k"] = (($five["5.q"] - $five["5.e"]) < 0 ? 0 : ($five["5.q"] - $five["5.e"]));
	$five["5.l"] = $five["5.g"] + $five["5.h"] + $five["5.i"] + $five["5.j"] + $five["5.k"];
	$five["5.q"] = $five["5.e"] + $five["5.k"];

	$five["5.r"] = $five["5.f"] + $five["5.l"];
}

function initSix ($sDate, $eDate) {
	// Opportunistic Infection OI / (AIDs-defining illnesses--ADIs)

	global $six;

	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$theDate = array($sDate, $eDate);
	$cellArray = array (
			array ("mo14" => "6.a", "no14np" => "6.b", "pf" => "6.c", "xu14" => "6.d", "yu14" => "6.e"),
			array ("mo14" => "6.m", "no14np" => "6.n", "pf" => "6.o", "xu14" => "6.p", "yu14" => "6.q")
	);
	for ($j = 0; $j < 2; $j++) {
		$qry = "select d.siteCode, " .
			STANDARD_CASE_STATEMENT . " as 'theGroup', 
			count(distinct m.patientid) as 'theCount' 
			from v_conditions d, " . $tableName[$j] . " m 
			where whoStage = 'Stage IV' and
			conditionCode not in ('otherCancerNot4','otherNot4') and
			m.patientid = d.patientid and
			d.visitdate <= '" . $theDate[$j] . "' 
			group by d.siteCode, " . 
				STANDARD_CASE_STATEMENT . " 
			order by 1,2";
		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
		$result = dbQuery ($qry);
		while ($row = psRowFetchAssoc ($result)) {
			foreach ($cellArray[$j] as $key => $cell)
				if ($row['theGroup'] == $key) $six[$cell] = $row['theCount'];
		}
	}
	$six["6.f"] = $six["6.a"] + $six["6.b"] + $six["6.c"] + $six["6.d"] + $six["6.e"];
	$six["6.g"] = (($six["6.m"] - $six["6.a"]) < 0 ? 0 : ($six["6.m"] - $six["6.a"]));
	$six["6.h"] = (($six["6.n"] - $six["6.b"]) < 0 ? 0 : ($six["6.n"] - $six["6.b"]));
	$six["6.i"] = (($six["6.o"] - $six["6.c"]) < 0 ? 0 : ($six["6.o"] - $six["6.c"]));
	$six["6.j"] = (($six["6.p"] - $six["6.d"]) < 0 ? 0 : ($six["6.p"] - $six["6.d"]));
	$six["6.k"] = (($six["6.q"] - $six["6.e"]) < 0 ? 0 : ($six["6.q"] - $six["6.e"]));
	$six["6.l"] = $six["6.g"] + $six["6.h"] + $six["6.i"] + $six["6.j"] + $six["6.k"];
	$six["6.q"] = $six["6.e"] + $six["6.k"];
	$six["6.r"] = $six["6.f"] + $six["6.l"];
}

function initseven ($sDate, $eDate) {
	// undergoing TB treatment

	global $seven;

	$tableName = array ("#pMaxVitals","#cMaxVitals");
	$theDate = array($sDate, $eDate);
	$cellArray = array (
			array ("mo14" => "7.a", "no14np" => "7.b", "pf" => "7.c", "xu14" => "7.d", "yu14" => "7.e"),
			array ("mo14" => "7.m", "no14np" => "7.n", "pf" => "7.o", "xu14" => "7.p", "yu14" => "7.q")
	);
	for ($j = 0; $j < 2; $j++) {
		$qry = "select d.siteCode, " .
			STANDARD_CASE_STATEMENT . " as 'theGroup', 
			count(distinct m.patientid) as 'theCount' 
			from v_tbStatus d, " . $tableName[$j] . " m 
			where currentTreat = 1 and
			m.patientid = d.patientid and
			d.visitdate <= '" . $theDate[$j] . "' 
			group by d.siteCode, " . 
				STANDARD_CASE_STATEMENT . "  
			order by 1,2";
		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
		$result = dbQuery ($qry);
		while ($row = psRowFetchAssoc ($result)) {
			foreach ($cellArray[$j] as $key => $cell)
				if ($row['theGroup'] == $key) $seven[$cell] = $row['theCount'];
		}
	}
	$seven["7.f"] = $seven["7.a"] + $seven["7.b"] + $seven["7.c"] + $seven["7.d"] + $seven["7.e"];
	$seven["7.g"] = (($seven["7.m"] - $seven["7.a"]) < 0 ? 0 : ($seven["7.m"] - $seven["7.a"]));
	$seven["7.h"] = (($seven["7.n"] - $seven["7.b"]) < 0 ? 0 : ($seven["7.n"] - $seven["7.b"]));
	$seven["7.i"] = (($seven["7.o"] - $seven["7.c"]) < 0 ? 0 : ($seven["7.o"] - $seven["7.c"]));
	$seven["7.j"] = (($seven["7.p"] - $seven["7.d"]) < 0 ? 0 : ($seven["7.p"] - $seven["7.d"]));
	$seven["7.k"] = (($seven["7.q"] - $seven["7.e"]) < 0 ? 0 : ($seven["7.q"] - $seven["7.e"]));
	$seven["7.l"] = $seven["7.g"] + $seven["7.h"] + $seven["7.i"] + $seven["7.j"] + $seven["7.k"];
	$seven["7.q"] = $seven["7.e"] + $seven["7.k"];

	$seven["7.r"] = $seven["7.f"] + $seven["7.l"];
}

function initEight ($eDate, $endDate) {
	// Regimen counts for $endDate

	global $eight;

	$qry = "select
		siteCode,
		t.visitDate,
		sex,
		ageYears as age,
		t.patientid,
		regimen
		from pepfarTable t, #cMaxVitals m
		where t.patientid = m.patientid and t.visitdate between dateadd(month,-1, '" . $eDate . "') and '" . $eDate . "' AND (t.forPepPmtct = 0 OR t.forPepPmtct IS NULL) order by 2";
	$result = dbQuery($qry);
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
	while ($row = psRowFetch ($result)) {
		$site = $row[0];
		$visitDate = substr($row[1],2,2) . substr($row[1],5,2);
		$sex = $row[2];
		$age = $row[3];
		$regimen = $row[5];
		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $eight["8.1.a"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $eight["8.1.j"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $eight["8.2.a"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $eight["8.2.j"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $eight["8.1.b"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $eight["8.1.k"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $eight["8.2.b"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $eight["8.2.k"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $eight["8.1.c"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $eight["8.1.l"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $eight["8.2.c"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $eight["8.2.l"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $eight["8.1.d"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $eight["8.1.m"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $eight["8.2.d"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $eight["8.2.m"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-ABC" )   $eight["8.1.e"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-ABC" )   $eight["8.1.n"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-ABC" )   $eight["8.2.e"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-ABC" )   $eight["8.2.n"]++;
		
		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $eight["8.3.a"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $eight["8.3.i"]++;

		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $eight["8.3.b"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $eight["8.3.j"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-ddI-NVP" )   $eight["8.4.a"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-ddI-NVP" )   $eight["8.4.k"]++;

		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $eight["8.4.b"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $eight["8.4.l"]++;
	}
	$eight["8.1.i"] = $eight["8.1.a"] + $eight["8.1.b"] + $eight["8.1.c"] + $eight["8.1.d"] + $eight["8.1.e"];
	$eight["8.1.r"] = $eight["8.1.j"] + $eight["8.1.k"] + $eight["8.1.l"] + $eight["8.1.m"] + $eight["8.1.n"];
	$eight["8.1.s"] = $eight["8.1.i"] + $eight["8.1.r"];

	$eight["8.2.i"] = $eight["8.2.a"] + $eight["8.2.b"] + $eight["8.2.c"] + $eight["8.2.d"] + $eight["8.2.e"];
	$eight["8.2.s"] = $eight["8.2.j"] + $eight["8.2.k"] + $eight["8.2.l"] + $eight["8.2.m"] + $eight["8.2.n"];
	$eight["8.2.u"] = $eight["8.2.i"] + $eight["8.2.s"];

	$eight["8.2.j"] = $eight["8.1.i"] + $eight["8.2.i"];
	$eight["8.2.t"] = $eight["8.1.r"] + $eight["8.2.s"];

	$eight["8.2.u"] = $eight["8.2.i"] + $eight["8.2.s"];
	$eight["8.2.v"] = $eight["8.2.j"] + $eight["8.2.t"];

	$eight["8.3.h"] = $eight["8.3.a"] + $eight["8.3.b"];
	$eight["8.3.p"] = $eight["8.3.i"] + $eight["8.3.j"];
	$eight["8.3.q"] = $eight["8.3.h"] + $eight["8.3.p"];

	$eight["8.4.h"] = $eight["8.4.a"] + $eight["8.4.b"];
	$eight["8.4.r"] = $eight["8.4.k"] + $eight["8.4.l"];
	$eight["8.4.u"] = $eight["8.4.h"] + $eight["8.4.r"];

	$eight["8.4.i"] = $eight["8.3.h"] + $eight["8.4.h"];
	$eight["8.4.s"] = $eight["8.3.p"] + $eight["8.4.r"];
	$eight["8.4.v"] = $eight["8.4.i"] + $eight["8.4.s"];

	$eight["8.4.j"] = $eight["8.2.j"] + $eight["8.4.i"];
	$eight["8.4.t"] = $eight["8.2.t"] + $eight["8.4.s"];
	$eight["8.4.w"] = $eight["8.2.v"] + $eight["8.4.v"];
}

function initNine ($eDate) {

	global $nine;

	$qry = "select distinct
		d.patientid,
		reasonDiscNoFollowup,
		reasonDiscDeath,
		ending,
		transferClinics,
		sex
		from v_discEnrollment d, #cMaxVitals p, discTable t
		where d.patientid = p.patientid and
			d.patientid = t.patientid and
			t.discDate <= '" . $eDate . "' and
			d.encounterType = 12";
		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";
	$result = dbQuery($qry);

	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetch ($result)) {
		$no = $row[1];
		$death = $row[2];
		$stop = $row[3];
		$trans = $row[4];
		$sex = $row[5];
		if ($death == 1 && $sex == 2) $nine["9.a"]++;
		if ($stop  == 1 && $sex == 2) $nine["9.b"]++;
		if ($no    == 1 && $sex == 2) $nine["9.c"]++;
		if ($trans == 1 && $sex == 2) $nine["9.d"]++;
		if ($death == 1 && $sex == 1) $nine["9.f"]++;
		if ($stop  == 1 && $sex == 1) $nine["9.g"]++;
		if ($no    == 1 && $sex == 1) $nine["9.h"]++;
		if ($trans == 1 && $sex == 1) $nine["9.i"]++;
	}
	$nine["9.e"] = $nine["9.a"] + $nine["9.b"] + $nine["9.c"] + $nine["9.d"];
	$nine["9.j"] = $nine["9.f"] + $nine["9.g"] + $nine["9.h"] + $nine["9.i"];
	$nine["9.k"] = $nine["9.a"] + $nine["9.f"];
	$nine["9.l"] = $nine["9.b"] + $nine["9.g"];
	$nine["9.m"] = $nine["9.c"] + $nine["9.h"];
	$nine["9.n"] = $nine["9.d"] + $nine["9.i"];
	$nine["9.o"] = $nine["9.e"] + $nine["9.j"];
}

/*function initFive ($siteCode, $startDate, $endDate, $unixEndDate) {
	// Number of persons who did not pick up their ART regimens


	//global $siteCode;
	global $five;
	//global $endDate;
	//global $unixEndDate;

	$oneBk = date("ym", strtotime("-1 months",$unixEndDate));
	$twoBk = date("ym", strtotime("-2 months",$unixEndDate));
	$thrBk = date("ym", strtotime("-3 months",$unixEndDate));

	$unionArray = array (
		array ( $oneBk, $oneBk ),
		array ( $twoBk, $oneBk ),
		array ( $thrBk, $oneBk ),
	);

	for ($i = 1; $i <= 3; $i++) {
		$qry = "select
			sex,
			count(distinct p.patientid) as pCnt
			from pepfarTable t, patient p
			where t.patientid = p.patientid and rtrim(sitecode) = '" . $siteCode . "' AND (t.forPepPmtct = 0 OR t.forPepPmtct IS NULL) and
			p.patientid not in (
				select patientid from pepfarTable where
				substring(convert(varchar,visitDate,112),3,4) between '" . $unionArray[$i - 1][0] . "' and '" . $unionArray[$i - 1][1] . "' AND (forPepPmtct = 0 OR forPepPmtct IS NULL)
			) and
			rtrim(siteCode) = '" . $siteCode . "'
			group by sex";
		$result = dbQuery($qry);

		if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";

		while ($row = psRowFetchAssoc ($result)) {
			$sex = $row[0];
			$cnt = $row[1];
			//print $sex . " " . $cnt;
			if ($i == 1 && $sex == 2 ) $five["5.1.a"] = $cnt;
			if ($i == 2 && $sex == 2 ) $five["5.1.b"] = $cnt;
			if ($i == 3 && $sex == 2 ) $five["5.1.c"] = $cnt;
			if ($i == 1 && $sex == 1 ) $five["5.1.e"] = $cnt;
			if ($i == 2 && $sex == 1 ) $five["5.1.f"] = $cnt;
			if ($i == 3 && $sex == 1 ) $five["5.1.g"] = $cnt;
		}
	}

	$five["5.1.a"] = $five["5.1.a"] - $five["5.1.b"];
	$five["5.1.b"] = $five["5.1.b"] - $five["5.1.c"];
	$five["5.1.e"] = $five["5.1.e"] - $five["5.1.f"];
	$five["5.1.f"] = $five["5.1.f"] - $five["5.1.g"];

	$five["5.1.d"] = $five["5.1.a"] + $five["5.1.b"] + $five["5.1.c"];
	$five["5.1.h"] = $five["5.1.e"] + $five["5.1.f"] + $five["5.1.g"];
	$five["5.1.i"] = $five["5.1.d"] + $five["5.1.h"];

	$qry = "select distinct
				d.patientid,
				reasonDiscNoFollowup,
				reasonDiscDeath,
				ending,
				transferClinics
		from discEnrollment d, encValid v
		where v.patientid = d.patientid and
			v.visitDate = d.visitdateyy + d.visitdatemm + d.visitdatedd and
			d.visitdateyy + d.visitdatemm = '" . $endDate . "' and
			rtrim(d.siteCode) = '" . $siteCode . "'";

	$result = dbQuery($qry);

	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchAssoc ($result)) {
		$no = $row[1];
		$death = $row[2];
		$stop = $row[3];
		$trans = $row[4];
		if ($no == 1)    $five["5.2.a"]++;
		if ($death == 1) $five["5.2.b"]++;
		if ($stop == 1)  $five["5.2.c"]++;
		if ($trans == 1) $five["5.2.d"]++;
	}

}*/

function insertToPep ($arg1, $arg2, $arg3, $arg4, $arg5, $arg6) {
	dbQuery("insert into pepfarRecords values (" .
		$arg1 . "," . $arg2 . ", '" . $arg3 . "','" . $arg4 . "','" . $arg5 . "','" . $arg6 . "')");
}

function escapeSingleQuotes($string) {
   $singQuotePattern = "'";
   $singQuoteReplace = "''";
   return(stripslashes(eregi_replace($singQuotePattern, $singQuoteReplace, $string)));
}

function generateMaxVitals($tableName, $site, $theDate) {
	$qry = "create table " . $tableName . " (patientid varchar(11) null, visitdate datetime null, pregnant int null, sex tinyint null, ageYears int null)";
	dbQuery ($qry);
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . " Create table statement for generateMaxVitals is " . $qry;
	$qry1 = "select p.patientid, v.visitdate, 
			case when v.pregnant between 1 and 2 then v.pregnant else 0 end as pregnant, 
			case when p.sex between 1 and 2 then p.sex else 0 end as sex, 
			case when isNumeric(p.ageYears) = 1 then p.ageYears else 0 end as ageYears 
		from v_vitals v, patient p 
		where v.patientid = p.patientid and visitdate <= '" . $theDate . "' and sitecode = '" . $site . "' and p.patientid not in (
			select patientid from discTable where discDate <= '" . $theDate . "'
		)
		order by p.patientid, visitdate desc";

	$oldID = "";
	$cnt = 0;
	$result1 = dbQuery($qry1);
	while ($row = psRowFetch ($result1)) {
		if ($oldID != $row[0]) {
			$cnt++;
			$age = $row['ageYears'];
			dbQuery("insert into " . $tableName . " (patientid, visitdate, pregnant, sex, ageYears) values ('" . $row['patientid'] . "','" . $row['visitdate'] . "'," . $row['pregnant'] . "," . $row['sex'] . ",'" . $age . "')");
			$oldID = $row[0];
		}
	}
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . " Count of patients in first step of generateMaxVitals is " . $cnt . " and query is " . $qry1;
	
	/* add a null pregnant record (0 pregnant) for patients with only a registration form */
	$qry2 = "insert into " . $tableName . " (patientid, visitdate, pregnant, sex, ageYears)
		select patientid, max(visitdate), 0 as pregnant, 
			case when sex between 1 and 2 then sex else 0 end as sex, 
			case when isNumeric(ageYears) = 1 then ageYears else 0 end as ageYears
		from v_patients 
		where encountertype in (10,15) and visitdate <= '" . $theDate . "' and sitecode = '" . $site . "' and patientid not in (
			select patientid from discTable where discDate <= '" . $theDate . "'
		)
		group by patientid, case when sex between 1 and 2 then sex else 0 end, case when isNumeric(ageYears) = 1 then ageYears else 0 end
		having count(patientid) = 1";
	$result = dbQuery($qry2);
	
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . " Count of patients in 2nd step of generateMaxVitals is " . psModifiedCount($result) . " and query is " . $qry2;
	dbQuery ("create index " . $tableName . "Index on " . $tableName . " (patientid, visitdate)");
}

function generateMaxVitalsOLD($tableName, $site, $theDate) {
	$qry = "create table " . $tableName . " (patientid varchar(11) null, visitdate datetime null, pregnant int null, sex tinyint null, ageYears int null)";
	dbQuery ($qry);
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . " Create table for generateMaxVitals is " . $qry;
	/* run a loop on maxVitals in order to update it's pregnant, sex, and ageYears values */

	$qry1 = "select p.patientid, visitdate, pregnant, sex, case when isNumeric(ageYears) = 1 then ageYears else 0 end as ageYears from v_vitals v, patient p where v.patientid = p.patientid and
	visitdate <= '" . $theDate . "' and sitecode = '" . $site . "'
	order by p.patientid, visitdate desc";
	$oldID = "";
	$cnt = 0;
	$result1 = dbQuery($qry1);
	while ($row = psRowFetch ($result1)) {
		if ($oldID != $row[0]) {
			$cnt++;
			//$age = (is_int($row['ageYears'])) ? $row['ageYears'] : 0;
			$age = $row['ageYears'];
			dbQuery("insert into " . $tableName . " (patientid, visitdate, pregnant, sex, ageYears) values ('" . $row['patientid'] . "','" . $row['visitdate'] . "'," . $row['pregnant'] . "," . $row['sex'] . "," . $age . ")");
			$oldID = $row[0];
		}
	}
	if (DEBUG_FLAG) echo "<br />" . date('h:i:s A') . " Count of patients in first step of generateMaxVitals is " . $cnt . " and query is " . $qry1;
	/* add a null pregnant record (0 pregnant) for patients with only a registration form and valid ageYears */
	$qry = "insert into " . $tableName . " (patientid, visitdate, pregnant, sex, ageYears)
		select distinct patientid, visitdate, 0, sex, ageYears from v_patients where isNumeric(ageYears) = 1 and patientid in (
			select patientid from encValid where patientid in (
				select patientid from encValid where encountertype in (10,15) and visitdate <= '" . $theDate . "' and sitecode = '" . $site . "'
			) 
			group by patientid having count(encounter_id) = 1
		) ";
	$result = dbQuery($qry);
	 /* add a null pregnant record (0 pregnant) for patients with only a registration form and no ageYears */
	$qry = "insert into " . $tableName . " (patientid, visitdate, pregnant, sex, ageYears)
		select distinct patientid, visitdate, 0, sex, 0 from v_patients where isNumeric(ageYears) <> 1 and patientid in (
			select patientid from encValid where patientid in (
				select patientid from encValid where encountertype in (10,15) and visitdate <= '" . $theDate . "' and sitecode = '" . $site . "'
			) 
			group by patientid having count(encounter_id) = 1
		) ";
	$result = dbQuery($qry);	
	/* remove discontinued patients */
	$qry = "delete from " . $tableName . " where patientid in (select patientid from discTable where discDate <= '" . $theDate . "')";
	$result = dbQuery($qry);
}

?>
