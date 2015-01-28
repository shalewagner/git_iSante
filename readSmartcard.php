<?
require_once 'include/standardHeaderExt.php';
require_once 'labels/menu.php';
require_once 'labels/bannerLabels.php';
require_once 'labels/smartcard.php';
$readCard = 0;
$result = "";
$mrn = "";
$ccd = "";
if (isset ($_REQUEST['readCard'])) $readCard = $_REQUEST['readCard'];
if (isset ($_REQUEST['result'])) $result = $_REQUEST['result'];
if (isset ($_REQUEST['ccd'])) $ccd = $_REQUEST['ccd'];
if (isset ($_REQUEST['mrn'])) $mrn = $_REQUEST['mrn'];

if ($readCard) {
  $eventArgs = array ("source" => "readSmartCard.php");
  if ($result == "0") {
    if (empty ($pid) || empty ($lang) || empty ($site)) {
      $result = "BADDATA";
      $eventArgs['msg'] = "Required parameter missing.";
    } else {
      $eventArgs['pid'] = $pid;
      // Parse/sanity check incoming data
      $xml = simplexml_load_string ($ccd);
      if (!$xml) {
        $result = "BADDATA";
        $eventArgs['msg'] = "Error parsing XML from smartcard.";
      } else {
        // Create encounter record for incoming clinical summary
        $now = date ("Y-m-d H:i:s");
        $xferid = addEncounter ($pid, date ("d"), date ("m"), date ("y"), $site, $now, 33, "", "", "", "",  "", "", "", 0, "", $now);

        // Update masterPid for patient
        updateMasterPid ($pid, $mrn);

        // Store clinical summary files in the proper location
        mkdir (getEncounterFilePath ($xferid, ""), 0770, true);
        foreach ($xml->xpath ("//file") as $file) {
          $status = file_put_contents (getEncounterFilePath ($xferid, "") . $file['name'], base64_decode ($file));
          if ($status == 0) {
            $result = "BADDATA";
            break;
          }
        }
        $eventArgs['msg'] = "Clinical summary successfully read from smartcard and stored.";
      }
    }
  } else {
    $eventArgs['msg'] = "Error reading from smartcard.";
  }
  recordEvent ("readSmartcard", $eventArgs);
}
?>
<title><?=$encType[$lang][33];?></title> 
<script type="text/vbscript">
	//method to read card
	Sub StartRead
                document.getElementById("goButton").innerHTML = "<?=$smartcard_labels[$lang][4]?>"
                dim x
                x = setTimeout(ActuallyRead, 5000)
	End sub
        Function ActuallyRead()
		If (BioPlugInActX.IsClientInstalled) Then
			BioPlugInActX.ReadCCD
		Else
			MsgBox("<?=$smartcard_labels[$lang][3];?>")
		End If
        End Function
        Sub BioPlugInActX_OnReadCCD
                If BioPlugInActX.Result = "0" And (IsEmpty(BioPlugInActX.MRN) Or IsEmpty(BioPlugInActX.CCD) Or BioPlugInActX.MRN = "" Or BioPlugInActX.CCD = "") Then
                        BioPlugInActX.Result = "-1"
                End If
                document.getElementById("result").value = BioPlugInActX.Result
                document.getElementById("ccd").value = BioPlugInActX.CCD
                document.getElementById("mrn").value = BioPlugInActX.MRN
                document.forms.mainForm.submit()
        End Sub
</script>
<script type="text/javascript">
function disableButtons(flag) {
  document.getElementById("goButton").disabled = flag;
  document.getElementById("backButton").disabled = flag;
}

function showMsg() {
  var result = "<?=$result?>";
  var returnMsg = "";
  switch (result) {
    case "0":
      returnMsg = "<?=$smartcard_labels[$lang][5]?>";
      break;
    case "-1":
      returnMsg = "<?=$smartcard_labels[$lang][6]?>";
      break;
    case "BADSCAN":
      returnMsg = "<?=$smartcard_labels[$lang][7]?>";
      break;
    case "MISMATCH":
      returnMsg = "<?=$smartcard_labels[$lang][8]?>";
      break;
    case "BADDATA":
      returnMsg = "<?=$smartcard_labels[$lang][9]?>";
      break;
  }
  if (returnMsg != "") {
    document.getElementById("returnMsg").innerHTML = returnMsg;
    document.getElementById("returnMsg").style.fontSize = "large";
    document.getElementById("returnMsg").style.color = "red";
    document.getElementById("returnMsg").style.fontWeight = "bold";
  }
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
echo "<body" . ($readCard ? " onLoad=\"showMsg()\"" : "") . ">\n";
?>
<form name="mainForm" action="readSmartcard.php" method="post">
<input type="hidden" name="pid" value="<?=$pid?>"/>
<input type="hidden" name="lang" value="<?=$lang?>"/>
<input type="hidden" name="readCard" value="1"/>
<input type="hidden" name="site" value="<?=$site?>"/>
<input id="result" type="hidden" name="result" value=""/>
<input id="ccd" type="hidden" name="ccd" value=""/>
<input id="mrn" type="hidden" name="mrn" value=""/>
<table class="header" >
	<tr>
		<td class="m_header"><?=$encType[$lang][33];?></td>
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
                <td><?=$smartcard_labels[$lang][2];?></td>
        </tr>
        <tr>
                <td>&nbsp;</td>
        </tr>
        <tr>
                <td><button id="goButton" class="button-maker button12-short" onclick='disableButtons(true);StartRead();' type="button"><?=$smartcard_labels[$lang][1];?></button></td>
        </tr>
        <tr>
                <td>&nbsp;</td>
        </tr>
        <tr>
                <td><button id="backButton" class="button-maker button12-short" onclick='disableButtons(true);location.href="allEnc.php?pid=<?=$pid;?>&amp;lang=<?=$lang;?>&amp;site=<?=$site;?>";' type="button"><?=$allEnc[$lang][0];?>/<?=$formCancel[$lang][1];?></button></td>
        </tr>
</table>
</form>
</body>
</html>
