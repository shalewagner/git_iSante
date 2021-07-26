<?php
echo "
<tr>
    <td>
	     <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" BORDER=\"0\">
	      <tr>
	       <td class=\"s_header\" colspan=\"10\">" . $arv_header[$lang][1] . "</td>
	      </tr>
	      <tr>
	       <td colspan=\"10\">" . $arvEver[$lang][0] . " <span>
	         <input tabindex=\"17001\" id=\"arvY\" id=\"arvY\" name=\"arvEver[]\" " . getData ("arvEver", "radio", 1) . " type=\"radio\" value=\"1\">" . $arvEver[$lang][1] . " <input tabindex=\"17002\" id=\"arvN\" name=\"arvEver[]\" " . getData ("arvEver", "radio", 2) . " type=\"radio\" value=\"2\">" . $arvEver[$lang][2] . "</span></td>
	      </tr>
	      <tr>
	       <td colspan=\"2\"><i>" . $arv_header[$lang][2] . "</i></td>
	       <td colspan=\"8\" class=\"sm_cnt\"><b>" . $arv_subhead14[$lang][0] . "</b> &nbsp; " . $arv_subhead12[$lang][1] . " &nbsp; " . $arv_subhead14[$lang][1] . " &nbsp; " . $arv_subhead12[$lang][2] . " &nbsp; " . $arv_subhead12[$lang][3] . " &nbsp; " . $arv_subhead12[$lang][4] ."</td>
	      </tr>
	      <tr>
	       <td class=\"bottom_line\" colspan=\"10\">&nbsp;</td>
	      </tr>
	      <tr>
	       <td>&nbsp;</td>
	       <td class=\"sm_header_lt\">" . $arv_subhead1[$lang][0] . "</td>
	       <td class=\"sm_header_lt\">" . $arv_subhead1[$lang][1] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead1[$lang][2] . "</td>
	       <td class=\"sm_header_cnt\">&nbsp;</td>
	       <td class=\"sm_header_lt\" colspan=\"5\">" . $arv_subhead6[$lang][1] . "</td>
	      </tr>
	      <tr>
	       <td class=\"top_line\" colspan=\"10\">&nbsp;</td>
	      </tr>
	      <tr>
	       <td colspan=\"5\"><b><a class=\"toggle_display\"
	            onclick=\"toggleDisplay(0,$arvSubHeadElems[0]);\"
	            title=\"Toggle display\">
	            <span id=\"section0Y\" style=\"display:none\">(+)</span>
	            <span id=\"section0N\">(-)&nbsp;</span>" .
	          $arv_subhead3[$version][$lang][1] .
	         "</a></b></td>
		   <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][4] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][0] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][1] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][2] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead11[$lang][2] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][3] . "</td>
	      </tr>" . $arv_rows . "
	      <tr>
	       <td class=\"s_header\" colspan=\"10\">" . $arv_subhead11[$lang][1] . "</td>
	      </tr>
	      <tr>
	       <td colspan=\"10\"><textarea tabindex=\"17901\" name=\"drugComments\" cols=\"80\" rows=\"5\">" . getData ("drugComments", "textarea") . "</textarea></td>
	      </tr>
	     </table>
    </td>
</tr>

<!-- ******************************************************************** -->
<!-- ************************* ARV and Pregnancy ************************ -->
<!-- ******************** (tab indices 8001 - 9000) ********************* -->
<!-- ******************************************************************** -->

