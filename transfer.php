<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/register.php';
echo "
<title>" . ${$typeArray[$type]. 'FormTitle'}[$lang][1] . "</title>
</head>
<body>
<form name=\"mainForm\"  target=\"_parent\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
<input  type=\"hidden\" name=\"site\" value=\"$site\" />
<input  type=\"hidden\" name=\"lang\" value=\"$lang\" />
<input  type=\"hidden\" name=\"lastPid\" value=\"$lastPid\" />
";
include ("include/patientIdClinicVisitDate.php");   
$includePath = getEncounterFilePath($eid, "jasperReport.html", DB_SITE); 
echo "<input type=\"hidden\" name=\"ipath\" value=\"" . $includePath . "\">";

$fp = fopen($includePath,"r");
while($buf = fgets($fp)) {
   if (CHARSET != "UTF-8") $buf = iconv ("UTF-8", CHARSET, $buf);
   echo preg_replace('/src="([^"]+)"/', "src=\"getEncounterImage.php?eid=$eid&fname=$1\"", $buf) . "\n"; 
} 
fclose ($fp);

echo "
  </div>
   </form>
 </body>
</html>
";

?>
