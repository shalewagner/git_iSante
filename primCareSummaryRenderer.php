<?php

require_once ("backend/primCareSummaryFunctions.php");

echo generatePrimCareSummary ($_REQUEST['pid'], $_REQUEST['site'], $_REQUEST['lang']);

?>
