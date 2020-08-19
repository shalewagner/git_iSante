<?php
echo "
<!-- ******************************************************************** -->
<!-- ********************** Discontinue Treatment  ********************** -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->
 <table class=\"header\">
      <tr>
       			<td class=\"s_header\"  colspan=\"2\">Rapport de discontinuation des soins 
       			</td>
      </tr>
	  
	  <tr>
	        <td colspan=\"2\" width=\"100%\">&nbsp;
			</td>
      </tr>
	  <tr>
			<td colspan=\"2\" width=\"100%\">" . $everOn_1[$lang][0] . "</td>
	</tr>
		<tr>
			<td colspan =\"2\" width=\"100%\">
					   <span><input tabindex=\"105\" name=\"everOn[]\" " . getData ("everOn", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $everOn_1[$lang][1] . "</span>
			</td>
	  </tr>
	  <tr>
		  <td colspan=\"2\" width=\"100%\">
			   <span><input tabindex=\"106\" name=\"everOn[]\" " . getData ("everOn", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $everOn_1[$lang][2] . "</span>
		  </td>
      </tr>
	  
	  
	  
	  
	  <tr>
	  	        <td  id=\"disEnrollDtTitle\" width=\"50%\">
	  	                 " . $discEnrollDd_1[$lang][0] . "
	  	        </td>
	  	        <td class=\"left_pad\">
	  	  			<table>
	  	  				<tr>
	  	  					<td>
	  	  						<input type=\"text\"   tabindex=\"102\" size=\"8\" id=\"disEnrollDt\" name=\"disEnrollDt\" value=\"" . getData ("disEnrollDd", "textarea") . "/". getData ("disEnrollMm", "textarea") ."/". getData ("disEnrollYy", "textarea") . "\"/>
	  	  		     		    <input type=\"hidden\" 				     id=\"disEnrollDd\" name=\"disEnrollDd\" " . getData ("disEnrollDd", "text") . "/>
	  	  		     		    <input type=\"hidden\" tabindex=\"0\" id=\"disEnrollMm\" name=\"disEnrollMm\" " . getData ("disEnrollMm", "text") . "/>
	  	  		     		    <input type=\"hidden\" tabindex=\"0\" id=\"disEnrollYy\" name=\"disEnrollYy\" " . getData ("disEnrollYy", "text") . "/>
	  	  		     		</td>
	  	  		     		<td>
	  	  		     			<i>" . $discEnrollYy[$lang][2] . "</i>
	  	  		     		</td>
	  	  		     	</tr>
	  	  		     </table>
	  	  		</td>
   	  </tr>
	  <tr>
	            <td id=\"lastContactDtTitle\" width=\"50%\">
	                  " . $lastContactDd_1[$lang][0] . "
	            </td>

	  	        <td class=\"left_pad\">
	  	        	<table>
	  	        		<tr>
	  	        			<td>
					<input type=\"text\"   tabindex=\"103\" size=\"8\" id=\"lastContactDt\" name=\"lastContactDt\" value=\"" . getData ("lastContactDd", "textarea") . "/". getData ("lastContactMm", "textarea") ."/". getData ("lastContactYy", "textarea") . "\">
					<input type=\"hidden\" 				     id=\"lastContactDd\" name=\"lastContactDd\" " . getData ("lastContactDd", "text") . ">
					<input type=\"hidden\" tabindex=\"0\" id=\"lastContactMm\" name=\"lastContactMm\" " . getData ("lastContactMm", "text") . ">
					<input type=\"hidden\" tabindex=\"0\" id=\"lastContactYy\" name=\"lastContactYy\" " . getData ("lastContactYy", "text") . ">
	  		    </td>
	  		    <td>
	  		     	<i>" . $lastContactYy[$lang][2] . "</i>
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
	        <td colspan=\"2\" width=\"100%\">&nbsp;
			</td>
      </tr>
     <tr>
           			<td class=\"s_header\"  colspan=\"2\">".$reasonDiscNoFollowup_2[$lang][0]."
           			</td>
   </tr>
  </table>
  <table>
  <tr>
	 <td colspan=\"2\" width=\"100%\">&nbsp;</td>
  </tr>
     <tr>
        <td colspan=\"4\" width=\"100%\">
     	    <input tabindex=\"3101\" name=\"reasonDiscNoFollowup\" " . getData ("reasonDiscNoFollowup", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscNoFollowup_2[$lang][1] . "
        </td>
     </tr>
  <tr>
	 <td colspan=\"2\" width=\"100%\">&nbsp;</td>
  </tr>
     <tr>
         <td colspan=\"4\" width=\"95%\">
		 <input tabindex=\"3101\" name=\"emigrationCause\" " . getData ("emigrationCause", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscNoFollowup_2[$lang][2] 
		  ."&nbsp; <input tabindex=\"3105\" name=\"emigrationPrecisez\" " . getData ("emigrationPrecisez", "text") . " type=\"text\" size=\"82\" maxlength=\"255\">
         </td>
     </tr>
";
	$transferDisabled = "disabled";
	//if (getAccessLevel(getSessionUser()) == 3) 
		$transferDisabled = "";
   echo "
   <tr>
	 <td colspan=\"2\" width=\"100%\">&nbsp;</td>
  </tr>
     <tr>
         <td colspan=\"4\" width=\"100%\"><input tabindex=\"3201\" name=\"reasonDiscTransfer\" " . getData ("reasonDiscTransfer", "checkbox") . " type=\"checkbox\" value=\"On\" " . $transferDisabled . " /> " .  $transferClinics_1[$lang][0] . "
         </td>
     </tr>
     <tr>
     	 <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">" .
   	          " <span><input tabindex=\"3204\" name=\"reasonDiscRef[]\" " . getData ("reasonDiscRef", "checkbox", 1) . " type=\"radio\" value=\"1\" " . $transferDisabled . " /> " . $transferClinics_1[$lang][1] . "</span>
         </td>
     </tr>
     <tr>
	     <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">
     		<span><input tabindex=\"3205\" name=\"reasonDiscRef[]\" " . getData ("reasonDiscRef", "checkbox", 2) . " type=\"radio\" value=\"2\" " . $transferDisabled . " /> " . $transferClinics_1[$lang][2] . "</span>
         </td>
     </tr>
     <tr>
	 	 <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  .  $transferClinics_1[$lang][3];
// <input type=\"text\" tabindex=\"3206\" size=\"76\" name=\"clinicName\" " . getData ("clinicName", "text") . " maxlength=\"255\" " . $transferDisabled . " />
	allClinicsDropdown ("clinicName", $site, "tabindex=\"3206\"", getData ("clinicName", "textarea"), $transferDisabled);
	echo "
     </tr>
  <tr>
	 <td colspan=\"2\" width=\"100%\">&nbsp;</td>
  </tr>

<tr>
	<td colspan=\"3\" width=\"100%\">
		 <input tabindex=\"3500\" name=\"reasonDiscDeath\"  type=\"checkbox\" value=\"On\" " . getData ("reasonDiscDeath", "checkbox") . "  > " . $reasonDiscDeath_2[$lang][0] . "
		 </td>
	 	<td colspan=\"1\" width=\"95%\">
	 		<table>
	 			<tr>
	 				<td>" . $reasonDiscDeathDd[$lang][0] . "&nbsp;&nbsp;</td>
	 				<td><input type=\"text\" tabindex=\"3306\" size=\"8\" id=\"reasonDiscDeathDt\" name=\"reasonDiscDeathDt\" value=\"" . getData ("reasonDiscDeathDd", "textarea") . "/". getData ("reasonDiscDeathMm", "textarea") ."/". getData ("reasonDiscDeathYy", "textarea") . "\" maxlength=\"8\">
	 					<input type=\"hidden\"							  id=\"reasonDiscDeathDd\" name=\"reasonDiscDeathDd\" " . getData ("reasonDiscDeathDd", "text") . ">
	 					<input type=\"hidden\" tabindex=\"3307\" 		  id=\"reasonDiscDeathMm\" name=\"reasonDiscDeathMm\" " . getData ("reasonDiscDeathMm", "text") . ">
	 					<input type=\"hidden\" tabindex=\"3308\" 		  id=\"reasonDiscDeathYy\" name=\"reasonDiscDeathYy\" " . getData ("reasonDiscDeathYy", "text") . ">
	 				</td>
	 				<td>
	 				<i>" . $reasonDiscDeathYy[$lang][2] . "</i>
	 				</td>
	 			</tr>
	 		</table>
	    </td>
	 </tr>
      <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3501\" id=\"tuberculoseCauseDeces\" name=\"tuberculoseCauseDeces\" " . getData ("tuberculoseCauseDeces", "checkbox",1) . " type=\"checkbox\"> " . $reasonDiscDeath_2[$lang][1] . "
         </td>
      </tr>
      <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3502\" name=\"maladieInfectuesesCauseDeces\" " . getData ("maladieInfectuesesCauseDeces", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath_2[$lang][2] . "
       </tr>
       <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3503\" name=\"CancerCauseDeces\" " . getData ("CancerCauseDeces", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath_2[$lang][3] . "
          </td>
       </tr>
       <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3504\" name=\"autreMaladieCauseDeces\" " . getData ("autreMaladieCauseDeces", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath_2[$lang][4] . "
          </td>
       </tr>
	   <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3504\" name=\"causeNaturelCauseDeces\" " . getData ("causeNaturelCauseDeces", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath_2[$lang][5] . "
          </td>
       </tr>
	   <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3504\" name=\"causeNonNaturelCauseDeces\" " . getData ("causeNonNaturelCauseDeces", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath_2[$lang][6] . "
          </td>
       </tr>
        <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3504\" name=\"inconnueCauseDeces\" " . getData ("inconnueCauseDeces", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath_2[$lang][7] . "
          </td>
       </tr>


";
		//$disReasons = array (0=>"noARVs",1=>"patientMoved",2=>"poorAdherence",3=>"patientPreference",4=>"discReasonOther");
		//$disReasonresult = ifChecked($disReasons,4);
		echo "
		  <tr>
	 <td colspan=\"2\" width=\"100%\">&nbsp;</td>
  </tr>
	<tr>
	<td colspan=\"4\" width=\"100%\">
		 <input tabindex=\"3500\" name=\"reasonDiscOther\"  type=\"checkbox\" value=\"On\" " . getData ("reasonDiscOther", "checkbox") . "  > " . $discReason_2[$lang][0] . "
		 </td>

	</tr>
      <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3504\" name=\"patientPreference\" " . getData ("patientPreference", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientPreference[$lang][1] . "
          </td>
       </tr>	   

      <tr>
         <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"3\" width=\"95%\">
     	     <input tabindex=\"3501\" name=\"decisionPrestataire\" " . getData ("decisionPrestataire", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $discReason_2[$lang][1] . "
         </td>
      </tr>
	  <tr>
         <td width=\"5%\">&nbsp;</td>
		 <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"2\" width=\"95%\">
     	     <input tabindex=\"3503\" name=\"poorAdherence\" " . getData ("poorAdherence", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $poorAdherence[$lang][1] . "
          </td>
       </tr>
      <tr>
         <td width=\"5%\">&nbsp;</td>
		 <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"2\" width=\"95%\">
     	     <input tabindex=\"3502\" name=\"deniArret\" " . getData ("deniArret", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $discReason_2[$lang][2] . "
       </tr>
       
       <tr>
         <td width=\"5%\">&nbsp;</td>
		 <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"2\" width=\"95%\">
     	     <input tabindex=\"3504\" name=\"troublePsychiatre\" " . getData ("troublePsychiatre", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $discReason_2[$lang][3] . "
          </td>
       </tr>
        <tr>
	      	<td width=\"5%\">&nbsp;</td>
		 <td width=\"5%\">&nbsp;</td>
     	<td colspan=\"2\" width=\"95%\">
	        		<input tabindex=\"3601\" name=\"discReasonOther\" " . getData ("discReasonOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $discReasonOtherText_1[$lang][1] . " &nbsp; <input type=\"text\" tabindex=\"3602\" size=\"80\" name=\"discReasonOtherText\" " . getData ("discReasonOtherText", "text") . " maxlength=\"255\">
	      	  </td>
       </tr>
  </table>

  <table class=\"header\">
<tr>
	 <td colspan=\"2\" width=\"100%\">&nbsp;</td>
  </tr>
   		<td class=\"s_header\">" . $discRemarks_1[$lang][1] . "
   		</td>
  	</tr>
  	<tr>
    	<td>

       		<textarea tabindex=\"4001\" name=\"discRemarks\" cols=\"112\" rows=\"5\">" . getData ("discRemarks", "textarea") . "</textarea>

    	</td>
   </tr>
  </table>

  <p>
  <input type=\"hidden\" name=\"encounterType\" value=\"12\">
";

echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"discontinuation/1.js\"></script>";

?>
