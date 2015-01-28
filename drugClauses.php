<?php
//echo date('h:i:s A');

// Check for required fields and validate user input

// Check form date fields and send back if errors

$errors = getErrors ($_POST, 14, 1);

if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
if (!empty ($_POST['lang'])) $lang = $_POST['lang'];
$lang = (empty ($lang) || !in_array ($lang, $langs)) ? $def_lang : $lang;

if (!empty ($errors)) {
	$paramList = $_POST['startMm'] . "|" . $_POST['startYy'] . "|" . $_POST['endMm'] . "|" . $_POST['endYy'];
    $loc = "location: reportSetup.php&lang=$lang&code=1&natID=$paramList";
    header ($loc);
	exit;
}

$debugFlag = false;

$siteCode = "";
if (!empty ($_POST['siteCode']))
	$siteCode = $_POST['siteCode'];

$startMm = $_POST['startMm'];
$startYy = $_POST['startYy'];
// put date in YYMM format
$startDate = $startYy . $startMm;

$endMm = $_POST['endMm'];
$endYy = $_POST['endYy'];
$endDate = $endYy . $endMm;

$year = $endYy;
$month = $endMm;
$unixEndDate = mktime(0,0,0, $month, 1, $year);

// initialize arrays for report tables
$one = array ("1.a" => 0,"1.b" => 0,"1.c" => 0,"1.d" => 0,"1.e" => 0,"1.f" => 0,"1.g" => 0,"1.h" => 0,"1.i" => 0,"1.j" => 0,"1.k" => 0,"1.l" => 0,"1.m" => 0,"1.n" => 0,"1.o" => 0,"1.p" => 0,"1.q" => 0,"1.r" => 0, "1.s" => 0);

$two = array ("2.a" => 0,"2.b" => 0,"2.c" => 0,"2.d" => 0,"2.e" => 0,"2.f" => 0,"2.g" => 0,"2.h" => 0,"2.i" => 0,"2.j" => 0,"2.k" => 0,"2.l" => 0,"2.m" => 0,"2.n" => 0,"2.o" => 0,"2.p" => 0,"2.q" => 0,"2.r" => 0, "2.s" => 0,"2.t" => 0,"2.u" => 0,"2.v" => 0);

$three = array ("3.a" => 0,"3.b" => 0,"3.c" => 0,"3.d" => 0,"3.e" => 0,"3.f" => 0,"3.g" => 0,"3.h" => 0,"3.i" => 0,"3.j" => 0,"3.k" => 0,"3.l" => 0,"3.m" => 0,"3.n" => 0,"3.o" => 0,"3.p" => 0);

$four = array ("4.1.a" => 0,"4.1.b" => 0,"4.1.c" => 0,"4.1.d" => 0,"4.1.i" => 0,"4.1.j" => 0,"4.1.k" => 0,"4.1.l" => 0,"4.1.m" => 0,"4.1.r" => 0,"4.1.s" => 0,
"4.2.a" => 0,"4.2.b" => 0,"4.2.c" => 0,"4.2.d" => 0,"4.2.i" => 0,"4.2.j" => 0,"4.2.k" => 0,"4.2.l" => 0,"4.2.m" => 0,"4.2.n" => 0,"4.2.s" => 0,"4.2.t" => 0,"4.2.u" => 0,"4.2.v" => 0,
"4.3.a" => 0,"4.3.b" => 0,"4.3.h" => 0,"4.3.i" => 0,"4.3.j" => 0,"4.3.p" => 0,"4.3.q" => 0,
"4.4.a" => 0,"4.4.b" => 0,"4.4.h" => 0,"4.4.i" => 0,"4.4.j" => 0,"4.4.k" => 0,"4.4.l" => 0,"4.4.r" => 0,"4.4.s" => 0,"4.4.t" => 0,"4.4.u" => 0,"4.4.v" => 0,"4.4.w" => 0,
"4.4.c" => 0,
"4.4.m" => 0,
"4.4.d" => 0,
"4.4.n" => 0,
"4.4.e" => 0,
"4.4.o" => 0,
"4.4.f" => 0,
"4.4.p" => 0,
"4.4.g" => 0,
"4.4.q" => 0,
"4.3.c" => 0,
"4.3.k" => 0,
"4.3.d" => 0,
"4.3.l" => 0,
"4.3.e" => 0,
"4.3.m" => 0,
"4.3.f" => 0,
"4.3.n" => 0,
"4.3.g" => 0,
"4.3.o" => 0,
"4.2.e" => 0,
"4.2.o" => 0,
"4.2.f" => 0,
"4.2.p" => 0,
"4.2.g" => 0,
"4.2.q" => 0,
"4.2.h" => 0,
"4.2.r" => 0,
"4.1.e" => 0,
"4.1.n" => 0,
"4.1.f" => 0,
"4.1.o" => 0,
"4.1.g" => 0,
"4.1.p" => 0,
"4.1.h" => 0,
"4.1.q" => 0);

