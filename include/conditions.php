<?php

echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Conditions ************************ -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") -->
<!-- ******************************************************************** -->
";

$cond_list = generateConditionList ($lang);

echo "
   <tr>
    <td>
     <table class=\"b_header_nb_nw\" border=\"0\" WIDTH=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
      <colgroup>
       <col width=\"50\">
       <col width=\"50\">
       <col width=\"100\">
       <col width=\"250\">
       <col width=\"150\">
      </colgroup>
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $conditions_header[$lang][2] . "</td>
      </tr>
      <tr>
       <td colspan=\"5\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"5\" align=\"left\"><i>" . $conditions_header[$lang][3] . "</i></td>
      </tr>
      <tr>
       <td class=\"sm_header_cnt\">" . $conditions_subhead1[$lang][0] . "</td>
	   <td class=\"sm_header_cnt\">" . $conditions_subhead1[$lang][1] . "</td>
	   <td class=\"sm_header_cnt\">" . $conditions_subhead1[$lang][2] . "</td>
	   <td class=\"sm_header_lt\">&nbsp;&nbsp;&nbsp;" . $conditions_subhead2[$lang][0] . "</td>
     <td class=\"sm_header_lt\">&nbsp;&nbsp;&nbsp;" . $conditions_subhead2[$lang][1] . "</td>
	  </tr>
      <tr>
       <td colspan=\"5\">
	   <div style=\"overflow: scroll; width:95%; height:200\">
        <TABLE border=\"0\" CELLSPACING=\"0\" CELLPADDING=\"0\">
        <colgroup>
       <col width=\"65\">
       <col width=\"65\">
       <col width=\"100\">
       <col width=\"450\">
       <col width=\"150\" align=\"left\">
		</colgroup>
        <tr>
         <td colspan=\"3\">&nbsp;</td>
         <td colspan=\"2\"><b>" . $conditions_subhead3[$lang][0] . "</b></td>
        </tr>";

// Print all WHO Stage I conditions (group 0)
$tbi = conditionRows (0, $tabIndex + 1);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead3[$lang][1] . "</b></td>
      </tr>";

// Print all WHO Stage II conditions (group 1)
$tbi = conditionRows (1, $tbi + 1);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead3[$lang][2] . "</b></td>
      </tr>";

// Print all WHO Stage III conditions (group 2)
$tbi = conditionRows (2, $tbi);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead4[$lang][0] . "</b></td>
      </tr>
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b><u>" . $conditions_subhead4[$lang][1] . "</u></b></td>
      </tr>";

// Print first 4 WHO Stage IV conditions (group 3)
$tbi = conditionRows (3, $tbi, 1, 4);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b><u>" . $conditions_subhead4[$lang][2] . "</u></b></td>
      </tr>";

// Print next 3 WHO Stage IV conditions (group 3)
$tbi = conditionRows (3, $tbi, 5, 3);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b><u>" . $conditions_subhead5[$lang][0] . "</u></b></td>
      </tr>";

// Print next 4 WHO Stage IV conditions (group 3)
$tbi = conditionRows (3, $tbi, 8, 4);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b><u>" . $conditions_subhead5[$lang][1] . "</u></b></td>
      </tr>";

// Print next 5 WHO Stage IV conditions (group 3)
$tbi = conditionRows (3, $tbi, 12, 5);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b><u>" . $conditions_subhead5[$lang][2] . "</u></b></td>
      </tr>";

// Print next 2 WHO Stage IV conditions (group 3)
$tbi = conditionRows (3, $tbi, 17, 2);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead6[$lang][0] . "</b></td>
      </tr>";

// Print remaining WHO Stage IV conditions (group 3)
$tbi = conditionRows (3, $tbi, 19);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead6[$lang][1] . "</b></td>
      </tr>";

// Print all Other Medical conditions (group 4)
$tbi = conditionRows (4, $tbi);

echo "
      <tr>
       <td colspan=\"3\" valign=\"top\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead6[$lang][2] . "</b></td>
      </tr>";

// Print all Mental Health/Substance Use conditions (group 5)
$tbi = conditionRows (5, $tbi);

echo "
       </TABLE>
      </div>
      </td>
      </tr>
      <tr>
      <td colspan=\"5\" class=\"sm_header_lt_pd_top\">" . $conditions_subhead2[$lang][2] . "</td>
      </tr>
      <tr>
      <td colspan=\"5\">
        <textarea tabindex=\"" . ($tabIndex + 318) . "\"
          name=\"conditionComments\" rows=\"5\" cols=\"100\">" .
          getData ("conditionComments", "textarea") . "</textarea></td>
      </tr>
      <tr>
        <td colspan=\"5\">&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>

";
?>
