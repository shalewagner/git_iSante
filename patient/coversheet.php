<?php
// Warning: the strings in this array will be placed inside JavaScript code
// surrounded by ', so don't use any plain apostrophes in these strings.
$ARVreason = array (
	'fr' => array (
    'WHOIII-2' => 'OMS Stade III',
    'WHOIIICond' => 'OMS Stade III & condition actif',
    'eligByAge' => 'Lâ€™Ã¢ge',
    'eligByCond' => 'Condition actif',
    'eligPcr' => 'RÃ©sultat positif de test PCR',
    'cd4LT200' => 'CD4 inf&#xe9;rieur au seuil',
    'tlcLT1200' => 'TLC < 1200',
    'WHOIII' => 'OMS Stade III + CD4 inf&#xe9;rieur au seuil',
    'WHOIV' => 'OMS Stade IV',
    'PMTCT' => 'PTME',
    'medEligHAART' => '&Eacute;ligibilit&eacute; m&eacute;dicale &eacute;tablie ',
    'estPrev' => '&Eacute;ligibilit&eacute; m&eacute;dicale &eacute;tablie &agrave; la visite ant&eacute;rieure',
    'former' => 'ARV trith&eacute;rapie ant&eacute;rieure',
    'PEP' => 'Prophylaxie post-exposition (PEP)',
    'OptionB+' => 'Option B+'
  ),'en' => array(
    'WHOIII-2' => 'WHO Stage III',
    'WHOIIICond' => 'WHO Stage III & active condition',
    'eligByAge' => 'Age',
    'eligByCond' => 'Active condition',
    'eligPcr' => 'Positive PCR result',
    'cd4LT200' => 'CD4 below threshold',
    'tlcLT1200' => 'TLC < 1200',
    'WHOIII' => 'WHO Stage III + CD4 below threshold',
    'WHOIV' => 'Who Stage IV',
    'PMTCT' => 'PMTCT',
    'medEligHAART' => 'Eligibility established ',
    'estPrev' => 'Eligibility established in a previous visit',
    'former' => 'Prior ARV therapy',
    'PEP' => 'Prophylaxis post-exposition (PEP)',
    'OptionB+' => 'Option B+')
);

// Warning: the strings in this array will be placed inside JavaScript code
// surrounded by ', so don't use any plain apostrophes in these strings.
$coverLabels = array(
	'en' => array(
		'Visit Date',
		'Eligible On',
		'Clinical Stage at Start ARV',
		'Reason for Eligibility',
		'Regimen',
		'Encounter Type',
		'Name',
		'WHO Stage',
		'Diagnosis',
		'Onset Date',
		'CD4',
		'First Count',
		'Lowest Count',
		'Lab Test',
		'Date Administ',
		'Result',
		'Abnormal',
		'Eligibility not established',
    'Treatment',
    'Reaction',
    'No visits reported.',
    'No allergies reported.',
    'No CD4 counts reported.'
	),
	'fr' => array(
		'Date de visite',
		'Date du &eacute;ligibilit&eacute',
		'Stade OMS au d&eacute;marrage des ARV',
		'Raison d&rsquo;&eacute;ligibilit&eacute; m&eacute;dicale aux ARV',
		'R&eacute;gime',
		'Type de visite',
		'Nom',
		'OMS Stade',
		'Diagnostics',
		'Date de D&eacute;but',
		'Compte CD4',
		'1er Compte CD4',
		'Compte CD4 le plus bas',
		'Analyses',
		'Date Demand&#xe9;es',
		'R&#xe9;sultat',
		'Anormal',
		'Pas d&rsquo;&#xe9;ligibilit&eacute; m&eacute;dicale &eacute;tablie',
    'Traitement',
    'R&#xe9;action',
    'Pas de visites signalÃ©es.',
    'Pas d&rsquo;allergies signalÃ©es.',
    'Aucun compte CD4 rapportÃ©'
	)
);


