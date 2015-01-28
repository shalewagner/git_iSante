<?php     

if (DEBUG_FLAG) {
  require_once 'firePHP/lib/FirePHPCore/FirePHP.class.php';
  require_once 'firePHP/lib/FirePHPCore/fb.php';
  ob_start();
  $firephp = FirePHP::getInstance(true);
}

require_once 'backend.php';
$pid = $_GET['pid'];

$date = "iso8601";
$wiki = "https:/haiti-dev.cirg.washington.edu";
$wikiSelection = "Patient Timeline";
$image = "taztia_xt_crop.jpg";
$icon_red = "dark-red-circle.png";
$icon_blue = "dark-blue-circle.png";
$icon_green = "dull-green-circle.png";
$icon_gray = "blue_base_small.png";

$dateCalc = "substring(visitdate,1,10)";
$qry = "(select 'Regimen' , regimen, $dateCalc as visitdate , a . drugName as 'drug1' , b . drugName as 'drug2' , c . drugName as 'drug3'
from pepfarTable p , regimen r , drugLookup a , drugLookup b , drugLookup c
where patientid = '" . $pid . "' and p . regimen = r . shortName and r . drugID1 = a . drugID and r . drugID2 = b . drugID and r . drugID3 = c . drugID)
union
(select drugGroup, drugLabelFr, $dateCalc, '' , '' , ''
from a_prescriptions v , drugLookup d
where v . drugID = d . drugID and patientid = '" . $pid . "' and drugGroup not in ('NNRTIs', 'NRTIs', 'Pls')) order by 3";
if (DEBUG_FLAG) FB::log($qry);
//get query from db
$result = dbQuery($qry) or die ("main drug query failed");

//Load query data into arrays
$event_data_1 = array();
$event_data_4 = array();
$event_data_5 = array();
$drugs = array();
while ($row = psRowFetch($result)) {
	$desc = $row[0];
	if ($row[0] == "Regimen") {
	    $desc = "$row[3]". "\\n" ."$row[4]" ."\\n" ."$row[5]";
	    $icon = $icon_red;
            $event_data_5 [] = array ( 
              'start' => $row[2],
              'title' => $row[1],
              'description' => $desc,
              'image' => $icon,
              'icon' => $icon
            );
	} else {
	    $key = $row[2]."|".$row[0];
	    if (array_key_exists($key, $drugs))
	    	array_push($drugs[$key], $row[1]);
	    else
		$drugs[$key] = array($row[1]);
	}
}
foreach ($drugs as $key => $value) {
	$dgroup = explode("|", $key);
	$desc = implode("\\n", $value); 
	$icon = $icon_blue;
	if($dgroup[1] == "Micronutrients") {
	    $icon = $icon_blue;
	} elseif ($dgroup[1] == "Antiparasite") {
	    $icon = $icon_green;
	} elseif ($dgroup[1] == "Antibiotic") {
	    $icon = $icon_green; 
	} elseif ($dgroup[1] == "Antifungal") {
	    $icon = $icon_gray; 
	}
	$event_data_1 [] = array (
		'start' => $dgroup[0],
		'title' => $dgroup[1],
		'description' => $desc,
		'image' => $icon,
		'icon' => $icon
	    );
}

$patient_data_1['wiki-url'] = $wiki;
$patient_data_1['wiki-selection'] = $wikiSelection;
$patient_data_1['dateTimeFormat'] = $date;
$patient_data_1['events'] = $event_data_1;
$json = json_encode($patient_data_1);
$json1 =  stripslashes($json);
  
$patient_data_5['wiki-url'] = $wiki;
$patient_data_5['wiki-selection'] = $wikiSelection;
$patient_data_5['dateTimeFormat'] = $date;
$patient_data_5['events'] = $event_data_5;
$json = json_encode($patient_data_5);
$json5 =  stripslashes($json);
$root = "https://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']);
echo "
<html>
<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=" . CHARSET . "\" />
	<meta http-equiv=\"x-ua-compatible\" content=\"IE=8\">
	<meta name=\"author\" content=\"\" />
	<title>Patient Adherence</title>
	<script type=\"text/javascript\">
		var Timeline_ajax_url = '" . $root . "/timeline/timeline_ajax/simile-ajax-api.js';
		var Timeline_urlPrefix ='" . $root . "/timeline/timeline_js/';       
		var Timeline_parameters='bundle=true&forceLocale=" . $_GET['lang'] . "';
	</script>
	<script type=\"text/javascript\" src=\"" . $root . "/timeline/timeline_js/timeline-api.js\"></script>
	<script type=\"text/javascript\">
	/* https://code.google.com/p/simile-widgets/issues/detail?id=61 */
	SimileAjax.History.enabled = false;\n
	var time1 = " . $json1 . ";\n
	var time5 = " . $json5 . ";\n
	var tl;
  
	function onLoad() {
		var eventSource1 = new Timeline.DefaultEventSource();
		var eventSource5 = new Timeline.DefaultEventSource();
		
	 	var tl_el = document.getElementById('tl');
		var theme = Timeline.ClassicTheme.create();
      theme.event.bubble.width = 100;
      theme.event.bubble.height = 150;
      theme.event.label.width = 150;
  
    var bandInfos = [
      Timeline.createBandInfo({
        eventSource:    eventSource5,
        width:          '50%', 
        intervalUnit:   Timeline.DateTime.MONTH, 
        theme:		 theme,
        layout:	 'original',
        intervalPixels: 30
      }),
      Timeline.createBandInfo({
        eventSource:    eventSource1,
        width:          '50%', 
        intervalUnit:   Timeline.DateTime.MONTH, 
        theme:		 theme,
        layout:	 'original',
        intervalPixels: 30
      })
    ];
		bandInfos[1].syncWith = 0;
		bandInfos[1].highlight = true;

		tl = Timeline.create(tl_el, bandInfos, Timeline.HORIZONTAL);
		var url = 'images/';
		eventSource1.loadJSON(time1, url);
		eventSource5.loadJSON(time5, url);
		//tl.layout();
    // Used to make the right edge be the current date
    var endAtCurrent = SimileAjax.DateTime.parseIso8601DateTime('".  date("Y-m-d") ."');
    function centerTimeline() {
        tl.getBand(0,1).setMaxVisibleDate(endAtCurrent);
    }
    centerTimeline();
    //console.log('centered');

	}";
?>
</script>
</head>
<body onload="onLoad()">
<div id="tl" align="center" style="height: 300px;width: 100%; font-size: 9px"></div>
</body>
</html>
