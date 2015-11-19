<?php
include_once('backend.php');
$isarv = array_key_exists('arv', $_GET) ? $_GET['arv'] : null;
$querypid = array_key_exists('query', $_GET) ? $_GET['query'] : null;
$site = $_REQUEST['site'];
$lang = array_key_exists('lang', $_GET) ? $_REQUEST['lang'] : null;
$ARVreason = array (
	"fr" => array (
		'cd4LT200' => "CD4 inf&#xe9;rieur au seuil",
		'tlcLT1200' => "TLC < 1200",
		'WHOIII' => "OMS Stade III + CD4 inf&#xe9;rieur au seuil",
		'WHOIV' => "OMS Stade IV",
		'PMTCT' => "PTME",
		'medEligHAART' => "&eacute;ligibilit&eacute; m&eacute;dicale &eacute;tablie ",
		'estPrev' => "&eacute;ligibilit&eacute; m&eacute;dicale &eacute;tablie &aacute; la visite ant&eacute;rieure",
		'former' => "ARV trith&eacute;rapie ant&eacute;rieure",
		'PEP' => "Prophylaxie post-exposition (PEP)"),
		'coinfectionTbHiv' => "Coinfection TB/HIV",
		'coinfectionHbvHiv' => "Coinfection HBV/HIV",
		'coupleSerodiscordant' => "Couple sérodiscordant",
		'pregnantWomen' => "Femme enceinte (Grossesse)",
		'breastfeedingWomen' => "Femme allaitante",
		'ChildLT5ans' => "Enfant avec âge < 5ans",
		'patientGt50ans' => "Patient avec âge  > 50 ans",
		'nephropathieVih' => "Néphropathie à VIH",
                'protocoleTestTraitement' => 'Protocole Test et traitement')
	"en" => array(
		'cd4LT200' => "CD4 below threshold",
		'tlcLT1200' => "TLC < 1200",
		'WHOIII' => "WHO Stage III + CD4 below threshold",
		'WHOIV' => "Who Stage IV",
		'PMTCT' => "PMTCT",
		'medEligHAART' => "Eligibility established ",
		'estPrev' => "Eligibility established in a previous visit",
		'former' => "Prior ARV therapy",
		'PEP' => "Prophylaxis post-exposition (PEP)",
		'coinfectionTbHiv' => "Coinfection TB/HIV",
		'coinfectionHbvHiv' => "Coinfection HBV/HIV",
		'coupleSerodiscordant' => "HIV negative stable partner",
		'pregnantWomen' => "pregnant women",
		'breastfeedingWomen' => "breastfeeding women",
		'ChildLT5ans' => "Child < 5 years",
		'patientGt50ans' => "Adult > 50 years",
		'nephropathieVih' => "Néphropathie à VIH",
                'protocoleTestTraitement' => 'Testing and treatment protocol' )
);

$line = array(
	"d4T-3TC-NVP" => 1,
	"d4T-3TC-EFV" => 1,
	"ZDV-3TC-NVP" => 1,
	"ZDV-3TC-EFV" => 1,
	"ZDV-ddI-IDV" => 1,
	"ZDV-ddI-NFV" => 1,
	"FTC-TNF-EFV" => 1,
	"ZDV-ddI-LPV/r" => 2,
	"d4T-ddI-LPV/r" => 2,
	"d4T-ddI-NFV" => 2
);

$functionalStatus1 = array (
   "en" => array (
   "",
	"<b>Working</b>",
	"<b>Ambulatory</b>",
	"",
	"<b>Bedridden</b>"),
   "fr" => array (
	"",
	"<b>Capable de travailler</b>",
	"<b>Ambulatoire</b>",
	"",
	"<b>Alit&#xe9;</b>")
);

// saving the changes!!!!

function saveData(){
    $records = json_decode(stripslashes($_POST['data']),true);
	for($i = 0; $i < sizeof($records); $i++){
		$entry = $records[$i];
		switch($entry["sex"]){
			case "Inconnu":
				$sex = 0;
				break;
			case "Homme":
				$sex = 2;
				break;
			case "Femme":
				$sex = 1;
				break;
		}
		$dob = new DateTime($entry['dob']);
		$day = date_format($dob,'d');
		$month = date_format($dob,'m');
		$year = date_format($dob,'Y');
		$qry = "UPDATE patient set lname = '".$entry['lname']."',nationalID = '".$entry['natID']."', dobDd = '".$day."',dobMm = '".$month."',dobYy = '".$year."', sex = ".$sex.", addrDistrict = '".$entry['Address']."',addrSection = '".$entry['Address2']."', addrTown = '".$entry['Address3']."',fname = '".$entry['fname']."' where patientID = '".$entry['patientID']."';";
		$result = dbQuery($qry);
	}
	echo '{success: true}';
}