<tr>
    <td>
	     <table class=\"b_header_nb\">
		      <tr>
		       <td class=\"s_header\">" . $ARVandPregnancy_header[$lang][1] . "</td>
		      </tr>
		      <tr>
		       <td>" . $ARVexcl[$lang][0] . "  <span>
		         <input tabindex=\"18001\" id=\"ARVex1\" name=\"ARVexcl[]\" " . getData ("ARVexcl", "radio", 1) . " type=\"radio\" value=\"1\" class=\"arvExcl\">" . $ARVexcl[$lang][1]
		        . " <input tabindex=\"18002\" id=\"ARVex2\" name=\"ARVexcl[]\" " . getData ("ARVexcl", "radio", 2) . " type=\"radio\" value=\"2\" class=\"arvExcl\">" . $ARVexcl[$lang][2] .
		          " <input tabindex=\"18003\" id=\"ARVex3\" name=\"ARVexcl[]\" " . getData ("ARVexcl", "radio", 4) . " type=\"radio\" value=\"4\" class=\"arvExcl\">" . $ARVexcl[$lang][3] . "</span></td>
		      </tr>
		      <tr>
		       <td>" . $zidovudineARVpreg[$lang][0] . " <span>
		         <input tabindex=\"18004\" id=\"zidovudineARVpreg[]\" name=\"ARVpreg[]\" " .  getData ("zidovudineARVpreg", "radio", "1") ." type=\"radio\"   class=\"arvExcl\">" . $zidovudineARVpreg[$lang][1] . "
		         <input  id=\"zidovudineARVpreg\"  name=\"zidovudineARVpreg\" type=\"hidden\"   " .  getData ("zidovudineARVpreg", "text") ."> 
				</span> 
				<span>
		         <input tabindex=\"18005\" id=\"nevirapineARVpreg[]\" name=\"ARVpreg[]\" " . getData ("nevirapineARVpreg", "radio", "1") . " type=\"radio\" class=\"arvExcl\">" . $nevirapineARVpreg[$lang][1] . "
				 <input id=\"nevirapineARVpreg\" name=\"nevirapineARVpreg\" type=\"hidden\"  " .  getData ("nevirapineARVpreg", "text") ."> 
		        </span> <span>
		         <input tabindex=\"18006\" id=\"unknownARVpreg[]\" name=\"ARVpreg[]\" " . getData ("unknownARVpreg", "radio","1") . " type=\"radio\"  class=\"arvExcl\">" . $unknownARVpreg[$lang][1] .
		       "</span> <span>
			   <input  id=\"unknownARVpreg\" name=\"unknownARVpreg\" type=\"hidden\"    " .  getData ("unknownARVpreg", "text") ."> 
		         <input tabindex=\"18007\" id=\"otherARVpreg[]\" name=\"ARVpreg[]\" " . getData ("otherARVpreg", "radio","1") . " type=\"radio\" class=\"arvExcl\">" . $otherARVpreg[$lang][1] . " " .
		       $otherTextARVpreg[$lang][1] . " <input id=\"otherARVpreg\"  name=\"otherARVpreg\" type=\"hidden\"    " .  getData ("otherARVpreg", "text") ."> <input tabindex=\"18008\" name=\"otherTextARVpreg\" " . getData ("otherTextARVpreg", "text") . " type=\"text\" size=\"30\" maxlength=\"64\" class=\"arvExcl\"></span></td>
		      </tr>
	     </table>
    </td>
</tr>";




