<?php
 



$formName = "";
fb($eid,"eid in psychForm");


$lang = $_GET["lang"];

fb($_POST, "post in psychform/0");
fb($lang);


echo "

<div class=\"formArea\">


  <table class=\"header\">
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"8\" width=\"100%\">" . $householdComp_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\" width=\"25%\">" . $householdComp_householdName[$lang][1] . "</td>
       <td class=\"sm_header_lt\" width=\"10%\">" . $householdComp_householdAge[$lang][1] . "</td>
       <td class=\"sm_header_lt\" width=\"20%\">" . $householdComp_householdRel[$lang][1] . "</td>
       <td rowspan=\"" . ($max_householdComp + 1) . "\" width=\"5%\">&nbsp;</td>
       <td class=\"sm_header_lt\" width=\"20%\">" . $householdComp_hivStatus[$lang][0] . "</td>
       <td rowspan=\"" . ($max_householdComp + 1) . "\" class=\"vert_line\">&nbsp;</td>
       <td rowspan=\"" . ($max_householdComp + 1) . "\" width=\"5%\">&nbsp;</td>
       <td class=\"sm_header_lt\" width=\"15%\">" . $householdComp_disclosure[$lang][0] . "</td>
      </tr>" . houseCompCols ($max_householdComp, 2001) . "
     </table>
";


	$sectionName = "HouseHold";


$sectionName = "domiciliaire";
?>

	
</tr></td>

<tr><td>

<table  class="b_header_nb">
	<tr>
		<td class="s_header" colspan="5">
			<?=$community[$lang][0]?>
		</td>	
	</tr>
	<tr> 
		<td colspan="5">
			<?=$community[$lang][1]?><br>
			<textarea cols="100" rows="5" name="PtHouseDirs" ><?= getData("PtHouseDirs", "textarea") ?></textarea>
		</td>
	</tr>
</table>
</tr></td>

<tr><td>
<table  class="b_header_nb">
	<tr>
		<td class="s_header" colspan="5">
			<?=$HIVStatus[$lang][0]?>
		</td>	
	</tr>
	<tr> 
		<td width="30%">
			<?=$HIVStatus[$lang][1]?>
			
		</td>
		<td>
		  <input type="radio" value="1" name="infectionKnowl[]" <?= getData("infectionKnowl", "radio", 1)?> /> <?=$yesNo[$lang][0]?>
  		  <input type="radio" value="2" name="infectionKnowl[]" <?= getData("infectionKnowl", "radio", 2)?> /> <?=$yesNo[$lang][1]?>
		  <input type="radio" value="4" name="infectionKnowl[]" <?= getData("infectionKnowl", "radio", 4)?> /> <?=$yesNo[$lang][2]?>
		</td>
	</tr>
	<tr>
		<td> <?=$HIVStatus[$lang][2]?></td><td> <input type="text" size="50" name="infectionKnowlReason" <?=getData("infectionKnowlReason", "text")?> /></td>
	</tr>

	<tr> 
		<td>
			<?=$HIVStatus[$lang][3]?>
			
		</td>
		<td>
		  <input type="radio" value="1" name="antecedentsOfDisease[]" <?=getData("antecedentsOfDisease", "radio", 1)?> /> <?=$yesNo[$lang][0]?> <input type="text" 
name="antecedentsOfDiseaseText" <?= getData("antecedentsOfDiseaseText", "text")?> />
  		  <input type="radio" value="2" name="antecedentsOfDisease[]" <?=getData("antecedentsOfDisease", "radio", 2)?> /> <?=$yesNo[$lang][1]?>
		</td>
	</tr>

	<tr> 
		<td>
			<?=$HIVStatus[$lang][4]?>
			
		</td>
		<td>
		  <input type="radio" value="1" name="disbeliefStatusResult[]" <?= getData("disbeliefStatusResult", "radio", 1)?> /> <?=$yesNo[$lang][0]?> 
  		  <input type="radio" value="2" name="disbeliefStatusResult[]" <?= getData("disbeliefStatusResult", "radio", 1)?> /> <?=$yesNo[$lang][1]?>
		</td>
	</tr>

	<tr> 
		<td>
			<?=$HIVStatus[$lang][5]?>
			
		</td>
		<td>
			<input type="text" size="50" maxlength="500" name="majorHealthProblems" <?= getData("majorHealthProblems", "text") ?> />
		</td>
	</tr>


	<tr> 
		<td>
			<?=$HIVStatus[$lang][6]?>
			
		</td>
		<td>
		  <input type="radio" value="1" name="refuseToDiscussDisease[]" <?=getData("refuseToDiscussDisease", "radio", 1)?> /> <?=$yesNo[$lang][0]?> 
  		  <input type="radio" value="2" name="refuseToDiscussDisease[]" <?=getData("refuseToDiscussDisease", "radio", 2)?> /> <?=$yesNo[$lang][1]?>
		</td>
	</tr>


</table>
</tr></td>


<tr><td>

	<table  class="b_header_nb">
		<tr>
			<td class="s_header" colspan=5>
				<?= $socioFamily[$lang][0] ?>
			</td>	
		</tr>

		<tr>
			<td> <?= $socioFamily[$lang][1]?></td>
			<td> <input type="radio"  name="childDelivery[]" value="1" <?= getData("childDelivery", "radio", 1)?> > <?=$yesNo[$lang][0]?> <input type="radio" 
name="childDelivery[]" value="2" <?= getData("childDelivery", "radio", 2)?> /> <?=$yesNo[$lang][1]?> <?=$socioFamily[$lang][2]?> <input type="text" size="20" maxlength="200" 
name="childDeliveryMethod" <?= getData("childDeliveryMethod", "text")?> />
		</tr>
		<tr>
			<td> <?= $socioFamily[$lang][3]?> </td>
			<td> <input type="radio" name="childReaction[]" value="1" <?= getData("childReaction", "radio", 1)?> /> <?=$socioFamily[$lang][4]?> 
				<input type="radio" name="childReaction[]" value="2" <?= getData("childReaction", "radio", 2)?> /> 
