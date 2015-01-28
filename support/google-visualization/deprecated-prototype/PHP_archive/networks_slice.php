<?php

require_once "_config.php";

	// fields for the slice
	$fields = array();
	$fields['sex'] = 'p.sex';
	$fields['hiv'] = 'p.hivPositive';
	$fields['status'] = 't.patientStatus';
	
		// preparing the columns to use
		$select = '';
		$group = '';
		foreach ($fields as $key => $value) {
			$select .= ", ".$value." AS ".$key;
			$group .= ", `".$key."`";
		}
	


	// emptying the temp table
	$dbh->query("TRUNCATE TABLE department_slice");
	
	$i = 0;
	
	// loop through dates
	$sql = "SELECT DISTINCT endDate
FROM `patientstatustemp` WHERE endDate BETWEEN '2011-01-01' AND NOW()";

	$dates = $dbh->query($sql);
	
	// For each date
	while( $row = $dates->fetch(PDO::FETCH_ASSOC) ) {
		$i++;

		$date = explode('-',$row['endDate']);
		
		// option to only import ends of months (data between month doesn't seem accurate)
		$endofmonth = date('Y-m-d',strtotime('-1 day',strtotime('+1 month',strtotime($date[0].'-'.$date[1].'-01'))));
		
		if ($endofmonth == $row['endDate']) {
			echo '--- '.$row['endDate'].' ---<br />';

			// stop after 10 iterations
			// if ($i >10) break;

			// get values for date
			$sql = "INSERT INTO network_slice SELECT p.network, t.endDate AS day".$select.", COUNT( p.patientID ) AS population
			FROM (SELECT p.patientID as patientID, p.sex as sex, p.hivPositive as hivPositive, c.network as network FROM `patient` as p INNER JOIN `cliniclookup` as c ON p.location_id = c.siteCode) AS p RIGHT JOIN (SELECT * FROM `patientstatustemp` WHERE endDate = '".$row['endDate']."') AS t ON p.patientID = t.patientID
			GROUP BY p.network, t.endDate".$group."
			ORDER BY p.network".$group.", t.endDate";
			
			echo $sql;
			
			// $dbh->query($sql);

		}
	}



	
/**********************************************************************************************/
// Department
/**********************************************************************************************/

		// add main slice
		$concept = array('network' => 'string');
		$DSPL->create_all_slices($fields,'networks',$concept,'network_slice');

/**********************************************************************************************/
// National
/**********************************************************************************************/

		
		$DSPL->print_created_tables();
		
		$DSPL->print_add_to_dataset('addtodataset_networks.xml');


?>
