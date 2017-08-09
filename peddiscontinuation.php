<?php
$encType = 21;
echo "
<!-- ******************************************************************** -->
<!-- ********************** Discontinue Treatment  ********************** -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->
 <table class=\"header\">
      <tr>
          <td  colspan=\"2\" width=\"100%\">" . $partStop_2_0[$lang][0] . "
      			</td>

	  <tr>
	  			<td>
				    <span><input tabindex=\"2003\" name=\"partStop[]\" " . getData ("partStop", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $partStop_2_0[$lang][1] . "</span>

                </td>
      </tr>
      <tr>
	  	      	<td>
	  				<span><input tabindex=\"2007\" name=\"partStop[]\" " . getData ("partStop", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $partStop_2_0[$lang][2] . "</span>
	            </td>
	  </tr>


	  <tr>
	        		<td colspan=\"2\" width=\"100%\">&nbsp;
	              </td>
      </tr>


	  <tr>
				 <td colspan=\"2\" width=\"100%\">" . $everOn_2[$lang][0] . "</td>

			 </tr>
			 <tr>
				  <td colspan =\"2\" width=\"100%\">
					   <span ><input tabindex=\"2001\" name=\"everOn[]\" " . getData ("everOn", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $everOn_2[$lang][1] . "</span>
				  </td>

	  </tr>
	  <tr>
		  <td colspan=\"2\" width=\"100%\">
			   <span ><input tabindex=\"2002\" name=\"everOn[]\" " . getData ("everOn", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $everOn_2[$lang][2] . "</span>
		  </td>

      </tr>
      <tr>
	  	        		<td colspan=\"2\" width=\"100%\">&nbsp;
	  	              </td>
      </tr>
      <tr>

	  	  	  		<td id=\"disEnrollDtTitle\" width=\"50%\">
						  	                 " . $discEnrollDd_1[$lang][0] . "
					</td>
					<td class=\"left_pad\">
						<table>
							<tr>
								<td>
									<input type=\"text\"   tabindex=\"2010\" size=\"8\" id=\"disEnrollDt\" name=\"disEnrollDt\" value=\"" . getData ("disEnrollDd", "textarea") . "/". getData ("disEnrollMm", "textarea") ."/". getData ("disEnrollYy", "textarea") . "\">
									<input type=\"hidden\" 				     id=\"disEnrollDd\" name=\"disEnrollDd\" " . getData ("disEnrollDd", "text") . ">
									<input type=\"hidden\" tabindex=\"2011\" id=\"disEnrollMm\" name=\"disEnrollMm\" " . getData ("disEnrollMm", "text") . ">
									<input type=\"hidden\" tabindex=\"2012\" id=\"disEnrollYy\" name=\"disEnrollYy\" " . getData ("disEnrollYy", "text") . ">
								</td>
								<td>
									<i>" . $discEnrollYy[$lang][2] . "</i>
								</td>
							</tr>
						 </table>
	  	  		</td>
	     	  </tr>

	  	  <tr>
		<td id=\"lastContactD1Title\" width=\"50%\">
	                  " . $lastContactDd_1[$lang][0] . "
	            </td>

	  	        <td class=\"left_pad\">
	  	        	<table>
	  	        		<tr>
	  	        			<td>
					<input type=\"text\"   tabindex=\"2020\" size=\"8\" id=\"lastContactD1\" name=\"lastContactDt\" value=\"" . getData ("lastContactDd", "textarea") . "/". getData ("lastContactMm", "textarea") ."/". getData ("lastContactYy", "textarea") . "\">
					<input type=\"hidden\" 				     id=\"lastContactDd\" name=\"lastContactDd\" " . getData ("lastContactDd", "text") . ">
					<input type=\"hidden\" tabindex=\"2021\" id=\"lastContactMm\" name=\"lastContactMm\" " . getData ("lastContactMm", "text") . ">
					<input type=\"hidden\" tabindex=\"2022\" id=\"lastContactYy\" name=\"lastContactYy\" " . getData ("lastContactYy", "text") . ">
	  		    </td>
	  		    <td>
	  		     	<i>" . $lastContactYy[$lang][2] . "</i> &nbsp;&nbsp;". $timeUnknownUse[$lang][0] . "
	  		    </td>
			  </tr>
			 </table>
			</td>

	  </tr>
	 </table>

";

echo "
<!-- ******************************************************************** -->
<!-- ********************** Discontinue Enrollment ********************** -->
<!-- ******************** (tab indices 3001 - 4000) ********************* -->
<!-- ******************************************************************** -->
";

echo "

  <table class=\"header\">
  	<tr>
         			<td class=\"s_header\" colspan=\"4\">". $reasonUnknown_header[$lang][0] ."
         			</td>
      </tr>
     <tr>
        <td colspan=\"4\" width=\"100%\">
     	    <input tabindex=\"3101\" id=\"reasonDiscNoFollowup\" name=\"reasonDiscNoFollowup\" " . getData ("reasonDiscNoFollowup", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscNoFollowup_1[$lang][1] . "
        </td>
     </tr>
     <tr>
        <td width=\"5%\">&nbsp;</td>
        <td colspan=\"3\" width=\"95%\">" .
	        $min3homeVisits_1[$lang][0] . "
        </td>
     </tr>
     <tr>
     	<td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     		<span><input tabindex=\"3102\" name=\"min3homeVisits[]\" " . getData ("min3homeVisits", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $min3homeVisits_1[$lang][1] . " <input tabindex=\"3103\" name=\"min3homeVisits[]\" " . getData ("min3homeVisits", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $min3homeVisits_1[$lang][2] . " <input tabindex=\"3104\" name=\"min3homeVisits[]\" " . getData ("min3homeVisits", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $min3homeVisits_1[$lang][3] . "</span>
     	</td>
     </tr>
     <tr>
         <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">" .
             $min3homeVisitsText_1[$lang][1] . "&nbsp; <input tabindex=\"3105\" name=\"min3homeVisitsText\" " . getData ("min3homeVisitsText", "text") . " type=\"text\" size=\"82\" maxlength=\"255\">
         </td>
     </tr>
	";
		$transferDisabled = "disabled";
		//if (getAccessLevel(getSessionUser()) == 3) 
			$transferDisabled = "";
	   echo "
     <tr>
         <td colspan=\"4\" width=\"100%\"><input tabindex=\"3201\" id=\"reasonDiscTransfer\" name=\"reasonDiscTransfer\" " . getData ("reasonDiscTransfer", "checkbox") . " type=\"checkbox\" value=\"On\" " . $transferDisabled . " /> " .
   	         $transferClinics_1_0[$lang][0] . "
         </td>
     </tr>
     <tr>
     	 <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">" .
   	          " <span ><input tabindex=\"3204\" name=\"reasonDiscRef[]\" " . getData ("reasonDiscRef", "checkbox", 1) . " type=\"radio\" value=\"1\" " . $transferDisabled . " /> " . $transferClinics_1_0[$lang][1] . "</span>
         </td>
     </tr>
     <tr>
	     <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">
     		<span ><input tabindex=\"3205\" name=\"reasonDiscRef[]\" " . getData ("reasonDiscRef", "checkbox", 2) . " type=\"radio\" value=\"2\" " . $transferDisabled . " /> " . $transferClinics_1_0[$lang][2] . "</span>
         </td>
     </tr>
     <tr>
	 	 <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  .
     		$transferClinics_1_0[$lang][3]; 
		//<input type=\"text\" tabindex=\"3206\" size=\"76\" name=\"clinicName\" " . getData ("clinicName", "text") . " maxlength=\"255\">
	allClinicsDropdown ("clinicName", $site, "tabindex=\"3206\"", getData ("clinicName", "textarea"), $transferDisabled);
	echo "
	     </tr>



     <tr>
	           <td colspan=\"4\" width=\"100%\">
	      	      <input tabindex=\"3305\"  id=\"reasonDiscDeath\" name=\"reasonDiscDeath\" " . getData ("reasonDiscDeath", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath[$lang][1] . "</td>

	 </tr>
	 <tr>
	 	<td width=\"5%\">&nbsp;</td>
	 	<td width=\"30%\"> ".  $dateOfDeath[$lang][0] . "
	 	</td>
	 	<td colspan=\"2\" width=\"95%\">
	 	<table><tr><td id=\"reasonDiscDeathD1Title\">" . $reasonDiscDeathDd[$lang][0] . "&nbsp;&nbsp;</td>
	 	<td><input type=\"text\" tabindex=\"3306\" size=\"8\" id=\"reasonDiscDeathD1\" name=\"reasonDiscDeathD1\" value=\"" . getData ("reasonDiscDeathDd", "textarea") . "/" . getData ("reasonDiscDeathMm", "textarea") . "/" .getData ("reasonDiscDeathYy", "textarea") . "\"  maxlength=\"8\">
	 	<input type=\"hidden\" 				   id=\"reasonDiscDeathDd\" name=\"reasonDiscDeathDd\" " . getData ("reasonDiscDeathDd", "text") . ">
	 	<input type=\"hidden\" tabindex=\"3307\" id=\"reasonDiscDeathMm\" name=\"reasonDiscDeathMm\" " . getData ("reasonDiscDeathMm", "text") . ">
	 	<input type=\"hidden\" tabindex=\"3308\" id=\"reasonDiscDeathYy\" name=\"reasonDiscDeathYy\" " . getData ("reasonDiscDeathYy", "text") . " >
	 	</td>
	 	<td>
	 	<i>" . $reasonDiscDeathYy[$lang][2] . "</i> &nbsp;&nbsp; ". $timeUnknownUse[$lang][0] . "
	 	</td>
	 	</tr>
	 	</table>
	    </td>
	 </tr>
	 <tr>
	    <td width=\"5%\">&nbsp;</td>
	    <td colspan=\"2\" width=\"95%\">". $reasonDiscDeathDd_1_0[$lang][0]. "</td>
	 </tr>
	 <tr>
	    <td width=\"5%\">&nbsp;</td>
	 	<td width=\"30%\">
	    	<span >
	 		<input tabindex=\"3401\" id=\"sideEffects\" name=\"sideEffects\" " . getData ("sideEffects", "checkbox") . " type=\"radio\" value=\"On\"> " . $sideEffects_1[$lang][1] . "</span>
	 	</td>
	    <td width=\"65%\">
	    	<input type=\"text\" tabindex=\"3402\" size=\"40\" name=\"sideEffectsText\" " . getData ("sideEffectsText", "text") . " maxlength=\"255\">
	 	</td>
	 </tr>
	 <tr>
	    <td width=\"5%\">&nbsp;</td>
	 	<td width=\"30%\">
	        <span>
	 	 	<input tabindex=\"3403\" id=\"opportunInf\"  name=\"opportunInf\" " . getData ("opportunInf", "checkbox") . " type=\"radio\" value=\"On\"> " . $opportunInf_1[$lang][1] . "</span>
	 	</td>
	    <td width=\"65%\"><input type=\"text\" tabindex=\"3404\" size=\"40\" name=\"opportunInfText\" " . getData ("opportunInfText", "text") . " maxlength=\"255\">
	    </td>
	 </tr>
	<tr>
	    <td width=\"5%\">&nbsp;</td>
	 	<td width=\"30%\">
	        <span >
	      	<input tabindex=\"3405\" id=\"discDeathOther\" name=\"discDeathOther\" " . getData ("discDeathOther", "checkbox") . " type=\"radio\" value=\"On\"> " . $discDeathOther_1[$lang][1] . "</span></td>
	    <td width=\"65%\"><input type=\"text\" tabindex=\"3406\" size=\"40\" name=\"discDeathOtherText\" " . getData ("discDeathOtherText", "text") . " maxlength=\"255\">
	    </td>
    </tr>

";
		//$disReasons = array (0=>"noARVs",1=>"patientMoved",2=>"poorAdherence",3=>"patientPreference",4=>"discReasonOther");
		//$disReasonresult = ifChecked($disReasons,4);
		echo "
	<tr>
	<td colspan=\"4\" width=\"100%\">
		 <input tabindex=\"3300\" id=\"reasonDiscOther\"  name=\"reasonDiscOther\"  type=\"checkbox\" value=\"On\" " . getData ("reasonDiscOther", "checkbox") . "  > " . $reasonOfDisenrollment[$lang][0] . "
		 </td>

	</tr>

      <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3301\" name=\"noARVs\" " . getData ("noARVs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $noARVs[$lang][1] . "
         </td>
      </tr>
      <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3302\" name=\"patientMoved\" " . getData ("patientMoved", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientMoved[$lang][1] . "
       </tr>
       <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3303\" name=\"poorAdherence\" " . getData ("poorAdherence", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $poorAdherence[$lang][1] . "
          </td>
       </tr>
       <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3304\" name=\"patientPreference\" " . getData ("patientPreference", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientPreference_1[$lang][1] . "
          </td>
       </tr>
       <tr>
	       <td width=\"5%\">&nbsp;</td>
	         <td colspan=\"3\" width=\"95%\">
	           <input tabindex=\"3305\" name=\"seroreversion\" " . getData ("seroreversion", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $seroreversion[$lang][0] . "
	        </td>
       </tr>
        <tr>
	      	  <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
	        		<input tabindex=\"3501\" name=\"discReasonOther\" " . getData ("discReasonOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $discReasonOtherText_1[$lang][1] . " &nbsp; <input type=\"text\" tabindex=\"3502\" size=\"80\" name=\"discReasonOtherText\" " . getData ("discReasonOtherText", "text") . " maxlength=\"255\">
	      	  </td>
       </tr>
  </table>

  <table class=\"header\">
  <tr>
       	<td colspan=\"4\" width=\"100%\">
  	        		<input tabindex=\"3500\" id=\"reasonUnknownClosing\" name=\"reasonUnknownClosing\" " . getData ("reasonUnknownClosing", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonUnknownClosing_1[$lang][0] . "
  	      	  </td>
       </tr>
  	<tr>
   		<td class=\"s_header\">" . $discRemarks_1[$lang][1] . "
   		</td>
  	</tr>
  	<tr>
    	<td>

       		<textarea tabindex=\"4001\" name=\"discRemarks\" cols=\"150\" rows=\"5\">" . getData ("discRemarks", "textarea") . "</textarea>

    	</td>
   </tr>
  </table>

  <p>
  <input type=\"hidden\" name=\"encounterType\" value=\"21\">
";

$tabIndex = 5000;
$formName = "peddiscontinuation";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"discontinuation/peddiscontinuation.js\"></script>";
?>
