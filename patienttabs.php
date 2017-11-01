<?php
require_once 'backend/constants.php';
require_once 'include/standardHeaderExt.php';

//check for patient ID, if none is specified in the header then redirect to search page
if(empty($pid)){
	$root = explode("/", $_SERVER['PHP_SELF']);
	if ($lang == "en")
      echo "<script type=\"text/javascript\"> alert('You have not specified a patient ID, you will now be redirected to the search page to search for a patient.');";
	else
		echo "<script type=\"text/javascript\"> alert('Vous n\'avez pas spécifié un ID patient, vous allez être maintenant redirigé vers la page de recherche pour trouver un patient.');";
	echo "
	location.href = 'find.php?lang=$lang&site=$site';
	 </script>";
}

require_once 'labels/findLabels.php';
include("patient/coversheet.php");

//this should go into labels
$title = ($lang == "fr") ? "Les donn&eacute;es du patient" : "Patient Information";

//local variables -- Patient Information
$fname = getData ("fname", "textarea");
$lname = getData ("lname", "textarea");
$clinID = getData ("clinicPatientID", "textarea");
$fnamemom =  getData ("fnameMother", "textarea");
$natID =  getData ("nationalID", "textarea");
$patientDOB = getData ("dobDd", "textarea") . "/" . getData ("dobMm", "textarea") . "/" . getData ("dobYy", "textarea");
// DOB in YYYY-MM-DD format - for use in pedGrowth javascript
$patientDOB2 = getData ("dobYy", "textarea") . "-" . getData ("dobMm", "textarea") . "-" . getData ("dobDd", "textarea");
// $curAgeArray get current age and also whether patient is below 18 years old
// Note - define what's considered the age cut-off in backendAddOn.php
$curAgeArray = getCurrentAgeYears($pid);
$curAge = $curAgeArray[0];
$isPed = $curAgeArray[1];
$patientStatus = getPatientStatus ($pid);
$patientRegimen = getRegimen($pid);
$symptoms = getSymptoms($pid, $lang, array($coverLabels[$lang][6],$coverLabels[$lang][9]));
$symptoms = str_replace("'","\'",$symptoms);
$mf = getData("sex", "textarea");
$index = (isset($_GET['index'])) ? $_GET['index']: "";
if($mf!=""){
	$mf=$sex[$lang][$mf]; //this calculation should be a backend function i think
} else {
  $mf = $sex[$lang][3];
}

$tab = (isset($_GET['tab'])) ? $_GET['tab'] : "";


