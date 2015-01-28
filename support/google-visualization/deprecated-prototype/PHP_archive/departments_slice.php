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
	

			// get values for date
			$sql = "INSERT INTO department_slice SELECT LEFT( c.siteCode, 1 ) as department,s.`day`,s.`sex`,s.`hiv`,s.`status`,SUM(s.`population`) as population 
			FROM `clinic_slice` as s 
			INNER JOIN cliniclookup as c on s.`clinic` = c.siteCode
			WHERE c.department != 'Nippes'
			GROUP BY department,s.`day`,s.`sex`,s.`hiv`,s.`status`";
			
			$dbh->query($sql);

			// patch for Nippes
			// This is not quite correct for numeric department, because the Nippes department was carved out of Grande-Anse in 2006. Because we must retain a 5-digit sitecode scheme, Nippes sitecodes still start with 8 when they should be 10.
			// get values for date
			$sql = "INSERT INTO department_slice SELECT 10 as department,s.`day`,s.`sex`,s.`hiv`,s.`status`,SUM(s.`population`) as population 
			FROM `clinic_slice` as s 
			INNER JOIN cliniclookup as c on s.`clinic` = c.siteCode
			WHERE c.department = 'Nippes'
			GROUP BY department,s.`day`,s.`sex`,s.`hiv`,s.`status`";
			
			$dbh->query($sql);

	
/**********************************************************************************************/
// Department
/**********************************************************************************************/

		// add main slice
		$concept = array('department' => 'string');
		$DSPL->create_all_slices($fields,'departments',$concept,'department_slice');

/**********************************************************************************************/
// National
/**********************************************************************************************/

		// add main slice
		$concept = array();
		$DSPL->create_all_slices($fields,'national',$concept,'department_slice');
		
		
		$DSPL->print_created_tables();
		
		$DSPL->print_add_to_dataset('addtodataset_departments.xml');


?>
