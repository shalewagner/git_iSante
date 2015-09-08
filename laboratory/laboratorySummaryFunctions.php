<?php
chdir('..');
require_once ("backend.php");
require_once 'backend/config.php';
require_once 'backend/database.php';
require_once 'backend/materializedViews.php';
require_once "include/standardHeaderExt.php";

function laboratorySummary ($eid, $pid, $site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang); 
  $lname=$GLOBALS['existingData']['lname'];
  $fname=$GLOBALS['existingData']['fname'];
  
  /* union query below has three parts:
   * individual tests either without results or not sent to OpenElis
   * panels for OpenElis
   * test results
   */
  $qry = "select visitDate as 'Date l’ordre', labGroup as Groupe, replace(testNameFr,'\'','’') as 'Nom du test', sampleType as 'Type d’échantillon'
	from a_labs 
	where encounter_id = " . $eid . " and patientid = '" . $pid . "'
	union 
        select l.visitDate, p.labGroup, p.panelName, '' from a_labs l, labPanelLookup p, labGroupLookup g 
        where encounter_id = " . $eid . " and patientid = '" . $pid . "' and l.labid = p.labPanelLookup_id and l.labGroup = g.labGroup and l.labGroup = p.labGroup 
	union  
	select ymdtodate(visitDateyy,visitdatemm,visitdatedd),labGroup, replace(testNameFr,'\'','’'),sampleType
	from labs l, encounterQueue q 
	where patientid = '" . $pid . "' and
	l.sitecode = left('" . $pid . "',5) and
	l.sitecode = q.sitecode and
	q.encounter_id = " . $eid . " and  
	left(l.accessionNumber,instr(l.accessionNumber,'-')-1) = q.accessionNumber";   
  
  $laboratory = outputQueryRows($qry); 
    
  $summary = <<<EOF
  
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
	input { padding:3px; border:1px solid #F5C5C5; border-radius:2px; width:142px; }
  </style>  
</head>

<body text="#000000" link="#000000" alink="#000000" vlink="#000000" align="center">
<center>
<table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top" >
  <td style="width: 100%; padding:15px;"  align="center">
   <div><span style="font-family: Lucida Console; font-size: 15.0px;">
   <strong>$siteName</strong></span></div>
   <div><span style="font-family: Lucida Console; font-size: 12.0px;"><strong>Liste des Ordres de laboratoire </strong></span></div>
  </td>
</tr>
</table>

<div>&nbsp;</div>
<div>&nbsp;</div>

<table width="90%" border="0">
  <tr>
    <td width="70%">
	<div><strong>Patient: <span>$lname </span> $fname</strong></div>
	<div>&nbsp;</div>
	<div><strong>No d'ordre: <span>$site - $eid</span></strong></div>
	<div>&nbsp;</div>
	<div>$laboratory</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div align="right"><input type="button" value="Print" onclick="window.print()"/></div>
    </td>
  </tr>
</table>
</center>
</body>
</html>
EOF;

  return ($summary);
}

function outputQueryRows($qry) {
        $output = '';
        // execute the query 
        $arr = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC); 
        if (count($arr) == 0) return '<p><center><font color="red"><bold>Aucuns rÃ©sultats trouvÃ©s</bold></font></center><p>';
        // set up the table
        $output = '<center><table class="" width="90%" border="1" cellpadding="0" cellspacing="0">';
        // loop on the results 
        $i = 0;
        foreach($arr as $row) {
               if ($i == 0) { 
                       // output the column header 
                       $output .= '<tr>';
                       foreach($row as $key => $value) $output .= '<th>' . $key . '</th>';
                       $output .= '</tr>'; 
                       $i++;
               } 
               $output .= '<tr>';
               foreach($row as $key => $value) $output .= '<td style="font-family: Lucida Console; font-size: 12.0px; padding:3px;">' . $value . '</td>';
               $output .= '</tr>';
        }
        // close the table 
        $output .= '</table></center>';
        return $output;
}



?>