function addData(){
	$demo = array();
	$demo['lname'] = $_POST['lname'];
	$demo['fname'] = $_POST['fname'];
	$demo['clinicPatientID'] = $_POST['stID'];
	$demo['addrDistrict'] = $_POST['Address'];
	$demo['addrSection'] = $_POST['Address2'];
	$demo['addrTown'] = $_POST['Address3'];
	$demo['nationalID'] = $_POST['natID'];
	
	switch(trim($_POST["sex2"])){
		case "Inconnu":
			$sex = 0;
			break;
		case "Homme":
			$sex = 2;
			break;
		case "Femme":
			$sex = 1;
			break;
	}
	
	$demo['sex'] = $sex;
	
	$dob = explode('/', $_POST['dob']);
	$dayd = $dob[0];
	$monthd = $dob[1];
	$yeard = $dob[2];
	
	$demo['dobMm'] = $monthd;
	$demo['dobYy'] = $yeard;
	$demo['dobDd'] = $dayd;
	
	$conf = explode('/', $_POST['HIVdate']);
	$day = $conf[0];
	$month = $conf[1];
	$year = $conf[2];
	$year = substr($year, -2);
	
	$pid = addPatient($_GET['site'],$demo);	
	if ($pid){
		dbQuery("update patient set hivPositive = 1 where patientID = '" . $pid . "'");
	}	
	/*   stID is figured out in addPatient -- no need to do it here
	 *** $stid = preg_replace('/[^0-9]/', '',$_POST['stID']);
	 *** $qry = "update patient set stid = case when isnumeric(".$stid.") = 1 then convert(float, ".$stid.") else 0 end where patientid = '".$pid."' ";
	 *** dbQuery($qry);
	 */
	
	$eid = addEncounter($pid, $day, $month, $year, $_GET['site'], date ("Y-m-d H:i:s"), 10, '', '', '', '', '', '', '', 1, getSessionUser(), date ("Y-m-d H:i:s") );
	if($eid){
		$qry2 = "update encounter set isRegistry = 1 where encounter_id = ".$eid." ";
		dbQuery($qry2);
	}
	echo '{success: true}';
}

