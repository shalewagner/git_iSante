<?php
echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Conditions ************************ -->
<!-- *(tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")* -->
<!-- ******************************************************************** -->
";
if ($type == "1" && $version == "1")
	$coHead = $intakeSectLabs1[$lang][15];
else
	$coHead = $conditions_header_1[$lang][0];

// For some reason there are no conditions listed in conditionOrder for
// the intake form.  Presumably, this is because they're the same as for
// the follow-up form (which does have conditions listed in conditionOrder).
// So, if we're on an intake form, use the follow-up form's order.
/*
if ($type == "1") {
  $cond_list = generateConditionListInOrder ($lang,$version,"2");
} else {
  $cond_list = generateConditionListInOrder ($lang,$version,$type);
}
*/
//print_r($GLOBALS['existingData']);

echo "
   <tr>
    <td>
     <table class=\"b_header_nb_nw\" border=\"0\" WIDTH=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	  <tr>
	   <td class=\"s_header\">" . $coHead . "</td>
	  </tr>
	  <tr>
	   <td>
     	<div style=\"overflow: scroll; width:95%; height:1200px\">
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
              <td colspan=\"4\">
               <input tabindex=\"" . ($tabIndex + 1) . "\" id=\"noDiagnosis\" name=\"noDiagnosis\" " . getData ("noDiagnosis", "checkbox") . " type=\"checkbox\" value=\"On\" >" . $conditions_header_1[$lang][1] . "
              </td>
             <tr>
			  <td colspan=\"4\" align=\"left\">
			  	<i>" . $conditions_header_1[$lang][2] . "</i>
			  </td>
			 <tr>
			  <td colspan=\"2\">
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
			  <td colspan=\"2\" >
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"top_line\" >
			   &nbsp;
			  </td>
			 <tr>

			 <!-- category 0 -->
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   <b>" . $conditions_subhead3[$lang][0] . "</b>
         	  </td>
         	 </tr>
         	 ";
         	 $tabIndex +=  1;
         	 // Print all WHO Stage I conditions (group 0)
			 $tbi = conditionRows_1 (0, $tabIndex + 5);
		echo "
			 <tr>
		      <td colspan=\"2\" valign=\"top\">
		       &nbsp;
		      </td>
		      <td colspan=\"2\" valign=\"top\">
		       <b>" . $conditions_subhead3[$lang][1] . "</b>
		      </td>
		     </tr>";

			 // Print all WHO Stage II conditions (group 1)
			$tbi = conditionRows_1 (1, $tbi + 1);
		echo "
			 <tr>
			  <td colspan=\"2\" valign=\"top\">&nbsp;</td>
			  <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead3[$lang][2] . "</b></td>
			 </tr>";

			// Print all WHO Stage III conditions (group 3)
			$tbi = conditionRows_1 (2, $tbi);

		echo "
			 <tr>
			  <td colspan=\"2\" valign=\"top\">&nbsp;</td>
			  <td colspan=\"2\" valign=\"top\"><b>" . $conditions_subhead4[$lang][0] . "</b></td>
			 </tr>
			 ";

			// Print all WHO Stage IV conditions (group 4)
			$tbi = conditionRows_1 (3, $tbi);

		echo "
		    </table>
			<table width=\"100%\">
	          	 <colgroup>
				  <col width=\"5%\">
				  <col width=\"10%\">
				  <col width=\"45%\">
			  	  <col width=\"30%\" align=\"right\">
		  	 </colgroup>
			 <tr>
			  <td colspan=\"2\">
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
 			  <td colspan=\"2\" >
 			   &nbsp;
 			  </td>
 			  <td colspan=\"2\" class=\"top_line\" >
 			   &nbsp;
 			  </td>
			 </tr>
 			 <tr>
			  <td colspan=\"2\" valign=\"top\">&nbsp;</td>
			  <td colspan=\"2\" valign=\"top\"><b>" . $conditions_suit_subhead5_1[$lang][0] . "</b></td>
			 </tr>



			      ";

			// Print last 1 WHO Stage IV (suite) conditions (group 5)
			$tbi = conditionRows_1 (4, $tbi,23,1);

		echo "
 				  <tr>
			       <td colspan=\"2\" valign=\"top\">&nbsp;</td>
			       <td colspan=\"2\" valign=\"top\"><b>" . $conditions_suit_subhead5_1[$lang][5] . "</b></td>
			      </tr>
			      ";

			// Print first 4 Other Diagnostics conditions (group 5)
			$tbi = conditionRows_1 (5, $tbi,1,5);
			// Print 1 Other Diagnostics conditions (group 5)
			$tbi = conditionRows_1 (5, $tbi,6,1);
			//"","&nbsp;&nbsp;<input tabindex=' . $tbi++ . ' name=' . $code . 'Comment[]' . getData ($code . 'Comment', 'checkbox', 2) . ' type='checkbox' value='2'>Type2&nbsp;<input tabindex=' . $tbi++ . ' name=' . $code . 'Comment[]' . getData ($code . 'Comment', 'checkbox', 1) . ' type='checkbox' value='1'>Type1" );
		    // Print 7 Other Diagnostics conditions (group 5)
			$tbi = conditionRows_1 (5, $tbi,7,7);

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
			 <!-- category 5 -->
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   <b>" . $conditions_suit_subhead5_1[$lang][0] . "</b>
         	  </td>
         	 </tr>
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   " . $conditions_suit_subhead5_1[$lang][1] . "
         	  </td>
         	 </tr>
         	 ";

			 $tbi = conditionRows_1 (4, $tabIndex + 1,1,3,'&nbsp;&nbsp;&nbsp;&nbsp;');
			 $tbi = conditionRows_1 (4, $tbi,4,1);
	echo "
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   " . $conditions_suit_subhead5_1[$lang][2] . "
         	  </td>
         	 </tr>
         	 ";

			 $tbi = conditionRows_1 (4, $tbi,5,3,'&nbsp;&nbsp;&nbsp;&nbsp;');
	echo "
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   " . $conditions_suit_subhead5_1[$lang][3] . "
         	  </td>
         	 </tr>
         	 ";

			 $tbi = conditionRows_1 (4, $tbi,8,3,'&nbsp;&nbsp;&nbsp;&nbsp;');
			 $tbi = conditionRows_1 (4, $tbi,11,7);
	echo "
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   " . $conditions_suit_subhead5_1[$lang][4] . "
         	  </td>
         	 </tr>
         	 ";

			 $tbi = conditionRows_1 (4, $tbi,18,4,'&nbsp;&nbsp;&nbsp;&nbsp;');
			 $tbi = conditionRows_1 (4, $tbi,22,1);
	echo "  </table>

			<table width=\"100%\">
			 <tr>
			  <td colspan=\"2\">
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
 			  <td colspan=\"2\" >
 			   &nbsp;
 			  </td>
 			  <td colspan=\"2\" class=\"top_line\" >
 			   &nbsp;
 			  </td>
			 </tr>
			 ";
			 $tbi = conditionRows_1 (5, $tbi,14,4);
	echo "
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   <b>" . $conditions_suit_subhead5_1[$lang][6] . "</b>
         	  </td>
         	 </tr>
         	 ";

			 $tbi = conditionRows_1 (6, $tbi);
	echo "
			 <tr>
			  <td colspan=\"2\">
			   &nbsp;
			  </td>
         	  <td colspan=\"2\">
         	   <b>" . $conditions_suit_subhead5_1[$lang][7] . "</b>
         	  </td>
         	 </tr>
         	 ";

			 $tbi = conditionRows_1 (7, $tbi);
	echo "
       	    </table>
           </td>
          </tr>
         </table>
        </div>



	   </td>
	  </tr>
	  <tr>
	        <td colspan=\"5\" class=\"s_header\">" . $conditions_subhead2_11[$lang][0] . "</td>
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
