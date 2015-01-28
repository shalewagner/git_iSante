<?php

$imms_list = generatePedImmunizationList ($lang, $encType, $version);
//print_r ($imms_list);
foreach ($imms_list as $imm) {
  if (!empty ($followup) && $followup === 1) {
    echo "
      <tr>
       <td width=\"45%\"><table><tr><td id=\"" . $imm['code'] . "Given1Title\"></td><td><input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . "Given1\" name=\"" . $imm['code'] . "Given1\" " . getData ($imm['code'] . "Given1", "checkbox") . " type=\"checkbox\" value=\"On\">"

      . $imm['label'];

    if ($imm['code'] == 'immunOther') {
      echo "
       <td><input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" name=\"immunOtherText\" " . getData ("immunOtherText", "text") . " type=\"text\" size=\"15\" maxlength=\"64\"></td>";
    }

    echo "</td></tr></table></td>
       <td><table><tr><td id=\"" . $imm['code'] . "Doses1Title\">&nbsp;</td><td><input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . "Doses1\" name=\"" . $imm['code'] . "Doses1\" " . getData ($imm['code'] . "Doses1", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td><td id=\"" . $imm['code'] . "DtTitle\">&nbsp;</td></tr></table></td>

       <td>
        <input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . "Dt\" name=\"" . $imm['code'] . "Dt\" value=\"" . getData ($imm['code'] . "Dd1", "textarea") . "/" . getData ($imm['code'] . "Mm1", "textarea") . "/" .getData ($imm['code'] . "Yy1", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . "Dd\" name=\"" . $imm['code'] . "Dd1\" " . getData ($imm['code'] . "Dd1", "text") . " type=\"hidden\">
       	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . "Mm\" name=\"" . $imm['code'] . "Mm1\" " . getData ($imm['code'] . "Mm1", "text") . " type=\"hidden\">
       	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . "Yy\" name=\"" . $imm['code'] . "Yy1\" " . getData ($imm['code'] . "Yy1", "text") . " type=\"hidden\">
       </td>
      </tr>
";
  } else {
    echo "
      <tr>
       <td width=\"25%\">" . $imm['label'] . "</td>
";
    if (strpos ($imm['code'], "immunOther") === 0) {
      echo "
       <td width=\"25%\"><input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" name=\"immunOtherText\" " . getData ("immunOtherText", "text") . " type=\"text\" size=\"30\" maxlength=\"64\"></td>
";

      for ($i = 1; $i <= 2; $i++) {
        if ($i <= $imm['cnt']) {
          echo "
       <td ";
          if ($i == 1 && $imm['cnt'] == 1)
          	echo " colspan=\"2\" width=\"50%\">";
          else
          	echo " width=\"25%\">";

          echo "
            <table><tr><td id=\"". $imm['code'] .$i . "DtTitle\">". $i . "</td><td>
 			<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Dt\" name=\"" . $imm['code'] .$i . "Dt\"  value=\"" . getData ($imm['code'] . "Dd" . $i , "textarea") . "/" . getData ($imm['code'] . "Mm" . $i, "textarea") . "/" .getData ($imm['code'] . "Yy" . $i, "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
        	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Dd\" name=\"" . $imm['code'] . "Dd" . $i . "\" " . getData ($imm['code'] . "Dd". $i , "text") . " type=\"hidden\">
        	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Mm\" name=\"" . $imm['code'] . "Mm" . $i . "\" " . getData ($imm['code'] . "Mm". $i , "text") . " type=\"hidden\">
       		<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Yy\" name=\"" . $imm['code'] . "Yy" . $i . "\" " . getData ($imm['code'] . "Yy". $i , "text") . " type=\"hidden\">
       		</td></tr></table>
";
        }
      }

      echo "
      </tr>
";
    } else {
      for ($i = 1; $i <= 3; $i++) {
        if ($i <= $imm['cnt']) {
          echo "
      <td ";

          if ($i == 1 && $imm['cnt'] == 1) echo " colspan=\"3\" width=\"75%\">";
          else if ($i == 2 && $imm['cnt'] == 2) echo " colspan=\"2\" width=\"50%\">";
          else echo " width=\"25%\">";

          echo "
            <table><tr><td id=\"". $imm['code'] .$i . "DtTitle\">". $i . "</td><td>
			<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Dt\" name=\"" . $imm['code'] .$i . "Dt\"  value=\"" . getData ($imm['code'] . "Dd" . $i , "textarea") . "/" . getData ($imm['code'] . "Mm" . $i, "textarea") . "/" .getData ($imm['code'] . "Yy" . $i, "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
        	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Dd\" name=\"" . $imm['code'] . "Dd" . $i . "\" " . getData ($imm['code'] . "Dd". $i , "text") . " type=\"hidden\">
        	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Mm\" name=\"" . $imm['code'] . "Mm" . $i . "\" " . getData ($imm['code'] . "Mm". $i , "text") . " type=\"hidden\">
       		<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Yy\" name=\"" . $imm['code'] . "Yy" . $i . "\" " . getData ($imm['code'] . "Yy". $i , "text") . " type=\"hidden\">
			</td></tr></table>
";
        }
      }

      echo "
      </tr>
";

      if ($imm['cnt'] >= 4) {
        echo "
      <tr>
       <td width=\"25%\">&nbsp;</td>
";

        for ($i = 4; $i <= 6; $i++) {
          if ($i <= $imm['cnt']) {
            echo "
       <td ";

            if ($i == 4 && $imm['cnt'] == 4) echo " colspan=\"3\" width=\"75%\">";
            else if ($i == 5 && $imm['cnt'] == 5) echo " colspan=\"2\" width=\"50%\">";
            else echo " width=\"25%\">";

            echo "
            <table><tr><td id=\"". $imm['code'] .$i . "DtTitle\">". $i . "</td><td>
			<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Dt\" name=\"" . $imm['code'] .$i . "Dt\"  value=\"" . getData ($imm['code'] . "Dd" . $i , "textarea") . "/" . getData ($imm['code'] . "Mm" . $i , "textarea") . "/" .getData ($imm['code'] . "Yy" . $i, "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
        	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Dd\" name=\"" . $imm['code'] . "Dd" . $i . "\" " . getData ($imm['code'] . "Dd". $i , "text") . " type=\"hidden\">
        	<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Mm\" name=\"" . $imm['code'] . "Mm" . $i . "\" " . getData ($imm['code'] . "Mm". $i , "text") . " type=\"hidden\">
       		<input class=\"pedImmVacc\" tabindex=\"" . $tabIndex++ . "\" id=\"" . $imm['code'] . $i ."Yy\" name=\"" . $imm['code'] . "Yy" . $i . "\" " . getData ($imm['code'] . "Yy". $i , "text") . " type=\"hidden\">
		    </td></tr></table>
";
          }
        }

        echo "
      </tr>
";
      }
    }
  }
}

?>
