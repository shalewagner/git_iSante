<?php
require_once 'include/standardHeader.php';
require_once 'labels/report.php';
$printLabel = ($lang == 'fr') ? 'Impression':'Print';
if (DEBUG_FLAG) print_r ($_POST);
if (!empty ($_POST['order']))
	$order = $_POST['order'];
else
	$order = "";
if (!empty ($_POST['odir']))
	$odir = $_POST['odir'];

$queryTable = stripslashes($_POST['adhocQuery']);

echo "
<title>" . $reportFormTitle2[$lang] . "</title>
<script type=\"text/javascript\">
function runJasper(format) {
    document.forms[0].action = 'getTempFile.php?baseName=xlsOutput&extension=csv'
    document.forms[0].method = 'post'
    document.forms[0].submit()
}
</script>
</head>
<body>
<form name=\"mainForm\" action=\"#\">

<div class=\"hide-this print-show\">
  <div style=\"float: right; margin-left: 20px\"><img src=\"images/isante_logo_bw_large.png\" width=\"108\" height=\"30\" /></div></div>

 <table class=\"header\">
   <tr>
	<td class=\"m_header\">" .
		$reportFormTitle2[$lang] . "
	</td>
   </tr>
 </table>
 <input class=\"print-hide\" type=\"button\" name=\"ret1\" value=\"" . $repReturn[$lang] . "\" onclick=\"window.close()\" />
&nbsp;<input class=\"print-hide\" type=\"button\" name=\"printButton\" value=\"" . $printLabel . "\" onclick=\"window.print()\" />
&nbsp;<input class=\"print-hide\" type=\"button\" name=\"genExcel\" value=\"Excel (CSV)\" onclick=\"runJasper('xls')\" />
 <center>";
if ( $order != "" ) {
  $parts = preg_split('/(order by .*?)/i', $queryTable);
  $queryTable = $parts[0] . ' order by ' . $order . ' ' . $odir;
}
recordEvent('adhoc', array(
			   'query' => $queryTable, 
			   'rtype' => $rtype, 
			   'lang' => $lang,
			   'reportNumber' => '999',
			   'siteCode' => $site
			   ));
generateQueryResult($queryTable, 'adhoc', '', $lang, $site, 0, 0, 0, 0, 0, '', '', '', '', '','');
echo "
 </center>";
if (DEBUG_FLAG) print $queryTable;
echo "<br />
  	<input class=\"print-hide\" type=\"button\" name=\"ret2\" value=\"" . $repReturn[$lang] . "\" onclick=\"window.close()\" />
  	";
?>
    </form>
  </body>
</html>
