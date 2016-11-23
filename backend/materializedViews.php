<?php
require_once 'backend.php';
require_once 'backend/config.php';
require_once 'backend/database.php';

function runQueries($stmt, $start = 0) {
  if ($start > sizeof($stmt)) {
    return '';
  }
  for ($i=$start; $i < sizeof($stmt); $i++) {
    //$startTime = microtime(true);
    $result = dbQuery($stmt[$i]);
    //print 'q:' . (microtime(true) - $startTime) . "\n";
    //print $stmt[$i] . "\n\n";
    if (DEBUG_FLAG) {
      echo "<br>" . date('h:i:s A') . "<br>" . $stmt[$i] . "<br>" . psModifiedCount($result);
    }
  }
  return $result;
}

/**
 * from 41rc2upodate.sql
 */
function bloodEval($mode = 1, $endDate = null) {
  $dateQual = "";
  if ($endDate != "" && $endDate != "null" && $endDate != null) {
    $dateQual = " and dbo.ymdToDate(visitdateyy, visitdatemm, visitdatedd) <= '" . $endDate . "'";
  }

  $where = "
where b.patientid = v.patientid
 and b.visitdate = v.visitdate
 and b.seqNum = v.seqNum
 and ";
  $frm1 = " from #bloodeval1Temp b, v_labsCompleted v ";
  $frm2 = " from #bloodeval2Temp b, v_labsCompleted v ";

  //compute new data for bloodeval1
  $stmt = array();	
  $stmt[] = "
create table #bloodeval1Temp
(patientid varchar(11) not null,
 visitdate varchar(10) not null,
 seqNum tinyint not null,
 labid1 int null,
 labid2 int null,
 labid3 int null,
 labid4 int null,
 labid5 int null);";
  $stmt[] = "create index bloodeval1TempIndex on #bloodeval1Temp (patientid, visitdate)";
  $stmt[] = "
insert into #bloodeval1Temp (patientid, visitdate, seqNum, labid1) 
select distinct patientid, visitDate, seqNum, labid 
from v_labsCompleted 
where labid = 148
 and isdate(dbo.ymdToDate(visitdateyy, visitdatemm, visitdatedd)) = 1" . $dateQual;
  $stmt[] = "update b set b.labid2 = 175 " . $frm1 . $where . " v.labid = 175";
  $stmt[] = "update b set b.labid3 = 177 " . $frm1 . $where . " v.labid = 177";
  $stmt[] = "update b set b.labid4 = 105 " . $frm1 . $where . " v.labid = 105";
  $stmt[] = "update b set b.labid5 = 146 " . $frm1 . $where . " v.labid = 146";
  runQueries($stmt);

  //update bloodeval1
  dbBeginTransaction();
  dbQuery("truncate table bloodeval1;");
  dbLockTables(array('#bloodeval1Temp', 'bloodeval1'));
  dbQuery("
insert into bloodeval1 (patientid, visitdate, seqNum, labid1, labid2, labid3, labid4, labid5)
select patientid, visitdate, seqNum, labid1, labid2, labid3, labid4, labid5
from #bloodeval1Temp;");
  dbCommit();
  dbUnlockTables();

  //compute new data for bloodeval2
  $stmt = array();	
  $stmt[] = "
create table #bloodeval2Temp
(patientid varchar(11) not null,
 visitdate varchar(10) not null,
 seqNum tinyint not null,
 labid1 int null,
 labid2 int null,
 labid3 int null,
 labid4 int null);";
  $stmt[] = "create index bloodeval2TempIndex on #bloodeval2Temp (patientid, visitdate)";
  $stmt[] = "
insert into #bloodeval2Temp (patientid, visitdate, seqNum, labid1) 
select distinct patientid, visitdate, seqNum, labid 
from v_labsCompleted 
where labid = 111" . $dateQual;
  $stmt[] = "update b set b.labid2 = 110 " . $frm2 . $where . " v.labid = 110";
  $stmt[] = "update b set b.labid3 = 104 " . $frm2 . $where . " v.labid = 104";
  $stmt[] = "update b set b.labid4 = 105 " . $frm2 . $where . " v.labid = 105";
  runQueries($stmt);

  //update bloodeval2
  dbBeginTransaction();
  dbQuery("truncate table bloodeval2");
  dbLockTables(array('#bloodeval2Temp', 'bloodeval2'));
  dbQuery("
insert into bloodeval2 (patientid, visitdate, seqNum, labid1, labid2, labid3, labid4)
select patientid, visitdate, seqNum, labid1, labid2, labid3, labid4
from #bloodeval2Temp;");
  dbCommit();
  dbUnlockTables();

  //clean up
  dbQuery("drop table #bloodeval1Temp;");
  dbQuery("drop table #bloodeval2Temp;");
}

function chkVisitDate($visitDate) {
	$result = dbQuery("Select cast('" . $visitDate . "' as date) is not null");

	if($row = psRowFetch ($result)) {
		return $row[0];
	} else {
		return '0';
	}
}

function cohortAnalysis() {
	$stmt = array();
	//dbBeginTransaction();
	$stmt[0] = "delete from normalTable";

	/* started on ART */
	$stmt[1] = "insert into normalTable select c.sitecode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6)), 1,count(distinct p.patientid) from cohortTable c, pepfarTable p where c.patientid = p.patientid AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6))";

	/* transfers in/out */
	$stmt[2] = "update vitals set firstcarethisfac = 1, firstcareotherfac = null where (firstcarethisfac = 0 and firstcareotherfac = 0) or (firstcarethisfac is null and firstcareotherfac is null)";

	$stmt[3] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,e.visitdate,112),6)), 2,count(distinct v.patientid) from vitals v, encValid e, cohortTable c where c.patientid = e.patientid and v.patientid = e.patientid and v.visitdatemm = e.visitdatemm and v.visitdatedd = e.visitdatedd and v.visitdateyy = e.visitdateyy and v.seqnum = e.seqnum and v.sitecode = e.sitecode and v.firstcareotherfac = 1 group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,e.visitdate,112),6))";

	$stmt[4] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,e.visitdate,112),6)), 3,count(distinct c.patientid) from discEnrollment d, encValid e, cohortTable c where c.patientid = d.patientid and d.patientid = e.patientid and d.visitdatemm = e.visitdatemm and d.visitdatedd = e.visitdatedd and d.visitdateyy = e.visitdateyy and d.seqnum = e.seqnum and d.sitecode = e.sitecode and d.reasonDiscTransfer = 1 group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,e.visitdate,112),6))";

	/* Net current cohort (sum of 1,2,3) */
	/* original 1st line */
	$stmt[5] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6)), 5, count(distinct p.patientid) from cohortTable c, pepfarTable p, regimen r where c.patientid = p.patientid and r.shortname = p.regimen and r.regGroup like '1st%' AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6))";

	/* alternate regimens 1st line */
	$stmt[6] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6)), 6, sum(0) from cohortTable c, pepfarTable p, regimen r where c.patientid = p.patientid and r.shortname = p.regimen and r.regGroup like '1st%' AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6))";

	/* regimens 2nd line */
	$stmt[7] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6)), 7,count(distinct p.patientid) from cohortTable c, pepfarTable p, regimen r where c.patientid = p.patientid and r.shortname = p.regimen and r.regGroup like '2nd%' AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6))";

	/* stopped */
	$stmt[8] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,e.visitdate,112),6)), 8,count(distinct e.patientid) from discEnrollment d, encValid e, cohortTable c where c.patientid = d.patientid and d.patientid = e.patientid and d.visitdatemm = e.visitdatemm and d.visitdatedd = e.visitdatedd and d.visitdateyy = e.visitdateyy and d.seqnum = e.seqnum and d.sitecode = e.sitecode and d.partStop = 2 group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,e.visitdate,112),6))";

	/* died */
	$stmt[9] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,c.firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,p.visitdate,112),6)), 9,count(distinct d.patientid) from discEnrollment d, pepfarTable p, cohortTable c where p.patientid = d.patientid and c.patientid = d.patientid and d.reasonDiscDeath = 1 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6))";

	/* Lost */
	$stmt[10] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6)), 10,count(distinct d.patientid) from discEnrollment d, pepfarTable p, cohortTable c where p.patientid = d.patientid and c.patientid = d.patientid and d.reasonDiscNoFollowup = 1 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,visitdate,112),6))";

  runQueries($stmt);
	/* average cd4 load cd4 values into table */
	/* calculate the average for each cohort/visit combination */
	genCD4table();

	$stmt[11] = "insert into normalTable select c.siteCode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,p.visitdate,112),6)), 12,avg(cd4) from cohortTable c, pepfarTable p, cd4Table t where c.patientid = p.patientid and p.patientid = t.patientid and p.visitDate = t.visitDate AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.siteCode,  convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,p.visitdate,112),6))";

	/* functional status */
	$stmt[12] = "delete from validVitals";

	$stmt[13] = "insert into validVitals (sitecode, patientid, visitdatemm,visitdatedd,visitdateyy, seqnum) select sitecode, patientid, visitdatemm,visitdatedd,visitdateyy,seqnum from vitals where cast(dbo.ymdToDate(visitdateyy, visitdatemm, visitdatedd) as date) is not null";

	$stmt[14] = "delete fcPatients";

	$stmt[15] = "insert into fcPatients select distinct c.sitecode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,p.visitdate,112),6)), p.patientid, max(functionalstatus) from cohortTable c, pepfarTable p, validVitals v where c.patientid = p.patientid and p.patientid = v.patientid and left(CONVERT(VARCHAR,p.visitdate,112),6) = '20' + v.visitdateyy + v.visitdatemm and convert(bigint,left(CONVERT(VARCHAR,p.visitDate,112),6)) >= 200502 and convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)) >= 200502 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) group by c.sitecode, convert(bigint,left(CONVERT(VARCHAR,firstvisit,112),6)), convert(bigint,left(CONVERT(VARCHAR,p.visitdate,112),6)), p.patientid order by 1,2,3";

	$stmt[16] = "insert into normalTable select sitecode, firstvisit, visitdate, 14, count(distinct patientid) from fcPatients group by sitecode, firstvisit, visitdate having max(functionalStatus) = 1";

	$stmt[17] = "insert into normalTable select sitecode, firstvisit, visitdate, 15, count(distinct patientid) from fcPatients group by sitecode, firstvisit, visitdate having max(functionalStatus) = 2";

	$stmt[18] = "insert into normalTable select sitecode, firstvisit, visitdate, 16, count(distinct patientid) from fcPatients group by sitecode, firstvisit, visitdate having max(functionalStatus) = 4";

	$stmt[19] = "insert into normalTable select sitecode, firstvisit, visitdate, 17, count(distinct patientid) from fcPatients where functionalStatus in (1,2,4) group by sitecode, firstvisit, visitdate";
	/* delete rows that do not correspond to initial, 6-month, 12-month, 24-month visitdates  */
	$stmt[20] = "delete from normaltable where datediff(m,convert(datetime,convert(varchar,cohortdate)+'01'), convert(datetime,convert(varchar,visitdate)+'01')) not in (0,6,12,24)";
	runQueries($stmt, 11);
	//print_r(psRowFetchNum(dbQuery("select * from normaltable")));
	////dbCommit();
}


