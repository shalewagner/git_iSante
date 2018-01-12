<?
require_once 'backend/config.php';
require 'include/notificationBar.php';
?>

<script type="text/javascript">
    window.name = 'mainWindow';
</script>
<?php
echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\" />
<input type=\"hidden\" name=\"site\" value=\"$site\" />
<input type=\"hidden\" name=\"lastPid\" value=\"$lastPid\" />";
?>

<?php
// Checks to see if this is test version. If yes, displays
// alert at top of page that system is not for production.
if (preg_match('/test/', APP_VERSION) > 0) {
    echo "<div class='top-alert'>";
    echo $topAlert[$lang][0] . APP_VERSION . $topAlert[$lang][1];
    echo "</div>";
} elseif (preg_match('/demo/', APP_VERSION) > 0) {
    echo "<div class='top-alert demo'>";
    echo $topAlert[$lang][2];
    echo "</div>";
}
?>
<?php /* z-index added banner to fix bug in IE7 - menu dropdown was hidden */ ?>
<div id="banner" style="z-index: 1">
    <table class="header" id="top">
        <tr>
            <td id="top_title" rowspan="2">
                <?php
                echo "<a href=\"./splash.php?noid=false&lang=$lang&site=$site\"><img src=\"images/isante_logo.png\"></a>
                <div id=\"app_version\">" . APP_VERSION . "</div>\n";
                ?>
            </td>
            <td id="top_menu">
                <div>
                    <?php
                    echo $bannerSite[$lang] . $colon[$lang][0];
                    $sites = getSiteAccess($user);
                    switch (count($sites)) {
                        case 0:
                            echo $noSiteAssigned[$lang] . "<input type=\"hidden\" name=\"siteCode\" />";
                            break;
                        case 1:
                            // if sizeof $sites = 1, then use readonly text field, else--use select widget
                            //echo $sites[0]['siteCode'] . " - ";
                            echo ($lang == "en") ? $sites[0]['siteName'] : $sites[0]['siteNameFr'];
                            echo " - " . getCommune($sites[0]['siteCode']);
                            echo "<input type=\"hidden\" name=\"siteCode\" value=\"" . $sites[0]['siteCode'] . "\" />";
                            break;
                        default:
                            echo " <select class=\"banner\" onchange=\"setParam('site',this.options[this.selectedIndex].value)\" name=\"siteCode\">";
                            foreach ($sites as $row) {
                                if ($row['hasAccess']) {
                                    echo "<option class=\"banner\" value=\"" . $row['siteCode'] . "\"";
                                    if ($row['siteCode'] == $site)
                                        echo " selected";
                                    echo ">";
                                    echo ($lang == "en") ? $row['siteName'] : $row['siteNameFr'];
                                    echo " - " . getCommune($row['siteCode']);
                                }
                            }
                            echo "</select>";
                    }
                    echo ' | <a class="menu_action" href="ldap/edit.php?id=' . $user . '&lang='
                    . $lang . '&passFlag=true&site=' . $site . '&lastPid=' . $lastPid . '"'
                    . ">$user [" . $access_labels['privLabels'][$lang][$userAccessLevel + 1] . "]</a> | <a class=\"menu_action\" href=";
                    $uri = $_SERVER['REQUEST_URI'];
                    if ($lang == "fr") {
                        if (preg_match("/lang=/", $uri)) {
                            echo str_replace("lang=fr", "lang=en", $uri) . '>';
                        } else {
                            echo $uri . "?lang=en>";
                        }
                        echo "English";
                    } else {
                        if (preg_match("/lang=/", $uri)) {
                            echo str_replace("lang=en", "lang=fr", $uri) . '>';
                        } else {
                            echo $uri . "?lang=fr>";
                        }
                        echo "Fran&ccedil;ais";
                    }
                    echo "</a> | ";
                    $menu = array("en" => "Unspecified", "fr" => "G&eacute;n&eacute;ral");
                    $subject = $errorType[$lang][0] . $menu[$lang];
                    $linkText = $bugLabels[$lang][0];
                    echo "<a class=\"menu_action\" href=\"#\" onclick=\"bugPopUp('$subject','$lang','" . getSessionUser() . "')\">" . $linkText . "</a> | ";
                    $mess = array("en" => "Please close your browser to disconnect", "fr" => "Veuillez fermer votre navigateur pour d&eacute;connecter");
                    echo "<a class=\"menu_action\" href=\"#\" onclick=\"javascript:alert('" . $mess[$lang] . "')\">$bannerLogout[$lang]</a>\n";
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td id="main-menu-area">
                <div>
                    <ul class="main-menu" style="z-index: 9989">

