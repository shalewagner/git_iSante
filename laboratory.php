<?php
require_once 'include/standardHeaderExt.php';
if ($version == 3)
	require_once 'laboratory/3.php'; 
else { 
	require_once 'labels/followup.php';
	require_once 'labels/intake.php';
	require_once 'labels/menu.php';
	require_once 'labels/pediatric.php';

	$mf = getData("sex", "textarea");
	if($type == "19"){
		$version = 0;
		$label1 = $pedLaboratory[$lang][0];
		$label2 = $pedLaboratory[$lang][1];
		$labRows = pedLabRows (2001);
	} else {
		$label1 = $labs_header[$version][$lang][1];
		$label2 = $labs_subhead2[$lang][1];
		$labRows = labRows (2001, $version);
	}
	echo "<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>";
	$tabsOn = false;
	if ($tabsOn) include("include/tabs/laboratoryTabs.php");
	echo "
	<script language=\"JavaScript\" type=\"text/javascript\" src=\"laboratory/labs.js\"></script>
	";

	if($mf == 'M' || $mf == 'm' || $mf == 2){

	echo "
	<script language=\"JavaScript\" type=\"text/javascript\">
	   Ext.onReady(function(){
	        var pregArr = new Array('pregnancyTest[]', 'pregnancyTestResult0','pregnancyTestResult1', 'pregnancyTestAbnormal[]', 'pregnancyTestDt');

	        for(var f = 0; f < pregArr.length;f++){
	                document.getElementById(pregArr[f]).disabled = 'disabled';
	        }
	   });
	</script>
	";
	}

	echo "
	 </head>
	 <body>
	<form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
	 <input id=\"hemAlertDone\" name=\"hemAlertDone\" type=\"hidden\" value=\"false\"/>
	 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
	 <input id=\"sex1\" name=\"sex1\" type=\"hidden\" value=\"".$mf."\"/>
	";
	$tabIndex = 0;

	include ('include/patientIdClinicVisitDate.php');
	echo "
	<div id=\"tab-panes\">
	<div id=\"pane1\"><hr/>
	";
	$tabIndex = 10;
	include ('include/associatedForm.php');
	echo"

	</div>
	<!-- ******************************************************************** -->
	<!-- ********************* Labs Ordered & Results *********************** -->
	<!-- ******************* (tab indices 2001 - 3000) ********************** -->
	<!-- ******************************************************************** -->
	<div id=\"pane2\">
	  <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
	   <tr>
	    <td colspan=\"6\" class=\"under_header\" width=\"100%\">
	    </td>
	   </tr>
	   <tr>
	    <td class=\"s_header\" colspan=\"6\" width=\"100%\">" . $label1 . "</td>
	   </tr>
	   <tr>
	    <td class=\"sm_header_cnt\" width=\"10%\">" . $labs_subhead1[$lang][0] . "</td>
	    <td class=\"sm_header_lt\" width=\"20%\">" . $labs_subhead1[$lang][1] . "</td>
	    <td class=\"sm_header_lt\" width=\"35%\">" . $labs_subhead1[$lang][2] . "</td>
	    <td class=\"sm_header_cnt\" width=\"10%\">" . $labs_subhead1[$lang][3] . "</td>
	    <td width=\"5%\">&nbsp;</td>
	    <td class=\"sm_header_lt\" width=\"20%\">" . $labs_subhead1[$lang][4] . "</td>
	   </tr>
	   <tr>
	    <td class=\"top_line\" width=\"10%\">&nbsp;</td>
	    <td class=\"top_line\" colspan=\"5\" width=\"90%\"><b>" . $label2 . "</b></td>
	   </tr>";

	echo $labRows['full'] . "
	  </table>";

	$tabIndex = 4000;
	if($type == '6'){
		include ("laboratory/" . $version . ".php");
	} else {
		include ("pedlaboratory.php");
	}
	//echo $labMatrixData;
	echo "
	  </div>
	</div>
	";

	$tabIndex = 5000;
	$formName = "lab";
	echo"<div id=\"saveButtons\">";
	include ("include/saveButtons.php");
	echo "
	</div>
	   </form>
	 </body>
	</html>"; 
}
?>