echo "
<tr>
    <td>
     <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" BORDER=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"8\">" . $allergies_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"8\"><i>" . $allergies_header[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td class=\"bottom_line\" colspan=\"8\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][0] . "</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][1] . "</td>
       <td class=\"sm_header_lt\" width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][2] . "</td>
       <td class=\"sm_header_lt\" width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead2[$lang][0] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_lt\">&nbsp;&nbsp;" . $allergies_subhead2[$lang][1] . "</td>
      </tr>
      <tr>
       <td class=\"top_line\" colspan=\"6\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"6\"><b>" . $allergies_subhead11[$lang][0] . "</b></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
       <td rowspan=\"13\" class=\"reg\">
         &nbsp;&nbsp;<textarea tabindex=\"19057\" name=\"treatmentComments\"
           rows=\"16\" cols=\"30\">" .
           getData ("treatmentComments", "textarea") . "</textarea>
       </td>
      </tr>
      <tr class=\"alt\">
       <td id=\"ethambutolStartTitle\" class=\"small_cnt\">" . $ethambutolMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19001\" id=\"ethambutolStartMm\" name=\"ethambutolStartMm\" class=\"small_cnt\" " .
           getData ("ethambutolStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19002\" id=\"ethambutolStartYy\" name=\"ethambutolStartYy\" class=\"small_cnt\" " .
           getData ("ethambutolStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ethambutolStopTitle\"></td>
       <td>
         <input tabindex=\"19003\" id=\"ethambutolStopMm\" name=\"ethambutolStopMm\" class=\"small_cnt\" " .
           getData ("ethambutolStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .

         "/<input tabindex=\"19004\" id=\"ethambutolStopYy\" name=\"ethambutolStopYy\" class=\"small_cnt\" " .
		   getData ("ethambutolStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ethambutolContinuedTitle\"></td>
       <td class=\"sm_header_cnt_np\">
         <input tabindex=\"19005\" id=\"ethambutolContinued\" name=\"ethambutolContinued\" " . getData ("ethambutolContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"isoniazidStartTitle\" class=\"small_cnt\">" . $isoniazidMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19006\" id=\"isoniazidStartMm\" name=\"isoniazidStartMm\" class=\"small_cnt\" " .
           getData ("isoniazidStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19007\" id=\"isoniazidStartYy\" name=\"isoniazidStartYy\" class=\"small_cnt\" " .
           getData ("isoniazidStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"isoniazidStopTitle\" />
       <td>
         <input tabindex=\"19008\" id=\"isoniazidStopMm\" name=\"isoniazidStopMm\" class=\"small_cnt\" " .
           getData ("isoniazidStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
          "/<input tabindex=\"19009\" id=\"isoniazidStopYy\" name=\"isoniazidStopYy\" class=\"small_cnt\" " .
           getData ("isoniazidStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
        <td  id=\"isoniazidContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19010\" id=\"isoniazidContinued\" name=\"isoniazidContinued\" " . getData ("isoniazidContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"pyrazinamideStartTitle\" class=\"small_cnt\">" . $pyrazinamideMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19011\" id=\"pyrazinamideStartMm\" name=\"pyrazinamideStartMm\" class=\"small_cnt\" " .
           getData ("pyrazinamideStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19012\" id=\"pyrazinamideStartYy\" name=\"pyrazinamideStartYy\" class=\"small_cnt\" " .
           getData ("pyrazinamideStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"pyrazinamideStopTitle\" />
       <td>
         <input tabindex=\"19013\" id=\"pyrazinamideStopMm\" name=\"pyrazinamideStopMm\" class=\"small_cnt\" " .
           getData ("pyrazinamideStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19014\" id=\"pyrazinamideStopYy\" name=\"pyrazinamideStopYy\" class=\"small_cnt\" " .
           getData ("pyrazinamideStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"pyrazinamideContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19015\" id=\"pyrazinamideContinued\" name=\"pyrazinamideContinued\" " . getData ("pyrazinamideContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"rifampicineStartTitle\" class=\"small_cnt\">" . $rifampicineMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19016\" id=\"rifampicineStartMm\" name=\"rifampicineStartMm\" class=\"small_cnt\" " .
           getData ("rifampicineStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
          "/<input tabindex=\"19017\" id=\"rifampicineStartYy\" name=\"rifampicineStartYy\" class=\"small_cnt\" " .
            getData ("rifampicineStartYy", "text") .
            " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"rifampicineStopTitle\">
       <td>
         <input tabindex=\"19018\" id=\"rifampicineStopMm\" name=\"rifampicineStopMm\" class=\"small_cnt\" " .
           getData ("rifampicineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19019\" id=\"rifampicineStopYy\" name=\"rifampicineStopYy\" class=\"small_cnt\" " .
           getData ("rifampicineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"rifampicineContinuedTitle\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19020\" id=\"rifampicineContinued\" name=\"rifampicineContinued\" " . getData ("rifampicineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"streptomycineStartTitle\"  class=\"small_cnt\">" . $streptomycineMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19021\" id=\"streptomycineStartMm\" name=\"streptomycineStartMm\" class=\"small_cnt\" " .
           getData ("streptomycineStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"19022\" id=\"streptomycineStartYy\" name=\"streptomycineStartYy\" class=\"small_cnt\" " .
           getData ("streptomycineStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"streptomycineStopTitle\" />
       <td>
         <input tabindex=\"19023\" id=\"streptomycineStopMm\" name=\"streptomycineStopMm\" class=\"small_cnt\" " .
           getData ("streptomycineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"19024\" id=\"streptomycineStopYy\" name=\"streptomycineStopYy\" class=\"small_cnt\" " .
           getData ("streptomycineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"streptomycineContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19025\" id=\"streptomycineContinued\" name=\"streptomycineContinued\" " . getData ("streptomycineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"5\"><b>" . $allergies_subhead11[$lang][1] . "</b></td>
      </tr>
      <tr class=\"alt\">
       <td id=\"acyclovirStartTitle\" class=\"small_cnt\">" . $acyclovirMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19026\" id=\"acyclovirStartMm\" name=\"acyclovirStartMm\" class=\"small_cnt\" " .
           getData ("acyclovirStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19027\" id=\"acyclovirStartYy\" name=\"acyclovirStartYy\" class=\"small_cnt\" " .
           getData ("acyclovirStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"acyclovirStopTitle\">
       <td>
         <input tabindex=\"19028\" id=\"acyclovirStopMm\" name=\"acyclovirStopMm\" class=\"small_cnt\" " .
           getData ("acyclovirStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"19029\" id=\"acyclovirStopYy\" name=\"acyclovirStopYy\" class=\"small_cnt\" " .
           getData ("acyclovirStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"acyclovirContinuedTitle\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19030\" id=\"acyclovirContinued\" name=\"acyclovirContinued\" " . getData ("acyclovirContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"cotrimoxazoleStartTitle\" class=\"small_cnt\">" . $cotrimoxazoleMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19031\" id=\"cotrimoxazoleStartMm\" name=\"cotrimoxazoleStartMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19032\" id=\"cotrimoxazoleStartYy\" name=\"cotrimoxazoleStartYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"cotrimoxazoleStopTitle\">
       <td>
         <input tabindex=\"19033\" id=\"cotrimoxazoleStopMm\" name=\"cotrimoxazoleStopMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19034\" id=\"cotrimoxazoleStopYy\" name=\"cotrimoxazoleStopYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"cotrimoxazoleContinuedTitle\">
       <td  class=\"sm_header_cnt_np\"><input tabindex=\"19035\" id=\"cotrimoxazoleContinued\" name=\"cotrimoxazoleContinued\" " . getData ("cotrimoxazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"fluconazoleStartTitle\" class=\"small_cnt\">" . $fluconazoleMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19036\" id=\"fluconazoleStartMm\"  name=\"fluconazoleStartMm\" class=\"small_cnt\" " .
           getData ("fluconazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19037\" id=\"fluconazoleStartYy\" name=\"fluconazoleStartYy\" class=\"small_cnt\" " .
           getData ("fluconazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"fluconazoleStopTitle\">
       <td>
         <input tabindex=\"19038\" id=\"fluconazoleStopMm\" name=\"fluconazoleStopMm\" class=\"small_cnt\" " .
           getData ("fluconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19039\" id=\"fluconazoleStopYy\" name=\"fluconazoleStopYy\" class=\"small_cnt\" " .
           getData ("fluconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"fluconazoleContinuedTitle\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19040\" id=\"fluconazoleContinued\" name=\"fluconazoleContinued\" " . getData ("fluconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"ketaconazoleStartTitle\" class=\"small_cnt\">" . $ketaconazoleMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"19041\" id=\"ketaconazoleStartMm\" name=\"ketaconazoleStartMm\" class=\"small_cnt\" " .
           getData ("ketaconazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19042\" id=\"ketaconazoleStartYy\" name=\"ketaconazoleStartYy\" class=\"small_cnt\" " .
           getData ("ketaconazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ketaconazoleStopTitle\" />
       <td>
         <input tabindex=\"19043\" id=\"ketaconazoleStopMm\" name=\"ketaconazoleStopMm\" class=\"small_cnt\" " .
           getData ("ketaconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19044\" id=\"ketaconazoleStopYy\" name=\"ketaconazoleStopYy\" class=\"small_cnt\" " .
           getData ("ketaconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ketaconazoleContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19045\" id=\"ketaconazoleContinued\" name=\"ketaconazoleContinued\" " . getData ("ketaconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"traditionalStartTitle\" class=\"small_cnt\">" . $traditionalStartMm[$lang][0] . "</td>
       <td>
         <input tabindex=\"19046\" id=\"traditionalStartMm\" name=\"traditionalStartMm\" class=\"small_cnt\" " .
           getData ("traditionalStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19047\" id=\"traditionalStartYy\" name=\"traditionalStartYy\" class=\"small_cnt\" " .
           getData ("traditionalStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"traditionalStopTitle\" />
       <td>
         <input tabindex=\"19048\" id=\"traditionalStopMm\" name=\"traditionalStopMm\" class=\"small_cnt\" " .
           getData ("traditionalStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19049\" id=\"traditionalStopYy\" name=\"traditionalStopYy\" class=\"small_cnt\" " .
           getData ("traditionalStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"traditionalContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19050\" id=\"traditionalContinued\" name=\"traditionalContinued\" " . getData ("traditionalContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $other1Text[$lang][1] .
         " <input tabindex=\"19051\" name=\"other3Text\" class=\"small_cnt\" " .
             getData ("other3Text", "text") .
             " type=\"text\" size=\"20\" maxlength=\"255\"></td>
       <td><table><tr><td  id=\"other3StartTitle\"></td><td>
         <input tabindex=\"19052\" id=\"other3StartMm\" name=\"other3MM\" class=\"small_cnt\" " .
           getData ("other3MM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19053\" id=\"other3StartYy\" name=\"other3YY\" class=\"small_cnt\" " .
           getData ("other3YY", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td id=\"other3StopTitle\" />
       <td>
         <input tabindex=\"19054\" id=\"other3StopMm\" name=\"other3SpMM\" class=\"small_cnt\" " .
           getData ("other3SpMM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"19055\" id=\"other3StopYy\" name=\"other3SpYY\" class=\"small_cnt\" " .
           getData ("other3SpYY", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"other3ContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"19056\" id=\"other3Continued\" name=\"other3Continued\" " . getData ("other3Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>";
   echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"include/arvs.js\"></script>";
?>
