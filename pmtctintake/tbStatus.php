<?php

echo "
<div id=\"pane_TbStatus\">
  <table width=\"100%\">
<!-- ******************************************************************** -->
<!-- **************************** TB Status ***************************** -->
<!-- ******************************************************************** -->
   
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
      <td id=\"tbStatusTitle\" class=\"s_header\" colspan=\"5\">" . $tb_header[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td colspan=\"1\"><span id=\"asymptomaticTbTitle\"></span> <input tabindex=\"" . ($tab++) . "\" id=\"asymptomaticTb[]\" name=\"tbStatus[]\" " .getData ("tbStatus", 
"radio","1") 
. " type=\"radio\" 
title=\"true\" value=\"1\">"." <input type=\"hidden\" id =\"asymptomaticTb\"  name =\"asymptomaticTb\" " .  getData ("asymptomaticTb", "text") ." />". $noPreTB[$lang][0] . "</td>
	   <td colspan=\"4\"> <span id=\"contactTBTitle\"></span><input tabindex=\"" . ($tab++) . "\" id=\"contactTB[]\" name=\"tbStatus[]\" ".getData("tbStatus","radio",2)." 
title=\"true\" type=\"radio\" value=\"2\">"."<input type=\"hidden\" id =\"contactTB\" name =\"contactTB\" " .  getData ("contactTB", "text") ." />" . $noPreTB[$lang][1] . "</td>
	  </tr>
	  <tr>
	   <td> <span id=\"completeTreatTitle\"></span><input tabindex=\"" . ($tab++) . "\" id=\"completeTreat[]\" name=\"tbStatus[]\" " .  getData ("tbStatus", "radio","4") . " 
type=\"radio\" title=\"true\" 
value=\"4\">"."<input type=\"hidden\" id =\"completeTreat\"  name =\"completeTreat\" " .  getData ("completeTreat", "text") ." />" .  $completeTreat[$lang][1] . "</td>
	   <td><span id=\"ppd6mosTitle\"></span><input tabindex=\"" . ($tab++) . "\" id=\"ppd6mos[]\" name=\"tbStatus[]\"  ".getdata("tbStatus","radio",8)." type=\"radio\" 
title=\"true\" value=\"8\">"."<input type=\"hidden\" id =\"ppd6mos\"  name =\"ppd6mos\" " .  getData ("ppd6mos", "text") ." />" .  $ppd6mos[$lang][1] . "</td>
	   <td id=\"ppdDtTitle\"> If yes, date </td>
		<td style=\"padding-top:.5em;\"><input type=\"text\" value=\"" . getData ("ppdDd","textarea") . "/". getData ("ppdMm", "textarea") ."/". getData ("ppdYy", "textarea") . "\" id=\"ppdDt\" tabindex=\"" . ($tab++) . "\" name=\"ppdDt\" size=\"10\" />
		<input type=\"hidden\" id=\"ppdYy\" name=\"ppdYy\" " . getData ("ppdYy", "text") . "/>
		<input type=\"hidden\" id=\"ppdMm\" name=\"ppdMm\" " . getData ("ppdMm", "text") . "/>
		<input type=\"hidden\" id=\"ppdDd\" name=\"ppdDd\" " . getData ("ppdDd", "text") . "/>
	   </td>

	  </tr>
	  <tr>
	      <td id=\"completeTreatDtTitle\" class=\"inlineblock\"> " . $completeTreatMm[$lang][0] . "</td>
              <td class=\"inlineblock\"><input tabindex=\"" . ($tab++) . "\" id=\"completeTreatDt\" name=\"completeTreatDt\"  value=\"" . getData ("completeTreatDd", "textarea") . "/". getData ("completeTreatMm", "textarea") ."/". getData ("completeTreatYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\">
	       <input id=\"completeTreatDd\" name=\"completeTreatDd\" " . getData ("completeTreatDd", "text") . " type=\"hidden\">
		<input id=\"completeTreatMm\" name=\"completeTreatMm\" " . getData ("completeTreatMm", "text") . " type=\"hidden\">
		<input id=\"completeTreatYy\" name=\"completeTreatYy\" " . getData ("completeTreatYy", "text") . " type=\"hidden\">
	   </td>

	   <td id=\"completeTreatFacTitle\">" . $completeTreatFac[$lang][1] . "</td>
	   <td>
	    <input tabindex=\"" . ($tab++) . "\" id=\"completeTreatFac\" name=\"completeTreatFac\" " . getData ("completeTreatFac", "text") . " type=\"text\" size=\"30\" maxlength=\"255\">
	   </td>
	  </tr>

	<tr><td> " .  $treatDuration[$lang][1] . "
	    <input tabindex=\"" . ($tab++) . "\" id=\"completeTreatDur\" name=\"completeTreatDur\"  " . getData("completeTreatDur","text")."type=\"text\" size=\"3\" maxlength=\"2\"> 
	    </td>
	</tr>

	  <tr>
	   <td><span id=\"currentTreatTitle\"></span><input tabindex=\"" . ($tab++) . "\" id=\"currentTreat[]\" name=\"tbStatus[]\" " . getData ("tbStatus", "radio","16") .  " 
type=\"radio\" 
title=\"true\" value=\"16\">"."<input type=\"hidden\" id =\"currentTreat\"  name =\"currentTreat\" " .  getData ("currentTreat", "text") ." />" .$currentTreat[$lang][1] . "</td>
	</tr><tr>
       <td id=\"currentTreatNoTitle\" class=\"inlineblock\">" . $currentTreatNo[$lang][1] . "</td>
	   <td><input tabindex=\"" . ($tab++) . "\" id=\"currentTreatNo\" name=\"currentTreatNo\" " . getData ("currentTreatNo", "text") . " type=\"text\" size=\"30\" maxlength=\"64\"></td>    
	   <td id=\"currentTreatFacTitle\" >" . $currentTreatFac[$lang][1] . "</td>
	   <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"currentTreatFac\" name=\"currentTreatFac\" " . getData ("currentTreatFac", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>          
	  </tr>


	<tr><td id=\"treatInitiationDtTitle\"> " .  $treatInitiation[$lang][1] . "
	    <input tabindex=\"" . ($tab++) . "\" id=\"treatInitiationDt\" name=\"treatInitiationDt\" value=\"" . getData ("treatInitiationDd","textarea") . "/". getData ("treatInitiationMm", "textarea") ."/". 
getData ("treatInitiationYy", "textarea") . "\"
type=\"text\" size=\"10\" maxlength=\"10\"> 

		<input type=\"hidden\" id=\"treatInitiationYy\" name=\"treatInitiationYy\" " . getData ("treatInitiationYy", "text") . "/>
		<input type=\"hidden\" id=\"treatInitiationMm\" name=\"treatInitiationMm\" " . getData ("treatInitiationMm", "text") . "/>
		<input type=\"hidden\" id=\"treatInitiationDd\" name=\"treatInitiationDd\" " . getData ("treatInitiationDd", "text") . "/>

	    </td>
	</tr>
     </table>
    </td>
   </tr>
  </table>
</div>
";
?>