// Warning: the strings in this array will be placed inside JavaScript code
// surrounded by ', so don't use any plain apostrophes in these strings.
$coverHeaders = array(
	'en' => array(
		'ARV',
		'Vitals',
		'CD4',
		'Graph Overview',
		'Symptoms',
		'Labs',
		'Recent Encounters',
		'Diagnoses',
		'CD4 Graph',
		'Weight Graph',
		'No graphs are available for this patient.',
		'Weight (kg)',
    'and',
	'BMI Graph',
	'BMI'
	),
	'fr' => array(
		'ARV',
		'Signes Vitaux',
		'CD4',
		'Vue d&#39;ensemble des graphiques',
		'Sympt&ocirc;mes',
		'Analyses',
		'Visites RÃ©centes',
		'Diagnostics',
		'Graphique CD4',
		'Graphique de poids',
		'Aucun graphique disponible pour ce patient.',
		'Poids (kg)',
    'et',
	'IMC Graph',
	'IMC'
	)
);
$pedGrowthLabels = array(
  "en" => array (
    0 => 'Pediatric Growth',
    1 => 'Visit Date',
    2 => 'Height',
    3 => 'Weight',
    4 => 'BMI',
    5 => 'BMI-for-age',
    6 => 'Weight-for-age',
    7 => 'Length-for-age',
    8 => 'Weight-for-length',
    9 => 'Measure',
    10 => 'Percent',
    11 => 'Z-score',
    12 => 'Age',
    13 => 'Months',
    14 => 'Years',
    15 => 'Warning! This patient is more than 2SD from average in: ',
    16 => 'Print'
  ),
  "fr" => array (
    0 => 'Croissance de pÃ©diatrie',
    1 => 'Date de visite',
    2 => 'Taille',
    3 => 'Poids',
    4 => 'IMC',
    5 => 'IMC pour lâ€™Ã‚ge',
    6 => 'Poids pour lâ€™Ã‚ge',
    7 => 'Longueur de lâ€™Ã‚ge',
    8 => 'Poids pour la Longueur',
    9 => 'Mesure',
    10 => 'Pour cent',
    11 => 'Z-score',
    12 => 'Ã‚ge',
    13 => 'Mois',
    14 => 'Ans',
    15 => 'Attention! Patient est plus de deux Ã©carts types de la moyenne en: ',
    16 => 'Imprimer'
  )
); 

$adultGrowthLabels = array(
  "en" => array (
    0 => 'Adult Growth',
    1 => 'Visit Date',
    2 => 'Height',
    3 => 'Weight',
    4 => 'BMI',
    5 => 'BMI-for-age',
    6 => 'Weight-for-age',
    7 => 'Length-for-age',
    8 => 'Weight-for-length',
    9 => 'Measure',
    10 => 'Classification',
    11 => 'Z-score',
    12 => 'Age',
    13 => 'Months',
    14 => 'Years',
    15 => 'Warning! This patient is abnormal: ',
    16 => 'Print',
    17 => 'Muac'
  ),
  "fr" => array (
    0 => 'Croissance chez les adultes',
    1 => 'Date de visite',
    2 => 'Taille',
    3 => 'Poids',
    4 => 'IMC',
    5 => 'IMC pour lâ€™Ã‚ge',
    6 => 'Poids pour lâ€™Ã‚ge',
    7 => 'Longueur de lâ€™Ã‚ge',
    8 => 'Poids pour la Longueur',
    9 => 'Mesure',
    10 => 'Classification',
    11 => 'Z-score',
    12 => 'Ã‚ge',
    13 => 'Mois',
    14 => 'Ans',
    15 => 'Attention! Ce patient est anormale : ',
    16 => 'Imprimer',
    17 => 'Pb'
  )
);

function makeHTMLRows($array, $numcolumns, $headers ,$topheader =NULL){
	if (count($array) == 0) return "";
	$table = "<table class=\"table table-bordered panel-table cover-table\">";
  $table .= "<thead><tr>";
	for($i=0; $i<$numcolumns;$i++){
		$table .= "<th>".$headers[$i]."</th>";
	}
  $table .= "</tr></thead>";
  $table .= "<tbody>";
	$j = 0;
	foreach($array as $value){
		if($j == $numcolumns){
			$j= 0;
			$table .= "</tr><tr>";
		}
		$table .= "<td>".$value."</td>";
		$j++;
	}
	$table = substr($table,0,-5);
	$table .= "</tbody></table>";
	return $table;
}
//---------------RECENT ENCOUNTERS -------------------------------
$qry3 = "SELECT TOP 5 encounter_id,lastModified, encStatus, formVersion, rtrim(visitDateDd) as visitDateDd,rtrim(visitDateMm) as visitDateMm, rtrim(visitDateYy) as visitDateYy, encounterType, visitDate FROM encValidAll WHERE patientID = '$pid' AND siteCode = '$site' AND encounterType <> 13 ORDER BY visitDateYy DESC, visitDateMm DESC, visitDateDd DESC, encounter_id DESC";
$result3 = dbQuery($qry3);

