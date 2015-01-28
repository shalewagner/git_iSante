<?
require_once 'include/standardHeaderExt.php';
require_once 'labels/menu.php';
require_once 'labels/bannerLabels.php';
require_once 'labels/smartcard.php';
require_once 'backend/jasper-reports.php';
require_once 'backend/primCareSummaryFunctions.php';
$writeCard = "";
if (isset ($_REQUEST['writeCard'])) $writeCard = $_REQUEST['writeCard'];
$patientDOB = getData ("dobDd", "textarea") . "/" . getData ("dobMm", "textarea") . "/" . getData ("dobYy", "textarea");
$patientStatus = getPatientStatus ($pid);
$patientRegimen = getRegimen($pid) ;
$fname = getData ("fname", "textarea");
$lname = getData ("lname", "textarea");
$clinID = getData ("clinicPatientID", "textarea");
$fnamemom =  getData ("fnameMother", "textarea");
$natID =  getData ("nationalID", "textarea");
$symptoms = getSymptoms($pid, $lang, array($coverLabels[$lang][6],$coverLabels[$lang][10]));
$symptoms = str_replace("'","\'",$symptoms);
$mf = getData("sex", "textarea"); 
$prints = getPrints(getMasterPid($pid));
if($mf!=""){
	$mf=$sex[$lang][$mf];
}

if ($writeCard != "") {
  if (empty ($pid) || empty ($lang) || empty ($site)) {
    echo "Required parameter missing!";
    exit;
  } else {
    if (getHivPositive ($pid)) {
      $argumentsArray = array (
        "report" => "214",
        "format" => "html",
        "siteName" => $site,
        "pid" => $pid,
        "lang" => $lang,
        "site" => $site,
        "transferTo" => $site,
        "source" => "writeSmartcard.php"
      );

      $clinsum = file_get_contents(renderReportToFile($argumentsArray, true));

      // Bump up font sizes
      $clinsum = preg_replace_callback ('/\d+\.0px/', create_function ('$matches', 'return (substr ($matches[0], 0, strpos ($matches[0], ".")) + 2) . substr ($matches[0], strpos ($matches[0], "."));'), $clinsum);

      // Grab image ids
      $cnt = preg_match_all ('/<img src="jrImage.php\?image=img_(\d+)_(\d+)_(\d+)"/', $clinsum, $imgs);

      // Initialize image array for all files to be stored in XML
      $imgList = array ("jasperpx.png" => getTempFileName ('jasperpx', 'png'));

      // Replace image filenames
      $clinsum = preg_replace ('/jrImage\.php\?image=px/', 'jasperpx.png', $clinsum);
      $clinsum = preg_replace_callback ('/jrImage\.php\?image=img_\d+_\d+_\d+/', create_function ('$matches', 'return ("jasperimg_" . substr ($matches[0], 22) . ".png");'), $clinsum);

      // Touch up some of the HTML so that IE displays it properly
      $clinsum = preg_replace ('/ align="center"/', '', $clinsum);
      $clinsum = preg_replace ('/JR_PAGE_ANCHOR_0_1"\/>/', 'JR_PAGE_ANCHOR_0_1"></a>', $clinsum);
    } else {
      $argumentsArray = array (
        "username" => getSessionUser(),
        "pid" => $pid,
        "lang" => $lang,
        "siteCode" => $site,
        "source" => "writeSmartcard.php"
      );

      $clinsum = generatePrimCareSummary ($pid, $site, $lang);
      $imgList = array ();
      $imgs = array (array ());
      recordEvent ("primCareSummary", $argumentsArray);
    }

    // Encode HTML string for XML
    $clinsum_xml = base64_encode ($clinsum);

    // Prepare XML string, add encoded HTML
    $xml_out = "<?xml version=\"\"1.0\"\" encoding=\"\"UTF-8\"\"?>";
    $xml_out .= "<clinical-summary create-ts=\"\"" . date ("Y-m-d H:i:s") . "\"\" create-site=\"\"$site\"\" masterPid=\"\"" . getMasterPid ($pid) . "\"\">";
    $xml_out .= "<file-list><file name=\"\"jasperReport.html\"\">$clinsum_xml</file>";

    // Add image files to XML
    foreach (array_keys ($imgs[0]) as $i) {
      $imgList["jasperimg_" . $imgs[1][$i] . "_" . $imgs[2][$i] . "_" . $imgs[3][$i] . ".png"] = getTempFileName("jasperimg" . $imgs[1][$i] . $imgs[2][$i] . $imgs[3][$i], "png");
    }
    foreach ($imgList as $name => $filename) {
      $xml_out .= "<file name=\"\"$name\"\">" . base64_encode (fread (fopen ($filename, "r"), filesize ($filename))) . "</file>";
    }

    // Finish XML
    $xml_out .= "</file-list></clinical-summary>";
  }
}
?>
<title><?=$cmdLabel[$lang][41]?></title> 
<script type="text/vbscript">
        Sub BioPlugInActX_OnIssueNewCard
                //MsgBox(BioPlugInActX.Result)
                Dim ReturnMsg
                ReturnMsg = ""
                If BioPlugInActX.Result = "0" Then
                        ReturnMsg = "<?=$smartcard_labels[$lang][5]?>"
                ElseIf BioPlugInActX.Result = "-1" Then
                        ReturnMsg = "<?=$smartcard_labels[$lang][6]?>"
                ElseIf BioPlugInActX.Result = "BADSCAN" Then
                        ReturnMsg = "<?=$smartcard_labels[$lang][7]?>"
                End If
                If StrComp(ReturnMsg, "") <> 0 Then
                        document.getElementById("returnMsg").innerHTML = ReturnMsg
                        document.getElementById("returnMsg").style.fontSize = "large"
                        document.getElementById("returnMsg").style.color = "red"
                        document.getElementById("returnMsg").style.fontWeight = "bold"
                End If
                disableButtons(false)
        End Sub
	//method to write card, prompting for fingerprint scan
	Sub StartWrite
		If (BioPlugInActX.IsClientInstalled) Then
                        If "<?=$writeCard?>" = "issue" Then
                                //BioPlugInActX.CaptureRegisterFingerData "0"
                                Dim XmlData
                                XmlData = "<?=$xml_out?>" 
                                Lprint = "<?=$prints[1]?>"
                                Rprint = "<?=$prints[0]?>"
                                BioPlugInActX.IssueNewCard "<?=getMasterPid ($pid)?>", XmlData, Lprint, Rprint
                        End If
		Else
			MsgBox("<?=$smartcard_labels[$lang][3]?>")
                        disableButtons(false)
		End If
	End Sub
