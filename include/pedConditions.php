<?php

echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Conditions ************************ -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") -->
<!-- ******************************************************************** -->
";

$cond_list = generatePedConditionList ($lang);
//print_r($GLOBALS['existingData']);

echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb_nw\" border=\"0\" WIDTH=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	  <tr>
	   <td class=\"s_header\">" . $pedCond[$lang][0] . "</td>
	  </tr>
	  <tr>
	   <td>
     	<div style=\"overflow: scroll; width:95%; height:100%\">
     	 <table border=\"0\" WIDTH=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	 	  <tr>
           <td valign=\"top\" width=\"50%\">
          	<table width=\"100%\">
          	 <colgroup>
			  <col width=\"5%\">
			  <col width=\"10%\">
			  <col width=\"5%\">
			  <col width=\"50%\">
		  	  <col width=\"30%\" align=\"right\">
		  	 </colgroup>
             <tr>
              <td colspan=\"5\">
               <input tabindex=\"" . ($tabIndex + 1) . "\" id=\"noDiagnosis\" name=\"noDiagnosis\" " . getData ("noDiagnosis", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedCond[$lang][1] . "
              </td>
             <tr>
			  <td colspan=\"5\" align=\"left\">
			  	<i>" . $pedCond[$lang][2] . "</i>
			  </td>
			 <tr>
			  <td colspan=\"3\">
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"bottom_line\">
			   &nbsp;
			  </td>
			 </tr>
			 <tr>
			   <td class=\"sm_header_cnt\">" . $pedCond[$lang][3] . "</td>
			   <td class=\"sm_header_cnt\"> " . $pedCond[$lang][4] . "</td>
			   <td class=\"sm_header_cnt\"> " . $pedCond[$lang][5] . "</td>
			   <td class=\"sm_header_lt\">" . $pedCond[$lang][6] . "</td>
               <td class=\"sm_header_lt\">" . $pedCond[$lang][7] . "</td>
        	 </tr>
        	 <tr>
			  <td colspan=\"3\" >
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"top_line\" >
			   &nbsp;
			  </td>
			 </tr>

			 <tr>
		      <td colspan=\"3\" valign=\"top\">
		       &nbsp;
		      </td>
		      <td colspan=\"2\" valign=\"top\">
		       <b>" . $pedCond[$lang][8] . "</b>
		      </td>
		     </tr>";

         	 // Print first column (first 23 rows)
			 $tbi = pedConditionRows ($tabIndex + 2, 1, 24, 10);
		echo "
       	    </table>
       	   <td valign=\"bottom\" class=\"vert_line\" width=\"1%\">
			&nbsp;
		   </td>
		   <td valign=\"top\" width=\"49%\">
          	<table width=\"100%\">
          	 <colgroup>
			  <col width=\"5%\">
			  <col width=\"10%\">
			  <col width=\"5%\">
			  <col width=\"50%\">
		  	  <col width=\"30%\" align=\"right\">
		  	 </colgroup>
			 <tr>
			  <td colspan=\"3\">
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"bottom_line\">
			   &nbsp;
			  </td>
			 </tr>
			 <tr>
			   <td class=\"sm_header_cnt\">" . $pedCond[$lang][3] . "</td>
			   <td class=\"sm_header_cnt\"> " . $pedCond[$lang][4] . "</td>
			   <td class=\"sm_header_cnt\"> " . $pedCond[$lang][5] . "</td>
			   <td class=\"sm_header_lt\">" . $pedCond[$lang][6] . "</td>
               <td class=\"sm_header_lt\">" . $pedCond[$lang][7] . "</td>
        	 </tr>
        	 <tr>
			  <td colspan=\"3\" >
			   &nbsp;
			  </td>
			  <td colspan=\"2\" class=\"top_line\" >
			   &nbsp;
			  </td>
			 </tr>

			 <tr>
		      <td colspan=\"3\" valign=\"top\">
		       &nbsp;
		      </td>
		      <td colspan=\"2\" valign=\"top\">
		       <b>" . $pedCond[$lang][11] . "</b>
		      </td>
		     </tr>";

         	 // Print second column
			 $tbi = pedConditionRows ($tbi + 1, 25, 28, 13);
		echo "
       	    </table>
           </td>
          </tr>
         </table>
        </div>



	   </td>
	  </tr>
	  <tr>
	        <td colspan=\"5\" class=\"s_header\">" . $pedCond[$lang][13] . "</td>
	        </tr>
	        <tr>
	        <td  colspan=\"5\">
	          <textarea tabindex=\"" . ($tbi + 1) . "\"
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
