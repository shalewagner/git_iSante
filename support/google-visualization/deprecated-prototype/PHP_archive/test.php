<?php

require_once "_config.php";


	$i = 0;
	
	// loop through dates
	$sql = "SELECT DISTINCT patientid
FROM `cd4Table`";

	$dates = $dbh->query($sql);
	
	// For each date
	while( $row = $dates->fetch(PDO::FETCH_ASSOC) ) {
		$i++;
		echo '--- '.$row['endDate'].' ---<br />';
		
		// stop after 10 iterations
		// if ($i > 10) break;

		// get values for date
		$sql = "INSERT INTO clinic_slice SELECT LEFT(t.patientID,5) AS clinic, t.endDate AS day".$select.", COUNT( p.patientID ) AS population
		FROM `patient` AS p RIGHT JOIN (SELECT * FROM `patientstatustemp` WHERE endDate = '".$row['endDate']."') AS t ON p.patientID = t.patientID
		GROUP BY LEFT( p.location_id, 5 ), t.endDate".$group."
		ORDER BY clinic".$group.", t.endDate";
		
		$dbh->query($sql);
	
	}

		/*
SELECT LEFT(visitdate,7), COUNT(*) as total, sum( if( `cd4` < 200, 1, 0) )/COUNT(*) as '200 and down', sum( if( `cd4` BETWEEN 200 AND 350, 1, 0) )/COUNT(*) as '200-350', sum( if( `cd4` > 350, 1, 0) )/COUNT(*) as '350 and up' FROM `cd4Table` GROUP BY LEFT(visitdate,7)

*/



?>
