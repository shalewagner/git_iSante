<?  
chdir('..');
require_once('backend.php'); 
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="IE=8">
<title><?=_('en:Register fingerprints--registration requires prints of both middle fingers, three scans each.')?></title> 
<!-- BioPlugin ActiveX control to capture finger data -->
<object id="BioPlugInActX" width="0" height="0" classid="CLSID:05E8280C-D45A-494F-AE42-840A40444AFF">
	<param name="_Version" value="65536">
	<param name="_ExtentX" value="2646">
	<param name="_ExtentY" value="2646">
	<param name="_StockProps" value="0">
</object>
<script type="text/vbScript">
	//retrieve fingerdata after the capture operation is completed
	Sub BioPlugInActX_OnCapture
		mainForm.LeftbiodataType.value = BioPlugInActX.GetLeftFingerType
		mainForm.RightbiodataType.value = BioPlugInActX.GetRightFingerType
		mainForm.Leftbiodata.value = BioPlugInActX.GetSafeLeftFingerData
		mainForm.Rightbiodata.value = BioPlugInActX.GetSafeRightFingerData
		mainForm.submit
	End Sub

	//method to start the fingerprint capture operation
	Sub StartCapture 
		BioPlugInActX.CaptureRegisterFingerData
	End Sub
</script>
<body onload="StartCapture()">
<form name="mainForm" action="processFingerprint.php" method="post" enctype="multipart/form-data">
	<table class="header"><tr><td class="m_header"><?=_('en:Register fingerprints--registration requires prints of both middle fingers, three scans each.')?></td></tr></table>
	<input type="hidden" name="task" value="registerFingerprints">
	<input type="hidden" name="Leftbiodata">
	<input type="hidden" name="Rightbiodata">
	<input type="hidden" name="LeftbiodataType">
	<input type="hidden" name="RightbiodataType">
	<input type="hidden" value="1" name="LocationID" id="LocationID">
	<input type="hidden" name="id" value="<?=getMasterPid($_REQUEST['pid'])?>">
	<input type="hidden" name="lang" value="<?=$_REQUEST['lang']; ?>">
	<input type="hidden" name="site" value="<?=$_REQUEST['site']; ?>">
</form>
</body>
</html>