<?=$socioFamily[$lang][5]?> <input type="radio" name="childReaction[]" value="4" <?= getData("childReaction", "radio", 4)?> /> <?=$socioFamily[$lang][6]?> </td>
		</tr>

		<tr>
			<td> <?= $socioFamily[$lang][7]?> </td>
			<td><input type="radio" name="childMedicationAcceptance[]" value="1" <?= getData("childMedicationAcceptance", "radio", 1)?> /> <?=$yesNo[$lang][0]?> 
<input 
type="radio" name="childMedicationAcceptance[]" value="2" <?= getData("childMedicationAcceptance", "radio", 2)?> /> 
<?=$yesNo[$lang][1]?></td>
		</tr>

		<tr>
			<td> <?= $socioFamily[$lang][8]?> </td>
			<td><input type="radio" name="childAttendsSchool[]" value="1" <?= getData("childAttendsSchool", "radio", 1)?> /> <?=$yesNo[$lang][0]?> <input 
type="radio" name="childAttendsSchool[]" value="2" <?= getData("childAttendsSchool", "radio", 2)?> /> <?=$yesNo[$lang][1]?> 
<?=$socioFamily[$lang][9]?> <input type="text" name="childSchoolClass" <?= getData("childSchoolClass", "text")?> /></td>
		</tr>

		<tr>
			<td> <?= $socioFamily[$lang][10]?> </td>
			<td><input type="text" name="childLivesWith" <?= getData("childLivesWith", "text")?> /></td>
		</tr>

		<tr>
			<td style="vertical-align:top"> <?= $socioFamily[$lang][11]?> </td>
		</tr>
		<tr>
			<td width="40%">
				<?=$socioFamily[$lang][12] ?> <input type="radio" value="1" name="happy[]" <?= getData("happy", "radio", 1)?> /> <?=$yesNo[$lang][0]?> 
<input type="radio" value="2" name="happy[]" <?= getData("happy", "radio", 2)?> /> 
<?=$yesNo[$lang][1]?><br>
				<?=$socioFamily[$lang][13] ?> <input type="radio" value="1" name="confident[]" <?= getData("confident", "radio", 1)?> /> 
<?=$yesNo[$lang][0]?> <input type="radio" value="2" name="confident[]" <?=getData("confident", "radio", 2)?> /> <?=$yesNo[$lang][1]?><br>
				<?=$socioFamily[$lang][14] ?> <input type="radio" value="1" name="introvert[]" <?= getData("introvert", "radio", 1)?> /> <?=$yesNo[$lang][0]?> <input 
type="radio" value="2" 
name="introvert[]" <?= getData("introvert", "radio", 2)?> /> <?=$yesNo[$lang][1]?><br>
			</td><td width="40%">
				<?=$socioFamily[$lang][15] ?> <input type="radio" value="1" name="intravert[]" <?= getData("intravert", "radio", 1)?> /> 
<?=$yesNo[$lang][0]?> 
<input type="radio" value="2" 
name="intravert[]" <?= getData("intravert", "radio", 2)?> /> <?=$yesNo[$lang][1]?><br>
				<?=$socioFamily[$lang][16] ?> <input type="radio" value="1" name="wild[]" <?= getData("wild", "radio", 1)?> /> 
<?=$yesNo[$lang][0]?> 
<input type="radio" value="2" 
name="wild[]" <?= getData("wild", "radio", 2)?> /> <?=$yesNo[$lang][1]?><br>
				<?=$socioFamily[$lang][17] ?> <input type="radio" value="1" name="shy[]" <?= getData("shy", "radio", 1)?> /> <?=$yesNo[$lang][0]?> 
<input type="radio" value="2" name="shy[]" <?= getData("shy", "radio", 2)?> /> 
<?=$yesNo[$lang][1]?><br>

			</td>


		</tr>



	</table>

</tr></td>




<tr><td>
	<table  class="b_header_nb">
		<tr>
			<td class="s_header" colspan=5>
				<?= $familyHealth[$lang][0] ?>
			</td>	
		</tr>

		<tr>
			<td width="30%"><?= $familyHealth[$lang][1] ?></td>
			<td><input type="radio" value="1" name="fatherStatus" <?=getData("fatherStatus", "radio", 1)?> /> <?=$yesNo[$lang][0]?> <input type="radio" value="2" 
name="fatherStatus" <?=getData("fatherStatus", "radio", 2)?> /> 
<?=$yesNo[$lang][1]?>
		</tr>
		<tr>
			<td><?= $familyHealth[$lang][2] ?></td>
			<td><input type="radio" value="1" name="motherStatus" <?=getData("motherStatus", "radio", 1)?> /> <?=$yesNo[$lang][0]?> <input type="radio" value="2" 
name="motherStatus" <?=getData("motherStatus", "radio", 2)?> /> <?=$yesNo[$lang][1]?>
		</tr>

		<tr>
			<td><?= $familyHealth[$lang][3] ?></td>
			<td><input type="radio" value="1" name="parentStatus[]" <?=getData("parentStatus", "radio", 1)?> /> <?=$yesNo[$lang][0]?> <input type="radio" 
value="2" name="parentStatus[]" <?=getData("parentStatus", "radio", 2)?> /> <?=$yesNo[$lang][1]?>
		</tr>


	</table>
</td></tr>
 






<tr><td>

<?php

$sectionName = 'sexualPractices';



?>

