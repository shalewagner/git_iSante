<?
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';

header('Content-Type: text/javascript; charset=UTF-8');  
chdir('..');
require_once "backend.php"; 


$stCode=$_REQUEST['stCode'];
$siteCode=$_REQUEST['siteCode'];
$visitDate=$_REQUEST['visitDate'];
$result=$_REQUEST['result'];
$resultDate=$_REQUEST['resultDate'];
$note=$_REQUEST['note'];

$resultLab=0;

$patientid=getPatient($stCode,$siteCode);
if($patientID<>''){
    $orderDate= checkOrderDate($patientid,$siteCode,$visitDate);
    if($orderDate==null) {
         	$result=saveEncounter($patientID,$site,$visit);
	        if($result) { $resultLab=saveLabs($patientid,$siteCode,$visitDate,$result,$resultDate,$note);}
    }
    else  {
	        $resultLab=updateLabs($patientid,$siteCode,$visitDate,$result,$resultDate,$note);
    }
}

if($resultLab)
	echo 'result load successfully';
else 
	echo 'Cannot load result';


function saveEncounter($patientID,$site,$visit)
{
		$visitArray = split('-', $visit);
		$ry ='';
		$rm ='';
		$rd ='';
		if (count($visitArray) == 3) {
			$ry = substr($visitArray[0],2);
			$rm = $visitArray[1];
			$rd = $visitArray[2];
		}
		$date = date('Y-m-d', time());

	$sql = "insert into encounter (siteCode,patientID,visitDateDd,visitDateMm,visitDateYy,lastModified,encounterType,seqNum,encStatus,encComments,dbSite,visitPointer,formAuthor,formVersion,labOrDrugForm,creator,createDate,lastModifier,badVisitDate,visitDate) values (?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?)"; 
	$rc = database()->query($sql,array(($site,$patientID,$rd,$rm,$ry,$date ,6,0,0,'',DB_SITE,0,'admin',3,0,'admin',$date ,'admin',0,$visit)));
	
	return $rc->rowCount();	
}

function saveLabs($patientID,$site,$visit,$result,$resultDate,$note)
{
	$visitArray = split('-', $visit);
		$ry ='';
		$rm ='';
		$rd ='';
		if (count($visitArray) == 3) {
			$ry = substr($visitArray[0],2);
			$rm = $visitArray[1];
			$rd = $visitArray[2];
		}
		
		$resultArray = split('-', $resultDate);
		$rdy ='';
		$rdm ='';
		$rdd ='';
		if (count($resultArray) == 3) {
			$rdy = substr($resultArray[0],2);
			$rdm = $resultArray[1];
			$rdd = $resultArray[2];
		}
	
	$sql = "insert into labs (patientID, dbsite, sitecode, visitdateDd, visitdateMm, visitdateYy, seqNum, labid, ordered, labGroup, testnamefr,sampletype,result,resultdateyy,resultdatemm,resultdatedd,resultRemarks) values (?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?)"; 
	$rc = database()->query($sql,array(($patientID,DB_SITE,$rd,$rm,$ry,0,103,1,1,'Biologie moleculaire','Charge virale','iSanté',$result,$rdy,$rdm,$rdd,$note)));
	
	return $rc->rowCount();
}

function updateLabs($patientID,$site,$visit,$result,$resultDate,$note)
{
 	  $query="update labs l
                   set l.result=?,
                   l.resultDateDd=Day(date(?)),
                   l.resultDateMm=Month(date(?)),
                   l.resultDateYy=date_format(date(?),?),
                   l.resultRemarks=?
             where l.patientID=? and 
	               l.labID IN (103, 1257) and 
	               ymdToDate(visitDateYy,visitDateMm,visitDateDd)=date(?)";				   
	$result=database()->query($query,array($result,$resultDate,$resultDate,$resultDate,'%y',$note,$patientID,$visit));  
	return result->rowCount(); 
}

function getPatient($st,$site){
	$sql ="SELECT patientID,clinicPatientid AS STfromFile,DIGITS(clinicPatientid) AS numericDigitsST, DIGITS(clinicPatientid)+0 AS numericST
FROM patient WHERE location_id = ".$site." AND DIGITS(clinicPatientid)+0 = DIGITS(".$st.")+0";
$result = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
$patientID='';
if (count($result) > 0) {
 $patientID=$result[0]['patientID'];
}	
return $patientID;	
}


function checkOrderDate($patientID,$site,$visit){
	$sql ="SELECT  ymdToDate(visitDateYy,visitDateMm,visitDateDd) as visitDate,patientID,
	FROM labs WHERE siteCode = ".$site." AND patientID =".$patientID." and l.labID IN (103, 1257) and ymdToDate(visitDateYy,visitDateMm,visitDateDd)=".$visit;
$result = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
$visitDate=null;
if (count($result) > 0) {
 $visitDate=$result[0]['visitDate'];
}	
return $visitDate;	
}


?>  
