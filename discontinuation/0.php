<?php
echo "
<!-- ******************************************************************** -->
<!-- ********************** Discontinue Treatment  ********************** -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
      <tr>
       <td class=\"under_header\" colspan=\"2\">
       </td>
      </tr>
      <tr>
          <td class=\"s_header\" colspan=\"2\">" . $discARVTreatment_header[$lang][1] . "</td>
      </tr>
      <tr>
                  <td width=\"50%\">" . $everOn[$lang][0] . "</td><td width=\"50%\">" . $ending[$lang][0] . "
                  </td>
             </tr>
             <tr>
                  <td width=\"50%\">
                       <span><input tabindex=\"2001\" name=\"everOn[]\" " . getData ("everOn", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $everOn[$lang][1] . "</span>
                  </td>
                  <td width=\"50%\">
                       <table>
                       <tr><td><input tabindex=\"2003\" name=\"ending[]\" " . getData ("ending", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $ending[$lang][1] . "
                       </td>
                       <td  id=\"endingDtTitle\"></td>
                       <td>
             <input type=\"text\"   tabindex=\"2004\" size=\"8\" maxsize=\"8\" id=\"endingDt\" name=\"endingDt\" value=\"" . getData ("endingDd", "textarea") . "/". getData ("endingMm", "textarea") ."/". getData ("endingYy", "textarea") . "\">
			 <input type=\"hidden\" 				  id=\"endingDd\" name=\"endingDd\" " . getData ("endingDd", "text") . ">
			 <input type=\"hidden\" tabindex=\"2005\" id=\"endingMm\" name=\"endingMm\" " . getData ("endingMm", "text") . ">
	  	  	 <input type=\"hidden\" tabindex=\"2006\" id=\"endingYy\" name=\"endingYy\" " . getData ("endingYy", "text") . ">
             </td><td><i>" . $endingYy[$lang][2] . "</i></td></tr></table>
                  </td>
             </tr>
             <tr>
                  <td width=\"50%\">
                       <span><input tabindex=\"2002\" name=\"everOn[]\" " . getData ("everOn", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $everOn[$lang][2] . "</span>
                  </td>
                  <td width=\"50%\">
                       <span><input tabindex=\"2007\" name=\"ending[]\" " . getData ("ending", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $ending[$lang][2] . "</span>
                  </td>
      </tr>
     </table>
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
    <td class=\"s_header\" colspan=\"2\">" . $discEnrollment_header[$lang][1] . "</td>
   </tr>
   <tr>";

if ($lang == "en") echo "
       <td colspan=\"2\">
           <b>" . $partStop[$lang][0] . "</b> <span><input tabindex=\"3001\" name=\"partStop[]\" " . getData ("partStop", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $partStop[$lang][2] . " <input tabindex=\"3002\" name=\"partStop[]\" " . getData ("partStop", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $partStop[$lang][1] . "</span>
       </td>";

else echo "
       <td colspan=\"2\">
           <b>" . $partStop[$lang][0] . "</b> <span><input tabindex=\"3001\" name=\"partStop[]\" " . getData ("partStop", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $partStop[$lang][1] . " <input tabindex=\"3002\" name=\"partStop[]\" " . getData ("partStop", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $partStop[$lang][2] . "</span>
       </td>";

echo "
   </tr>
   <tr>
            <td id=\"lastContactDtTitle\" width=\"35%\">
                <b>" . $lastContactDd[$lang][0] . "</b>
            </td>
	        <td class=\"left_pad\">
	         <table>
	          <tr>
	           <td>
	  	  		<input type=\"text\"   tabindex=\"3005\" size=\"8\" id=\"lastContactDt\" name=\"lastContactDt\" value=\"" . getData ("lastContactDd", "textarea") . "/". getData ("lastContactMm", "textarea") ."/". getData ("lastContactYy", "textarea") . "\">
	  	  		<input type=\"hidden\" 				     id=\"lastContactDd\" name=\"lastContactDd\" " . getData ("lastContactDd", "text") . ">
	  	  		<input type=\"hidden\" tabindex=\"3006\" id=\"lastContactMm\" name=\"lastContactMm\" " . getData ("lastContactMm", "text") . ">
	  	  		<input type=\"hidden\" tabindex=\"3007\" id=\"lastContactYy\" name=\"lastContactYy\" " . getData ("lastContactYy", "text") . ">
			   </td>
			   <td>
		        <i>" . $lastContactYy[$lang][2] . "</i>
		       </td>
		      </tr>
		     </table>
		    </td>
   </tr>
   <tr>
            <td id=\"disEnrollDtTitle\" width=\"35%\">
                <b>" . $discEnrollDd[$lang][0] . "</b>
            </td>
            <td class=\"left_pad\">
		     <table>
	          <tr>
	           <td>
	  	  		<input type=\"text\"   tabindex=\"3008\" size=\"8\" id=\"disEnrollDt\" name=\"disEnrollDt\" value=\"" . getData ("disEnrollDd", "textarea") . "/". getData ("disEnrollMm", "textarea") ."/". getData ("disEnrollYy", "textarea") . "\">
	  	  		<input type=\"hidden\" 				     id=\"disEnrollDd\" name=\"disEnrollDd\" " . getData ("disEnrollDd", "text") . ">
	  	  		<input type=\"hidden\" tabindex=\"3009\" id=\"disEnrollMm\" name=\"disEnrollMm\" " . getData ("disEnrollMm", "text") . ">
	  	  		<input type=\"hidden\" tabindex=\"3010\" id=\"disEnrollYy\" name=\"disEnrollYy\" " . getData ("disEnrollYy", "text") . ">
			   </td>
			   <td>
		        <i>" . $discEnrollYy[$lang][2] . "</i>
		       </td>
		      </tr>
		     </table>
		    </td>
   </tr>
   <tr>
        <td colspan=\"2\">
             <b>" . $reasonDiscNoFollowup[$lang][0] . "</b>

        </td>
   </tr>
  </table>

  <table>
     <tr>
        <td colspan=\"4\" width=\"100%\">
     	    <input tabindex=\"3101\" name=\"reasonDiscNoFollowup\" " . getData ("reasonDiscNoFollowup", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscNoFollowup[$lang][1] . "
        </td>
     </tr>
     <tr>
        <td width=\"5%\">&nbsp;</td>
        <td colspan=\"3\" width=\"95%\">" .
	        $min3homeVisits[$lang][0] . " <span><input tabindex=\"3102\" name=\"min3homeVisits[]\" " . getData ("min3homeVisits", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $min3homeVisits[$lang][1] . " <input tabindex=\"3103\" name=\"min3homeVisits[]\" " . getData ("min3homeVisits", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $min3homeVisits[$lang][2] . " <input tabindex=\"3104\" name=\"min3homeVisits[]\" " . getData ("min3homeVisits", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $min3homeVisits[$lang][3] . "</span>
        </td>
     </tr>
     <tr>
         <td width=\"5%\">&nbsp;</td>
         <td colspan=\"3\" width=\"95%\">" .
             $min3homeVisitsText[$lang][1] . " <input tabindex=\"3105\" name=\"min3homeVisitsText\" " . getData ("min3homeVisitsText", "text") . " type=\"text\" size=\"80\"/>
         </td>
     </tr>
     <tr>
         <td colspan=\"4\" width=\"100%\"><input tabindex=\"3201\" name=\"reasonDiscTransfer\" " . getData ("reasonDiscTransfer", "checkbox") . " type=\"checkbox\" value=\"On\"> " .
   	         $transferClinics[$lang][0] . " <span><input tabindex=\"3202\" name=\"transferClinics[]\" " . getData ("transferClinics", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $transferClinics[$lang][1] . " <input tabindex=\"3203\" name=\"transferClinics[]\" " . getData ("transferClinics", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $transferClinics[$lang][2] . "</span>
         </td>
     </tr>
     <tr>
         <td colspan=\"4\" width=\"100%\">" .
   	         $reasonDiscTransfer[$lang][0] . " <span><input tabindex=\"3204\" name=\"reasonDiscRef[]\" " . getData ("reasonDiscRef", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $reasonDiscTransfer[$lang][1] . " <input tabindex=\"3205\" name=\"reasonDiscRef[]\" " . getData ("reasonDiscRef", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $reasonDiscTransfer[$lang][2] . "</span> &nbsp; " . $clinicName[$lang][1] . " <input type=\"text\" tabindex=\"3206\" size=\"30\" name=\"clinicName\" " . getData ("clinicName", "text") . "/>
         </td>
      </tr>
      <tr>
         <td colspan=\"4\" width=\"100%\">&nbsp;</td>
      </tr>
      <tr>
         <td colspan=\"4\" width=\"100%\">
     	     <input tabindex=\"3301\" name=\"noARVs\" " . getData ("noARVs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $noARVs[$lang][1] . "
         </td>
      </tr>
      <tr>
         <td colspan=\"4\" width=\"100%\">
     	     <input tabindex=\"3302\" name=\"patientMoved\" " . getData ("patientMoved", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientMoved[$lang][1] . "
       </tr>
       <tr>
         <td colspan=\"4\" width=\"100%\">
     	     <input tabindex=\"3303\" name=\"poorAdherence\" " . getData ("poorAdherence", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $poorAdherence[$lang][1] . "
          </td>
       </tr>
       <tr>
         <td colspan=\"4\" width=\"100%\">
     	     <input tabindex=\"3304\" name=\"patientPreference\" " . getData ("patientPreference", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientPreference[$lang][1] . "
          </td>
       </tr>
  </table>

  <table>
       <tr>
          <td width=\"10%\">
     	      <input tabindex=\"3305\" name=\"reasonDiscDeath\" " . getData ("reasonDiscDeath", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDiscDeath[$lang][1] . "</td>
          <td id=\"reasonDiscDeathDtTitle\" align=\"right\" width=\"10%\">" . $reasonDiscDeathDd[$lang][0] . "</td>
          <td colspan=\"2\" width=\"80%\">
		    <table>
	          <tr>
	           <td>
	  	  		<input type=\"text\"   tabindex=\"3306\" size=\"8\" id=\"reasonDiscDeathDt\" name=\"reasonDiscDeathDt\" value=\"" . getData ("reasonDiscDeathDd", "textarea") . "/". getData ("reasonDiscDeathMm", "textarea") ."/". getData ("reasonDiscDeathYy", "textarea") . "\">
	  	  		<input type=\"hidden\" 				     id=\"reasonDiscDeathDd\" name=\"reasonDiscDeathDd\" " . getData ("reasonDiscDeathDd", "text") . ">
	  	  		<input type=\"hidden\" tabindex=\"3307\" id=\"reasonDiscDeathMm\" name=\"reasonDiscDeathMm\" " . getData ("reasonDiscDeathMm", "text") . ">
	  	  		<input type=\"hidden\" tabindex=\"3308\" id=\"reasonDiscDeathYy\" name=\"reasonDiscDeathYy\" " . getData ("reasonDiscDeathYy", "text") . ">
			   </td>
			   <td>
		        <i>" .  $reasonDiscDeathYy[$lang][2]. "</i>
		       </td>
		      </tr>
		     </table>
          </td>
       </tr>
       <tr>
          <td width=\"10%\">&nbsp;</td>
          <td align=\"right\" width=\"10%\">" .
		$sideEffects[$lang][0] . "
     	  			</td>
	  <td width=\"40%\">
                <span>
		<input tabindex=\"3401\" id=\"sideEffects\" name=\"sideEffects\" " . getData ("sideEffects", "checkbox") . " type=\"radio\" value=\"On\"> " . $sideEffects[$lang][1] . "</span></td>
          <td width=\"40%\"><input type=\"text\" tabindex=\"3402\" size=\"40\" name=\"sideEffectsText\" " . getData ("sideEffectsText", "text") . "/>
	  </td>
       </tr>
       <tr>
       	  <td colspan=\"2\" width=\"20%\">&nbsp;</td>
	  <td width=\"40%\">
                <span>
	 	<input tabindex=\"3403\" id=\"opportunInf\" name=\"opportunInf\" " . getData ("opportunInf", "checkbox") . " type=\"radio\" value=\"On\"> " . $opportunInf[$lang][1] . "</span></td>
          <td width=\"40%\"><input type=\"text\" tabindex=\"3404\" size=\"40\" name=\"opportunInfText\" " . getData ("opportunInfText", "text") . " maxlength=\"255\">
          </td>
       </tr>
       <tr>
       	  <td colspan=\"2\" width=\"20%\">&nbsp;</td>
	  <td width=\"40%\">
                <span>
     	   	<input tabindex=\"3405\" id=\"discDeathOther\" name=\"discDeathOther\" " . getData ("discDeathOther", "checkbox") . " type=\"radio\" value=\"On\"> " . $discDeathOther[$lang][1] . "</span></td>
          <td width=\"40%\"><input type=\"text\" tabindex=\"3406\" size=\"40\" name=\"discDeathOtherText\" " . getData ("discDeathOtherText", "text") . " maxlength=\"255\">
      	  </td>
       </tr>
       <tr>
   	  <td colspan=\"4\" width=\"100%\">
     		<input tabindex=\"3501\" name=\"discReasonOther\" " . getData ("discReasonOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $discReasonOther[$lang][1] . " <input type=\"text\" tabindex=\"3502\" size=\"80\" name=\"discReasonOtherText\" " . getData ("discReasonOtherText", "text") . " maxlength=\"255\">
   	  </td>
       </tr>
  </table>

  <table class=\"header\">
  	<tr>
   		<td class=\"s_header\">" . $discRemarks[$lang][1] . "
   		</td>
  	</tr>
  	<tr>
    	<td>
      		<table class=\"header\">
      			<tr>
       				<td>
       					<textarea tabindex=\"4001\" name=\"discRemarks\" cols=\"80\" rows=\"5\">" . getData ("discRemarks", "textarea") . "</textarea>
       				</td>
      			</tr>
     		</table>
    	</td>
   </tr>
  </table>

  <p>
  <input type=\"hidden\" name=\"encounterType\" value=\"12\">
";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"discontinuation/0.js\"></script>";
?>