function getVitals($pid, $lang, $headers=NULL) {
	$boolLookup = array(1=>1,2=>2,4=>3,8=>4,16=>5);
	$tableSchema = " and table_schema = '" . DB_NAME . "'";
	$colArray = fetchQueryColumns("select column_name, data_type, character_maximum_length from information_schema.columns where column_name in ( 'vitalTemp','vitalBp1','vitalBp2','vitalHr','hospitalized','vitalHeight','vitalRr','genStat','vitalHeightCm','vitalWeight','vitalWeightUnits','pregnant','pregnantLmpDd','pregnantLmpMm','pregnantLmpYy','functionalStatus','vitalTempUnits') and table_name = 'vitals'" . $tableSchema);
	//print_r($colArray);
	$finalArray = array();
	foreach ($colArray as $key => $value) {
		$lab = getLabel($key);
		//print_r($lab);
		if (!empty ($lab) && $value[0] == "bool") {
			$finalArray[$key] =  $lab;
			$finalArray[$key]['type'] = "bool";
			if(strpos($key, 'Units')){
				$finalArray[$key]['en'][0] = '';
				$finalArray[$key]['fr'][0] = '';
			}
		}else if(!empty($lab)){
			$finalArray[$key]['en'] = $lab['en'][1];
			$finalArray[$key]['fr'] = $lab['fr'][1];
			$finalArray[$key]['type'] = "value";
		}
	}
	$targetList = "";
	//print_r($finalArray); 
 
	foreach ($finalArray as $key => $value) {
		$targetList .= ", " . $key;
	}
	$query = "select top 1 v.encounter_id, v.visitdate, (v.visitdatedd + '/' + v.visitdatemm + '/20' + v.visitdateyy) as vDate " . $targetList . ", o.value_numeric as vitalMuac  
		from a_vitals v left join obs o on concat(o.location_id, o.person_id) = '" . $pid . "' and o.concept_id = 70823 and o.encounter_id = v.encounter_id
		where patientid = '" . $pid . "' order by visitdate desc, v.encounter_id desc"; 
	$result = dbQuery ($query);
	if ($lang == "fr") $kk = 0;
	else $kk = 1;
		// add vitalMuac 
	$finalArray['vitalMuac']['en'] = 'Muac';
	$finalArray['vitalMuac']['fr'] = 'Pb';
	$finalArray['vitalMuac']['type'] = 'value';
  $vitalHeader = array (
    "en" => array ("Vital Signs","No vital signs reported."),
    "fr" => array ("Signes Vitaux", "Pas de signes vitaux signalés.")
  );
  $retVar = "<h2>".$vitalHeader[$lang][0]."</h2>";
  $retVar .= '<div class="cover-list-inner">';
	$retVar .= "<table class=\"table table-bordered panel-table cover-table\">";
	if($headers){
    $retVar .= "<thead>";
		foreach($headers as $head){
			$retVar .= "<th><b>".$head."</b></th>";
		}
    $retVar .= "</thead>";
	}
	//print_r($finalArray);

  $retVar .= "<tbody>";
  $emptyRow = true;
	while ($row = psRowFetch($result)) {
		$retVar .= "<thead><tr><th colspan = \"2\"><b>Date de Visite: </b> ".$row['vDate']."</th></tr></thead>";
		foreach ($finalArray as $key => $value) {
			$trim = trim($row[$key]);
			if (!empty($trim)) {
				$emptyRow = false;
				$currValue = $row[$key];
				//echo "***".$currValue."<br/>";
				if($key === 'functionalStatus'){
					$currValue++;
				}               
				if($value['type'] === 'bool' && strpos( $key, 'Units') === false ){
					$retVar .= "<tr><td>" . $value[$lang][0] . "</td><td>" . $value[$lang][$boolLookup[$currValue]] ."</td></tr>";
				}else{
				switch($key){
				case 'vitalBp1':
					$retVar .= "<tr><td>" . $value[$lang] . "</td><td>".$trim."/".$row['vitalBp2']." </td></tr>";
					break;
				case 'vitalWeight':
					$retVar .= "<tr><td>" . $value[$lang] . "</td><td>".$trim." ".$finalArray['vitalWeightUnits'][$lang][$row['vitalWeightUnits']]." </td></tr>";
					break;
				// Will only display if value in the 'meter' filled in (vitalHeight)
				case 'vitalHeight':
					$height = array( "en" => "Height", "fr" => "Taille");
					$retVar .= "<tr><td>" . $height[$lang] . "</td><td>".$trim."m ".$row['vitalHeightCm']."cm</td></tr>";
					break;
				// If vitalHeight is empty, but vitalHeightCm is filled, display that
				case 'vitalHeightCm':
					if ($row['vitalHeight'] != Null && $row['vitalHeight'] != "") break;
					$height = array( "en" => "Height", "fr" => "Taille");
					$retVar .= "<tr><td>" . $height[$lang] . "</td><td>".$trim."cm</td></tr>";
					break;       
				case 'vitalTemp':
					$retVar .= "<tr><td>" . $value[$lang] . "</td><td>".$trim." ".$finalArray['vitalTempUnits'][$lang][$row['vitalTempUnits']]." </td></tr>";
					break;
				case 'vitalHr':
				case 'vitalRr':
					$retVar .= "<tr><td>" . $value[$lang] . "</td><td>".$trim." </td></tr>";
					break; 
				case 'vitalMuac':
					if ($value != Null) $retVar .= "<tr><td>" . $value[$lang] . "</td><td>".$trim." cm</td></tr>";
					break;
				default:
					break;
				}
			}
		}}
	}
	$retVar .= "</tbody></table>";
  $retVar .= "<a class=\"table-more-link\" href=\"javascript:onClick=changeTab('forms');\">".$allEnc[$lang][32]."</a>";
  $retVar .= "</div>";
  if ($emptyRow) {
    $retVar = "<h2>".$vitalHeader[$lang][0]."</h2>";
    $retVar .= "<div class=\"cover-list-inner\"><p>".$vitalHeader[$lang][1]."</p></div>";
  }
  return ($retVar);
}

$vitals = getVitals($pid, $lang);
$vitals = str_replace("'","\'",$vitals);

// BMI calculator - used for initial display. Could just rely on js version
function calcDataBMI($weight, $height) {
  $resultBMI = $weight / pow(($height / 100), 2);
  return $resultBMI;
}

function getGrowth($pid, $lang, $headers=NULL) {
	// Only return most recent row
	$query = "select top 1 v.encounter_id, v.visitDate, v.vitalHeight, v.vitalHeightCm, CASE WHEN v.vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(v.vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(v.vitalWeight)), ',', '.') END as vitalWeight, o.value_numeric as vitalMuac from a_vitals v left join obs o on concat(o.location_id,o.person_id) = v.patientid and o.encounter_id = v.encounter_id and o.concept_id = 70823 where v.patientid = '" . $pid . "' and ((isnumeric(vitalheight) = 1 or isnumeric(vitalheightcm) = 1) and isnumeric(vitalweight) = 1) order by v.visitDate desc, v.encounter_id desc";
	$result = dbQuery ($query); 
	$array = "";
	$i = 0;
	while ($row = psRowFetch($result)) {
		$array[$i]["anthroDate"] = $row['visitDate'];
		if ($row['vitalHeight'] != Null ) {
		$array[$i]["anthroHeight"] = (($row['vitalHeight'] * 100) + $row['vitalHeightCm']);
		} else {
		$array[$i]["anthroHeight"] = $row['vitalHeightCm'];
		}
		$array[$i]["anthroWeight"] = $row['vitalWeight'];
		$array[$i]["anthroBMI"] = calcDataBMI($row['vitalWeight'], $array[$i]["anthroHeight"]);
		if ($row['vitalMuac'] != '') $array[$i]["anthroMuac"] = $row['vitalMuac'];
		$i++;
	}
  return ($array);
}

