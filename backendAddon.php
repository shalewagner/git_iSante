<?php
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';

//Run this on a *labels* array and it will convert all the &***; symbols into the native character for whichever character set is correct.
//Also does a "ISO-8859-1" to "UTF-8" conversion
//Assumes *labels* arrays are encocded as ISO-8859-1. We'll probably want to change that someday.
function fixLabelsCharset(&$labels) {
  return array_walk_recursive($labels, '__fix_label_charset');
}
//helper function for fixLabelsCharset()
function __fix_label_charset(&$value, $key) {
  //convert html entities
  $value = html_entity_decode($value, ENT_QUOTES, CHARSET);
}

function getEncounterFilePath($encounterId, $fileSuffix, $dbSite = null) {
  if (is_null($dbSite)) {
    $dbSite = DB_SITE;
  }
  
  $bashPath = '/var/backups/itech/encounterFiles';

  return $bashPath . DIRECTORY_SEPARATOR . $dbSite . DIRECTORY_SEPARATOR . $encounterId . DIRECTORY_SEPARATOR . $fileSuffix;
}

function getPatientTransferDir() {
  return '/var/backups/itech/patientTransfer';
}

function getArtQualifyingDate($pid) {
	$qry = "select reason, visitdate, encounter_id as eid, encounterType as etype, formVersion as version from eligibility where patientid = '" . $pid . "' and reason in ('cd4LT200', 'tlcLT1200', 'WHOIII', 'WHOIV', 'PMTCT', 'medEligHAART', 'estPrev', 'former', 'PEP', 'eligByAge', 'eligByCond', 'eligPcr', 'WHOIII-2', 'WHOIIICond', 'OptionB+') and criteriaVersion " . (strtotime (date ("Y-m-d")) <= strtotime (CD4_350_DATE) ? "= 1" : (strtotime (date ("Y-m-d")) <= strtotime (OPTION_B_PLUS_DATE) ? "= 2" : "IN (2, 3)")) . " order by visitdate";
	$result = dbQuery($qry);
	$retArray = array();
	while ($row = psRowFetch($result)) {
		if (!empty($row['visitdate'])) {
			$tmp = array($row['reason'],$row['visitdate'], $row['eid'], $row['etype'], $row['version']);
			array_push ($retArray, $tmp);
		}
	}
	return ($retArray);
}

function getHivPositive ($pid) {
	$qry = "select hivPositive from patient where patientID = '" . $pid . "'";
	$result = dbQuery ($qry);
	$row = psRowFetch ($result);
	if ($row[0] == 1)
		return true;
	else
		return false;
}

function getRegimen ($pid) {
	$regimen = "";
	$qry = "select top 1 regimen, visitdate from pepfarTable where patientID = '" . $pid . "' order by 2 desc";
	$result = dbQuery ($qry);
	while ($row = psRowFetch ($result)) {
		 $regimen = $row[0];
		 break;
	}
	return ($regimen);
}

function isPediatric ($pid) {
	$qry = "select isPediatric from patient where patientid = '" . $pid . "'";
	$result = dbQuery ($qry);
	$row = psRowFetch ($result);
	if ($row[0] == 1)
		return true;
	else
		return false;
}

function isObgyn ($pid) {
	$qry = "select sex from a_patients where patientid = '" . $pid . "' and encounterType in (24,25,26)";
	$result = dbQuery ($qry);
	$row = psRowFetch ($result);
	if ($row[0] == 1)
		return true;
	else
		return false;
}

function isFemale() {
	$mf = getData("sex", "textarea");
	if($mf == 1)
		return true;
	return false;
}

function saveSite($sitecode, $network, $inCPHR) {
  $qry = "
update clinicLookup 
set
 inCPHR = $inCPHR,
 network = '$network' 
where siteCode = '$sitecode'";
  $numRows = psModifiedCount(dbQuery($qry));
  if ($numRows != 1) {
    return 0;
  } else {
    return 1;
  }
}

function getDebugFlag($username) {
  $result = database()->query('select debugFlag from userPrivilege where username = ?',
			      array($username));
  $rows = $result->fetchAll();
  if (count($rows) > 0) {
    return $rows[0]['debugFlag'];
  } else {
    return '';
  }
}

function getTranslateFlag($username) {
	$retVal = "";
	$qry = "select allowtrans from userPrivilege where username = '" . $username . "'";
	//if (DEBUG_FLAG) print $qry;
	$result = dbQuery ($qry);
	while ($row = psRowFetch ($result)) {
	  $retVal = $row[0];
      break;
    }
	return $retVal;
}

function getIntakeID ($pid, $encType = 1) {
	$qry = "SELECT top 1 encounter_id FROM encounter where encounterType = '" . $encType ."' and patientID = '" . $pid . "'";
	$result = dbQuery ($qry) or die("Could not get intake encounter id.");
	while ($row = psRowFetchAssoc ($result)) {
	  return ($row['encounter_id']);
      break;
    }
}

function getRegion ($siteCode) {
	$qry = "SELECT top 1 department as region FROM clinicLookup where sitecode = '" . $siteCode . "'";
	$result = dbQuery ($qry) or die("Could not get region.");
	while ($row = psRowFetchAssoc ($result)) {
		return ($row['region']);
		break;
	}
}

function getCommune($siteCode) {
	$result = database()->query('SELECT commune FROM clinicLookup where sitecode = ?', array($siteCode));
	$rows = $result->fetchAll();
	if (count($rows) > 0) {
		return $rows[0]['commune'];
	}
}

function getNetwork($siteCode) {
	$result = database()->query('SELECT network FROM clinicLookup where sitecode = ?', array($siteCode));
	$rows = $result->fetchAll();
	if (count($rows) > 0) {
		return $rows[0]['network'];
	}
}

function getDepartment($siteCode) {
	$result = database()->query('SELECT department FROM clinicLookup where sitecode = ?', array($siteCode));
	$rows = $result->fetchAll();
	if (count($rows) > 0) {
		return $rows[0]['department'];
	}
}

function setVisitPointer ($encID, $visitID) {
  $qry = " update encounter set visitPointer = '$visitID' where encounter_id = '$encID'";
  $numRows = psModifiedCount(dbQuery($qry));
  if ($numRows != 1) {
    // in at least mysql, psModifiedCount returns zero when applying an existing value, so the following message gets written into the JavaScript code and disrupts processing
    //print  "Unable to set visitPointer";
  }
}

function checkForExistingPatient ($lname,$fname,$dobDd,$dobMm,$dobYy) {
	$dupFlag = "";
	$qry = "select top 1 patientID
		from patient
		where
			lname = '" . $lname . "' and
			fname = '" . $fname . "' and
			dobDd = '" . $dobDd . "' and
			dobMm = '" . $dobMm . "' and
			dobYy = '" . $dobYy . "' and
			patStatus = 0";
	$result = dbQuery ($qry) or die("Failed the encounter query.");
	$row = psRowFetchAssoc ($result);
	if (!empty($row['patientID']))
	  	$dupFlag = $row['patientID'];
	return ($dupFlag);
}

function getFollowupEncounters ($pid,$site, $encType = 2) {
    $queryStmt = "SELECT encounter_id as visitPointer, RTRIM(visitDateDd) as visitDateDd, RTRIM(visitDateMm) as visitDateMm,
    		RTRIM(visitDateYy) as visitDateYy
    		FROM encounter
    		WHERE patientID = '$pid' AND siteCode = '$site' AND encStatus < 255 and encounterType = $encType
			ORDER BY visitDateYy * 365 + visitDateMm * 30 + visitDateDd DESC";
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encounter table.");
	return ($result);
}

function checkForDuplicateForm($encType, $site, $pid, $vdd, $vdm, $vdy) {
	$dupFlag = "";
	$qry = "select top 1 encounter_id
		from encounter
		where
			encounterType = " . $encType . " and
			siteCode = '" . $site . "' and
			patientID = '" . $pid . "' and
			visitDateDd = '" . $vdd . "' and
			visitDateMm = '" . $vdm . "' and
			visitDateYy = '" . $vdy . "' and
			encStatus < 255";
	$result = dbQuery ($qry) or die("Failed the encounter query.");
	while ($row = psRowFetchAssoc ($result)) {
	  if (!empty($row['encounter_id']))
	  	$dupFlag = $row['encounter_id'];
      break;
    }
    return ($dupFlag);
}

function getSessionUser() {
	if (!empty($_SERVER['REMOTE_USER'])) {
		$pieces = explode("\\", $_SERVER['REMOTE_USER']);
		if (count($pieces) != 1) {
			$currUser = $pieces[1];
		} else {
			$currUser = $pieces[0];
		}
	} elseif (isset($_SERVER['HTTP_PUBCOOKIE_USER'])) {
		$currUser = $_SERVER['HTTP_PUBCOOKIE_USER'];
	} else {
		$currUser = ''; #this happens when the ten minute job executes a script
	}  
	return ($currUser);
}

function getName ($pid = "") {
	$qry = "SELECT (lname + ', ' + fname) as pname FROM patient where patientID = " . $pid;
	$result = dbQuery ($qry) or die("Could not get patient name.");
	while ($row = psRowFetchAssoc ($result)) {
	  return ($row['pname']);
      break;
    }
}

function getAccessLevel($username) {
  static $last_username = null;
  static $last_accessLevel;

  if (isset($last_username) && $last_username === $username) {
    return $last_accessLevel;
  } else {
    $last_username = null;
    $last_accessLevel = null;
    $result = database()->query('SELECT privLevel FROM userPrivilege where username = ?',
				array($username));
    $rows = $result->fetchAll();
    if (count($rows) > 0) {
      $last_username = $username;
      $last_accessLevel = $rows[0]['privLevel'];
      return $last_accessLevel;
    }
  }
}

function getUiConfig($username) {
  $result = database()->query('SELECT uiConfiguration FROM userPrivilege where username = ?',
			      array($username));
  $rows = $result->fetchAll();
  if (count($rows) > 0) {
    return $rows[0]['uiConfiguration'];
  }
}

function getDefaultSite ($currUser) {
        $qry = "SELECT rtrim(siteCode) as siteCode FROM userPrivilege WHERE username = ?";
        $result = database()->query($qry,array($currUser));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                return ($row['siteCode']);
                break;
        }
}

function setDefaultSite($currUser, $sc){
	$qry = "UPDATE userPrivilege SET sitecode = '" . $sc . "' WHERE username = '" .$currUser . "'";
	$result = dbQuery($qry) or die("Could not update table userPrivilege");
	return true;
}

function getDefaultEntity ($currUser, $entity) {
	$qry = "SELECT distinct " . $entity . ",a.sitecode as siteCode from clinicLookup a where inCPHR=1 order by 1";
	$result = dbQuery ($qry) or die("Could not get user's default site.");
	while ($row = psRowFetchAssoc ($result)) {
		return ($row[$entity]);
		break;
	}
}

function getSiteName ($siteCode = "",$lang = "fr") {
	$qry = "SELECT clinic as 'siteNameFr' FROM clinicLookup WHERE rtrim(siteCode) = '" . $siteCode . "'";
	$result = dbQuery ($qry) or die("Could not get site name.");
	while ($row = psRowFetchAssoc ($result)) {
	  return ($row['siteNameFr']);
      break;
    }
}

function getSiteLocation ($siteCode = "") {
	$qry = "SELECT commune as 'siteAddress' FROM clinicLookup WHERE rtrim(siteCode) = '" . $siteCode . "'";
	$result = dbQuery ($qry) or die("Could not get site location.");
	while ($row = psRowFetchAssoc ($result)) {
	  return ($row['siteAddress']);
      break;
    }
}

function getSiteAccess($selectedUser = '') {
  $result = database()->query('
select distinct
 1 as hasAccess,
 rtrim(siteCode) as siteCode,
 clinic as siteName,
 clinic as siteNameFr,
 commune,
 department as departement,
 network
from siteAccess
 join clinicLookup using (siteCode)
where siteAccess.username = ?
order by 3', array($selectedUser));
  return $result->fetchAll();
}

function getEntity ($selectedUser = "", $entity) {
	$results = array ();
	$qry = "SELECT distinct " . $entity . ",a.sitecode as siteCode from clinicLookup a where inCPHR=1 order by 1";
	$result = dbQuery ($qry);
	while ($row = psRowFetch ($result))
		array_push ($results, $row);
	return ($results);
}

function getAllEntities ($entity) {
	$results = array ();
    $qry = "SELECT distinct " . $entity . " from clinicLookup";
	$result = dbQuery ($qry);
	while ($row = psRowFetch ($result))
		array_push ($results, $row);
	return ($results);
}

/*
**	This function creates a table userTemp (based on the input test) which can then be used downstream for queries
**	input : report category, treatment status, test, and end date
**	output: temporary table named userTemp of qualifying patientIDs
*/
function addTests($tableName, $repNum, $type2, $type3, $end, $menuSelection, $site) {
	/* current possible values for $menuSelection are:
	******* testNever
	******* testDone
	******* testNeeded
	******* testAbnormal
	*/
	$query = "select c.patientId, c.maxdate, c.visitCnt from " . $tableName . " c";

        // Make some temp tables to hold all the subquery results to use in
        // later joins (MySQL doesn't like all the "... in (select ..." stuff)
        $testTableNames = createTempTables ("#testtemp", 3, array ("patientID varchar(11), abnormal tinyint unsigned", "patientID varchar(11)", "patientID varchar(11)"), "pat_idx::patientID");

        $curSubquery = "";
        $labIdsClause = "";
        if ($type3 == "blood") {
	  $curSubquery = " select distinct patientid, 1 from v_bloodeval";
        } else {
          if ($type3 == "liver") {
            $nameClause = "(testNameFr LIKE '%a%t/sg%t%' OR testNameFr LIKE '%bilirubin%')";
          } else if ($type3 == "pap") {
            $nameClause = "(testNameFr LIKE '%pap%' OR testNameFr LIKE '%frottis vaginal%')";
          } else {
            $nameClause = "testNameFr LIKE '%$type3%'";
          }

          $labIds = array ();
          $result = dbQuery ("SELECT labID FROM labLookup WHERE $nameClause AND labID >= 100");
          while ($row = psRowFetch ($result)) {
            $labIds[] = $row[0];
          }
  	  $labIdsClause = "'" . implode ("', '", $labIds) . "'";
  
  	  $curSubquery = "
            SELECT STRAIGHT_JOIN patientID, resultAbnormal
            FROM v_labsCompleted
            WHERE (labID IN ($labIdsClause)
             AND CASE WHEN ISDATE(dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd)) = 1 THEN dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd) ELSE visitDate END <= '$end' AND $site)";
	     if ($type3 == "cd4" && $menuSelection == "testNever") {
		// exclude infants -- they aren't given cd4 tests
		$curSubquery .= " or patientID in (select patientid from v_patients where " . $site . " and DATEDIFF(month, dbo.ymdToDate(dobYy, dobMm, dobDd), getdate()) <= 18)";
	     }      
        }
        if (DEBUG_FLAG) print "<p> Query for testtemp1: insert into " . $testTableNames[1] . $curSubquery . "</p>\n";
        dbQuery ("insert into " . $testTableNames[1] . $curSubquery);

	if ($menuSelection == "testNever")
	  $query .= " left join " . $testTableNames[1] . " t1 on c.patientId = t1.patientID where t1.patientID is null";
	else if ($menuSelection == "testAbnormal")
          // bloodeval requires special handling
          if ($type3 == "blood") 
            $query .= ", v_labsCompleted v, " . $testTableNames[1] . " t1 where c.patientId = v.patientID and c.patientId = t1.patientID and v.resultAbnormal = 1 group by c.patientId, c.maxdate, c.visitCnt";
          else
            $query .= ", " . $testTableNames[1] . " t1 where c.patientId = t1.patientID and t1.abnormal = 1 group by c.patientId, c.maxdate, c.visitCnt";
	else if ($menuSelection == "testDone")
	  $query .= ", " . $testTableNames[1] . " t1 where c.patientId = t1.patientID group by c.patientId, c.maxdate, c.visitCnt";
        else if ($menuSelection == "testNeeded") {
          // bloodeval requires special handling
          if ($type3 == "blood") 
	    $query .= ", v_bloodeval l where c.patientid = l.patientid and datediff(dd, visitdate, '" . $end . "') >= 60 ";
          else if ($type3 == "cd4" || $type3 == "liver") {
	    // extra qualifications for ART/NOTART for these tests
            $artClause = " select l.patientID from labs l, encValid e, pepfarTable p where l.siteCode = e.siteCode AND l.patientID = e.patientID AND l.visitDateDd = e.visitDateDd AND l.visitDateMm = e.visitDateMm AND l.visitDateYy = e.visitDateYy AND l.seqNum = e.seqNum and ((result IS NOT NULL AND result != '') OR (result2 IS NOT NULL AND result2 != '') OR (result3 IS NOT NULL AND result3 != '') OR (result4 IS NOT NULL AND result4 != '') OR (resultAbnormal IS NOT NULL AND resultAbnormal = 1)) and l.labID in ($labIdsClause) and l.$site and (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) and l.patientID = p.patientid group by l.patientID having max(case when isdate(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 then dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) else e.visitDate end) <= dateadd(dd, -240, '" . $end . "')";
            if (DEBUG_FLAG) print "<p> Query for testtemp2: insert into " . $testTableNames[2] . $artClause . "</p>\n";
            dbQuery ("insert into " . $testTableNames[2] . $artClause);

            $ccClause = " select l.patientID from v_labsCompleted l left join pepfarTable p on l.patientID = p.patientid where l.labID in ($labIdsClause) and l.$site and (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL) and p.patientid is null group by l.patientID having max(case when isdate(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 then dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) else l.visitDate end) <= dateadd(dd, -420, '" . $end . "')";
            if (DEBUG_FLAG) print "<p> Query for testtemp3: insert into " . $testTableNames[3] . $ccClause . "</p>\n";
            dbQuery ("insert into " . $testTableNames[3] . $ccClause);

            if ($type2 == "art") {
              $query .= ", " . $testTableNames[2] . " t2 where c.patientId = t2.patientID";
            } else if ($type2 == "notart") {
              $query .= ", " . $testTableNames[3] . " t3 where c.patientId = t3.patientID";
            } else {
              $query .= ", " . $testTableNames[2] . " t2 where c.patientId = t2.patientid group by c.patientId, c.maxdate, c.visitCnt union select c.patientId, c.maxdate, c.visitCnt from " . $tableName . " c, " . $testTableNames[3] . " t3 where c.patientId = t3.patientid group by c.patientId, c.maxdate, c.visitCnt";
            }
          }
        }

	if (DEBUG_FLAG) print "<p> Query for test: " . $query . "<p>";
	$tableName = makeTable("temp", $query);
}

