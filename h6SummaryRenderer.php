<?php

require_once ("backend/h6SummaryFunctions.php");



echo generateh6Summary ($_REQUEST['startdate'],$_REQUEST['enddate'], $_REQUEST['site'], $_REQUEST['lang']);

?>