<table  class="b_header_nb">
	<tr>
		<td class="s_header" colspan=5>
			<?= $sexualPractices[$lang][0] ?>
		</td>	
	</tr>
	<tr>
		<td width="30%">
			<li> <?= $sexualPractices[$lang][1] ?></li>
		</td>
		<td>
			<input type="radio" name="SexualContact[]" value="1" <?= getData("SexualContact", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> 
			<input type="radio" value="2" <?= getData("SexualContact", "radio", 2) ?>name="SexualContact[]"> <?= $yesNo[$lang][1] ?><br>
		
		</td>
	</tr>
	<tr>
		<td>
			<li> <?= $sexualPractices[$lang][2] ?></li>
		</td>
		<td>
			<input value="1" <?= getData("PartnerType", "radio", 1) ?> type="radio" name="PartnerType[]"> <?= $sexualPractices[$lang][3] ?> 
			<input type="radio" name="PartnerType[]" value="2" <?= getData("PartnerType", "radio", 2) ?>> <?= $sexualPractices[$lang][4] ?> 
			<input type="radio" name="PartnerType[]" value="4" <?= getData("PartnerType", "radio", 4) ?>> <?= $sexualPractices[$lang][5] ?>
		</td>
	</tr>

	<tr>
		<td>
			 <li><?= $sexualPractices[$lang][6] ?></li>
		</td>
		<td>
			<input type="checkbox" name="SexContactType[]" value="1" <?= getData("SexContactType", "checkbox", 1) ?>> <?= $sexualPractices[$lang][7] ?>
			<input value="2" <?= getData("SexContactType", "checkbox", 2) ?> type="checkbox" name="SexContactType[]"> <?= $sexualPractices[$lang][8] ?> 
			<input value="4" <?= getData("SexContactType", "checkbox", 4) ?> type="checkbox" name="SexContactType[]"> <?= $sexualPractices[$lang][9] ?> 
			<input value="8" <?= getData("SexContactType", "checkbox", 8) ?> type="checkbox" name="SexContactType[]"> <?= $sexualPractices[$lang][10] ?>
			<input type="checkbox" name="SexContactType[]" value="16" <?= getData("SexContactType", "checkbox", 16) ?>> <?= $sexualPractices[$lang][11] ?>
		</td>
	</tr>
	
	<tr>
		<td>
		<li> <?= $sexualPractices[$lang][12] ?><br>
					<?= $sexualPractices[$lang][13] ?><br>
					<?= $sexualPractices[$lang][14] ?></li>
				
		</td>
		<td>
			<br><input type="radio" value="1" <?= getData("SexLast3Mos", "radio", 1) ?> name="SexLast3Mos[]"> <?= $yesNo[$lang][0] ?> 
			<input type="radio" name="SexLast3Mos[]" value="2" <?= getData("SexLast3Mos", "radio", 2) ?>> <?= $yesNo[$lang][1] ?> 
			<input type="radio" name="SexLast3Mos[]" value="4" <?= getData("SexLast3Mos", "radio", 4) ?>> <?= $yesNo[$lang][2] ?>

			<br><input type="radio" name="SexLast3MosNoProt[]" value="1" <?= getData("SexLast3MosNoProt", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> 
			<input type="radio" name="SexLast3MosNoProt[]" value="2" <?= getData("SexLast3MosNoProt", "radio", 2) ?>> <?= $yesNo[$lang][1] ?> 
			<input type="radio" name="<? echo $formName  ?>SexLast3MosNoProt[]" value="4" <?= getData("SexLast3MosNoProt", "radio", 4) ?>> <?= $yesNo[$lang][2] ?>		
		</td>
	</tr>
	
	<tr>
		<td>
			<li> <?= $sexualPractices[$lang][15] ?></li>
		</td>
		<td>
			<input type="radio" name="ProtectionTrouble[]" value="1" <?= getData("ProtectionTrouble", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> 
<input 
type="radio" name="<? echo 
$formName ?>ProtectionTrouble[]" value="2" <?= getData("ProtectionTrouble", "radio", 2) ?>> <?= $yesNo[$lang][1] ?>
		</td>
	</tr>
	
	<tr>
		<td>
			<li> <?= $sexualPractices[$lang][16] ?></li>
		</td>
		<td>
			<input type="radio" name="SexAgresVictim[]" value="1" <?= getData("SexAgresVictim", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> <input type="radio" name="<? echo 
$formName ?>SexAgresVictim[]" value="2" <?= getData("SexAgresVictim", "radio", 2) ?>> <?= $yesNo[$lang][1] ?> 
<br>
			<?= $sexualPractices[$lang][17] ?> <input type="text" cols="20" rows="4" name="SexAgresVictimText" <?= getData("SexAgresVictimText","text")?> />
		</td>
	</tr>
	<tr>
		<td>
			<li> <?= $sexualPractices[$lang][18] ?></li>
		</td>
		<td>
			<input type="radio" name="SexualInfections[]" value="1" <?= getData("SexualInfections", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> <input type="radio" name="<? echo 
$formName ?>SexualInfections[]" value="2" <?= getData("SexualInfections", "radio", 2) ?>> <?= $yesNo[$lang][1] ?> 
<input 
type="radio" name="SexualInfections[]" value="4" <?= getData("SexualInfections", "radio", 4) ?>> <?= $yesNo[$lang][2] ?>
		</td>
	</tr>
	
	<tr>
		<td>
			<li> <?= $sexualPractices[$lang][19] ?></li>
		</td>
		<td>
			<input type="radio" name="SpouseHIVStatus[]" value="1" <?= getData("SpouseHIVStatus", "radio", 1) ?>> <?= $hivStatus[$lang][0]?> 
			<input type="radio" name="SpouseHIVStatus[]" value="2" <?= getData("SpouseHIVStatus", "radio", 2) ?>> <?= $hivStatus[$lang][1] ?> 
			<input type="radio" name="SpouseHIVStatus[]" value="4" <?= getData("SpouseHIVStatus", "radio", 4) ?>> <?= $yesNo[$lang][2] ?>
		</td>
	
	</tr>
</table>
		
</tr></td>

<tr><td>


<?php $sectionName = 'psychObservations'; ?>
<table  class="b_header_nb">
	<tr>
		<td class="s_header" colspan=5>
			<?= $psychObservations[$lang][0] ?>
		</td>	
	</tr>

	<tr>
		<td>
			<?= $psychObservations[$lang][1] ?>
		</td>
	</tr>
	
	<tr>
		<td width="30%">
			<li><?= $psychObservations[$lang][2] ?></li>
		</td>
		<td colspan="2">
			<input value="1" <?= getData("PtAtGlance", "checkbox", 1) ?> type="checkbox" name="PtAtGlance[]"> <?= $psychObservations[$lang][3] ?> 
			<input value="2" <?= getData("PtAtGlance", "checkbox", 2) ?> type="checkbox" name="PtAtGlance[]"> <?= $psychObservations[$lang][4] ?>
			<input value="4" <?= getData("PtAtGlance", "checkbox", 4) ?> type="checkbox" name="PtAtGlance[]"> <?= $psychObservations[$lang][5] ?>
			<input value="8" <?= getData("PtAtGlance", "checkbox", 8) ?> type="checkbox" name="PtAtGlance[]"> <?= $psychObservations[$lang][6] ?>
			<input value="16" <?= getData("PtAtGlance", "checkbox", 16) ?> type="checkbox" name="PtAtGlance[]"> <?= $psychObservations[$lang][7] ?>
			<input value="32" <?= getData("PtAtGlance", "checkbox", 32) ?> type="checkbox" name="PtAtGlance[]"> <?= $psychObservations[$lang][8] ?>
		</td>
	</tr>

	<tr>
		<td width="30%" style="vertical-align:top;">
			<li><?=$childSymptoms[$lang][15]?></li>
		</td>
			<td>
				<input value="1" type="checkbox" name="anger" <?=getData("anger","checkbox")?> /> 
<?=$childSymptoms[$lang][0]?><br>
				<input value="1" type="checkbox" name="refusal" <?=getData("refusal","checkbox")?> /> 
<?=$childSymptoms[$lang][3]?><br>
				<input value="1" type="checkbox" name="sleeps" <?=getData("sleeps", "checkbox")?> /> 
<?=$childSymptoms[$lang][6]?><br>
				<input value="1" type="checkbox" name="shouting" <?=getData("shouting", "checkbox")?> /> 
<?=$childSymptoms[$lang][9]?><br>
				<input value="1" type="checkbox" name="collaborates" <?=getData("collaborates", "checkbox") ?> /> 
<?=$childSymptoms[$lang][12]?><br>


			</td>

			<td>
				<input value="1" type="checkbox" name="tantrums" <?=getData("tantrums", "checkbox")?> /> 
<?=$childSymptoms[$lang][1]?><br>
				<input value="1" type="checkbox" name="fears" <?=getData("fears", "checkbox")?> /> 
<?=$childSymptoms[$lang][4]?><br>
				<input value="1" type="checkbox" name="sulking" <?=getData("sulking", "checkbox")?> /> 
<?=$childSymptoms[$lang][7]?><br>
				<input value="1" type="checkbox" name="balance" <?=getData("balance", "checkbox")?> /> 
<?=$childSymptoms[$lang][10]?><br>
				<input value="1" type="checkbox" name="collaborates" <?=getData("collaborates", "checkbox")?> /> 
<?=$childSymptoms[$lang][13]?><br>
			</td>

			<td>
				<input value="1" type="checkbox" name="speak" <?=getData("speak", "checkbox")?> /> 
<?=$childSymptoms[$lang][2]?><br>
				<input value="1" type="checkbox" name="crying" <?= getData("crying", "checkbox")?> /> <?=$childSymptoms[$lang][5]?><br>
				<input value="1" type="checkbox" name="sings" <?=getData("sings", "checkbox")?> /> 
<?=$childSymptoms[$lang][8]?><br>
				<input value="1" type="checkbox" name="prattling" <?=getData("prattling", "checkbox")?> /> 
<?=$childSymptoms[$lang][11]?><br>
				<input value="1" type="checkbox" name="gurgling" <?=getData("gurgling", "checkbox")?> /> 
<?=$childSymptoms[$lang][14]?><br>
			</td>



	</tr>
	
	<tr>
		<td colspan=2>
		<?= $psychObservations[$lang][21] ?><br>
		<textarea rows="5" name="ObsRemarks" cols="100" ><?= getData("ObsRemarks", "textarea")?> </textarea>
		</td>
	</tr>

	
</table>		
</tr></td>

<tr><td>


<?  $sectionName = 'remarks1';  ?>
<table  class="b_header_nb">
	<tr>
		<td class="s_header" colspan="5">
			<?=$psychRemarks[$lang][0]?>
		</td>	
	</tr>
	<tr>
		<td colspan="4">
			<?=$psychRemarks[$lang][1]?> 			
			<input type="text" name="NextPsychAppt" <?= getData("NextPsychAppt", "text") ?> />  <?=$psychRemarks[$lang][5]?>
		</td>
	</tr>
	<tr>
		<td colspan=4>
			<?=$psychRemarks[$lang][2]?><br>
			<textarea cols="100" rows="4" name="ActionPlan1"><?= getData("ActionPlan1", "textarea") ?></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<?=$psychRemarks[$lang][3]?> <input type="text" name="RemarksSignature" maxlength="20" <?= getData("RemarksSignature", "text") ?>>
		</td>
	</tr>
</table>
</tr></td>

<tr><td>

<? $sectionName = 'social'; ?>
<table  class="b_header_nb">
	<tr>
		<td class="w_header" colspan=5>
			<?=$psychSocial[$lang][0]?>
		</td>	
	</tr>
	
	<tr>
		<td class="s_header" colspan='5'>
			<?=$psychSocial[$lang][1]?>

		</td>
	</tr>
	
	<tr>
		<td width="30%"	> <?=$psychSocial[$lang][2]?></td>
		<td>
			<input type="radio" name="PtHasBddy[]" value="1" <?= getData("PtHasBddy", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> 
			<input type="radio" value="2" <?= getData("PtHasBddy", "radio", 2) ?> name="PtHasBddy[]"> <?= $yesNo[$lang][1] ?> 
			<input type="radio" name="PtHasBddy[]" value="4" <?= getData("PtHasBddy", "radio", 4) ?>> <?= $yesNo[$lang][2] ?>
		</td>
	</tr>

	<tr>
		<td> <?=$psychSocial[$lang][3]?> </td>
		<td>
			<input type="radio" name="BddyPresent[]" value="1" <?= getData("BddyPresent", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> 
			<input type="radio" value="2" <?= getData("BddyPresent", "radio", 2) ?> name="BddyPresent[]"> <?= $yesNo[$lang][1] ?> 
			<input type="radio" value="4" <?= getData("BddyPresent", "radio", 4) ?> name="BddyPresent[]"> <?= $yesNo[$lang][2] ?>
		</td>
	</tr>

	<tr>
		<td> <?=$psychSocial[$lang][4]?> </td>
		<td>
			<input type="radio" value="1" <?= getData("PtBddyRelation", "radio", 1) ?> name="PtBddyRelation[]"> <?=$psychSocial[$lang][5]?> 
			<input type="radio" value="2" <?= getData("PtBddyRelation", "radio", 2) ?> name="PtBddyRelation[]"> <?=$psychSocial[$lang][6]?>
			<input type="radio" value="4" <?= getData("PtBddyRelation", "radio", 4) ?> name="PtBddyRelation[]"> <?=$psychSocial[$lang][7]?>
			<input type="radio" value="8" <?= getData("PtBddyRelation", "radio", 8) ?> name="PtBddyRelation[]"> <?=$psychSocial[$lang][8]?>
			<input type="radio" value="16" <?= getData("PtBddyRelation", "radio", 16) ?> name="PtBddyRelation[]"> <?=$psychSocial[$lang][9]?>
			<input value="32" <?= getData("PtBddyRelation", "radio", 32) ?> type="radio" name="PtBddyRelation[]"> <?=$psychSocial[$lang][10]?> 
			<input type="text" name="PtBddyRelationOther" <?= getData("PtBddyRelationOther", "text")?>>
		</td>
	</tr>
	
	<tr>
		<td> <?=$psychSocial[$lang][11]?>  </td><td>
			<input type="text" name="BddyLName" maxlength=255 <?= getData("BddyLName","text")?>></td>
	</tr>
	
	<tr>
		<td> <?=$psychSocial[$lang][12]?>  </td><td>
			<input type="text" name="BddyFName" maxlength=255 <?= getData("BddyFName","text")?>></td>
	</tr>
	<tr>
		<td> <?=$psychSocial[$lang][13]?>  </td><td>
			<input type="radio" name="BddyGender[]" value="1" <?= getData("BddyGender", "radio", 1) ?>> <?=$psychSocial[$lang][14]?> 
			<input type="radio" value="2" <?= getData("BddyGender", "radio", 2) ?> name="BddyGender[]"> <?=$psychSocial[$lang][15]?>
		</td>
	</tr>
	<tr>
		<td> <?=$psychSocial[$lang][16]?> </td>
		<td><input type="text" name="BddyTele" maxlength=40 <?= getData("BddyTele", "text")?>></td>
	</tr>
	<tr>
		<td> <?=$psychSocial[$lang][17]?>  </td>
		<td><input type="text" size="100" name="BddyAddr" maxlength=255 <?= getData("BddyAddr", "text")?>></td>
	</tr>
	
	<tr>
		<td> <?=$psychSocial[$lang][18]?></td>
		<td>
			<input type="radio" value="1" <?= getData("BddyEducation", "radio", 1) ?> name="BddyEducation[]" > <?=$psychSocial[$lang][19]?>
			<input type="radio" value="2" <?= getData("BddyEducation", "radio", 2) ?> name="BddyEducation[]" /> <?=$psychSocial[$lang][20]?>
			<input type="radio" value="4" <?= getData("BddyEducation", "radio", 4) ?> name="BddyEducation[]"/> <?=$psychSocial[$lang][21]?>
			<input value="8" <?= getData("BddyEducation", "radio", 8) ?> type="radio" name="BddyEducation[]" /> <?=$psychSocial[$lang][22]?>
		</td>	
	</tr>	

	<tr>
		<td> <?=$psychSocial[$lang][23]?></td>
		<td>
			<input type="radio" name="PtTestRecall[]" value="1" <?= getData("PtTestRecall", "radio", 1) ?>> <?= $yesNo[$lang][0] ?> 
			<input type="radio" value="2" <?= getData("PtTestRecall", "radio", 2) ?> name="PtTestRecall[]" /> <?= $yesNo[$lang][1] ?> 
			<?=$psychSocial[$lang][24]?><textarea name="PtTestActual"  ><?= getData("PtTestActual", "textarea")?></textarea> </td>	
	</tr>	

	<tr>
		<td>
			<?=$psychSocial[$lang][25]?>
		</td>
		<td>
			<input type="radio" name="BddyUnderstandTests[]" value="1" <?= getData("BddyUnderstandTests", "radio", 1) ?>/>  <?= $yesNo[$lang][0] 
?>
			<input type="radio" name="<? echo $formName  ?>BddyUnderstandTests[]" value="2" <?= getData("BddyUnderstandTests", "radio", 2) ?>/>  <?= $yesNo[$lang][1] 
?>  
<?=$psychSocial[$lang][26]?>
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][27]?></td>
		<td>
			<input type="radio" name="BddyHomeDist[]" value="1" <?= getData("BddyHomeDist", "radio", 1) ?> >  <?=$psychSocial[$lang][28]?> 
			<input type="radio" name="BddyHomeDist[]" value="2" <?= getData("BddyHomeDist", "radio", 2) ?> /> <?=$psychSocial[$lang][29]?>
			<input type="radio" name="BddyHomeDist[]" value="4" <?= getData("BddyHomeDist", "radio", 4) ?> /> <?=$psychSocial[$lang][30]?>
		</td>	
	</tr>	


	<tr>
		<td>
			<?=$psychSocial[$lang][31]?>
		</td>
		<td>
			<input type="radio" name="BddyCar[]" value="1" <?= getData("BddyCar", "radio", 1) ?> />  <?= $yesNo[$lang][0] ?> 
			<input type="radio" name="BddyCar[]" value="2" <?= getData("BddyCar", "radio", 2) ?> />  <?=$psychSocial[$lang][32]?><textarea 
name="BddyCarType"><?= getData("BddyCarType", "textarea")?></textarea>)
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][33]?>
		</td>
		<td>
			<input type="radio" name="PtBddyContact[]" value="1" <?= getData("PtBddyContact", "radio", 1) ?> /> <?=$psychSocial[$lang][34]?>
			<input type="radio" name="PtBddyContact[]" value="2" <?= getData("PtBddyContact", "radio", 2) ?> /> <?=$psychSocial[$lang][35]?>
			<input type="radio" name="PtBddyContact[]" value="4" <?= getData("PtBddyContact", "radio", 4) ?> /> <?=$psychSocial[$lang][36]?>          
			<input type="radio" name="PtBddyContact[]" value="8" <?= getData("PtBddyContact", "radio", 8) ?> /> <?=$psychSocial[$lang][37]?>
			
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][38]?> 
		</td>
		<td>
			<input type="radio" name="PtBddySeparate[]" value="1" <?= getData("PtBddySeparate", "radio", 1) ?> /> <?=$psychSocial[$lang][39]?>    
			<input type="radio" name="PtBddySeparate[]" value="2" <?= getData("PtBddySeparate", "radio", 2) ?> /> <?=$psychSocial[$lang][40]?>
			<input type="radio" name="PtBddySeparate[]" value="4" <?= getData("PtBddySeparate", "radio", 4) ?> /> <?=$psychSocial[$lang][41]?>
			<input type="radio" name="PtBddySeparate[]" value="8" <?= getData("PtBddySeparate", "radio", 8) ?> /> <?=$yesNo[$lang][2]?>
					
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][42]?>
		</td>
		<td>
			<input type="radio" name="BddyMedDelivery[]" value="1" <?= getData("BddyMedDelivery", "radio", 1) ?> /> <?=$psychSocial[$lang][43]?>
			<input type="radio" name="BddyMedDelivery[]" value="2" <?= getData("BddyMedDelivery", "radio", 2) ?> /> <?=$psychSocial[$lang][44]?>
			<input type="radio" name="BddyMedDelivery[]" value="4" <?= getData("BddyMedDelivery", "radio", 4) ?> /> <?=$psychSocial[$lang][45]?>
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][46]?>
		</td>
		<td>
			<input type="radio" name="BddyClinicVisit[]" value="1" <?= getData("BddyClinicVisit", "radio", 1) ?> /> <?=$psychSocial[$lang][47]?>    
			<input type="radio" name="BddyClinicVisit[]" value="2" <?= getData("BddyClinicVisit", "radio", 2) ?> /> <?=$psychSocial[$lang][48]?>                         
			<input type="radio" name="BddyClinicVisit[]" value="4" <?= getData("BddyClinicVisit", "radio", 4) ?> />  <?=$psychSocial[$lang][49]?>
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][50]?>
		</td>
		<td>
			<input type="radio" name="BddyAIDSTrain[]" value="1" <?= getData("BddyAIDSTrain", "radio", 1) ?> />  <?= $yesNo[$lang][0] ?>      
			<input type="radio" name="BddyAIDSTrain[]" value="2" <?= getData("BddyAIDSTrain", "radio", 2) ?> />  <?= $yesNo[$lang][1] ?>  
