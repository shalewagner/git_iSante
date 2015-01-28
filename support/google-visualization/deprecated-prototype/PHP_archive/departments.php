<?php

require_once "_config.php";

$sql = "SELECT code as department,department as name
FROM  `depts`";

output_mysql($dbh,$sql,'departments.csv');


?>