$five = array ("5.1.a" => 0,"5.1.b" => 0,"5.1.c" => 0,"5.1.d" => 0,"5.1.e" => 0,"5.1.f" => 0,"5.1.g" => 0,"5.1.h" => 0,"5.1.i" => 0,
"5.2.a" => 0,"5.2.b" => 0,"5.2.c" => 0,"5.2.d" => 0);

$six = array ("6.a" => "","6.b" => "","6.c" => "","6.d" => "","6.e" => "","6.f" => "","6.g" => "","6.h" => "","6.i" => "","6.j" => "","6.k" => "","6.l" => "","6.m" => "","6.n" => "","6.o" => "","6.p" => "","6.q" => "");

genTempTables();

// main function for generating the reports individual cells
function reportGen($cell = "") {

	global $lang;
	global $debugFlag;
	global $siteCode;
	global $one;
	global $two;
	global $three;
	global $four;
	global $five;
	global $startDate;
	global $endDate;
	global $unixEndDate;
	global $localizedMonths;

	// This top switch statement puts header info into the report
    switch ($cell) {
		case "month":
			return ( $localizedMonths[$lang][date("n", $unixEndDate) - 1] );
			break;
		case "year":
			return ( "20" . substr($endDate,0,2) );
			break;
		case "facility":
			return ( getSiteName($siteCode, $lang) );
			break;
		case "location":
			return ( getSiteLocation($siteCode) );
			break;
		case "grantee":
			return ("I-TECH");
			break;
		case "country":
			return ("Haiti");
			break;
		case "6.q":
			return ("");
			break;
    }

	// Determine which view, table, or query to use by looking at the report section # or cell
	switch (substr($cell,0,1)) {
		case "1":
			if ($cell == "1.s") {
				return ($one["1.r"] - $two["2.r"]);
			} else {
				return ($one[$cell]);
			}
			break;
		case "2":
			switch ($cell) {
				case "2.s":
					// persons already enrolled who transferred in last month ($endDate)
					$qry = "select count(distinct patientid) from pepfar
						where rtrim(sitecode) = '" . $siteCode . "' and
						patientid in (select patientid from vitals where transferin = 1 and
						visitdateyy + visitdatemm = '" . $endDate . "')";
					break;
				case "2.t":
					// persons who restarted ART during the last month after stopping for at least one month
					$twoM = date("ym", strtotime("-1 months",$unixEndDate));
					$threeM = date("ym", strtotime("-2 months",$unixEndDate));
					$qry = "
						select count(distinct p.patientid) from pepfar p, startARV s
						where rtrim(p.sitecode) = '" . $siteCode . "' and
						p.patientid = s.patientid and
						left(p.visitDate,4) = '" . $endDate . "' and
						p.patientid not in (select patientid from pepfar where left(visitDate,4) = '" . $twoM . "') and
						left(s.visitdate,4) <= '" . $threeM . "'";
					break;
				case "2.u":
					// number of baseline CD4 counts for persons who started ART in the last month
					$qry = "select count(distinct m.patientid) from medicalEligARVs m, startARV s
						where m.patientid = s.patientid and
						cd4 is not null and cd4 != '' and
						left(s.visitDate,4) = '" . $endDate . "'";
					break;
				case "2.v":
					// median baseline CD4 count for persons who started ART in the last month
					$qry = "select round(avg(cd4)) from medicalEligARVs m, startARV s
						where m.patientid = s.patientid and
						cd4 is not null and cd4 != '' and isnumeric(cd4) = 1 and
						left(s.visitDate,4) = '" . $endDate . "'";
					break;
				default:
					return ($two[$cell]);
			}
			if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";
			break;
		case "3";
			return ($three[$cell]);
			break;
		case "4";
			return ($four[$cell]);
			break;
		case "5";
			return ($five[$cell]);
			break;
		case "6";
			return ("&nbsp");
			break;
		default:
			return("");
	}

    $value = "";
    if (!empty($qry)) {
         $result = dbQuery($qry);
	 $row = psRowFetch($result);
	 $value = $row[0];
	 if ($debugFlag)
	   if ($cell == "2.t") print "value is: " . $value  . "<br>";
    }
    if (empty($value)) $value = 0;
    return ($value);
}

