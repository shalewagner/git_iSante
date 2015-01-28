<?
require_once('backend/config.php');
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=_('en:Check to see if the scanner is set up')?></title>
</head>

<body>

<form name="mainForm" action="splash.php" method ="post" style="WIDTH: 250px">
	<table class="header">
		<tr><td class="m_header"><?=_('en:Scanner Status')?></td></tr> 
        	<tr><td><input type="button" value="<?=_('en:Check Status')?>" onclick="CheckIt()" /></td></tr>
		<tr><td><input type="text" size="75" id="Software_Status"></tr></td>
		<tr><td><input type="text" size="75" id="Scanner_Status"></tr></td>
		<tr><td>&nbsp;</tr></td>
        	<tr><td><input type="button" value="<?=_('en:Display scanner window')?>" onclick="doCapture()" /></td></tr> 
        	<tr><td><input type="submit" value="<?=_('en:Return to iSanté')?>" /></td></tr>
	</table>
</form>

<!-- BioPlugin ActiveX control to capture finger data -->
<object id="BioPlugInActX" width="0" height="0"
 classid="CLSID:05E8280C-D45A-494F-AE42-840A40444AFF">
  <param name="_Version" value="65536">
  <param name="_ExtentX" value="2646">
  <param name="_ExtentY" value="2646">
  <param name="_StockProps" value="0">
</object>

<script type="text/javascript">
function doCapture() {
	try {
		BioPlugInActX.CaptureVerifySingleShortFingerData();
        } catch (e) {
		alert('<?=_('en:Scanner window cannot be displayed')?>');
		alert(e);
        }
}


function CheckIt() {
  if (BioPlugInActX.IsClientInstalled()) {
    document.getElementById('Software_Status').value = "<?=_('en:M2Sys client software installed')?>";
  } else {
    document.getElementById('Software_Status').value = "<?=_('en:M2Sys client software not installed.')?>";
  }

  if (BioPlugInActX.IsClientRunning()) {
    BioPlugInActX.GetScannerCount();
  } else {
    document.getElementById('Scanner_Status').value = "<?=_('en:M2Sys client software not running.')?>";
  }
};

function BioPlugInActX::OnScannerStatus() {
  document.getElementById('Scanner_Status').value = "<?=_('en:Scanner count is: ')?>" + BioPlugInActX.result;
}

</script>

</body>
</html>
