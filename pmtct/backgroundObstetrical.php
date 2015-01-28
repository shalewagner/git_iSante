<?php

echo "
 <div id=\"pane_backgroundObstetrical\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $antecedents_subhead[$lang][0] . "</td>
      </tr>
	 <tr>
		<td>
			<table width=\"100%\">
				<tr>
					<td width=\"15%\">". $added_antecedents[$lang][12] ."	</td>
					<td width=\"10%\"><input type=\"radio\" ".getData("puberty", "radio", 1) ." tabindex=\"". ($tab++) . "\" name=\"puberty\" value=\"1\"> ". $added_antecedents[$lang][8] ."</td>
					<td width=\"10%\"><input type=\"radio\"  ".getData("puberty", "radio", 2) ." tabindex=\"". ($tab++) . "\" name=\"puberty\" value=\"2\"> ". $added_antecedents[$lang][13] ."</td>
					<td width=\"10%\"><input type=\"radio\"  ".getData("puberty", "radio", 4) ." tabindex=\"". ($tab++) . "\" name=\"puberty\" value=\"4\"> ". $added_antecedents[$lang][14] ."</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>

	  <tr>
	   <td valign=\"bottom\">
	    <table width=\"100%\">
		 <tr>
		  <td width=\"10%\" id=\"mensAgeTitle\">" . $antecedents_section[$lang][7] . "</td>
		  <td width=\"10%\">
			<input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"mensAge\" name=\"mensAge\" size=\"8\" ".getData ("mensAge", "text")."  />
	      </td>
		  <td width=\"25%\" align=\"right\" id=\"beginSexTitle\">" . $antecedents_section[$lang][8] . "</td>
		  <td>
		   <input tabindex=\"". ($tab++) . "\" id=\"beginSex\" type=\"text\"  name=\"beginSex\" size=\"8\"  ".getData ("beginSex", "text")." />
	      </td>
		
			<td id=\"mensDurationTitle\">
				" . $added_antecedents[$lang][0] . " </td><td>
				<input type=\"text\" tabindex=\"". ($tab++) . "\" size=\"8\" id=\"mensDuration\" name=\"mensDuration\"  
".getData("mensDuration", "text") ."  >
			</td>

			<td id=\"mensCycleTitle\">
				" . $added_antecedents[$lang][1] . " </td><td>
				<input type=\"text\" tabindex=\"". ($tab++) . "\" size=\"8\" id=\"mensCycle\" name=\"mensCycle\" 
".getData("mensCycle", "text") ." />
			</td>
		 </tr>
		</table>
	   </td>
	  </tr>


	<tr>
		<td><table width=\"100%\">
			<td>
				<table width=\"100%\">
					<tr>
						<td id=\"\" width=\"20%\"> " . $added_antecedents[$lang][2]  ."  </td>
						<td width=\"20%\" style=\"text-alignment:left;\"><input type=\"radio\" ".getData("dysmenhoree", "radio",1) ." tabindex=\"". 
($tab++) . "\" 
name=\"dysmenhoree\" 
value=\"1\" > " . 
$generalOption[$lang][1] . "
						<input type=\"radio\" ".getData("dysmenhoree", "radio",2) ." tabindex=\"". ($tab++) . "\" name=\"dysmenhoree\" value=\"2\" > " . 
$generalOption[$lang][0] . "
						</td>
						<td> " . $added_antecedents[$lang][3]  ."  </td> 
						<td> <input type=\"radio\" ".getData("yesDysmenhoree", "radio",1) ." tabindex=\"". ($tab++) . "\" name=\"yesDysmenhoree\" 
value=\"1\" > 
" . $added_antecedents[$lang][4] . "
						     <input type=\"radio\" ".getData("yesDysmenhoree", "radio",2) ." tabindex=\"". ($tab++) . "\" name=\"yesDysmenhoree\" 
value=\"2\" > 
" . $added_antecedents[$lang][5] . "
					</tr>
				</table>
			</td>



		</table></td>
	</tr>


	  <tr>
	   <td>
	    <table width=\"100%\">
		 <tr>
		  <td width=\"15%\" id=\"pregnantDDRDtTitle\">".$antecedents_section[$lang][15] ."</td>
	      <td width=\"15%\">
		   <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"pregnantDDRDt\" name=\"pregnantDDRDt\" size=\"8\" value=\"" . getData ("pregnantDDRDd", "textarea") . 