// Get pedGrowth/anthroArray info if the patient is 18 years or younger
if ($isPed != 0) {
  $anthroArray = getGrowth($pid, $lang);
  if ($anthroArray) {
    $anthroCount = count($anthroArray);
    $anthroDate = ($anthroArray[0]["anthroDate"]) ? $anthroArray[0]["anthroDate"] : 0;
    $anthroDateDisplay = ($anthroDate != 0) ? date("d/m/Y", strtotime($anthroDate)) : 0;
    $anthroHeight = ($anthroArray[0]["anthroHeight"]) ? $anthroArray[0]["anthroHeight"] : 0;
    $anthroWeight = ($anthroArray[0]["anthroWeight"]) ? $anthroArray[0]["anthroWeight"] : 0;
    // Have to use str_replace to change comma from period. For some reason, if
    // in French, was changing to comma which messed up calculations
    $anthroBMI = ($anthroArray[0]["anthroBMI"]) ? str_replace(',','.',$anthroArray[0]["anthroBMI"]) : 0;
    $anthroCalc = "<br/><br /><table class=\"table table-bordered table-condensed panel-table cover-table nutrition-table\">";
    $anthroCalc .= "<thead><tr><th>".$pedGrowthLabels[$lang][9]."</th><th>".$pedGrowthLabels[$lang][10]."</th><th>".$pedGrowthLabels[$lang][11]."</th><th></th></tr></thead>";
    $anthroCalc .= "<tbody>";
    $ageTitle = $pedGrowthLabels[$lang][12];
    if ($isPed == 1) {
      $ageTitle .= " (".$pedGrowthLabels[$lang][13].")";
    } else {
      $ageTitle .= " (".$pedGrowthLabels[$lang][14].")";
    }
    $measureArray = array(
        array("who_bmi_day_0-1856","age", "bmi",$pedGrowthLabels[$lang][5],$pedGrowthLabels[$lang][4],$ageTitle),
        array("who_lengthHeight_day_0-1856","age", "length",$pedGrowthLabels[$lang][7],$pedGrowthLabels[$lang][2]." (cm)",$ageTitle)
    );
    $addUnder5 = array("who_weight_length_45-110", "length", "weight",$pedGrowthLabels[$lang][8],$pedGrowthLabels[$lang][3]." (kg)",$pedGrowthLabels[$lang][2]." (cm)");
    $addWeight = array("who_weight_day_0-1856","age", "weight",$pedGrowthLabels[$lang][6],$pedGrowthLabels[$lang][3]." (kg)",$ageTitle);
    if ($isPed > 0 && $isPed < 3) $measureArray[] = $addWeight;
    if ($isPed == 1) $measureArray[] = $addUnder5;
    for ($i=0; $i<count($measureArray); $i++) {
      $anthroCalc .= "<tr><td>".$measureArray[$i][3]."</td><td id=\"anthroCalcP".$i."\"></td><td id=\"anthroCalc".$i."\"></td>";
      $anthroCalc .= "<td><img class=\"chart-launch\" src=\"images/icon-stats-bar.png\" data-metric=\"".$measureArray[$i][0]."\" data-metric-title=\"".$measureArray[$i][3]."\" data-xtitle=\"".$measureArray[$i][5]."\" data-ytitle=\"".$measureArray[$i][4]."\" data-xpoint=\"".$measureArray[$i][1]."\" data-ypoint=\"".$measureArray[$i][2]."\"></td></tr>";
    }
    $anthroCalc .= "</tbody></table>";

    $anthro = "<h2>".$pedGrowthLabels[$lang][0]."</h2>";
    $anthro .= '<div class="cover-list-inner">';
    $anthro .= "<b>".$pedGrowthLabels[$lang][1].": </b> ".$anthroDateDisplay;
    $anthro .= "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$pedGrowthLabels[$lang][2]."</b>: ".$anthroHeight." cm";
    $anthro .= "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$pedGrowthLabels[$lang][3]."</b>: ".$anthroWeight." kg";
    $anthro .= "<br /><b>".$pedGrowthLabels[$lang][4]."</b>: ".number_format($anthroBMI,1);
    $anthro .= $anthroCalc;
    $anthro .= '</div>';
    // TODO - Perhaps use this to output multiple points in chart
    $anthro .= "<div id='allData' class='hide'>";
    $anthroCalc2 = "";
    for ($j=0; $j< count($anthroArray); $j++) {
      $anthroCalc2 .= "[".$anthroArray[$j]["anthroDate"].",".$anthroArray[$j]["anthroHeight"].",".$anthroArray[$j]["anthroWeight"]."],";
    }
    $anthro .= substr($anthroCalc2, 0, -1);
    $anthro .= "</div>";
    $anthro = str_replace("'","\'",$anthro);
  }
} // if ($isPed != 0) 

