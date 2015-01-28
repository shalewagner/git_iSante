<?php

require_once 'backend.php';
require_once 'drugClauses.php';
require_once 'labels/reportSetupLabels.php';
require_once 'labels/report.php';

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>Monthly, Facility-Based HIV Care/ART Reporting Form</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>
  <table class=\"header\">
	<tr>
	<td class=\"m_header\">
		Monthly, Facility-Based HIV Care/ART Reporting Form
	</td>
	</tr>
  </table>
  <input type=\"button\" name=\"ret1\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />
  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td align=\"left\" valign=\"bottom\" width=\"50%\">Month: " . reportGen ("month") . "</td>
    <td align=\"left\" valign=\"bottom\" width=\"50%\">Year: " . reportGen ("year") . "</td>
   </tr>
   <tr>
    <td align=\"left\" valign=\"bottom\" width=\"50%\">Grantee: " . reportGen ("grantee") . "</td>
    <td align=\"left\" valign=\"bottom\" width=\"50%\">Facility: " . reportGen ("facility") . "</td>
   </tr>
   <tr>
    <td align=\"left\" valign=\"bottom\" width=\"50%\">Location: " . reportGen ("location") . "</td>
    <td align=\"left\" valign=\"bottom\" width=\"50%\">Country: " . reportGen ("country") . "</td>
   </tr>
  </table>

  <br /><br />

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td colspan=\"7\" valign=\"bottom\" width=\"100%\"><b>1. HIV care (non-ART and ART) - new and cumulative number of persons enrolled</b></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td align=\"center\" colspan=\"2\" valign=\"bottom\" width=\"20%\">Cumulative number of persons ever enrolled in HIV care at this facility at beginning of month</td>
    <td align=\"center\" colspan=\"2\" valign=\"bottom\" width=\"20%\">New persons enrolled in HIV care at this facility during the month</td>
    <td align=\"center\" colspan=\"2\" valign=\"bottom\" width=\"20%\">Cumulative number of persons ever enrolled in HIV care at this facility at end of month</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">1. Males (>14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">a.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">g.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">m.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.m") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">2. Non-pregnant females (>14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">b.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">h.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">n.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.n") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">3. Pregnant females</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">c.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">i.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.i") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">o.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.o") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">4. Boys (0-14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">d.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">j.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.j") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"12.5%\">p.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.p") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">5. Girls (0-14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">e.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">k.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.k") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">q.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.q") . "</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Total</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">f.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">l.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.l") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">r.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.r") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" bgcolor=\"silver\" valign=\"bottom\" width=\"40%\"><br /></td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"20%\">&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" valign=\"bottom\" width=\"40%\">Total number of persons who are enrolled and eligible for ART but have not been started on ART</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">s.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("1.s") . "</td>
   </tr>
  </table>

  <br /><br />

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td colspan=\"7\" valign=\"bottom\" width=\"100%\"><b>2. ART care - new and cumulative number of persons started</b></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td align=\"center\" colspan=\"2\" valign=\"bottom\" width=\"20%\">Cumulative number of persons ever started on ART at this facility at beginning of month</td>
    <td align=\"center\" colspan=\"2\" valign=\"bottom\" width=\"20%\">New persons started on ART at this facility during the month</td>
    <td align=\"center\" colspan=\"2\" valign=\"bottom\" width=\"20%\">Cumulative number of persons ever started on ART at this facility at end of month</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">1. Males (>14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">a.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">g.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">m.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.m") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">2. Non-pregnant females (>14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">b.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">h.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">n.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.n") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">3. Pregnant females</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">c.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">i.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.i") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">o.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.o") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">4. Boys (0-14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">d.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">j.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.j") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">p.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.p") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">5. Girls (0-14 years)</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">e.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">k.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.k") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">q.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.q") . "</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Total</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">f.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">l.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.l") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">r.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.r") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" bgcolor=\"silver\" valign=\"bottom\" width=\"40%\"><br /></td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"20%\">&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" valign=\"bottom\" width=\"40%\">No. of persons on ART and already enrolled in program who transferred into facility in last month</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">s.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.s") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" valign=\"bottom\" width=\"40%\">Number of persons who restarted ART during the last month, after stopping ART for at least 1 month</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">t.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.t") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" bgcolor=\"silver\" valign=\"bottom\" width=\"40%\"><br /></td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"20%\">&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" valign=\"bottom\" width=\"40%\">Number of baseline CD4<sup>+</sup> counts for persons who started ART in the last month</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">u.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.u") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"></td>
    <td colspan=\"4\" valign=\"bottom\" width=\"40%\">Median baseline CD4<sup>+</sup> count for persons who started ART in the last month</td>
    <td align=\"right\" valign=\"bottom\" width=\"10%\">v.</td><td align=\"right\" valign=\"bottom\" width=\"10%\">" . reportGen ("2.v") . "</td>
   </tr>
  </table>

  <br /><br />

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td colspan=\"5\" valign=\"bottom\" width=\"100%\"><b>3. Change in CD4<sup>+</sup> count and adherence to ART for 6-month and 12-month cohorts</b></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">For persons who have completed</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"30%\">6 months of ART</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"30%\">12 months of ART</td>
   </tr>
   <tr>
    <td bgcolor=\"silver\" valign=\"bottom\" width=\"40%\"><br /></td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"30%\">&nbsp;</td>
    <td colspan=\"2\"bgcolor=\"silver\" valign=\"bottom\" width=\"30%\">&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Cohort started in (month/year)</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">a.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">i.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.i") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Number of persons in cohort</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">b.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">j.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.j") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Number of baseline CD4<sup>+</sup> counts</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">c.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">k.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.k") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Median baseline CD4<sup>+</sup> count</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">d.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">l.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.l") . "</td>
   </tr>
   <tr>
    <td bgcolor=\"silver\" valign=\"bottom\" width=\"40%\"><br /></td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"30%\">&nbsp;</td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"30%\">&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"30%\">after 6 months of ART</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"30%\">after 12 months of ART</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Number of persons in cohort</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">e.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">m.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.m") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Number of CD4<sup>+</sup> counts</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">f.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">n.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.n") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Median CD4<sup>+</sup> count</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">g.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">o.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.o") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Number of persons who picked up ARVs each month for 6 months</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">h.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.h") . "</td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"30%\">&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">Number of persons who picked up ARVs each month for 12 months</td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"30%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"15%\">p.<td align=\"right\" valign=\"bottom\" width=\"15%\">" . reportGen ("3.p") . "</td>
   </tr>
  </table>

  <br /><br />

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>4. Regimen at end of month</b></td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Male</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Female</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>On 1st-line ART regimen</b></td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>4.1 Adults (>14 years)</b></td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">d4T-3TC-NVP</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">j.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.j") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">d4T-3TC-EFV</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">k.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.k") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">ZDV-3TC-NVP</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">l.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.l") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">ZDV-3TC-EFV</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">m.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.m") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">e.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">n.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.n") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">f.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">o.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.o") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">g.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">p.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.p") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">h.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">q.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.q") . "</td>
    <td colspan=\"2\" align=\"right\" valign=\"bottom\" width=\"7.5%\"></td>
    <td align=\"center\" rowspan=\"2\" valign=\"bottom\" width=\"15%\">Total number of adults on 1st-line regimen</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Adults on 1st-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">i.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.i") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">r.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.r") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">s.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.1.s") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>4.2 Children (0-14 years)</b></td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">d4T-3TC-NVP</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">k.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.k") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">d4T-3TC-EFV</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">l.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.l") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">ZDV-3TC-NVP</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">m.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.m") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">ZDV-3TC-EFV</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">n.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.n") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">e.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">o.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.o") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">f.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">p.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.p") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">g.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">q.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.q") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">h.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">r.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.r") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\"></td>
    <td align=\"center\" rowspan=\"2\" valign=\"bottom\" width=\"15%\">Total number of children on 1st-line regimen</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Children on 1st-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">i.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.i") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">s.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.s") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">u.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.u") . "</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Adults and children on 1st-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">j.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.j") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">t.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.t") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">v.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.2.v") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"15%\">Total adults and children on 1st-line regimens</td>
   </tr>
   <tr>
    <td bgcolor=\"silver\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>On 2nd-Line ART regimen</b></td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>4.3 Adults (>14 years)</b></td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">ZDV-ddI-LPV/r</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">i.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.i") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">d4T-ddI-LPV/r</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">j.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.j") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">k.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.k") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">l.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.l") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">e.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">m.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.m") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">f.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">n.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.n") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">g.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">o.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.o") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\"></td>
    <td align=\"center\" rowspan=\"2\" valign=\"bottom\" width=\"15%\">Total number of adults on 2nd-line regimen</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Adults on 2nd-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">h.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">p.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.p") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">q.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.3.q") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>4.4 Children (0-14 years)</b></td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">d4T-ddI-NFV</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">k.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.k") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">ZDV-ddI-LPV/r</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">l.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.l") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">m.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.m") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">n.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.n") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">e.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">o.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.o") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">f<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">p<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.p") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"30%\"></td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">g.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">q.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.q") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\"></td>
    <td align=\"center\" rowspan=\"2\" valign=\"bottom\" width=\"15%\">Total number of children on 2nd-line regimen</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Children on 2nd-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">h.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">r.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.r") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">u.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.u") . "</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Adults and children on 2nd-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">i.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.i") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">s.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.s") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">v.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.v") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"15%\">Total adults and children on 2nd-line regimens</td>
   </tr>
   <tr>
    <td align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"40%\">&nbsp;</td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td colspan=\"2\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
    <td align=\"center\" bgcolor=\"silver\" valign=\"bottom\" width=\"15%\">&nbsp;</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Adults and children on 1st- and 2nd-line regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">j.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.j") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">t.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.t") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">w.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("4.4.w") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"15%\">Total adults and children on 1st- and 2nd-line regimens</td>
   </tr>
  </table>

  <br /><br />

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>5.1 Number of persons who did not pick up their ART regimens</b></td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Male</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Female</td>
    <td colspan=\"2\" rowspan=\"2\" valign=\"bottom\" width=\"15%\"><b>5.2 Of those who did not pick up regimen in last 1 month (optional)</b></td>
    <td colspan=\"2\" rowspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Total number of adults and children</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">1. For last 1 month (only)</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">e.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.e") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">2. For last 2 months (only)</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">f.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.f") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\">1. Lost to follow-up</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.2.a") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">3. For last 3 or more months</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">g.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.g") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\">2. Who died</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.2.b") . "</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"40%\">Subtotal</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">h.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.h") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\">3. Who stopped ART</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.2.c") . "</td>
   </tr>
   <tr>
    <td align=\"center\" colspan=\"3\" valign=\"bottom\" width=\"40%\">Total number of persons who did not pick up their ART regimens</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">i.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.1.i") . "</td>
    <td colspan=\"2\" valign=\"bottom\" width=\"15%\">4. Who transferred out</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("5.2.d") . "</td>
   </tr>
  </table>

  <br /><br />

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td valign=\"bottom\" width=\"40%\"><b>6. Number of personnel trained in HIV care during the month</b></td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Physicians</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Nurses</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Other staff</td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Subtotal</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">1. ART clinical care</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">a.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.a") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">e.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.e") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">i.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.i") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">m.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.m") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">2. Non-ART clinical care</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">b.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.b") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">f.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.f") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">j.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.j") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">n.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.n") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">3. Adherence counseling/support</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">c.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.c") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">g.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.g") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">k.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.k") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">o.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.o") . "</td>
   </tr>
   <tr>
    <td valign=\"bottom\" width=\"40%\">4. Other types of training</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">d.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.d") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">h.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.h") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">l.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.l") . "</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">p.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.p") . "</td>
   </tr>
   <tr>
    <td colspan=\"5\" valign=\"bottom\" width=\"70%\"></td>
    <td colspan=\"2\" align=\"center\" valign=\"bottom\" width=\"15%\">Total personnel trained</td>
    <td align=\"right\" valign=\"bottom\" width=\"7.5%\">q.<td align=\"right\" valign=\"bottom\" width=\"7.5%\">" . reportGen ("6.q") . "</td>
   </tr>
  </table>
  <input type=\"button\" name=\"ret2\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />
 </body>
</html>
";
?>