&nbsp;&nbsp;&nbsp;&nbsp;Note: <input type="text" name="BddyAIDSTrainText" <?= getData("BddyAIDSTrainText", "text") ?> />

		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][51]?>
		</td>
		<td>
                        <input type="radio" name="BddySupportGroup[]" value="1" <?= getData("BddySupportGroup", "radio", 1) ?> />  <?= $yesNo[$lang][0] ?>
                        <input type="radio" name="BddySupportGroup[]" value="2" <?= getData("BddySupportGroup", "radio", 2) ?> />  <?= $yesNo[$lang][1] ?>  &nbsp;&nbsp;&nbsp;&nbsp;Note: <input 
type="text" name="BddySupportGroupText" <?= getData("BddySupportGroupText","text") ?>  />
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][52]?>
		</td>
		<td>
			<input type="radio" name="BddyInfoUnderstanding[]" value="1" <?= getData("BddyInfoUnderstanding", "radio", 1) ?> /> <?=$psychSocial[$lang][53]?>   
			<input type="radio" name="BddyInfoUnderstanding[]" value="2" <?= getData("BddyInfoUnderstanding", "radio", 2) ?> /> <?=$psychSocial[$lang][54]?>             
			<input type="radio" name="BddyInfoUnderstanding[]" value="4" <?= getData("BddyInfoUnderstanding", "radio", 4) ?> /> <?=$psychSocial[$lang][55]?>
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][56]?>
		</td>
		<td>
			<input type="radio" name="BddySpprtLvl[]" value="1" <?= getData("BddySpprtLvl", "radio", 1) ?> />  <?=$psychSocial[$lang][57]?>                  
			<input type="radio" name="BddySpprtLvl[]" value="2" <?= getData("BddySpprtLvl", "radio", 2) ?> />  <?=$psychSocial[$lang][58]?>                            
			<input type="radio" name="BddySpprtLvl[]" value="4" <?= getData("BddySpprtLvl", "radio", 4) ?> />  <?=$psychSocial[$lang][59]?>
		</td>	
	</tr>	


	<tr>
		<td> <?=$psychSocial[$lang][60]?>
		</td>
		<td>
			<input type="radio" name="PtFollowUpARV[]" value="1" <?= getData("PtFollowUpARV", "radio", 1) ?> />  <?=$psychSocial[$lang][57]?>                  
			<input type="radio" name="PtFollowUpARV[]" value="2" <?= getData("PtFollowUpARV", "radio", 2) ?> />  <?=$psychSocial[$lang][58]?>                            
			<input type="radio" name="PtFollowUpARV[]" value="4" <?= getData("PtFollowUpARV", "radio", 4) ?> />  <?=$psychSocial[$lang][59]?>
		</td>	
	</tr>	


