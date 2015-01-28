<?php
include("include/standardHeaderExt.php");
$type=9;

echo "<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>

 </head>
 <body>

  <form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
   <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>

";
$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");

echo "
<div id=\"tab-panes\">
<div id=\"pane1\">
</div>

<!-- ******************************************************************** -->
<!-- ************************* Patient Referrals ************************ -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"under_header\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\">" . $patientReferrals_header[$lang][1] . "</td>
   </tr>
  </table>
  <table class=\"header\">
   <tr>
    <td>
     <table>
     <tr>
        <th class=\"sm_header_lt\" width=\"20%\">" . $referralsSubhead1[$lang][1] . "</th>
        <th class=\"sm_header_lt_pd\" width=\"25%\">" . $referralsSubhead2[$lang][1] . "</th>
         <th class=\"sm_header_lt\" width=\"1%\"></td>
        <th class=\"sm_header_lt\" width=\"20%\">" . $referralsSubhead3[$lang][1] . "</th>
        <th class=\"sm_header_lt\" width=\"15%\">" . $referralsSubhead4[$lang][0] . "</th>
        <th class=\"sm_header_lt\" width=\"1%\"></td>
        <th class=\"sm_header_lt\" width=\"20%\">" . $referralsSubhead5[$lang][1] . "</th>
     </tr>";
     $j = 0;
     $results = getReferrals($_GET['eid']);
     $tabindex = 2001;
     foreach ($results as $row) {
       $id = $row['refSequence'];

       // Ignore row if sequence number is zero
       if (empty ($id)) continue;

       if ($lang == "en") {
	  $langLabel = $row['refLabelEn'];
//	  $ddd = "mm/dd/yy";
       } else {
	  $langLabel = $row['refLabelFr'];
//	  $ddd = "jj/mm/aa";
       }
      echo "<tr>
       <td width=\"20%\">
           <input tabindex=\"" . $tabindex++ . "\" name=\"" . $row['refName'] . "Checked\" " . getData ($row['refName'] . "Checked", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $langLabel;
//	   if (!empty($row['refAdateDd'])) echo " checked";
//           echo ">" . $langLabel . "
      echo "
       </td>
       <td class=\"left_pad\" width=\"25%\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"text\" " . getData ($row['refName'] . "Clinic", "text") . " name=\"" . $row['refName'] . "Clinic\">
       </td>";
       echo "<td id=\"" . $row['refName'] . "AdateDtTitle\"></td>";
      if ($lang == "en") echo "
       <td  width=\"20%\">
		  <input tabindex=\"" . $tabindex++ . "\" type=\"text\" size=\"8\"  value=\"" . getData ($row['refName'] . "AdateDd", "textarea") . "/". getData ($row['refName'] . "AdateMm", "textarea") ."/". getData ($row['refName'] . "AdateYy", "textarea") . "\" id=\"" . $row['refName'] . "AdateDt\" name=\"" . $row['refName'] . "AdateDt\" maxlength=\"8\">
		  <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "AdateDd", "text") . " id=\"" . $row['refName'] . "AdateDd\" name=\"" . $row['refName'] . "AdateDd\" >
		  <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "AdateMm", "text") . " id=\"" . $row['refName'] . "AdateMm\" name=\"" . $row['refName'] . "AdateMm\">
		  <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "AdateYy", "text") . " id=\"" . $row['refName'] . "AdateYy\" name=\"" . $row['refName'] . "AdateYy\"></td>";


      else echo "
       <td  width=\"20%\">
       	   <input tabindex=\"" . $tabindex++ . "\" type=\"text\" size=\"8\"  value=\"" . getData ($row['refName'] . "AdateDd", "textarea") . "/". getData ($row['refName'] . "AdateMm", "textarea") ."/". getData ($row['refName'] . "AdateYy", "textarea") . "\" id=\"" . $row['refName'] . "AdateDt\" name=\"" . $row['refName'] . "AdateDt\" maxlength=\"8\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "AdateDd", "text") . " id=\"" . $row['refName'] . "AdateDd\" name=\"" . $row['refName'] . "AdateDd\" >
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "AdateMm", "text") . " id=\"" . $row['refName'] . "AdateMm\" name=\"" . $row['refName'] . "AdateMm\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "AdateYy", "text") . " id=\"" . $row['refName'] . "AdateYy\" name=\"" . $row['refName'] . "AdateYy\"></td>";

      echo "
       <td width=\"15%\">
           <span>
           <input tabindex=\"" . $tabindex++ . "\" type=\"radio\" value=\"1\" name=\"" . $row['refName'] . "Akept[]\" " . getData ($row['refName'] . "Akept", "checkbox", 1) . "> " . $referralsSubhead4[$lang][1] . "
           <input tabindex=\"" . $tabindex++ . "\" type=\"radio\" value=\"2\" name=\"" . $row['refName'] . "Akept[]\" " . getData ($row['refName'] . "Akept", "checkbox", 2) . "> " . $referralsSubhead4[$lang][2] . "</span></td>";
	  echo "<td  id=\"" . $row['refName'] . "FdateDtTitle\"></td>";
      if ($lang == "en") echo "
       <td width=\"20%\">
 		   <input tabindex=\"" . $tabindex++ . "\" type=\"text\" size=\"8\" value=\"" . getData ($row['refName'] . "FdateDd", "textarea") . "/". getData ($row['refName'] . "FdateMm", "textarea") ."/". getData ($row['refName'] . "FdateYy", "textarea") . "\" id=\"" . $row['refName'] . "FdateDt\" name=\"" . $row['refName'] . "AdateDt\" maxlength=\"8\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "FdateDd", "text") . " id=\"" . $row['refName'] . "FdateDd\" name=\"" . $row['refName'] . "FdateDd\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "FdateMm", "text") . " id=\"" . $row['refName'] . "FdateMm\" name=\"" . $row['refName'] . "FdateMm\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "FdateYy", "text") . " id=\"" . $row['refName'] . "FdateYy\" name=\"" . $row['refName'] . "FdateYy\"></td>";

      else echo "
       <td>
           <input tabindex=\"" . $tabindex++ . "\" type=\"text\" size=\"8\" value=\"" . getData ($row['refName'] . "FdateDd", "textarea") . "/". getData ($row['refName'] . "FdateMm", "textarea") ."/". getData ($row['refName'] . "FdateYy", "textarea") . "\" id=\"" . $row['refName'] . "FdateDt\" name=\"" . $row['refName'] . "AdateDt\" maxlength=\"8\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "FdateDd", "text") . " id=\"" . $row['refName'] . "FdateDd\" name=\"" . $row['refName'] . "FdateDd\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "FdateMm", "text") . " id=\"" . $row['refName'] . "FdateMm\" name=\"" . $row['refName'] . "FdateMm\">
           <input tabindex=\"" . $tabindex++ . "\" type=\"hidden\" " . getData ($row['refName'] . "FdateYy", "text") . " id=\"" . $row['refName'] . "FdateYy\" name=\"" . $row['refName'] . "FdateYy\"></td>";

      echo "
       </tr>";
      }
     echo "</table>
   </tr>
  </table>

  <table class=\"header\">
   <tr>
     <td class=\"s_header\">" . $referralsSubhead1[$lang][0] . " &nbsp; <i>" . $referralsSubhead1[$lang][2] . "</i></td>
   </tr>
   <tr>
    <td>
      <table class=\"header\">
      <tr>
       <td><textarea tabindex=\"3001\" name=\"homeVisitRemarks\" cols=\"80\" rows=\"5\">" . getData ("homeVisitRemarks", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>

<div id=\"saveButtons\">";
include ("include/saveButtons.php");

echo "
</div></div></form>
 </body>
</html>
";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"referral/0.js\"></script>";
?>
