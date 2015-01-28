<?  
chdir('..');
require_once('backend/config.php'); 
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="IE=8">
<title><?=_('en:Enter fingerprint')?></title> 
<!-- BioPlugin ActiveX control to capture finger data -->
<object id="BioPlugInActX" width="0" height="0" classid="CLSID:05E8280C-D45A-494F-AE42-840A40444AFF">
	<param name="_Version" value="65536">
	<param name="_ExtentX" value="2646">
	<param name="_ExtentY" value="2646">
	<param name="_StockProps" value="0">
</object>
<script type="text/vbscript">
	//retrieve fingerdata after the capture operation is completed
	Sub BioPlugInActX_OnCapture
		mainForm.leftbiodata.value = BioPlugInActX.GetSafeLeftFingerData
		mainForm.submit
	End Sub

	//method to start the fingerprint capture operation
	Sub StartCapture
		If (BioPlugInActX.IsClientInstalled) Then
			// presents window in upper right corner of screen without image of hand
		 	//BioPlugInActX.CaptureFingerData "4" 
			// this call is not documented and does not work
			//Call BioPlugInActX.SetDefaultFinger(1)
			BioPlugInActX.CaptureVerifySingleShortFingerData
		Else
			MsgBox("<?=_('en:Client software either not installed or not running.')?>")
		End If
	End sub
</script>
<body onload="StartCapture()">
<form name="mainForm" action="processFingerprint.php" method="post">
	<table class="header"><tr><td class="m_header"><?=_('en:Enter fingerprint')?></td></tr></table>
	<input type="hidden" name="task" value="getFingerprintPid">
	<input type="hidden" name="leftbiodata">
	<input type="hidden" name="lang" value="<?=$_REQUEST['lang']; ?>">
	<input type="hidden" name="site" value="<?=$_REQUEST['site']; ?>">
</form> 
</body>
</html>