"/". getData ("pregnantDDRMm", "textarea") ."/". getData ("pregnantDDRYy", "textarea") . "\" />
		   <input type=\"hidden\" id=\"pregnantDDRYy\" name=\"pregnantDDRYy\" " . getData ("pregnantDDRYy", "text") . "/>
		   <input type=\"hidden\" id=\"pregnantDDRMm\" name=\"pregnantDDRMm\" " . getData ("pregnantDDRMm", "text") . "/>
		   <input type=\"hidden\" id=\"pregnantDDRDd\" name=\"pregnantDDRDd\" " . getData ("pregnantDDRDd", "text") . "/>
		  </td>
	      <td width=\"20%\" id=\"largePosTestDtTitle\" align=\"right\">".$antecedents_section[$lang][16] ."</td>
	      <td width=\"15%\"><input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"largePosTestDt\" name=\"largePosTestDt\" size=\"8\"  value=\"" . getData ("largePosTestDd", 
"textarea") . "/". getData ("largePosTestMm", "textarea") ."/". getData ("largePosTestYy", "textarea") . "\"/>
		   <input type=\"hidden\" id=\"largePosTestYy\" name=\"largePosTestYy\" " . getData ("largePosTestYy", "text") . "/>
		   <input type=\"hidden\" id=\"largePosTestMm\" name=\"largePosTestMm\" " . getData ("largePosTestMm", "text") . "/>
		   <input type=\"hidden\" id=\"largePosTestDd\" name=\"largePosTestDd\" " . getData ("largePosTestDd", "text") . "/>
		  </td>
	      <td width=\"10%\" align=\"right\" id=\"DPADtTitle\">".$antecedents_section[$lang][17] ."</td>
	      <td width=\"25%\" align=\"left\"><input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"DPADt\" name=\"DPADt\" size=\"8\" value=\"" . getData ("DPADd", 
"textarea") 
. "/". 
getData ("DPAMm", "textarea") ."/". getData ("DPAYy", "textarea") . "\">
		   <input type=\"hidden\" id=\"DPAYy\" name=\"DPAYy\" " . getData ("DPAYy", "text") . "/>
		   <input type=\"hidden\" id=\"DPAMm\" name=\"DPAMm\" " . getData ("DPAMm", "text") . "/>
		   <input type=\"hidden\" id=\"DPADd\" name=\"DPADd\" " . getData ("DPADd", "text") . "/>
		  </td>
		 </tr>
		</table>
	   </td>
	  </tr>
	






	  <tr>
	   <td >
		   <table>
		    <tr>
			 <td id=\"gravidaTitle\" >" . $antecedents_section[$lang][0] . "
			 </td>
			 <td  align=\"center\">
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"gravida\"  name=\"gravida\" size=\"8\" maxsize=\"8\" " . getData ("gravida", "text") . " />
			 </td>
			 <td id=\"paraTitle\">" . $antecedents_section[$lang][1] . "
			 </td>
			 <td>
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"para\" name=\"para\" size=\"8\" maxsize=\"8\" " . getData ("para", "text") . " />
			 </td>
			 <td id=\"abortaTitle\">" . $antecedents_section[$lang][2] . "
			 </td>
			 <td>
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"aborta\" name=\"aborta\" size=\"8\" maxsize=\"8\" " . getData ("aborta", "text") . " />
			 </td>
			 <td id=\"mortFoetalTitle\">" . $antecedents_section[$lang][3] . "
			 </td>
			 <td>
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"mortFoetal\" name=\"mortFoetal\" size=\"8\" maxsize=\"8\" " . getData ("mortFoetal", "text") . " 
/>
			 </td>
			 <td id=\"fulltimePregTitle\">" . $antecedents_section[$lang][4] . "
			 </td>
			 <td>
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"fulltimePreg\" name=\"fulltimePreg\" size=\"8\" maxsize=\"8\" " . getData ("fulltimePreg", 
"text") . " />
			 </td>
			 <td id=\"prematurityTitle\">" . $antecedents_section[$lang][5] . "
			 </td>
			 <td>
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"prematurity\" name=\"prematurity\" size=\"8\" maxsize=\"8\" " . getData ("prematurity", "text") . 
" />
			 </td>
			 <td id=\"ectPregTitle\">" . $antecedents_section[$lang][6] . "
			 </td>
			 <td>
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"ectPreg\" name=\"ectPreg\" size=\"8\" maxsize=\"8\" " . getData ("ectPreg", "text") . " />
			 </td>

			 <td id=\"liveChildTitle\">" . $antecedents_section[$lang][19] . "
			 </td>

			 <td> <!-- ADD TO DB -->
						
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"liveChilds\" name=\"liveChilds\" size=\"8\" maxsize=\"8\" " . getData ("liveChilds", "text") . " />
			 </td>
			</tr>
		   </table>


		<table>
			<tr><td id=\"menopauseTitle\">
				" . $added_antecedents[$lang][6] . "</td>
				<td><input type=\"radio\" ".getData("menopause", "radio",1) ." tabindex=\"". ($tab++) . "\" name=\"menopause\" value=\"1\"/> ". 
