<?php


echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Conditions ************************ -->
<!-- *(tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")* -->
<!-- ******************************************************************** -->
";


//forms 24/25 are now using the same condition list.
$swi = false;
if($version == 1 and $type == 25){
	$type = 24;
	$swi = true;
}

if(isset($type)&&$type == 25)
	$coHead = $otherDiagnose_head [$lang][0];
else
    $coHead = $intakeSectLabs1[$lang][15];

/*$cond_list_ver0 = generatePMTCTConditionListInOrder ($lang,$type,0);
$cond_list_ver1 = generatePMTCTConditionListInOrder ($lang,$type,1);
$cond_list = array_merge($cond_list_ver0, $cond_list_ver1);
*/


$cond_list = generatePMTCTConditionListInOrder ($lang,$type,$version);
echo "
   <tr>
    <td>
     <table class=\"b_header_nb_nw\" border=\"0\" WIDTH=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	  <tr>
	   <td class=\"s_header\">" . $coHead . "</td>
	  </tr>
	  <tr>
	   <td>";
// if($type == '24')
echo "<div style=\"overflow: scroll; width:95%; height:600px\">";
//else
//echo "<div style=\"overflow: scroll; width:95%; height:200px\">";
    
echo "
     	 <table id=\"conditionsTable\" border=\"0\" WIDTH=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	 	  <tr>
           <td width=\"49%\">
          	<table width=\"100%\">
          	 <colgroup>
			  <col width=\"5%\">
			  <col width=\"10%\">
			  <col width=\"45%\">
		  	  <col width=\"30%\" align=\"right\">
		  	 </colgroup>
             <tr>
             <tr>
			   <td class=\"sm_header_cnt\">" . $conditions_subhead1[$lang][0] . "</td>
			   <td class=\"sm_header_cnt\"> " . $conditions_subhead1[$lang][1] . "</td>
			   <td class=\"sm_header_lt\">" . $conditions_subhead2[$lang][0] . "</td>
               <td class=\"sm_header_lt\">" . $conditions_subhead2_1[$lang][0] . "</td>
        	 </tr>
        	 <tr>
			  <td colspan=\"2\" >
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"top_line\" >
			   &nbsp;
			  </td>

         	 ";

         	 $tab++;
         	 // Print all WHO Stage I conditions (group 0)

			 if($type == '24')
				$tab = conditionRows_pmtct ($cond_list[0], $tab, 1, 25,$lang);
			 else if($type == '25')
				$tab = conditionRows_pmtct ($cond_list[1], $tab, 1, 8,$lang);
		echo "

       	    </table>
       	   <td valign=\"top\" class=\"vert_line\">
			&nbsp;
		   </td>
		   <td width=\"49%\">

			<table width=\"100%\">
          	 <colgroup>
			  <col width=\"5%\">
			  <col width=\"10%\">
			  <col width=\"45%\">
		  	  <col width=\"30%\" align=\"right\">
		  	 </colgroup>
			 <tr>
			  <td colspan=\"2\" >
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"bottom_line\">
			   &nbsp;
			  </td>
			 </tr><tr>
			   <td class=\"sm_header_cnt\">" . $conditions_subhead1[$lang][0] . "</td>
			   <td class=\"sm_header_cnt\"> " . $conditions_subhead1[$lang][1] . "</td>
			   <td class=\"sm_header_lt\">" . $conditions_subhead2[$lang][0] . "</td>
               <td class=\"sm_header_lt\">" . $conditions_subhead2_1[$lang][0] . "</td>
        	 </tr>
        	 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"top_line\">
			   &nbsp;
			  </td>
			 </tr>


         	 ";
			 if($type == '24')
				$tab = conditionRows_pmtct ($cond_list[0], $tab, 25, 47,$lang);
			 else if($type == '25')
				$tab = conditionRows_pmtct ($cond_list[1], $tab, 8, 14,$lang);
		
	echo "
       	    </table>
           </td>
          </tr>
         </table>
        </div>



	   </td>
	  </tr>

	 </table>
	</td>
   </tr>";


if($swi){
	$type = 24;
}

function conditionRows_pmtct($condList, $tbi = 0, $start = 1, $end, $lang)  
{
   $hepatitisOption = array (
   "en" => array (
        "A",
		"B",
		"C",
		"other:"
		),
   "fr" => array (
        "A",
		"B",
		"C",
		"autre:"
		)
  );

  for($i=$start;$i<$end;$i++)
  {

	if(isset($condList[$i]))
	{
		$ind++;
		$bgColor = ($bgColor == "#FFFFFF") ? "#D8D8D8" : "#FFFFFF";

		$code = $condList[$i]['code'];

		echo "
		  <tr bgcolor=\"$bgColor\">
		   <td align=\"center\" valign=\"top\">
			<table>
				<tr>
					<td id=\"" . $code . "ActiveTitle\"></td><td><input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active1\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 1) . " class=\"conditions\" type=\"checkbox\" value=\"1\"></td>
				</tr>
			</table>
		</td>
		<td align=\"center\" valign=\"top\">
			<input tabindex=\"" . $tbi++ . "\" class=\"conditions\" id=\"" . $code . "Active2\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 2) . " type=\"checkbox\" value=\"2\">
		</td>
		<td id=\"" .$code . "Title\" class=\"small_cnt\">" . $condList[$i][$lang]  ;
		if ($code == "hepatitis")
		{
		   echo "<br />
		    <table width=\"100%\">
			 <tr>
			  <td>
				<input tabindex=\"" . $tbi++ . "\" id=\"hepatitisType1\" name=\"hepatitisType[]\" " . getData ("hepatitisType", "checkbox", "1") . " type=\"checkbox\" class=\"conditions\" value=\"1\"> " .  $hepatitisOption[$lang][0] . "  </td>
			  <td> <input tabindex=\"" . $tbi++ . "\" id=\"hepatitisType2\" name=\"hepatitisType[]\" " . getData ("hepatitisType", "checkbox", "2") . " 
type=\"checkbox\" class=\"conditions\" value=\"2\"> " . $hepatitisOption[$lang][1] . " </td>
			  <td> <input tabindex=\"" . $tbi++ . "\" id=\"hepatitisType4\" name=\"hepatitisType[]\" " . getData ("hepatitisType", "checkbox", "4") . " type=\"checkbox\" 
class=\"conditions\" value=\"4\"> " . $hepatitisOption[$lang][2] . " </td>
			  <td> <input tabindex=\"" . $tbi++ . "\" id=\"hepatitisType8\" name=\"hepatitisType[]\" " . getData ("hepatitisType", "checkbox", "8") . " type=\"checkbox\" 
class=\"conditions\" value=\"8\"> " .  $hepatitisOption[$lang][3] . " <input tabindex=\"" . $tbi++ . "\" id=\"hepatitisOtherComment\" name=\"hepatitisOtherComment\" " . getData ("hepatitisOtherComment", "text") . " type=\"text\" class=\"conditions\" size=\"4\" maxsize=\"255\">
			  </td>
			 </tr>
			</table>";
		}
		else
		{
			if($code == "otherDiagnoses")
			{
				echo "<br /><input tabindex=\"" . $tbi++ . "\" name=\"" . $code . "Comment\" " . getData (  $code . "Comment", "text") . " type=\"text\" class=\"conditions\" size=\"15\" maxlength=\"200\">";
			}
		}		

		echo "</td>
		      <td  valign=\"top\">
			<input tabindex=\"" . $tbi++ .
				"\" id=\"" .$code . "MY\"  name=\"" . $code . "Mm\" " . getData ($code . "Mm", "text") .
				" type=\"text\" class=\"conditions\" size=\"2\" maxlength=\"2\">/
				<input tabindex=\"" . $tbi++ . "\" id=\"" .$code . "YM\" name=\"" . $code . "Yy\" " .
				getData ($code . "Yy", "text") .
				" type=\"text\" class=\"conditions\" size=\"2\" maxlength=\"2\">
			</td>
		  </tr>";
	 }
  }
  return ($tbi);

}
function conditionRow($condList, $tbi = 0, $start = 1, $end, $lang) {
  $ind = 0;
  $bgColor = "#FFFFFF";

  for($i=$start;$i<$end;$i++)
  {

	if(isset($condList[$i]))
	{
		$ind++;
		$bgColor = ($bgColor == "#FFFFFF") ? "#D8D8D8" : "#FFFFFF";

		$code = $condList[$i]['code'];
		

		echo "
		  <tr bgcolor=\"$bgColor\">
		   <td align=\"center\" valign=\"top\"><table><tr><td id=\"" . $code . "ActiveTitle\"></td><td><input tabindex=\"" . $tbi++ . "\" id=\"" . $code . "Active1\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 1) . " class=\"conditions\" type=\"checkbox\" value=\"1\"></td></tr></table></td>
		   <td align=\"center\" valign=\"top\"><input tabindex=\"" . $tbi++ . "\" class=\"conditions\" id=\"" . $code . "Active2\" name=\"" . $code . "Active[]\" " . getData ($code . "Active", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
		   <td id=\"" .$code . "Title\" class=\"small_cnt\">" . $condList[$i][$lang]  ;

		echo "</td>
		      <td  valign=\"top\"><input tabindex=\"" . $tbi++ .
				"\" id=\"" .$code . "MY\"  name=\"" . $code . "Mm\" " . getData ($code . "Mm", "text") .
				" type=\"text\" class=\"conditions\" size=\"2\" maxlength=\"2\">/
				<input tabindex=\"" . $tbi++ . "\" id=\"" .$code . "YM\" name=\"" . $code . "Yy\" " .
				getData ($code . "Yy", "text") .
				" type=\"text\" class=\"conditions\" size=\"2\" maxlength=\"2\"></td>
		  </tr>";
	    $tbi +=5;
	 }
  }
  return ($tbi);
}

?>