function genCD4table() {
  // make sure we screen all bad visit dates out of the encValid view
  database()->exec('
update encounter
set badVisitDate =
 case when isDate(ymdToDate(visitDateYy, visitDateMm, visitDateDd)) = 1 then 0
 else 1 end');
 
  database()->exec('
create temporary table cd4TableTemp
(sitecode mediumint unsigned,
 patientID varchar(11),
 visitdate datetime null,
 cd4 int unsigned,
 encounterType tinyint,
 encounter_id int unsigned,
 formVersion tinyint);');

  $replacePrefix = 'replace(replace(replace(replace(replace(';
  $replaceSuffix = ',?,?),?,?),?,?),?,?),?,?)';
  $replaceParams = array('+','', '-','', ',','', '<','', '*','');
	  
  database()->query('
insert into cd4TableTemp 
select straight_join siteCode, patientID, 
case
 when isdate(ymdToDate(lowestcd4cntyy, lowestcd4cntmm, lowestcd4cntdd)) = 1
 then ymdToDate(lowestcd4cntyy, lowestcd4cntmm, lowestcd4cntdd)
 else ymdToDate(lowestcd4cntyy, lowestcd4cntmm, 15) 
end, 
' . $replacePrefix . 'lowestcd4cnt' . $replaceSuffix . ',
encounterType, encounter_id, formVersion 
from vitals join encValid using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
where lowestCd4Cnt is not null
 and lowestcd4cnt <> ?
 and isnumeric(' . $replacePrefix . 'lowestcd4cnt' . $replaceSuffix . ') = 1
 and (isdate(ymdToDate(lowestcd4cntyy, lowestcd4cntmm, lowestcd4cntdd)) = 1 
      or isdate(ymdToDate(lowestcd4cntyy, lowestcd4cntmm, 15)) = 1);',
		    array_merge($replaceParams, array(''), $replaceParams));
		  
  database()->query('
insert into cd4TableTemp 
select straight_join siteCode, patientID, 
case
 when isdate(ymdToDate(CD4DateYY, CD4DateMM, CD4DateDD)) = 1
 then ymdToDate(CD4DateYY, CD4DateMM, CD4DateDD)
 else ymdToDate(CD4DateYY, CD4DateMM, 15) 
end, 
' . $replacePrefix . 'cd4' . $replaceSuffix . ',
encounterType, encounter_id, formVersion 
from medicalEligARVs join encValid using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
where Cd4 is not null
 and Cd4 <> ?
 and isnumeric(' . $replacePrefix . 'cd4' . $replaceSuffix . ') = 1
 and (isdate(ymdToDate(CD4DateYY, CD4DateMM, CD4DateDD)) = 1
      or isdate(ymdToDate(CD4DateYY, CD4DateMM, 15)) = 1);', array_merge($replaceParams, array(''), $replaceParams));

  database()->query('
insert into cd4TableTemp
select straight_join distinct t.siteCode, t.patientID,
  case
   when isdate(ymdToDate(t.resultDateYy, t.resultDateMm, t.resultDateDd)) = 1
   then ymdToDate(t.resultDateYy, t.resultDateMm, t.resultDateDd)
   else e.visitDate
  end as visitDate,
 ' . $replacePrefix . 't.result' . $replaceSuffix . ',
 e.encounterType, e.encounter_id, e.formVersion
 from labs t
  join encValid e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 where isnumeric(' . $replacePrefix . 't.result' . $replaceSuffix . ') = 1
  and t.labid in (102,176,1212,1214,1561)', array_merge($replaceParams, $replaceParams));
        
  database()->query('
insert into cd4TableTemp 
select straight_join siteCode, patientID, visitDate,
' . $replacePrefix . 'value_text' . $replaceSuffix . ',
encounterType, obs.encounter_id, formVersion 
from concept
join obs using (concept_id)
join encValid on obs.encounter_id = encValid.encounter_id and obs.location_id = encValid.siteCode
where concept.short_name = ?
 and value_text is not null
 and isnumeric(' . $replacePrefix . 'value_text' . $replaceSuffix . ') = 1;', array_merge($replaceParams, array('evalplanCD4Count'), $replaceParams));

  database()->exec('truncate table cd4Table;');
  database()->exec('lock tables cd4Table write;');
  database()->exec('delete from cd4Table;');
  database()->exec('
insert into cd4Table
select distinct siteCode, patientID, visitdate, cd4, encounter_id, encounterType, formVersion
from cd4TableTemp;
');
  database()->exec('unlock tables;');

  database()->exec('drop temporary table cd4TableTemp;');
}


function genDiscDates() {
  global $idColumnType, $siteCodeColumnType;

  /* Discontinuation Types (added to schema in version 6.0 RC1): */
  /*  1 = toxicity/side-effects (removed in version 6.0 RC6) */
  /*  2 = pregnancy (removed in version 6.0 RC6) */
  /*  3 = treatment failure (removed in version 6.0 RC6) */
  /*  4 = poor adherence */
  /*  5 = patient hospitalized (removed in version 6.0 RC6) */
  /*  6 = lack of ARV availability */
  /*  7 = failure to pay (removed in version 6.0 RC6) */
  /*  8 = patient preference */
  /*  9 = other */
  /* 10 = loss to followup */
  /* 11 = transferred */
  /* 12 = deceased */
  /* 13 = discontinuation - no reason checked (removed in version 7.0 RC1) */
  /* 14 = unknown */
  /* 15 = patient moved (added in version 7.0 RC2) */
  /* 16 = seroreversion [pediatric form] (added in version 7.0 RC2) */

  $stmt = array();

  $stmt[] = "
create table #tempDiscTable 
(discEnrollment_id $idColumnType null,
 sitecode $siteCodeColumnType not null,
 patientid varchar(11) not null,
 visitDate varchar(10) null,
 discDate varchar(10) not null,
 discType int not null)";

  /* loss of contact */
  $stmt[] = "
insert into #tempDiscTable 
select discEnrollment_id, sitecode, patientid, visitdate,
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     when isdate(dbo.ymdToDate(lastContactYy, lastContactMm, isnull(lastContactDd, '01'))) = 1 then dbo.ymdToDate(lastContactYy, lastContactMm, isnull(lastContactDd, '01'))
     else visitdate
end, 10 
from v_discEnrollment 
where encounterType in (12, 21)
 and reasonDiscNoFollowup = 1";

  /* transferred */
  $stmt[] = "
insert into #tempDiscTable 
select discenrollment_id, sitecode, patientid, visitDate,
case when isdate(dbo.ymdToDate(transferDateYy, transferDateMm, isnull(transferDateDd, '01'))) = 1 then dbo.ymdToDate(transferDateYy, transferDateMm, isnull(transferDateDd, '01'))
     when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 11 
from v_discEnrollment 
where encounterType in (12, 21)
 and (transferClinics = 1 or reasonDiscTransfer = 1)";

  /* death */
  $stmt[] = "
insert into #tempDiscTable 
select discenrollment_id, sitecode, patientid, visitDate,
case when isdate(dbo.ymdToDate(reasonDiscDeathYy, reasonDiscDeathMm, isnull(reasonDiscDeathDd, '01'))) = 1 then dbo.ymdToDate(reasonDiscDeathYy, reasonDiscDeathMm, isnull(reasonDiscDeathDd, '01'))
     when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 12 
from v_discEnrollment 
where encountertype in (12, 21)
 and reasonDiscDeath = 1";

  /* discontinuation -- Poor Adherence */
  $stmt[] = "
insert into #tempDiscTable
select discEnrollment_id, sitecode, patientid, visitDate, 
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 4 
from v_discEnrollment 
where encountertype in (12, 21)
 and poorAdherence = 1";
	
  /* discontinuation -- noARVs */
  $stmt[] = "
insert into #tempDiscTable
select discEnrollment_id, sitecode, patientid, visitDate, 
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 6
from v_discEnrollment
where encountertype in (12, 21)
 and noARVs = 1";

  /* discontinuation -- Patient Preference */
  $stmt[] = "
insert into #tempDiscTable
select discEnrollment_id, sitecode, patientid, visitDate, 
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 8
from v_discEnrollment
where encountertype in (12, 21)
 and patientPreference = 1";

  /* discontinuation -- Patient Moved */
  $stmt[] = "
insert into #tempDiscTable
select discEnrollment_id, sitecode, patientid, visitDate, 
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 15
from v_discEnrollment
where encountertype in (12, 21)
 and patientMoved = 1";

  /* discontinuation -- Seroreversion */
  $stmt[] = "
insert into #tempDiscTable
select discEnrollment_id, sitecode, patientid, visitDate, 
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 16
from v_discEnrollment
where encountertype in (12, 21)
 and seroreversion = 1";

  /* discontinuation -- discReasonOther */
  $stmt[] = "
insert into #tempDiscTable
select discEnrollment_id, sitecode, patientid, visitDate,
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 9
from v_discEnrollment
where encountertype in (12, 21)
 and (discReasonOther = 1 or (reasonDiscOther = 1 and poorAdherence != 1 and noARVs != 1 and patientPreference != 1 and patientMoved != 1 and seroreversion != 1))";

  /* unknown  reason */
  $stmt[] = "
insert into #tempDiscTable 
select discEnrollment_id, sitecode, patientid, visitDate,
case when isdate(dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))) = 1 then dbo.ymdToDate(disEnrollYy, disEnrollMm, isnull(disEnrollDd, '01'))
     else visitdate
end, 14 
from v_discEnrollment 
where encountertype in (12, 21)
 and reasonUnknownClosing = 1";
	
  $stmt[] = "create index tdiscTableIndex on #tempDiscTable (patientid)";

  runQueries($stmt);

  // no need to explicitly remove deleted forms because all queries above were against v_discEnrollment which already weeds out deleted encounters
  /* get rid of deleted forms
  dbBeginTransaction();
  dbLockTables(array('#tempDiscTable', 'encounter as e1', 'encounter as e2'));
  dbQuery("
delete from #tempDiscTable 
where patientid in (
 select patientid
 from encounter as e1
 where encountertype in (12,21)
  and encStatus = 255
)
and patientid not in (
 select patientid
 from encounter as e2
 where encountertype in (12,21)
 and encStatus < 255
)");
  dbCommit();
  dbUnlockTables();
*/

  //update discTable
  dbBeginTransaction();
  dbQuery("truncate table discTable");
  dbLockTables(array('#tempDiscTable', 'discTable'));
  // insert minimum records in discTable 
  dbQuery("
insert into discTable (sitecode, patientid, discDate) 
select sitecode, patientid, min(discDate) 
from #tempDiscTable 
group by sitecode, patientid");
  // update reason 
  dbQuery("
update discTable 
set discTable.discType = #tempDiscTable.discType 
from discTable, #tempDiscTable 
where discTable.patientid = #tempDiscTable.patientid
 and discTable.discDate = #tempDiscTable.discDate");
  dbCommit();
  dbUnlockTables();


  //clean up
  dbQuery("drop table #tempDiscTable");

  /* also reset stid in patient for sorting in the registry -- this gets that proc into the 10 minute job without changing it */
	//resetStID();

	//print_r(psRowFetchNum(dbQuery("select * from discTable")));
}

//related to upgrade
//function MSforeachview($command1,$replacechar = '?', $command2, $command3, $whereand, $precommand, $postcommand)
//{
//	$stmt = array();
//	//dbBeginTransaction();
//	$stmt[0] = "truncate table discTable";
//	dbQuery ($stmt[0]) or dbRollback();
/* This proc returns one or more rows for each view (optionally, matching @where), with each table defaulting to its own result set */
/* @precommand and @postcommand may be used to force a single result set via a temp table. */
/* Preprocessor will not replace within quotes so have to use str(). */
//	$stmt[1] = "select ltrim(str(convert(int, 0x0002)))";

	//	$result = dbQuery ($stmt[1]) or dbRollback();
	//	while ($row = psRowFetch ($result)) {
	//			 $mscat = $row[0];

	//	}
	//	if ($precommand != null)
	//	dbQuery($precommand)


	//	//$result = dbQuery("select '[' + REPLACE(user_name(uid), ']', ']]') + ']'+ '.' + '[' + REPLACE(object_name(id), ']', ']]') + ']' from sysobjects o  where OBJECTPROPERTY(o.id, 'IsView') = 1  and o.category & " . $mscat . " = 0 ");

	//	$retval = dbErrorString();


	//	/* related to upgrade
	//	if ($retval == "0")
	//		$retval = MSforeach_worker($command1, $replacechar, $command2, $command3);
	//	*/

	//	if ($retval == "0" && $postcommand == null)
	//	  dbQuery($postcommand);
	//	//dbCommit();
	//	return $retval;

	//}

function resetStID() {
	$stmt = array();
	//dbBeginTransaction();

	$stmt[0] = "create table #patSTtemp (patientid varchar(11), stid varchar(255))";

	$stmt[1] = "insert into #patSTtemp select p.patientid, e.clinicpatientid from patient p, encounter e where p.patientid = e.patientid and encountertype in (10,15)";

	$stmt[2] = "update #patSTtemp set stid = substring(stid, charindex('0',stid)+1,1000) where len(stid) > charindex('0',stid)";

	$stmt[3] = "update #patSTtemp set stid = replace(stid,'S','')";

	$stmt[4] = "update #patSTtemp set stid = replace(stid,'T','')";

	$stmt[5] = "update #patSTtemp set stid = replace(stid,'s','')";

	$stmt[6] = "update #patSTtemp set stid = replace(stid,'t','')";

	$stmt[7] = "update #patSTtemp set stid = replace(stid,'-','')";

	$stmt[8] = "update #patSTtemp set stid = replace(stid,'o','')";

	$stmt[9] = "update #patSTtemp set stid = replace(stid,'O','')";

	$stmt[10] = "update #patSTtemp set stid = replace(stid,'.','')";

	$stmt[11] = "update patient set patient.stid = case when isnumeric(#patSTtemp.stid) = 1 then convert(float, #patSTtemp.stid) else 0 end from patient, #patSTtemp where #patSTtemp.patientid =  patient.patientid";

	runQueries($stmt);
	//or dbRollback();

	//print_r(Psrowfetchnum(dbQuery("select * from #patSTtemp")));

	//dbCommit();

}


#mode = 1 -> update patient.patientStatus
#mode = 2 -> update patientStatusTemp where endDate = '$endDate and return getPatientStatusTemp($endDate)
function updatePatientStatus($mode = 1, $endDate = null) {
  $encTypeList = '1,2,3,4,5,6,7,10,14,15,16,17,18,19,20,24,25,26,27,28,29,31';

  if (is_null($endDate) || strtotime($endDate) > strtotime(date('Y-m-d'))) {
    $endDate = date('Y-m-d');
  }

  #hold the new patient status information that will be used to update the patient or patientStatusTemp tables
  database()->exec('create temporary table tpatient (patientid varchar(11), patientStatus int unsigned, primary key (patientid))');

  #compute some lists of patients that will be used multiple times later on
  database()->query('DROP TABLE IF EXISTS patientDispenses');
  database()->query('CREATE TABLE patientDispenses (keycol INT UNSIGNED NOT NULL AUTO_INCREMENT, patientid varchar(11) not null, dispd date not null, nxt_dispd date null, 
		PRIMARY KEY (keycol,patientid), UNIQUE INDEX iDisp (patientid,dispd))');
  database()->query('INSERT INTO patientDispenses (patientid, dispd) SELECT DISTINCT e.patientid, 
		CASE WHEN ymdtodate(dispdateyy,dispdatemm,dispdatedd) IS NOT NULL THEN ymdtodate(dispdateyy,dispdatemm,dispdatedd) 
		ELSE ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) end as dispd
		FROM prescriptions p, encounter e WHERE e.encountertype in (5,18) AND encStatus < 255 AND 
		p.patientid = e.patientid AND p.sitecode = e.sitecode AND p.visitdateyy = e.visitdateyy AND p.visitdatemm = e.visitdatemm AND p.visitdatedd = e.visitdatedd AND p.seqNum = e.seqNum AND 
		drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88) AND 
		(dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdtodate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND 
		(forPepPmtct = 2 OR forPepPmtct IS NULL) AND CASE WHEN ymdtodate(dispdateyy,dispdatemm,dispdatedd) IS NOT NULL THEN ymdtodate(dispdateyy,dispdatemm,dispdatedd) ELSE
		ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) end <= ? ORDER BY 1,2 DESC', array($endDate));
  # add nxt_disp
  database()->query('UPDATE patientDispenses t, prescriptions p, encounter e 
		SET t.nxt_dispd = CASE WHEN ymdtodate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd) IS NOT NULL THEN ymdtodate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd) ELSE NULL END
		WHERE t.patientid = e.patientid AND e.encountertype in (5,18) AND e.encStatus < 255 AND 
		p.patientid = e.patientid AND p.sitecode = e.sitecode AND p.visitdateyy = e.visitdateyy AND p.visitdatemm = e.visitdatemm AND p.visitdatedd = e.visitdatedd AND p.seqNum = e.seqNum AND 
		drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88) AND 
		(dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdtodate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND 
		(forPepPmtct = 2 OR forPepPmtct IS NULL) AND
		t.dispd = CASE WHEN ymdtodate(p.dispdateyy,p.dispdatemm,p.dispdatedd) IS NOT NULL THEN ymdtodate(p.dispdateyy,p.dispdatemm,p.dispdatedd) ELSE
		ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) end');
  # adjust nxt_disp when null and patient has multiple dispense in the past 
  database()->query('DROP TABLE IF EXISTS lastDispense');
  database()->query('CREATE TABLE lastDispense SELECT patientid, MIN(keycol) as rank, count(*) as cnt FROM patientDispenses GROUP BY 1; ALTER TABLE lastDispense ADD PRIMARY KEY (patientid)');
  database()->query('CREATE TEMPORARY TABLE patientsInPepfarTable select l.patientid, l.dispd,
		CASE WHEN l.nxt_dispd IS NOT NULL THEN l.nxt_dispd ELSE DATE_ADD(l.dispd, INTERVAL DATEDIFF(l.dispd, p.dispd) DAY) END AS nxt_dispd 
		FROM patientDispenses l, patientDispenses p, lastDispense a
		WHERE l.patientid = p.patientid AND l.patientid = a.patientid AND p.keycol = a.rank + 1 and DATEDIFF(l.dispd, p.dispd) > 0; 
		ALTER TABLE patientsInPepfarTable ADD PRIMARY KEY (patientid)');
  # add patients with only one dispense   
  database()->query('insert into patientsInPepfarTable select l.patientid, l.dispd, DATE_ADD(l.dispd,INTERVAL 30 DAY) 
		FROM patientDispenses l, lastDispense a where l.patientid = a.patientid and a.cnt = 1'); 

  database()->query('create temporary table patientsNotInPepfarTable select distinct p.patientid from patient p
		left join patientsInPepfarTable on patientsInPepfarTable.patientid = p.patientid
		join encounter e on e.patientid = p.patientid
		where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1 and patientsInPepfarTable.patientid is null and 
		ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ?;', array($endDate));
  database()->exec('alter table patientsNotInPepfarTable add primary key (patientid)');

  database()->query('create temporary table patientsInDiscTable select distinct patientid from discTable where discDate <= ?;', array($endDate));
  database()->exec('alter table patientsInDiscTable add primary key (patientid)');

  database()->query('create temporary table patientsNotInDiscTable select distinct p.patientid from patient p
		left join patientsInDiscTable on patientsInDiscTable.patientid = p.patientid
		join encounter e on e.patientid = p.patientid
		where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1 and patientsInDiscTable.patientid is null and 
		ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ?', array($endDate));
  database()->exec('alter table patientsNotInDiscTable add primary key (patientid);');

/* PATIENTS ON ART */

  # discontinued = 1
  database()->exec(' insert into tpatient select distinct patientid, 1 from patient p join patientsInPepfarTable using (patientid) join patientsInDiscTable using (patientid)');

  # active = 6
  database()->query(' insert into tpatient select straight_join e.patientid, 6 from patientsInPepfarTable
		join patientsNotInDiscTable using (patientid)
		join patient p using (patientid)
		join encounter e using (patientid)
		where (encountertype in (' . $encTypeList . ') and e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1 and 
		ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ?) OR
		? < patientsInPepfarTable.nxt_dispd 
		group by e.patientid having datediff(?, max(ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd))) <= 90;', array($endDate, $endDate, $endDate));

  # inactive = 8
  database()->query('create temporary table pStatus8 select patientid from patientsInPepfarTable
		join patient p using (patientid)
		join encounter e using (patientid)
		where encountertype in (' . $encTypeList . ') and patientid not in (
		select patientid from tpatient) and 
		e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1 and ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ? 
		group by patientid having datediff(?, max(ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd))) > 90', array($endDate, $endDate));
  database()->exec('insert into tpatient select patientid, 8 from pStatus8;');
  database()->exec('drop temporary table pStatus8;');
  
/* PRE-ART PATIENTS */

  # discontinued = 9
  database()->exec(' insert into tpatient select distinct patientid, 9 from patientsNotInPepfarTable join patientsInDiscTable using (patientid);');

  # active = 7
  database()->query(' insert into tpatient select straight_join distinct patientid, 7 from patientsNotInDiscTable
		join patientsNotInPepfarTable using (patientid)
		join patient p using (patientid)
		join encounter e using (patientid)
		where encountertype in (' . $encTypeList . ') and e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1 and 
		ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ?
		group by patientid having datediff(?, max(ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd))) <= 180;', array($endDate, $endDate));

  # inactive = 10
  database()->query(' insert into tpatient select straight_join distinct patientid, 10 from patientsNotInDiscTable
		join patientsNotInPepfarTable using (patientid)
		join patient p using (patientid)
		join encounter e using (patientid)
		where encounterType in (' . $encTypeList . ') and e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1 and 
		ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ?
		group by patientid having datediff(?, max(ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd))) > 180;', array($endDate, $endDate));

  //clean up
  database()->exec('drop temporary table patientsInPepfarTable;');
  database()->exec('drop temporary table patientsNotInPepfarTable;');
  database()->exec('drop temporary table patientsInDiscTable;');
  database()->exec('drop temporary table patientsNotInDiscTable;');

  if ($mode == 2) {
    database()->exec('lock tables patientStatusTemp write;');
    database()->query('delete from patientStatusTemp where endDate = ?', array($endDate));
    database()->query('insert into patientStatusTemp (patientID, patientStatus, endDate, insertDate) select patientID, patientStatus, ?, now() from tpatient;', array($endDate));
    database()->exec('unlock tables');
    database()->exec('drop temporary table tpatient');
    return getPatientStatusTemp($endDate);
  } else {
    database()->exec('lock tables patient p write');
    database()->exec('update patient p left join tpatient t using (patientid) set p.patientStatus = t.patientStatus'); 
	database()->exec('unlock tables;'); 
	database()->exec('drop temporary table tpatient');
  }
}

function updateAges() {
  //two digit years greater then this are considered from the 1900s
  $y2kCutOff = 9;

  $stmt = array();

  //fix non-numeric or two digit dobYy values
  $stmt[] = "
/* attempt to fix non-numeric or two digit dobYy values (see where clause) */
update patient 
set dobYy = 
 case
  /* fix all two digit dobYy values */
  when isnumeric(dobYy) = 1
       and dobYy between 0 and 99
  then case
        when dobYy between 0 and " . $y2kCutOff . "
        then convert(char(4), 2000 + dobYy)
        else convert(char(4), 1900 + dobYy)
       end
  /* try and get dobYy from nationalid */
  when isnumeric(substring(nationalid, 5, 2)) = 1
       and substring(nationalid, 5, 2) between 0 and 99
  then case
        when substring(nationalid, 5, 2) between 0 and " . $y2kCutOff . "
        then convert(char(4), 2000 + substring(nationalid, 5, 2))
        else convert(char(4), 1900 + substring(nationalid, 5, 2))
       end
  /* (not numeric or less than 0) and can't get it from nationalid */
  else 'XXXX'
 end
where isnumeric(dobYy) <> 1
 or dobYy <= 99";

  //fix non-numeric or two digit dobMm values
  $stmt[] = "
update patient set dobMm = substring(nationalid,3,2) 
where isnumeric(dobMm) <> 1
 and isnumeric(substring(nationalid,3,2)) = 1
 and convert(bigint,substring(nationalid,3,2)) between 1 and 12";

  foreach ($stmt as $query) {
    dbBeginTransaction();
    dbLockTables(array('patient'));
    dbQuery($query);
    dbCommit();
    dbUnlockTables();
  }
  
  //finally if dobYy doesn't exist then try and compute it with ageYears and registration visit date.
  dbBeginTransaction();
  dbLockTables(array('patient as p', 'encValid as e'));
  dbQuery("
update p 
set p.dobYy = year(dateadd(yy, -convert(int, p.ageYears), e.visitDate)),
 dobMm = month(dateadd(yy, -convert(int, p.ageYears), e.visitDate)),
 dobDd = day(dateadd(yy, -convert(int, p.ageYears), e.visitDate))
from patient p, encValid e
where p.patientid = e.patientid
 and encounterType in (10, 15)
 and (p.dobYy is null or isnumeric(p.dobYy) <> 1)
 and ageYears is not null
 and isnumeric(ageYears) = 1
 and charindex('.', ageYears) < 1
 and ageYears < 1000");
  dbCommit();
  dbUnlockTables();
}


#If $patientId is provided then only update drugTableAll for the one patient otherwise update for all patients.
function updateDrugTableAll($patientId = null) {
  database()->exec('
create temporary table drugTableTemp
(sitecode mediumint unsigned null,
 patientid varchar(11) null,
 visitdate datetime null,
 drugID int unsigned null,
 forPepPmtct tinyint unsigned null);');

  $extraPatientIdWhere = '1=1';
  $extraPatientIdParam = array();
  if (isset($patientId)) {
    $extraPatientIdWhere = 't.patientID = ?';
    $extraPatientIdParam = array($patientId);
  }
  database()->query("
insert into drugTableTemp (sitecode, patientid, visitdate, drugID, forPepPmtct)
select straight_join sitecode, patientID, case
 when isdate(ymdToDate(dispDateYy, dispDateMm, dispDateDd)) = 1
  then ymdToDate(dispDateYy, dispDateMm, dispDateDd)
 when isdate(ymdToDate(dispDateYy, dispDateMm, 1)) = 1
  then ymdToDate(dispDateYy, dispDateMm, 1)
 else ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) end,
 l.drugID, forPepPmtct
from drugLookup l, prescriptions t
join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
join patient p using (patientid)
where e.encStatus < 255
 and p.patStatus = 0
 and badvisitdate = 0
 and t.drugID = l.drugID
 and
  case when l.drugGroup in (?, ?, ?)
  then (t.forPepPmtct IN (1, 2) OR t.dispensed = 1)
  else 1 = 1
  end
 and " . $extraPatientIdWhere . ";", array_merge (array ('NRTIs', 'NNRTIs', 'Pls'), $extraPatientIdParam));

  #lock/begin transaction and remove old records
  if (isset($patientId)) {
    database()->beginTransaction();
    database()->query('delete from drugTableAll where patientid = ?;', array($patientId));
  } else {
    database()->exec('truncate table drugTableAll;');
    database()->exec('lock tables drugTableAll write;');
    database()->exec('delete from drugTableAll;');
  }

  #add new records
  database()->exec('
insert into drugTableAll (sitecode, patientID, visitDate, drugID, forPepPmtct)
select sitecode, patientid, visitdate, drugID, forPepPmtct
from drugTableTemp;');

  #unlock/commit
  if (isset($patientId)) {
    database()->commit();
  } else {
    database()->exec('unlock tables;');
  }

  #cleanup
  database()->exec('drop temporary table drugTableTemp;');
}


function updatePepfarTable($patientId = null) {
  $extraPatientIdWhere = '1=1';
  $extraPatientIdParam = array();
  if (isset($patientId)) {
    $extraPatientIdWhere = 'patientID = ?';
    $extraPatientIdParam = array($patientId);
  }

  database()->exec('
create temporary table pepfarTableTemp
(siteCode mediumint unsigned null,
 patientid varchar(11) null,
 visitDate datetime null,
 regimen varchar(25),
 forPepPmtct tinyint null);');

  # Hold all one drug regimen prefixes. Used to find single drug regimens and speed up finding 2 drug regimen prefixes. 
  database()->exec('
create temporary table oneDrugRegimenPrefixTemp (
 sitecode mediumint(8) unsigned default NULL,
 patientid varchar(11) default NULL,
 visitdate datetime default NULL,
 drugID1 int(10) unsigned default NULL,
 forPepPmtct tinyint(3) unsigned default NULL
);
');

  database()->query('
insert into oneDrugRegimenPrefixTemp
select sitecode, patientID, visitDate, drugID,
 if(forPepPmtct = 1, 1, null)
from drugTableAll d1
join patient using (patientID)
join (select distinct drugID1 from regimen) r
 on r.drugID1 = d1.drugID
where hivPositive = 1
 and ' . $extraPatientIdWhere . ';', $extraPatientIdParam);

  /* put single drug regimens into pepfarTable */
  database()->exec('
insert into pepfarTableTemp (sitecode, patientid, visitDate, regimen, forPepPmtct)
select distinct siteCode, patientID, visitDate, shortname, forPepPmtct
from oneDrugRegimenPrefixTemp d1
join regimen r
 on r.drugID1 = d1.drugID1
where r.drugID2 = 0
 and r.drugID3 = 0;');

  /* Hold all two drug regimen prefixes. Used to find two drug regemens and speed up finding three drug regemins. */
  database()->exec('
create temporary table twoDrugRegimenPrefixTemp (
 sitecode mediumint(8) unsigned default NULL,
 patientid varchar(11) default NULL,
 visitdate datetime default NULL,
 drugID1 int(10) unsigned default NULL,
 drugID2 int(10) unsigned default NULL,
 forPepPmtct tinyint(3) unsigned default NULL
);
');

  database()->query('
insert into twoDrugRegimenPrefixTemp
select sitecode, patientID, visitDate, d1.drugID1, d2.drugID,
 if(d1.forPepPmtct = 1 or d2.forPepPmtct = 1, 1, null)
from oneDrugRegimenPrefixTemp d1
join drugTableAll d2 using (siteCode, patientID, visitdate)
join (select distinct drugID1, drugID2 from regimen) r
 on r.drugID1 = d1.drugID1
 and r.drugID2 = d2.drugID
 and ' . $extraPatientIdWhere . ';', $extraPatientIdParam);

  /* put 2 drug regimens into pepfarTable */
  database()->exec('
insert into pepfarTableTemp (sitecode, patientid, visitDate, regimen, forPepPmtct)
select distinct sitecode, patientID, visitDate, shortname, prefix.forPepPmtct
from twoDrugRegimenPrefixTemp prefix
join regimen r
 on prefix.drugID1 = r.drugID1
 and prefix.drugID2 = r.drugID2
where r.drugID3 = 0;');

  /* put 3 drug regimens into pepfarTable */
  database()->query('
insert into pepfarTableTemp (sitecode, patientid, visitDate, regimen, forPepPmtct)
select distinct sitecode, patientID, visitDate, shortname,
 if(prefix.forPepPmtct = 1 or drugTableAll.forPepPmtct = 1, 1, null)
from twoDrugRegimenPrefixTemp prefix
join drugTableAll using (siteCode, patientID, visitdate)
join regimen r
 on prefix.drugID1 = r.drugID1
 and prefix.drugID2 = r.drugID2
 and drugTableAll.drugID = r.drugID3
where r.drugID3 != 0
 and ' . $extraPatientIdWhere . ';', $extraPatientIdParam);

  #lock/begin transaction and remove old records
  if (isset($patientId)) {
    database()->beginTransaction();
    database()->query('delete from pepfarTable where patientid = ?;', array($patientId));
  } else {	 
    database()->exec('truncate table pepfarTable;');
    database()->exec('lock tables pepfarTable write;');
    database()->exec('delete from pepfarTable;');
  }

  #add new records
  database()->exec('
insert into pepfarTable (sitecode, patientid, visitDate, regimen, forPepPmtct)
select sitecode, patientid, visitDate, regimen, forPepPmtct from pepfarTableTemp;');
  #when sitecode, patientid, visitDate, regimen are all equal but forPepPmtct differs keep only the record with forPepPmtct = 1
  database()->exec('
delete pepfarTable
from pepfarTable
join pepfarTableTemp p2 using (sitecode, patientid, visitDate, regimen)
where pepfarTable.forPepPmtct is null
 and p2.forPepPmtct = 1;');

  #unlock/commit
  if (isset($patientId)) {
    database()->commit();
  } else {
    database()->exec('unlock tables;');
  }

  #cleanup
  database()->exec('drop temporary table oneDrugRegimenPrefixTemp;');
  database()->exec('drop temporary table twoDrugRegimenPrefixTemp;');
  database()->exec('drop temporary table pepfarTableTemp;');
}


function whoInit() {
  //Generate new drugTableAll data  
  updateDrugTableAll();

  //Generate new drugSummaryAll data
  $reasons = array(
	'toxicity',
	'intolerance',
	'failureVir',
	'failureImm',
	'failureClin',
	'stockOut',
	'pregnancy',
	'patientHospitalized',
	'lackMoney',
	'alternativeTreatments',
	'missedVisit',
	'patientPreference',
	'prophDose',
	'failureProph',
	'interUnk',
	'finPTME');

  database()->exec('
create temporary table drugSummaryAllTemp (
 patientid varchar(11) default NULL,
 drugID int(10) unsigned default NULL,
 forPepPmtct tinyint(3) unsigned default NULL,
 startDate datetime default NULL,
 stopDate datetime default NULL,
 toxicity tinyint(3) unsigned default NULL,
 intolerance tinyint(3) unsigned default NULL,
 failureVir tinyint(3) unsigned default NULL,
 failureImm tinyint(3) unsigned default NULL,
 failureClin tinyint(3) unsigned default NULL,
 stockOut tinyint(3) unsigned default NULL,
 pregnancy tinyint(3) unsigned default NULL,
 patientHospitalized tinyint(3) unsigned default NULL,
 lackMoney tinyint(3) unsigned default NULL,
 alternativeTreatments tinyint(3) unsigned default NULL,
 missedVisit tinyint(3) unsigned default NULL,
 patientPreference tinyint(3) unsigned default NULL,
 prophDose tinyint(3) unsigned default NULL,
 failureProph tinyint(3) unsigned default NULL,
 interUnk tinyint(3) unsigned default NULL,
 finPTME tinyint(3) unsigned default NULL,
 PRIMARY KEY (patientid, drugID))');

  /* set original start dates in the drugSummaryAllTemp table */
  database()->exec('
insert into drugSummaryAllTemp (patientID, drugID, startdate) 
select patientID, drugID, min(visitdate) 
from drugTableAll group by patientID, drugID');

  /** set stop dates and reasons for stop in the drugSummaryAllTemp table
   ** generate stop dates based on stopYy+stopMm or visitDate
   ***/
  database()->exec('
update drugSummaryAllTemp a, a_drugs b set a.stopDate = case when isdate(ymdtodate(b.stopYy,b.stopMm,1))= 1 then last_day(ymdtodate(b.stopYy,b.stopMm,1)) else last_day(ymdtodate(b.visitdateYy,b.visitdateMm,b.visitdateDd)) end, a.toxicity = b.toxicity, a.intolerance = b.intolerance, a.failureVir = b.failureVir, a.failureImm = b.failureImm, a.failureClin = b.failureClin, a.stockOut = b.stockOut, a.pregnancy = b.pregnancy, a.patientHospitalized = b.patientHospitalized, a.lackMoney = b.lackMoney, a.alternativeTreatments = b.alternativeTreatments, a.missedVisit = b.missedVisit, a.patientPreference = b.patientPreference, a.prophDose = b.prophDose, a.failureProph = b.failureProph, a.interUnk = b.interUnk, a.finPTME = b.finPTME where a.patientID = b.patientID and a.drugID = b.drugID and (isdate(ymdToDate(b.stopYy, b.stopMm, 1)) = 1 or b.isContinued != 1 or (b.toxicity = 1 or b.intolerance = 1 or b.failureVir = 1 or b.failureImm = 1 or b.failureClin = 1 or b.stockOut = 1 or b.pregnancy = 1 or b.patientHospitalized = 1 or b.lackMoney = 1 or b.alternativeTreatments = 1 or b.missedVisit = 1 or b.patientPreference = 1 or b.prophDose = 1 or b.failureProph = 1 or b.interUnk = 1 or b.finPTME = 1))');

  database()->exec('truncate table drugSummaryAll;');
  database()->exec('lock tables drugSummaryAll write;');
  database()->exec('delete from drugSummaryAll;');
  database()->exec('insert into drugSummaryAll select * from drugSummaryAllTemp;');
  database()->exec('unlock tables;');

  database()->exec('drop temporary table drugSummaryAllTemp;');


//Generate new pepfarTable data
// since pepfarTable is now maintained when the form is saved, we don't need to keep recomputing it--just recompute the whole thing when it is empty
// since consolidated database doesn't do form saves, always recompute pepfarTable when running it's 10 minute job
// always want to truncate pepfarTable and then run the 10 minute job on a db upgrade, just to make sure everything is in sync
  $row = database()->query('select count(*) as cnt from pepfarTable')->fetch();
  if ($row['cnt'] == 0 || SERVER_ROLE == 'consolidated') {
    updatePepfarTable();
  }


  //Generate new cohortTable data
  database()->exec('
create temporary table cohortTableTemp (
 siteCode mediumint(8) unsigned default NULL,
 patientid varchar(11) default NULL,
 firstVisit datetime default NULL,
 sex tinyint(3) unsigned default NULL,
 ageYears int(10) unsigned default NULL,
 pregnant tinyint(3) unsigned default NULL)');

  database()->exec('
insert into cohortTableTemp (siteCode, patientID, firstVisit) 
select siteCode, patientID, min(visitdate) 
from pepfarTable where (forPepPmtct = 0 OR forPepPmtct IS NULL)
group by siteCode, patientID;');

  database()->exec('
update cohortTableTemp, patient
set cohortTableTemp.sex = patient.sex,
 cohortTableTemp.ageYears = patient.ageYears
where patient.patientID = cohortTableTemp.patientID
 and isnumeric(patient.ageYears) = 1;');

  database()->exec('
update cohortTableTemp, vitals
set cohortTableTemp.pregnant = vitals.pregnant 
where cohortTableTemp.patientID = vitals.patientID
 and cohortTableTemp.sex = 1;');

  database()->exec('truncate table cohortTable;');
  database()->exec('lock tables cohortTable write;');
  database()->exec('delete from cohortTable;');
  database()->exec('insert into cohortTable select * from cohortTableTemp;');
  database()->exec('unlock tables;');

  database()->exec('drop temporary table cohortTableTemp;');
}


function printResult($qry) {
	$result = dbQuery($qry);
	while ($row = psRowFetchNum($result)) {
		print_r($row);
		echo "\n";
	}

}

function genEligibility($endDate = '') {
  if ($endDate == '') {
    $endDate = date('Y-m-d');
  }

  // Temporary table to hold new eligibility data.
  // This will be copied to the real eligibility table once all the work is done.
  // The purpose is to reduce the amount of time the eligibility table is locked for.
  database()->query('
create temporary table eligibilityTemp
(patientid varchar(11),
 reason varchar(30),
 visitDate datetime,
 encounter_id int unsigned,
 encountertype int,
 formVersion int,
 criteriaVersion int unsigned);');

  // This temporary table is used by several queries below to help speed things up on mysql.
  database()->query('
create temporary table genEligTemp
(patientid varchar(11), primary key (patientid));');
  database()->query('
insert into genEligTemp
select distinct patientid
from cd4Table
where cd4 != 0
 and visitdate <= ?
 and (
  (cd4 < 200 and visitdate < ?)
  or (cd4 < 350 and visitdate >= ?)
 )
', array($endDate, CD4_350_DATE, CD4_350_DATE));

  // Temporary table for helping to calculate TMS eligibility.
  database()->query('
create temporary table tmsEligTemp
(patientID varchar(11),
 ageAtReg int NULL,
 regDate datetime NULL,
 fourteenYearsOld datetime NULL,
 sixWeeksOld datetime NULL,
 oneYearOld datetime NULL,
 encounter_id int unsigned NULL,
 encounterType int NULL,
 formVersion int NULL)');
  database()->query('
insert into tmsEligTemp
select p.patientID,
 year(e.visitDate) - p.dobYy,
 e.visitDate,
 case when year(e.visitDate) - p.dobYy < 14
  then date_add(p.dobYy, INTERVAL 14 year)
  else NULL end,
 NULL,
 NULL,
 e.encounter_id,
 e.encounterType,
 e.formVersion
from encValid e join patient p using (patientID)
where isnumeric(p.dobYy) = 1
 and isnumeric(p.dobMm) != 1
 and e.encounterType in (10, 15)');

  database()->query('
insert into tmsEligTemp
select
 p.patientID,
 round(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, 1)) / 30.4368499) / 12,
 e.visitDate,
 case when round(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, 1)) / 30.4368499) / 12 < 14
  then date_add(ymdToDate(p.dobYy, p.dobMm, 1), INTERVAL 14 year)
  else NULL end,
 case when round(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, 1)) / 30.4368499) / 12 < 1
  then date_add(ymdToDate(p.dobYy, p.dobMm, 1), INTERVAL 42 day)
  else NULL end,
 case when round(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, 1)) / 30.4368499) / 12 < 1
  then date_add(ymdToDate(p.dobYy, p.dobMm, 1), INTERVAL 1 year)
  else NULL end,
 e.encounter_id,
 e.encounterType,
 e.formVersion
from encValid e join patient p using (patientID)
where isnumeric(p.dobYy) = 1
 and isnumeric(p.dobMm) = 1
 and isnumeric(p.dobDd) != 1
 and isdate(ymdToDate(p.dobYy, p.dobMm, 1)) = 1
 and e.encounterType in (10, 15)');

  database()->query('
insert into tmsEligTemp
select 
 p.patientID,
 floor(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, p.dobDd)) / 365.25),
 e.visitDate,
 case when floor(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, p.dobDd)) / 365.25) < 14
  then date_add(ymdToDate(p.dobYy, p.dobMm, p.dobDd), INTERVAL 14 year)
  else NULL end,
 case when floor(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, p.dobDd)) / 365.25) < 1
  then date_add(ymdToDate(p.dobYy, p.dobMm, p.dobDd), INTERVAL 42 day)
  else NULL end,
 case when floor(datediff(e.visitDate, ymdToDate(p.dobYy, p.dobMm, p.dobDd)) / 365.25) < 1
  then date_add(ymdToDate(p.dobYy, p.dobMm, p.dobDd), INTERVAL 1 year)
  else NULL end,
 e.encounter_id,
 e.encounterType,
 e.formVersion
from encValid e join patient p using (patientID)
where isnumeric(p.dobYy) = 1
 and isnumeric(p.dobMm) = 1
 and isnumeric(p.dobDd) = 1
 and isdate(ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1
 and e.encounterType in (10, 15)');

  // Temp table to hold birthdates (or best guesses)
  database()->exec('
create temporary table tempDob
(patientid varchar(11), dob date, primary key (patientid));');
  database()->query('
insert into tempDob
select patientID,
 case when isnumeric(dobYy) = 1 and isnumeric(dobMm) <> 1 and
  isdate(ymdToDate(dobYy, ?, ?)) = 1 then ymdToDate(dobYy, ?, ?)
  when isnumeric(dobYy) = 1 and isnumeric(dobMm) = 1 and
  isnumeric(dobDd) <> 1 and isdate(ymdToDate(dobYy, dobMm, ?)) = 1
  then ymdToDate(dobYy, dobMm, ?)
  when isnumeric(dobYy) = 1 and isnumeric(dobMm) = 1 and
  isnumeric(dobDd) = 1 and isdate(ymdToDate(dobYy, dobMm, dobDd)) = 1
  then ymdToDate(dobYy, dobMm, dobDd)
  else NULL end as dob
from patient
where patStatus = 0;', array('06', '15', '06', '15', '15', '15'));

  // This clause is re-used a bunch below
  $labResultDateCaseClause = 'case when isnumeric(t.resultDateYy) = 1 and
    isnumeric(t.resultDateMm) <> 1 and
    isdate(ymdToDate(t.resultDateYy, ?, ?)) = 1 then
    ymdToDate(t.resultDateYy, ?, ?)
    when isnumeric(t.resultDateYy) = 1 and isnumeric(t.resultDateMm) = 1 and
    isnumeric(t.resultDateDd) <> 1 and
    isdate(ymdToDate(t.resultDateYy, t.resultDateMm, ?)) = 1 then
    ymdToDate(t.resultDateYy, t.resultDateMm, ?)
    when isdate(ymdToDate(t.resultDateYy, t.resultDateMm, t.resultDateDd)) = 1 then
    ymdToDate(t.resultDateYy, t.resultDateMm, t.resultDateDd)
    else ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) end';

  // Temp table to hold PCR test results
  database()->exec('
create temporary table tempPcrResult
(patientid varchar(11), resultDate date, result tinyint unsigned, encounter_id int unsigned, encounterType tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  database()->query("
insert into tempPcrResult
select distinct t.patientID, " . $labResultDateCaseClause . ",
 case when t.result = 1 or t.result = ? then 1
  when t.result = 2 or t.result = ? then 2
  else NULL end,
  e.encounter_id, e.encounterType, e.formVersion
from labs t /* v_labsCompleted too slow */
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1
 and lower(t.testnamefr) in (?, ?)
 and t.result in (?, ?, ?, ?)
 and isdate(" . $labResultDateCaseClause . ") = 1
 and " . $labResultDateCaseClause . " <= ?;", array('06', '15', '06', '15', '15', '15', 'Detecte', 'Non Detecte', 'pcr', 'ADN VIH-1', '1', '2', 'Detecte', 'Non Detecte', '06', '15', '06', '15', '15', '15', '06', '15', '06', '15', '15', '15', $endDate));

  // Temp table to hold HIV statuses of ped. patients
  database()->exec('
create temporary table tempPedHivStatus
(patientid varchar(11), maxStatus tinyint unsigned, index pidIdx (patientid));');
  database()->query("
insert into tempPedHivStatus
SELECT e.patientID, MAX(v.pedCurrHiv)
FROM encValid e, vitals v
WHERE v.patientID = e.patientID
 AND v.siteCode = e.siteCode
 AND v.visitDateYy = e.visitDateYy
 AND v.visitDateMm = e.visitDateMm
 AND v.visitDateDd = e.visitDateDd
 AND v.seqNum = e.seqNum
 AND v.pedCurrHiv >= 1
 AND e.visitDate <= ?
group by 1;", array ($endDate));

  // Need a duplicate of above table for self-joining purposes
  database()->exec('
create temporary table tempPcrResult2
(patientid varchar(11), resultDate date, result tinyint unsigned, encounter_id int unsigned, encounterType tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  database()->exec("insert into tempPcrResult2 select * from tempPcrResult");

  // Temp table to hold WHO stages
  database()->exec('
create temporary table tempWhoStage
(patientid varchar(11), stageDate date, stage tinyint unsigned, encounter_id int unsigned, encountertype tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  // Conditions
  database()->query('
insert into tempWhoStage
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 case when whoStage = ? then 1
  when whoStage = ? then 2
  when whoStage = ? then 3
  when whoStage = ? then 4
  else NULL end,
  encounter_id, encountertype, formVersion
from v_conditions
where whoStage in (?, ?, ?, ?);', array('06', '15', '06', '15', '15', '15', 'Stage I', 'Stage II', 'Stage III', 'Stage IV', 'Stage I', 'Stage II', 'Stage III', 'Stage IV'));
  // Symptoms
  database()->query('
insert into tempWhoStage
select distinct e.patientID,
 e.visitDate,
 case when o.short_name in (?, ?) then 1
  when o.short_name in (?, ?, ?, ?) then 2
  when o.short_name in (?, ?, ?) then 3
  when o.short_name in (?, ?) then 4
  when e.encounterType in (1, 2) and o.short_name = ? then 3
  when e.encounterType in (16, 17) and o.short_name = ? then 2
  else NULL end,
  e.encounter_id, e.encounterType, e.formVersion
from encValid e, v_obs o
where e.encounter_id = o.encounter_id
 and substring(e.patientID, 6, length(e.patientID)) = o.person_id
 and e.sitecode = o.location_id
 and o.short_name in (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
 and visitdate <= ?;', array('asymptomaticWho', 'chronicWeakness', 'weightLossLessTenPercMo', 'feverLessMo', 'diarrheaLessMo', 'pedSympWhoDiarrhea', 'weightLossPlusTenPercMo', 'diarrheaPlusMo', 'pedSympWhoWtLoss2', 'wtLossTenPercWithDiarrMo', 'pedSympWhoWtLoss3', 'feverPlusMo', 'feverPlusMo', 'asymptomaticWho', 'chronicWeakness', 'weightLossLessTenPercMo', 'feverLessMo', 'diarrheaLessMo', 'pedSympWhoDiarrhea', 'weightLossPlusTenPercMo', 'diarrheaPlusMo', 'pedSympWhoWtLoss2', 'wtLossTenPercWithDiarrMo', 'pedSympWhoWtLoss3', 'feverPlusMo', $endDate));
  // Current HIV Stage radios
  database()->query('
insert into tempWhoStage
select straight_join t.patientid,
 ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd),
 case when e.encounterType in (1, 2) and e.formVersion = 0
  and t.currentHivStage = 1 then 1
  when e.encounterType in (1, 2) and e.formVersion = 0
  and t.currentHivStage in (2, 3) then 3
  when e.encounterType in (1, 2) and e.formVersion = 0
  and t.currentHivStage > 3 then 4
  when e.encounterType in (1, 2) and e.formVersion = 1
  and t.currentHivStage = 1 then 1
  when e.encounterType in (1, 2) and e.formVersion = 1
  and t.currentHivStage in (2, 3) then 2
  when e.encounterType in (1, 2) and e.formVersion = 1
  and t.currentHivStage in (4, 5, 6, 7) then 3
  when e.encounterType in (1, 2) and e.formVersion = 1
  and t.currentHivStage > 7 then 4
  when e.encounterType in (16, 17) and t.currentHivStage = 1 then 1
  when e.encounterType in (16, 17) and t.currentHivStage in (2, 3) then 2
  when e.encounterType in (16, 17) and t.currentHivStage in (4, 5, 6, 7) then 3
  when e.encounterType in (16, 17) and t.currentHivStage > 7 then 4
  else null end,
  e.encounter_id, e.encountertype, e.formVersion
from medicalEligARVs t /* v_medicalEligARVs is too slow */
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and e.badvisitdate = 0 and p.hivPositive = 1
and t.currentHivStage is not null
and t.currentHivStage between 1 and 15
and ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) <= ?;', array($endDate));

  // Temp table to hold active dates for certain conditions
  database()->exec('
create temporary table tempActiveCond
(patientid varchar(11), condDate date, condName varchar(64), encounter_id int unsigned, encounterType tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  // active TB
  database()->query("
insert into tempActiveCond
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 ?,
 encounter_id, encounterType, formVersion
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (20, 21, 41, 208, 397, 405, 409, 423)
 and conditionActive != 2
 and conditionActive is not null;", array('06', '15', '06', '15', '15', '15', 'tb'));
  database()->query("
insert into tempActiveCond
select straight_join distinct t.patientID,
 e.visitDate,
 ?,
 e.encounter_id, e.encounterType, e.formVersion
from tbStatus t
 join encounter e using (patientID, siteCode, visitDateDd, visitDateMm, visitDateYy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and e.badvisitdate = 0 and p.hivPositive = 1
 and e.encounterType in (1, 2, 16, 17)
 and t.currentTreat = 1;", array('tb'));
  // Hep B
  database()->query("
insert into tempActiveCond
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 ?,
 encounter_id, encounterType, formVersion
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (320)
 and conditionActive != 2
 and conditionActive is not null;", array('06', '15', '06', '15', '15', '15', 'hepb'));
  // HIV Nephropathy
  database()->query("
insert into tempActiveCond
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 ?,
 encounter_id, encounterType, formVersion
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (35, 341)
 and conditionActive != 2
 and conditionActive is not null;", array('06', '15', '06', '15', '15', '15', 'nephropathy'));
  // PIL
  database()->query("
insert into tempActiveCond
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 ?,
 encounter_id, encounterType, formVersion
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (18)
 and conditionActive != 2
 and conditionActive is not null;", array('06', '15', '06', '15', '15', '15', 'pil'));
  // Leucoplasie buccale velue
  database()->query("
insert into tempActiveCond
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 ?,
 encounter_id, encounterType, formVersion
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (15, 202)
 and conditionActive != 2
 and conditionActive is not null;", array('06', '15', '06', '15', '15', '15', 'hairyoral'));
  // Thrombocytopénie
  database()->query("
insert into tempActiveCond
select distinct patientID,
 case when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) <> 1 and
  isdate(ymdToDate(conditionYy, ?, ?)) = 1 then
  ymdToDate(conditionYy, ?, ?)
  when isnumeric(conditionYy) = 1 and isnumeric(conditionMm) = 1 and
  isdate(ymdToDate(conditionYy, conditionMm, ?)) = 1 then
  ymdToDate(conditionYy, conditionMm, ?)
  else visitDate end,
 ?,
 encounter_id, encounterType, formVersion
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (49)
 and conditionActive != 2
 and conditionActive is not null;", array('06', '15', '06', '15', '15', '15', 'thrombo'));

  // Temp table to hold inactive dates for certain conditions
  database()->exec('
create temporary table tempInactiveCond
(patientid varchar(11), condDate date, condName varchar(64), index pidIdx (patientid));');
  // TB treatment complete (inactive)
  database()->query("
insert into tempInactiveCond
select straight_join distinct e.patientID,
  ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd),
 ?
from tbStatus t
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and e.badvisitdate = 0 and p.hivPositive = 1
 and e.encounterType in (1, 2, 16, 17)
 and (t.asymptomaticTb = 1 or t.noTBsymptoms = 1);", array('tb'));
  database()->query("
insert into tempInactiveCond
select straight_join distinct e.patientID,
 case when isnumeric(completeTreatYy) = 1 and
  isnumeric(completeTreatMm) <> 1 and
  isdate(ymdToDate(completeTreatYy, ?, ?)) = 1 then
  ymdToDate(completeTreatYy, ?, ?)
  when isnumeric(completeTreatYy) = 1 and isnumeric(completeTreatMm) = 1 and
  isnumeric(completeTreatDd) <> 1 and
  isdate(ymdToDate(completeTreatYy, completeTreatMm, ?)) = 1 then
  ymdToDate(completeTreatYy, completeTreatMm, ?)
  when isdate(ymdToDate(t.completeTreatYy, t.completeTreatMm, t.completeTreatDd)) = 1 then
  ymdToDate(t.completeTreatYy, t.completeTreatMm, t.completeTreatDd)
  else ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) end,
 ?
from tbStatus t
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and e.badvisitdate = 0 and p.hivPositive = 1
 and e.encounterType in (1, 2, 16, 17)
 and t.completeTreat = 1;", array('06', '15', '06', '15', '15', '15', 'tb'));
  // Hep B
  database()->query("
insert into tempInactiveCond
select distinct patientID, visitDate, ?
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (320)
 and conditionActive = 2;", array('hepb'));
  // HIV Nephropathy
  database()->query("
insert into tempInactiveCond
select distinct patientID, visitDate, ?
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (35, 341)
 and conditionActive = 2;", array('nephropathy'));
  // PIL
  database()->query("
insert into tempInactiveCond
select distinct patientID, visitDate, ?
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (18)
 and conditionActive = 2;", array('pil'));
  // Leucoplasie buccale velue
  database()->query("
insert into tempInactiveCond
select distinct patientID, visitDate, ?
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (15, 202)
 and conditionActive = 2;", array('hairyoral'));
  // Thrombocytopénie
  database()->query("
insert into tempInactiveCond
select distinct patientID, visitDate, ?
from v_conditions
where encounterType in (1, 2, 16, 17)
 and conditionID in (49)
 and conditionActive = 2;", array('thrombo'));

  // Temp tables to hold max condition status dates relative to CD4 dates
  database()->exec('
create temporary table tempCondMaxActive
(patientid varchar(11), cd4Date date, condName varchar(64), maxDate date, index pidIdx (patientid));');
  // TB
  database()->query("
insert into tempCondMaxActive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempActiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'tb'));
  // HepB
  database()->query("
insert into tempCondMaxActive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempActiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'hepb'));
  // Nephropathy
  database()->query("
insert into tempCondMaxActive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempActiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'nephropathy'));
  // PIL
  database()->query("
insert into tempCondMaxActive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempActiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'pil'));
  // Leucoplasie buccale velue
  database()->query("
insert into tempCondMaxActive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempActiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'hairyoral'));
  // Thrombocytopénie
  database()->query("
insert into tempCondMaxActive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempActiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'thrombo'));

  database()->exec('
create temporary table tempCondMaxInactive
(patientid varchar(11), cd4Date date, condName varchar(64), maxDate date, index pidIdx (patientid));');
  // TB
  database()->query("
insert into tempCondMaxInactive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempInactiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'tb'));
  // HepB
  database()->query("
insert into tempCondMaxInactive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempInactiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'hepb'));
  // Nephropathy
  database()->query("
insert into tempCondMaxInactive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempInactiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'nephropathy'));
  // PIL
  database()->query("
insert into tempCondMaxInactive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempInactiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'pil'));
  // Leucoplasie buccale velue
  database()->query("
insert into tempCondMaxInactive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempInactiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'hairyoral'));
  // Thrombocytopénie
  database()->query("
insert into tempCondMaxInactive
select c.patientID,
 c.visitdate,
 a.condName,
 max(a.condDate)
from cd4Table c
 join tempInactiveCond a on c.patientid = a.patientid and c.visitdate >= a.condDate
where c.visitdate <= ?
 and a.condName = ?
group by 1, 2, 3;", array($endDate, 'thrombo'));

  // Temp table to hold max WHO stage dates relative to CD4 dates
  database()->exec('
create temporary table tempStageMax
(patientid varchar(11), cd4Date date, stage tinyint unsigned, index pidIdx (patientid));');
  database()->query("
insert into tempStageMax
select c.patientID,
 c.visitdate,
 max(w.stage)
from cd4Table c
 join tempWhoStage w on c.patientid = w.patientid and c.visitdate >= w.stageDate
where c.visitdate <= ?
group by 1, 2;", array($endDate));

  $insertEligibilityClause = '
insert into eligibilityTemp
(patientID, reason, visitDate, encounter_id, encountertype, formVersion, criteriaVersion) ';

  // CD4 count less than threshold
  database()->query($insertEligibilityClause . '
select patientid, ?, visitdate, encounter_id, encountertype, formVersion, 1
from cd4Table 
where cd4 < 200
 and cd4 <> 0
 and visitdate <= ?;', array ('cd4LT200', $endDate));
  database()->query($insertEligibilityClause . '
select c.patientid, ?, c.visitdate, c.encounter_id, c.encountertype, c.formVersion, 2
from cd4Table c
 join tempDob p using (patientID)
where c.cd4 < 350
 and c.cd4 <> 0
 and c.visitdate <= ?
 and p.dob is not null
 and c.visitdate >= date_add(p.dob, interval 15 year);', array('cd4LT200', $endDate));
  database()->query($insertEligibilityClause . '
select c.patientid, ?, c.visitdate, c.encounter_id, c.encountertype, c.formVersion, 2
from cd4Table c
 join tempDob p using (patientID)
 left join tempStageMax w on c.patientid = w.patientid and w.cd4Date = c.visitdate
 left join tempCondMaxActive a on c.patientid = a.patientid and a.cd4Date = c.visitdate
 left join tempCondMaxInactive i on c.patientid = i.patientid and i.cd4Date = c.visitdate
 left join tempPcrResult r on c.patientid = r.patientid and r.resultDate <= c.visitdate
where
 (
  (c.cd4 < 750
   and c.visitdate >= date_add(p.dob, interval 12 month)
   and c.visitdate < date_add(p.dob, interval 36 month))
  or
  (c.cd4 < 350
   and c.visitdate >= date_add(p.dob, interval 36 month)
   and c.visitdate < date_add(p.dob, interval 15 year))
 )
 and c.cd4 <> 0
 and c.visitdate <= ?
 and r.patientID is null
 and
 (
  w.stage in (1, 2)
  or
  (
   w.stage = 3
   and
   (
    a.patientid is null
    or
    (a.patientid is not null
     and a.condName in (?, ?, ?, ?)
     and i.maxDate > a.maxDate)
   )
  )
 )
 and p.dob is not null;', array('cd4LT200', $endDate, 'tb', 'pil', 'hairyoral', 'thrombo'));

  // TLC count less than threshold

  // Temp table to hold TLC test results
  database()->exec('
create temporary table tempTlcResult
(patientid varchar(11), resultDate date, result varchar(255), encounter_id int unsigned, encounterType tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  database()->query("
insert into tempTlcResult
select distinct t.patientID, " . $labResultDateCaseClause . ",
  t.result, e.encounter_id, e.encounterType, e.formVersion
from labs t /* v_labsCompleted too slow */
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1
 and lower(t.testnamefr) = ?
 and t.result <> 0
 and t.result is not null
 and ltrim(rtrim(t.result)) != ?
 and isdate(" . $labResultDateCaseClause . ") = 1
 and " . $labResultDateCaseClause . " <= ?;", array('06', '15', '06', '15', '15', '15', 'lymphocytes', '', '06', '15', '06', '15', '15', '15', '06', '15', '06', '15', '15', '15', $endDate));

  // Temp table to hold TLC lab result dates relative to max WHO stage
  database()->exec('
create temporary table tempStageMaxTlc
(patientid varchar(11), resultDate date, stage tinyint unsigned, index pidIdx (patientid));');
  database()->query("
insert into tempStageMaxTlc
select t.patientid, resultDate, max(w.stage)
from tempTlcResult t
 join tempWhoStage w on t.patientid = w.patientid and t.resultDate >= w.stageDate
where t.resultDate <= ?
group by 1, 2;", array ($endDate));

  database()->query($insertEligibilityClause . '
select t.patientid, ?, t.resultDate, t.encounter_id, t.encounterType, t.formVersion, 1
from tempTlcResult t
where t.result <= ?
 and t.resultDate <= ?;', array('tlcLT1200', '1200', $endDate));
  database()->query($insertEligibilityClause . '
select t.patientid, ?, t.resultDate, t.encounter_id, t.encounterType, t.formVersion, 2
from tempTlcResult t
 join tempDob d using (patientid)
 join tempStageMaxTlc w on t.patientid = w.patientid and t.resultDate = w.resultDate
 left join cd4Table c on t.patientid = c.patientid and c.visitdate <= t.resultDate
 left join tempPcrResult r on t.patientid = r.patientid and r.resultDate <= t.resultDate
where
 (
  (t.result < 3000 
   and t.resultDate >= date_add(d.dob, interval 12 month)
   and t.resultDate < date_add(d.dob, interval 36 month))
  or
  (t.result < 2500 
   and t.resultDate >= date_add(d.dob, interval 36 month)
   and t.resultDate < date_add(d.dob, interval 60 month))
  or
  (t.result < 2000 
   and t.resultDate >= date_add(d.dob, interval 60 month)
   and t.resultDate < date_add(d.dob, interval 108 month))
 )
 and c.patientid is null
 and r.patientID is null
 and w.stage = 2
 and d.dob is not null
 and t.resultDate <= ?;', array('tlcLT1200', $endDate));

  // WHOIII
  database()->query($insertEligibilityClause . '
select c.patientid, ?, c.stageDate, c.encounter_id, c.encountertype, c.formVersion, 1
from tempWhoStage c, genEligTemp
where c.stage = 3
 and c.stageDate <= ?
 and c.patientid = genEligTemp.patientid;', array('WHOIII', $endDate));
  database()->query($insertEligibilityClause . '
select c.patientid, ?, c.stageDate, c.encounter_id, c.encountertype, c.formVersion, 2
from tempWhoStage c
 join tempDob d using (patientid)
where c.stage = 3
 and c.stageDate <= ?
 and d.dob is not null
 and c.stageDate >= date_add(d.dob, interval 15 year);', array('WHOIII-2', $endDate));

  // WHOIV
  database()->query($insertEligibilityClause . '
select patientid, ?, stageDate, encounter_id, encountertype, formVersion, 1
from tempWhoStage
where stage = 4
 and stageDate <= ?;', array('WHOIV', $endDate));
  database()->query($insertEligibilityClause . '
select c.patientid, ?, c.stageDate, c.encounter_id, c.encountertype, c.formVersion, 2
from tempWhoStage c
 join tempDob d using (patientid)
where c.stage = 4
 and c.stageDate <= ?
 and d.dob is not null
 and c.stageDate >= date_add(d.dob, interval 15 year);', array('WHOIV', $endDate));
  database()->query($insertEligibilityClause . '
select c.patientid, ?, c.stageDate, c.encounter_id, c.encountertype, c.formVersion, 2
from tempWhoStage c
 join tempDob d using (patientid)
 left join tempPcrResult r on c.patientid = r.patientid and r.resultDate <= c.stageDate
where c.stage = 4
 and c.stageDate <= ?
 and d.dob is not null
 and r.patientid is null
 and c.stageDate >= date_add(d.dob, interval 12 month)
 and c.stageDate < date_add(d.dob, interval 15 year);', array('WHOIV', $endDate));

  // Age (either >= 60 yrs. or < 12 mos. w/ no PCR results and not exposed-only)
  database()->query($insertEligibilityClause . '
select e.patientID, ?, date_add(d.dob, interval 60 year), e.encounter_id, e.encountertype, e.formVersion, 2
from tempDob d
 join encounter e using (patientID)
where e.encounterType in (10, 15)
 and d.dob is not null
 and ? >= date_add(d.dob, interval 60 year)', array ('eligByAge', $endDate));
  database()->query($insertEligibilityClause . '
select e.patientID, ?, d.dob, e.encounter_id, e.encountertype, e.formVersion, 2
from tempDob d
 join encounter e using (patientID)
 left join tempPcrResult r on d.patientid = r.patientid and r.resultDate <= ?
 left join tempPedHivStatus h on d.patientid = h.patientid and h.maxStatus = 1
where e.encounterType in (10, 15)
 and d.dob is not null
 and r.patientid is null
 and h.patientid is null
 and ? < date_add(d.dob, interval 1 year)', array ('eligByAge', $endDate, $endDate));

  // Active condition
  
  // Temp table to hold min inactive condition date relative to active date
  database()->exec('
create temporary table tempCondMinInactive
(patientid varchar(11), activeDate date, condName varchar(64), minInactive date, index pidIdx (patientid));');
  // TB
  database()->query("
insert into tempCondMinInactive
select c.patientid,
 c.condDate,
 c.condName,
 min(i.condDate)
from tempActiveCond c
 left join tempInactiveCond i on c.patientid = i.patientid and i.condDate > c.condDate
where c.condDate <= ?
 and i.condDate <= ?
 and c.condName = ?
group by 1, 2, 3;", array($endDate, $endDate, 'tb'));
  // HepB
  database()->query("
insert into tempCondMinInactive
select c.patientid,
 c.condDate,
 c.condName,
 min(i.condDate)
from tempActiveCond c
 left join tempInactiveCond i on c.patientid = i.patientid and i.condDate > c.condDate
where c.condDate <= ?
 and i.condDate <= ?
 and c.condName = ?
group by 1, 2, 3;", array($endDate, $endDate, 'hepb'));
  // HIV Nephropathy
  database()->query("
insert into tempCondMinInactive
select c.patientid,
 c.condDate,
 c.condName,
 min(i.condDate)
from tempActiveCond c
 left join tempInactiveCond i on c.patientid = i.patientid and i.condDate > c.condDate
where c.condDate <= ?
 and i.condDate <= ?
 and c.condName = ?
group by 1, 2, 3;", array($endDate, $endDate, 'nephropathy'));
  // PIL
  database()->query("
insert into tempCondMinInactive
select c.patientid,
 c.condDate,
 c.condName,
 min(i.condDate)
from tempActiveCond c
 left join tempInactiveCond i on c.patientid = i.patientid and i.condDate > c.condDate
where c.condDate <= ?
 and i.condDate <= ?
 and c.condName = ?
group by 1, 2, 3;", array($endDate, $endDate, 'pil'));
  // Leucoplasie buccale velue
  database()->query("
insert into tempCondMinInactive
select c.patientid,
 c.condDate,
 c.condName,
 min(i.condDate)
from tempActiveCond c
 left join tempInactiveCond i on c.patientid = i.patientid and i.condDate > c.condDate
where c.condDate <= ?
 and i.condDate <= ?
 and c.condName = ?
group by 1, 2, 3;", array($endDate, $endDate, 'hairyoral'));
  // Thrombocytopénie
  database()->query("
insert into tempCondMinInactive
select c.patientid,
 c.condDate,
 c.condName,
 min(i.condDate)
from tempActiveCond c
 left join tempInactiveCond i on c.patientid = i.patientid and i.condDate > c.condDate
where c.condDate <= ?
 and i.condDate <= ?
 and c.condName = ?
group by 1, 2, 3;", array($endDate, $endDate, 'thrombo'));

  database()->query($insertEligibilityClause . '
select a.patientID, ?, a.condDate, a.encounter_id, a.encounterType, a.formVersion, 2
from tempActiveCond a
 join tempDob d using (patientid)
 left join tempCondMinInactive i on a.patientid = i.patientid and a.condName = i.condName and a.condDate = i.activeDate
where a.condDate <= ?
 and a.condName in (?, ?, ?)
 and d.dob is not null
 and a.condDate >= date_add(d.dob, interval 15 year)
 and i.patientid is null;', array ('eligByCond', $endDate, 'tb', 'hepb', 'nephropathy'));
  database()->query($insertEligibilityClause . '
select distinct a.patientid, ?, a.condDate, a.encounter_id, a.encounterType, a.formVersion, 2
from tempActiveCond a
 join tempDob d using (patientid)
 left join tempCondMinInactive i on a.patientid = i.patientid and a.condName = i.condName and a.condDate = i.activeDate
 left join tempWhoStage w on a.patientid = w.patientid and w.stageDate <= a.condDate
 left join tempPcrResult r on a.patientid = r.patientid and r.resultDate <= a.condDate
where a.condDate <= ?
 and a.condName in (?, ?, ?, ?)
 and d.dob is not null
 and w.stage = 3
 and r.patientID is null
 and a.condDate >= date_add(d.dob, interval 12 month)
 and a.condDate < date_add(d.dob, interval 15 year)
 and i.patientid is null;', array('WHOIIICond', $endDate, 'tb', 'pil', 'hairyoral', 'thrombo'));
  database()->query($insertEligibilityClause . '
select distinct w.patientid, ?, w.stageDate, w.encounter_id, w.encounterType, w.formVersion, 2
from tempWhoStage w
 join tempDob d using (patientid)
 left join tempActiveCond a on a.patientid = w.patientid and w.stageDate >= a.condDate
 left join tempCondMinInactive i on a.patientid = i.patientid and a.condName = i.condName and a.condDate = i.activeDate
 left join tempPcrResult r on a.patientid = r.patientid and r.resultDate <= a.condDate
where w.stageDate <= ?
 and a.condName in (?, ?, ?, ?)
 and d.dob is not null
 and w.stage = 3
 and r.patientID is null
 and w.stageDate >= date_add(d.dob, interval 12 month)
 and w.stageDate < date_add(d.dob, interval 15 year)
 and i.patientid is null;', array('WHOIIICond', $endDate, 'tb', 'pil', 'hairyoral', 'thrombo'));

  // PCR positive (pediatric only)
  database()->query($insertEligibilityClause . '
select r.patientid, ?, r.resultDate, r.encounter_id, r.encounterType, r.formVersion, 2
from tempPcrResult r
 join tempDob d using (patientid)
 left join
  (select patientid, max(resultDate) as resultDate
   from tempPcrResult2
   where resultDate <= ?
    and result = 2
   group by 1) r2 on r.patientid = r2.patientid
where r.resultDate <= ?
 and r.result = 1
 and d.dob is not null
 and
 (
  r2.patientid is null
  or
  (r2.patientid is not null
   and r.resultDate >= r2.resultDate)
 )
 and r.resultDate < date_add(d.dob, interval 15 year);', array('eligPcr', $endDate, $endDate));

  // Option B+, if an HIV+ woman ever becomes pregnant, or a pregnant woman
  // becomes HIV+, she's eligible on that date regardless of the outcome of
  // the pregnancy.

  // Temp table to hold HIV+ dates
  database()->exec('
create temporary table tempHivPosDates
(patientid varchar(11), posDate date, encounter_id int unsigned, encounterType tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  database()->query("
insert into tempHivPosDates
select distinct v.patientID, v.visitDate, v.encounter_id, v.encounterType, v.formVersion
from encValid v
where v.encounterType in (1, 16)
 and v.visitDate <= ?", array ($endDate));

  database()->query("
insert into tempHivPosDates
select straight_join distinct v.patientID, ymdToDate(v.resultDateYy, v.resultDateMm, v.resultDateDd), v.encounter_id, v.encounterType, v.formVersion
from a_labsCompleted v
where
 (
  (v.labID in (100, 101, 181) and v.result = 1)
  or
  (v.testNameFr like ? and v.labID > 1000 and v.result not like ?)
 )
 and isdate(ymdToDate(v.resultDateYy, v.resultDateMm, v.resultDateDd)) = 1
 and ymdToDate(v.resultDateYy, v.resultDateMm, v.resultDateDd) <= ?", array ("%vih%", "%neg%", $endDate));

  // Temp table to hold pregnancy dates
  database()->exec('
create temporary table tempPregDates
(patientid varchar(11), pregDate date, encounter_id int unsigned, encounterType tinyint unsigned, formVersion smallint, index pidIdx (patientid));');
  database()->query("
insert into tempPregDates
select straight_join distinct v.patientID, v.visitDate, v.encounter_id, v.encounterType, v.formVersion
from a_vitals v
where v.pregnant = 1
 and v.visitDate <= ?", array ($endDate));

  database()->query("
insert into tempPregDates
select straight_join distinct v.patientID, ymdToDate(v.resultDateYy, v.resultDateMm, v.resultDateDd), v.encounter_id, v.encounterType, v.formVersion
from a_labsCompleted v
where
 (
  (v.labID in (134) and v.result = 1)
  or
  (v.testNameFr like ? and v.labID > 1000 and v.result not like ?)
 )
 and isdate(ymdToDate(v.resultDateYy, v.resultDateMm, v.resultDateDd)) = 1
 and ymdToDate(v.resultDateYy, v.resultDateMm, v.resultDateDd) <= ?", array ("%grossesse%", "%neg%", $endDate));

  database()->query("
insert into tempPregDates
select distinct e.patientID, e.visitDate, e.encounter_id, e.encounterType, e.formVersion
from encValidAll e, obs t1, obs t2, obs t3
where e.encounter_id = t1.encounter_id
 and t1.encounter_id = t2.encounter_id
 and t1.encounter_id = t3.encounter_id
 and e.siteCode = t1.location_id
 and t1.location_id = t2.location_id
 and t1.location_id = t3.location_id
 and e.visitDate <= ?
 and
 (
  (t1.concept_id = 7057
   and t2.concept_id = 7058
   and t3.concept_id = 7059
   and isdate(ymdToDate(t1.value_text, t2.value_text, t3.value_text)) = 1
   and ymdToDate(t1.value_text, t2.value_text, t3.value_text) <= date_add(?, interval 9 month))
  or
  (t1.concept_id = 8062
   and t2.concept_id = 8063
   and t3.concept_id = 8061
   and isdate(ymdToDate(t1.value_text, t2.value_text, t3.value_text)) = 1
   and ymdToDate(t1.value_text, t2.value_text, t3.value_text) <= date_add(?, interval 9 month))
 )
union
select distinct e.patientID, e.visitDate, e.encounter_id, e.encounterType, e.formVersion
from encValidAll e, obs o
where o.location_id = e.siteCode
 and o.encounter_id = e.encounter_id
 and o.concept_id IN (71069, 70466)
 and o.value_datetime <= date_add(?, interval 9 month)
 and e.visitDate <= ?", array ($endDate, $endDate, $endDate, $endDate, $endDate));

  database()->query("
insert into tempPregDates
select distinct v.patientID, v.visitDate, v.encounter_id, v.encounterType, v.formVersion
from encValidAll v
where v.encounterType = 26
 and v.visitDate <= ?", array ($endDate));

  database()->query("
insert into tempPregDates
select distinct v.patientID, v.visitDate, v.encounter_id, v.encounterType, v.formVersion
from encValidAll v, obs o
where o.location_id = v.siteCode
 and o.encounter_id = v.encounter_id
 and v.visitDate <= ?
 and
  (
   (v.encounterType in (27,28,29,31)
    and o.concept_id IN (70264, 70265)
    and o.value_boolean = 1)
   or
   (v.encounterType in (24,25) 
    and
     (
      (o.concept_id in (70067,70068,70069,70078,70082,70084,70086,70087,70103,70118,70126,70130,70132,70144,70148,70150,71140)
       and o.value_boolean = 1)
      or
      (o.concept_id IN (7098,7163,7166,7897)
       and
        (isnumeric(o.value_text) = 1
         or isnumeric(o.value_numeric) = 1)
       and
        (o.value_text > 0
         or o.value_numeric > 0))
     ))
  )
union
select distinct v.patientID, v.visitDate, v.encounter_id, v.encounterType, v.formVersion
from a_conditions v
where v.conditionID IN (439)
 and v.conditionActive = 1
 and v.encounterType IN (24,25)
 and v.visitDate <= ?", array ($endDate, $endDate));

  // Temp table to hold min HIV+ date
  database()->exec('
create temporary table tempMinHivPosDate
(patientid varchar(11), posDate date, index pidIdx (patientid));');
  database()->query("
insert into tempMinHivPosDate
select patientid, min(posDate)
from tempHivPosDates
group by 1");

  // Temp table to hold min pregnancy date after first HIV+ date
  database()->exec('
create temporary table tempMinPregDate
(patientid varchar(11), pregDate date, index pidIdx (patientid));');
  database()->query("
insert into tempMinPregDate
select t2.patientid, min(t2.pregDate)
from tempMinHivPosDate t1, tempPregDates t2
where t1.patientid = t2.patientid
 and t1.posDate <= t2.pregDate
group by 1");

  // Temp table to hold min HIV+ date after any pregnancy date (+9 months)
  database()->exec('
create temporary table tempMinHivPosAfterPregDate
(patientid varchar(11), posDate date, index pidIdx (patientid));');
  database()->query("
insert into tempMinHivPosAfterPregDate
select t2.patientid, min(t2.posDate)
from tempPregDates t1, tempHivPosDates t2
where t1.patientid = t2.patientid
 and t2.posDate between t1.pregDate and date_add(t1.pregDate, interval 9 month)
group by 1");

  database()->query($insertEligibilityClause . '
select straight_join t1.patientid, ?, t1.pregDate, t2.encounter_id, t2.encountertype, t2.formVersion, 3
from tempMinPregDate t1
 join tempPregDates t2 using (patientid, pregDate)
 join patient p using (patientID)
where p.sex = 1', array ("OptionB+"));

  database()->query($insertEligibilityClause . '
select straight_join t1.patientid, ?, t1.posDate, t2.encounter_id, t2.encountertype, t2.formVersion, 3
from tempMinHivPosAfterPregDate t1
 join tempHivPosDates t2 using (patientid, posDate)
 join patient p using (patientID)
where p.sex = 1', array ("OptionB+"));

  // 'Yes' selected on form in medical eligibility section
  database()->query($insertEligibilityClause . '
select straight_join t.patientid, ?, ymdToDate(visitDateYy, visitDateMm, visitDateDd), encounter_id, encountertype, formVersion, 1
from medicalEligARVs t /* v_medicalEligARVs is too slow */
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1
and
(
 (
  encounterType in (1, 2)
  and (formVersion != 1 or formVersion IS NULL)
  and medElig IN (1, 2, 3, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15)
 )
 or
 (
  (
   (encounterType in (16, 17)
    and (formVersion != 1 or formVersion IS NULL)
   )
   or (encounterType in (1, 2) and formVersion = 1)
  )
  and medElig IN (1, 3, 5, 7, 9, 11, 13, 15)
 )
)
and ymdToDate(visitDateYy, visitDateMm, visitDateDd) <= ?;', array('medEligHAART', $endDate));
  database()->query($insertEligibilityClause . '
select straight_join t.patientid, ?, ymdToDate(visitDateYy, visitDateMm, visitDateDd), encounter_id, encountertype, formVersion, 2
from medicalEligARVs t /* v_medicalEligARVs is too slow */
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1
and
(
 (
  encounterType in (1, 2)
  and (formVersion != 1 or formVersion IS NULL)
  and medElig IN (1, 2, 3, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15)
 )
 or
 (
  (
   (encounterType in (16, 17)
    and (formVersion != 1 or formVersion IS NULL)
   )
   or (encounterType in (1, 2) and formVersion = 1)
  )
  and medElig IN (1, 3, 5, 7, 9, 11, 13, 15)
 )
)
and ymdToDate(visitDateYy, visitDateMm, visitDateDd) <= ?;', array('medEligHAART', $endDate));

  // catchall for anything checked yes -- adult and pediatric
  $catchAllInfo = array('cd4LT200' => 'cd4LT200',
			'tlcLT1200' => 'tlcLT1200',
			'WHOIII' => 'WHOIII',
			'WHOIV' => 'WHOIV',
			'PMTCT' => 'PMTCT',
			'formerARVtherapy' => 'former',
			'PEP' => 'PEP',
			'medEligHAART' => 'estPrev',
			'pedMedEligCd4Cnt' => 'cd4LT200',
			'pedMedEligTlc' => 'tlcLT1200',
			'pedMedEligWho3' => 'WHOIII',
			'pedMedEligWho4' => 'WHOIV',
			'pedMedEligPmtct' => 'PMTCT',
			'pedMedEligFormerTherapy' => 'former',
			'coinfectionTbHiv' => 'coinfectionTbHiv',
		    'coinfectionHbvHiv' => 'coinfectionHbvHiv',
		    'coupleSerodiscordant' => 'coupleSerodiscordant',
		    'pregnantWomen' => 'pregnantWomen',
		    'breastfeedingWomen' => 'breastfeedingWomen',
		    'ChildLT5ans' => 'ChildLT5ans',
		    'patientGt50ans' => 'patientGt50ans',
		    'nephropathieVih' => 'nephropathieVih',
                    'protocoleTestTraitement'=> 'protocoleTestTraitement',
			);
  database()->query('
create temporary table medicalEligARVsTemp
select straight_join t.*, e.encounter_id, e.encountertype, e.formVersion, ymdToDate(visitDateYy, visitDateMm, visitDateDd) fixedVisitDate
from medicalEligARVs t /* v_medicalEligARVs is too slow */
 join encounter e using (siteCode, patientID, visitDatedd, visitDatemm, visitDateyy, seqNum)
 join patient p using (patientID)
where e.encStatus < 255 and p.patStatus = 0 and badvisitdate = 0 and p.hivPositive = 1
 and (' . implode('=1 or ', array_keys($catchAllInfo)) . '=1)
 and ymdToDate(visitDateYy, visitDateMm, visitDateDd) <= ?;', array($endDate));
  foreach ($catchAllInfo as $columnName => $typeName) {
    database()->query($insertEligibilityClause . '
select patientid, ?, fixedVisitDate, encounter_id, encountertype, formVersion, 1
from medicalEligARVsTemp
where ' . $columnName . ' = 1', array($typeName));
    database()->query($insertEligibilityClause . '
select patientid, ?, fixedVisitDate, encounter_id, encountertype, formVersion, 2
from medicalEligARVsTemp
where ' . $columnName . ' = 1', array($typeName));
  }
  database()->exec('drop temporary table medicalEligARVsTemp;');

  // TMS eligibility criteria below
  // Anyone 14 or over at registration was eligible at registration
  database()->query($insertEligibilityClause . '
select patientID, ?, regDate, encounter_id, encounterType, formVersion, 1
 from tmsEligTemp where ageAtReg >= 14', array('tmsAdult'));

  // People who have passed age 14 since registration are eligible at 14
  database()->query($insertEligibilityClause . '
select patientID, ?, fourteenYearsOld, encounter_id, encounterType,
formVersion, 1
 from
 (select patientID, fourteenYearsOld, encounter_id,
  encounterType, formVersion
  from tmsEligTemp
  where ageAtReg < 14 and
  fourteenYearsOld is not null) t
 where ? >= fourteenYearsOld', array('tmsAdult', $endDate));

  // Infected children currently b/w 6 wks. and 1 yr. old eligible at diagnosis date
  database()->query($insertEligibilityClause . '
select distinct p.patientID, ?, min(c.visitdate),
p.encounter_id, p.encounterType, p.formVersion, 1
 from
 (select patientID, sixWeeksOld, oneYearOld, encounter_id, encounterType,
  formVersion
  from tmsEligTemp
  where sixWeeksOld is not null and
  oneYearOld is not null) p,
 v_vitals v, v_conditions c 
where
 p.patientID = v.patientID and
 p.patientID = c.patientID and
 ? between p.sixWeeksOld and p.oneYearOld and
 c.whoStage in (?, ?, ?) and
 c.visitdate between p.sixWeeksOld and p.oneYearOld and
 v.pedCurrHiv > 1 and
 v.visitDate between p.sixWeeksOld and p.oneYearOld
group by p.patientID, p.encounter_id, p.encounterType, p.formVersion;', array('tmsChildInfected', $endDate, 'Stage II', 'Stage III', 'Stage IV'));

  // Exposed children currently b/w 6 wks. and 1 yr. old eligible at exposure date
  database()->query($insertEligibilityClause . '
select distinct p.patientID, ?, min(v.visitDate),
p.encounter_id, p.encounterType, p.formVersion, 1
 from
 (select patientID, sixWeeksOld, oneYearOld, encounter_id, encounterType, 
  formVersion
  from tmsEligTemp 
  where sixWeeksOld is not null and
  oneYearOld is not null) p,
 v_vitals v where
 p.patientID = v.patientID and
 ? between p.sixWeeksOld and p.oneYearOld and
 v.pedCurrHiv = 1 and
 v.visitDate between p.sixWeeksOld and p.oneYearOld
 group by p.patientID, p.encounter_id, p.encounterType, p.formVersion', array('tmsChildExposed', $endDate));

  // Remove records with duplicate patient, reason and criteria version. Keep the one with the earliest visitDate.
  database()->exec('
create temporary table eligibilityTempFinal
(patientid varchar(11),
 reason varchar(30),
 visitDate datetime,
 encounter_id int unsigned,
 encountertype int,
 formVersion int,
 criteriaVersion int unsigned,
 unique key patientid (patientid, reason, criteriaVersion)
);');
  database()->exec('
insert into eligibilityTempFinal
 (patientid, reason, visitDate, encounter_id, encountertype, formVersion, criteriaVersion)
select * from eligibilityTemp t
on duplicate key update
 visitDate = if(eligibilityTempFinal.visitDate < t.visitDate, eligibilityTempFinal.visitDate, t.visitDate),
 encounter_id = if(eligibilityTempFinal.visitDate < t.visitDate, eligibilityTempFinal.encounter_id, t.encounter_id),
 encountertype = if(eligibilityTempFinal.visitDate < t.visitDate, eligibilityTempFinal.encountertype, t.encountertype),
 formVersion = if(eligibilityTempFinal.visitDate < t.visitDate, eligibilityTempFinal.formVersion, t.formVersion);');

  // Copy data into the real eligibility table.
  database()->exec('truncate table eligibility;');
  database()->exec('lock tables eligibility write;');
  database()->exec('delete from eligibility;');
  database()->exec('
insert into eligibility (patientid, reason, visitDate, encounter_id, encountertype, formVersion, criteriaVersion)
select patientid, reason, visitDate, encounter_id, encountertype, formVersion, criteriaVersion
from eligibilityTempFinal;');
  database()->exec('unlock tables;');

  //clean up
  database()->exec('drop temporary table eligibilityTemp;');
  database()->exec('drop temporary table eligibilityTempFinal;');
  database()->exec('drop temporary table genEligTemp;');
  database()->exec('drop temporary table tmsEligTemp;');
  database()->exec('drop temporary table tempDob;');
  database()->exec('drop temporary table tempPcrResult;');
  database()->exec('drop temporary table tempPcrResult2;');
  database()->exec('drop temporary table tempWhoStage;');
  database()->exec('drop temporary table tempActiveCond;');
  database()->exec('drop temporary table tempInactiveCond;');
  database()->exec('drop temporary table tempCondMaxActive;');
  database()->exec('drop temporary table tempCondMaxInactive;');
  database()->exec('drop temporary table tempStageMax;');
  database()->exec('drop temporary table tempTlcResult;');
  database()->exec('drop temporary table tempStageMaxTlc;');
  database()->exec('drop temporary table tempHivPosDates;');
  database()->exec('drop temporary table tempMinHivPosDate;');
  database()->exec('drop temporary table tempPregDates;');
  database()->exec('drop temporary table tempPedHivStatus;');
} 


function generateSplashArray () {
	$lang = 'fr';   
	require_once 'labels/splash.php';
	dbQuery("truncate table lastSplash");
	dbQuery("truncate table lastSplashText");
	$statusArray = array();
	// index is patientStatus, associative value is column in final report
	$statusMap = array (1 => 9, 2 => 5, 3 => 0, 4 => 7 , 5 => 2,  6 => 6,  7 => 1, 8 => 8,  9 => 4, 10 => 3, 0 => 11);

	// this query gets status count information; add pediatric rows by making isPediatric part of the key
	$qry = "select rtrim(sitecode), case when isPediatric = 1 then 1 else 0 end as isPediatric, 
		case when patientStatus between 1 and 10 and hivPositive = 1 then patientStatus else 0 end as patientStatus, count(distinct e.patientid)
		from encounter e, patient p where e.patientid = p.patientid and e.encStatus < 255 and p.patStatus = 0 and e.encounterType in (10, 15)
		group by sitecode, case when isPediatric = 1 then 1 else 0 end, patientStatus";
	$result = dbQuery ($qry);
	while ($row = psRowFetch ($result)) {
		if (!array_key_exists($row[0] . "|" . $row[1], $statusArray))
			$statusArray[$row[0] . "|" . $row[1]] = array(0,0,0,0,0,0,0,0,0,0,0);
		$statusArray[$row[0] . "|" . $row[1]][$statusMap[$row["patientStatus"]]] = $row[3];
	}
	// this query gets clinic information
	$qry2 = "select clinic,
		rtrim(c.sitecode) as sitecode, case when c.dbSite != 0 then '" . $splashLabels[$lang]['sLocal'] . "' else '' end as 
'local', dbVersion, case when max(lastmodified) is null then '2000-01-01' else max(lastmodified) end as 'maxDate', datediff(d,max(lastmodified),getDate()) as ddDelta, datediff(d,min(createdate),getDate()) as ddNew
		from clinicLookup c, encounter e where e.encStatus < 255 and e.sitecode = c.sitecode and c.incphr = 1";
	$qry2 .= " group by clinic, c.sitecode, case when c.dbSite != 0 then '" . $splashLabels[$lang]['sLocal'] . "' else '' end, dbVersion order by 5 desc";  
	eval("\$qry2 = \"$qry2\";");
 	$result = dbQuery ($qry2);
	$jj = 0;
	// format row results
	loadSplash("var myData = [");
	$firstFlag = true;
	$localCnt = 0;
	while ($row = psRowFetch($result)) {
		if ($firstFlag) {
			loadSplash ("[");
			$firstFlag = false;
		}
		else loadSplash (",\n[");
		$curDate = formatDisplayedDate ("maxDate", $row["maxDate"],"en");
		$ddDelta = $row['ddDelta'];
		$color = "";
		$ecolor = "";
		if ($ddDelta > 14) {
			$color = "<font color=\"red\">";
			$ecolor = "</font>";
		} 
		$curDateArray = explode("/", $curDate);
		$curDate = $curDateArray[0] . "/" . $curDateArray[1] . "/20" . $curDateArray[2];
		$ddDelta = $row['ddDelta'];
		$ddNew = $row['ddNew'];
		$color = "";
		$ecolor = "";
		if ($ddNew < 90) {
			$color = "<font color=\"blue\">";
			$ecolor = "</font>";
		}
		if ($ddDelta > 14) {
			$color = "<font color=\"red\">";
			$ecolor = "</font>";
		}
		$clinic = "'" . $color . str_replace("'","X",$row["clinic"]) . $ecolor . "','";
		// display the local APP_VERSION for the dbVersion if the defsite value matches; otherwise use clinicLookup table value 
		$dbVersion = ($row["sitecode"] == DEF_SITE) ? APP_VERSION : $row["dbVersion"];
		// tweak dbVersion if it uses the new numbering convention
		if (strpos($dbVersion,'(') > 0) $dbVersion = substr($dbVersion,0,5);
		loadSplash ($clinic . $row["sitecode"] . "','" . $dbVersion . "','" . $row["local"] . "','" . $curDate . "',");
		$t1 = array();
		$t2 = array();
		for ($j = 0; $j < 2; $j++) {
			if (!array_key_exists($row[1] . "|" . $j, $statusArray)) {
				$statusArray[$row[1] . "|" . $j] = array(0,0,0,0,0,0,0,0,0,0,0);
			}
			// clinical care total
			$t1[$j] = $statusArray[$row[1] . "|" . $j][0] + $statusArray[$row[1] . "|" . $j][1] + $statusArray[$row[1] . "|" . $j][2] + $statusArray[$row[1] . "|" . $j][3] + $statusArray[$row[1] . "|" . $j][4];
			// art total
			$t2[$j] = $statusArray[$row[1] . "|" . $j][5] + $statusArray[$row[1] . "|" . $j][6] + $statusArray[$row[1] . "|" . $j][7] + $statusArray[$row[1] . "|" . $j][8] + $statusArray[$row[1] . "|" . $j][9];
		}
		for ($k = 0; $k < 5; $k++)
			loadSplash (str_replace(".", "&nbsp;", "'" . str_pad ($statusArray[$row[1] . "|" . "0"][$k],4,".",STR_PAD_LEFT) . "/" . str_pad($statusArray[$row[1] . "|" . "1"][$k],3,".",STR_PAD_LEFT) . "',"));
		loadSplash (str_replace(".", "&nbsp;", "'" . str_pad ($t1[0],4,".",STR_PAD_LEFT) . "/" . str_pad ($t1[1],3,".",STR_PAD_LEFT) . "',"));
		for ($k = 5; $k < 10; $k++)
			loadSplash (str_replace(".", "&nbsp;", "'" . str_pad ($statusArray[$row[1] . "|" . "0"][$k],4,".",STR_PAD_LEFT) . "/" . str_pad($statusArray[$row[1] . "|" . "1"][$k],3,".",STR_PAD_LEFT) . "',"));
		loadSplash (str_replace(".", "&nbsp;", "'" . str_pad ($t2[0],4,".",STR_PAD_LEFT) . "/" . str_pad ($t2[1],4,".",STR_PAD_LEFT) . "',"));
		loadSplash ("'" . ($statusArray[$row[1] . "|0"][11] + $statusArray[$row[1] . "|1"][11]) . "',");
		$t3 = $t1[0] + $t1[1] + $t2[0] + $t2[1] + ($statusArray[$row[1] . "|0"][11] + $statusArray[$row[1] . "|1"][11]);
		loadSplash ("'" . $t3 . "']");
	    $jj++;
	    if ($row[2] != "") $localCnt++;
	}
	loadSplash ("];");
	// totals row
	$totals[0] = array(0,0,0,0,0,0,0,0,0,0,0);
	$totals[1] = array(0,0,0,0,0,0,0,0,0,0,0);
	foreach ($statusArray as $site => $numArray) {
		$siteParts = explode("|", $site);
		$j = $siteParts[1];
		for ($k = 0; $k < 12; $k++)
			$totals[$j][$k] += $numArray[$k];
	}
	$t1 = array();
	$t2 = array();
	for ($j = 0; $j < 2; $j++) {
		$t1[$j] = $totals[$j][0]+$totals[$j][1]+$totals[$j][2]+$totals[$j][3]+$totals[$j][4];
		$t2[$j] = $totals[$j][5]+$totals[$j][6]+$totals[$j][7]+$totals[$j][8]+$totals[$j][9];
	}
	
	$arrayVector = array ("'" . $splashLabels[$lang]["grandTotals"] . "'","' '","'" . $localCnt . "'","'" . $jj . "'");
	for ($k = 0; $k < 5; $k++)
		array_push ($arrayVector,  "'" . str_pad ($totals[0][$k],4," ",STR_PAD_LEFT) . "/" . str_pad ($totals[1][$k],3," ",STR_PAD_LEFT) . "'");
	array_push ($arrayVector, "'" . str_pad ($t1[0],4," ",STR_PAD_LEFT) . "/" . str_pad ($t1[1],3," ",STR_PAD_LEFT) . "'");
	for ($k = 5; $k < 10; $k++)
		array_push ($arrayVector, "'" . str_pad ($totals[0][$k],4," ",STR_PAD_LEFT) . "/" . str_pad ($totals[1][$k],3," ",STR_PAD_LEFT) . "'");
	array_push ($arrayVector,  "'" . str_pad ($t2[0],4," ",STR_PAD_LEFT) . "/" . str_pad ($t2[1],3," ",STR_PAD_LEFT) . "'");
	array_push ($arrayVector, "'" . ($totals[0][11] + $totals[1][11]) . "'");
	$t3 = $t1[0] + $t1[1] + $t2[0] + $t2[1] + $totals[0][11] + $totals[1][11];
	array_push ($arrayVector, "'" . $t3 . "'");
	loadSplash("\nvar totalVector = new Array (");
	$first = true;
	foreach ($arrayVector as $vectorElement) {
		if ($first) {
			loadSplash($vectorElement);
			$first = false;
		}
		else loadSplash("," . $vectorElement);
	}
	loadSplash (");");  
	dbQuery ("insert into lastSplash values (getDate())");
}
function loadSplash($val) {
	$value = str_replace ("'", "''", $val);
	dbQuery ("insert into lastSplashText (splashText) values ('$value')");
}


function generateMarkerArray() {
	$lang = 'fr';
	  $statusArray = array();
	  // index is patientStatus, associative value is column in final report
	  $statusMap = array(0 => 11, 1 => 9, 2 => 5, 3 => 0, 4 => 7 , 5 => 2,  6 => 6,  7 => 1, 8 => 8,  9 => 4, 10 => 3);  
	  $result = database()->query('
	select siteCode, case when p.patientStatus between 1 and 10 then p.patientStatus else 0 end as patientStatus, count(distinct e.patientid) as patientid
	from encounter e join patient p using (patientid)
	where e.encStatus < 255 and p.patStatus = 0 
	group by siteCode, p.patientStatus;');
	  while ($row = $result->fetch()) {
	    if (!array_key_exists($row['siteCode'], $statusArray)) {
	      $statusArray[$row['siteCode']] = array(0,0,0,0,0,0,0,0,0,0,0);
	    }
	    $statusArray[$row['siteCode']][$statusMap[$row['patientStatus']]] = $row['patientid'];
	  }

	  $result = database()->query('
	select clinic, siteCode, c.dbSite, dbVersion, lat, lng, commune, max(date(lastmodified)) as maxDate
	from encValid e join clinicLookup c using (siteCode)
	where lat != 0
	 and lng != 0
	 and lat is not null
	 and lng is not null
	group by clinic, siteCode, c.dbSite, dbVersion, lat, lng, commune;');
	  // format row results
	  $outputTexts = array(); 
	  $iconBase = "images/mm_20_"; 
	  while ($row = $result->fetch()) {
	    $hiv = $statusArray[$row['siteCode']][0] + $statusArray[$row['siteCode']][1] + $statusArray[$row['siteCode']][2] + $statusArray[$row['siteCode']][3] + $statusArray[$row['siteCode']][4];
	    $hivArt = $statusArray[$row['siteCode']][5] + $statusArray[$row['siteCode']][6] + $statusArray[$row['siteCode']][7] + $statusArray[$row['siteCode']][8] + $statusArray[$row['siteCode']][9];
	    $other = $statusArray[$row['siteCode']][11];
	    $grandTotal = $hiv + $hivArt + $other;
	    if ($row['dbSite'] == 0) $icon = $iconBase . "blue.png";
	    else $icon = $iconBase . "green.png";
	    $clinicNoApostrophes = str_replace('\'', ' ', $row['clinic']); #thats a right single quote
	    $desc = $clinicNoApostrophes . '<br />' . $row['maxDate'] . '<br />' . $row['commune'] . '<table border="1">';
	    $desc .= '<tr><td>' . _('VIH soins palliatifs') . '</td><td align="right">' . $hiv . '</td></tr> <tr><td>' . _('VIH soins TAR') . '</td><td align="right">' . $hivArt . '</td></tr> <tr><td>' . _('Autre') . '</td><td align="right">' . $other . '</td></tr> <tr><td>' . _('Totaux') . '</td><td align="right">' . $grandTotal . '</td></tr> </table>';
	    $outputTexts[] = "{
			lat: $row[lat],
			lng: $row[lng],
			marker: {
				title: '" . $clinicNoApostrophes . "', 
				icon: '" . $icon . "',
				infoWindow: {content: '" . $desc . "'}
				}
			}";
	  }

	  database()->exec('lock tables lastMarkers2 write;');
	  database()->exec('delete from lastMarkers2;');
	  database()->query('insert into lastMarkers2 values (now(), ?)', array(implode(",\n", $outputTexts)));
	  database()->exec('unlock tables;');
} 

/* Once a day (patientStatusBatch.php) switch isPediatric from 1 to 0 if patient is >= 15 ans
 * Currently does fully defined birth dates, year/month assuming 01 if days is XX, year only if month and day are XX
 * because many birthdates are in the database with 19 when it should be 20 (i.e. 1910 instead of 2010), the range of dates is between 15 and 50, rather than just >= 15
 * we might want to have a report to flag these for correction???
 */
function pediatricToAdult () {
	$qry = "update patient set ispediatric = 0 where ispediatric = 1 and (
		(upper(dobyy) != ? and upper(dobmm) != ? and upper(dobdd) != ? and isdate(ymdtodate(dobyy,dobmm,dobdd)) = 1 and datediff(now(), ymdToDate(dobyy,dobmm,dobdd))/365.242199 between 15 and 50) or
		(upper(dobyy) != ? and upper(dobmm) != ? and upper(dobdd) = ? and isdate(ymdtodate(dobyy,dobmm, ?)) = 1 and datediff(now(), ymdToDate(dobyy,dobmm, ?))/365.242199 between 15 and 50) or
		(upper(dobyy) != ? and upper(dobmm) = ? and upper(dobdd) = ? and isnumeric(dobyy) = 1 and year(now())-dobyy between 15 and 50)
		)";
	return database()->query($qry,array('XXXX','XX','XX','XXXX','XX','XX','01','01','XXXX','XX','XX'))->rowCount(); 
}

/*
 * This function executes the fpmerge process which updates the local database with fingerprint data from the national database
 * the goal is to deduplicate patients based on Fingerprints
 */
function mergeFingerprintData($file) {
    
    // Expected DuplicateTemplateFound.log location uploaded from fingerprint local database by hybrid_detamerger.cmd
    $DuplicateFileLocation = "/var/backups/itech/fpDuplicateLogs/".$file;
    
    // If file exists
    if (file_exists ($DuplicateFileLocation)) {
    
        // Access DuplicateTemplateFound.log file to find duplicates
        $handle = fopen($DuplicateFileLocation,"r");

        $DuplicateIDs = array();
        $PatientIDFound = 0;
        $PatientID = 0;
        $masterPid = 0;

        // Read the output file "DuplicateTemplateFound.log" from the hybrid_datamerger.exe to find duplicate IDs 
        while (($buffer = fgets($handle, 4096)) !== false) {
                // If we have already found a Duplicate PatientID line, we expect to find a MasterID line
            if($PatientIDFound == 1) {
                if (preg_match('/Found ID is : (?P<masterPid>\d*)./', $buffer, $matches)) {
                    $masterPid = $matches['masterPid'];
                    $DuplicateIDs[$PatientID] = $masterPid;
                }
                // In any case we tell the parser that the line has been treated and it should start anew
                $PatientIDFound = 0;
            }
            // Parsing line to see if it is a Duplicate Patient ID line    
            if (preg_match('/For Registration ID \((?P<patientID>\d*)\), Duplicate Data found./', $buffer, $matches)) {
                $PatientID = $matches['patientID'];
                $PatientIDFound = 1;
            } else {
                $PatientIDFound = 0;
            }
        }
        fclose($handle);

        // Update local database based on found duplicates
        foreach($DuplicateIDs as $patientID => $masterPid) {

            //Update patient.masterPID with value from file
            $qry = "UPDATE patient SET masterPid = ? WHERE patientID = ?";
            $rowCnt = database()->query($qry,array($masterPid,$patientID));
            if ($rowCnt == 0) { 
                echo '{"success":"false","message":"update failed for ' . $patientID . ' to masterPid: '. $masterPid .'","data":"xxx"}';
            }  

            //Update registration record with current date so that masterPID is pushed to consolidated DB
            $qry = "UPDATE encounter SET lastModified = now() WHERE patientID = ? AND encounterType in (10,15)";
            $rowCnt = database()->query($qry,array($patientID));

            // change the fingerprint key from REGISTRATIONNO to patientID
            if (changeFingerprintID($patientID, $masterPid) == false) {
                echo " - Failed to change fingerprint key, something wrong, quitting...<br/>";
            }
        }

        // It seems useful to rename the DuplicateTemplateFound.log file upon completion to archive it
        $old = '/var/backups/itech/fpDuplicateLogs/'.$file;
        $new = '/var/backups/itech/fpDuplicateLogs/processed/'.$file;
        rename($old, $new) or die("Unable to copy $old to $new.");
        
        // Logs event in table eventLog and saves duplicateIDs
        recordEvent('fpmerge',$DuplicateIDs);
        
    } else {
        echo "No file to merge found at expected location: $DuplicateFileLocation";
    }
}




function generatePatientAlert() {

database()->exec('truncate table patientAlert');

/* Generate viralLoadTemp */
database()->exec('DROP TABLE IF EXISTS viralLoadTemp');
database()->query('CREATE TABLE viralLoadTemp SELECT distinct patientid, date(ymdToDate(visitdateyy,visitDateMm,visitDateDd)) as visitDate, result+0 as result, date(?) as maxDate 
FROM labs WHERE labID IN (103, 1257) and isNumeric(result) = 1 AND result+0 > 0',array("2016-01-01"));
database()->exec('CREATE INDEX iViral ON viralLoadTemp (patientid,visitdate)');
database()->exec('UPDATE viralLoadTemp A, (select patientID, max(visitDate) as maxDate FROM viralLoadTemp B GROUP BY 1) B set A.maxDate = B.maxDate where A.patientID = B.patientID');

/* Generate arvStartedTemp */
database()->exec('DROP TABLE IF EXISTS arvStartedTemp');
database()->exec('CREATE TABLE arvStartedTemp SELECT patientID, DATE(MIN(visitDate)) AS arvDate
FROM pepfarTable GROUP BY 1');
database()->exec('ALTER TABLE arvStartedTemp ADD PRIMARY KEY (patientID)');

/* Any patients 6 months after ART initiation NB. we also remove patient that are a viral load after six months of arv initiation. */
database()->exec('INSERT INTO patientAlert(siteCode,patientID,alertId,insertDate)
SELECT DISTINCT LEFT(A.patientid,5), A.patientID, 1, date(now()) FROM arvStartedTemp A LEFT JOIN viralLoadTemp B
ON A.patientID=B.patientID and visitDate >= arvDate 
where arvDate <= DATE_ADD(now(), INTERVAL -6 MONTH)');

/*Any patients 5 months after ART initiation */
database()->exec('INSERT INTO patientAlert(siteCode,patientID,alertId,insertDate)
SELECT DISTINCT LEFT(A.patientid,5), A.patientID, 2, date(now()) FROM arvStartedTemp A LEFT JOIN viralLoadTemp B
on A.patientID = B.patientID and visitDate >= arvDate
where arvDate > DATE_ADD(now(), INTERVAL -6 MONTH) and arvDate<= DATE_ADD(now(), INTERVAL -5 MONTH)');

/* Any pregnant woman 4 months after ART initiation */
database()->exec('INSERT INTO patientAlert(siteCode,patientID,alertId,insertDate)
SELECT DISTINCT LEFT(A.patientid,5), A.patientID, 3, date(now()) FROM arvStartedTemp A JOIN dw_pregnancy_ranges B ON A.patientID=B.patientID and A.arvDate between B.startDate and B.stopDate
LEFT JOIN viralLoadTemp C ON A.patientID=C.patientID and C.visitDate >= A.arvDate
where arvDate <= DATE_ADD(now(), INTERVAL -4 MONTH) and C.patientID is null');	

/* Any patient whose last viral load test was performed 12 months’ prior */
database()->exec('INSERT INTO patientAlert(siteCode,patientID,alertId,insertDate)
SELECT DISTINCT A.location_id, A.patientID, 4, date(now()) from patient A join viralLoadTemp B ON A.patientID = B.patientID 
WHERE A.hivPositive = 1 AND B.maxDate <= DATE_ADD(now(), INTERVAL -12 MONTH)');	

/* Any patient including pregnant women whose viral test result was greater than 1000 copies and was performed 3 months ago */
database()->exec('INSERT INTO patientAlert(siteCode,patientID,alertId,insertDate)
SELECT DISTINCT left(patientid,5), patientID, 5, date(now())
FROM viralLoadTemp 
WHERE maxDate = visitDate AND maxDate <= DATE_ADD(NOW() , INTERVAL -3 MONTH ) AND result > 1000');

/* Any patient whose viral test result was greater than 1000 copies */
database()->exec('INSERT INTO patientAlert(siteCode,patientID,alertId,insertDate)
SELECT DISTINCT left(patientid,5), patientID, 6, now()
FROM viralLoadTemp WHERE maxDate = visitDate AND result > 1000');
}

?>
