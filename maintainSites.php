<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/site.php';
?>
<title>Maintain Sites</title>
<script type="text/javascript" src="include/formValidationExt.js"></script>
<script type="text/javascript">
var fm = Ext.form; 
<? include ("maintainSites/maintainSites.php"); ?> 
</script>
</head>
<body>
<form name="mainForm" action="maintainSites.php" method="post">
<? include ("bannerbody.php"); ?>
<div class="contentArea"> 
<div id="hello-win" class="x-hidden"></div>
</div> 
</form>
</body>
</html>