// Adult nutrition
if ($isPed == 0) {
  $anthroArray = getGrowth($pid, $lang);
  if ($anthroArray) {
    $anthroDate = ($anthroArray[0]["anthroDate"]) ? $anthroArray[0]["anthroDate"] : 0;
    $anthroDateDisplay = ($anthroDate != 0) ? date("d/m/Y", strtotime($anthroDate)) : 0;
    $anthroHeight = ($anthroArray[0]["anthroHeight"]) ? $anthroArray[0]["anthroHeight"] : 0;
    $anthroWeight = ($anthroArray[0]["anthroWeight"]) ? $anthroArray[0]["anthroWeight"] : 0;
    // Have to use str_replace to change comma from period. For some reason, if
    // in French, was changing to comma which messed up calculations
    $anthroBMI = ($anthroArray[0]["anthroBMI"]) ? str_replace(',','.',$anthroArray[0]["anthroBMI"]) : 0;
    $anthroMuac = ($anthroArray[0]["anthroMuac"]) ? str_replace(',','.',$anthroArray[0]["anthroMuac"]) : 0; 

    $anthroCalc = "<br/><br /><table class=\"table table-bordered table-condensed panel-table cover-table nutrition-table\">";
    $anthroCalc .= "<thead><tr><th>".$adultGrowthLabels[$lang][9]."</th><th>".$adultGrowthLabels[$lang][10]."</th></tr></thead>";
    $anthroCalc .= "<tbody>";

    /*
	Underweight   ( <= 18.5 )
	Normal weight ( > 18.5 and  < 25 )
	Overweight    ( >= 25 and  < 30 )
	Obese         ( >= 30 )
     */ 
    $class = '';
    if ($anthroBMI <= 18.5) { 
	$class = ' class="error"';
	$measure = 'Maigreur ( <= 18.5 )';
    } else if ($anthroBMI > 18.5 && $anthroBMI < 25) $measure = 'Poids normal ( > 18.5 & < 25 )';
    else if ($anthroBMI >= 25 && $anthroBMI < 30) {
	 $class = ' class="error"'; 
	 $measure = 'Embonpoint ( >= 25 & < 30 )';
    } else {  
	$class = ' class="error"'; 
	$measure = 'Obésité ( >= 30 )';
    } 

    $anthroCalc .= '<tr' . $class . '><td>' . $adultGrowthLabels[$lang][4] . '</td><td>' . $measure . '</td></tr>'; 
    
    if ($mf == "F") {
    	$class = '';
    	switch ($anthroMuac) {
    	case 0:
    	$class = ' class="error"';
    	$measure = 'null'; 
    	break;
    	default:
    	if ($anthroMuac < 21) { 
    		$class = ' class="error"';
    		$measure = 'Anormale';
    	}
    	else $measure = 'Normale';  
    	}
    	$anthroCalc .= '<tr' . $class . '><td>' . $adultGrowthLabels[$lang][17] . '</td><td>' . $measure . '</td></tr>';
    }
    $anthroCalc .= "</tbody></table>"; 

    $anthro = "<h2>".$adultGrowthLabels[$lang][0]."</h2>";
    $anthro .= '<div class="cover-list-inner">';
    $anthro .= "<b>".$adultGrowthLabels[$lang][1].": </b> ".$anthroDateDisplay;
    $anthro .= "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$adultGrowthLabels[$lang][2]."</b>: ".$anthroHeight." cm";
    $anthro .= "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$adultGrowthLabels[$lang][3]."</b>: ".$anthroWeight." kg";
    $anthro .= "<br /><b>".$adultGrowthLabels[$lang][4]."</b>: ".number_format($anthroBMI,1); 
    if ($measure != 'null' && $mf = 1) $anthro .= "<br /><b>".$adultGrowthLabels[$lang][17]."</b>: ".number_format($anthroMuac,1);
    $anthro .= $anthroCalc;
    $anthro .= '</div>';
  }
} // end Adult nutrition 