$generalOption[$lang][0] ." </td>
				<td><input type=\"radio\" ".getData("menopause", "radio",2) ." tabindex=\"". ($tab++) . "\" name=\"menopause\" value=\"2\"/> ". 
$generalOption[$lang][1] ." </td>
				<td id=\"menopauseAgeTitle\" >" . $added_antecedents[$lang][7] . "</td>
				<td><input type=\"text\" ".getData("menopauseAge", "text") ." tabindex=\"". ($tab++) . "\" id =\"menopauseAge\" name=\"menopauseAge\" />  </td>

			</tr>


			

		</table>





		<table><tr>
		  <td>
		   <b>" . $antecedents_section[$lang][18] . "</b>
		  </td>
		 </tr>
		 <tr>
		  <td>
		   <table width=\"100%\">
		    <tr>
			 <td > 
			  " . $antecedents_section[$lang][9] . "
			 </td>
		     <td >
			  <input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"papTest0\" name=\"papTest[]\" " . getData ("papTest", "checkbox","1") . " value=\"1\"/>" . 
$generalOption[$lang][0] . " 
			 </td>
		     <td >
			  <input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"papTest1\" name=\"papTest[]\" " . getData ("papTest", "checkbox","2") . " value=\"2\" />" . 
$generalOption[$lang][1] . " 
             	     </td>
	         <td >
			  <input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"papTest2\" name=\"papTest[]\" " . getData ("papTest", "checkbox","4") . " value=\"4\" />" . 
$generalOption[$lang][2] . " 
			 </td>
			 <td width=\"35%\">&nbsp;
			 </td>
		    </tr>
		   </table>
		  </td>
		 </tr>
		 <tr>
		  <td>
		   <table width=\"100%\">
		    <tr>
			 <td width=\"20%\">" . $antecedents_section[$lang][10] . " </td>
			 <td width=\"15%\"><input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"papAnml0\" name=\"papAnml\" " . getData ("papAnml", "radio","1") . " value=\"1\"/>" . $added_antecedents[$lang][8] . " </td>
			 <td width=\"15%\"><input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"papAnml1\" name=\"papAnml\" " . getData ("papAnml", "radio","2") . " value=\"2\"/>" . $added_antecedents[$lang][9] . " </td>
			 <td width=\"15%\"><input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"papAnml2\" name=\"papAnml\" " . getData ("papAnml", "radio","4") . " value=\"4\"/>" . $generalOption[$lang][2] . " </td>
			</tr>
		   </table>
		  </td>
		 </tr>
		 <tr>
		  <td>
		   <table width=\"100%\">
		    <tr>
			 <td  id=\"papTestDtTitle\">" . $antecedents_section[$lang][11] . " </td>
			 <td >
			  <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"papTestDt\" name=\"papTestDt\" size=\"8\" maxsize=\"8\"  value=\"" . getData ("papTestDd", 
"textarea") . "/". getData ("papTestMm", "textarea") ."/". getData ("papTestYy", "textarea") . "\"/>
			  <input type=\"hidden\" id=\"papTestYy\" name=\"papTestYy\" " . getData ("papTestYy", "text") . "/>
			  <input type=\"hidden\" id=\"papTestMm\" name=\"papTestMm\" " . getData ("papTestMm", "text") . "/>
			  <input type=\"hidden\" id=\"papTestDd\" name=\"papTestDd\" " . getData ("papTestDd", "text") . "/>
		     </td>
			</tr>
		   </table>
		  </td>
		 </tr>
		 <tr>
		  <td>
		   <table width=\"100%\">
		    <tr>
			 <td >" . $antecedents_section[$lang][12] . "</td>
			 <td ><input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"papTestResult\" name=\"papTestResult\" size=\"8\" maxsize=\"8\" " . getData ("papTestResult", 
"text") . " /></td>			  
	        </tr>
		   </table>
		  </td>
		 </tr>
		


		 <tr>
		  <td>
			<table>
				<tr><td> " . $added_antecedents[$lang][11]  . "</td></tr>
				<tr><td>" . $added_antecedents[$lang][15]  . "</td><td><input type=\"radio\" ".getData("mammograph", "radio","1") ." tabindex=\"". ($tab++) . "\" 