</script>
<script type="text/javascript">
<? include_once ("include/patientHeaderButtonFunctions.js"); ?>
function disableButtons(flag) {
  document.getElementById("issueButton").disabled = flag;
  //document.getElementById("updateButton").disabled = flag;
  document.getElementById("backButton").disabled = flag;
}
</script>
</head>
<!-- BioPlugin ActiveX control to write to card -->
<object id="BioPlugInActX" width="0" height="0" classid="CLSID:05E8280C-D45A-494F-AE42-840A40444AFF">
	<param name="_Version" value="65536">
	<param name="_ExtentX" value="2646">
	<param name="_ExtentY" value="2646">
	<param name="_StockProps" value="0">
</object>
<?
echo "<body" . ($writeCard ? " onLoad=\"disableButtons(false);StartWrite()\"" : "") . ">\n";
?>
<form name="mainForm" action="writeSmartcard.php" method="post">
<input type="hidden" name="pid" value="<?=$pid?>"/>
<input id="writeCard" type="hidden" name="writeCard" value=""/>
<?
include 'bannerbody.php';
if (!empty ($pid) && preg_match ('/^\d+$/', $pid)) {
  include "patient/patientHeader.php";
}
?>
<table class="header" >
	<tr>
		<td class="m_header"><?=$cmdLabel[$lang][41]?></td>
	</tr>
</table>
<br />
<table>
        <tr>
                <td><span id="returnMsg"></span></td>
        </tr>
        <tr>
                <td>&nbsp;</td>
        </tr>
        <tr>
                <td><?=$smartcard_labels[$lang][2]?></td>
        </tr>
        <tr>
                <td>&nbsp;</td>
        </tr>
        <tr>
                <td><button id="issueButton" class="button-maker button12-short" onclick='document.getElementById("writeCard").value="issue";this.innerHTML="<?=$smartcard_labels[$lang][4]?>";disableButtons(true);document.forms.mainForm.submit();' type="button"><?=$smartcard_labels[$lang][10]?></button></td>
        </tr>
        <tr>
                <td>&nbsp;</td>
        </tr>
        <tr>
                <td><button id="backButton" class="button-maker button12-short" onclick='disableButtons(true);location.href="patienttabs.php?pid=<?=$pid?>&amp;lang=<?=$lang?>&amp;site=<?=$site?>";' type="button"><?=$formCancel[$lang][1]?></button></td>
        </tr>
</table>
</form>
</body>
</html>