// check to see if we want to go directly to a specific form
if (isset($_GET["fid"]) && $_GET["fid"] != "") {
	// make sure the initial tab is the forms tab
	// generate the appropriate iframe call for this form
	$specificForm = true;
	$fid = $_GET["fid"];
} else {
	$specificForm = false;
}
?>
<title><?=$title;?></title>
<script type="text/javascript" src="Highcharts-<?= HIGHCHARTS_VERSION ?>/js/highcharts.js"></script>
<script type="text/javascript" src="growthChartData/growthChartLmsData.js"></script>
<script type="text/javascript" src="patient/printPatient.js"></script>
<script type="text/javascript">
// Function to call print of page element. Need to have class="print-link" on
// the a. The href should specify the ID of the section to print.
$(function() {
    $('.print-link').click(function() {
        var id = $(this).attr('href');
        $("#modalChart .modal-body").print();
        return(false);
    });
});

// Added to fix problem with labelRenderer in graphs
// don't delete the labelRenderer!
Ext.override(Ext.chart.CartesianChart,{
    createAxis : function(axis, value){
        var o = Ext.apply({}, value),
            ref,
            old;

        if(this[axis]){
            old = this[axis].labelFunction;
            this.removeFnProxy(old);
            this.labelFn.remove(old);
        }
        if(o.labelRenderer){
            ref = this.getFunctionRef(o.labelRenderer);
            o.labelFunction = this.createFnProxy(function(v){
                return ref.fn.call(ref.scope, v);
            });
            // delete o.labelRenderer; // troublemaker!
            this.labelFn.push(o.labelFunction);
        }
        if(axis.indexOf('xAxis') > -1 && o.position == 'left'){
            o.position = 'bottom';
        }
        return o;
    }
});
// End - fix problem with labelRenderer in graphs

Ext.ux.IFrameComponent = Ext.extend(Ext.BoxComponent, {
	onRender : function(ct, position){
		this.el = ct.createChild({tag: 'iframe', id: 'iframe-'+ this.id, frameBorder: 0, src: this.url});
	}
});

function launchClinicalSummary () {
	var url = '<?=JASPER_RENDERER;?>?report=206&rtype=individualCase&format=pdf&siteName=<?=$site;?>&pid=<?=$pid;?>&lang=<?=$lang;?>';
	stuff = 'width=800,height=600,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes';
	currWindow = window.open(url ,'RapportWindow', stuff);
	currWindow.focus();
}

function r34Popup () {
        var url = 'patient/r34Popup.php?pid=<?=$pid;?>&lang=<?=$lang;?>';
        stuff = 'width=750,height=1000,scrollbars=yes,resizable=yes,titlebar=no';
        currWindow = window.open(url ,'VIH Status', stuff);
        currWindow.focus();
}

function delPatFromHeader() {
	var url = 'adminPat.php?pid=<?=$pid;?>&lang=<?=$lang;?>';
	document.location = url;
	
}

function deletePrints() {
  if (confirm("<?= _('en:Really delete this patient’s fingerprints?') ?>")) {
    document.location = '<?=$_SERVER['REQUEST_URI'] . "&deletePrints=true"?>';
  }
}

function submitPrints() {
	var url = 'fingerprint/submitPrints.php?pid=<?=$pid;?>&lang=<?=$lang;?>';
	document.location = url;
}

<? include_once ("include/patientHeaderButtonFunctions.js"); ?>

function fillFields () {
  var cnt = 0;
  if (document.mainForm)
	for (i in document.mainForm.elements)
	  if (document.mainForm.elements[i])
		switch (document.mainForm.elements[i].type) {
			case 'checkbox' :
				//alert(document.mainForm.elements[i].name);
				document.mainForm.elements[i].checked = true;
				break;
			case 'text' :
			case 'textarea' :
				//alert(document.mainForm.elements[i].name);
				if (document.mainForm.elements[i].value == '') document.mainForm.elements[i].value = (cnt++ % 99) + 1;
			break;
		}
  if (frames.formframe.document.mainForm)
	for (i in frames.formframe.document.mainForm.elements)
	  if (frames.formframe.document.mainForm.elements[i]) {
		switch (frames.formframe.document.mainForm.elements[i].type) {
		  case 'radio':
			var tmpRadioObj = frames.formframe.document.getElementsByName(frames.formframe.document.mainForm.elements[i].name);
			// always select the first radio in the array (only works in firefox because these radios are undefined in IE)
		  	tmpRadioObj[0].checked = true;
			break;
		  case 'checkbox' :
			frames.formframe.document.mainForm.elements[i].checked = true;
			break;
		  case 'text' :
		  case 'textarea' :
			if (frames.formframe.document.mainForm.elements[i].value == '') frames.formframe.document.mainForm.elements[i].value = (cnt++ % 99) + 1;
			break;
		}
	}
}

<?
if (getUiConfig(getSessionUser()) == "1" || getUiConfig(getSessionUser()) == "3"){
	// set up charts
	require('patient/graphSetup.js.php');
	require_once('patient/graphSetup.php');
	writeCoverGraphDataJson($pid);
}
?>