</table>

</tr></td>

<tr><td>



<? $sectionName = "supportEval"; ?>
<table  class="b_header_nb">
	<tr>
		<td class="w_header" colspan="5"> <?=$obstacles[$lang][0]?></td >
	</tr>
</table>
</tr></td>

<tr><td>

<br>


<?php

 $sectionName = "obstacles"; ?>


<table  class="b_header_nb">
	<tr>
		<td colspan="2" style="font-weight:900;"> <?=$childObstacles[$lang][0]?></td>
	</tr>


	<tr>
		<td width="30%"> <?=$obstacles[$lang][1]?></td >
		<td>
			<input type="radio" name="ClinicObstacles[]" value="1" <?= getData("ClinicObstacles", "radio", 1) ?> /> <?=$obstacles[$lang][2]?>  
			<input type="radio" name="ClinicObstacles[]" value="2" <?= getData("ClinicObstacles", "radio", 2) ?> /> <?=$obstacles[$lang][3]?>
			<input type="radio" name="ClinicObstacles[]" value="4" <?= getData("ClinicObstacles", "radio", 4) ?> /> <?=$obstacles[$lang][4]?><input type="text" 
name="ClinicObstaclesText" <?= getData("ClinicObstaclesText", "text")?> />
		</td>	
	</tr>	

	<tr>
		<td>	<?=$obstacles[$lang][5]?>
		</td>
		<td>
			<input type="radio" name="HomeVisits[]" value="1" <?= getData("HomeVisits", "radio", 1) ?> />  <?=$obstacles[$lang][6]?>
			<input type="radio" name="HomeVisits[]" value="2" <?= getData("HomeVisits", "radio", 2) ?> />  <?=$obstacles[$lang][7]?>
			<input type="radio" name="HomeVisits[]" value="4" <?= getData("HomeVisits", "radio", 4) ?> />  <?=$obstacles[$lang][8]?>
		</td>	
	</tr>	

	<tr>
		<td> <?=$obstacles[$lang][9]?>
		</td>
		<td>
			<input type="radio" name="RelativeSupport[]" value="1" <?= getData("RelativeSupport", "radio", 1) ?> />  <?=$obstacles[$lang][10]?>
			<input type="radio" name="RelativeSupport[]" value="2" <?= getData("RelativeSupport", "radio", 2) ?> />  <?=$obstacles[$lang][11]?>
			<input type="radio" name="RelativeSupport[]" value="4" <?= getData("RelativeSupport", "radio", 4) ?> />  <?=$obstacles[$lang][12]?>
			<input type="radio" name="RelativeSupport[]" value="8" <?= getData("RelativeSupport", "radio", 8) ?> />  <?=$obstacles[$lang][13]?>
		</td>	
	</tr>	

	<tr>
		<td colspan="2" style="font-weight:900;"> <?=$childObstacles[$lang][1]?></td>
	</tr>

	<tr>
		<td> <?=$obstacles[$lang][14]?>
		</td>
		<td>
				<input type="radio" name="HIVStatCom[]" value="1" <?= getData("HIVStatCom", "radio", 1) ?> >  <?=$obstacles[$lang][15]?>
				<input type="radio" name="HIVStatCom[]" value="2" <?= getData("HIVStatCom", "radio", 2) ?> />  <?=$obstacles[$lang][16]?>
				<input type="radio" name="HIVStatCom[]" value="4" <?= getData("HIVStatCom", "radio", 4) ?> />  <?=$obstacles[$lang][17]?>
				<input type="radio" name="HIVStatCom[]" value="8" <?= getData("HIVStatCom", "radio", 8) ?> />  <?=$obstacles[$lang][18]?>
				<input type="radio" name="HIVStatCom[]" value="16" <?= getData("HIVStatCom", "radio", 16) ?> />  <?=$obstacles[$lang][19]?>
				<input type="radio" name="HIVStatCom[]" value="32" <?= getData("HIVStatCom", "radio", 32) ?> />  <?=$obstacles[$lang][20]?>
			</td>	
		</tr>	
	<tr>
		<td> <?=$obstacles[$lang][21]?>
		</td>
		<td>
			<input type="radio" name="PsychSocialSupport[]" value="1" <?= getData("PsychSocialSupport", "radio", 1) ?> />  <?=$obstacles[$lang][10]?>
			<input type="radio" name="PsychSocialSupport[]" value="2" <?= getData("PsychSocialSupport", "radio", 2) ?> />  <?=$obstacles[$lang][11]?>
			<input type="radio" name="PsychSocialSupport[]" value="4" <?= getData("PsychSocialSupport", "radio", 4) ?> />  <?=$obstacles[$lang][12]?>
			<input type="radio" name="PsychSocialSupport[]" value="8" <?= getData("PsychSocialSupport", "radio", 8) ?> />  <?=$obstacles[$lang][13]?>
		</td>	
	</tr>	

		
	<tr>
		<td> <?=$obstacles[$lang][22]?>
		</td>
		<td>
			<input type="radio" name="HomeVisitAccp[]" value="1" <?= getData("HomeVisitAccp", "radio", 1) ?> />  <?=$obstacles[$lang][6]?>
			<input type="radio" name="HomeVisitAccp[]" value="2" <?= getData("HomeVisitAccp", "radio", 2) ?> />  <?=$obstacles[$lang][7]?>
			<input type="radio" name="HomeVisitAccp[]" value="4" <?= getData("HomeVisitAccp", "radio", 4) ?> />  <?=$obstacles[$lang][23]?> 
		</td>	
	</tr>	


	<tr>
		<td> <?=$obstacles[$lang][24]?>
		</td>
		<td>
			<input type="radio" name="HomeVisitObstacles[]" value="1" <?= getData("HomeVisitObstacles", "radio", 1) ?> />  <?=$obstacles[$lang][25]?>
			<input type="radio" name="HomeVisitObstacles[]" value="2" <?= getData("HomeVisitObstacles", "radio", 2) ?> />  <?=$obstacles[$lang][26]?>
			<input type="radio" name="HomeVisitObstacles[]" value="4" <?= getData("HomeVisitObstacles", "radio", 4) ?> />  <?=$obstacles[$lang][27]?>
			<input type="radio" name="HomeVisitObstacles[]" value="8" <?= getData("HomeVisitObstacles", "radio", 8) ?> />  <?=$obstacles[$lang][28]?>
		</td>	
	</tr>	


	<tr>
		<td valign="top"> <?=$obstacles[$lang][29]?>
		</td>
		<td valign="top">
			<input type="radio" name="Rsns4PtConcern[]" value="1" <?= getData("Rsns4PtConcern", "radio", 1) ?> />  <?=$obstacles[$lang][30]?> 
			<input type="radio" name="Rsns4PtConcern[]" value="2" <?= getData("Rsns4PtConcern", "radio", 2) ?> />  <?=$obstacles[$lang][31]?>
			<input type="radio" name="Rsns4PtConcern[]" value="4" <?= getData("Rsns4PtConcern", "radio", 4) ?> />  <?=$obstacles[$lang][32]?>
			<input type="radio" name="Rsns4PtConcern[]" value="8" <?= getData("Rsns4PtConcern", "radio", 8) ?> />  <?=$obstacles[$lang][33]?>
			<input type="radio" name="Rsns4PtConcern[]" value="16" <?= getData("Rsns4PtConcern", "radio", 16) ?> />  <?=$obstacles[$lang][34]?><input type="text" 