if(empty($_GET['ac']) && empty($_GET['regType'])){
	$arr = array();
	$entry = array();

	$qry_count = "select count(patientid) from patient where left(patientid,5) = '" . $site . "'";
	$result_count = dbQuery($qry_count);
	while($row =  psRowFetch($result_count)){
	$rows = $row[0];
	}
	if (!empty($_GET['query'])){
	$id = $_GET['query'];
	$id_other = $_GET['query'];
	}else{
	$id = 'ST000-001';
	$id_other = 'ST000001';
	}
	
	
	if($isarv){
		$qryin = " SELECT TOP 1 stid from patient p, encounter v where p.patientid = v.patientid and patientStatus in (1,2,4,6,8) and isnumeric(stid) = 1 and left(p.patientid,5) = '".$site."' and (clinicPatientID like '%".$id."%' OR clinicPatientID like '%".$id_other."%') ORDER BY 1";
	}else{
		$qryin = " SELECT TOP 1 stid from patient p, encounter v where p.patientid = v.patientid and isnumeric(stid) = 1 and left(p.patientid,5) = '".$site."' and (clinicPatientID like '%".$id."%' OR clinicPatientID like '%".$id_other."%' ) ORDER BY 1";
	}
	
	$resultpid = dbQuery($qryin);
	$startpid = psRowFetch($resultpid);
	$id2 = $startpid['stid'];
	if(trim($id2) === ''){
	$id2 =1;
	}
	//---------------Build pid list/Demographics info (from the patient table)----------------------------
	if($isarv){
		$qry = " SELECT distinct TOP 10 stid, patientID, siteCode, clinicPatientID, fnameMother, sex, nationalID, lname, fname, ageYears, sex, addrDistrict, addrSection, addrTown, dobDd, dobMm, dobYy FROM v_patients where patientStatus in (1,2,4,6,8) and sitecode = " . $site . " and stid >= " . $id2 . " and isnumeric(stid) = 1 ORDER BY 1";
	}else{
		$qry = "select distinct TOP 10 stid, clinicPatientID, patientID, siteCode, fnameMother, sex, nationalID, lname, fname, ageYears, addrDistrict,addrSection,addrTown, dobDd, dobMm, dobYy FROM v_patients where sitecode = '".$site."' and  stid >= ".$id2." and isnumeric(stid) = 1 order by 1";
	}
	
	$result = dbQuery($qry);
	
	$pidAr = array();
	$stid = array();
	$pids = '';
	while($row = psRowFetch($result)){
		$stid[$row['patientID']] = $row['clinicPatientID'];
		$pidAr[] = $row['patientID'];
		$pids .= "'".$row['patientID']."',";
		${'p'.$row['patientID']} = array();
		${'p'.$row['patientID']}['stID'] = $stid[$row['patientID']];
		${'p'.$row['patientID']}['natID'] = $row['nationalID'];
		${'p'.$row['patientID']} = array_merge(${'p'.$row['patientID']},$row);
		$dob = zpad (trim($row['dobMm']), 2) . "/" . zpad (trim ($row['dobDd']), 2) . "/" . zpad (trim ($row['dobYy']), 2);
		${'p'.$row['patientID']}['dob'] = $dob;
		switch($row["sex"]){
		case 0:
			${'p'.$row['patientID']}["sex"] = "Inconnu";
			break;
		case 1:
			${'p'.$row['patientID']}["sex"] = "Femme";
			break;
		case 2:
			${'p'.$row['patientID']}["sex"] = "Homme";
			break;
		}
		$age = $row['ageYears'];
				
		//if age is not defined calculate from years
		if( !isset($age) || $age == '' || $age <= '15'){
			if( $row['dobYy'] != '    '){
				$age = date ('Y') - intval($row['dobYy']);
				//echo "BIRTHYEAR: " . $row['dobYy'];
				${'p'.$row['patientID']}["ageYears"] = $age; 
			}
		}
		
		if( $age != ''){
			switch($age){
				case 0:
					${'p'.$row['patientID']}["under1m"] = 1;
					break;
				case 1:
				case 2:
					${'p'.$row['patientID']}["1to2"] = 1;
					break;
				case 3:
				case 4:
					${'p'.$row['patientID']}["2to4"] = 1;
					break;
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
				case 11:
				case 12:
				case 13:
				case 14:
					${'p'.$row['patientID']}["5to14"] = 1;
					break;
				default:
					${'p'.$row['patientID']}["over15"] = 1;
					break;
			}
		}
	}
	$pids = substr($pids, 0, -1);

	//--------------Date ART Started----------------------------------------------------both

	$startArray = array();
	$qryARTstart = "SELECT patientid,MIN(visitDate) AS ARTstart FROM pepfarTable WHERE patientid IN (".$pids.") AND (forPepPmtct = 0 OR forPepPmtct IS NULL) GROUP BY patientid";
	$resulta = dbQuery($qryARTstart);
	while($artstart = psRowFetch($resulta)){
	$date = $artstart['ARTstart'];
	$created = new DateTime($date);
	$format= date_format($created,'m/d/Y');
	$startArray[$artstart['patientid']] = $format;
	${'p'.$artstart['patientid']}['ARTstart'] = $format;
	}
	
//---------------due date if pregnant---------------------------------both
	dbQuery("create table #preg (lmpdate datetime, patientid varchar(11))");
	dbQuery(" insert into #preg (lmpdate, patientid) select max(dbo.ymdToDate(pregnantLmpYy, pregnantLmpMm, pregnantLmpDd )), patientID from v_vitals where pregnant = 1 and isdate(dbo.ymdToDate(pregnantLmpYy, pregnantLmpMm, pregnantLmpDd )) = 1 group by patientid");
	dbQuery(" insert into #preg (lmpdate, patientid) select max(dbo.ymdToDate(pregnantLmpYy, pregnantLmpMm, '01' )), patientID from v_vitals where pregnant = 1 and isdate(dbo.ymdToDate(pregnantLmpYy, pregnantLmpMm, '01' )) = 1 and patientid not in (select patientid from v_vitals where pregnant = 1 and isdate(dbo.ymdToDate(pregnantLmpYy, pregnantLmpMm, pregnantLmpDd )) = 1) group by patientID");
	$qrypreg = "select lmpdate, patientID from #preg where patientID in (".$pids.")";
	$resultp = dbQuery($qrypreg);
	while($preg = psRowFetch($resultp)){
	  $date = $preg['lmpdate'];
	  $created = new DateTime($date);
	  $created -> modify("+40 weeks");
	  $format= date_format($created,'m/d/Y');
	${'p'.$preg['patientID']}['pregduedate'] = $format;
	}

	//---------------HIV confirmed date (from the vitals table)----------------------------both

	dbQuery("create table #hivconf (confdate datetime, patientid varchar(11))");
	dbQuery(" insert into #hivconf (confdate, patientid) select max(dbo.ymdToDate(firstTestYy, firstTestMm, firstTestDd )), patientID from v_vitals where isdate(dbo.ymdToDate(firstTestYy, firstTestMm, firstTestDd )) = 1 and patientid in  (".$pids.") group by patientid");
	dbQuery(" insert into #hivconf (confdate, patientid) select max(dbo.ymdToDate(firstTestYy, firstTestMm, '01' )), patientID from v_vitals where isdate(dbo.ymdToDate(firstTestYy, firstTestMm, '01' )) = 1 and patientid in  (".$pids.") group by patientID");
	dbQuery(" insert into #hivconf (confdate, patientid) select max(dbo.ymdToDate(repeatTestYy, repeatTestMm, repeatTestDd )), patientID from v_vitals where isdate(dbo.ymdToDate(repeatTestYy, repeatTestMm, repeatTestDd )) = 1 and patientid in  (".$pids.") group by patientid");
	dbQuery(" insert into #hivconf (confdate, patientid) select max(dbo.ymdToDate(repeatTestYy, repeatTestMm, '01' )), patientID from v_vitals where isdate(dbo.ymdToDate(repeatTestYy, repeatTestMm, '01' )) = 1 and patientid in  (".$pids.") group by patientID");
	$qryconfHIV = " select confdate as tdate, patientID from #hivconf where patientID in (".$pids.") order by 2,1";

	$result3 = dbQuery($qryconfHIV);
	while($hiv = psRowFetch($result3)){
	$date = $hiv['tdate'];
	$created1 = new DateTime($date);
	$hivposformat= date_format($created1,'m/d/Y');

	if(trim($hiv['tdate']) !== '') ${'p'.$hiv['patientID']}['hivposdate'] = $hivposformat;
	}

	if (!$isarv) {
		//---------------PPD results----------------------------preARV

		$qryppd = "SELECT visitdate,patientID,result, resultAbnormal FROM v_labs WHERE patientID IN (".$pids.") AND  labID IN (130,172) order by 2,1 ;";
		$resultppd = dbQuery($qryppd);
		while($ppd = psRowFetch($resultppd)){
			$date =$ppd['visitdate'];
			$created1 = new DateTime($date);
			$ppddate= date_format($created1,'m/d/Y');
			${'p'.$ppd['patientID']}['ppddate'] = $ppddate;

			switch($ppd['result']){
				case '1':
					${'p'.$ppd['patientID']}['ppdpos'] = 1;
					break;
				case '2':
					${'p'.$ppd['patientID']}['ppdneg'] = 1;
					break;
			}
		}


		$qrybacc = "SELECT visitdate,patientID,result,resultAbnormal FROM v_labs WHERE patientID IN (".$pids.") AND  labID IN (169) order by 2,1 ;";
		$resultbacc = dbQuery($qrybacc);
		while($bacc = psRowFetch($resultbacc)){
			$date =$bacc['visitdate'];
			$created1 = new DateTime($date);
			$baccdate= date_format($created1,'m/d/Y');
			${'p'.$bacc['patientID']}['baccdate'] = $baccdate;
			switch($bacc['result']){
				case '1':
					${'p'.$bacc['patientID']}['baccpos'] = 1;
					break;
				case '2':
				case '4':
					${'p'.$bacc['patientID']}['baccneg'] = 1;
					break;
			}
			if($bacc['resultAbnormal'] === '1'){
				${'p'.$bacc['patientID']}['baccpos'] = 1;
			}
		}

		//----------------Date enrolled in HIV care----------------------preARV
	  dbQuery("create table #hivstart (sdate datetime, patientid varchar(11))");
	  dbQuery(" insert into #hivstart (sdate, patientid) select min(dbo.ymdToDate(visitDateYy, visitDateMm, visitDateDd )), patientID from encounter where encounterType IN (10,15) and isdate(dbo.ymdToDate(visitDateYy, visitDateMm, visitDateDd )) = 1 group by patientid");
	  $qryHIVstart = " select sdate as HIVdate, patientID from #hivstart where patientid in (".$pids.")";

	  $resulthivstart = dbQuery($qryHIVstart);
	while($hivstart = psRowFetch($resulthivstart)){
	$date = $hivstart['HIVdate'];
	$created = new DateTime($date);
	$format= date_format($created,'m/d/Y');
	${'p'.$hivstart['patientID']}['HIVdate'] = $format;
	}

	//----------------Date eligible and selected----------------------preARV
	$qryelig = "Select min(visitdate) as visitdate, patientID FROM v_arvEnrollment WHERE patientID IN (".$pids.") AND arv = 1 group by patientID;";

	$resultelig = dbQuery($qryelig);
	while($elig = psRowFetch($resultelig)){
	$date = $elig['visitdate'];
	$created = new DateTime($date);
	$format= date_format($created,'m/d/Y');
	${'p'.$elig['patientID']}['commDate'] = $format;
	}

	//----------------Date died, lost to follow-up, or transfer----------------------preARV
	$qryds = "Select * FROM discTable WHERE patientid IN (".$pids.") AND discType IN (5,11,12);";
	$resultds = dbQuery($qryds);
	while($ds = psRowFetch($resultds)){
	$date = $ds['discDate'];
	$createdd = new DateTime($date);
	$formatd= date_format($createdd,'m/d/Y');

	switch($ds['discType']){
		case '5':
			${'p'.$ds['patientid']}['lost'] = $formatd;
			break;
		case '11':
			${'p'.$ds['patientid']}['transfer'] = $formatd;
			break;
		case '12':
			${'p'.$ds['patientid']}['death'] = $formatd;
			break;
	}
	}

	//-----------------------who stage dates ----------------------------------------------preARV
	$qryWhostage = "SELECT MIN(visitDate) as visitdate,whoStage,patientID FROM v_conditions WHERE patientID IN (".$pids.") and whoStage LIKE '%Stage%' group by whoStage,patientID";
	$resultstage = dbQuery($qryWhostage);
	$oldpid = '';
	while($stage = psRowFetch($resultstage)){
		if($oldpid !== $stage['patientID']){
			$stage1 = '';
			$stage2 = '';
			$stage3 = '';
			$stage4 = '';
		}

		$date = new DateTime($stage['visitdate']);
		$format= date_format($date,'m/d/Y');
		switch($stage['whoStage']){
			case 'Stage I':
				$stage1 = $format;
				break;
			case 'Stage II':
				$stage2 = $format;
				break;
			case 'Stage III':
				$stage3 = $format;
				break;
			case 'Stage IV':
				$stage4 = $format;
				break;
		}

		if( $stage1 === $stage2 || $stage1 === $stage3 || $stage1 === $stage4){
			${'p'.$stage['patientID']}['stage1'] = '';
		}else{
			${'p'.$stage['patientID']}['stage1'] = $stage1;
		}

		if( $stage2 === $stage3 || $stage2 === $stage4){
			${'p'.$stage['patientID']}['stage2'] = '';
		}else{
			${'p'.$stage['patientID']}['stage2'] = $stage2;
		}

		if( $stage3 === $stage4){
			${'p'.$stage['patientID']}['stage3'] = '';
		}else{
			${'p'.$stage['patientID']}['stage3'] = $stage3;
		}

		${'p'.$stage['patientID']}['stage4'] = $stage4;

			$oldpid = $stage['patientID'];
		}
	
	}
	
	//---------------FLUC 14, CTX 9, INH 18, (from the drugs table)----------------------------both
	$qryDrugs = "SELECT case when stopYy != '' then 'stop' else 'start' end as type, visitdate ,patientID,drugid, startMm, startYy, stopMm, stopYy FROM v_drugs WHERE patientID IN (".$pids.") and  drugid in (14,9,18) order by 3,2"; //echo $qryDrugs;
	$result4 = dbQuery($qryDrugs);
	while($drugs = psRowFetch($result4)){
		$date = $drugs['visitdate'];
		$created = new DateTime($date);
		$format= date_format($created,'m/d/Y');
		switch($drugs['drugid']){
			case '14':
				if($drugs['type'] === 'start'){
					${'p'.$drugs['patientID']}['Flucstart'] = $format;
				}else if($drugs['type'] === 'stop'){
					${'p'.$drugs['patientID']}['Flucstop'] = $format;
				}
				break;
			case '9':
				if($drugs['type'] === 'start'){
					${'p'.$drugs['patientID']}['CTXstart'] = $format;
				}else if($drugs['type'] === 'stop'){
					${'p'.$drugs['patientID']}['CTXstop'] = $format;
				}
				break;
			case '18':
				if($drugs['type'] === 'start'){
					${'p'.$drugs['patientID']}["INHstart"] = $format;
				}else if($drugs['type'] === 'stop'){
					${'p'.$drugs['patientID']}["INHstop"] = $format;
				}
				break;
		}
	}
	
	if($isarv){
		//--------------STage start ART and last CD4----------------------------------------------------ARV
		$switch = true;
		$qryARTstage = '';
		$qryTrack = '';
		$qryLastCD4 = '';
		foreach($startArray as $pid=>$start){
			$threem = $start;
			$threem = new DateTime($threem);
			$threem -> modify("-3 months");
			$three = date_format($threem, "Y-m-d");
			$startArray = explode('-',$three);

			$start = "dbo.ymdToDate(".$startArray[0].", ".$startArray[1].", ".$startArray[2].")";

			
			if(!$switch){
				$qryARTstage .= "union (select TOP 1 whoStage,patientid,visitdate from v_conditions where patientid = '".$pid."' and visitdate >= " . $start . ")";
				$qryLastCD4 .= "union (select patientid, max(visitdate) as visitdate,cd4 from cd4Table where patientid = '".$pid."' and visitdate <= '".$three."'  group by patientid,cd4) ";
				$qryTrack .= "union (select ". $start ." as start,'func' as type, CONVERT(varchar(20),functionalStatus) as result,patientid, visitdate from v_vitals where patientid = '".$pid."' and functionalStatus != 0 and visitdate >= ".$start.")
				union
				(select ". $start ." as start,'cd4', CONVERT(varchar(20),cd4) as result,patientid,visitdate from cd4Table where patientid = '".$pid."' and visitdate >= ". $start ." )
				union
				(select ". $start ." as start,'reg', regimen,patientid,visitdate from pepfarTable where patientid = '".$pid."' and visitdate >= ". $start ." AND (forPepPmtct = 0 OR forPepPmtct IS NULL)) ";
			}else{
				$qryARTstage .= "(select TOP 1 whoStage,patientid,visitdate from v_conditions where patientid = '".$pid."' and visitdate >= ". $start .") ";
				$qryLastCD4 .= "(select patientid,max(visitdate)as visitdate,cd4 from cd4Table where patientid = '".$pid."' and visitdate <= '".$three."' group by patientid,cd4) ";
				$qryTrack .= " (select  ".$start." as start,'func' as type, CONVERT(varchar(20),functionalStatus) as result,patientid, visitdate from v_vitals where patientid = '".$pid."' and functionalStatus != 0 and visitdate >= ". $start .")
				union
				(select ".$start." as start,'cd4' as type, CONVERT(varchar(20),cd4) as result,patientid,visitdate from cd4Table where patientid = '".$pid."' and visitdate >= ".$start.")
				union
				(select ".$start." as start,'reg', regimen,patientid,visitdate from pepfarTable where patientid = '".$pid."' and visitdate >= ".$start." AND (forPepPmtct = 0 OR forPepPmtct IS NULL)) ";
			}
			$switch = false;
		}
		echo "/* $qryTrack */";
		if(trim($qryARTstage) !== '') {
			$qryARTstage .= "ORDER BY 3,1 ASC";
			$resultar = dbQuery($qryARTstage);
			while($artstage = psRowFetch($resultar)){
				${'p'.$artstage['patientid']}['stageStartART'] = $artstage['whoStage'];
			}
		}
		if(trim($qryLastCD4) !== '') {
			$qryLastCD4 .= "ORDER BY 2 ASC";
			$resultcd4 = dbQuery($qryLastCD4);
			while($cd4 = psRowFetch($resultcd4)){
				${'p'.$cd4['patientid']}['lastCD4'] = $cd4['cd4'];
			}
		}
		//echo ($qryTrack);
		if(trim($qryTrack) !== '') {
			$qryTrack .= "ORDER BY 4,5";
			$resultTrack = dbQuery($qryTrack);
			$oldpid = '';
			while($track= psRowFetch($resultTrack)){
				if($oldpid !== $track['patientid']){
					$j = 2;
					$k = 1;
					$old = '';
				}
				$s = strtotime($track['start']);
				$t = strtotime($track['visitdate']);
				//echo $track['start']."$$$".$track['visitdate']." ";
				$dateDiff = floor(($t-$s)/2628000);
				if($track['type'] !== 'reg'){
					if( $dateDiff <= 5){
						$dateDiff = 0;
					}else if($dateDiff > 5 && $dateDiff <= 11){
						$dateDiff = 6;
					}else if($dateDiff > 11 && $dateDiff <= 17){
						$dateDiff = 12;
					}else if($dateDiff > 17 && $dateDiff <= 23){
						$dateDiff = 18;
					}else if($dateDiff > 23 && $dateDiff <= 27){
						$dateDiff = 24;
					}
				}
				if($track['type'] === 'reg' && $dateDiff < 1){
					${'p'.$track['patientid']}['1reg1'] = $track['result'];
				}
				if($oldpid === $track['patientid'] && $old !== $track['result']  && trim($old) !== '' && $track['type'] === 'reg'){
					$result = "<span style=\"color:#8FBC8F;\">".$track['result']." ".$old." </span>";
					$temp = new DateTime($track['visitdate']);
					$format= date_format($temp,'m/d/Y');
					if($line[$track['result']] == 1){
						${'p'.$track['patientid']}['1reg'.$j] = $track['result'];
						${'p'.$track['patientid']}['1reg'.$j.'date'] = $format;
						$j++;
					}else{
						${'p'.$track['patientid']}['2reg'.$j] = $track['result'];
						${'p'.$track['patientid']}['2reg'.$j.'date'] = $format;
						$k++;
					}
					${'p'.$track['patientid']}[$track['type'].$dateDiff] = $track['result'];
				}else if($track['type'] === 'func'){
					${'p'.$track['patientid']}[$track['type'].$dateDiff] = $functionalStatus1['fr'][$track['result']];
				}else{
					${'p'.$track['patientid']}[$track['type'].$dateDiff] = $track['result'];
				}
				if($track['type'] === 'reg'){
				$old = $track['result'];
				$oldpid = $track['patientid'];
				}
				//print_r($dateDiff);
				//echo "********";
				//${'p'.$track['patientid']}['lastCD4'] = $track['cd4'];
			}
		}
	}else{	
		//--------------STage start ART----------------------------------------------------preARV
		$switch = true;
		$qryARTstage = '';
		$qryCD4 = '';
		foreach($startArray as $pid=>$start){
			$threem = $start;
			$threem = new DateTime($threem);
			$threem -> modify("-3 months");
			$three = date_format($threem, "m/d/Y");
			if(!$switch){
				$qryARTstage .= "union (select TOP 1 whoStage,patientid,visitdate from v_conditions where patientid = '".$pid."' and visitdate >= '".$start."')";
				$qryCD4 .= "union (select patientid,max(visitdate)as visitdate,cd4 from cd4Table where patientid = '".$pid."' and visitdate <= '".$three."'  group by patientid,cd4) ";
			}else{
				$qryARTstage .= "(select TOP 1 whoStage,patientid,visitdate from v_conditions where patientid = '".$pid."' and visitdate >= '".$start."')";
				$qryCD4 .= "(select patientid,max(visitdate)as visitdate,cd4 from cd4Table where patientid = '".$pid."' and visitdate <= '".$three."' group by patientid,cd4) ";
			}
			$switch = false;
		}

		if($qryARTstage != '') {
			$qryARTstage .= " ORDER BY 3,1 ASC";
			$resultar = dbQuery($qryARTstage);
			while($artstage = psRowFetch($resultar)){
				${'p'.$artstage['patientid']}['stageStartART'] = $artstage['whoStage'];
			}
		}
		if($qryCD4 != '') {
			$qryCD4 .= " ORDER BY 2 ASC";
			$resultcd4 = dbQuery($qryCD4);
			while($cd4 = psRowFetch($resultcd4)){
				${'p'.$cd4['patientid']}['lastCD4'] = $cd4['cd4'];
			}
		}
	}
	//------------------ reason for eligibility--------------------------------------------both
	$qryART = "(select 'tlcLT1200' as result, min(visitdate) as visitdate, patientid from v_labsCompleted where testnameen = 'lymphocytes' and result <= '1200' and result != '' and patientid in (".$pids.") group by patientid)
		union
		(select  'cd4LT200', min(visitdate) as visitdate, patientid from (select patientid, visitdate from cd4Table where cd4 < 200 and visitdate < '" . CD4_350_DATE . "' union select patientid, visitdate from cd4Table where cd4 < 350 and visitdate >= '" . CD4_350_DATE . "') t WHERE patientid IN (".$pids.") group by patientid)
		union
		(select  'WHOIII', min(visitdate) as visitdate, patientid from v_conditions where whoStage = 'Stage III' and patientid in (select patientid from cd4Table where cd4 < 200 and cd4 <> 0 and visitdate < '" . CD4_350_DATE . "' union select patientid from cd4Table where cd4 < 350 and cd4 <> 0 and visitdate >= '" . CD4_350_DATE . "') and patientid in (".$pids.") group by patientid)
		union
		(select  'WHOIV', min(visitdate) as visitdate, patientid from v_conditions where whoStage = 'Stage IV' and patientid in (".$pids.") group by patientid)
		union
		(select  'medEligHAART', min(visitdate) as visitdate, patientid from v_medicalEligARVs where patientid in (".$pids.") and ((medElig in (1,2) and formVersion = 0) or (medElig = 1 and formVersion = 1)) group by patientid)
		union
		(select case
			when cd4LT200 = 1 then 'cd4LT200'
			when tlcLT1200 = 1 then 'tlcLT1200'
			when WHOIII = 1 then 'WHOIII'
			when WHOIV = 1 then 'WHOIV'
			when PMTCT = 1 then 'PMTCT'
			when formerARVtherapy = 1 then 'former'
			when PEP = 1 then 'PEP'
			when medEligHAART = 1 then 'estPrev'
			when ChildLT5ans=1 then 'ChildLT5ans'
            when coinfectionTbHiv=1 then 'coinfectionTbHiv'
            when coinfectionHbvHiv=1 then 'coinfectionHbvHiv'
            when coupleSerodiscordant=1 then 'coupleSerodiscordant'
            when pregnantWomen=1 then 'pregnantWomen'
            when breastfeeding=1 then 'breastfeeding'
            when patientGt50ans=1 then 'patientGt50ans'
	    when nephropathieVih=1 then 'nephropathieVih'
            when protocoleTestTraitement=1 then 'protocoleTestTraitement'
			end as result, visitdate, patientid from v_medicalEligARVs
			where  (cd4LT200 = 1 or tlcLT1200 = 1 or WHOIII = 1 or WHOIV = 1 or PMTCT = 1 or formerARVtherapy = 1 or PEP = 1  or medEligHAART = 1 or ChildLT5ans=1 or coinfectionTbHiv=1 or  coinfectionHbvHiv=1 or coupleSerodiscordant=1 or pregnantWomen=1 or breastfeeding=1 or patientGt50ans=1 or nephropathieVih=1 or protocoleTestTraitement=1) and patientid in (".$pids.")
		)
		order by 2 desc";
	//echo $qryART;
	$result5 = dbQuery($qryART);
	while ($art = psRowFetch($result5)) {
		if(!empty($art['visitdate'])){
			$date = $art['visitdate'];
			$created = new DateTime($date);
			$format= date_format($created,'m/d/Y');
			${'p'.$art['patientid']}["medEligDate"] = $format;
			$result = $art['result'];
			${'p'.$art['patientid']}["whyElig"] = $ARVreason['fr'][$result];
		}
	}
	
	if($isarv){
		//--------------------------------funct stat at start,height, and weight-----------------------------------------------ARV
		$qryvitals = "SELECT visitdate,vitalHeight,vitalHeightCm,vitalWeight,vitalWeightUnits,functionalStatus,patientid FROM v_vitals WHERE patientID IN (".$pids.") order by patientid,visitdate desc  ;";
		$resultv = dbQuery($qryvitals);
		while($vit = psRowFetch($resultv)){
			if(!empty(${'p'.$vit['patientid']}['ARTstart']) ){
				$tempmin = new DateTime(${'p'.$vit['patientid']}['ARTstart']);
				//$tempmax = date_modify($tempmin, "+100 days");
				$tempmin -> modify("-10 days");
				$date = $vit['visitdate'];
				$vitdate = new DateTime($date);
				if ($vitdate >= $tempmin ){
					if($vit['vitalWeightUnits'] != 0){
						$wt = ($vit['vitalWeightUnits'] == 2) ? 'lbs' : 'kgs';
					}else{
						$wt = "";
					}
					if(!empty($vit['functionalStatus'])) ${'p'.$vit['patientid']}["statAtstart"] = $functionalStatus1['fr'][$vit['functionalStatus']];
					if(trim($vit['vitalWeight']) !== '') ${'p'.$vit['patientid']}["weightAtstart"] = $vit['vitalWeight']." ".$wt;
					if(trim($vit['vitalHeight']) !== '') ${'p'.$vit['patientid']}["heightAtstart"] = $vit['vitalHeight']."M ".$vit['vitalHeightCm'];
				}
			}
		}
	}
	
	//HIV
	foreach($pidAr as $x){
		$arr[] = ${'p'.$x};
	}
	echo $_GET['callback'].'({"totals":"'.$rows.'","results":'.json_encode($arr).'})';
} else if($_GET['ac'] === 'saveData'){
	saveData();
}else{
	addData();
}
//print($pids);
?>