Ext.onReady( function() {
<?
if (getUiConfig(getSessionUser()) == "1" || getUiConfig(getSessionUser()) == "3"){ 
	include("patient/vaccinations.php"); 
	include("patient/gridSetup.php");
	$qry = "select count(*) from prescriptions where patientid = '" . $pid . "'";
	$result = dbquery($qry);
	$row = psRowFetch($result);
	$treatmentRowcount = $row[0];
	$eid = ""; 
	$type = (isPediatric($pid)) ? 15:10; 
	$eid = getIntakeID($pid, $type);
	if($eid != ""){
		$result = dbQuery("select formVersion from encounter where patientid ='" . $pid . "' and encounterType = " . $type);
		$row = psRowFetch($result);
		$regVersion = $row[0];
                echo "\n";
		echo "var iframe1 = Ext.DomHelper.append(document.body,{tag: 'iframe',name:'demographics',id:'demographics', layout:'fit',frameBorder: 0, src: 'register.php?pid=".$pid."&lang=".$lang."&site=".$site."&eid=".$eid."&type=".$type."&version=" . $regVersion . "&tabcall=1',width: '100%', height: '100%'});\n";
	}
	if ($treatmentRowcount > 0) echo "var iframeTreatment = Ext.DomHelper.append(document.body,{tag: 'iframe', frameBorder: 0, id:'drugTreatment', src: 'tline6.php?pid=".$pid."&lang=".$lang."',width: '100%', height: '100%'});\n";
}

// set up the forms tab iframe
if ($specificForm) {
	getExistingData ($fid, $tables);
	$type = getData ("encounterType", "textarea");
	$version = getData("formVersion", "textarea");
	$mapArray = array ("10" => "10", "15" => "10", "1" => "1","2" => "2", "5" => "5", "6" => "6", "14" => "14", "3" => "3", "4" => "4", "7" => "7", "9" => "9", "11" => "11", "12" => "12", "16" => "1", "17" => "2", "18" => "5", "19" => "6", "20" => "14", "21" => "12", "30" => "30");
	$url = $GLOBALS['typeArray'][$mapArray[$type]] . ".php?pid=$pid&lang=$lang&site=$site&eid=$fid&type=$type&version=$version";
	echo "var iframe2 = Ext.DomHelper.append(document.body,{tag: 'iframe',name:'formframe',id:'formframe', frameBorder: 0, src: '" . $url . "',width: '100%', height: '100%'});\n";
} else {
	if (isset($code)){
		echo "var iframe2 = Ext.DomHelper.append(document.body,{tag: 'iframe',name:'formframe',id:'formframe',layout:'fit', frameBorder: 0, src: 'allEnc.php?pid=".$pid."&lang=".$lang."&site=". $site. "&code=" . $code . "',width: '100%', height: '100%'});\n";
	} else {
		echo "var iframe2 = Ext.DomHelper.append(document.body,{tag: 'iframe',name:'formframe',id:'formframe', layout:'fit',frameBorder: 0, src: 'allEnc.php?pid=".$pid."&lang=".$lang."&site=".$site."',width: '100%', height: '100%'});\n";
	}
}

echo "var iframe3 = Ext.DomHelper.append(document.body,{tag: 'iframe',name:'labResults',id:'labResults', layout:'fit',frameBorder: 0, src: 'patient/patientLabResults.php?pid=".$pid."&lang=".$lang."&site=".$site."&eid=".$eid."&type=".$type."&version=" . $regVersion . "&tabcall=1',width: '100%', height: '100%'});";

?> 

var patienttabs = new Ext.TabPanel({
	id:'ptabs',
	region:'center',
	activeTab: 0,
	deferredRender: false,
	autoScroll: true,
	fitToFrame: false,
	items:[
<?
// demographics tab
if (getUiConfig(getSessionUser()) == "1" || getUiConfig(getSessionUser()) == "3") {
	if($eid != ""){ 
		echo "{ 
		id: 'demo',
		height:600,
		layout:'fit',
		fitToFrame: true,
		contentEl: iframe1,
        title: '" . $tabLabels[$lang][6] . "'
		},";
	}
// coverpage tab
	include "patient/coverTab.php"; 
}
?>
// forms tab (also displays individual forms in iframe)
{
	id: 'forms',
	height:600,
	layout:'fit',
	fitToFrame: true,
	contentEl: iframe2,
	title: '<?=$tabLabels[$lang][1];?>'
}
<?
// additional tabs for labs/conditions/meds 

if (getUiConfig(getSessionUser()) == "1" || getUiConfig(getSessionUser()) == "3") { 
?>
    ,powerUpExtTable('vaccine'),
     {
	xtype: 'panel',
	title: '<?= _('en:Growth Charts') ?>',
	id: 'pediatricGrowthTab',
	layout: 'fit',
	autoScroll:true,
	containerScroll: true,
	contentEl: document.getElementById('pediatricGrowthGraph'),
	height: 600
    },{
	id: 'labResultsTab',
        height: 600,
	layout: 'fit',
        autoScroll: true,
        fitToFrame: true,
        contentEl: iframe3,
	title: '<?= $tabLabels[$lang][7] ?>'
    },{
	xtype: 'panel',
	title: '<?= $tabLabels[$lang][3] ?>',
	id: 'dxTab',
	layout: 'fit',
	autoScroll:true,
	items:dxGrid,
	height: 600
    },{
	xtype: 'panel',
	title: '<?= $tabLabels[$lang][4] ?>',
	id: 'rxTab',
	layout: 'fit',
	autoScroll:true,
	height:600,
	items:rxGrid
    }
<?php } ?>
    ] 
});

<?
if ((getUiConfig(getSessionUser()) == "1" || getUiConfig(getSessionUser()) == "3") && !$specificForm && $tab != "forms"){ 
	if ($tab == 'demo') echo "patienttabs.setActiveTab('demo')";
	else 
	echo "patienttabs.setActiveTab('coverp');";
} else {
	echo "patienttabs.setActiveTab('forms');";
}
?>

var patientheader = new Ext.Panel({
	region:'north',
	id: 'pheader',
	height: 50,
	border: false,
	html: '<? include("patient/patientHeader.php"); ?>'
});

var slayout = new Ext.Panel({
	layout:'border',
  id: 'centerPanel',
	region: 'center',
	items:[
		patientheader,
		patienttabs
	]
});

var layout = new Ext.Viewport({
	layout:'border',
	items:[
		new Ext.BoxComponent({
			region:'north',
			el:'banner',
			height: 67,
      margins: '<? if (preg_match('/(test|demo)/i', APP_VERSION) > 0) { echo "24 0 0 0"; } // Checks for test version, if yes msg displays via bannerbody  ?>'
		}),
		slayout
	] 
});

});