$encs  = array();
while($row = psRowFetch($result3)){
  $eid = $row['encounter_id'];
  $type = $row['encounterType'];
  $form = $typeArray[$mapArray[$type]] . ".php"; 
  $version = $row['formVersion'];     
  /* these two line are handled directly by $mapArray in backend/constants.php, so are unnecessary and incorrect
   *   if(substr($form, 0, 3) == "ped") $form = substr($form, 3);
   *   if ($type == 15) $form = "register.php";  
   */
  $sname = $encType[$lang][$type];
  $error = '';
  $cdate = zpad (trim($row['visitDateDd']), 2) . "/" . zpad (trim ($row['visitDateMm']), 2) . "/" . zpad (trim ($row['visitDateYy']), 2) ;
  $encs[] = "<a href=\"javascript:onClick=changeTab(\'forms\',\'$form?lang=$lang&amp;pid=$pid&amp;eid=$eid&amp;type=$type&amp;version=$version&amp;errors=$error&amp;site=$site\');\">".str_replace("'","\'",$sname)."</a>";
  $encs[] = $cdate;
}

$forms = "<h2>".$coverHeaders[$lang][6]."</h2>";
$forms .= "<div class=\"cover-list-inner\">";
if (count($encs) > 0) {
    $forms .= makeHTMLRows($encs,2,array($coverLabels[$lang][5],$coverLabels[$lang][0]));
    $forms .= "<a class=\"table-more-link\" href=\"javascript:onClick=changeTab(\'forms\');\">".$allEnc[$lang][32]."</a>";
} else {
    $forms .= "<p>".$coverLabels[$lang][20]."</p>";
}
$forms .= "</div>";

// ------------------------ CD4 PANEL-----------------------------------
$qry = "select * from cd4Table where patientid ='".$pid."' union (select siteCode,patientID, v.visitDate,case when (encounterType in (6,19) and formVersion = 3) or resulttimestamp is not null then result else case when resultType = 1 and result != '' then case when result = '1' then resultLabelFr1  when result = '2' then resultLabelFr2  when result = '4' then resultLabelFr3 when result = '8' then resultLabelFr4 when result = '16' then resultLabelFr5 end when resultType = 2 and result != '' then concat(result,' ',resultLabelFr1) when resultType = 3 and result != '' then concat(result,' ',resultLabelFr1) when resultType = 4 and result != '' then case when result = '1' then resultLabelFr1  when result = '2' then resultLabelFr3 when result = '4' then resultLabelFr4 end when resultType = 5 and result IS NOT NULL then case when result2 = '1' then concat(result,' ',resultLabelFr1) when result2 = '2' then concat(result,' ',resultLabelFr2) end  when resultType = 6 and result != '' then case when result = '1' then resultLabelFr1  when result = '2' then resultLabelFr5 end else ''  end end*1 as result,encounter_id,encounterType,formVersion  from a_labs v where ((result is not null and result <> '') or isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1) and patientid ='".$pid."')";




//echo $qry;
$result = dbQuery($qry);
$cd4 = array();
$cd4header = "<h2>".$coverHeaders[$lang][2]."</h2>";
$cd4first = "";
$cd4low = "";

while($row = psRowFetch($result)){
  $cdate = new DateTime($row['visitdate']);
  $cdate = date_format($cdate,'Y-m-d');
  $cd4[$cdate] = $row['cd4'];
}

if(sizeOf($cd4) >= 1){
	$rdate = new DateTime(key($cd4));
	$rdate = date_format($rdate,'d/m/Y');

	$cd4first = '<p><b>'.$coverLabels[$lang][11].'</b>: '.current($cd4).' ('.$rdate.')</p>';
  //makeHTMLRows(array(current($cd4),$rdate),2,array($coverLabels[$lang][11]));
	if(empty($cd4first)){	$cd4first = ''; }
	asort($cd4);
	$rdate = new DateTime(key($cd4));
	$rdate = date_format($rdate,'d/m/Y');
  $cd4low = '<p><b>'.$coverLabels[$lang][12].'</b>: '.current($cd4).' ('.$rdate.')</p>';
	//$cd4low = makeHTMLRows(array(current($cd4),$rdate),2,array($coverLabels[$lang][12]));
	if(empty($cd4low)){	$cd4low = ''; }
	krsort($cd4);

		//Fixed the problem that the cd4 array always misses the latest one.
		$count = array();
		$count[] = current($cd4);
	  $rdate = new DateTime(key($cd4));
		$rdate = date_format($rdate,'d/m/Y');
		$count[] = $rdate;
				
		for($i = 1; $i<4;$i++){
			if(sizeof($cd4) >= ($i+1)){
				$count[] = next($cd4);
				$rdate = new DateTime(key($cd4));
				$rdate = date_format($rdate,'d/m/Y');
				$count[] = $rdate;
			}
		}

  $cd4table = "<div class=\"cover-list-inner\">";
  $cd4table .= makeHTMLRows($count,2,array($coverLabels[$lang][10],$coverLabels[$lang][0]));
  $cd4table .= "<a class=\"table-more-link\" href=\"javascript:onClick=changeTab(\'labResultsTab\');\">".$allEnc[$lang][32]."</a>";
  $cd4table .= "</div>";
} else $cd4table = "<div class=\"cover-list-inner\"><p>".$coverLabels[$lang][22]."</p></div>";