function genTempTables() {
	global $debugFlag;
	global $siteCode;
	global $endDate;

	// try to get as many age values calculated as possible
	doQuery("
update patient 
set ageYears = DATEDIFF(year, dbo.ymdToDate(dobyy, dobmm, dobdd), GETDATE())
where isdate(dbo.ymdToDate(dobyy, dobmm, dobdd)) = 1 
and (ageYears is null or ageYears = '')");

    if ($debugFlag) print "***********initOne**********<br>";

    initOne();
/*
    doQuery("if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[pepfar]') and OBJECTPROPERTY(id, N'IsView') = 1) drop view [dbo].[pepfar]");

    doQuery("
        	create view pepfar as select rtrim(d1.siteCode) as siteCode, d1.visitdateYy + d1.visitdateMm + d1.visitdateDd as visitDate,
				p.sex,
				p.ageYears as age,
				p.patientid,
				shortname as regimen,
				v.pregnant
				from prescriptions d1, prescriptions d2, prescriptions d3, regimen r, patient p, vitals v
				where d1.patientid = p.patientid and
				d1.siteCode = d2.siteCode and
				d1.patientid = d2.patientid and
				d1.visitdatedd = d2.visitdatedd and
				d1.visitdatemm = d2.visitdatemm  and
				d1.visitdateyy = d2.visitdateyy and
				d1.seqNum = d2.seqNum and
				d1.siteCode = d3.siteCode and
				d1.patientid = d3.patientid and
				d1.visitdatedd = d3.visitdatedd and
				d1.visitdatemm = d3.visitdatemm and
				d1.visitdateyy = d3.visitdateyy and
				d1.seqNum = d3.seqNum and
				v.patientid = d1.patientid and
				r.drugID1 = d1.drugID and
				r.drugID2 = d2.drugID and
				r.drugID3 = d3.drugID and
				r.drugID3 != 0 and
				d1.siteCode = '" . $siteCode . "'
			union
			select rtrim(d1.siteCode), d1.visitdateYy + d1.visitdateMm + d1.visitdateDd,
				p.sex,
				p.ageYears,
				p.patientid,
				shortname,
				v.pregnant
				from prescriptions d1, prescriptions d2, regimen r, patient p, vitals v
				where d1.patientid = p.patientid and
				d1.siteCode = d2.siteCode and
				d1.patientid = d2.patientid and
				d1.visitdatedd = d2.visitdatedd and
				d1.visitdatemm = d2.visitdatemm  and
				d1.visitdateyy = d2.visitdateyy and
				d1.seqNum = d2.seqNum and
				v.patientid = d1.patientid and
				r.drugID1 = d1.drugID and
				r.drugID2 = d2.drugID and
				r.drugID3 = 0 and
				d1.siteCode = '" . $siteCode . "'
		");
*/
	doQuery("if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[startARV]')) drop table startARV");

    doQuery("create table startARV (siteCode char(10) ,patientid varchar(11), age varchar(5), sex tinyint, pregnant tinyint, visitdate char(6))");

	// startARV holds each patient's earliest Pepfar (ART) visit, along with age, sex, and pregnant attributes
    doQuery("insert into startARV
        	select
        		p.siteCode,
        		p.patientid,
        		age,
				sex,
				v.pregnant,
				min(visitDate) as visitDate
			from pepfar p, vitals v
			where rtrim(p.sitecode) = '" . $siteCode . "' and
			p.patientid = v.patientid and
			p.visitDate = v.visitDateYy + v.visitDateMm + v.visitDateDd and
			age is not null and
			age != ''
			group by p.siteCode, p.patientid, age, sex, pregnant");

/*
	doQuery("if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[patStart]')) drop table 	patStart");

	// patStart holds all patients that started in $endDate (the month the report is running for).
	doQuery("create table patStart (patientid varchar(11))");

	doQuery("insert into patStart
			select patientid from patient where
				patientid not in (select patientid from pepfar where left(visitDate,4) < '" . $endDate . "') and
				patientid in (select patientid from pepfar where left(visitDate,4) = '" . $endDate . "')");
*/
    if ($debugFlag) print "***********initTwo**********<br>";
	initTwo();
    if ($debugFlag) print "***********initThree**********<br>";
	initThree();
    if ($debugFlag) print "***********initFour**********<br>";
	initFour();
    if ($debugFlag) print "***********initFive**********<br>";
	initFive();
}

function initOne () {
	// cumulative persons enrolled in care

	global $debugFlag;
	global $siteCode;
	global $one;
	global $startDate;
	global $endDate;

	$qry = "select rtrim(e.siteCode),
			e.patientid,
			p.ageYears,
			p.sex,
			v.pregnant,
			min (e.visitdateyy + e.visitdatemm) as visitDate
		from patient p, encValid e, vitals v
		where p.patientid = e.patientid and
			v.patientid = e.patientid
			and e.sitecode = v.sitecode and
			e.visitdateyy = v.visitdateyy and
			e.visitdatemm = v.visitdatemm and
			e.visitdatedd = v.visitdatedd and
			e.encountertype = 10 and
			rtrim(e.siteCode) = '" . $siteCode . "' and
			p.ageYears is not null and
			isdate(dbo.ymdToDate(e.visitdateyy, e.visitdatemm, e.visitdatedd)) = 1
			group by rtrim(e.siteCode), e.patientid, p.ageYears, p.sex, v.pregnant";

	$result = dbQuery($qry);

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$site = $row[0];
		$age = $row[2];
		$sex = $row[3];
		$pregnant = $row[4];
		$visitDate = $row[5];

		if ($sex == 2 && $age > 14  && $visitDate <= $startDate)                   $one["1.a"]++;
		if ($sex == 1 && $age > 14  && $visitDate <= $startDate && $pregnant != 1) $one["1.b"]++;
		if ($sex == 1 && $age > 14  && $visitDate <= $startDate && $pregnant == 1) $one["1.c"]++;
		if ($sex == 2 && $age <= 14 && $visitDate <= $startDate)                   $one["1.d"]++;
		if ($sex == 1 && $age <= 14 && $visitDate <= $startDate)                   $one["1.e"]++;
		if ($sex == 2 && $age > 14  && $visitDate == $endDate)                   $one["1.g"]++;
		if ($sex == 1 && $age > 14  && $visitDate == $endDate && $pregnant != 1) $one["1.h"]++;
		if ($sex == 1 && $age > 14  && $visitDate == $endDate && $pregnant == 1) $one["1.i"]++;
		if ($sex == 2 && $age <= 14 && $visitDate == $endDate)                   $one["1.j"]++;
		if ($sex == 1 && $age <= 14 && $visitDate == $endDate)                   $one["1.k"]++;
	}
	$one["1.f"] = $one["1.a"] + $one["1.b"] + $one["1.c"] + $one["1.d"] + $one["1.e"];
	$one["1.l"] = $one["1.g"] + $one["1.h"] + $one["1.i"] + $one["1.j"] + $one["1.k"];

	$one["1.m"] = $one["1.a"] + $one["1.g"];
	$one["1.n"] = $one["1.b"] + $one["1.h"];
	$one["1.o"] = $one["1.c"] + $one["1.i"];
	$one["1.p"] = $one["1.d"] + $one["1.j"];
	$one["1.q"] = $one["1.e"] + $one["1.k"];

	$one["1.r"] = $one["1.f"] + $one["1.l"];
}

function initTwo () {
	// cumulative persons on ART

	global $debugFlag;
	global $siteCode;
	global $two;
	global $startDate;
	global $endDate;

	$qry = "select
			siteCode,
			patientid,
			age,
			sex,
			pregnant,
			visitdate
		from startARV where rtrim(siteCode) = '" . $siteCode . "'";

	$result = dbQuery($qry);

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$site = $row[0];
		$age = $row[2];
		$sex = $row[3];
		$pregnant = $row[4];
		$visitDate = substr($row[5],0,4);

		if ($sex == 2 && $age > 14  && $visitDate <= $startDate)                   $two["2.a"]++;
		if ($sex == 1 && $age > 14  && $visitDate <= $startDate && $pregnant != 1) $two["2.b"]++;
		if ($sex == 1 && $age > 14  && $visitDate <= $startDate && $pregnant == 1) $two["2.c"]++;
		if ($sex == 2 && $age <= 14 && $visitDate <= $startDate)                   $two["2.d"]++;
		if ($sex == 1 && $age <= 14 && $visitDate <= $startDate)                   $two["2.e"]++;
		if ($sex == 2 && $age > 14  && $visitDate == $endDate)                     $two["2.g"]++;
		if ($sex == 1 && $age > 14  && $visitDate == $endDate && $pregnant != 1)   $two["2.h"]++;
		if ($sex == 1 && $age > 14  && $visitDate == $endDate && $pregnant == 1)   $two["2.i"]++;
		if ($sex == 2 && $age <= 14 && $visitDate == $endDate)                     $two["2.j"]++;
		if ($sex == 1 && $age <= 14 && $visitDate == $endDate)                     $two["2.k"]++;
	}
	$two["2.f"] = $two["2.a"] + $two["2.b"] + $two["2.c"] + $two["2.d"] + $two["2.e"];
	$two["2.l"] = $two["2.g"] + $two["2.h"] + $two["2.i"] + $two["2.j"] + $two["2.k"];

	$two["2.m"] = $two["2.a"] + $two["2.g"];
	$two["2.n"] = $two["2.b"] + $two["2.h"];
	$two["2.o"] = $two["2.c"] + $two["2.i"];
	$two["2.p"] = $two["2.d"] + $two["2.j"];
	$two["2.q"] = $two["2.e"] + $two["2.k"];

	$two["2.r"] = $two["2.f"] + $two["2.l"];
}