function changeTab(id,url){
	var patienttabs = Ext.getCmp('ptabs');
	patienttabs.setActiveTab(id);
	if(url){
		document.getElementById('formframe').src = url;
	}
}

</script>

<?php if ($anthroArray) { 
  if (isPediatric($pid)) include("patient/pedGrowth.js.php"); 
  else include("patient/adultGrowth.js.php");
}
?>

<style type="text/css">
    #container {
        padding:1px;
    }
    #container .x-panel {
        margin:1px;
    }
    #container .x-panel-ml {
        padding-left:1px;
    }
    #container .x-panel-mr {
        padding-right:1px;
    }
    #container .x-panel-bl {
        padding-left:2px;
    }
    #container .x-panel-br {
        padding-right:2px;
    }
    #container .x-panel-body {
    }
    #container .x-panel-mc {
        padding-top:0;
    }
    #container .x-panel-bc .x-panel-footer {
        padding-bottom:2px;
    }
    #container .x-panel-nofooter .x-panel-bc {
        height:2px;
    }
    #container .x-toolbar {
        border:1px solid #99BBE8;
        border-width: 0 0 1px 0;
    }
    .chart {
        background-image: url(ext-<?= EXTJS_VERSION ?>/examples/chart/chart.gif) !important;
    }
    .x-panel-body {
        border-top: none;
    }
</style>
</head>

<body onLoad="updateGraph(cdcGraphSets[0]);">

<script>
var cdcGraphSets = 
       [
	["cdc_weight_month_0-36", "cdc95", CoverSheetGraph.data.weight],
	["cdc_length_month_0-36", "cdc95", CoverSheetGraph.data.height],
	["cdc_weight_length_month_0-36", "cdc95", CoverSheetGraph.data.combinedHeightWeight],
	["cdc_circumference_month_0-36", "cdc95", CoverSheetGraph.data.headCircumference],
	["cdc_weight_year_2-20", "cdc95", CoverSheetGraph.data.weight],
	["cdc_height_year_2-20", "cdc95", CoverSheetGraph.data.height],
	["cdc_bmi_year_2-20", "cdc95", CoverSheetGraph.data.combinedHeightWeight],
	["cdc_weight_stature_2-5", "cdc95", CoverSheetGraph.data.combinedHeightWeight]
	];
var whoGraphSets = 
  [
   ["who_weight_month_0-24", "who", CoverSheetGraph.data.weight],
   ["who_length_month_0-24", "who", CoverSheetGraph.data.height],
   ["who_weight_length_month_0-24", "who", CoverSheetGraph.data.combinedHeightWeight],
   ["who_circumference_month_0-24", "who", CoverSheetGraph.data.headCircumference],
   ["who_bmi_month_0-24", "who", CoverSheetGraph.data.combinedHeightWeight]
   ];

function renderGraphSelector(graphSet, graphSetText) {
    var graphName = graphSet[0];
    var title = GrowthChart.allGraphInfo[graphName].title;
    document.write("<li><a href=\"#\" onclick=\"updateGraph(" + graphSetText + ")\">" + title + "</a></li>");
}