$cd4info = $cd4header."<div class=\"cover-list-inner\">".$cd4first.$cd4low."</div>";
  
// ------------------------ LABS PANEL----------------------------------
$qry2 = "SELECT TOP 5 * FROM a_labs WHERE patientid = '".$pid."' ORDER BY visitdate DESC";
$result2 = dbQuery($qry2);
$lab = array();

while($row = psRowFetch($result2)){
	$cdate = new DateTime($row['visitdate']);
	$cdate = date_format($cdate,'d/m/Y');

		$lab[] = $row['testNameFr'];
		$lab[] = $cdate;
		$lab[] = $row['result'].$row['result2'].$row['result3'].$row['result4'];
		if($row['resultAbnormal'] == 1){
		$lab[] = 'Yes';
		}else{
		$lab[] = ' ';
		}
}

$labtable = makeHTMLRows($lab,4,array($coverLabels[$lang][13],$coverLabels[$lang][14],$coverLabels[$lang][15],$coverLabels[$lang][16]));


// ------------------------DIAGNOSIS PANEL----------------------------------
$qry4 = "SELECT TOP 5 * FROM a_conditions WHERE patientid = '".$pid."' ORDER BY visitdate DESC";
$result4 = dbQuery($qry4);
$diagA = array();
$diagI = array();
while($row = psRowFetch($result4)){
	$cdate = new DateTime($row['visitdate']);
	$cdate = date_format($cdate,'d/m/Y');

	if($row['conditionActive'] == 1){
		$diagA[] = $cdate;
		$diagA[] = $row['whoStage'];
		$diagA[] = $row['conditionNameFr'];
		$diagA[] = $row['conditionMm']."/".$row['conditionYy'];
	}else if($row['conditionActive'] == 2){
		$diagI[] = $cdate;
		$diagI[] = $row['whoStage'];
		$diagI[] = $row['conditionNameFr'];
		$diagI[] = $row['conditionMm']."/".$row['conditionYy'];
	}
}

$diagAtable = makeHTMLRows($diagA,4,array($coverLabels[$lang][0],$coverLabels[$lang][7],$coverLabels[$lang][8],$coverLabels[$lang][9]));
$diagItable = makeHTMLRows($diagI,4,array($coverLabels[$lang][0],$coverLabels[$lang][7],$coverLabels[$lang][8],$coverLabels[$lang][9]));

// ------------------------ARVS PANEL----------------------------------
//date of first qualify for ARV
$eligDate = getArtQualifyingDate($pid);
$url = "";
$eligReason = "";
$errors = "";
if(!empty($eligDate)){
	$celigDate = new DateTime($eligDate[0][1]);
	$celigDate = date_format($celigDate,'d/m/Y');
	foreach($eligDate as $qualifier){
		$temp = new DateTime($qualifier[1]);
		$temp = date_format($temp,'d/m/Y');
		if($temp == $celigDate){
		    $eligReason .= $ARVreason[$lang][$qualifier[0]].", ";
            $encT = $typeArray[$mapArray[$qualifier[3]]] . ".php"; 
            $url = "javascript: onClick=changeTab(\'forms\', \'" . $encT . "?lang=" . $lang . "&pid=" . $pid . "&eid=" . $qualifier[2] . "&type=".$qualifier[3]."&version=".$qualifier[4]."&errors=" . $errors . "&site=" . $site. "\');";
		}else{
		break;
		}
	}
    $celigDate = "<a href=\"" . $url . "\">" . $celigDate . "</a>";
	$eligReason = "<a href=\"" . $url. "\">" . substr($eligReason, 0, -2) . "</a>";

}else{
	$celigDate = addslashes($coverLabels[$lang][17]);
	$eligReason = '';
}


