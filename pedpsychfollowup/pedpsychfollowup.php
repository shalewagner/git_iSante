<?php 
require_once("labels/psych.php");
require_once("labels/intake.php");


fb($eid,"eid in psychFUForm");
fb($support[$lang][0],"support no. 1");

$lang = $_GET["lang"];

?>

<div class="formArea">
	<table class="header">
		<tr><td>

			<table  class="b_header_nb">
				<tr>
					<td class="s_header" colspan="5">
						<?= $support[$lang][0] ?>
					</td>	
				</tr>

      </tr>
      <!-- tr>

       <td id="vitalBp1Title"> <?= $vitalBp1[$lang][1] ?></td>
       <td colspan="3"><table><tr><td><input tabindex="1105" id="vitalBp1" name="vitalBp1" <?= getData ("vitalBp1", "text") ?> type="text" size="10"
maxlength="64">&nbsp;/</td><td  id="vitalBp2Title"></td>
       <td><input  tabindex="1106" id="vitalBp2" name="vitalBp2" <?= getData ("vitalBp2", "text") ?> type="text" size="10" maxlength="64"></td><td><span><i> <?=
$vitalBPUnits[$lang][0] ?> <td id="vitalBpUnitTitle"></td><td><input tabindex="1107" id="vitalBpUnit1" name="vitalBPUnits[]" <?= getData ("vitalBPUnits", "radio", 1) ?>
type="radio" value="1"> <?= $vitalBPUnits[$lang][1] ?> <input tabindex="1108" id="vitalBpUnit2" name="vitalBPUnits[]" <?= getData ("vitalBPUnits", "radio", 2) ?>  type="radio"
value="2"> <?= $vitalBPUnits[$lang][2] ?> </i></span></td></tr></table></td>
      </tr -->





			        <tr>
			                <td width="30%" > <?= $support[$lang][1]?></td>
			                <td>
			                        <input type="radio" name="PtHasBddy[]" value="1" <?= getData("PtHasBddy", "radio", 1) ?>> <?= $yesNo[$lang][0] ?>
			                        <input type="radio" value="2" <?= getData("PtHasBddy", "radio", 2) ?> name="PtHasBddy[]"> <?= $yesNo[$lang][1] ?>
			                        <input type="radio" name="PtHasBddy[]" value="4" <?= getData("PtHasBddy", "radio", 4) ?>> <?= $yesNo[$lang][2] ?>
			                </td>
			        </tr>

			        <tr>
			                <td> <?=$support[$lang][2]?> </td>
			                <td>
			                        <input type="radio" name="BddyPresent[]" value="1" <?= getData("BddyPresent", "radio", 1) ?>> <?= $yesNo[$lang][0] ?>
			                        <input type="radio" value="2" <?= getData("BddyPresent", "radio", 2) ?> name="BddyPresent[]"> <?= $yesNo[$lang][1] ?>
			                        <input type="radio" value="4" <?= getData("BddyPresent", "radio", 4) ?> name="BddyPresent[]"> <?= $yesNo[$lang][2] ?>
			                </td>
			        </tr>

			        <tr>
			                <td id="BddyAIDSTrainCmpltDateTitle"> <?=$support[$lang][3]?> </td>
			                <td valign="top">
			                        <input type="radio" id="BddyAIDSTrainCmplt1" name="BddyAIDSTrainCmplt[]" value="1" <?= getData("BddyAIDSTrainCmplt","radio",1)?> > <?= 
$support[$lang][4] ?> 
<input type="text" name="BddyAIDSTrainCmpltDate" id="BddyAIDSTrainCmpltDate" <?=  getData("BddyAIDSTrainCmpltDate","text") ?> />
			                        <input type="radio" name="BddyAIDSTrainCmplt[]" value="2" <?= getData("BddyAIDSTrainCmplt","radio",2)?>  > <?= $yesNo[$lang][1] ?>
			                </td>
			        </tr>


			        <tr>
			                <td> <?=$support[$lang][5]?> </td>
			                <td valign="top">
			                        <input type="radio" value="1" name="BddyInfoUnderstanding[]"  <?= getData("BddyInfoUnderstanding","radio",1)?> > <?= $yesNo[$lang][0] ?>
			                        <input type="radio" value="2" name="BddyInfoUnderstanding[]" <?= getData("BddyInfoUnderstanding","radio",2)?> > <?= $support[$lang][6] ?> 
<input type="text" name="BddyInfoUnderstandingText" />
			                </td>
			        </tr>

			        <tr>
			                <td> <?=$support[$lang][7]?> </td>
			                <td valign="top">
			                        <input type="radio" value="1" id="BddyChng1" name="BddyChng[]" <?= getData("BddyChng","radio",1)?> /> <?= $support[$lang][8] ?>
			                        <input type="radio" value="2" name="BddyChng[]" <?= getData("BddyChng","radio",2)?> /> <?= $yesNo[$lang][1] ?>
			                </td>
			        </tr>
				<tr id="buddyInfo">
					<td></td><td>
<table style="border:1px solid black;margin-bottom:.5em;padding:.5em;">        <tr>
                <td id="BddyLNameTitle"> <?=$psychSocial[$lang][11]?>  </td><td>
                        <input type="text" name="BddyLName" id="BddyLName" maxlength=255 <?= getData("BddyLName","text")?>></td>
        </tr>

        <tr>
                <td id="BddyFNameTitle"> <?=$psychSocial[$lang][12]?>  </td><td>
                        <input type="text" name="BddyFName" id="BddyFName" maxlength=255 <?= getData("BddyFName","text")?>></td>
        </tr>
        <tr>
                <td id="BddyGenderTitle"> <?=$psychSocial[$lang][13]?>  </td><td>
                        <input type="radio" name="BddyGender[]" value="1" <?= getData("BddyGender", "radio", 1) ?>> 