function makeCustomStatusTable ($statuses) {
  $tblNames = createTempTables ("#tempStatus", 1, "patientID varchar(11), status int unsigned", "pat_idx::patientID");

  $query = "INSERT " . $tblNames[1] . " (patientId, status) VALUES ";

  foreach ($statuses as $pid => $status) {
    dbQuery ($query . "('" . $pid . "', $status)");
  }
}

/*
**  This function initializes a temporary table (for the current user) and then loads it with records based on the input query
**  input: base tablename, query to be loaded
**  output: desired temp table with list of patientids
*/
function makeTable($name, $query) {
	$user = substr(getSessionUser(), 0, 3);
	$tableName = TEMP_DB . "." . $name . $user;
	dbQuery("drop table if exists " . $tableName);
	dbQuery("create table " . $tableName . " (patientId varchar(11), maxdate date null, visitCnt int null, index pat_idx (patientId))");
	$tempQry = "insert into " . $tableName . " " . $query;
	if (DEBUG_FLAG) print "<br>Query: " . $tempQry . "<br>";
	dbQuery($tempQry);
	return ($tableName);
}

function generateQueryResult($qry, $rtype = '', $repNum = '', $lang = 'fr', $site = '%', $pStatus = '0', $tStatus = '0', $tType = '0', $gLevel = '0', $oLevel = '0', $start = '',$end = '', $pid = '', $ddValue = '0', $nForms = '100', $creator = '%', $den = '', $tblNames = array()) {

	$outputRowData = array();

	if ($repNum == "312") {
		include ('include/errorMessages.php');
		include ('labels/labels.php');
		include ('labels/tooltipLabels.php');
	}
        if ($repNum == "520") include ('labels/report.php');
        if ($repNum >= 2000 && $repNum <= 3999) include ('labels/labels.php');
        if ($repNum == "541") {
                include_once "backend/h6SummaryFunctions.php";
                echo generateh6Summary ($start, $end, $site, $lang);
                return '';
        }
		
		   if ($repNum == "545") {
                include_once "backend/isanteFrequentationReport.php";
                echo generateFrequentationReport($start, $end, $site, $lang);
                return '';
        } 
		  if ($repNum == "546") {
                include_once "backend/isanteFrequentationReport.php";
                echo generateFrequentationReport1($start, $end, $site, $lang);
                return '';
        } 
		 if ($repNum == "547") {
                include_once "backend/isanteConsultationReport.php";
                echo generateConsultationReport($start, $end, $site, $lang);
                return '';
        } 

       if ($repNum == "549") {
                include_once "backend/arvStarted.php";
                echo generatearvStarted($start, $end, $site, $lang);
                return '';
        } 
		if ($repNum == "550") {
                include_once "backend/nextVisitDate30.php";
                echo generatenextVisit30D($start, $end, $site, $lang);
                return '';
        } 
		
		if ($repNum == "551") {
                include_once "backend/nextVisitDate.php";
                echo generatenextVisit($start, $end, $site, $lang);
                return '';
        } 

		if ($repNum == "552") {
                include_once "backend/arvDrugPeriode.php";
                echo generatearvPatient($start, $end, $site, $lang);
                return '';
        } 
		
		if ($repNum == "553") {
                include_once "backend/dac.php";
                echo generateDac($start, $end, $site, $lang);
                return '';
        }	
		if ($repNum == "554") {
                include_once "backend/viralLoad.php";
                echo generateViral($start, $end, $site, $lang);
                return '';
        }
		if ($repNum == "557") {
                include_once "backend/viralLoadResult.php";
                echo generateViral($start, $end, $site, $lang);
                return '';
        }
		
		if ($repNum == "559") {
                include_once "backend/pcrEligibility.php";
                echo generatepatientEligibility($start, $end, $site, $lang);
                return '';
        }
		if ($repNum == "778") {
			include_once "viralBarcodeReport.php";
			echo generateBarcode($qry, $start, $end, $site, $lang);
			return '';
		}
		if ($repNum == "560") {
			include_once "backend/suiviDispensationARV.php";
			echo generatearvPatient($site, $lang);
			return '';
		}
		if ($repNum == "562") {
			include_once "backend/cancerColReport.php";
			echo generateCancerColPatient($start, $end, $site, $lang);
			return '';
		}
				
	$repWords = array ( "en" => array ( "This query contains an error", "National ID", "Clinic Patient ID", "Reason for Eligibility", "First Name", "Last Name", "Gender", "Status", "Age", "Last Date", "Regimen", "Change Date", "Stop Date (MM/YY)", "Drug Name", "Reason for Discontinuation", "Error description", "Form", "Field", "Applies to the entire form", "Discontinuation Date", "Patient Status", "Next Visit Date", "Last Modified Date", "Bad Visit Date", "Visit Date" ,"Date of Last Menstrual Period","Week of Amenorrhea","Drug Received", "ART Eligibility Date","Date of Beginning of ART","Regimen Actual","CD4 count at M1","CD4 count at M6","Last Visit Date","Number of ART's patient","Adherence percentage", "Lag (in days)", "Number of forms", "Ob/Gyn ID", "Primary Care ID", "Count", "M", "F", "U", "Address", "Phone", "Contact","Reason for Delayed Enrollment"), "fr" => array ( "La question contient une erreur", "No. d'identit&eacute; nationale", "No. de patient attribu&#xe9; par le site", "Raison d'&#xe9;ligibilit&#xe9;", "Pr&#xe9;nom", "Nom", "Sexe", "Statut", "&#xc2;ge", "Derni&egrave;re date", "R&#xe9;gime", "Date de changement", "Date d'arr&#xea;t (mm/yy)", "Nom de la m&#xe9;dication", "Raison de discontinuation", "Description d'erreur", "Fiche", "Zone", "S'applique &agrave; la fiche enti&egrave;re", "Date de discontinuation", "Statut de patient", "Prochaine date de visite", "Date de dernier changement", "Date de visite mauvaise", "Date de visite","Date de la Semaine Derni&egrave;re de P&eacute;riode","Semaine D'am&eacute;norrh&eacute;e" ,"Médicaments reçus","Date d'&Eacute;ligibilit&eacute; d'ART","Date du Commencement de l'ART","R&eacute;gime R&eacute;el","Compte CD4 &agrave; M1","Compte CD4 &agrave; M6","La Date Pass&eacute;e de Visite","Nombre patient d'ART","Pourcentage d'Adh&eacute;rence", "Laps de temps (jours)", "Compte des fiches", "No. de code OG", "No. de code PC", "Compte", "H", "F", "I", "Adresse", "Téléphone", "Contact", "Raison d'enrôlement rapporté") );

	$noResult = array ("en" => "<br>There is no result!<br>", "fr" => "<br>Il n'y a aucun  r&eacute;sultat!<br>");
	
  	$retVal = $repWords[$lang][0];

	if ($repNum == 205) {
		crossTabReport($lang, $pid);
		return '';
	}
	if ($repNum == 5000) {
		patientVisitPlot($lang, $site, $start, $end);
		return '';
	}

	if (DEBUG_FLAG) echo "<br>" . $qry . "<br>";

        // Don't use the standard table layout for some reports
        $nonStandardReports = array (540);
        if ($gLevel > 1 && !($repNum > 5029 && $repNum < 5047)) {
          $nonStandardReports[] = $repNum;
        }

	if (!in_array ($repNum, $nonStandardReports)) {
          echo '<table class="report-data-table" border="1">';
        }

	$queries = split(";",$qry);
	for($i = 0; $i < sizeof($queries);$i++) {
		if ($rtype == "adhoc") {
		  $result = databaseSelect()->query($queries[$i]);
		} else {
		  $result = dbQuery($queries[$i]);
		}
		$dbRows = $result->fetchAll(PDO::FETCH_ASSOC);
	}

 	if (count($dbRows) != 0) {
		$myFile = getTempFileName('xlsOutput', 'csv');
		$fh = fopen($myFile, 'w') or die("can't open file");
		$newFieldNames = array();
		// format column headers
	        if (!in_array ($repNum, $nonStandardReports)) {
		  echo '<thead><tr>';
                }
		$i = 0;
		foreach ($dbRows[0] as $fieldName => $fieldVal) {
			$i++;
			if ( ! (strcasecmp($fieldName,"patientid") == 0 || strcasecmp($fieldName,"encountertype") == 0) ) {
				if ( !(strcasecmp($fieldName, "encounter_id") == 0) ) {
					$oldFieldName = " " . $i . " ";
					if (strcasecmp($fieldName,"nationalid") == 0) $fieldName= $repWords[$lang][1];
					if (strcasecmp($fieldName,"clinicPatientID") == 0) $fieldName= $repWords[$lang][2];
					if (strcasecmp($fieldName,"eligReason") == 0||strcasecmp($fieldName,"eligReasonTemp") == 0) $fieldName= $repWords[$lang][3];
					if (strcasecmp($fieldName,"fName") == 0) $fieldName= $repWords[$lang][4];
					if (strcasecmp($fieldName,"lName") == 0) $fieldName= $repWords[$lang][5];
					if (strcasecmp($fieldName,"sex") == 0) $fieldName= $repWords[$lang][6];
					if (strcasecmp($fieldName,"status") == 0) $fieldName= $repWords[$lang][7];
					if (strcasecmp($fieldName,"age") == 0) $fieldName= $repWords[$lang][8];
					if (strcasecmp($fieldName,"LastDate") == 0) $fieldName= $repWords[$lang][9];
					if (strcasecmp($fieldName,"regimen") == 0) $fieldName= $repWords[$lang][10];
					if (strcasecmp($fieldName,"changeDate") == 0) $fieldName= $repWords[$lang][11];
					if (strcasecmp($fieldName,"stopDate") == 0) $fieldName= $repWords[$lang][12];
					if (strcasecmp($fieldName,"drugName") == 0) $fieldName= $repWords[$lang][13];
					if (strcasecmp($fieldName,"failList") == 0) $fieldName= $repWords[$lang][14];
					if (strcasecmp($fieldName,"errorDesc") == 0) $fieldName= $repWords[$lang][15];
					if (strcasecmp($fieldName,"Field") == 0) $fieldName= $repWords[$lang][17];
					if (strcasecmp($fieldName,"DateDiscontinued") == 0) $fieldName= $repWords[$lang][19];
					if (strcasecmp($fieldName,"statusDesc") == 0) $fieldName= $repWords[$lang][20];
					if (strcasecmp($fieldName,"NxtVisitDate") == 0) $fieldName= $repWords[$lang][21];
					if (strcasecmp($fieldName,"LastModifiedDate") == 0) $fieldName= $repWords[$lang][22];
					if (strcasecmp($fieldName,"BadVisitDt") == 0) $fieldName= $repWords[$lang][23];
					if (strcasecmp($fieldName,"VisitDt") == 0) $fieldName= $repWords[$lang][24];
					if (strcasecmp($fieldName,"lastMenstrualPeriod") == 0) $fieldName= $repWords[$lang][25];
					if (strcasecmp($fieldName,"amenorrheaWeek") == 0) $fieldName= $repWords[$lang][26];
					if (strcasecmp($fieldName,"receivedDrug") == 0) $fieldName= $repWords[$lang][27];
					if (strcasecmp($fieldName,"ARTEligibilityDate") == 0) $fieldName= $repWords[$lang][28];
					if (strcasecmp($fieldName,"beginningARTDate") == 0) $fieldName= $repWords[$lang][29];
					if (strcasecmp($fieldName,"actualRegimen") == 0) $fieldName= $repWords[$lang][30];
					if (strcasecmp($fieldName,"cd4M1") == 0) $fieldName= $repWords[$lang][31];
					if (strcasecmp($fieldName,"cd4M6") == 0) $fieldName= $repWords[$lang][32];
					if (strcasecmp($fieldName,"lastVisitDate") == 0) $fieldName= $repWords[$lang][33];
					if (strcasecmp($fieldName,"artPatientNbr") == 0) $fieldName= $repWords[$lang][34];
					if (strcasecmp($fieldName,"adhPert") == 0) $fieldName= $repWords[$lang][35];
					if (strcasecmp($fieldName,"LagInDays") == 0) $fieldName= $repWords[$lang][36];
					if (strcasecmp($fieldName,"formcount") == 0) $fieldName= $repWords[$lang][37];
					if (strcasecmp($fieldName,"obGynID") == 0) $fieldName= $repWords[$lang][38];
					if (strcasecmp($fieldName,"pcID") == 0) $fieldName= $repWords[$lang][39];
					if (strcasecmp($fieldName,"totalCnt") == 0) $fieldName= $repWords[$lang][40];
					if (strcasecmp($fieldName,"Address") == 0) $fieldName= $repWords[$lang][44];
					if (strcasecmp($fieldName,"Phone") == 0) $fieldName= $repWords[$lang][45];
					if (strcasecmp($fieldName,"Contact") == 0) $fieldName= $repWords[$lang][46]; 
					if (strcasecmp($fieldName,"arvNoReasonDesc") == 0) $fieldName= $repWords[$lang][47]; 
					if (strcasecmp($fieldName,"rpt520siteCode") == 0) $fieldName= "";
					if (strcasecmp($fieldName,"rpt520label") == 0) $fieldName= "";
					if (strcasecmp($fieldName,"rpt520count") == 0) $fieldName= $report520Labels[$lang][1];
					if (strcasecmp($fieldName,"rpt520percentage") == 0) $fieldName= $report520Labels[$lang][2];
					//Windows require iso8859 while Linux requires UTF-8. The report.xml is UTF-8 encoded. Therefore it is neccessary to convert UTF-8 to iso8859 for windows.
					$fieldName = iconv("UTF-8", CHARSET, $fieldName);
					if ($rtype == "adhoc") $pageToCall = "runQuery.php?adhocQuery=" . urlencode($qry) . "&amp;";
					else $pageToCall = "runReport.php?";
					$newHref = $pageToCall . "reportNumber=" . $repNum . "&amp;rtype=" . $rtype . "&amp;pid=" . $pid . "&amp;lang=" . $lang . "&amp;site=" . $site . "&amp;start=" . $start . "&amp;end=" . $end . "&amp;patientStatus=" . $pStatus . "&amp;treatmentStatus=" . $tStatus . "&amp;testType=" . $tType . "&amp;groupLevel=" . $gLevel . "&amp;otherLevel=" . $oLevel . "&amp;ddValue=" . $ddValue . "&amp;nForms=" . $nForms . "&amp;creator=" . $creator . "&amp;order=" . $oldFieldName . "&amp;odir="; 
	                                if (!in_array ($repNum, $nonStandardReports)) {
					  echo '<th align="left">' . (empty ($fieldName) ? '' : '<a class="print-hide" href="' . $newHref . 'DESC' . '">&#8595;</a>') . $fieldName . (empty ($fieldName) ? '' : '<a class="print-hide" href="' . $newHref . 'ASC' . '">&#8593;</a>') . '</th>';
                                        }
					array_push($newFieldNames, $fieldName);
				} else {
	                                if (!in_array ($repNum, $nonStandardReports)) {
					  echo '<th align="left">' . $repWords[$lang][16] . '</th>';
                                        }
				}
			}
		}
	        if (!in_array ($repNum, $nonStandardReports)) {
		  echo '</tr></thead><tbody>';
                }
		fwrite($fh, implode(',', $newFieldNames) . "\n");
		$countTotal = 0;
		$GLOBALS['reportTotal'] = count($dbRows);
		$j = 0;

                // Handle drill-down components for higher organizational level reports
                if ($gLevel > 1 && !($repNum > 5029 && $repNum < 5047)) {
		  include ('labels/report.php');
                  $orgUnit = $kickLabel['groupLevel']['en'][$gLevel];
                  $orgUnitDisplay = $kickLabel['groupLevel'][$lang][$gLevel];
                  $pidsTable = "temp" . $repNum . getSessionUser ();

                  echo '
<div id="contentArea" class="contentArea">
<div class="row">
  
  <div class="span12">

    <div style="display: none" id="hideBox"></div>
    
    <div class="detail-container" id="resultsByTime">
      
      <table id="datatable" class="table table-bordered table-hover table-condensed report-table" lang="' . $lang . '" tblname="' . $pidsTable . '" olevel="' . $oLevel . '">
        <thead>
          <tr>
            <th style="width: 60%" colspan="2" class="indicator-name">' . $orgUnitDisplay . '</th>
            <th class="result-header">' . _('Compte') . '</th>
            <th class="result-header">' . _('Pour cent') . '</th>
          </tr> 
        </thead> 
        <tbody>';

                  for ($i = 0; $i < count($dbRows); $i++) {
                    // output org level to CSV
		    fwrite($fh, implode(',', $dbRows[$i]) . "\n");

                    // Look for age/gender grouping data
                    $oLevelLabel = "";
                    if ($oLevel == 2) {
                      if (strlen (trim ($dbRows[$i]['Sexe'])) > 0) {
                        $oLevelLabel = $dbRows[$i]['Sexe'];
                      }
                    } else if ($oLevel == 3) {
                      if (strlen (trim ($dbRows[$i]['AgeGroupe'])) > 0) {
                        $oLevelLabel = $dbRows[$i]['AgeGroupe'];
                      }
                    }

                    // Row begins
                    echo "<tr class='report-mainrow' orgunit='" . $orgUnit . "' orgname=\"" . $dbRows[$i][$orgUnit] . "\" olevelval=\"$oLevelLabel\">\n";
                    echo "<td class='report-row-info' colspan='2'><div class='report-row-title'><span class='report-row-title'>" . $dbRows[$i][$orgUnit] . (strlen ($oLevelLabel) > 0 ? " - $oLevelLabel" : "") . "</td>\n";
                    echo "<td>" . $dbRows[$i]['Compte'] . "</td>\n";
                    echo "<td>" . $dbRows[$i]['Pour cent'] . "</td>\n";
                    echo "</tr>\n";

                    // Start subrows - don't use if $gLevel < 3 
                    $oLevelFrom = "";
                    $oLevelWhere = "";
                    if ($oLevel == 2) {
                      $oLevelWhere = " and t.pid = p.patientID and (p.sex ";
                      $oLevelFrom = ", patient p ";
                      switch ($oLevelLabel) {
                        case "H":
                        case "M":
                          $oLevelWhere .= "= 2)";
                          break;
                        case "F":
                          $oLevelWhere .= "= 1)";
                          break;
                        default:
                          $oLevelWhere .= "not in (1, 2) or p.sex is null)";
                          break;
                      }
                    } else if ($oLevel == 3) {
                      $range = "";
                      $oLevelFrom = ", patient p ";
                      switch ($oLevelLabel) {
                        case "0-14":
                          $range = " 0 and 14";
                          break;
                        case "15-20":
                          $range = " 15 and 20";
                          break;
                        case "21-30":
                          $range = " 21 and 30";
                          break;
                        case "31-40":
                          $range = " 31 and 40";
                          break;
                        case "41-50":
                          $range = " 41 and 50";
                          break;
                        case "51-60":
                          $range = " 51 and 60";
                          break;
                        case "61-70":
                          $range = " 61 and 70";
                          break;
                        case "71-80":
                          $range = " 71 and 80";
                          break;
                        case "81-90":
                          $range = " 81 and 90";
                          break;
                        case "91-100":
                          $range = " 91 and 100";
                          break;
                        case "101-110":
                          $range = " 101 and 110";
                          break;
                        default:
                          $oLevelWhere = " and t.pid = p.patientID and case when isnumeric(p.dobYy) <> 1 then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) <> 1 and ((isdate(dbo.ymdToDate(p.dobYy, '06', '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, '06', '15'), getdate()) not between 0 and 110) or isdate(dbo.ymdToDate(p.dobYy, '06', '15')) <> 1) then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) <> 1 and ((isdate(dbo.ymdToDate(p.dobYy, p.dobMm, '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, '15'), getdate()) not between 0 and 110) or isdate(dbo.ymdToDate(p.dobYy, p.dobMm, '15')) <> 1) then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) = 1 and ((isdate(dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd), getdate()) not between 0 and 110) or isdate(dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd)) <> 1) then true else false end";
                          break;
                      }
                      if (strlen (trim ($range)) > 0)
                        $oLevelWhere = " and t.pid = p.patientID and case when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) <> 1 and isdate(dbo.ymdToDate(p.dobYy, '06', '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, '06', '15'), getdate()) between $range then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) <> 1 and isdate(dbo.ymdToDate(p.dobYy, p.dobMm, '15')) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, '15'), getdate()) between $range then true when isnumeric(p.dobYy) = 1 and isnumeric(p.dobMm) = 1 and isnumeric(p.dobDd) = 1 and isdate(dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1 and datediff(year, dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd), getdate()) between $range then true else false end";
                    }

                    if ($gLevel > 2) {
                      $subRowsResult = dbQuery ("SELECT l.clinic AS Name, l.siteCode AS sitecode, COUNT(DISTINCT t.pid) AS 'Compte', COUNT(DISTINCT t.pid) / " . $dbRows[$i]['Compte'] . " * 100 AS 'Pour cent' FROM $pidsTable t, clinicLookup l $oLevelFrom WHERE l.siteCode = LEFT(t.pid, 5) AND l." . $orgUnit . " = '" . str_replace ("'", "''", $dbRows[$i][$orgUnit]) . "' $oLevelWhere GROUP BY 1, 2");
		      $subRows = $subRowsResult->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($subRows as $subRow) {
                        // output org level to CSV
		        fwrite($fh, implode(',', array (' - ' . $subRow['Name'], $subRow['Compte'], $subRow['Pour cent'])) . "\n");

                        echo "<tr class='report-subrow' sitecode='" . $subRow['sitecode'] . "' orgname=\"" . $subRow['Name'] . "\" olevelval=\"$oLevelLabel\">\n";
                        echo "<td class='report-row-info'><div><span class='report-row-title'>" . $subRow['Name'] . "</td>\n";
                        echo "<td>" . $subRow['Compte'] . "</td>\n";
                        echo "<td>" . round ($subRow['Pour cent'], 2) . "</td>\n";
                        echo "</tr>\n"; 
                      }
                    }
                  }
                  // Total row
                  echo "<tr class='report-totalrow' orgname='Total' olevelval=''>\n";
                  echo "<td class='report-row-info' colspan='2'><div class='report-row-title'><span class='report-row-title'>Total</td>\n";
                  echo "<td>&nbsp;</td>\n";
                  echo "<td>100</td>\n";
                  echo "</tr>\n";
                  echo '
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>

  <div id="modalPatients" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalPatientsTitle" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalPatientsTitle"></h3>
      <div style="margin-top: -6px">' . $reportFilteringLabels[$lang][23] . ': <span id="patientCount"></span></div>
    </div>
    <div class="modal-body">
      <div class="loading-box" id="hideBoxPatients"></div>
      <div id="patientOutput" class="invisible">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">' . $repReturn[$lang] . '</button>
    </div>
  </div>';
		  foreach ($dbRows as $dbRow) {
                    // output to CSV
		    fwrite($fh, implode(',', $dbRow) . "\n");
                  }
                  $dbRows = array ();
                }
                // End drill-down component handling

		// Special processing for regimen reports
		if ($repNum == 5025 || $repNum == 5026 || $repNum == 5027) {
			// Regimen sort order
			$regOrder = array ( "en" => array ( "1st line regimen: TDF-FTC-EFV" => array ("FTC-TNF-EFV"), "1st line regimen: TDF-FTC-NVP" => array ("FTC-TNF-NVP"), "1st line regimen: AZT-3TC-EFV" => array ("ZDV-3TC-EFV"), "1st line regimen: AZT-3TC-NVP" => array ("ZDV-3TC-NVP"), "1st line regimen: d4T-3TC-EFV" => array ("d4T-3TC-EFV"), "1st line regimen: d4T-3TC-NVP" => array ("d4T-3TC-NVP"), "1st line regimen: AZT-3TC-ABC or Trizivir" => array ("ZDV-3TC-ABC"), "1st line regimen: TDF-FTC-ABC" => array ("ABC-FTC-TNF"), "1st line regimen: Other" => array ("ABC-ddI-FTC","ABC-ddI-3TC","ABC-ddI-d4T","ABC-ddI-ZDV","ABC-ddI-TNF","ABC-ddI-EFV","ABC-ddI-NVP","ABC-FTC-3TC","ABC-FTC-d4T","ABC-FTC-ZDV","ABC-FTC-EFV","ABC-FTC-NVP","ABC-3TC-d4T","ABC-3TC-TNF","ABC-3TC-EFV","ABC-3TC-NVP","ABC-d4T-TNF","ABC-d4T-ZDV","ABC-d4T-EFV","ABC-d4T-NVP","ABC-TNF-ZDV","ABC-TNF-EFV","ABC-TNF-NVP","ABC-ZDV-EFV","ABC-ZDV-NVP","ZDV-3TC-ddI","ZDV-3TC-FTC","ZDV-3TC-d4T","ZDV-3TC-TNF","ddI-FTC-3TC","ddI-FTC-d4T","ddI-FTC-TNF","ddI-FTC-ZDV","ddI-FTC-EFV","ddI-FTC-NVP","ddI-3TC-d4T","ddI-3TC-TNF","ddI-3TC-ZDV","ddI-3TC-EFV","ddI-3TC-NVP","ddI-d4T-TNF","ddI-d4T-ZDV","ddI-d4T-EFV","ddI-d4T-NVP","ddI-TNF-ZDV","ddI-TNF-EFV","ddI-TNF-NVP","ddI-ZDV-EFV","ddI-ZDV-NVP","FTC-3TC-d4T","FTC-3TC-TNF","FTC-3TC-ZDV","FTC-3TC-EFV","FTC-3TC-NVP","FTC-d4T-TNF","FTC-d4T-ZDV","FTC-d4T-EFV","FTC-d4T-NVP","FTC-TNF-ZDV","FTC-ZDV-EFV","FTC-ZDV-NVP","3TC-d4T-TNF","3TC-TNF-EFV","3TC-TNF-NVP","d4T-TNF-ZDV","d4T-TNF-EFV","d4T-TNF-NVP","d4T-ZDV-EFV","d4T-ZDV-NVP","TNF-ZDV-EFV","TNF-ZDV-NVP"), "2nd line regimen: TDF-FTC-LPV/r" => array ("TNF-FTC-LPV/r"), "2nd line regimen: AZT-3TC-LPV/r" => array ("ZDV-3TC-LPV/r"), "2nd line regimen: Other" => array ("ZDV-ddI-LPV/r", "d4T-ddI-LPV/r","d4T-ddI-NFV","ZDV-ddI-IDV","ZDV-ddI-NFV","d4T-3TC-IDV","d4T-3TC-LPV/r","d4T-3TC-NFV","d4T-ddI-IDV","d4T-ddI-NFV", "ZDV-3TC-IDV", "AZT-3TC-ATV/r", "AZT-TNF-3TC-ATV/r", "AZT-TNF-3TC-LPV/r", "TNF-3TC-ATV/r", "TNF-3TC-LPV/r", "TNF-FTC-ATV/r")), "fr" => array ( "R&#xe9;gime de 1&#xe8;re ligne: TDF-FTC-EFV" => array ("FTC-TNF-EFV"), "R&#xe9;gime de 1&#xe8;re ligne: TDF-FTC-NVP" => array ("FTC-TNF-NVP"), "R&#xe9;gime de 1&#xe8;re ligne: AZT-3TC-EFV" => array ("ZDV-3TC-EFV"), "R&#xe9;gime de 1&#xe8;re ligne: AZT-3TC-NVP" => array ("ZDV-3TC-NVP"), "R&#xe9;gime de 1&#xe8;re ligne: d4T-3TC-EFV" => array ("d4T-3TC-EFV"), "R&#xe9;gime de 1&#xe8;re ligne: d4T-3TC-NVP" => array ("d4T-3TC-NVP"), "R&#xe9;gime de 1&#xe8;re ligne: AZT-3TC-ABC ou Trizivir" => array ("ZDV-3TC-ABC"), "R&#xe9;gime de 1&#xe8;re ligne: TDF-FTC-ABC" => array ("FTC-TNF-ABC"), "R&#xe9;gime de 1&#xe8;re ligne: Autre" => array ("ABC-ddI-FTC","ABC-ddI-3TC","ABC-ddI-d4T","ABC-ddI-ZDV","ABC-ddI-TNF","ABC-ddI-EFV","ABC-ddI-NVP","ABC-FTC-3TC","ABC-FTC-d4T","ABC-FTC-ZDV","ABC-FTC-EFV","ABC-FTC-NVP","ABC-3TC-d4T","ABC-3TC-TNF","ABC-3TC-EFV","ABC-3TC-NVP","ABC-d4T-TNF","ABC-d4T-ZDV","ABC-d4T-EFV","ABC-d4T-NVP","ABC-TNF-ZDV","ABC-TNF-EFV","ABC-TNF-NVP","ABC-ZDV-EFV","ABC-ZDV-NVP","ZDV-3TC-ddI","ZDV-3TC-FTC","ZDV-3TC-d4T","ZDV-3TC-TNF","ddI-FTC-3TC","ddI-FTC-d4T","ddI-FTC-TNF","ddI-FTC-ZDV","ddI-FTC-EFV","ddI-FTC-NVP","ddI-3TC-d4T","ddI-3TC-TNF","ddI-3TC-ZDV","ddI-3TC-EFV","ddI-3TC-NVP","ddI-d4T-TNF","ddI-d4T-ZDV","ddI-d4T-EFV","ddI-d4T-NVP","ddI-TNF-ZDV","ddI-TNF-EFV","ddI-TNF-NVP","ddI-ZDV-EFV","ddI-ZDV-NVP","FTC-3TC-d4T","FTC-3TC-TNF","FTC-3TC-ZDV","FTC-3TC-EFV","FTC-3TC-NVP","FTC-d4T-TNF","FTC-d4T-ZDV","FTC-d4T-EFV","FTC-d4T-NVP","FTC-TNF-ZDV","FTC-ZDV-EFV","FTC-ZDV-NVP","3TC-d4T-TNF","3TC-TNF-EFV","3TC-TNF-NVP","d4T-TNF-ZDV","d4T-TNF-EFV","d4T-TNF-NVP","d4T-ZDV-EFV","d4T-ZDV-NVP","TNF-ZDV-EFV","TNF-ZDV-NVP"), "R&#xe9;gime de 2&#xe8;me ligne: TDF-FTC-LPV/r" => array ("FTC-TNF-LPV/r"), "R&#xe9;gime de 2&#xe8;me ligne: AZT-3TC-LPV/r" => array ("ZDV-3TC-LPV/r"), "R&#xe9;gime de 2&#xe8;me ligne: Autre" => array ("ZDV-ddI-LPV/r", "d4T-ddI-LPV/r","d4T-ddI-NFV", "ZDV-ddI-IDV","ZDV-ddI-NFV","d4T-3TC-IDV","d4T-3TC-LPV/r","d4T-3TC-NFV","d4T-ddI-IDV","d4T-ddI-NFV", "ZDV-3TC-IDV", "AZT-3TC-ATV/r", "AZT-TNF-3TC-ATV/r", "AZT-TNF-3TC-LPV/r", "TNF-3TC-ATV/r", "TNF-3TC-LPV/r", "TNF-FTC-ATV/r")) ); 
			$currReg = "";
			$newDbRows = array ();
			foreach ($regOrder[$lang] as $key => $val) {
				if (strcasecmp ($currReg, $key) != 0) {
					$currReg = $key;
					$found = 0;
				}
				$currPid = "";
				$printed = array ();
				foreach ($dbRows as $dbRow) {
					switch ($repNum) {
					case 5025:
						if (in_array ($dbRow['regimen'], $val)) {
							if ($found === 0) {
								array_push ($newDbRows, array ("regimenHeader" => $currReg));
								$found = 1;
							}
							array_push ($newDbRows, $dbRow);
						}
						break;
					default:
						if (strcasecmp ($currPid, $dbRow['patientID']) != 0) {
							$currPid = $dbRow['patientID'];
							if (in_array ($dbRow['regimen'], $val)) {
								if ($found === 0) {
									array_push ($newDbRows, array ("regimenHeader" => $currReg));
									$found = 1;
								}
								array_push ($newDbRows, $dbRow);
								array_push ($printed, $currPid);
							}
						} else {
							if (in_array ($currPid, $printed)) array_push ($newDbRows, $dbRow);
						}
						break;
					}
				}
			}
			$dbRows = $newDbRows;
		} // End special processing for regimen reports
		// Special processing for report 520 (pregnancy regimens)
		if ($repNum == 520) {
			$newDbRows = array ();
			$curSite = "";
			foreach ($dbRows as $dbRow) {
				$dbRow['rpt520siteCode'] = trim ($dbRow['rpt520siteCode']);
				if (!empty ($dbRow['rpt520siteCode']) && $curSite != $dbRow['rpt520siteCode']) {
					if ($dbRow['rpt520siteCode'] != "99999") {
                                                $curClinic = lookupSiteName ($dbRow['rpt520siteCode']);
					} else {
						$curClinic = $report520Labels[$lang][9];
					}
					if (!empty ($curClinic)) {
						if (!empty ($curSite)) {
							array_push ($newDbRows, array ("report520BlankHeader" => "&nbsp;&nbsp;"));
							$multiSite = true;
						}
						array_push ($newDbRows, array ("report520Header" => $curClinic));
						array_push ($newDbRows, array ("report520SubHeader" => $dbRow['rpt520label']));
					}
					$curSite = $dbRow['rpt520siteCode'];
					$totalDen += $dbRow['rpt520count']; 
				} else if (empty ($dbRow['rpt520siteCode'])) {
					array_push ($newDbRows, array ("report520BlankHeader" => "&nbsp;&nbsp;"));
					array_push ($newDbRows, array ("report520SubHeader" => $dbRow['rpt520label'])); 
				} else {
					$dbRow['rpt520siteCode'] = "";
					if ($dbRow['rpt520label'] == $report520Labels[$lang][3]) $totalMono += $dbRow['rpt520count'];
					else if ($dbRow['rpt520label'] == $report520Labels[$lang][4]) $totalBi += $dbRow['rpt520count'];
					else if ($dbRow['rpt520label'] == $report520Labels[$lang][5]) $totalTri += $dbRow['rpt520count'];
					else if ($dbRow['rpt520label'] == $report520Labels[$lang][5]) $totalTri += $dbRow['rpt520count'];
					else if ($dbRow['rpt520label'] != $report520Labels[$lang][6]) {
						if (empty ($totalRegs[$dbRow['rpt520label']])) $totalRegs[$dbRow['rpt520label']] = $dbRow['rpt520count'];
						else $totalRegs[$dbRow['rpt520label']] += $dbRow['rpt520count'];
					} 
					array_push ($newDbRows, $dbRow);
				}
			}
			$dbRows = $newDbRows;
		} // End special processing for report 520 (pregnancy regimens)
		// Special processing for report 540 (disease surveillance)
		if ($repNum == 540) {
		        include ('labels/report.php');
                        $colCnt = count ($dbRows[0]) - 1;
                        $curSyn = "";
                        $curGrp = "";
                        $siteLabels = array ();
                        $groupSites = array ();
                        $grouping = false;
                        $groupName = "";
                        $labelFunc = "";
                        if ($_REQUEST["groupLevel"] > 2) {
                          switch ($_REQUEST["groupLevel"]) {
                            case 3:
                              $labelFunc = "getCommune";
                              break;
                            case 4:
                              $labelFunc = "getRegion";
                              break;
                            default:
                              $labelFunc = "getNetwork";
                              break;
                          }
                          $grouping = true;
                        } else {
                          if (count (explode (",", $_REQUEST["site"])) > 1) {
                            $labelFunc = $report540Labels[$lang][23];
                            $grouping = true;
                          }
                        }

                        // if grouping, get info for sites we have data for
                        if ($grouping) {
                          $subRes = dbQuery ("
                           SELECT DISTINCT site
                           FROM " . $tblNames[0]);
                          while ($subRow = psRowFetch ($subRes)) {
                            if (!isset ($siteLabels[$subRow[0]]["group"])) {
                              $groupName = is_callable ($labelFunc) ? call_user_func ($labelFunc, $subRow[0]) : $labelFunc;
                              $siteLabels[$subRow[0]]["group"] = $groupName;
                            } else {
                              $groupName = $siteLabels[$subRow[0]]["group"];
                            }
                            $groupSites[$groupName][] = $subRow[0];
                          }
                        }

                        // print style block
                        echo "<style type=\"text/css\">
                               table.report540 {
                                border-collapse: collapse;
                                background-color: white;
                               }
                               table.report540 tr {
                                border-width: 1px;
                                border-style: none;
                                border-color: black;
                                background-color: white;
                                font-weight: normal;
                               }
                               table.report540 tr.header {
                                background-color: yellow;
                                font-weight: bold;
                               }
                               table.report540 tr.hidden {
                                display: none;
                               }
                               table.report540 tr.shown {
                                display: table-row;
                               }
                               table.report540 tr.title {
                                background-color: #DDDDFF;
                               }
                               table.report540 tr.shaded {
                                background-color: #DDDDDD;
                               }
                               table.report540 td {
                                border-width: 1px;
                                padding: 5px;
                                border-style: solid;
                                border-color: black;
                                text-align: center;
                               }
                               table.report540 td.headerCorner {
                                border-width: 0px;
                                border-spacing: 0px;
                                border-style: none;
                                border-color: white;
                                background-color: white;
                               }
                               table.report540 td.title {
                                " . ($grouping ? "border-left: none; padding-left: 1px;" : "") . "
                                text-align: left;
                               }
                               table.report540 td.group {
                                padding-left: 10px;
                               }
                               table.report540 td.site {
                                padding-left: 20px;
                               }
                               table.report540 td.button {
                                border-right: none;
                                padding-right: 1px;
                                vertical-align: top;
                                width: 15px;
                               }
                               table.report540 td.blackened {
                                background-color: #444444;
                                color: #444444;
                               }
                               table.report540 a {
                                text-decoration: none;
                                color: #444444
                               }
                               table.report540 span {
                                font-size: smaller;
                               }
                             </style>
                             <script language=\"JavaScript\" type=\"text/javascript\">
                               function toggleRow (name) {
                                 var tbl = document.getElementById('report540Table');
                                 var trs = tbl.getElementsByTagName('tr');
                                 for (var i = 0; i < trs.length; i++) {
                                   if (trs[i].className.indexOf(name) >= 0) {
                                     if (trs[i].className.indexOf('hidden') >= 0) {
                                       trs[i].className = trs[i].className.replace(/hidden/, 'shown');
                                     } else {
                                       trs[i].className = trs[i].className.replace(/shown/, 'hidden');
                                     }
                                   }
                                 }
                               }
                               function toggleButton (a) {
                                 if (a.innerHTML.indexOf('+') >= 0)
                                   a.innerHTML = a.innerHTML.replace(/\+/, '—');
                                 else
                                   a.innerHTML = a.innerHTML.replace(/—/, '+');
                               }
                               function allRows (action) {
                                 var tbl = document.getElementById('report540Table');
                                 var trs = tbl.getElementsByTagName('tr');
                                 var buttonRegex = new RegExp('—');
                                 var button = '+';
                                 var cRegex = new RegExp('shown');
                                 var cname = 'hidden';
                                 if (action == 'expand') {
                                   buttonRegex = new RegExp('\\\\+');
                                   button = '—';
                                   cRegex = new RegExp('hidden');
                                   cname = 'shown';
                                 }
                                 for (var i = 0; i < trs.length; i++) {
                                   if (trs[i].className.indexOf('title') >= 0) {
                                     trs[i].getElementsByTagName('td')[0].getElementsByTagName('a')[0].innerHTML = trs[i].getElementsByTagName('td')[0].getElementsByTagName('a')[0].innerHTML.replace(buttonRegex, button);
                                   } else if (trs[i].className.indexOf('header') == -1) {
                                       trs[i].className = trs[i].className.replace(cRegex, cname);
                                   }
                                 }
                               }
                             </script>";

                        // print header rows
                        echo "<table id=\"report540Table\" class=\"report540\">
                               <tr class=\"header\">
                                <td" . ($grouping ? " colspan=\"2\"" : "") . " class=\"headerCorner\"></td>";
                        $endDate = dayDiff (0 - ((1 + date ("w", strtotime ($_REQUEST["end"]))) % 7), $_REQUEST["end"]);

                        $weekLabels = array();
                        while (strtotime ($endDate) >= strtotime ($_REQUEST["start"])) {
                          array_unshift ($weekLabels, formatDisplayedDate ("", dayDiff (-6, $endDate), $lang) . " - " . formatDisplayedDate ("", $endDate, $lang));
                          $endDate= dayDiff (-7, $endDate);
                        }
                        foreach ($weekLabels as $weekLabel) {
                          echo "
                                <td colspan=\"5\">$weekLabel</td>";
                        }
                        $mStr = ($lang == "fr" ? "H" : "M");
                        $yrStr = ($lang == "fr" ? "5 ans" : "5 yrs.");
                        $wkStr = ($lang == "fr" ? "Total" : "Total");
                        $collStr = $report540Labels[$lang][25];
                        $expStr = $report540Labels[$lang][26];
                        echo "  <td class=\"headerCorner\"></td>
                               </tr>
                               <tr class=\"header\">
                                <td" . ($grouping ? " colspan=\"2\"" : "") . ">" . $report540Labels[$lang][24] . ($grouping ? "<br><span class=\"smaller\"><a href=\"javascript:;\" onClick=\"allRows('expand');\">[$expStr]</a> <a href=\"javascript:;\" onClick=\"allRows();\">[$collStr]</a></span>" : "") . "</td>";
                                for ($i = 1; $i <= ($colCnt - 2) / 5; $i++) {
                                    echo "<td>$mStr &lt; $yrStr</td>
                                          <td>F &lt; $yrStr</td>
                                          <td>$mStr &ge; $yrStr</td>
                                          <td>F &ge; $yrStr</td>
                                          <td>$wkStr</td>";
                                }
                                echo "<td>" . $report540Labels[$lang][27] . "</td>
                                     </tr>";
                        
                        // print data rows
                        $synCnt = 0;
                        $rowCnt = 0;
			foreach ($dbRows as $dbRow) {
                                // output to CSV
			        fwrite($fh, implode(',', $dbRow) . "\n");

                                // get labels, if needed
                                if (!isset ($siteLabels[$dbRow["site"]]["name"])) {
                                  $siteLabels[$dbRow["site"]]["name"] = lookupSiteName ($dbRow["site"]);
                                }

                                // set blackened cells for appropriate syndromes
                                $blackCells = array ();
                                if ($dbRow["syndrome"] == $report540Labels[$lang][21]) {
                                  for ($i = 1; $i <= ($colCnt - 2); $i += 5) {
                                    $blackCells[] = $i;
                                    $blackCells[] = $i + 1;
                                    $blackCells[] = $i + 2;
                                  }
                                }

                                if ($curSyn != $dbRow["syndrome"]) {
                                  $synCnt++;
                                  // new syndrome, print syndrome totals row
                                  $sumStr = "SUM(boys0) AS boys0, SUM(girls0) AS girls0, SUM(men0) AS men0, SUM(women0) AS women0, SUM(total0) AS total0";
                                  for ($i = 1; $i < ($colCnt - 2) / 5; $i++) {
                                    $sumStr .= ", SUM(boys$i) AS boys$i, SUM(girls$i) AS girls$i, SUM(men$i) AS men$i, SUM(women$i) AS women$i, SUM(total$i) AS total$i";
                                  }
                                  $sumStr .= ", SUM(grandTotal) AS grandTotal";
                                  $subRes = dbQuery ("
                                   SELECT syndrome, $sumStr
                                   FROM " . $tblNames[0] . "
                                   WHERE syndrome = '" . str_replace ("'", "''", $dbRow["syndrome"]) . "'
                                   GROUP BY 1");
                                  $rowCnt++;
                                  $shade = $rowCnt % 2 == 0 ? "" : "shaded";
                                  echo "<tr class=\"title\">\n";
                                  while ($subRow = psRowFetch ($subRes)) {
                                    foreach ($subRow as $key => $val) {
                                      if (is_numeric ($key)) echo "<td" . ($key == 0 ? ($grouping ? " class=\"button\"><a href=\"javascript:;\" onClick=\"toggleButton(this); toggleRow('syn$synCnt');\">+</a></td><td class=\"title\"><a href=\"javascript:;\" onClick=\"toggleButton(this.parentNode.parentNode.getElementsByTagName('td')[0].getElementsByTagName('a')[0]); toggleRow('syn$synCnt');\"" : " class=\"title\"") : (in_array ($key, $blackCells) ? " class=\"blackened\"" : "")) . ">$val" . ($grouping && $key == 0 ? "</a>" : "") . "</td>\n";
                                    }
                                  }
                                  echo "</tr>\n";
                                  $curGrp = "";
                                }

                                if ($grouping) {
                                  $groupName = $siteLabels[$dbRow["site"]]["group"];
                                  if ($curGrp != $groupName) {
                                    // new group, print group totals row
                                    $sumStr = "SUM(boys0) AS boys0, SUM(girls0) AS girls0, SUM(men0) AS men0, SUM(women0) AS women0, SUM(total0) AS total0";
                                    for ($i = 1; $i < ($colCnt - 2) / 5; $i++) {
                                      $sumStr .= ", SUM(boys$i) AS boys$i, SUM(girls$i) AS girls$i, SUM(men$i) AS men$i, SUM(women$i) AS women$i, SUM(total$i) AS total$i";
                                    }
                                    $sumStr .= ", SUM(grandTotal) AS grandTotal";
                                    $siteList = implode ("','", $groupSites[$groupName]);
                                    $subRes = dbQuery ("
                                     SELECT '" . str_replace ("'", "''", $groupName) . "', $sumStr
                                     FROM " . $tblNames[0] . "
                                     WHERE syndrome = '" . str_replace ("'", "''", $dbRow["syndrome"]) . "'
                                      AND site IN ('" . $siteList . "')
                                     GROUP BY 1");
                                    $rowCnt++;
                                    $shade = $rowCnt % 2 == 0 ? "" : "shaded";
                                    echo "<tr class=\"syn$synCnt hidden $shade\">\n";
                                    while ($subRow = psRowFetch ($subRes)) {
                                      foreach ($subRow as $key => $val) {
                                        if (is_numeric ($key)) echo "<td" . ($key == 0 ? " colspan=\"2\" class=\"title group\"" : (in_array ($key, $blackCells) ? " class=\"blackened\"" : "")) . ">$val</td>\n";
                                      }
                                    }
                                    echo "</tr>\n";
                                  }
                                  $rowCnt++;
                                  $shade = $rowCnt % 2 == 0 ? "" : "shaded";
                                  echo "<tr class=\"syn$synCnt hidden $shade\">\n";
                                  foreach ($dbRow as $key => $val) {
                                    if ($key == "site") {
                                      echo "<td colspan=\"2\" class=\"title site\">" . $siteLabels[$val]["name"] . "</td>\n";
                                    } else if ($key != "syndrome") {
                                      echo "<td" . (!empty ($blackCells) && (stripos ($key, "boys") === 0 || stripos ($key, "girls") === 0 || stripos ($key, "men") === 0) ? " class=\"blackened\"" : "") . ">" . $val . "</td>\n";
                                    }
                                  }
                                  echo "</tr>\n";
                                }

                                $curSyn = $dbRow["syndrome"];
                                $curGrp = $siteLabels[$dbRow["site"]]["group"];
			}
                        $dbRows = array (); 
		} // End special processing for report 540 (disease surveillance)

                $maxRowsReached = false;
		foreach ($dbRows as $row) {
			$outputRowData = array(); 
		        $htmlRowData = "";
			$havePidLink = false;
			// Pull out patient id for later use in links
			$pid = (!empty ($row['patientID'])) ? $row['patientID'] : "";
			// Get pid via other patient identifiers, if present
			if ($pid == "") { 
				if (!empty($row['Code ST'])) $pid = getPidByOtherID ($row['Code ST'], $site, 'clinicPatientID');
				if (!empty($row['clinicPatientID'])) $pid = getPidByOtherID ($row['clinicPatientID'], $site, 'clinicPatientID');
				if (!empty($row['pcID'])) $pid = getPidByOtherID ($row['pcID'], $site, 'pcID');
				if (!empty($row['obgynID'])) $pid = getPidByOtherID ($row['obgynID'], $site, 'obgynID'); 
			} 
			if ($pid != "") $havePidLink = true;
			// this sets up for a fiche link if possible
			if (! empty($row['encounter_id']) && ! empty($row['encountertype'])) {
				$haveEncLink = true;
				$encID = $row['encounter_id'];
				$enctype = $row['encountertype'];
			} else {
				$haveEncLink = false;
				$encID = '';
				$enctype = '';
			}
			if (!empty ($row['regimenHeader'])) {
				if ($j < MAX_REPORT_ROWS) echo "<tr bgcolor=\"#BBBBFF\"><td colspan=\"9\"><b>" . $row['regimenHeader'] . "</b></td></tr>";
				array_push($outputRowData, $row['regimenHeader']);
			    fwrite($fh, implode(',', $outputRowData) . "\n");
				continue;
			}
			if (!empty ($row['report520Header'])) {
				if ($j < MAX_REPORT_ROWS) echo "<tr bgcolor=\"#BBBBFF\"><td colspan=\"4\"><b>" . $row['report520Header'] . "</b></td></tr>";
				array_push($outputRowData, $row['report520Header']);
			    fwrite($fh, implode(',', $outputRowData) . "\n");
				continue;
			}
			if (!empty ($row['report520BlankHeader'])) {
				if ($j < MAX_REPORT_ROWS) echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"4\">" . $row['report520BlankHeader'] . "</td></tr>";
				array_push($outputRowData, $row['report520BlankHeader']);
			    fwrite($fh, implode(',', $outputRowData) . "\n");
				continue;
			}
			if (!empty ($row['report520SubHeader'])) {
				if ($j < MAX_REPORT_ROWS) echo "<tr bgcolor=\"#FFFFFF\"><td></td><td colspan=\"3\">" . $row['report520SubHeader'] . "</td></tr>";
				array_push($outputRowData, $row['report520SubHeader']);
			    fwrite($fh, implode(',', $outputRowData) . "\n");
				continue;
			}
			if ( $j%2 )
				$htmlRowData .= "<tr bgcolor='#BBBBBB'>";
			else
				$htmlRowData .= "<tr>";  
			foreach ($row as $fieldName => $fieldVal) {
				if (is_numeric ($fieldName)) continue;
				if (! (strcasecmp($fieldName,"patientid") == 0 || strcasecmp($fieldName,"encountertype") == 0)) {
					if ($havePidLink && (strcasecmp($fieldName, "Code ST") == 0 || strcasecmp($fieldName, "clinicPatientID") == 0 || strcasecmp($fieldName, "pcID") == 0 || strcasecmp($fieldName, "obgynID") == 0)) {
						// there's an id in the results--generate a url for finding the patient
						$htmlRowData .= "<td align=\"left\"><a target=\"mainWindow\" href=\"patienttabs.php?lang=$lang&site=$site&pid=$pid\" onclick=\"javascript:window.blur()\">" . (strlen (trim ($fieldVal)) > 0 ? $fieldVal : "N/A") . "</a></td>";
						array_push($outputRowData, $fieldVal);
					} else if (strcasecmp($fieldName,"Alerte popup") == 0) {
							$htmlRowData .= "<td align=\"center\"><a target=\"_blank\" href=\"patient/r34Popup.php?lang=$lang&amp;pid=$pid\" onclick=\"javascript:window.blur()\">popup</a></td>";
							array_push($outputRowData, "popup");
					} else if ($haveEncLink && $fieldName == "encounter_id") {
						$fname = $GLOBALS['encType'][$lang][$enctype];
						// encounter_id is in the query--generate a url for displaying the encounter
						$htmlRowData .= "<td align=\"left\"><a target=\"mainWindow\" href=\"patienttabs.php?lang=$lang&amp;site=$site&amp;pid=$pid&amp;fid=$encID\" onclick=\"javascript:window.blur()\">" . $fname . "</a></td>";
					} else if (stripos ($fieldName, "date") !== false) {
						//format Date for fr or en
						$curDate = $fieldVal;
						if ($curDate == "")
							$curDate = "null";
						else {
							$curDate = formatDisplayedDate ($fieldName, $fieldVal,$lang);
							if (strcmp ($fieldName, "stopDate") == 0) $curDate = (strcmp ($lang, "en") == 0) ? substr ($curDate, 0, 3) . substr ($curDate, 6, 2) : substr ($curDate, 3);
						}
						$htmlRowData .= "<td align=\"left\">" . $curDate . "</td>";
						array_push($outputRowData, $curDate);
					} else if (strcasecmp($fieldName,"arvNoReasonDesc") == 0 ) {
						$reasons = explode ("|", $fieldVal);
						$finalFieldVal = "";
						for ($z = 0; $z < count ($reasons); $z++) {
							if ($z > 0) $finalFieldVal .= "; ";
							$finalFieldVal .= $reasons[$z];
						}
						$htmlRowData .= "<td align=\"left\">" ;
						$htmlRowData .= $finalFieldVal;
						$htmlRowData .= "</td>";
						array_push($outputRowData, $finalFieldVal);
					} else if (strcasecmp($fieldName,"eligReason") == 0 || strcasecmp($fieldName,"eligReasonTemp") == 0) {
						$eligReasonXref = array ( "en" => array ( "cd4LT200" => "CD4 below threshold", "tlcLT1200" => "Lymphocytes <= 1200", "WHOIII" => "WHO Stage III & CD4 below threshold", "WHOIII-2" => "WHO Stage III", "WHOIIICond" => "WHO Stage III & active condition", "WHOIV" => "WHO Stage IV", "PMTCT" => "PMTCT", "medEligHAART" => "\"Yes\" checked on form", "estPrev" => "Established at last visit", "former" => "Former ARV therapy", "PEP" => "PEP", "eligByAge" => "Age", "eligByCond" => "Active condition", "eligPcr" => "Positive PCR result", "OptionB+" => "Option B+", "tmsAdult" => "HIV+ adult or adolescent", "tmsChildInfected" => "HIV+ child w/ diagnoses", "tmsChildExposed" => "HIV-exposed child" ), "fr" => array ( "cd4LT200" => "CD4 inf&#xe9;rieur au seuil", "tlcLT1200" => "Lymphocytes <= 1200", "WHOIII" => "OMS Stade III & CD4 inf&#xe9;rieur au seuil", "WHOIII-2" => "OMS Stade III", "WHOIIICond" => "OMS Stade III & condition actif", "WHOIV" => "OMS Stade IV", "PMTCT" => "PTME", "medEligHAART" => "\"Oui\" choisi sur la fiche", "estPrev" => "&#xc9;ligibilit&#xe9; m&#xe9;dicale &#xe9;tablie &#xe0; la visite ant&#xe9;rieure", "former" => "ARV trith&#xe9;rapie ant&#xe9;rieure", "PEP" => "PEP", "eligByAge" => "L'âge", "eligByCond" => "Condition actif", "eligPcr" => "Résultat positif de test PCR", "OptionB+" => "Option B+", "tmsAdult" => "Adulte ou adolescent VIH-positif", "tmsChildInfected" => "Enfant VIH-positif avec diagnostics", "tmsChildExposed" => "Enfant expos&#xe9; &#xe0; VIH" ) ); 
						$reasons = explode ("|", $fieldVal);
						$finalFieldVal = "";
						for ($z = 0; $z < count ($reasons); $z++) {
							if ($z > 0) $finalFieldVal .= "; ";
							if(isset($eligReasonXref[$lang][$reasons[$z]])) {
								$finalFieldVal .= $eligReasonXref[$lang][$reasons[$z]];
							} else {
								$finalFieldVal .= $reasons[$z];
							}
						}
						$htmlRowData .= "<td align=\"left\">" ;
						$htmlRowData .= $finalFieldVal;
						$htmlRowData .= "</td>";
						array_push($outputRowData, $finalFieldVal);
					} else if (strcasecmp($fieldName,"status") == 0) {
						$statusXref = array ( "en" => array ( "ART" => "On ART", "CC" => "Palliative Care", "soins palliatifs" => "Palliative Care", "sous ARV" => "On ART" ), "fr" => array ( "ART" => "sous ARV", "CC" => "soins palliatifs" ) ); 
						$htmlRowData .= "<td align=\"left\">";
						if(isset($statusXref[$lang][$fieldVal])) {
							$htmlRowData .= $statusXref[$lang][$fieldVal];
						    array_push($outputRowData, $statusXref[$lang][$fieldVal]);
                                                } else {
							$htmlRowData .= $fieldVal;
						    array_push($outputRowData, $fieldVal);                                                
						}
						$htmlRowData .= "</td>";
					} else if (strcasecmp($fieldName,"sex") == 0) {
						if (is_numeric ($fieldVal)) {
							if ($fieldVal == 2) {
								$fieldVal = $repWords[$lang][41];
							} else if ($fieldVal == 1) {
								$fieldVal = $repWords[$lang][42];
							} else {
								$fieldVal = $repWords[$lang][43];
							}
						}
						$htmlRowData .= "<td align=\"left\">" . $fieldVal . "</td>";
						array_push($outputRowData, $fieldVal);
					} else if (strcasecmp($fieldName,"errorDesc") == 0) {
							$errorNum = $row["errorDesc"];
							if (is_numeric($errorNum)) {
								if ($errorNum < 10) {
									// These are recorded based upon errors, marked as complete/incomplete, marked as for review
									$errorDesc = formStatusMessage ($lang, $errorNum, $formStatus);
								} else {
									// values come from client-side error array
									$errorDesc = $errorMessages[$lang][$errorNum];
								}
							} else {
								// errors coming from old getErrors routine (now obsolete) initialized in the 60rc1updates script
								if (strlen($tooltipLabels[$errorNum][$lang]) > 0) $errorDesc = strlen($tooltipLabels[$errorNum][$lang]);
								else	$errorDesc = $errorNum;
							}
							$htmlRowData .= "<td align=\"left\">" . $errorDesc . "</td>";
							array_push($outputRowData, $errorDesc);
					} else if (strcasecmp($fieldName,"Address") == 0) {
						$addr = explode ("|", $fieldVal);
						$finalFieldVal = "";
						for ($z = 0; $z < count ($addr); $z++) {
							if ($z > 0) $finalFieldVal .= "; ";
						  $finalFieldVal .= $addr[$z];
					  }
						$htmlRowData .= "<td align=\"left\">" ;
						$htmlRowData .= $finalFieldVal;
						$htmlRowData .= "</td>";
						array_push($outputRowData, $finalFieldVal);
					} else if (strcasecmp($fieldName,"receivedDrug") == 0) {
						$drugs = explode ("|", $fieldVal);
						$finalFieldVal = "";
						for ($z = 0; $z < count ($drugs); $z++) {
							if ($z > 0) $finalFieldVal .= "; ";
						  $finalFieldVal .= $drugs[$z];
					  }
						$htmlRowData .= "<td align=\"left\">" ;
						$htmlRowData .= $finalFieldVal;
						$htmlRowData .= "</td>";
						array_push($outputRowData, $finalFieldVal);
					} else {
						if ($gLevel != 1 && $oLevel == 1 && is_null($fieldVal)) {
							$htmlRowData .= "<td align=\"left\">Total</td>";
							array_push($outputRowData, "Total");
						} else if ($oLevel > 1 && is_null($row[0]) && is_null($fieldVal)) {
							$htmlRowData .= "<td align=\"left\">Total</td>";
							array_push($outputRowData, "Total");
						} else if ($oLevel > 1 && !is_null($row[0]) && is_null($fieldVal)) {
							$htmlRowData .= "<td align=\"left\">Subtotal</td>";
							array_push($outputRowData, "Subtotal");
						} else {
							$curVal = $fieldVal;
							if (strcasecmp($curVal,"ExF") == 0) $curVal = $repWords[$lang][18];
							if (is_numeric($curVal) || strcasecmp($fieldName,"nationalid") == 0)
								$htmlRowData .= "<td align=\"right\">" . $curVal . "</td>";
							else if($curVal != null) {
								$htmlRowData .= "<td align=\"left\">" . $curVal . "</td>";
							} else {
								$htmlRowData .= "<td align=\"left\">&nbsp;</td>";
							}
							array_push($outputRowData, $curVal);
						}
					}
					if ($fieldName == "Count" || $fieldName == "f" || $fieldName == "totalCnt") $countTotal = $countTotal + $fieldVal;
				}
			}
			$htmlRowData .= "</tr>";
			fwrite($fh, implode(',', $outputRowData) . "\n"); 
			if ($j < MAX_REPORT_ROWS) echo $htmlRowData;
                        else if (!$maxRowsReached) {
                          $maxRowsReached = true;
                        }
			$j++;
		}

		fclose($fh);
		if ($countTotal != 0) $GLOBALS['reportTotal'] = $countTotal;
		// format result total
	        if (!in_array ($repNum, $nonStandardReports)) {
		  if ($gLevel == 1 && $oLevel == 1) {
			echo "<tr height=\"55\"><td colspan=\"10\" align=\"left\"> <b>Total: " . $GLOBALS['reportTotal'] . "</b></td></tr>";
		  } else if ($repNum == 501 || $repNum == 102 || $repNum == 100 || $repNum == 601 || $repNum == 603) {
			echo "<tr height=\"55\"><td colspan=\"2\" align=\"left\"> <b>Total: " . $GLOBALS['reportTotal'] . "</b></td></tr>";
                  } else if ($repNum >= 2000 && $repNum <= 2999) {
                        echo "<tr height=\"55\"><td colspan=\"10\" align=\"left\"> <b>Total: " . $GLOBALS['reportTotal'] . " " . $allEnc[$lang][12] . " " . (empty ($den) ? "0 (0%)" : "$den (" . round (100 * $GLOBALS['reportTotal'] / $den, 1) . "%)") . "</b></td></tr>";
                  } else if ($repNum >= 3000 && $repNum <= 3099 && $repNum != 3001) {
                        echo "<tr height=\"55\"><td colspan=\"10\" align=\"left\"> <b>Total: " . $GLOBALS['reportTotal'] . " " . $allEnc[$lang][12] . " " . (empty ($den) ? "0 (0%)" : "$den (" . round (100 * $GLOBALS['reportTotal'] / $den, 1) . "%)") . "</b></td></tr>";
                  } else if ($repNum >= 3100 && $repNum <= 3999) {
                        echo "<tr height=\"55\"><td colspan=\"10\" align=\"left\"> <b>Total: " . $GLOBALS['reportTotal'] . "</b></td></tr>";
                  }
                }
                if ($maxRowsReached) {
                  echo "<h4><font color=\"red\">" . sprintf (_('Note : L’affichage des résultats a été tronqué après %d lignes. Pour voir les résultats complets, veuillez cliquer sur le bouton « excel » ci-dessus.'), MAX_REPORT_ROWS) . "</font></h4>";
                }
		$retVal = "";
	        if (!in_array ($repNum, $nonStandardReports)) {
		  echo '</tbody>';
                }
	} else { 
		echo "<script type=\"text/javascript\">
				if(document.forms[0].genPDF!=null)
					document.forms[0].genPDF.disabled=true;
			    if(document.forms[0].genExcel!=null)
					document.forms[0].genExcel.disabled=true;
			 </script>";		
            if (($repNum >= 2000 && $repNum <= 2999) || ($repNum >= 3000 && $repNum <= 3099 && $repNum != 3001)) {
              echo "<tr height=\"55\"><td colspan=\"10\" align=\"left\"> <b>Total: " . $GLOBALS['reportTotal'] . " " . $allEnc[$lang][12] . " " . (empty ($den) ? "0 (0%)" : "$den (" . round (100 * $GLOBALS['reportTotal'] / $den, 1) . "%)") . "</b></td></tr>";
            } else {
	      echo $noResult[$lang];
            }
	}
	dropTempTables ($tblNames);
	if (!in_array ($repNum, $nonStandardReports)) {
	  echo '</table>';
        }
  	return ($retVal);
}

function formatDisplayedDate ($fieldName, $dateString, $lang) {
  $time = strtotime($dateString);

  if (strlen($dateString) == 4) {
    $format = 'm/y';
  } else {
    if ($lang == 'fr') {
      $format = 'd/m/y';
    } else {
      $format = 'm/d/y';
    }
  }

  if ($fieldName == "lastModified" || $fieldName == "createDate")
    return date($format . ' h:i:s A', $time);
  else
    return date($format, $time);
}

function getReferrals($eid) {
    $qry = "select refName, refSequence, refLabelEn, refLabelFr
                from referralLookup";
     $qry .= " ORDER BY refSequence";
     $results = array ();
     $content = dbQuery ($qry) or die ("Couldn't search referral table.");
     while ($row = psRowFetch ($content))
          array_push ($results, $row);
     return ($results);
}

function setLDAPAdmin ($pw, $userName) {
	$connectionDn = 'uid=' . getSessionUser() . ',ou=users,' . LDAP_BASE_DN;
	$connect = ldap_connect(LDAP_HOST);
	ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	$r = ldap_bind($connect, $connectionDn , $pw);
	$userDn = 'uid=' . $userName . ',ou=users,' . LDAP_BASE_DN;
	$group_info = array();
	$group_info["member"][0] = $userDn;
	$group_name = 'cn=admins,ou=groups,' . LDAP_BASE_DN;
	echo "\n" . $group_name . "\n";
	$retVal = ldap_mod_add($connect,$group_name,$group_info);
	if ($retVal) echo "WAS ABLE TO ADD AS AN ADMINISTRATOR";
	else echo "**********ADMIN ADD FAILED***********";
}

function genCommuneDropDown ($fieldName = "", $tabIndex = "", $curValue = "", $extra = "") {
	$site = getDefaultSite (getSessionUser ());
	$region = getRegion($site);
	$commune = getCommune($site);
	$flag = 0;
	$qry = "select distinct rtrim(commune) as commune, department as region from clinicLookup
	 	union select 'Cit&eacute; Soleil', 'Ouest'
		union select 'Tabarre', 'Ouest' order by 1";
	echo "<select tabindex=\"" . $tabIndex . "\" id=\"" . $fieldName . "\" name=\"" . $fieldName . "\">";
    $content = dbQuery ($qry) or die ("Couldn't run query to generate dropdown.");
	while ($row = psRowFetchAssoc($content)) {
          if ($row['commune'] == "erehwon") continue;
	  echo "<option value=\"" . $row['commune'] . "\"";
	  // no value yet == set to user's commune; otherwise set to current value
	  //print $curValue . " " . $row['commune'] . " " . $commune;
	  //if ( ($curValue == "" && $row['commune'] == $commune) || strtolower($row['commune']) == strtolower($curValue) ) {
	  if ( $curValue != "" && strtolower($row['commune']) == strtolower($curValue) ) {
	  	$flag = 1;
	  	echo " selected";
	  }
	  echo ">" . $row['commune'] . " (" . $row['region'] . ")</option>";
	}
	if ($flag == 0) echo "<option value=\"" . $curValue . "\" selected>" . $curValue . $extra . "&nbsp;";
	echo "</select>";
}

function getEidByPidAndType ($pid = "", $eType = "") {
   $queryStmt = "SELECT top 1 * FROM encounter WHERE patientID = '" . $pid . "' and encounterType = '" . $eType . "' order by visitDateYy, visitDateMm, visitDateDd";
   $content = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't find encounter.");
   $row = psRowFetch ($content);
   return ($row['encounter_id']);
}

function loadXMLFile($reportsXMLFile) {
	if (file_exists($reportsXMLFile))
  		$xml = simplexml_load_file($reportsXMLFile);
	else {
		$reportsXMLFile = "c:\\Program Files\\Apache Software Foundation\\Tomcat 5.5\\webapps\\ITECH_Reports\\reports.xml";
		if (file_exists($reportsXMLFile))
	  		$xml = simplexml_load_file($reportsXMLFile);
		else
			exit("Failed to open $reportsXMLFile");
	}
	return $xml;
}

function genReportArray($rtype, $stype) {
	$xml = loadXMLFile("jrxml/reports.xml");

	$reportSetArray = array();


	$xpath = "reportSet[@rtype='$rtype']/reportSubSet/report | reportSet[@rtype='$rtype']/reportSubSet";
	if ( $stype != "" )
	    $xpath = "reportSet[@rtype='$rtype']/reportSubSet[title='$stype']/report";
	//print "XPath: " . $xpath . "\n<br />";
	foreach ($xml->xpath($xpath) as $xml_report)
	{
	    $reportSetArray[] = parseXmlReport($xml_report);
	}

	return $reportSetArray;
}

function parseXmlReport($xml_report) {
  global $site;
  global $start;
  global $end;
  global $pid;

  $report = array (
	"reportNameen" => $xml_report->xpath("title[@lang='en']"),
	"reportNamefr" => $xml_report->xpath("title[@lang='fr']"),
	"reportNamecr" => $xml_report->xpath("title[@lang='ht']"),
	"reportFile" => $xml_report->xpath("reportFile"),
	"reportNumber" => (string)$xml_report['id'],
	"tempQuery" => (string)$xml_report['tempQuery'],
	"query" => (string)$xml_report->query,
	"description" => (string)$xml_report->description,
	"patientStatus" => $xml_report['patientStatus'],
	"treatmentStatus" => $xml_report['treatmentStatus'],
	"testType" => $xml_report['testType'],
	"groupLevel" => $xml_report->groupLevel,
	"otherLevel" => $xml_report->otherLevel,
	"menuSelection" => $xml_report->menuSelection
  );

  if ($report["reportNameen"]) {
    $report["reportNameen"] = (string)$report["reportNameen"][0];
  } else {
    $report["reportNameen"] = "";
  }
  if ($report["reportNamefr"]) {
    $report["reportNamefr"] = (string)$report["reportNamefr"][0];
  } else {
    $report["reportNamefr"] = "";
  }
  if ($report["reportNamecr"]) {
    $report["reportNamecr"] = (string)$report["reportNamecr"][0];
  } else {
    $report["reportNamecr"] = "";
  }
  if ( $report["reportFile"])   {
      $report["reportFile"] = (string)$report["reportFile"][0];
  } else   {
      $report["reportFile"] = "";
  }

  //replace the '$site', '$start', '$end', and '$pid' variables that are inside query strings
  $report["query"] = str_replace('$site', $site, $report["query"]);
  $report["query"] = str_replace('$start', $start, $report["query"]);
  $report["query"] = str_replace('$end', $end, $report["query"]);
  $report["query"] = str_replace('$pid', $pid, $report["query"]);
  $report["query"] = str_replace('$user', getSessionUser(), $report["query"]);

  //is this a reportSubSet rather then a report? (does it contain a list of reports?)
  if ($xml_report->report[0]) {
    $report["reportNameen"] = '<b>' . $report["reportNameen"] . '</b>';
    $report["reportNamefr"] = '<b>' . $report["reportNamefr"] . '</b>';
    $report["reportNamecr"] = '<b>' . $report["reportNamecr"] . '</b>';
    $report["reportFile"] = '<b>' . $report["reportFile"] . '</b>';
  }
  return $report;
}

function getReportSubsets($rtype) {
	$xml = loadXMLFile("jrxml/reports.xml");

	$reportSetArray = array();

	$xpath = "reportSet[@rtype='$rtype']/reportSubSet";
	//print "XPath: " . $xpath . "\n<br />";
	foreach ($xml->xpath($xpath) as $xml_report) {
    	$report = array("reportNameen" => $xml_report->xpath("title[@lang='en']"),
		  "reportNamefr" => $xml_report->xpath("title[@lang='fr']"),
		  "reportNamecr" => $xml_report->xpath("title[@lang='ht']"));

    	  if ($report["reportNameen"]) {
            $report["reportNameen"] = (string)$report["reportNameen"][0];
          } else {
            $report["reportNameen"] = "";
          }
          if ($report["reportNamefr"]) {
            $report["reportNamefr"] = (string)$report["reportNamefr"][0];
          } else {
            $report["reportNamefr"] = "";
          }
          if ($report["reportNamecr"]) {
            $report["reportNamecr"] = (string)$report["reportNamecr"][0];
          } else {
            $report["reportNamecr"] = "";
          }
	    $reportSetArray[] = $report;
     }
    return $reportSetArray;
}

function getEncounterWhere ($eid, $pid) {
	$where = "";
	// obtain keys from encounter table via query
	if (!empty($eid)) {
		$qry = "SELECT patientID, siteCode, visitDateDd, visitDateMm, visitDateYy, seqNum
			FROM encounter WHERE encounter_id = " . $eid . " and patientID = '" . $pid . "'";
		$result = dbQuery ($qry) or die ("FATAL ERROR: Unable to find encounter.");
		$keys = psRowFetch ($result);
		// the where clause for the table
		$where = "
			patientID =   '" . $keys[0] . "' AND
			siteCode  =   '" . $keys[1] . "' AND
			visitDateDd = '" . $keys[2] . "' AND
			visitDateMm = '" . $keys[3] . "' AND
			visitDateYy = '" . $keys[4] . "' AND
			seqNum = '" . $keys[5] . "'";
		$GLOBALS['existingData']['patientID'] = $keys[0];
		$GLOBALS['existingData']['siteCode'] = $keys[1];
		$GLOBALS['existingData']['visitDateDd'] = $keys[2];
		$GLOBALS['existingData']['visitDateMm'] = $keys[3];
		$GLOBALS['existingData']['visitDateYy'] = $keys[4];
		$GLOBALS['existingData']['seqNum'] = $keys[5];
	}
	return ($where);
}

function queryBlock ($lang, $where, $version, $tabCntLeft = 6000, $tabCntRight = 6500) {
	$risks = lookupRisks($lang, $version);
	$savedRisks = lookupSavedRisks($where);
	foreach ($risks as $allRisks) {
		$answer = "";
		$riskComment = "";
		$riskDd = "";
		$riskMm = "";
		$riskYy = "";   
		$ansType = "";
		$riskID = $allRisks['riskID'];
		$riskDesc = $allRisks['riskDesc' . $lang];
		$riskName = $allRisks['riskName'];
		$preMarkup = $allRisks['preMarkup'];
		$postMarkup = $allRisks['postMarkup'];
		$ansType = $allRisks['answerType'];
		foreach ($savedRisks as $curValues) {
			if ($riskID == $curValues['riskID'] || ($riskID == 21 && $curValues['riskID'] == 15) || ($riskID == 23 && $curValues['riskID'] == 12)) {
				$answer = $curValues['riskAnswer'];
				$riskComment = $curValues['riskComment'];
				$riskDd = $curValues['riskDd'];
				$riskMm = $curValues['riskMm'];
				$riskYy = $curValues['riskYy'];
				break;
			}
		}
		if (strpos($preMarkup,"pad"))
			$tabCntRight = displayRiskItem ($lang, $tabCntRight, $riskName, $riskDesc, $preMarkup, $postMarkup, $answer, $ansType, $riskComment, $riskDd, $riskMm, $riskYy, $encType);
		else
			$tabCntLeft  = displayRiskItem ($lang, $tabCntLeft,  $riskName, $riskDesc, $preMarkup, $postMarkup, $answer, $ansType, $riskComment, $riskDd, $riskMm, $riskYy, $encType);
	}
}

function lookupRisks ($lang, $version) {
	$version = 2;
	$risks = array();
	$qry = "select riskorder, fieldName as riskName, preMarkup, postMarkup, riskID, riskDesc" . $lang . ", answerType 
		from riskLookup l, riskOrder o
		where l.fieldname = o.riskName and o.formVersion = " . $version . "
		order by riskorder";
	$result = dbQuery ($qry) or die("Could not query for risk list.");
	while ($row = psRowFetch ($result))
		array_push ($risks, $row);
	return $risks;
}

function lookupSavedRisks ($where) {
	$savedRisks = array();
	if (!empty($where)) {
		$qry = "select riskID, riskAnswer, riskComment, riskDd, riskMm, riskYy
			from riskAssessments
			where " . $where;
		$result = dbQuery ($qry) or die("Could not query for current saved risks.");
		while ($row = psRowFetch ($result))
			array_push ($savedRisks, $row);
	}
	return $savedRisks;
}

function displayRiskItem ($lang, $tabNum, $riskName, $riskDesc, $preMarkup, $postMarkup, $answer, $ansType, $riskComment, $riskDd, $riskMm, $riskYy, $encType = 1) {
  // structures for various labels
  $ansLabels = array (
	  "en" => array ("Yes", "No", "Unk"),
	  "fr" => array ("Oui", "Non","Inc")
	);
	$dateLabel = array (
	   "en" => "DD/MM/YY",
	   "fr" => "JJ/MM/AA"
	);
	$maxI = 3;
	$ck = array (1,2,4);
	echo $preMarkup;
	switch ($ansType) {
	case "yesNoUnknown": 
	case "yesNo":  
		if ($ansType == "yesNo") $maxI = 2; 
		echo $riskDesc . "</td><td>";			
		echo "<table><tr><td id=\"" . $riskName . "AnswerTitle\"></td> ";
		// now want to define and display label and three check boxes
		for ($i = 0; $i < $maxI; $i++)
			echo "<td><input type=\"radio\" tabindex=\"" . $tabNum++ . "\"  id=\"" . $riskName . "Answer" . $i . "\" name=\"" . $riskName . "Answer[]\" value=\"" . $ck[$i] . "\" " . isItChecked($answer,$ck[$i]) . " /> " . $ansLabels[$lang][$i] . "</td> ";
		echo "</tr></table></td>";
		break;
	case "text":
		echo $riskDesc . "</td><td>";
		// just want a 40 character textfield filled with value if available
		echo "<table><tr><td colspan=\"3\"><input tabindex=\"" . $tabNum++ . "\" type=\"text\" size=\"40\" id=\"" . $riskName . "Comment\" name=\"" . $riskName . "Comment\" value=\"" . $riskComment . "\" />";
		echo "</td></tr></table>";
		break;
	case "yesNoYear":
		echo $riskDesc . "</td><td>";
		echo "<table><tr><td id=\"" . $riskName . "AnswerTitle\"></td> ";
		// now want to define and display label and three check boxes
		for ($i = 0; $i < 2; $i++)
			echo "<td><input type=\"radio\" tabindex=\"" . $tabNum++ . "\"  id=\"" . $riskName . "Answer" . $i . "\" name=\"" . $riskName . "Answer[]\" value=\"" . $ck[$i] . "\" " . isItChecked($answer,$ck[$i]) . " /> " . $ansLabels[$lang][$i] . "</td> ";
		echo "<td id=\"". $riskName . "DtTitle\"></td><td>
		 <input tabindex=\"" . $tabNum++ . "\"  type=\"text\" size=\"8\" id=\"" . $riskName . "Dt\" name=\"" . $riskName . "Dt\" value=\"" . getData ($riskName . "Dd", "textarea") . "/" . getData ($riskName . "Mm", "textarea") . "/" . getData ($riskName . "Yy", "textarea") . "\" />
		 <input type=\"hidden\"  id=\"" . $riskName . "Dd\" name=\"" . $riskName . "Dd\"  />
		 <input tabindex=\"" . $tabNum++ . "\"  type=\"hidden\"  id=\"" . $riskName . "Mm\" name=\"" . $riskName . "Mm\"  />
		 <input tabindex=\"" . $tabNum++ . "\"  type=\"hidden\"  id=\"" . $riskName . "Yy\" name=\"" . $riskName . "Yy\"  />
		</td><td>" . $dateLabel[$lang] . "</td></tr></table>";
		break;
	}
    echo $postMarkup;
    return ($tabNum++);
}

function isItChecked ($curValue = "", $bin = "") {
	if ($bin > 0) {
	  $binstring = strrev (decbin ($curValue));
	  return (!empty ($binstring{log ($bin, 2)}) && $binstring{log ($bin, 2)} == 1) ? " title=\"true\" checked" : "";
	} else {
	  return ($curValue == 1) ? "title=\"true\" checked" : "";
	}
}

function getPatientStatus ($pid) {
	$qry = "select patientStatus from patient where patientid = '" . $pid . "'";
	$result = dbQuery ($qry);
	$row = psRowFetch ($result);
		return ($row[0]);
}

function getPatientStatusArray ($curVal) {
	$valArray = array (2,4,8,16,32,64,128,256,512,1024,2048);
	$outArray = array();
	for ($i = 0; $i < 11; $i++) {
		$binstring = strrev (decbin ($curVal));
		if (!empty ($binstring{log ($valArray[$i], 2)}) && $binstring{log ($valArray[$i], 2)} == 1)
		 	$outArray[$i] = 1;
		else
			$outArray[$i] = 0;
	}
	return ($outArray);
}

function genCheckboxControl ($label, $lang, $name, $i, $passedIn) {
	$valArray = array (2,4,8,16,32,64,128,256,512,1024,2048);
	$curArray = getPatientStatusArray ($passedIn);
	$label = $label[$name][$lang][$i+1];
	if ($passedIn == 14)
		if ($i > 2) $passedIn = 0;
	if ($passedIn == 0) {
		$checked = "disabled";
		$label = setLabelDisabled($label, $passedIn);
	} else if ($curArray[$i] == 1)
		$checked = "checked";
	else
		$checked = "";
	return "<input type=\"checkbox\" name=\"" . $name . $i . "\" value=\"" . $valArray[$i] . "\" " . $checked . ">" . $label;
}

function setLabelDisabled ($label, $passedIn) {
	if ($passedIn == 0)
		$label = "<font color=\"#C0C0C0\">" . $label . "</font>";
	return ($label);
}

function loadDropdown($entity, $lang, $user, $gLevel, $curValue, $defaultOverride) {
	$retVal = "";
	$siteChoose = array (
	   "en" => array (
		"",
		"All",
		""),
	   "fr" => array (
		"",
		"Tous",
		"")
	);
	$sites = getEntity ($user, $entity);
	$ddName = $entity;
	$ddColumn = $entity;
	if ($gLevel == 0) $disabled = "disabled";
	else $disabled = "";
	$default = getDefaultEntity ($user, $ddColumn);
	if ($defaultOverride == "selected") $default = "";
	$retVal = "<select" . ($_GET["noid"] == "true" || SERVER_ROLE == "consolidated" ? " multiple" : "") . " name=\"" . $ddName . "\" " . $disabled . ">";
	if ($user == "")
		$retVal .= "<option value=\"\">" . $siteChoose[$lang][1];
	else if ($user == "9999") 
		$retVal .= "<option value=\"\" selected></option>";
	else if (!empty ($defaultOverride))
		$retVal .= "<option value=\"All\" " . $defaultOverride . ">" . $siteChoose[$lang][1];
	$lastEntity = "";
	foreach ($sites as $row) {
		if ($lastEntity != $row[$ddColumn]) {
			if ($row[$ddColumn] == $default) $selected = "selected";
			else if ($curValue == $row[$ddColumn]) $selected = "selected";
			else $selected = "";
			if ($user == "")
				$curRow = $row[$ddColumn];
			else
				$curRow = $row["siteCode"];
			$retVal .= "<option value=\"" . $curRow . "\"" . $selected . ">" . $row[$ddColumn] . "</option>";
		}
		$lastEntity = $row[$ddColumn];
	}
	$retVal .= "</select>";
	return $retVal;
}

function loadAllDropdown($entity, $lang, $curValue) {
	$retVal = "";
	$siteChoose = array (
	   "en" => array (
		"",
		"All",
		""),
	   "fr" => array (
		"",
		"Tous",
		"")
	);
	$sites = getAllEntities ($entity);
	$ddName = $entity;
	$ddColumn = $entity;
	$retVal = "<select name=\"" . $ddName . "\">";
	if ($curValue == "All")
		$retVal .= "<option value=\"All\" selected>" . $siteChoose[$lang][1];
	else
		$retVal .= "<option value=\"All\">" . $siteChoose[$lang][1];
	foreach ($sites as $row) {
		$curRow = $row[$ddColumn];
		if ($curValue == $curRow) $selected = "selected";
		else $selected = "";
		$retVal .= "<option value=\"" . $curRow . "\"" . $selected . ">" . $row[$ddColumn] . "</option>";
	}
	$retVal .= "</select>";
	return $retVal;
}

function loadHivQualDropdown($lang, $siteList) {
       $retVal = "";
       $sites = array ();
       $qry = "SELECT distinct clinic, siteCode from clinicLookup where inCPHR = 1 order by 1";
       $result = dbQuery ($qry);
       while ($row = psRowFetch ($result))
               array_push ($sites, $row);
       $ddColumn = "clinic";
       $retVal = "<select multiple name=\"clinic\" size=\"6\">";
       foreach ($sites as $row) {
               $curRow = $row["siteCode"];
               if ($curRow == "0") continue;
               if (in_array ($curRow, $siteList)) $selected = "selected";
               else $selected = "";
               $retVal .= "<option value=\"" . $curRow . "\" " . $selected . ">" . $row[$ddColumn] . "</option>\n";
       }
       $retVal .= "</select>\n";
       return $retVal;
}

function findSites ($dept = "", $commune = "", $clinic = "", $sitecode = "", $network = "", $sysFlag) {
	$whereClause = " 1=1 ";
	if ($sysFlag) {
		$whereClause .= " and inCPHR = 1";
	}
	if (!empty ($dept) && $dept != "All") {
		if (strpos ($dept, "'") !== false) $dept = str_replace ("'", "''", $dept);
		$whereClause .= " and department = '" . $dept . "'";
	}
	if (!empty($commune) && $commune != "All") {
		if (strpos ($commune, "'") !== false) $commune = str_replace ("'", "''", $commune);
		$whereClause .= " and commune = '" . $commune . "' ";
	}
	if (!empty($clinic) && $clinic != "All") {
		if (strpos ($clinic, "'") !== false) $clinic = str_replace ("'", "''", $clinic);
		$whereClause .= " and clinic = '" . $clinic . "'";
	}
	if (!empty($sitecode))
		$whereClause .= " and sitecode like '" . $sitecode . "%'";
	if (!empty($network) && $network != "All") {
		if (strpos ($network, "'") !== false) $network = str_replace ("'", "''", $network);
		$whereClause .= " and network = '" . $network . "'";
	}
	// Do query
	$results = array ();
	$qry = "SELECT inCPHR, department, commune, clinic, sitecode, dbSite, ipAddress, network FROM clinicLookup where " . $whereClause . " order by 2,3,4";
	if (DEBUG_FLAG) print $qry;
	$result = dbQuery ($qry);
	if (!$result)
		print "FATAL ERROR: Could not search site lookup table." . $qry;
	else {
	  while ($row = psRowFetch($result)) {
	    array_push($results, $row);
	  }
	}
	return ($results);
}

function crossTabReport ($lang, $pid) {
	$dateLabel = array ("en" =>  "Visit Date", "fr" => "Date de visite");
	$noRowsLabel = array ("en" =>  "No lab results found.", "fr" => "Aucuns r&eacute;sultats de laboratoire trouv&eacute;s.");

	$testArray = array();
	$qry = "select distinct testname" . $lang . " as test from v_labs where patientid = '" . $pid . "' and
		((result is not null and result != '') or (result2 is not null and result2 != '') or (result3 is not null and result3 != ''))
		  order by 1";
	$result = dbQuery ($qry);
	while ($row = psRowFetchAssoc ($result))
		array_push ($testArray, $row['test']);

	$qry = "select distinct visitDate, testname" . $lang . " as test,
		result as result, result2, result3, resultAbnormal as abnorm
 		from v_labs
		where patientid = '" . $pid . "' and
		((result is not null and result != '') or (result2 is not null and result2 != '') or (result3 is not null and result3 != ''))
		order by 1,2";
	$result = dbQuery($qry);

	echo '<table class="crossTabReport" border="1">';
	$row = psRowFetchAssoc($result);
	if ($row) {
	  echo "<tr>";
	  echo "<th>" . $dateLabel[$lang] . "</th>";
	  for ($testCnt = 0; $testCnt < count($testArray); $testCnt++)
	    echo "<th>" . $testArray[$testCnt] . "</th>";
	  echo "</tr>";
	  $lastDate = "";
	  $lastTestCnt = -1;
	  while ($row) {
	    $curDate = $row['visitDate'];
	    $curTest = $row['test'];
	    $curResult = $row['result'] . $row['result2'] . $row['result3'];
	    if ($row['abnorm'] == 1) {
	      $curResult = "<font color=\"red\">" . $curResult . "</font>";
	    }
	    if ($lastDate != $curDate) {
	      if ($lastDate != "") {
		for ($i = $lastTestCnt + 1; $i < count($testArray); $i++) {
		  echo "<td align=\"right\">&nbsp;</td>";
		}
		echo "</tr>";
	      }
	      $lastTestCnt = -1;
	      echo "<tr><td align=\"right\">" . formatDisplayedDate ('',$curDate,$lang) . "</td>";
	    }
	    for ($testCnt = $lastTestCnt + 1; $testCnt < count($testArray); $testCnt++) {
	      if ($curTest == $testArray[$testCnt]) {
		echo "<td align=\"right\">" . $curResult . "</td>";
		$lastTestCnt = $testCnt;
		break;
	      } else {
		echo "<td align=\"right\">&nbsp;</td>";
	      }
	    }
	    $lastDate = $curDate;
	    $row = psRowFetchAssoc($result);
	  }

	  for ($i = $lastTestCnt + 1; $i < count($testArray); $i++) {
	    echo "<td align=\"right\">&nbsp;</td>";
	  }
	  echo "</tr>";
	} else {
	  echo "<tr><td>" . $noRowsLabel[$lang] . "</td></tr>";
	}
	echo '</table>';
}

function patientVisitPlot ($lang, $site, $begin, $end) {
	$dateLabel = array ("en" =>  "Pid/YMM", "fr" => "Pid/AMM");
	$dateArray = array();

	/*$lang  = $_GET['lang'];
	$site  = $_GET['site'];
	$begin = $_GET['begin'];
	$end   = $_GET['end'];*/

	// query for all dates (months) involved
	$qry = "select distinct
		year(visitdate)*100+month(visitdate)-200000 as foo
		from encValid e, patient p
		where
		e.patientid = p.patientid and
		sitecode like '" . $site . "' and
		visitdate between '" . $begin . "' and '" . $end . "'
		order by 1";

	// load the date array
	$result = dbQuery ($qry);
	while ($row = psRowFetchAssoc ($result))
		array_push ($dateArray, $row['foo']);

	// query for patient visits
	$qry = "select distinct p.patientid,
		year(visitdate)*100+month(visitdate)-200000 as foo,
		case
		when encountertype = 10 then 0
		when encountertype = 14 then 8
		else encountertype
		end as encountertype
		from encValid e, patient p
		where e.patientid = p.patientid and
		sitecode like '" . $site . "' and
		visitdate between '" . $begin . "' and '" . $end . "'
		order by 1,2,3";
	$result = dbQuery ($qry);

	$finalArray = array();
	$lastPatient = "";
	$ii = 0;
	while ($row = psRowFetchAssoc ($result)) {
		$curPatient = $row["patientid"];
		$curDate = $row["foo"];
		switch ( $row["encountertype"] ) {
		case "2":
			$curResult = "<font color=\"blue\">f</font>";
			break;
		case "5":
			$curResult = "p";
			break;
		case "6":
			$curResult = "l";
			break;
		case "0":
			$curResult = "r";
			break;
		case "1":
			$curResult = "<font color=\"green\">i</font>";
			break;
		case "3":
			$curResult = "c";
			break;
		case "4":
			$curResult = "d";
			break;
		case "7":
			$curResult = "h";
			break;
		case "8":
			$curResult = "a";
			break;
		case "11":
			$curResult = "s";
			break;
		case "12":
			$curResult = "<font color=\"red\">x</font>";
			break;
		default:
			$curResult = "";
			break;
		}
		if ($lastPatient != $curPatient) {
			// store previous patient's array
			if ($ii != 0) $finalArray[$lastPatient] = $patArray;
			// initialize new patientArray
			$patArray = array();
			foreach ($dateArray as $date)
				$patArray[$date] = "";
		}
		$patArray[$curDate] .= $curResult;

		// save patientid
		$lastPatient = $curPatient;
		$ii++;
		//if ($ii > 2000) break;
	}
	$finalArray[$lastPatient] = $patArray;

	echo "
	<table class=\"crossTabReport\" border=\"1\">
	<tr>
		<th>Code</th><th align=\"left\">Encounter Type</th>
		<th>Code</th><th align=\"left\">Encounter Type</th>
		<th>Code</th><th align=\"left\">Encounter Type</th>
		<th>Code</th><th align=\"left\">Encounter Type</th>
	</tr>
	<tr>
		<td>r</td><td>Registration</td>
		<td>c</td><td>Counseling intake</td>
		<td>l</td><td>Laboratory</td>
		<td>s</td><td>Selection committee</td>
	</tr>
	<tr>
		<td><font color=\"green\">i</font></td>
		<td>Intake</td><td>d</td><td>Counseling followup</td>
		<td>h</td><td>Home visit</td>
		<td><font color=\"red\">x</font></td><td>Discontinuation</td>
	</tr>
	<tr>
		<td><font color=\"blue\">f</font></td><td>Followup</td>
		<td>p</td><td>Pharmacy</td>
		<td>a</td><td>Adherence</td>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	</table>";

	echo '<table class="crossTabReport" border="1">';
	// generate the table body
	foreach ($finalArray as $patient => $visit) {
		echo "<tr>";
		echo "<td>" . $patient . "</td>";
		foreach ($dateArray as $date) {
			$curVisit = $visit[$date];
			if ($curVisit == "") $curVisit = "<spacer type=\"block\" height=\"1\" width=\"1\">";
			echo "<td height=\"5\">" . $curVisit . "</td>";
		}
		echo "</tr>";
	}
	echo '</table>';
}

// initializes pidList Session variable
function initPidList() {
	$_SESSION["pidList"] = "";
}

// adds the specified pid at the end of the existing session variable pidList
function addPidList ($pid) {
	$currList = $_SESSION["pidList"];
	if (strlen($currList) == 0)  $_SESSION["pidList"] = $pid;
	else {
		if  (strpos($currList, $pid) === false)
		$_SESSION["pidList"] = $_SESSION["pidList"] . "," . $pid;
	}
}

function getSymptoms($pid, $lang, $headers=NULL) {
	$foo = array (
	"anorexia" => array ("Anorexie/Perte d'app&eacute;tit", " Appetite loss"),
	"weightLossLessTenPercMo" => array ("Perte de poids <10%", " Weight loss <10%"),
	"weightLossPlusTenPercMo" => array ("Perte de poids >10%", " Weight loss >10%"),
	"diarrheaLessMo" => array ("Diarrh&eacute;e <1 mois", " Diarrhea <1 month"),
	"diarrheaPlusMo" => array ("Diarrh&eacute;e >1 mois sans cause identifiée", " Diarrhea >1 month unexplained"),
	"chronicWeakness" => array ("Fatigue chronique", " Fatigue"),
	"feverLessMo" => array ("Fi&egrave;vre <1 mois", " Fever <1 month"),
	"feverPlusMo" => array ("Fi&egrave;vre >1 mois sans cause identifiée", " Fever >1 month unexplained"),
	"nightSweats" => array ("Sueurs nocturnes", " Night sweats"),
	"lymphadenopathies" => array ("Lymphadenopathies (Stade I)", " Lymphadenopathies (Stage I)"),
	"prurigo" => array ("Prurigo (Stade II)", " Prurigo"),
	"cough" => array ("Toux", " Cough, non-productive"),
	"dyspnea" => array ("Dyspn&eacute;e", " Dyspnea"),
	"expectoration" => array ("Toux/Expectoration (sauf h&eacute;moptysie)", " Cough, productive"),
	"hemoptysie" => array ("H&eacute;moptysie", " Hemoptysis"),
	"odynophagia" => array ("Odynophagie/dysphagie", " Odynophagia/dysphagia"),
	"abPain" => array ("Douleur abdominale", " Abdominal pain"),
	"headache" => array ("C&eacute;phal&eacute;e", " Headache"),
	"nausea" => array ("Naus&eacute;e", " Nausea"),
	"numbness" => array ("Perte de sensibilit&eacute;", " Numbness/tingling"),
	"sympRash" => array ("Eruption cutan&eacute;e", " Rash"),
	"vomiting" => array ("Vomissement", " Vomiting"),
	"asymptomaticWho" => array ("Asymptomatique", " Asymptomatic")
	);
	$targetList = "";
	foreach ($foo as $key => $value) {
		$targetList .= ", " . $key;
	}
	// now using concept dictionary instead of symptoms table for symptoms
	//$query = "select visitdate, (visitdatedd + '/' + visitdatemm + '/20' + visitdateyy) as vDate " . $targetList . " from v_symptoms  where patientid = '" . $pid . "' order by visitdate desc";
	$query = "select visitdate, (visitdatedd + '/' + visitdatemm + '/20' + visitdateyy) as vDate, c.short_name from encValid e, concept c, obs o where e.encounter_id = o.encounter_id and c.concept_id = o.concept_id and patientid = '" . $pid . "' order by visitdate desc";
	$result = dbQuery ($query);
	if ($lang == "fr") $kk = 0;
	else $kk = 1;
	$retVar = "<table class=\"cover\">";
	if($headers){
		foreach($headers as $head){
			$retVar .= "<th><b>".$head."</b></th>";
		}
	}
	while ($row = psRowFetch($result)) {
		foreach ($foo as $key => $value) {
//			if ($row[$key] == 1) $retVar .= "<tr><td class=\"cover\">" . $value[$kk] . "</td><td class=\"cover\">" . $row["vDate"] . "</td></tr>";
			if ($row['short_name'] == $key) $retVar .= "<tr><td class=\"cover\">" . $value[$kk] . "</td><td class=\"cover\">" . $row["vDate"] . "</td></tr>";
		}
	}
	$retVar .= "</table>";
	return ($retVar);
}

function fetchQueryColumns($qry) {
	$colArray = array();
	$result = dbQuery($qry);
	while ($row = psRowFetch($result)) {
		switch ($row['data_type']) {
			case "tinyint":
				$type = "bool";
				break;
			default:
				$type = "string";
		}
		if (strpos(strtolower($row['column_name']),"date") > 0) $type = "date";
		$colArray[$row['column_name']] = array ($type, $row['character_maximum_length']);
	}
	return ($colArray);
}

require_once 'labels/labels.php';
require_once 'labels/followup.php';
function getLabel($labelVariableName) {
  if ($labelVariableName != '' &&
      isset($GLOBALS[$labelVariableName]) &&
      isset($GLOBALS[$labelVariableName]['fr']) &&
      isset($GLOBALS[$labelVariableName]['en'])) {
    return $GLOBALS[$labelVariableName];
  } else {
    return array();
  }
}

function formStatusMessage ($lang, $status, $formStatus){
	$encMessage = "";
	switch ($status) {
	case "1":
	case "3":
	case "5":
	case "7":
		$encMessage = $formStatus[$lang][2];
	}
	switch ($status) {
	case "2":
	case "3":
	case "6":
	case "7":
		if ($encMessage != "") $encMessage .= ", ";
		$encMessage .= $formStatus[$lang][4];
	}
	switch ($status) {
	case "4":
	case "5":
	case "6":
	case "7":
		if ($encMessage != "") $encMessage .= ", ";
		$encMessage .= $formStatus[$lang][5];
	}
	return ($encMessage);
}

function recordEvent($eventType, $eventParameters) {
	$dbSite = DB_SITE;
	$username = getSessionUser();
	$siteCode = isset($_GET['site']) ? substr ($_GET['site'], 0, 5) : '';
	$eParams = json_encode($eventParameters);
	$eParams = str_replace('\'', '\'\'', $eParams);
	$qry = "INSERT INTO eventLog (dbSite, siteCode, username, eventDate, eventType, eventParameters)
VALUES (" . $dbSite . ",'" . $siteCode . "','" . $username . "','" . date ("Y-m-d H:i:s") . "','" . $eventType . "','" . $eParams . "')";
	dbQuery ($qry);
}

function outputEvents ($eventType, $startDate) {
	$qry = "select * from eventLog where eventDate >= '" . $startDate . "' and eventType in ('" . $eventType . "') order by eventDate desc";
	$finalArray = array();
	$result = dbQuery ($qry) or die ("failed to run query for events");
	while ($row = psRowFetch ($result))
		array_push($finalArray, $row);
	return ($finalArray);
}

//generates a temporary file name using the curent user name and temp directory
//$baseName is something to uniquely identify the file
// for example if this is for the sql log $baseName might be 'sql'
//$extension is the file's type extension without a . character
// if $extension is empty no trailing . will be added.
function getTempFileName($baseName, $extension) {
  $username = getSessionUser();

  //make sure there are no special character in any of our input variables
  //this makes it impossible to grab a file outside of the temp folder or another users temp file
  $baseName = ereg_replace('[^A-Za-z0-9]', '', $baseName);
  $extension = ereg_replace('[^A-Za-z0-9]', '', $extension);
  $username = ereg_replace('[^A-Za-z0-9]', '', $username);

  if ($extension != '') {
    $extension = '.' . $extension;
  }
  return TEMP_DIR . DIRECTORY_SEPARATOR . $baseName . '-' . $username . $extension;

  
}

function createTempTables ($prefix, $cnt, $defs, $idx = "") {
  $tableNames = array ();
  $user = substr (getSessionUser (), 0, 3);
  for ($i = 1; $i <= $cnt; $i++) {
    $tableNames[$i] = $prefix . $i . $user;
    dropTempTables (array ($tableNames[$i]));
    dbQuery("CREATE TABLE " . $tableNames[$i] . " (" . (is_array ($defs) ? $defs[$i - 1] : $defs) . ")");
    if (!empty ($idx)) {
      list ($name, $def) = explode ('::', (is_array ($idx) ? $idx[$i - 1] : $idx));
      dbQuery("CREATE INDEX $name ON " . $tableNames[$i] . " (" . $def . ")");
    }
  }
  return ($tableNames);
}

function dropTempTables ($names) {
  foreach ($names as $name) {
    dbQuery("DROP TABLE IF EXISTS " . $name);
  }
}

function dumpTempTables ($names) {
  foreach ($names as $name) {
    echo "<BR/>\n<BR/>\nDumping table '$name':<BR/>\n";
    $result = dbQuery ("SELECT * FROM $name");
    $j = 0;
    while ($row = psRowFetchAssoc($result)) {
      $i = 0;
      echo ++$j . ", ";
      foreach ($row as $n => $v) {
        $i++;
        echo "$n: '" . $v . "'";
        if ($i < count ($row)) echo ", ";
      }
      echo "<BR/>\n";
    }
  }
}

//Gather up the value from the first column in a result set and return them all as an array.
function fetchFirstColumn($result) {
  $array = array();
  while ($row = psRowFetch($result)) {
    array_push($array, $row[0]);
  }
  return $array;
}

function monthDiff ($cnt, $date = null) {
  /* add $cnt months to $date ('now' if null), return date as "Y-m-d" */
  if (is_null($date)) {
    $timestamp = time();
  } else {
    $timestamp = strtotime($date);
  }
  $midmonth = mktime (12, 0, 0, date ('n', $timestamp) + $cnt, 15, date ('Y', $timestamp));
//  return date ("Y-m-d", date ('t', $timestamp) > date ('t', $midmonth) ? strtotime (date ("t F Y", $midmonth)) : strtotime (date (date ('d', $timestamp) . " F Y", $midmonth)));
  return date ("Y-m-d", strtotime (date ("t F Y", $midmonth)));
}

function dayDiff ($cnt, $date = null) {
  /* add $cnt days to $date ('now' if null), return date as "Y-m-d" */
  if (is_null($date)) {
    $timestamp = time();
  } else {
    $timestamp = strtotime($date);
  }
  $newdate = mktime (12, 0, 0, date ('n', $timestamp), date ('j', $timestamp) + $cnt, date ('Y', $timestamp));
  return date ("Y-m-d", $newdate);
}

/* Returns the current age of the patient, based on current date and dob
 * If dob is not filled in at all, returns null
 */
function getCurrentAgeYears($pid) {
  $isPed = 0;
	$qry = "select case 
	when upper(dobyy) != ? and upper(dobmm) != ? and upper(dobdd) != ? and isdate(ymdtodate(dobyy,dobmm,dobdd)) = 1 then ymdToDate(dobyy,dobmm,dobdd)
	when upper(dobyy) != ? and upper(dobmm) != ? and upper(dobdd) = ? and isdate(ymdtodate(dobyy,dobmm, ?)) = 1 then ymdToDate(dobyy,dobmm, ?)
	when upper(dobyy) != ? and upper(dobmm) = ? and upper(dobdd) = ? and isnumeric(dobyy) = 1 then dobyy else 0 end as ageBirthday from patient where patientid = ?";
	$ageData = database()->query($qry, array('XXXX','XX','XX','XXXX','XX','XX','01','01','XXXX','XX','XX',$pid))->fetchAll();
  //echo $ageData[0]['ageBirthday'];
  if ($ageData[0]['ageBirthday'] == '0'){
    $ageDisplay = _('Inconnu');
  }
  if (substr_count($ageData[0]['ageBirthday'],"-") == 0 ) {
    $ageBirthday = $ageData[0]['ageBirthday'] . "-01-01";
  } else {
    $ageBirthday = $ageData[0]['ageBirthday'];
  }
  $dateNow = date('Y-m-d');

  // End age calculator
  list($months, $days) = diff_date($ageBirthday, $dateNow);
  if (!$ageDisplay) {
    if ($months == 0 && $days == 0) {
      $ageDisplay = _('Inconnu'); // Doesn't understand people born today
    } elseif ($months == 0 && $days > 0) {
      $ageDisplay = $days . " " . _("j");
      $isPed = 1;
    } elseif ($months > 0 && $months < 36) {
      $ageDisplay = $months . " " . _("m");
      $isPed = 1;
    } else {
      $ageDisplay = floor($months/12) . " " . _("a");
      // 3 means greater than 5 and less than/equal to 19
      if ($months/12 <= 19) $isPed = 3;
      // 2 means greater than 5 and less than/equal to 10
      if ($months/12 <= 10) $isPed = 2;
      // 1 means 0 to 5
      if ($months/12 <= 5) $isPed = 1;
    }
  }
  $ageArray[] = $ageDisplay;
  $ageArray[] = $isPed;
	return $ageArray;    
} 

// Required to properly calculate age in months due to different month length.
// PHP5.3 has these functions built in and will make it much easier.
function diff_date($start_date, $end_date) {
  list($start_year, $start_month, $start_day) = explode('-', $start_date);
  list($end_year, $end_month, $end_day) = explode('-', $end_date);
  $month_diff = $end_month - $start_month;
  $day_diff   = $end_day - $start_day;
  $months = $month_diff + ($end_year - $start_year) * 12;
  $days = 0;
  if ($day_diff > 0) {
    $days = $day_diff;
  }
  else if ($day_diff < 0) {
    $days = $end_day;
    $months--;
    if ($month_diff > 0) {
      $days += 30 - $start_day;
      if (in_array($start_month, array(1, 3, 5, 7, 8, 10, 12))) {
        $days++;
      }
      else if ($start_month == 2) {
        if (($start_year % 4 == 0 && $start_year % 100 != 0) || $start_year % 400 == 0) {
          $days--;
        }
        else {
          $days -= 2;
        }
      }
      if (in_array($end_month - 1, array(1, 3, 5, 7, 8, 10, 12))) {
        $days++;
      }
      else if ($end_month - 1 == 2) {
        if (($end_year % 4 == 0 && $end_year % 100 != 0) || $end_year % 400 == 0) {
          $days--;
        }
        else {
          $days -= 2;
        }
      }
    }
  }
  return array($months, $days);
}

function getMasterPid ($pid) {
	$data = database()->query('select masterPid from patient where patientid = ?',array($pid))->fetchAll();
	return ($data[0]['masterPid']);
} 

function updateMasterPid ($pid, $mpid) {
  $queryStmt = "UPDATE patient SET masterPid = '$mpid' WHERE patientID = '$pid'";
  dbQuery ($queryStmt);
}

function getPidByOtherID ($cpid, $site = "", $idType) {
	switch ($idType) {
        case 'patGuid':
                // Need an extra check here because the sense of the ID
                // in 'masterPid' is different depending on if the patient
                // has been involved in a merge and/or if they've had a records
                // request loaded into their record and/or if they've been
                // assigned a new masterPid from the national fingerprint
                // database.  Basically, the only time to use masterPid in
                // this function is when 'patStatus' is 1 (locally merged
                // record). However, there is also a need to cover the case
                // where a previous merger becomes a mergee and a series of
                // masterPids needs to be followed.

                // Get data for matching patGuid record
                $data = database()->query ('
                  SELECT patientID, masterPid, patStatus
                  FROM patient
                  WHERE patGuid = ?', array ($cpid))->fetchAll();

                // Now follow chain of merged records until patStatus <> 1
                while ($data[0]["patStatus"] == 1) { 
                  $data = database()->query ('
                    SELECT patientID, masterPid, patStatus
                    FROM patient
                    WHERE patientID = ?', array ($data[0]["masterPid"]))->fetchAll();
                }

                $qry = "SELECT ? AS theID";
                $valArray = array ($data[0]["patientID"]);
                break;
	case 'clinicPatientID':
		$qry = "select patientID as theID from patient where clinicPatientID = ? and location_id = " . $site . " limit 1";
		$valArray = array($cpid);
		break;
	default:
		if ($idType == 'pcID') $idType = 'primCareID';
		$qry = "select concat(location_id, person_id) as theID from obs o, concept c 
		where o.concept_id = c.concept_id and short_name = ? and location_id = " . $site . " and value_text = ? limit 1";
		$valArray = array($idType, $cpid);
	}
	$rowVal = database()->query($qry, $valArray)->fetchAll(); 
	return ($rowVal[0]['theID']);
}

/* returns specific patient ids of type HIV (st) primary care (pc) or ob-gyn (ob)
 * given a patientID (pid);
 */
function getID ($pid, $idType) {
	if ($idType == "st") {
		$sql = "select clinicPatientID as id from patient where patientid = ?";
		$bind = array($pid);
	} else {
		$sql = "select value_text as id from obs where concept_id = ? and location_id = ? and person_id = ?";
		$cid = ($idType == "pc") ? 70039 : 70040; 
		$bind = array($cid, substr($pid,0,5), substr($pid,5));
	}
	$result = database()->query($sql, $bind)->fetchAll();
	return $result[0]['id'];
}

?>