function updateGraph(graphSet) {
    var graphName = graphSet[0];
    var percentileName = graphSet[1];
    var dataSet = graphSet[2];

    if (CoverSheetGraph.patientBirthDate === null
	|| CoverSheetGraph.patientGender === null) {
	document.getElementById('growthChart').innerHTML = "<?=_('en:Can not draw graph without known gender and birth date.')?>";
    } else {
	GrowthChart.render('growthChart', CoverSheetGraph.patientGender,
			   GrowthChart.allGraphInfo[graphName],
			   GrowthChart.allPercentileInfo[percentileName],
			   dataSet, CoverSheetGraph.patientBirthDate);
	var dataTable = GrowthChart.dataTable(CoverSheetGraph.patientGender,
					      GrowthChart.allGraphInfo[graphName],
					      dataSet, CoverSheetGraph.patientBirthDate);
	document.getElementById('growthTable').innerHTML = "";
	if (dataTable.length > 0) {
	    var newestDataPoint = dataTable[dataTable.length-1];
	    if (newestDataPoint.percentile !== null) {
		var displayDate = newestDataPoint.dataDate.getDate() + '/'
		    + (newestDataPoint.dataDate.getMonth() + 1) + '/'
		    + newestDataPoint.dataDate.getFullYear();
		document.getElementById('growthTable').innerHTML 
		    = "<?=_('en:Last value percentile')?>: "
		    + Math.round(newestDataPoint.percentile * 100 * 100) / 100
		    + " <?=_('en:Date')?>: "
		    + displayDate;
	    }
	}
    }
}
</script>

<div style="display:none;">
  <div id="pediatricGrowthGraph" class="container-1030">
      
      <div class="col-left-220">
        <div class="list-lead">CDC</div>
        <ul>
        <script>
        for (var i=0; i<cdcGraphSets.length; i++) {
            renderGraphSelector(cdcGraphSets[i], "cdcGraphSets[" + i + "]");
        }
        </script>
        </ul>
        <div class="list-lead">WHO</div>
        <ul>
        <script>
        for (var i=0; i<whoGraphSets.length; i++) {
            renderGraphSelector(whoGraphSets[i], "whoGraphSets[" + i + "]");
        }
        </script>
        </ul>
      </div>
      <div class="col-main-220" id="growthChartContainer">
          <div class="print-hide"><a class="button12 button-maker print-link" href="#growthChartContainer"><?= _('Imprimer')?></a></div>
          <br/>
          <div id="growthChart" style="width: 810px; min-height: 600px"></div>
          <div id="growthTable"></div>
          <br />
          <div class="print-hide"><a class="button12 button-maker print-link" href="#growthChartContainer"><?= _('Imprimer')?></a></div>
      </div>
          
  </div>
</div>

<form name="mainForm" action="find.php" method="post">
<input type="hidden" name="selectedPatient" value="<?=$index;?>">
<?
include ("bannerbody.php");
if(isset($_POST['errorSave']))
	$errorSave = $_POST['errorSave'];
else
	$errorSave = "";
// Notification text - used by notificationBar.php
if ($fname != "" && $lname != "") {
  $notificationMsg = $pickupPersonName[$lang][1] . " " . $fname . " " . $lname . " - " . $formStatus[$lang][$errorSave];
} else {
  $notificationMsg = $formStatus[$lang][$errorSave];
}
?>
<script type="text/javascript">
// Text that will go in notification
Ext.get('notification-text').createChild("<? echo $notificationMsg; ?>");
// End Notification text
</script>
</form>
<?php
// Patient header div used when printing. Can specify $printHeaderTitle
include("include/printPatientHeader.php");
?>

  <!-- Ped Growth Charting modal -->
  <div id="modalChart" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChartTitle" aria-hidden="true" style="width: 900px">
    <div class="modal-header print-hide">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="modalChartTitle"></h3>
    </div>
    <div class="modal-body">
      <div id="modalChartTitlePrint" class="print-show hidden print-chart-title"></div>
      <div id="pedGrowthContainer" style="width: 813px; margin: 0 auto"></div>
    </div>
    <div class="modal-footer print-hide">
      <button href="#pedGrowthContainer" class="btn btn-small print-link"><?= $pedGrowthLabels[$lang][16] ?></button> 
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?= $allEnc[$lang][27] ?></button>
    </div>
  </div>

<script type="text/javascript" src="include/bootstrap.js"></script>
<script>
/* Creates overlay that allows dropdown main menus to work with 
 * iframes. See boostrap-dropdown.js for details */
$('#main-menu-area').one("click", function() {
    var W=0, H=0, X=0, Y=0;
	$("#centerPanel").each(function(i,el){
	   W = $(el).width();
	   H = $(el).height();
	   X = $(el).position().left;
	   Y = $(el).position().top;
	   $(this).after('<div class="overlay" />');
		$(this).next('.overlay').css({
			width: W,
			height: H,
			left: X,
			top: Y        
		});
	});
})
</script>
</body>
</html>