//stage at start of ARVs
$qry6 = "select TOP 1 whoStage from a_conditions where patientid = '".$pid."' and visitdate >= (select min(visitDate) as visitdate from pepfarTable where patientid = '".$pid."' AND (forPepPmtct = 0 OR forPepPmtct IS NULL)) ORDER BY visitdate";
$result6 = dbQuery($qry6);
$eligStage = psRowFetch($result6);
$celigStage = $eligStage['whoStage'];
$whoStageFr = array(
	"Stage I" => "Stade I",
	"Stage II" => "Stade II",
	"Stage III" => "Stade III",
	"Stage IV" => "Stade IV",
	"Other" => "Autres",
	"Psych" => "Psych",
	"Substance Use" => "Usage de substances toxiques"
);
if($lang == "fr" && $celigStage !=""){
	$celigStage = $whoStageFr[$celigStage];
}
$qry8 = "select Top 5 * from pepfarTable where patientid = '".$pid."' AND (forPepPmtct = 0 OR forPepPmtct IS NULL) ORDER BY visitDate DESC";
$result8 = dbQuery($qry8);

$arvs = array();
while($row = psRowFetch($result8)){
	$cdate = new DateTime($row['visitDate']);
	$cdate = date_format($cdate,'d/m/Y');
		$arvs[] = $row['regimen'];
		$arvs[] = $cdate;
}

$arvInfo = "<h2>".$coverHeaders[$lang][0]."</h2>";
$arvInfo .= "<div class=\"cover-list-inner\">";
$arvInfo .= "<p><b>".$coverLabels[$lang][1].":</b> ".$celigDate."</p>";
$arvInfo .= "<p><b>".$coverLabels[$lang][2].":</b> ".$celigStage."</p>";
$arvInfo .= "<p><b>".$coverLabels[$lang][3].":</b> ".$eligReason."</p>";
$arvInfo .= "</div>";
if (count($arvs) > 0 ) {
  $regtable = "<div class=\"cover-list-inner\">";
  $regtable .= makeHTMLRows($arvs,2,array($coverLabels[$lang][4],$coverLabels[$lang][0]));
  $regtable .= "<a class=\"table-more-link\" href=\"javascript:onClick=changeTab(\'rxTab\');\">".$allEnc[$lang][32]."</a>";
  $regtable .= "</div>";
}


/* ------------------------ ALERGIES PANEL----------------------------------*/
  $foo = array (
	 "allergyName"     => array ("Nom", " Name"),
	 "allergyStartMm"  => array ("", ""),
	 "allergyStartYy"  => array ("MM/AA", "MM/YY"),
	 "allergyStopMm"   => array ("", ""),
	 "allergyStopYy"   => array ("MM/AA", " MM/YY"),
	 "rash"            => array ("Erup", "Rash"),
	 "rashF"           => array ("ErupF", "RashF"),
	 "ABC"             => array ("ABC", "ABC"),
	 "hives"           => array ("Pap", "Hives"),
	 "SJ"              => array ("SJ", "SJ"),
	 "anaph"           => array ("Anaph", "Anaph"),
	 "allergyOther"    => array ("Autre", "Other") 
  );
  $targetList = "";
  foreach ($foo as $key => $value) {
          $targetList .= ", " . $key;
  }
  $query = "select (visitdatedd + '/' + visitdatemm + '/' + visitdateyy) as vDate " . $targetList . ", visitdateyy, visitdatemm,visitdatedd 
  	from allergies  where patientid = '" . $pid . "' order by visitdateyy desc, visitdatemm desc, visitdatedd desc";
  if (DEBUG_FLAG) FB::log($query);
  $result = dbQuery ($query);
  if ($lang == "fr") $kk = 0;
  else $kk = 1;
  $retVar = ""; 
  $allergiesTable = array();
  while ($row = psRowFetch($result)) {
  	foreach ($foo as $key => $value) {
  		if ($row[$key] == 1) {
  			$allergiesTable[] = $row['vDate'];
  			$allergiesTable[] = $row['allergyName'];
  			$allergiesTable[] = $value[$kk];
  		}
  	} 
  }
  
  $allergies = "<h2>Allergies</h2>";
  $allergies .= "<div class=\"cover-list-inner allergies\">";
  if (count($allergiesTable) > 0 ) {
    $allergies .= makeHTMLRows($allergiesTable,3, array ($coverLabels[$lang][0], $coverLabels[$lang][18], $coverLabels[$lang][19]) );
  } else {
    $allergies .= "<p>".$coverLabels[$lang][21]."</p>";
  }
  $allergies .= "</div>";
?> 