<?php
// Begin main menu items
// Overview
echo "<li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\" id=\"" . $topLabelsId[0] . "\">" . $topLabels[$lang][0] . " <b class=\"caret\"></b></a>
    <ul class=\"dropdown-menu\">
        <li><a id=\"" . $cmdList[0] . "\" href=\"./splash.php?noid=false&" . $menustring . "\">" . $cmdLabel[$lang][0] . "</a></li>
        ";
    if (SERVER_ROLE != "consolidated") {
        echo "<li><a id=\"" . $cmdList[1] . "\" href=\"https://isante.ugp.ht/consolidatedId/isante/splash.php?lang=$lang\" target=\"_blank\">" . $cmdLabel[$lang][1] . "</a></li>";
    }
    echo "
    </ul>
</li>";

// Patients
// PHP to check whether IE (for fingerprint scanning). Could (should?) be done with javascript? Need be able to tell if scanner is available.
$ub = '';
if (preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Trident/i', $_SERVER['HTTP_USER_AGENT'])) {
    $ub = "ie";
}
// Check whether fingerprintURL is not null. FIXME: Doesn't necessarily mean that it's working properly & software is installed.
$fingerprintStatusUI = false;
if (getConfig('fingerprintURL') != Null) {
    $fingerprintStatusUI = true;
}
echo "
<li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\" id=\"" . $topLabelsId[1] . "\">" . $topLabels[$lang][1] . "  <b class=\"caret\"></b></a>
    <ul class=\"dropdown-menu\">
        ";
    if ($ub == "ie" && ($fingerprintStatusUI == true)) {
        echo "<li><a id=\"" . $cmdList[31] . "\" href=\"fingerprint/getFingerprintID.php?" . $menustring . "\">" . $cmdLabel[$lang][31] . "</a></li>";
    } else {
        echo "<li><span id=\"" . $cmdList[31] . "\" class=\"menudisable\" title=\"" . $noFingerprintMessage[$lang] . "\">" . $cmdLabel[$lang][31] . "</span></li>";
    }
    echo "
        <li><a id=\"" . $cmdList[2] . "\" href=\"./find.php?" . $menustring . "\">" . $cmdLabel[$lang][2] . "</a></li>";
    if (SERVER_ROLE == "consolidated") {
        echo "
        <li><span id=\"" . $cmdList[3] . "\" class=\"menudisable\">" . $cmdLabel[$lang][3] . "</span></li>
        <li><span id=\"" . $cmdList[4] . "\" class=\"menudisable\">" . $cmdLabel[$lang][4] . "</span></li>
        <li><span id=\"" . $cmdList[27] . "\" class=\"menudisable\">" . $cmdLabel[$lang][27] . "</span></li>
        ";
    } else {
        echo "
        <li><a id=\"" . $cmdList[3] . "\" href=\"./register.php?type=10&version=1&" . $menustring . "\">" . $cmdLabel[$lang][3] . "</a></li>
        <li><a id=\"" . $cmdList[4] . "\" href=\"./register.php?type=15&version=0&" . $menustring . "\">" . $cmdLabel[$lang][4] . "</a></li>
        <li><a id=\"" . $cmdList[27] . "\" href=\"./findGlobal.php?" . $menustring . "\">" . $cmdLabel[$lang][27] . "</a></li>";
    }
    if (empty($lastPid) || $lastPid == "") {
        echo "
        <li><span id=\"" . $cmdList[5] . "\" class=\"menudisable\" title=\"" . $noCurrentPatient[$lang] . "\">" . $cmdLabel[$lang][5] . "</span></li>";
        //echo "<li><span id=\"" . $cmdList[41] . "\" class=\"menudisable\" title=\"" . $noCurrentPatient[$lang] . "\">" . $cmdLabel[$lang][41] . "</span></li>";
        if ($userAccessLevel >= ADMIN && SERVER_ROLE == "production") {
            echo "<li><span id=\"" . $cmdList[6] . "\" class=\"menudisable\" title=\"" . $noCurrentPatient[$lang] . "\">" . $cmdLabel[$lang][6] . "</span></li>";
        }
    } else {
        echo "
        <li><a id=\"" . $cmdList[5] . "\" href=\"./patienttabs.php?pid=$lastPid&" . $menustring . "\">" . $cmdLabel[$lang][5] . "</a></li>";
        if ($userAccessLevel >= ADMIN && SERVER_ROLE == "production") {
            echo "<li><a id=\"" . $cmdList[6] . "\" href=\"./adminPat.php?pid=$lastPid&" . $menustring . "\">" . $cmdLabel[$lang][6] . "</a></li>";
        }
    }
    echo "
    </ul>
