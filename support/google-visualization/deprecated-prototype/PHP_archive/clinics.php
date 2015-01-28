<?php

require_once "_config.php";

$sql = "SELECT siteCode as clinic, clinic as name, case when department = 'Nippes' then 10 else LEFT( siteCode, 1 ) end AS department, network, lat as latitude,lng as longitude
FROM  `cliniclookup`
WHERE inCPHR = 1";

$DSPL->output_mysql($sql,'clinics.csv');

$sql = "SELECT DISTINCT network, network as name
FROM  `cliniclookup`
WHERE inCPHR = 1";

$DSPL->output_mysql($sql,'networks.csv');


?>
