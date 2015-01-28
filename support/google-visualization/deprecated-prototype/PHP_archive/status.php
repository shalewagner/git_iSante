<?php

require_once "_config.php";

$sql = "SELECT statusValue as status, statusDescEn as name_en, statusDescFr as name_fr
FROM  `patientstatuslookup`";

$DSPL->output_mysql($sql,'status.csv');


?>