<?=$psychSocial[$lang][14]?>
                        <input type="radio" value="2" <?= getData("BddyGender", "radio", 2) ?> name="BddyGender[]"> 
<?=$psychSocial[$lang][15]?>
                </td>
        </tr>
        <tr>
                <td id="BddyTeleTitle"> <?=$psychSocial[$lang][16]?> </td>
                <td><input type="text" name="BddyTele" id="BddyTele" maxlength=40 <?= getData("BddyTele", "text")?>></td>
        </tr>
        <tr>
                <td id="BddyAddrTitle"> <?=$psychSocial[$lang][17]?>  </td>
                <td><input type="text" size="100" name="BddyAddr" id="BddyAddr" maxlength=255 <?= getData("BddyAddr", "text")?>></td>
        </tr>
        <tr>
                <td id="BddyEducationTitle"> <?=$psychSocial[$lang][18]?></td>
                <td>
                        <input id="BddyEducation1" type="radio" value="1" <?= getData("BddyEducation", "radio", 1) ?> name="BddyEducation[]" > 
<?=$psychSocial[$lang][19]?>
                        <input id="BddyEducation2" type="radio" value="2" <?= getData("BddyEducation", "radio", 2) ?> name="BddyEducation[]" /> 
<?=$psychSocial[$lang][20]?>
                        <input id="BddyEducation3" type="radio" value="4" <?= getData("BddyEducation", "radio", 4) ?> name="BddyEducation[]"/> 
<?=$psychSocial[$lang][21]?>
                        <input id="BddyEducation4" value="8" <?= getData("BddyEducation", "radio", 8) ?> type="radio" name="BddyEducation[]" /> 
<?=$psychSocial[$lang][22]?>
                </td>
        </tr>


