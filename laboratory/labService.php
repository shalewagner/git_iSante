<? 
header('Content-Type: text/javascript; charset=UTF-8');  
chdir('..');
require_once "backend.php"; 

switch ($_REQUEST['task']) {
	case 'getOrdered':  
	        // check to see if order has been sent; hide OE catalog items with no results; show OE catalog with results 
	        $sql = "select count(*) as cnt from encounterQueue 
	        where encounter_id = " . $_REQUEST['eid'] . " and left('" . $_REQUEST['pid'] . "',5) = sitecode and encounterStatus in (1,2,6)";
	        $queue = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
		if (intval($queue[0]['cnt']) > 0) { 
		  /* the 1st select in the union gets non-OE-catalog items when there is an OE order
		   * the 2nd select in the union gets OE items that have results already returned
		   */
                  $sql = "(
                    select visitDate as vDate, labID as labid, labGroup, replace(testNameFr,'\'','’') as testNameFr, 
                        result, result2, result3, resultAbnormal, resultRemarks, ymdtodate(resultdateyy,resultdatemm,resultdatedd) resultDate, 
        		accessionNumber, sendingSiteName, sampleType as sampletype, 'T' as theType, 1
        		from a_labs 
        		where encounter_id = " . $_REQUEST['eid'] . " and 
        		patientid = '" . $_REQUEST['pid'] . "' 
        		and (labid < 1000 or sampletype in ('isante', 'iSanté', 'isanté', 'iSante'))
        	    ) union (
        	    select ymdtodate(visitDateyy,visitdatemm,visitdatedd), labID, labGroup, replace(testNameFr,'\'','’'),
        	        result, result2, result3, resultAbnormal, resultRemarks, date(resultTimestamp), 
        		q.accessionNumber, sendingSiteName, sampleType, 'T', 1
        		from labs l, encounterQueue q 
        		where patientid = '" . $_REQUEST['pid'] . "' and
        		l.sitecode = left('" . $_REQUEST['pid'] . "',5) and
        		l.sitecode = q.sitecode and
        		q.encounter_id = " . $_REQUEST['eid'] . " and  
        		left(l.accessionNumber,instr(l.accessionNumber,'-')-1) = q.accessionNumber and
        		q.encounterStatus = 6)";
		} else {  
		        $where = getEncounterWhere ($_REQUEST['eid'], $_REQUEST['pid']); 
		        /* this query fetches all order items when OE is not configured or when the order has not yet been sent to the lab
		         * the 1st select gets all simple order items and the 2nd select gets panels if OE is configured
		         */
        		$sql = "
        		(select visitDate as vDate, labID as labid, o.labgroup as labGroup, replace(testNameFr,'\'','’') as testNameFr, 
                        result, result2, result3, resultAbnormal, resultRemarks, ymdtodate(resultdateyy,resultdatemm,resultdatedd) as resultDate, 
        		accessionNumber, sendingSiteName, sampleType as sampletype, 'T' as theType, labGroupLookup_id from openLabs o, labGroupLookup g 
        		where o.formVersion >= 3 and encounter_id = " . $_REQUEST['eid'] . " and patientid = '" . $_REQUEST['pid'] . "' and o.labgroup = g.labgroup)";
        		if (getConfig('labOrderUrl') != NULL) $sql .= " union 
                	(select ymdtodate(visitdateyy,visitdatemm,visitdatedd), l.labid, p.labGroup, p.panelName, '','','','','','','','','Panel','P', labGroupLookup_id from labs l, labPanelLookup p, labGroupLookup g 
        	        where " . $where . " and l.labid = p.labPanelLookup_id and l.labGroup = g.labGroup and l.labGroup = p.labGroup) 
        	        order by 15,13,4"; 
        	}
		$labitems = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$data = json_encode($labitems);  
		echo '({"total":"' . count($labitems) . '","results":' . $data . '})';
		break;
	case 'queueEncounter': 
		$sql = 'insert into encounterQueue (encounterType, sitecode, dbSite, encounter_id, encounterStatus, createDateTime, lastStatusUpdate) values (' . $_REQUEST['type'] . ',' . $_REQUEST['site'] . ',' . DB_SITE . ',' . $_REQUEST['eid'] . ',1, now(), now())';
		$rc = database()->query($sql)->rowCount();
		if ($rc != 1) echo '{"retVal":false,"mess1":"insert to queue failed","mess2":"' . $sql . '"}';  
                else {
                        runEncounterQueue (); 
                        $sql = "select q.* from encounterQueue q where q.encounter_id = " . $_REQUEST['eid'] . " and " . $_REQUEST['site'] . " = q.sitecode order by lastStatusUpdate desc";
        	        $queue = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
        	        if (count($queue) > 0) {
        	                $statusNumber = $queue[0]['encounterStatus'];
        	                if ($statusNumber == 2)
                                        echo '{"retVal":true,"mess1":"successfully sent and accepted","mess2":"' . $sql . '"}';
        	                else 
        	                        echo '{"retVal":false,"mess1":"order rejected:' . $statusNumber . '","mess2":"' . $sql . '"}';
			} else 
			        echo '{"retVal":false,"mess1":"queue query failed","mess2":"' . $sql . '"}';
                }
		break;
	case 'updateLab': 
		echo "Ok";
		break;
	case 'saveOrderedLabs':
		$records = json_decode($_REQUEST['data'],true); 
		$whereArray = explode("'",getEncounterWhere ($_REQUEST['eid'], $_REQUEST['pid']));
		// delete the current set of rows 
		$sql = "delete from labs where patientid = ? and dbsite = ? and sitecode = ? and visitdatedd = ? and visitdatemm = ? and visitdateyy = ? and seqNum = ?"; 
		$keyArray = array($whereArray[1], DB_SITE, $whereArray[3], $whereArray[5], $whereArray[7], $whereArray[9], $whereArray[11]);    
		$rc = database()->query($sql, $keyArray)->rowCount(); 
		//echo "Delete rowcount = " . $rc;
		$retcode = saveRows($records, $keyArray);
		if ($retcode == 0) echo '{"success":"false"}';
		else {
			$qry = "update encounter set lastModified = now() where encounter_id = ? and patientid = ?"; 
			$rowCnt = database()->query($qry, array($_REQUEST['eid'], $_REQUEST['pid']))->rowCount();
			$mess = 'results saved';           
			echo '{"success":"true","message":"' . $mess . '"}'; 
		}
} 

function saveRows($records,$keyArray) { 
	foreach ($records as $rec) {
		$sql = "insert into labs (patientID, dbsite, sitecode, visitdateDd, visitdateMm, visitdateYy, seqNum, labid, ordered, labGroup, testnamefr,sampletype,result,result2,result3,resultAbnormal,resultdateyy,resultdatemm,resultdatedd,resultRemarks) values (?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?)"; 
		$itemArray = $keyArray;
		$resultDateArray = split('-', $rec['resultDate']);
		$ry ='';
		$rm ='';
		$rd ='';
		if (count($resultDateArray) == 3) {
			$ry = substr($resultDateArray[0],2);
			$rm = $resultDateArray[1];
			$rd = $resultDateArray[2];
		}
		array_push($itemArray,$rec['labid'], $rec['labGroup'],$rec['testNameFr'],$rec['sampletype'],$rec['result'],$rec['result2'],$rec['result3'],$rec['resultAbnormal'],$ry,$rm,$rd,$rec['resultRemarks']);
		$rc = database()->query($sql,$itemArray);
		if ($rc == 0) return 0;   
	}
	return 1;
}
?>  