</li>\n";

// Reports
echo "<li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\" id=\"" . $topLabelsId[3] . "\">" . $topLabels[$lang][3] . " <b class=\"caret\"></b></a>
    <ul class=\"dropdown-menu\">";
        if (HIV_AUTH) {
            echo "
        <li><a id=\"" . $cmdList[9] . "\" href=\"./kickPoint.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "repNum=1591&patientStatus=62&treatmentStatus=1&testType=0&groupLevel=1&otherLevel=1&start=0&end=0&pid=&ddValue=0&" . $menustring . "\">" . $cmdLabel[$lang][9] . "</a></li>";
        }
        echo "
        <li><a id=\"" . $cmdList[10] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=qualityCare&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][10] . "</a></li>
        <li><a id=\"" . $cmdList[11] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=aggregatePop&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][11] . "</a></li>";

        if (PC_AUTH) {
            echo "
        <li><a id=\"" . $cmdList[29] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=primaryCare&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][29] . "</a></li>";
        }
        echo "
        <li><span class=\"submenu-head\" id=\"indicators\">Tableaux de bord" . $colon[$lang][0] . "</span>
            <ul>
		<li><a class=\"submenu-item\" id=\"" . $cmdList[37] . "\" href=\"./reports-generator.php?rpt=malaria&" . $menustring . "\">" . $cmdLabel[$lang][37] . "</a></li>
		<li><a class=\"submenu-item\" id=\"" . $cmdList[39] . "\" href=\"./reports-generator.php?rpt=nutrition&" . $menustring . "\">" . $cmdLabel[$lang][39] . "</a></li>
		<li><a class=\"submenu-item\" id=\"" . $cmdList[40] . "\" href=\"./reports-generator.php?rpt=tb&" . $menustring . "\">" . $cmdLabel[$lang][40] . "</a></li>
		<li><a class=\"submenu-item\" id=\"" . $cmdList[41] . "\" href=\"./reports-generator.php?rpt=obgyn&" . $menustring . "\">" . $cmdLabel[$lang][43] . "</a></li>
		<li><a class=\"submenu-item\" id=\"" . $cmdList[42] . "\" href=\"./reports-generator.php?rpt=dataquality&" . $menustring . "\">" . $cmdLabel[$lang][44] . "</a></li>"; 
	if (getConfig('serverRole') == 'consolidated') {
		echo "
		<li><a class=\"submenu-item\" id=\"" . $cmdList[43] . "\" href=\"./reports-generator.php?rpt=mer&" . $menustring . "\">" . $cmdLabel[$lang][45] . "</a></li>";
	}
	echo "
           </ul>
        </li>";
        if (OB_AUTH) {
            echo "
        <li><span class=\"submenu-head\" id=\"" . $cmdList[30] . "\">" . $cmdLabel[$lang][30] . $colon[$lang][0] . "</span>
            <ul>
                <li><a class=\"submenu-item\" id=\"" . $cmdList[32] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=obGynPmtct&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][32] . "</a></li>
                <li><a class=\"submenu-item\" id=\"" . $cmdList[33] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=obGynAntenatal&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][33] . "</a></li>
                <li><a class=\"submenu-item\" id=\"" . $cmdList[34] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=obGynDelivery&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][34] . "</a></li>
                <li><a class=\"submenu-item\" id=\"" . $cmdList[35] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=obGynPostnatal&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][35] . "</a></li>
                <li><a class=\"submenu-item\" id=\"" . $cmdList[36] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=obGynOther&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][36] . "</a></li>
            </ul>
        </li>";
        }
        echo "
        <li><a id=\"" . $cmdList[12] . "\" href=\"./reports.php?" . ($noidFromGet == "true" ? "noid=true&" : "") . "rtype=dataQuality&testType=0&" . $menustring . "\">" . $cmdLabel[$lang][12] . "</a></li>
    </ul>
</li>\n";