</table></td>


				</tr>




			</table>
		</tr></td>





		<tr><td>

				<table  class="b_header_nb">
				<tr>
					<td class="s_header" colspan="5">
						<?=$psychEval[$lang][0]?>
					</td>	
				</tr>

				<tr>
					<table style="border-collapse:collapse; width:75%;">	
						<tr>
							<td class="b_header" width="50%"> <?=$psychEval[$lang][1]?> </td>
							<td class="b_header" width="10%"> <?=$psychEval[$lang][2]?> </td>
							<td class="b_header" width="10%"> <?=$psychEval[$lang][3]?> </td>
							<td class="b_header" width="10%"> <?=$psychEval[$lang][4]?> </td>
							<td class="b_header" width="10%"> <?=$psychEval[$lang][5]?> </td>
							<td class="b_header" width="10%"> <?=$psychEval[$lang][6]?> </td>
						</tr>
						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][7]?> </td>
							<td> <input type="radio" value="1"  name="colorKnowl[]" <?= getData("colorKnowl","radio",1)?>/> </td>
							<td> <input type="radio" value="2"  name="colorKnowl[]" <?= getData("colorKnowl","radio",2)?>/> </td>
							<td> <input type="radio" value="4"  name="colorKnowl[]" <?= getData("colorKnowl","radio",4)?>/> </td>
							<td> <input type="radio" value="8"  name="colorKnowl[]" <?= getData("colorKnowl","radio",8)?> /> </td>
							<td> <input type="radio" value="16" name="colorKnowl[]" <?= getData("colorKnowl","radio",16)?> /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][8]?> </td>
							<td> <input type="radio" value="1" <?= getData("geoKnowl","radio",1)?>   name="geoKnowl[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("geoKnowl","radio",2)?>   name="geoKnowl[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("geoKnowl","radio",4)?>   name="geoKnowl[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("geoKnowl","radio",8)?>  name="geoKnowl[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("geoKnowl","radio",16)?> name="geoKnowl[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][9]?> </td>
							<td> <input type="radio" value="1" <?= getData("treeKnowl","radio",1)?>  name="treeKnowl[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("treeKnowl","radio",2)?>  name="treeKnowl[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("treeKnowl","radio",4)?>  name="treeKnowl[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("treeKnowl","radio",8)?> name="treeKnowl[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("treeKnowl","radio",16)?> name="treeKnowl[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][10]?> </td>
							<td> <input type="radio" value="1" <?= getData("lateralization","radio",1)?>  name="lateralization[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("lateralization","radio",2)?>  name="lateralization[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("lateralization","radio",4)?>  name="lateralization[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("lateralization","radio",8)?> name="lateralization[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("lateralization","radio",16)?> name="lateralization[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][11]?> </td>
							<td> <input type="radio" value="1" <?= getData("UDorient","radio",1)?>  name="UDorient[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("UDorient","radio",2)?>  name="UDorient[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("UDorient","radio",4)?>  name="UDorient[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("UDorient","radio",8)?> name="UDorient[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("UDorient","radio",16)?> name="UDorient[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][12]?> </td>
							<td> <input type="radio" value="1" <?= getData("visPercep","radio",1)?>  name="visPercep[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("visPercep","radio",2)?>  name="visPercep[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("visPercep","radio",4)?>  name="visPercep[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("visPercep","radio",8)?> name="visPercep[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("visPercep","radio",16)?> name="visPercep[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][13]?> </td>
							<td> <input type="radio" value="1" <?= getData("visMem","radio",1)?>  name="visMem[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("visMem","radio",2)?>  name="visMem[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("visMem","radio",4)?>  name="visMem[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("visMem","radio",8)?> name="visMem[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("visMem","radio",16)?> name="visMem[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][14]?> </td>
							<td> <input type="radio" value="1" <?= getData("fineMotor","radio",1)?>  name="fineMotor[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("fineMotor","radio",2)?>  name="fineMotor[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("fineMotor","radio",4)?>  name="fineMotor[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("fineMotor","radio",8)?> name="fineMotor[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("fineMotor","radio",16)?> name="fineMotor[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][15]?> </td>
							<td> <input type="radio" value="1" <?= getData("oralCom","radio",1)?>  name="oralCom[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("oralCom","radio",2)?>  name="oralCom[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("oralCom","radio",4)?>  name="oralCom[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("oralCom","radio",8)?> name="oralCom[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("oralCom","radio",16)?> name="oralCom[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][16]?> </td>
							<td> <input type="radio" value="1" <?= getData("audPercep","radio",1)?>  name="audPercep[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("audPercep","radio",2)?>  name="audPercep[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("audPercep","radio",4)?>  name="audPercep[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("audPercep","radio",8)?> name="audPercep[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("audPercep","radio",16)?> name="audPercep[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][17]?> </td>
							<td> <input type="radio" value="1" <?= getData("audMem","radio",1)?>  name="audMem[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("audMem","radio",2)?>  name="audMem[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("audMem","radio",4)?>  name="audMem[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("audMem","radio",8)?> name="audMem[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("audMem","radio",16)?> name="audMem[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][18]?> </td>
							<td> <input type="radio" value="1" <?= getData("rhythm","radio",1)?>  name="rhythm[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("rhythm","radio",2)?>  name="rhythm[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("rhythm","radio",4)?>  name="rhythm[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("rhythm","radio",8)?> name="rhythm[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("rhythm","radio",16)?> name="rhythm[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][19]?> </td>
							<td> <input type="radio" value="1" <?= getData("intelFunc","radio",1)?>  name="intelFunc[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("intelFunc","radio",2)?>  name="intelFunc[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("intelFunc","radio",4)?>  name="intelFunc[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("intelFunc","radio",8)?> name="intelFunc[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("intelFunc","radio",16)?> name="intelFunc[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][20]?> </td>
							<td> <input type="radio" value="1" <?= getData("handUse","radio",1)?>  name="handUse[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("handUse","radio",2)?>  name="handUse[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("handUse","radio",4)?>  name="handUse[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("handUse","radio",8)?> name="handUse[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("handUse","radio",16)?> name="handUse[]" /> </td>
						</tr>

						<tr style="background-color:#eee;">
							<td> <?=$psychEval[$lang][21]?> </td>
							<td> <input type="radio" value="1" <?= getData("latDom","radio",1)?>  name="latDom[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("latDom","radio",2)?>  name="latDom[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("latDom","radio",4)?>  name="latDom[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("latDom","radio",8)?> name="latDom[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("latDom","radio",16)?> name="latDom[]" /> </td>
						</tr>

						<tr>
							<td> <?=$psychEval[$lang][22]?> </td>
							<td> <input type="radio" value="1" <?= getData("grossMotor","radio",1)?>  name="grossMotor[]" /> </td>
							<td> <input type="radio" value="2" <?= getData("grossMotor","radio",2)?>  name="grossMotor[]" /> </td>
							<td> <input type="radio" value="4" <?= getData("grossMotor","radio",4)?>  name="grossMotor[]" /> </td>
							<td> <input type="radio" value="8" <?= getData("grossMotor","radio",8)?> name="grossMotor[]" /> </td>
							<td> <input type="radio" value="16" <?= getData("grossMotor","radio",16)?> name="grossMotor[]" /> </td>
						</tr>


					</table>

				</tr>
			        <tr>
			                <td colspan=4>
			                        <?=$psychEval[$lang][23]?><br>
			                        <textarea cols="100" rows="4" name="ActionPlan1"><?= getData("ActionPlan1", "textarea") ?></textarea>
			                </td>
			        </tr>


			</table>
		</td></tr>





		<tr><td>

			<table  class="b_header_nb">
				<tr>
					<td class="s_header" colspan="5">
						<?=$followUpCare[$lang][0]?>
					</td>	
				</tr>

				<tr>
					<td width="30%" id="ptRcvdRefAndSrvcsTitle"> <?= $followUpCare[$lang][1]?></td>

					<td> <input type="radio" value="1" <?= getData("ptRcvdRefAndSrvcs","radio",1)?>  
name="ptRcvdRefAndSrvcs[]"> <?= $yesNo[$lang][0] ?>  
					     <input type="radio" id="ptRcvdRefAndSrvcsNo" value="2" <?= getData("ptRcvdRefAndSrvcs","radio",2)?>  
name="ptRcvdRefAndSrvcs[]"> 
<?= $followUpCare[$lang][2]?> <input type="text" name="ptRcvdRefAndSrvcsReason" id="ptRcvdRefAndSrvcsReason" <?= 
getData("ptRcvdRefAndSrvcsReason","text")?> />
					</td>

				</tr>

				<tr>
					<td> <?= $followUpCare[$lang][3]?> </td>
					<td> <input type="radio" value="1" <?= getData("ptMissedCinicVisit","radio",1)?>  name="ptMissedCinicVisit[]"> <?= $followUpCare[$lang][4] ?> <input type="text" name="ptMissedCinicVisitDate" <?= getData("ptMissedCinicVisitDate","text")?>/>  
					     <input type="radio" value="2" <?= getData("ptMissedCinicVisit","radio",2)?>  name="ptMissedCinicVisit[]"> <?= $yesNo[$lang][1]?>
					</td>

				</tr>

				<tr>
					<td> <?= $followUpCare[$lang][5]?> </td>
					<td> <input type="radio" value="1" <?= getData("ptMissOtherApts","radio",1)?>  name="ptMissOtherApts[]"> <?= $followUpCare[$lang][6] ?>  <input 
type="text" name="ptMissOtherAptsDate" <?= getData("ptMissOtherAptsDate","text") ?> />
					     <input type="radio" value="2" <?= getData("ptMissOtherApts","radio",2)?>  name="ptMissOtherApts[]"> <?= $yesNo[$lang][1]?>
					</td>

				</tr>

				<tr>
					<td> <?= $followUpCare[$lang][7]?> </td>
					<td> <input type="radio" value="1" <?= getData("ptOnARVS","radio",1)?>  name="ptOnARVS[]"> <?= $followUpCare[$lang][8] ?>  <input type="text" name="ptOnARVSRegime"  <?= getData("ptOnARVSRegime","text") ?> />
					     <input type="radio" value="2" <?= getData("ptOnARVS","radio",2)?>  name="ptOnARVS[]"> <?= $yesNo[$lang][1]?>
					</td>

				</tr>

			</table>
		</tr></td>



		<tr><td>

			<table  class="b_header_nb">
				<tr>
					<td class="s_header" colspan="5">
						<?=$abuseEval[$lang][0]?>
					</td>	
				</tr>
				<tr>
			
					<table>
						<tr>
							<td> <?=$abuseEval[$lang][1]?></td>
							<td> <?=$abuseEval[$lang][2]?></td>
							<td> <?=$abuseEval[$lang][3]?></td>
							<td> <?=$abuseEval[$lang][4]?></td>
							<td> <?=$abuseEval[$lang][5]?></td>

						</tr>
						
						<tr>
							<td width="30%"><?=$abuseEval[$lang][6]?></td>
							<td width="12%"><input type="radio" value="1" <?= getData("emotionalAbuseTime","radio",1)?>  name="emotionalAbuseTime[]"></td>
							<td width="12%"><input type="radio" value="2" <?= getData("emotionalAbuseTime","radio",2)?>  name="emotionalAbuseTime[]"></td>
							<td width="12%"><input type="checkbox" value="1" <?= getData("emotionalAbusePrtnr","checkbox")?>  name="emotionalAbusePrtnr"></td>
							<td width="12%"><input type="checkbox" value="1" <?= getData("emotionalAbuseFmly","checkbox")?>  name="emotionalAbuseFmly"></td>

						</tr>

						<tr>
							<td><?=$abuseEval[$lang][7]?></td>
							<td><input type="radio" value="1" <?= getData("verbAbuseTime","radio",1)?>  name="verbAbuseTime[]"></td>
							<td><input type="radio" value="2" <?= getData("verbAbuseTime","radio",2)?>  name="verbAbuseTime[]"></td>
							<td><input type="checkbox" value="1" <?= getData("verbAbusePrtnr","checkbox")?>  name="verbAbusePrtnr"></td>
							<td><input type="checkbox" value="1" <?= getData("verbAbuseFmly","checkbox")?>  name="verbAbuseFmly"></td>

						</tr>

						<tr>
							<td><?=$abuseEval[$lang][8]?></td>
							<td><input type="radio" value="1" <?= getData("physAbuseTime","radio",1)?>  name="physAbuseTime[]"></td>
							<td><input type="radio" value="2" <?= getData("physAbuseTime","radio",2)?>  name="physAbuseTime[]"></td>
							<td><input type="checkbox" value="1" <?= getData("physAbusePrtnr","checkbox")?>  name="physAbusePrtnr"></td>
							<td><input type="checkbox" value="1" <?= getData("physAbuseFmly","checkbox")?>  name="physAbuseFmly"></td>

						</tr>
					</table>
				</tr>
				<tr>
					<td> <?=$abuseEval[$lang][9]?><br><br></td>
				</tr>

				<tr>
					<td><?=$abuseEval[$lang][10]?></td>
				</tr>

				<tr>
					<table>
						<tr>  <?php $num = 1; 


					//need to come back to this section and find out what symptoms are already in database 
					//and if the datatypes associated with the symptom will work for our purpose. 

?>
							<td><input type="checkbox" name="headache" value="On" <?= getData("headache", "checkbox") ?> ><?=$abuseEval[$lang][11]?></td>
							<td><input type="checkbox" name="nausea" value="On" <?= getData("nausea", "checkbox") ?> ><?=$abuseEval[$lang][12]?></td>
							<td><input type="checkbox" value="1" <?= getData("appetiteLoss","checkbox")?>  name="appetiteLoss"><?=$abuseEval[$lang][13]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="On" <?= getData("vomiting","checkbox",1)?>  name="vomiting" ><?=$abuseEval[$lang][14]?></td>
							<td><input type="checkbox" value="1" <?= getData("diarrhea","checkbox")?>  name="diarrhea"><?=$abuseEval[$lang][15]?></td>
							<td><input type="checkbox" value="1" <?= getData("nailPigment","checkbox")?>  name="nailPigment"><?=$abuseEval[$lang][16]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1" <?= getData("insomnia","checkbox")?>  name="insomnia"><?=$abuseEval[$lang][17]?></td>
							<td><input type="checkbox" value="1" <?= getData("nightmares","checkbox")?>  name="nightmares"><?=$abuseEval[$lang][18]?></td>
							<td><input type="checkbox" value="1" <?= getData("hairLoss","checkbox")?>  name="hairLoss"><?=$abuseEval[$lang][19]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1" <?= getData("skinDiscolor","checkbox",1)?>  name="skinDiscolor"><?=$abuseEval[$lang][20]?></td>
							<td><input type="checkbox" value="1" <?= getData("feverAndSweat","checkbox")?>  name="feverAndSweat"><?=$abuseEval[$lang][21]?></td>
							<td><input type="checkbox" value="1" <?= getData("soreThroat","checkbox")?>  name="soreThroat"><?=$abuseEval[$lang][22]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1" <?= getData("sweatyPalms","checkbox")?>  name="sweatyPalms"><?=$abuseEval[$lang][23]?></td>
							<td><input type="checkbox" value="1"  <?= getData("icyHandsFeet","checkbox")?>  name="icyHandsFeet"><?=$abuseEval[$lang][24]?></td>
							<td><input type="checkbox" value="1"  <?= getData("diffSwallow","checkbox")?>  name="diffSwallow"><?=$abuseEval[$lang][25]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1"  <?= getData("chronicGreed","checkbox")?>  name="chronicGreed"><?=$abuseEval[$lang][26]?></td>
							<td><input type="checkbox" value="1"  <?= getData("prolongedSleep","checkbox")?>  name="prolongedSleep"><?=$abuseEval[$lang][27]?></td>
							<td><input type="checkbox" value="1"  <?= getData("healthWorries","checkbox")?>  name="healthWorries"><?=$abuseEval[$lang][28]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1"  <?= getData("smokingAndAlcohol","checkbox")?>  name="smokingAndAlcohol"><?=$abuseEval[$lang][29]?></td>
							<td><input type="checkbox" value="1"  <?= getData("indigestion","checkbox")?>  name="indigestion"><?=$abuseEval[$lang][30]?></td>
							<td><input type="checkbox" value="1"  <?= getData("palpitations","checkbox")?>  name="palpitations"><?=$abuseEval[$lang][31]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1"  <?= getData("yawnSigh","checkbox")?>  name="yawnSigh"><?=$abuseEval[$lang][32]?></td>
							<td><input type="checkbox" value="1"  <?= getData("spirits","checkbox")?>  name="spirits"><?=$abuseEval[$lang][33]?></td>
							<td><input type="checkbox" value="1"  <?= getData("apathy","checkbox")?>  name="apathy"><?=$abuseEval[$lang][34]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1"  <?= getData("musclePain","checkbox")?>   name="musclePain"><?=$abuseEval[$lang][35]?></td>
							<td><input type="checkbox" value="1"  <?= getData("fatigue","checkbox")?>   name="fatigue"><?=$abuseEval[$lang][36]?></td>
							<td><input type="checkbox" value="1"  <?= getData("diffConcentrating","checkbox")?>   name="diffConcentrating"><?=$abuseEval[$lang][37]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1"  <?= getData("crying","checkbox")?>   name="crying"><?=$abuseEval[$lang][38]?></td>
							<td><input type="checkbox" value="1"  <?= getData("dryMouth","checkbox")?>   name="dryMouth"><?=$abuseEval[$lang][39]?></td>
							<td><input type="checkbox" value="1"  <?= getData("irritable","checkbox")?>   name="irritable"><?=$abuseEval[$lang][40]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="1"  <?= getData("sexualProbs","checkbox")?>   name="sexualProbs"><?=$abuseEval[$lang][41]?></td>
							<td><input type="checkbox" value="1"  <?= getData("poorSelfEsteem","checkbox")?>   name="poorSelfEsteem"><?=$abuseEval[$lang][42]?></td>
							<td><input type="checkbox" value="1"  <?= getData("muscularConvulsions","checkbox")?>   name="muscularConvulsions"><?=$abuseEval[$lang][43]?></td>
						</tr>

						<tr>
							<td><input type="checkbox" value="1"  <?= getData("menstralProbs","checkbox")?> name="menstralProbs"><?=$abuseEval[$lang][44]?></td>
							<td><input type="checkbox" value="1"  <?= getData("IBS","checkbox")?> name="IBS"><?=$abuseEval[$lang][45]?></td>
							<td><input type="checkbox" value="1"  <?= getData("dryCough","checkbox")?> name="dryCough"><?=$abuseEval[$lang][46]?></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="On"   name="sympOther" <?= getData("sympOther", "checkbox") ?> ><?=$abuseEval[$lang][47]?> <input 
type="text" name="otherSymptoms" <?= getData("otherSymptoms", "text") ?>  /></td>
						</tr>


					</table>
				</tr>

			</table>
		</td></tr>


		<tr><td>

			<table  class="b_header_nb">
				<tr>
					<td class="s_header" colspan="5">
						<?=$arvInitiation[$lang][0]?>
					</td>	
				</tr>

				<tr>
					<table>
						<tr>
							<td width="40%"><?=$arvInitiation[$lang][1]?></td>
							<td colspan=3><?=$arvInitiation[$lang][2]?>
						</tr>
						<tr>
							<td><?=$arvInitiation[$lang][3]?></td>
							<td><input type="radio" name="KnowlTreatARV[]" value="1" <?= getData("KnowlTreatARV", "radio", 1); ?> ><?=$arvInitiation[$lang][4]?></td>
							<td><input type="radio" name="KnowlTreatARV[]" value="2" <?= getData("KnowlTreatARV", "radio", 2); ?> ><?=$arvInitiation[$lang][5]?></td>
							<td><input type="radio" name="KnowlTreatARV[]" value="4" <?= getData("KnowlTreatARV", "radio", 4); ?> ><?=$arvInitiation[$lang][6]?></td>
						</tr>
						<tr>
							<td><?=$arvInitiation[$lang][7]?></td>
							<td><input type="radio" name="KnowlARVNotCure[]" value="1" <?= getData("KnowlARVNotCure", "radio", 1); ?> ><?=$arvInitiation[$lang][4]?></td>
							<td><input type="radio" name="KnowlARVNotCure[]" value="2" <?= getData("KnowlARVNotCure", "radio", 2); ?> ><?=$arvInitiation[$lang][5]?></td>
							<td><input type="radio" name="KnowlARVNotCure[]" value="4" <?= getData("KnowlARVNotCure", "radio", 4); ?> ><?=$arvInitiation[$lang][6]?></td>
						</tr>
						<tr>
							<td><?=$arvInitiation[$lang][8]?></td>
							<td><input type="radio" name="ptKnowlMedRegime[]" value="1" <?= getData("ptKnowlMedRegime","radio",1)?> ><?=$arvInitiation[$lang][4]?></td>
							<td><input type="radio" name="ptKnowlMedRegime[]" value="2" <?= getData("ptKnowlMedRegime","radio",2)?> ><?=$arvInitiation[$lang][5]?></td>
							<td><input type="radio" name="ptKnowlMedRegime[]" value="4" <?= getData("ptKnowlMedRegime","radio",4)?> ><?=$arvInitiation[$lang][6]?></td>
						</tr>
						<tr>	
							<td><?=$arvInitiation[$lang][9]?></td>
							<td><input type="radio" name="ptKnowlARVEffects[]" value="1" <?= getData("ptKnowlARVEffects","radio",1)?> ><?=$arvInitiation[$lang][4]?></td>
							<td><input type="radio" name="ptKnowlARVEffects[]" value="2" <?= getData("ptKnowlARVEffects","radio",2)?> ><?=$arvInitiation[$lang][5]?></td>
							<td><input type="radio" name="ptKnowlARVEffects[]" value="4" <?= getData("ptKnowlARVEffects","radio",4)?> ><?=$arvInitiation[$lang][6]?></td>

						</tr>
					</table>
				</tr>
			</table>
		</td></tr>




		<tr><td>

			<table  class="b_header_nb">
				<tr>
					<td class="s_header">
						<?= $evalProbs[$lang][0]?>
					</td>	
				</tr>
				<tr>
					<table style="border-collapse:collapse;">

						<tr style="font-weight:900;background-color:#bbb;"> 
							<td width="30%">  <?= $evalProbs[$lang][1]?> </td>
							<td width="24%" colspan=3>  <?= $evalProbs[$lang][2]?></td>
							<td width="25%">  <?=$evalProbs[$lang][3]?> </td>
							<td width="7%">  <?= $evalProbs[$lang][4]?> </td>
							<td width="7%">  <?= $evalProbs[$lang][5]?> </td>
							<td width="7%">  <?= $evalProbs[$lang][6]?> </td>
						</tr>

						<tr>
							<td></td>
							<td><?= $yesNo[$lang][0]?></td>
							<td><?= $yesNo[$lang][1]?></td>
							<td><?= $yesNo[$lang][2]?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>


						<tr valign="top">
							<td><?= $evalProbs[$lang][7] ?></td>
							<td><input type="radio" value="1" <?= getData("limitedARVKnowl","radio",1)?>  name="limitedARVKnowl[]" /></td>
							<td><input type="radio" value="2" <?= getData("limitedARVKnowl","radio",2)?>  name="limitedARVKnowl[]" /></td>
							<td><input type="radio" value="4" <?= getData("limitedARVKnowl","radio",4)?>  name="limitedARVKnowl[]" /></td>
							<td><?= $evalProbs[$lang][9] ?></td>
							<td><input type="checkbox" <?= getData("limitedARVKnowlGiven","checkbox")?>  value="1" name="limitedARVKnowlGiven" /></td>
							<td><input type="checkbox" <?= getData("limitedARVKnowlRef","checkbox")?>  value="1" name="limitedARVKnowlRef" /></td>
							<td><input type="checkbox" <?= getData("limitedARVKnowlNotGiven","checkbox")?>  value="1" name="limitedARVKnowlNotGiven" /></td>
						</tr>

						<tr valign="top" style="background-color:#eee;">
							<td><?= $evalProbs[$lang][10] ?></td>
							<td><input type="radio" value="1" <?= getData("contHIVTransRisk","radio",1)?>  name="contHIVTransRisk[]" /></td>
							<td><input type="radio" value="2" <?= getData("contHIVTransRisk","radio",2)?>  name="contHIVTransRisk[]" /></td>
							<td><input type="radio" value="4" <?= getData("contHIVTransRisk","radio",4)?>  name="contHIVTransRisk[]" /></td>
							<td><?= $evalProbs[$lang][11] ?></td>
							<td><input type="checkbox" <?= getData("contHIVTransRiskGiven","checkbox")?>  value="1" name="contHIVTransRiskGiven" /></td>
							<td><input type="checkbox" <?= getData("contHIVTransRiskRef","checkbox")?>  value="1" name="contHIVTransRiskRef" /></td>
							<td><input type="checkbox" <?= getData("contHIVTransRiskNotGiven","checkbox")?>  value="1" name="contHIVTransRiskNotGiven" /></td>
						</tr>

						<tr valign="top">
							<td><?= $evalProbs[$lang][12] ?></td>
							<td><input type="radio" value="1" <?= getData("mentalHealth","radio",1)?>  name="mentalHealth[]" /></td>
							<td><input type="radio" value="2" <?= getData("mentalHealth","radio",2)?>  name="mentalHealth[]" /></td>
							<td><input type="radio" value="4" <?= getData("mentalHealth","radio",4)?>  name="mentalHealth[]" /></td>
							<td><?= $evalProbs[$lang][13] ?></td>
							<td><input type="checkbox" <?= getData("mentalHealthGiven","checkbox")?>  value="1" name="mentalHealthGiven" /></td>
							<td><input type="checkbox" <?= getData("mentalHealthRef","checkbox")?>  value="1" name="mentalHealthRef" /></td>
							<td><input type="checkbox" <?= getData("mentalHealthNotGiven","checkbox")?>  value="1" name="mentalHealthNotGiven" /></td>
						</tr>

						<tr valign="top"  style="background-color:#eee;">
							<td><?= $evalProbs[$lang][14] ?></td>
							<td><input type="radio" value="1" <?= getData("drugDependence","radio",1)?>  name="drugDependence[]" /></td>
							<td><input type="radio" value="2" <?= getData("drugDependence","radio",2)?>  name="drugDependence[]" /></td>
							<td><input type="radio" value="4" <?= getData("drugDependence","radio",4)?>  name="drugDependence[]" /></td>
							<td><?= $evalProbs[$lang][15] ?></td>
							<td><input type="checkbox" <?= getData("drugDependenceGiven","checkbox")?>  value="1" name="drugDependenceGiven" /></td>
							<td><input type="checkbox" <?= getData("drugDependenceRef","checkbox")?>  value="1" name="drugDependenceRef" /></td>
							<td><input type="checkbox" <?= getData("drugDependenceNotGiven","checkbox")?>  value="1" name="drugDependenceNotGiven" /></td>
						</tr>
						<tr valign="top">
							<td><?= $evalProbs[$lang][16] ?></td>
							<td><input type="radio" value="1" <?= getData("domViolenceRisk","radio",1)?>  name="domViolenceRisk[]" /></td>
							<td><input type="radio" value="2" <?= getData("domViolenceRisk","radio",2)?>  name="domViolenceRisk[]" /></td>
							<td><input type="radio" value="4" <?= getData("domViolenceRisk","radio",4)?>  name="domViolenceRisk[]" /></td>
							<td><?= $evalProbs[$lang][17] ?></td>
							<td><input type="checkbox" <?= getData("domViolenceRiskGiven","checkbox")?>  value="1" name="domViolenceRiskGiven" /></td>
							<td><input type="checkbox" <?= getData("domViolenceRiskRef","checkbox")?>  value="1" name="domViolenceRiskRef" /></td>
							<td><input type="checkbox" <?= getData("domViolenceRiskNotGiven","checkbox")?>  value="1" name="domViolenceRiskNotGiven" /></td>
						</tr>
						<tr valign="top"  style="background-color:#eee;">
							<td><?= $evalProbs[$lang][18] ?></td>
							<td><input type="radio" value="1" <?= getData("familyPlanning","radio",1)?>  name="familyPlanning[]" /></td>
							<td><input type="radio" value="2" <?= getData("familyPlanning","radio",2)?>  name="familyPlanning[]" /></td>
							<td><input type="radio" value="4" <?= getData("familyPlanning","radio",4)?>  name="familyPlanning[]" /></td>
							<td><?= $evalProbs[$lang][19] ?></td>
							<td><input type="checkbox" <?= getData("familyPlanningGiven","checkbox")?>  value="1" name="familyPlanningGiven" /></td>
							<td><input type="checkbox" <?= getData("familyPlanningRef","checkbox")?>  value="1" name="familyPlanningRef" /></td>
							<td><input type="checkbox" <?= getData("familyPlanningNotGiven","checkbox")?>  value="1" name="familyPlanningNotGiven" /></td>
						</tr>
						<tr valign="top">
							<td><?= $evalProbs[$lang][20] ?></td>
							<td><input type="radio" value="1" <?= getData("transportationPrb","radio",1)?>  name="transportationPrb[]" /></td>
							<td><input type="radio" value="2" <?= getData("transportationPrb","radio",2)?>  name="transportationPrb[]" /></td>
							<td><input type="radio" value="4" <?= getData("transportationPrb","radio",4)?>  name="transportationPrb[]" /></td>
							<td><?= $evalProbs[$lang][21] ?></td>
							<td><input type="checkbox" <?= getData("transportationPrbGiven","checkbox")?>  value="1" name="transportationPrbGiven" /></td>
							<td><input type="checkbox" <?= getData("transportationPrbRef","checkbox")?>  value="1" name="transportationPrbRef" /></td>
							<td><input type="checkbox" <?= getData("transportationPrbNotGiven","checkbox")?>  value="1" name="transportationPrbNotGiven" /></td>
						</tr>
						<tr valign="top"  style="background-color:#eee;">
							<td><?= $evalProbs[$lang][22] ?></td>
							<td><input type="radio" value="1" <?= getData("insufficientFood","radio",1)?>  name="insufficientFood[]" /></td>
							<td><input type="radio" value="2" <?= getData("insufficientFood","radio",2)?>  name="insufficientFood[]" /></td>
							<td><input type="radio" value="4" <?= getData("insufficientFood","radio",4)?>  name="insufficientFood[]" /></td>
							<td><?= $evalProbs[$lang][23] ?></td>
							<td><input type="checkbox" <?= getData("insufficientFoodGiven","checkbox")?>  value="1" name="insufficientFoodGiven" /></td>
							<td><input type="checkbox" <?= getData("insufficientFoodRef","checkbox")?>  value="1" name="insufficientFoodRef" /></td>
							<td><input type="checkbox" <?= getData("insufficientFoodNotGiven","checkbox")?>  value="1" name="insufficientFoodNotGiven" /></td>
						</tr>
						<tr valign="top">
							<td><?= $evalProbs[$lang][24] ?></td>
							<td><input type="radio" value="1" <?= getData("housingPrbs","radio",1) ?> name="housingPrbs[]" /></td>
							<td><input type="radio" value="2" <?= getData("housingPrbs","radio",2) ?> name="housingPrbs[]" /></td>
							<td><input type="radio" value="4" <?= getData("housingPrbs","radio",4) ?> name="housingPrbs[]" /></td>
							<td><?= $evalProbs[$lang][25] ?></td>
							<td><input type="checkbox" <?= getData("housingPrbsGiven","checkbox")?>  value="1" name="housingPrbsGiven" /></td>
							<td><input type="checkbox" <?= getData("housingPrbsRef","checkbox")?>  value="1" name="housingPrbsRef" /></td>
							<td><input type="checkbox" <?= getData("housingPrbsNotGiven","checkbox")?>  value="1" name="housingPrbsNotGiven" /></td>
						</tr>
						<tr valign="top"  style="background-color:#eee;">
							<td><?= $evalProbs[$lang][26] ?></td>
							<td><input type="radio" value="1" <?= getData("hygienePrbs","radio",1)?>  name="hygienePrbs[]" /></td>
							<td><input type="radio" value="2" <?= getData("hygienePrbs","radio",2)?>  name="hygienePrbs[]" /></td>
							<td><input type="radio" value="4" <?= getData("hygienePrbs","radio",4)?>  name="hygienePrbs[]" /></td>
							<td><?= $evalProbs[$lang][27] ?></td>
							<td><input type="checkbox" <?= getData("hygienePrbsGiven","checkbox")?>  value="1" name="hygienePrbsGiven" /></td>
							<td><input type="checkbox" <?= getData("hygienePrbsRef","checkbox")?>  value="1" name="hygienePrbsRef" /></td>
							<td><input type="checkbox" <?= getData("hygienePrbsNotGiven","checkbox")?>  value="1" name="hygienePrbsNotGiven" /></td>
						</tr>
						<tr valign="top">
							<td><?= $evalProbs[$lang][28] ?><br>  <textarea cols=20 rows=5 name="otherProb"><?= getData("otherProb", "textarea")?> </textarea></td>
							<td></td>
							<td></td>
							<td></td>
							<td><?= $evalProbs[$lang][29] ?> <br> <textarea cols=20 rows=5 name="otherSrvc"><?= getData("otherSrvc", "textarea")?></textarea></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>


					</table>
				</tr>
			</table>


		</td></tr>
			

		<tr></td>

			<table  class="b_header_nb">
				<tr>
					<td class="s_header" colspan="5">
						<?=$services[$lang][0]?>
					</td>	
				</tr>
				<tr><td>
					<input type="checkbox" <?= getData("rffrlToCommunitySupportOrg","checkbox")?>  value="1" name="rffrlToCommunitySupportOrg"> <?= $services[$lang][1]?> <br>
					<input type="checkbox" <?= getData("rffrlToSupportGroup","checkbox")?>  value="1" name="rffrlToSupportGroup"> <?= $services[$lang][2]?> <br>
					<input type="checkbox" <?= getData("nutritionalSpprt","checkbox")?>  value="1" name="nutritionalSpprt"> <?= $services[$lang][3]?> <br>
					<input type="checkbox" <?= getData("freight","checkbox")?>  value="1" name="freight"> <?= $services[$lang][4]?> <br>
					<input type="checkbox" <?= getData("provisionOfCondoms","checkbox")?>  value="1" name="provisionOfCondoms"> <?= $services[$lang][5]?> <br>
					<input type="checkbox" <?= getData("contraceptionMethod","checkbox")?>  value="1" name="contraceptionMethod"> <?= $services[$lang][6]?> <br>
					<input type="checkbox" <?= getData("otherSrvcOffered","checkbox")?>  value="1" name="otherSrvcOffered"> <?= $services[$lang][7]?> <input type="text" 
name="other1Text" <?= getData("other1Text", "text") ?> /><br>
					<?= $services[$lang][8] ?> <input type="text" name="NextPsychAppt" <?= getData("NextPsychAppt","text") ?> /> <br> 
					<?= $services[$lang][9] ?> <input type="text" name="RemarksSignature2" <?= getData("RemarksSignature2", "text") ?> /> 

				</td></tr>
			</table>
		</td></tr>
	</table>
</div>