function initThree () {
	// Change in CD4 count and adherence

	global $debugFlag;
	global $siteCode;
	global $three;
	global $endDate;
	global $unixEndDate;

	$sixM = date("ym", strtotime("-6 months",$unixEndDate));
	$twelveM = date("ym", strtotime("-12 months",$unixEndDate));

	$three["3.a"] = substr($sixM,2,2) . "/" . substr($sixM,0,2);
	$three["3.i"] = substr($twelveM,2,2) . "/" . substr($twelveM,0,2);

	doQuery("if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[cohort]')) drop table cohort");

	doQuery("create table cohort (siteCode char(10) ,patientid varchar(11), minDate char(6), cntDates char(6))");

	// This establishes which patients are in each cohort; remember that count of visits is unrelated to membership in cohort
	doQuery("
		insert into cohort
		select distinct
			rtrim(siteCode) as siteCode,
			patientid,
			min(visitDate) as minDate,
			count(distinct visitDate) as cntDates
		from pepfar
		where rtrim(sitecode) = '" . $siteCode . "'
		group by rtrim(siteCode), patientid
		having (
			left(min(visitDate),4) = '" . $sixM . "' or
			left(min(visitDate),4) = '" . $twelveM . "'
		)
	");

	$qry = "select * from cohort where rtrim(siteCode) = '" . $siteCode . "'";

	$result = dbQuery($qry);

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$site = $row[0];
		$id = $row[1];
		$minDate = substr($row[2],0,4);
		$cntDates = $row[3];

		// count of patients in cohort (6 and 12 months before $endDate)
		if ($minDate == $sixM)  $three["3.b"]++;
		if ($minDate == $twelveM) $three["3.j"]++;

		// patients who picked up each month during period
		// patients must have a count = # months (don't need to exactly fall into each month) AND be in the cohort
		if ($minDate == $sixM && $cntDates == 6) $three["3.h"]++;
		if ($minDate == $twelveM && $cntDates == 12) $three["3.p"]++;
	}

	$qry = "select
			p.siteCode,
			p.patientid,
			c.cntDates
		from pepfar p, cohort c
		where
			p.patientid = c.patientid and
			rtrim(p.siteCode) = '" . $siteCode . "' and
			cntDates in (6,12) and
			left(visitDate,4) = '" . $endDate . "'";

	$result = dbQuery($qry);

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$site = $row[0];
		$id = $row[1];
		$cntDates = $row[2];

		// count of patients still in cohort
		if ($cntDates == 6)  $three["3.e"]++;
		if ($cntDates == 12) $three["3.m"]++;
	}

	$qry = "select distinct
			m.patientid,
			c.cntDates,
			m.visitDateYy + m.visitDateMm + m.visitDateDd as visitDate,
			count(distinct m.cd4),
			round(avg(m.cd4))
		from cohort c, medicalEligARVs m
		where c.patientid = m.patientid
		group by m.patientid, c.cntDates, m.visitDateYy + m.visitDateMm + m.visitDateDd";

	$result = dbQuery($qry);

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$id = $row[0];
		$cntDates = $row[1];
		$visitDate = substr($row[2],0,4);
		$cd4Cnt = $row[3];
		$cd4Avg = $row[4];

		// count of not null cd4 prior to start of cohort
		if ($visitDate < $sixM      && !empty($cd4Cnt) && $cntDates == 6) $three["3.c"]++;
		if ($visitDate < $twelveM   && !empty($cd4Cnt) && $cntDates == 12) $three["3.k"]++;

		// sum of not null cd4 prior to start of cohort
		if ($visitDate < $sixM      && !empty($cd4Avg) && $cntDates == 6) $three["3.d"] += $cd4Avg;
		if ($visitDate < $twelveM   && !empty($cd4Avg) && $cntDates == 12) $three["3.l"] += $cd4Avg;

		// count of not null cd4 now
		if ($visitDate == $endDate  && !empty($cd4Cnt) && $cntDates == 6) $three["3.f"]++;
		if ($visitDate == $endDate  && !empty($cd4Cnt) && $cntDates == 12) $three["3.n"]++;

		// sum of not null cd4 now
		if ($visitDate == $endDate  && !empty($cd4Avg) && $cntDates == 6) $three["3.g"] += $cd4Avg;
		if ($visitDate == $endDate && !empty($cd4Avg) && $cntDates == 12) $three["3.o"] += $cd4Avg;
	}
	if ($three["3.c"] != 0) $three["3.d"] = $three["3.d"]/$three["3.c"];
	if ($three["3.k"] != 0) $three["3.l"] = $three["3.l"]/$three["3.k"];
	if ($three["3.f"] != 0) $three["3.g"] = $three["3.g"]/$three["3.f"];
	if ($three["3.n"] != 0) $three["3.o"] = $three["3.o"]/$three["3.n"];

}