name=\"mammograph\" value=\"1\" /> " 
.$generalOption[$lang][0] ." </td>
					<td><input type=\"radio\" ".getData("mammograph", "radio","2") ." tabindex=\"". ($tab++) . "\" name=\"mammograph\" value=\"2\" /> " 
.$generalOption[$lang][1] ." </td>
					<td><input type=\"radio\"  ".getData("mammograph", "radio","4") ." tabindex=\"". ($tab++) . "\" name=\"mammograph\" value=\"4\" /> " 
.$generalOption[$lang][2] ." </td>
					<td id=\"mammographDtTitle\">&nbsp;&nbsp;</td>
					<td> " . $added_antecedents[$lang][16]  . "</td><td><input type=\"text\" tabindex=\"". ($tab++) . "\" 
id=\"mammographDt\" name=\"mammographDt\" size=\"8\" maxsize=\"8\" value=\"" . getData ("mammographDd",
"textarea") . "/". getData ("mammographMm", "textarea") ."/". getData ("mammographYy", "textarea") . "\" />

			<input type=\"hidden\" id=\"mammographYy\" name=\"mammographYy\" " . getData ("mammographYy", "text") . "/>
			<input type=\"hidden\" id=\"mammographMm\" name=\"mammographMm\" " . getData ("mammographMm", "text") . "/>
			<input type=\"hidden\" id=\"mammographDd\" name=\"mammographDd\" " . getData ("mammographDd", "text") . "/>

	



</td></tr>


				<tr><td>" . $added_antecedents[$lang][17]  . "</td><td><input type=\"radio\"  ".getData("palpation", "radio",1) ." tabindex=\"". ($tab++) . "\" 
name=\"palpation\" value=\"1\" /> " 
.$generalOption[$lang][0] ." </td>
					<td><input type=\"radio\"  ".getData("palpation", "radio",2) ." tabindex=\"". ($tab++) . "\" name=\"palpation\" value=\"2\" /> " 
.$generalOption[$lang][1] ." </td>
					<td><input type=\"radio\"  ".getData("palpation", "radio",4) ." tabindex=\"". ($tab++) . "\" name=\"palpation\" value=\"4\" /> " 
.$generalOption[$lang][2] ." </td>
					<td>&nbsp;&nbsp;</td>
					<td id=\"palpationDtTitle\"> " . $added_antecedents[$lang][18]  . "</td><td><input  value=\"" . getData ("palpationDd","textarea") . "/". getData 
("palpationMm", "textarea") ."/". getData ("palpationYy", "textarea") . "\" type=\"text\" tabindex=\"". ($tab++) . "\" name=\"palpationDt\" id=\"palpationDt\"  size=\"8\" 
maxsize=\"8\" />



					<input type=\"hidden\" id=\"palpationYy\" name=\"palpationYy\" " . getData ("palpationYy", "text") . "/>
					<input type=\"hidden\" id=\"palpationMm\" name=\"palpationMm\" " . getData ("palpationMm", "text") . "/>
					<input type=\"hidden\" id=\"palpationDd\" name=\"palpationDd\" " . getData ("palpationDd", "text") . "/>



					</td></tr>

			</table>
	   </td>
	  </tr>
	 </table>
    </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
  </table>
 </div>";

?>