name="Rsns4PtConcernText" <?= getData("Rsns4PtConcernText", "text")?> />
		</td>	
	</tr>	


<table>

<? $sectionName = "ARVprep"; ?>

<table  class="b_header_nb">
	<tr>
		<td class="w_header" colspan=5> <?=$ARVprep[$lang][0]?></td >
	</tr>
	<tr>
		<td colspan="2" style="font-weight:900;"> <?=$childObstacles[$lang][1]?></td>
	</tr>

	<tr>
		<td width="30%"> <?=$ARVprep[$lang][1]?></td>
		<td> <?=$ARVprep[$lang][2]?></td>
	</tr>

	<tr>
		<td> <?=$ARVprep[$lang][3]?> </td>
		<td> 
			<input value="1" <?= getData("KnowlTransMode", "radio", 1) ?> type="radio" name="KnowlTransMode[]" /> <?=$ARVprep[$lang][4]?> 
			<input value="2" <?= getData("KnowlTransMode", "radio", 2) ?> type="radio" name="KnowlTransMode[]" /> <?=$ARVprep[$lang][5]?> 
			<input value="4" <?= getData("KnowlTransMode", "radio", 4) ?> type="radio" name="KnowlTransMode[]" /> <?=$ARVprep[$lang][6]?>  
		</td>

	</tr>	

	<tr>
		<td> <?=$ARVprep[$lang][7]?>   </td>
		<td> <input type="radio" value="1" <?= getData("KnowlTreatARV", "radio", 1) ?> name="KnowlTreatARV[]" /> <?=$ARVprep[$lang][4]?> 
		     <input value="2" <?= getData("KnowlTreatARV", "radio", 2) ?> type="radio" name="KnowlTreatARV[]" /> <?=$ARVprep[$lang][5]?> 
		     <input type="radio" name="KnowlTreatARV[]" value="4" <?= getData("KnowlTreatARV", "radio", 4) ?> /> <?=$ARVprep[$lang][6]?>  </td>

	</tr>	
	<tr>
		<td> <?=$ARVprep[$lang][8]?></td>
		<td> <input type="radio" value="1" <?= getData("KnowlARVNotCure", "radio", 1) ?> name="KnowlARVNotCure[]" /> <?=$ARVprep[$lang][4]?>
		<input value="2" <?= getData("KnowlARVNotCure", "radio", 2) ?> type="radio" name="KnowlARVNotCure[]" /> <?=$ARVprep[$lang][5]?>
		<input value="4" <?= getData("KnowlARVNotCure", "radio", 4) ?> type="radio" name="KnowlARVNotCure[]" /> <?=$ARVprep[$lang][6]?> </td>

	</tr>	
	<tr>
		<td> <?=$ARVprep[$lang][9]?></td>
		<td> <input type="radio" value="1" <?= getData("KnowlTransmitInARV", "radio", 1) ?> name="KnowlTransmitInARV[]" /> <?=$ARVprep[$lang][4]?>
		<input value="2" <?= getData("KnowlTransmitInARV", "radio", 2) ?> type="radio" name="KnowlTransmitInARV[]" /> <?=$ARVprep[$lang][5]?>
		<input type="radio" name="KnowlTransmitInARV[]" value="4" <?= getData("KnowlTransmitInARV", "radio", 4) ?>/> <?=$ARVprep[$lang][6]?></td>

	</tr>	
	<tr>
		<td> <?=$ARVprep[$lang][10]?></td>
		<td> <input type="radio" value="1" <?= getData("KnowlBuddy", "radio", 1) ?> name="KnowlBuddy[]" /> <?=$ARVprep[$lang][4]?>
		<input value="2" <?= getData("KnowlBuddy", "radio", 2) ?> type="radio" name="KnowlBuddy[]" /> <?=$ARVprep[$lang][5]?> 
		<input type="radio" name="KnowlBuddy[]" value="4" <?= getData("KnowlBuddy", "radio", 4) ?> /> <?=$ARVprep[$lang][6]?> </td>

	</tr>	


</table>
</tr></td>

<tr><td>




<?  $sectionName = 'remarks2';  ?>
<table  class="b_header_nb">
	<tr>
		<td class="s_header" colspan="5">
			<?=$psychRemarks[$lang][0]?>
		</td>	
	</tr>


	<tr>
		<td width="30%"> <?=$psychRemarks[$lang][4]?></td>
		<td> <input type="radio" name="ServiceReferal[]" value="1" <?= getData("ServiceReferal", "radio", 1) ?>> <?=$yesNo[$lang][0]?> 
		     <input type="radio" name="ServiceReferal[]" value="2" <?= getData("ServiceReferal", "radio", 2) ?>> <?=$yesNo[$lang][1]?>

		</td>	
	</tr>
	<tr>
		<td colspan=4>
			<?=$psychRemarks[$lang][2]?><br>
			<textarea cols="100" rows="4" name="ObsRemarks2" ><?= getData("ObsRemarks2", "textarea") ?></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<?=$psychRemarks[$lang][3]?> <input type="text" name="RemarksSignature2" <?= getData("RemarksSignature2", "text") ?> maxlength="20">
		</td>
	</tr>
</table>
</tr></td>





</table>

</div>
<?php




?>