// Administration
if ($userAccessLevel >= ADMIN) {
echo '
	<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" id="' . $topLabelsId[5] . '">' . $topLabels[$lang][5] . '<b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><a id="' . $cmdList[28] . '" href="./LDAPform.php?id=' . $user . '&' . $menustring . '">' . $cmdLabel[$lang][28] . '</a></li>';
            // next menuitem should only appear in the iSanté instance that is running on the Haiti national identified server
            if ((isset($_SERVER['HTTP_X_FORWARDED_HOST']) && NATIONAL_IDENTIFIED_SERVER === $_SERVER['HTTP_X_FORWARDED_HOST'] . '/consolidatedId/isante') || (SERVER_ROLE === 'test' && $_SERVER['SERVER_NAME'] === 'haiti-dev.cirg.washington.edu' && DB_NAME === 'itech'))
                echo '
        <li><a id="' . $cmdList[15] . '" href="./maintainSites.php?id=$user&' . $menustring . '">' . _('Entretien des cliniques de iSanté') . '</a></li>';
            echo '
        <li><a id="' . $cmdList[16] . '" href="./config.php?' . $menustring . '">' . $cmdLabel[$lang][16] . '</a></li> 
        <li><a id="' . $cmdList[38] . '" href="./listEncounterStatus.php?' . $menustring . '">' . $cmdLabel[$lang][38] . '</a></li>';
        if ($userAccessLevel > 2) {
                echo '<li><a id="' . $cmdList[17] . '" href="./adhocSetup.php?rtype=adhoc&testType=0&' . $menustring . '">' . $cmdLabel[$lang][17] . '</a></li>';
        }
$viralLoadLabel = ($lang == 'fr') ? 'Rapport pour les commandes de charge virale':'Report For Viral Load Orders';
$viralLoadURL = 'kickPoint.php?rtype=aggregatePop&reportNumber=778&lang=' . $lang . '&site=' . $site . '&patientStatus=0&treatmentStatus=0&testType=0&groupLevel=0&otherLevel=0&menu=dateSelect';
$saveViralResultsLabel = ($lang == 'fr') ? 'Enregistrer les résultats viraux':'Load Viral Results';
echo '
        <li><a id="barcodeReport" href="' . $viralLoadURL . '">' . $viralLoadLabel . '</a></li>
        <li><a id="loadViral" href="./loadViral.php">' . $saveViralResultsLabel . '</a></li>
    </ul>
</li>';
}

// Help 
$newIn = ($lang == 'en') ? 'New in ':'Nouveau dans la ';
echo '
<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" id="' . $topLabelsId[6] . '">' . $topLabels[$lang][6] . ' <b class="caret"></b></a>
<ul class="dropdown-menu">
	<li><a id="' . $cmdList[19] . '" href="./helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20de%20d%e9finition%20EMR&' . $menustring . '">' . $cmdLabel[$lang][19] . '</a></li>
	<li><a id="18.1"  href="helpfiles/ChangeDocument18.1' . $lang . '.pdf" target="_blank">' . $newIn . '18.1' .    '</a></li>
	<li><a id="17.3"  href="helpfiles/ChangeDocument17.3' . $lang . '.pdf" target="_blank">' . $newIn . '17.3' .    '</a></li>
	<li><a id="17.2"  href="helpfiles/ChangeDocument17.2' . $lang . '.pdf" target="_blank">' . $newIn . '17.2' .    '</a></li>
	<li><a id="17.1"  href="helpfiles/ChangeDocument17.1' . $lang . '.pdf" target="_blank">' . $newIn . '17.1' .    '</a></li>
	<li><a id="16.2"  href="helpfiles/ChangeDocument16.2' . $lang . '.pdf" target="_blank">' . $newIn . '16.2' .    '</a></li>
	<li><a id="16.1"  href="helpfiles/ChangeDocument16.1' . $lang . '.pdf" target="_blank">' . $newIn . '16.1' .    '</a></li>
	<li><a id="' . $cmdList[26] . '" href="helpfiles/recordsRequestUserGuide' . $lang . '.docx" target="_blank">' . $cmdLabel[$lang][26] . '</a></li>
	<li><a id="' . $cmdList[21] . '" href="./helpfile.php?file=reportFAQ&titleen=Frequently%20Asked%20Questions&titlefr=Questions%20Fréquemment%20Posées&' . $menustring . '">' . $cmdLabel[$lang][21] . '</a></li>
</ul>
</li>
';
// End main menu items
echo '<li><span id="searchbox"></span></li>';
?>
                    </ul>
                </div>
            </td>
        </tr>
    </table>
</div>
<!-- End id="banner" -->