function initFour () {
	// Regimen counts for $endDate

	global $debugFlag;
	global $siteCode;
	global $four;
	global $endDate;

	$qry = "select
			siteCode,
			visitDate,
			sex,
			age,
			patientid,
			regimen
		from pepfar
		where rtrim(siteCode) = '" . $siteCode . "'";

	$result = dbQuery($qry);

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$site = $row[0];
		$visitDate = substr($row[1],0,4);
		$sex = $row[2];
		$age = $row[3];
		$regimen = $row[5];

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $four["4.1.a"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $four["4.1.j"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $four["4.2.a"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-NVP" )   $four["4.2.k"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $four["4.1.b"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $four["4.1.k"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $four["4.2.b"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $four["4.2.l"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $four["4.1.c"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $four["4.1.l"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $four["4.2.c"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-NVP" )   $four["4.2.m"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $four["4.1.d"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $four["4.1.m"]++;
		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $four["4.2.d"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-3TC-EFV" )   $four["4.2.n"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $four["4.3.a"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $four["4.3.i"]++;

		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $four["4.3.b"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "d4T-3TC-EFV" )   $four["4.3.j"]++;

		if ($sex == 2 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-ddI-NVP" )   $four["4.4.a"]++;
		if ($sex == 1 && $age > 14   && $visitDate == $endDate && $regimen == "d4T-ddI-NVP" )   $four["4.4.k"]++;

		if ($sex == 2 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $four["4.4.b"]++;
		if ($sex == 1 && $age <= 14  && $visitDate == $endDate && $regimen == "ZDV-ddI-LPV/r" ) $four["4.4.l"]++;
	}
	$four["4.1.i"] = $four["4.1.a"] + $four["4.1.b"] + $four["4.1.c"] + $four["4.1.d"];
	$four["4.1.r"] = $four["4.1.j"] + $four["4.1.k"] + $four["4.1.l"] + $four["4.1.m"];
	$four["4.1.s"] = $four["4.1.i"] + $four["4.1.r"];

	$four["4.2.i"] = $four["4.2.a"] + $four["4.2.b"] + $four["4.2.c"] + $four["4.2.d"];
	$four["4.2.s"] = $four["4.2.k"] + $four["4.2.l"] + $four["4.2.m"] + $four["4.2.n"];
	$four["4.2.u"] = $four["4.2.i"] + $four["4.2.s"];

	$four["4.2.j"] = $four["4.1.i"] + $four["4.2.i"];
	$four["4.2.t"] = $four["4.1.r"] + $four["4.2.s"];

	$four["4.2.u"] = $four["4.2.i"] + $four["4.2.s"];
	$four["4.2.v"] = $four["4.2.j"] + $four["4.2.t"];

	$four["4.3.h"] = $four["4.3.a"] + $four["4.3.b"];
	$four["4.3.p"] = $four["4.3.i"] + $four["4.3.j"];
	$four["4.3.q"] = $four["4.3.h"] + $four["4.3.p"];

	$four["4.4.h"] = $four["4.4.a"] + $four["4.4.b"];
	$four["4.4.r"] = $four["4.4.k"] + $four["4.4.l"];
	$four["4.4.u"] = $four["4.4.h"] + $four["4.4.r"];

	$four["4.4.i"] = $four["4.3.h"] + $four["4.4.h"];
	$four["4.4.s"] = $four["4.3.p"] + $four["4.4.r"];
	$four["4.4.v"] = $four["4.4.i"] + $four["4.4.s"];

	$four["4.4.j"] = $four["4.2.j"] + $four["4.4.i"];
	$four["4.4.t"] = $four["4.2.t"] + $four["4.4.s"];
	$four["4.4.w"] = $four["4.2.v"] + $four["4.4.v"];
}

function initFive () {
	// Number of persons who did not pick up their ART regimens

	global $debugFlag;
	global $siteCode;
	global $five;
	global $endDate;
	global $unixEndDate;

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
			count(distinct patientid) as pCnt
			from pepfar
			where rtrim(sitecode) = '" . $siteCode . "' and
			patientid not in (
			select patientid from pepfar
			where left(visitDate,4) between '" . $unionArray[$i - 1][0] . "' and '" . $unionArray[$i - 1][1] . "') and
			rtrim(siteCode) = '" . $siteCode . "'
			group by sex";
		$result = dbQuery($qry);

		if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

		while ($row = psRowFetchNum($result)) {
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

	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";

	while ($row = psRowFetchNum($result)) {
		$no = $row[1];
		$death = $row[2];
		$stop = $row[3];
		$trans = $row[4];
		if ($no == 1)    $five["5.2.a"]++;
		if ($death == 1) $five["5.2.b"]++;
		if ($stop == 1)  $five["5.2.c"]++;
		if ($trans == 1) $five["5.2.d"]++;
	}

}

function doQuery($qry) {
	global $debugFlag;

	$result = dbQuery($qry);
	if (!$result) die("query failed: " . $qry);
	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";
}

?>
