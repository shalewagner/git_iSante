<?php
require_once ("laboratorySummaryFunctions.php");
echo laboratorySummary($_REQUEST['eid'],$_REQUEST['pid'],$_REQUEST['site'], $_REQUEST['lang']);
?>
