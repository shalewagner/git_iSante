<?php


echo "
<div id=\"pane_reference\">
	<table width=\"100%\">
	  <tr>
	   <td>
	    <table width=\"100%\">
         <tr>
          <td colspan=\"3\" class=\"s_header\">" . $referSelf[$lang][0] . "</td>
         </tr>
		 <tr>
          <td colspan=\"3\">&nbsp;</td>
         </tr>
         <tr>
		  <td width=\"50%\"><input tabindex=\"".($tab++)."\" name=\"referHosp\" " .getData ("referHosp", "checkbox") .   " type=\"checkbox\" value=\"On\">" . $referHosp[$lang][1] ."
		  </td>
		  <td><input tabindex=\"".($tab++)."\" name=\"referOutpatStd\" " . getData ("referOutpatStd", "checkbox") . " type=\"checkbox\" value=\"On\">" .  $referOutpatStd[$lang][1] . "
		  </td>    
		 </tr>
		 <tr>
		  <td><input tabindex=\"".($tab++)."\" name=\"referVctCenter\" " .  getData ("referVctCenter", "checkbox") ." type=\"checkbox\" value=\"On\">" .$referVctCenter[$lang][1] . "
		  </td>
		  <td><input tabindex=\"".($tab++)."\" name=\"referCommunityBasedProg\" " . getData ("referCommunityBasedProg", "checkbox") ." type=\"checkbox\" value=\"On\">" . $referCommunityBasedProg[$lang][1] . "</td>
		 </tr>
         <tr> 
		  <td rowspan=\"2\"><input tabindex=\"".($tab++)."\" name=\"referPmtctProg\" " .	getData ("referPmtctProg", "checkbox") ." type=\"checkbox\" value=\"On\">" . $referPmtctProg[$lang][1] . "
		  </td>
		  <td><span id=\"transferInTitle\"></span><input tabindex=\"".($tab++)."\" id=\"transferIn\" name=\"transferIn\" " .getData ("transferIn", "checkbox") . " type=\"checkbox\" value=\"On\">" . $transferIn[$lang][1] ."		  </td>
		 </tr>
		 <tr>
		  <td><span id=\"firstCareOtherFacTextTitle\"></span>&nbsp;&nbsp;&nbsp;&nbsp;" . $firstCareOtherFacText[$lang][1] . "&nbsp;<input tabindex=\"".($tab++)."\" id=\"firstCareOtherFacText\" name=\"firstCareOtherFacText\" " . getData ("firstCareOtherFacText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\">
		  </td>
	 </tr>
	 <tr>
		<td> &nbsp;</td>
			  <td id=\"firstCareOtherDtTitle\">&nbsp;&nbsp;&nbsp;&nbsp;" . $refEstablishDt[$lang][0] . "</td>
	</tr>
	<tr><td>&nbsp;</td>
			  <td>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input tabindex=\"".($tab++)."\" id=\"firstCareOtherDt\" name=\"firstCareOtherDt\"  value=\"" . getData ("firstCareOtherDd", "textarea") . "/". getData 
("firstCareOtherMm", "textarea") ."/". getData ("firstCareOtherYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\">
			   <input id=\"firstCareOtherDd\" name=\"firstCareOtherDd\" " . getData ("firstCareOtherDd", "text") . " type=\"hidden\">
			   <input id=\"firstCareOtherMm\" name=\"firstCareOtherMm\" " . getData ("firstCareOtherMm", "text") . " type=\"hidden\">
			   <input id=\"firstCareOtherYy\" name=\"firstCareOtherYy\" " . getData ("firstCareOtherYy", "text") . " type=\"hidden\">
			  </td>
		 </tr>
		</table>
       </td>
      </tr>
	 </table>
	</td>
   </tr>
  </table>
 </div>";

?>
