<?php

require_once "_config.php";

// emptying the temp table
$dbh->query("TRUNCATE TABLE clinic_encounter_population_slice");

$sql = "INSERT INTO clinic_encounter_population_slice SELECT clinic,day,SUM(population) as population, 0 as encounters FROM `clinic_slice` WHERE clinic != 0 GROUP BY clinic,day ORDER BY clinic,day";
$dbh->query($sql);

$sql = "UPDATE clinic_encounter_population_slice as d 
INNER JOIN 
(SELECT siteCode AS clinic, LAST_DAY(visitDate) AS 
day, COUNT( * ) AS encounters
FROM `encounter`
WHERE DATE(visitDate) > '2006-01-01'
GROUP BY siteCode, LAST_DAY(visitDate)
ORDER BY siteCode, LAST_DAY(visitDate)) as e
ON e.clinic = d.clinic AND e.day = d.day 
SET d.encounters = e.encounters";

$dbh->query($sql);

$sql = "(SELECT LEFT( e.clinic, 1 ) AS department, e.day, SUM(e.population) as population, SUM(e.encounters) as encounters
FROM clinic_encounter_population_slice as e INNER JOIN cliniclookup as c on e.clinic = c.siteCode
WHERE c.department != 'Nippes'
GROUP BY LEFT( e.clinic, 1 ),e.day
ORDER BY LEFT( e.clinic, 1 ),e.day)
UNION ALL 
(SELECT 10 AS department, e.day, SUM(e.population) as population, SUM(e.encounters) as encounters
FROM clinic_encounter_population_slice as e INNER JOIN cliniclookup as c on e.clinic = c.siteCode
WHERE c.department = 'Nippes'
GROUP BY e.day
ORDER BY e.day)";

$DSPL->output_mysql($sql,'departments_slice.csv');

$sql = "SELECT clinic, day, population, encounters
FROM clinic_encounter_population_slice
ORDER BY clinic,day";

$DSPL->output_mysql($sql,'clinics_slice.csv');

$sql = "SELECT day, SUM(population) as population, SUM(encounters) as encounters
FROM clinic_encounter_population_slice
GROUP BY day
ORDER BY day";

$DSPL->output_mysql($sql,'national_slice.csv');

$sql = "SELECT encounterType as encounter, enName as name_en, frName as name_fr FROM enctypelookup ORDER BY encounterType";

$DSPL->output_mysql($sql,'encounter.csv');


$dbh->query("TRUNCATE TABLE encounter_slice");
	
$sql = "INSERT INTO encounter_slice SELECT siteCode AS clinic, encounterType as encounter, LAST_DAY(visitDate) AS 
day, COUNT( * ) AS encounters
FROM `encounter`
WHERE DATE(visitDate) BETWEEN '2006-01-01' AND NOW()
GROUP BY siteCode, encounterType, LAST_DAY(visitDate)
ORDER BY siteCode, encounterType, LAST_DAY(visitDate)";

$dbh->query($sql);

// clean clinics that aren't in CPHR
$sql = "DELETE FROM encounter_slice WHERE clinic NOT IN (SELECT siteCode FROM cliniclookup WHERE inCPHR = 1)";
$dbh->query($sql);

// clean encounterTypes that aren't in the lookup
$sql = "DELETE FROM encounter_slice WHERE encounter = 0";
$dbh->query($sql);

$sql = "SELECT clinic, encounter, day, encounters FROM encounter_slice ORDER BY clinic, encounter,day";

$DSPL->output_mysql($sql,'clinics_encounter_slice.csv');

$sql = "SELECT LEFT(clinic,1) as department, encounter, day, SUM(encounters) as encounters  FROM encounter_slice GROUP BY LEFT(clinic,1), encounter, day ORDER BY LEFT(clinic,1), encounter, day";

$DSPL->output_mysql($sql,'departments_encounter_slice.csv');

$sql = "SELECT encounter, day, SUM(encounters) as encounters FROM encounter_slice GROUP BY encounter,day ORDER BY encounter,day";

$DSPL->output_mysql($sql,'national_encounter_slice.csv');


?>
