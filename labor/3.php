<?php
require_once 'backend/form-render-ew.php';

function renderNewbornEvolution($num) {
?>
   <tr>
     <td colspan="2" class="s_header"><?= _('EVOLUTION NOUVEAU NE') . ' ' . $num ?></td>
   </tr>
   <tr>
     <td colspan="2">
       <?= renderRadio('laborEvolutionNewborn' . $num, 0, _('Référée à la pouponnière ou en suites de couche avec sa maman')) ?>
     </td>
   </tr>
   <tr>
     <td colspan="2">
       <?= renderRadio('laborEvolutionNewborn' . $num, 1, _('Référée en Pédiatrie pour')) ?> :

       <?= renderRadios('laborEvolutionNewbornReferred' . $num, array(_('Détresse respiratoire'), _('Suspicion d’infection materno-foetale'), _('Macrosomie'), _('Prématurité') . ',')) ?>
       <?= _('Autre, précisez') ?> :
       <?= renderTextArea('laborEvolutionNewbornReferredOther' . $num, 24) ?>
     </td>
   </tr>
   <tr>
     <td colspan="2">
       <?= renderRadio('laborEvolutionNewborn' . $num, 2, _('Exéaté')) ?>
       <?= renderRadio('laborEvolutionNewborn' . $num, 3, _('Décédé') . ',') ?>
       <?= _('Autre, précisez') ?> :
       <?= renderTextArea('laborEvolutionNewbornOther' . $num, 24) ?>
     </td>
   </tr>
   <tr>
     <td colspan="2">
       <?= _('Méthode d’alimentation choisie à la sortie') ?> :
       <?= renderRadios('laborEvolutionNewbornFeedingMethod' . $num, array(_('Allaitement maternel exclusif'), _('Préparation pour nourrissons'), _('Alimentation mixte'))) ?>
     </td>
   </tr>
<?php
}

function renderVitalSigns($num, $post = true) {
  ?>

<?php if (!$post) { ?>
<tr>
   <td colspan="2">
      <table width="100%">
<?php } ?>
	 <tr id="laborVitalSignsTable<?= $num ?>">
	    <?php if ($post) { ?>
	    <td><?= renderDateTimeInput('laborVitalDateTime' . $num) ?></td>
	    <?php } ?>
	    <td>
	       <?= $post ? '' : _('TA') ?>
	       <?= renderTextArea('laborVitalBp' . $num, 3) ?>/<?= renderTextArea('laborVitalBpL' . $num, 3) ?>
	       <?= renderRadios('laborVitalBpUnit' . $num, array(_('cm'), _('mm de Hg'))) ?>
	    </td>
	    <td>
	       <?= $post ? '' : _('Pouls') ?>
	       <?= renderTextArea('laborVitalHr' . $num, 3) ?>/mn
	    </td>
	    <td>
	       <?= $post ? '' : _('FR') ?>
	       <?= renderTextArea('laborVitalRr' . $num, 3) ?>/mn
	    </td>
	    <td>
	       <?= $post ? '' : 'Temp' ?>
	       <?= renderTextArea('laborVitalTemp' . $num, 5) ?>
	       <?= renderRadios('laborVitalTempUnit' . $num, array('C°', 'F°')) ?>
	    </td>
	    <?php if ($post) { ?>
	    <td><?= renderTextArea('laborVitalConsciousness' . $num, 10) ?></td>
	    <td><?= renderTextArea('laborVitalGlobeSec' . $num, 10) ?><td>
	    <?php } ?>
	 </tr>
<?php if (!$post) { ?>
      </table>
   </td>
</tr>
<?php } ?>

<script language="JavaScript" type="text/javascript">
      var laborVitalTemp<?= $num ?>Check = makeTempRangeValidation('laborVitalTemp<?= $num ?>',
								   'laborVitalTempUnit<?= $num ?>0',
								   'laborVitalTempUnit<?= $num ?>1');
      attachEventTo('laborVitalTemp<?= $num ?>', 'onblur', laborVitalTemp<?= $num ?>Check);
      attachEventTo('laborVitalSignsTable<?= $num ?>', 'onclick', laborVitalTemp<?= $num ?>Check);

      attachEventTo('laborVitalBp<?= $num ?>', 'onblur',
		    makeNumericRangeValidation('laborVitalBp<?= $num ?>', 0, 300, 22));
      attachEventTo('laborVitalBpL<?= $num ?>', 'onblur',
		    makeNumericRangeValidation('laborVitalBpL<?= $num ?>', 0, 200, 23));
      var laborVitalBpRadio<?= $num ?>Check =
	makeXorErrorValidation('laborVitalBpUnit<?= $num ?>0', 72,
			       makeTestAnyNotBlank('laborVitalBp<?= $num ?>', 
						   'laborVitalBpL<?= $num ?>'),
			       makeTestOneIsChecked('laborVitalBpUnit<?= $num ?>0',
						    'laborVitalBpUnit<?= $num ?>1'));
      attachEventTo('laborVitalSignsTable<?= $num ?>', 'onclick',
		    laborVitalBpRadio<?= $num ?>Check);
      attachEventTo('laborVitalBp<?= $num ?>', 'onblur', laborVitalBpRadio<?= $num ?>Check);
      attachEventTo('laborVitalBpL<?= $num ?>', 'onblur', laborVitalBpRadio<?= $num ?>Check);
      var laborVitalBpRadio<?= $num ?>Check2 =
	makeXorErrorValidation('laborVitalBp<?= $num ?>', 72,
			       makeTestAnyNotBlank('laborVitalBp<?= $num ?>'), 
			       makeTestAnyNotBlank('laborVitalBpL<?= $num ?>'));
      attachEventTo('laborVitalSignsTable<?= $num ?>', 'onclick',
		    laborVitalBpRadio<?= $num ?>Check2);
      attachEventTo('laborVitalBp<?= $num ?>', 'onblur', laborVitalBpRadio<?= $num ?>Check2);
      attachEventTo('laborVitalBpL<?= $num ?>', 'onblur', laborVitalBpRadio<?= $num ?>Check2);

      attachEventTo('laborVitalHr<?= $num ?>', 'onblur', 
		    makeNumericRangeValidation('laborVitalHr<?= $num ?>', 0, 360, 24));

      attachEventTo('laborVitalRr<?= $num ?>', 'onblur', 
		    makeNumericRangeValidation('laborVitalRr<?= $num ?>', 0, 360, 24));
</script>

  <?php
}

function renderBirthHistory($num, $numString) {
  ?>

  <table id="birthHistoryTable<?= $num ?>">
    <tr><td style="height:1.75em;"><?= $numString ?></td></tr>
    <tr><td style="height:1.75em;"><?= renderRadio('birthHistoryMortality' . $num, 0, '&nbsp;') ?></td></tr>
    <tr><td style="height:1.75em;"><?= renderRadio('birthHistoryMortality' . $num, 1, '&nbsp;') ?></td></tr>
    <tr><td style="height:1.75em;"><?= renderRadio('birthHistoryMortality' . $num, 2, '&nbsp;') ?></td></tr>
    <tr><td style="height:2em;"><?= renderDateTimeInput('birthHistoryFetalDeathDate' . $num) ?></td></tr>
    <tr><td style="height:1.75em;"><?= renderRadio('birthHistoryMortality' . $num, 3, '&nbsp;') ?></td></tr>
    <tr><td style="height:2em;">
	<?= renderTextArea('birthHistoryApgar1' . $num, 2) ?>,
	<?= renderTextArea('birthHistoryApgar5' . $num, 2) ?>
    </td></tr>
    <tr><td style="height:2em;">
	<?= renderTextArea('birthHistoryWeight' . $num, 3) ?>
	<?= renderRadios('birthHistoryWeightUnit' . $num, array('kg', 'lb')) ?>
    </td></tr>
    <tr><td style="height:2em;">
	<?= renderTextArea('birthHistoryHeadCircumference' . $num, 3) ?> cm /
	<?= renderTextArea('birthHistoryHeight' . $num, 3) ?> cm
    </td></tr>
    <tr><td style="height:1.75em;"><?= renderRadios('birthHistorySex' . $num, array(_('Masc.'), _('Fém.'))) ?></td></tr>
    <tr><td style="height:1.75em;">
	<?= renderRadios('birthHistoryVaccinePolio' . $num, array(_('Polio O')), null, true) ?>
	<?= renderRadios('birthHistoryVaccineBcg' . $num, array(_('BCG')), null, true) ?>
    </td></tr>
    <tr><td style="height:1.75em;"><?= renderRadios('birthHistoryVitamineK1' . $num, array(_('Oui'), _('Non'))) ?></td></tr> 
    <tr><td style="height:1.75em;"><?= renderRadios('birthHistoryCongenitalMalformation' . $num, array(_('Oui'), _('Non'))) ?></td></tr>
    <tr><td style="height:1.75em;"><?= renderRadios('birthHistoryBreastfeedingFirstHour' . $num, array(_('Oui'), _('Non'))) ?></td></tr>
  </table>
  
<script language="JavaScript" type="text/javascript">
      attachEventTo('birthHistoryWeight<?= $num ?>', 'onblur',
		    makeNumericRangeValidation('birthHistoryWeight<?= $num ?>', 0, 500, 25));
      var birthHistoryWeight<?= $num ?>Check =
	makeXorErrorValidation('birthHistoryWeight<?= $num ?>', 72,
			       makeTestAnyNotBlank('birthHistoryWeight<?= $num ?>'),
			       makeTestOneIsChecked('birthHistoryWeightUnit<?= $num ?>0',
						    'birthHistoryWeightUnit<?= $num ?>1'));
      attachEventTo('birthHistoryTable<?= $num ?>', 'onclick',
		    birthHistoryWeight<?= $num ?>Check);
      attachEventTo('birthHistoryWeight<?= $num ?>', 'onblur', birthHistoryWeight<?= $num ?>Check);
</script>

  <?php
}

?>
<script language="JavaScript" type="text/javascript" src="labor/0.js"></script>

<style type="text/css">

.sectionLines {
    border-width: 1px 0px 0px 0px;
    border-style: solid;
    padding: 2px 0px 0px 0px;
}

.collapsedNoBorder {
    border-collapse: collapse;
    border: 0px;
}

</style>

<div id="tab-panes">

<!-- ******************************************************************** -->
<!-- ************************ Labor & Delivery ************************** -->
<!-- ******************************************************************** -->

<div id="pane1">
<table width="100%">
  <tr>
    <td colspan="2">
      <table width="100%">
	<tr>
	  <td>
	    <?= _('Grossesse Suivie') ?> : <?= renderRadios('laborFollowed', array(_('Oui'), _('Non'))) ?>
	  </td>
	  <td id="laborVitalSignsCell1">
	    <?= _('Poids') ?>
	    <?= renderTextArea('laborVitalWeight1', 3) ?>
	    <?= renderRadios('laborVitalWeightUnit1', array('kg', 'lb')) ?>
	  </td>
	  <td>
	    <?= _('Age') ?>
	    <?= renderTextArea('laborAge', 2) ?>
	  </td>
	  <td>
	    G
	    <?= renderTextArea('gravida', 2) ?>
	    P
	    <?= renderTextArea('para', 2) ?>
	    A
	    <?= renderTextArea('aborta', 4) ?>
	    EV
	    <?= renderTextArea('liveChilds', 2) ?>
	  </td>
	</tr>
      </table>
      <table width="100%">
	<tr>
	  <td>
	    <?= _('Grossesse désirée') ?> : <?= renderRadios('laborWantedPregnancy', array(_('Oui'), _('Non'))) ?>
	  </td>
	  <td>
	    <?= _('Référence') ?> : <?= renderRadios('laborReference', array(_('Oui'), _('Non'))) ?>
	    &nbsp;
	    <?= _('Si oui') ?> : <?= renderRadios('laborReferenceType', array(_('Matrone'), _('Autre'))) ?>
	  </td>
	</tr>
	<tr>
	  <td>
	    <?= _('Prophylaxie contre la Malaria') ?> : <?= renderRadios('laborProphylaxisAgainstMalaria', array(_('Oui'), _('Non'))) ?>
	  </td>
	</tr>
      </table>
    </td>
  </tr>

   <tr>
      <td colspan="2" class="s_header"><?= _('TRAVAIL ET ACCOUCHEMENT') ?></td>
   </tr>

  <tr>
    <td colspan="2">
      <table width="80%">
	<tr>
	  <td>
	    <table>
	      <tr>
		<td>
		  <?= _('Heure d’admission') ?>
		</td>
		<td>
		  <?= renderTextArea('laborAdmissionTime', 5) ?>
		</td>
		<td>
		  (24h)
		</td>
	      </tr>
	    </table>
	  </td>
	  <td>
	    <?= _('Grossesse') ?> :
	    <?= renderRadios('laborPregnancyType', array(_('Unique'), _('Gémellaire'), _('Multiple'))) ?>
	  </td>
	</tr>
      </table>
    </td>
  </tr>

   <tr>
      <td class="s_header"><?= _('DÉBUT DU TRAVAIL') ?></td>
      <td class="s_header"><?= _('ACCOUCHEMENT') ?></td>
   </tr>

   <tr>
      <td width="50%" valign="top">
	 <table>
	    <tr>
	       <td>
		  <table class="collapsedNoBorder"><tr>
		  <td><?= _('Date et Heure') ?> :&nbsp;</td>
		  <td><?= renderDateTimeInput('laborStart') ?></td>
		  </tr></table>
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines">
		  <?= _('Age gestationnel') ?> :
		  <?= renderTextArea('laborGestationalAge', 2) ?>
		  <?= _('semaines') ?>
		  &nbsp;&nbsp;
		  <?= _('Hauteur Utérine') ?>
		  <?= renderTextArea('laborUterine', 2) ?>
		  cm
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines" id="laborPresentationCell">
		 <table class="collapsedNoBorder">
		   <tr>
		     <td><?= _('Présentation') ?> :&nbsp;</td>
		     <td>
		       <?= renderRadio('laborPresentation', 0, _('Céphalique') . ', ' . _('précisez')) ?>:
		       <?= renderTextArea('laborPresentationCephalicOther', 11) ?>
		       <?= renderRadio('laborPresentation', 1, _('Siège')) ?>
		     </td>
		   </tr>
		   <tr>
		     <td></td>
		     <td>
		       <?= renderRadio('laborPresentation', 2, _('Transversale') . ', ' . _('précisez')) ?>:
		       <?= renderTextArea('laborPresentationTransverseOther', 11) ?>
		     </td>
		   </tr>
		 </table>
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines">
		  <?= _('Rythme Cardiaque Foetal') ?>
		  <?= renderTextArea('laborFetalHeartRate', 3) ?>/mn
		  <?= _('Fièvre') ?> :
		  <?= renderRadios('laborFever', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines">
		  <?= _('Rupture des membranes') ?> :
		  <?= renderRadios('laborInduced', array(_('Spontanée'), _('Provoquée'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <table class="collapsedNoBorder"><tr>
		  <td><?= _('Date et Heure') ?>&nbsp;</td>
		  <td><?= renderDateTimeInput('laborMembraneBroke') ?></td>
		  </tr></table>
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines">
		  <?= _('Liquide Amniotique') ?> :
		  <?= renderRadios('laborFeces', array(_('Claire'), _('Teinté'), _('Méconiale'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines">
		  <?= _('Dystocie') ?> :
		  <?= renderRadios('laborDifficultBirth', array(_('Mécanique'), _('Dynamique'), _('Autre'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td class="sectionLines">
		  <?= _('Procidence du Cordon') ?> :
		  <?= renderRadios('laborProlapsedCord', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	    <tr>
	      <td id="laborVaginalBleedingCell" class="sectionLines">
		<?= _('Hémorragie vaginale') ?> :
		<?= renderRadios('laborVaginalBleeding', array(_('Oui'), _('Non'))) ?>
		<?= _('Si oui, précisez') ?> :
		<br>
		<?= renderRadio('laborVaginalBleedingReason', 0, _('Abruptio placentae')) ?>
		<?= renderRadio('laborVaginalBleedingReason', 1, _('Placenta prævia')) ?>
		<?= renderRadio('laborVaginalBleedingReason', 2, _('Rupture utérine')) ?>
		<br>
		<?= renderRadio('laborVaginalBleedingReason', 3, _('Autre, précisez')) ?> :
		<?= renderTextArea('laborVaginalBleedingReasonOther', 40) ?>
	      </td>
	    </tr>
	    <tr>
	      <td>
		<?= _('Perte sanguine estimée à') ?> :
		<?= renderTextArea('laborBloodLossEstimation', 15) ?>
		<br>
		<?= _('Transfusion') ?> :
		<?= renderRadios('laborTransfusion', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('HTA') ?> :
		<?= renderRadios('laborHTA', array(_('Oui'), _('Non'))) ?>
		<?= _('Pré éclampsie Sévère') ?> :
		<?= renderRadios('laborPES', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Eclampsie') ?> :
		<?= renderRadios('laborEclampsia', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	 </table>
      </td>
      <td width="50%" valign="top">
	 <table>
	    <tr>
	       <td>
		  <table class="collapsedNoBorder"><tr>
		  <td><?= _('Date et Heure') ?>&nbsp;</td>
		  <td><?= renderDateTimeInput('laborChildbirth') ?></td>
		  </tr></table>
	       </td>
	    </tr>
	    <tr>
               <td class="sectionLines">
		 <table class="collapsedNoBorder">
		   <tr>
		     <td>
		       <?= _('Lieu Accouchement') ?> : 
		     </td>
		     <td>
                       <?= renderRadio('laborLocation2', 0, _('Institution actuelle')) ?>
                       <?= renderRadio('laborLocation2', 1, _('Domicile')) ?>
		     </td>
		   </tr>
		   <tr>
		     <td>
		     </td>
		     <td>
                       <?= renderRadio('laborLocation2', 2, _('Autre Institution')) ?>
                       <?= renderRadio('laborLocation2', 3, _('Autre')) ?>
		     </td>
		   </tr>
		 </table>
               </td>
            </tr>
	    <tr>
	      <td>
		<?= _('Si accouchement à domicile, assisté par Matrone') ?> :
		<?= renderRadios('laborMidwife', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines" id="laborMethodCell">
		<table class="collapsedNoBorder">
		  <tr>
		    <!--
		    <td style="vertical-align: top;">
		      <?= renderRadio('laborMethod', 0, _('Vaginal')) ?>
		    </td>
		    -->
		    <td>
		      <?= _('Vaginal') ?> :
		      <?= renderRadios('laborMystery', array(_('Oui'), _('Non'))) ?>
		      <!--
		      <?= _('Episio') ?>
		      <?= renderRadios('laborEpisio', array(_('Oui'), _('Non'))) ?>
		      <?= _('Si oui, Réparée') ?>
		      <?= renderRadios('laborEpisioRepaired', array(_('Oui'), _('Non'))) ?>
		      -->
		    </td>
		  </tr>
		  <tr>
		    <td class="sectionLines">
		      <?= _('Forceps') ?> :
		      <?= renderRadios('laborForceps', array(_('Oui'), _('Non'))) ?>
		      <?= _('Vacuum') ?> :
		      <?= renderRadios('laborVacuum', array(_('Oui'), _('Non'))) ?>
		    </td>
		  </tr>
		</table>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Ligature tardive du cordon') ?> :
		<?= renderRadios('laborLateCordLigation', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Délivrance') ?> :
		<?= renderRadios('laborDelivery', array(_('Naturelle'), _('Artificielle'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Placenta') ?> :
		<?= renderRadios('laborPlacenta', array(_('Complet/Total'), _('Incomplet'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Membranes Complètes') ?> :
		<?= renderRadios('laborMembranesComplete', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Rétention Placentaire') ?> :
		<?= renderRadios('laborPlacentalRetention', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td id="laborPerineumLacerationCell" class="sectionLines">
		<?= _('Lacération du périnée') ?> :
		<?= renderRadios('laborPerineumLaceration', array(_('Oui'), _('Non'))) ?>
		<br>
		<?= _('Si oui, réparation') ?> :
		<?= renderRadios('laborPerineumRepaired', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines" id="laborMethodCell2">
		<?= renderRadio('laborMethod', 1, _('Césarienne')) ?> :
		<?= _('Indication') ?>
		<?= renderTextArea('laborCesareanIndication', 24) ?>
		<br>
		<?= renderRadio('laborMethod', 2, _('Section césarienne + Hystérectomie')) ?>
	      </td>
	    </tr>
	    <tr>
	      <td>
	      </td>
	    </tr>
	    <tr>
	      <td class="sectionLines">
		<?= _('Counseling sur la Nutrition du Nouveau-né') ?> :
		<?= renderRadios('laborNutritionCounseling', array(_('Oui'), _('Non'))) ?>
	      </td>
	    </tr>
	 </table>
      </td>
   </tr>

   <tr>
     <td colspan="2" class="sectionLines" style="text-align: center; font-style: italic; font-size: 10pt; font-weight: bold;"><?= _('MEDICAMENTS') ?></td>
   </tr>
   <tr>
      <td width="50%" valign="top">
	 <table>
	    <tr>
	      <td id="laborTarCell">
		<?=_('Si VIH positif')?> : <?=_('TAR')?>
		<?= renderRadios('laborTar', array(_('Oui'), _('Non'))) ?>
		<?=_('Précisez')?>
		<?= renderTextArea('laborTarOther', 11) ?>
	      </td>
	    </tr>
	    <tr>
	       <td>
		 <table class="collapsedNoBorder">
		   <tr>
		     <td>
		       <?= _('Prophylaxie ARV') ?> :
		     </td>
		     <td>
		       <?= renderRadio('laborProphylaxisArv', 6, 'TDF+3TC+EFV') ?>
		       <?= renderRadio('laborProphylaxisArv', 7, 'AZT+3TC+EFV') ?>
		     </td>
		   </tr>
		   <tr>
		     <td></td>
		     <td>
		       <?= renderRadio('laborProphylaxisArv', 3, _('Autre, précisez')) ?> :
		       <?= renderTextArea('laborProphylaxisArvOther', 11) ?>
		     </td>
		   </tr>
		 </table>
	       </td>
	    </tr>
	    <tr>
	       <td id="laborProphylaxisAtHomeCell">
		  <?= _('Si accouchement à domicile, a pris prophylaxie') ?> :
		  <?= renderRadios('laborProphylaxisAtHome', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	 <!--   
	    <tr>
	       <td id="laborProphylaxisAtHomeArvCell">
		  <?= _('Si oui') ?>
		  <?= renderRadio('laborProphylaxisAtHomeArv', 0, 'NVP') ?>
		  <?= renderRadio('laborProphylaxisAtHomeArv', 4, 'AZT') ?>
		  <?= renderRadio('laborProphylaxisAtHomeArv', 1, 'AZT+3TC') ?>
		  <?= renderRadio('laborProphylaxisAtHomeArv', 5, 'AZT+3TC+NVP') ?>
		   options form old form
		  <?= renderRadio('laborProphylaxisAtHomeArv', 2, _('TAR Spécifier')) ?>
		  <?= renderTextArea('laborProphylaxisAtHomeArvOther', 11) ?>
	       </td>
	    </tr>   
	-->
	 </table>
      </td>

      <td width="50%" valign="top">
	 <table>
	    <tr>
	       <td id="laborNewbornProphylaxisCell">
		  <?= _('Prophylaxie ARV Nouveau-né') ?> :
		  <?= renderRadios('laborNewbornProphylaxis', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	    <tr>
	      <td id="laborNewbornProphylaxisArvCell">
		<table class="collapsedNoBorder">
		  <tr>
		    <td>
		      <?= _('Si oui') ?>,
		      <?= renderRadio('laborNewbornProphylaxisArv', 0, 'NVP') ?>
		      <?= renderRadio('laborNewbornProphylaxisArv', 4, 'AZT') ?>
		<!--  <?= renderRadio('laborNewbornProphylaxisArv', 1, 'AZT+3TC') ?>
		       The numbers are out of order so that answers to this quesiton match the answers to the last to. Maybe we will need another option in the future?
			<?= renderRadio('laborNewbornProphylaxisArv', 5, 'AZT+3TC+NVP') ?>
		    </td>
		    <td>
		      <?= _('Date de Début') ?>
		    </td>
		    <td>
		      <?= renderDateTimeInput('laborOnset', false) ?>    
		-->
		    </td>
		  </tr>
		</table>
	      </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('Autres médicaments, Précisez, posologie') ?>
		  <br>
		  <?= renderTextArea('laborOtherMedications', 60, 2) ?>
	       </td>
	    </tr>
	 </table>
      </td>
   </tr>

   <tr>
     <td colspan="2" class="s_header"><?= _('TABLEAU DE NAISSANCE') ?></td>
   </tr>
   <tr>
     <td colspan="2">
       <table width="100%">
	 <tr>
	   <td style="vertical-align:top;">
	     <table>
	       <tr><td style="height:1.75em;">&nbsp;</td></tr>
	       <tr><td style="height:1.75em;" colspan="2"><?= _('Naissance Vivante') ?></td></tr>
	       <tr><td style="height:1.75em;"></td><td><?= _('Macérée') ?></td></tr>
	       <tr><td style="height:1.75em;"><?= _('Mort Fœtale') ?>&nbsp;&nbsp;&nbsp;</td><td><?= _('Non Macérée') ?></td></tr>
	       <tr><td style="height:2em;"></td><td><?= _('Date et Heure') ?></td></tr>
	       <tr><td style="height:1.75em;" colspan="2"><?= _('Mort Néonatale') ?></td></tr>
	       <tr><td style="height:2em;" colspan="2">APGAR : 1mn - 5mn</td></tr>
	       <tr><td style="height:2em;" colspan="2"><?= _('Poids du (ou des) Nné(s)') ?></td></tr>
	       <tr><td style="height:2em;" colspan="2"><?= _('Périmètre Crânien et Taille') ?></td></tr>
	       <tr><td style="height:1.75em;" colspan="2"><?= _('Sexe') ?></td></tr>
	       <tr><td style="height:1.75em;" colspan="2"><?= _('Vaccins') ?></td></tr>
	       <tr><td style="height:1.75em;" colspan="2"><?= _('Vitamine K1') ?></td></tr> 
	       <tr><td style="height:1.75em; white-space: nowrap; overflow: hidden;" colspan="2"><?= _('Malformation Congénitale visible') ?></td></tr>
	       <tr><td style="height:1.75em; white-space: nowrap; overflow: hidden;" colspan="2"><?= _('Allaitement maternel 1 ère heure') ?></td></tr>
	     </table>
	   </td>
	   <td style="vertical-align:top;"><?php renderBirthHistory(1, _('1er')); ?></td>
	   <td style="vertical-align:top;"><?php renderBirthHistory(2, _('2eme')); ?></td>
	   <td style="vertical-align:top;"><?php renderBirthHistory(3, _('3eme')); ?></td>
	   <td style="vertical-align:top;"><?php renderBirthHistory(4, _('4eme')); ?></td>
	 </tr>
       </table>
     </td>
   </tr>

   <tr>
     <td colspan="2" class="s_header"><?= _('SIGNES VITAUX A L’ADMISSSION') ?></td>
   </tr>
   <?php renderVitalSigns(1, false); ?>
   <tr>
     <td colspan="2" class="s_header"><?= _('SIGNES VITAUX POST PARTUM ET ETAT DE CONSCIENCE') ?></td>
   </tr>
   <tr>
     <td colspan="2">
       <table width="100%">
	 <tr>
	   <td><?= _('Date et Heure') ?></td>
	   <td><?= _('TA') ?></td>
	   <td><?= _('Pouls') ?></td>
	   <td><?= _('FR') ?></td>
	   <td><?= _('Température') ?></td>
	   <td><?= _('Conscience') ?></td>
	   <td><?= _('Globe Sec.') ?></td>
	   <td></td>
	 </tr>
	 <?php renderVitalSigns(2); ?>
	 <?php renderVitalSigns(3); ?>
	 <?php renderVitalSigns(4); ?>
	 <?php renderVitalSigns(5); ?>
	 <?php renderVitalSigns(6); ?>
	 <?php renderVitalSigns(7); ?>
       </table>
     </td>
   </tr>

   <tr>
     <td colspan="2" class="s_header"><?= _('EVOLUTION MERE') ?></td>
   </tr>
   <tr>
     <td colspan="2">
       <?= renderRadio('laborEvolution', 0, _('Référée en suites de couche')) ?>
     </td>
   </tr>
   <tr>
     <td colspan="2">
       <?= renderRadio('laborEvolution', 1, _('Référée en pathologie pour')) ?> :
       <?= renderRadios('laborEvolutionPathology', array(_('HTA'), _('Hémorragie'),
							 _('Infection'), _('Post op'),
							 _('Cardiomyopathie') . ',')) ?>
       <?= _('Autre') ?> :
       <?= renderTextArea('laborEvolutionPathologyOther', 24) ?>
     </td>
   </tr>
   <tr>
     <td colspan="2">
       <?= renderRadio('laborEvolution', 2, _('Exéatée')) ?>
       <?= renderRadio('laborEvolution', 3, _('Décédée') . ',') ?>
       <?= _('Autre, précisez') ?> :
       <?= renderTextArea('laborEvolutionOther', 24) ?>
     </td>
   </tr>
   <tr>
     <td colspan="2">
       <?= _('Choix d’une méthode contraceptive') ?> :
       <?= renderRadios('laborContraceptiveMethodChosen', array(_('Oui'), _('Non') . ',')) ?>
       <?= _('Si oui, précisez') ?> :
       <?= renderTextArea('laborContraceptiveMethodChosenSpecify', 24) ?>
     </td>
   </tr>

   <?php renderNewbornEvolution(1); ?>
   <?php renderNewbornEvolution(2); ?>
   <?php renderNewbornEvolution(3); ?>

   <?php $tabIndex = 21000; include ("include/nextVisitDate.php"); ?>

</table>
</div>
</div>

<?php
if ($tabsOn) {
  echo "</div>";
}
?>

<script language="JavaScript" type="text/javascript">
formatAsTimeField('laborAdmissionTime', true, true);


attachEventTo('laborVitalWeight1', 'onblur',
	      makeNumericRangeValidation('laborVitalWeight1', 0, 500, 25));
var laborVitalWeight1Check =
    makeXorErrorValidation('laborVitalWeight1', 72,
			   makeTestAnyNotBlank('laborVitalWeight1'),
			   makeTestOneIsChecked('laborVitalWeightUnit10',
						'laborVitalWeightUnit11'));
attachEventTo('laborVitalSignsCell1', 'onclick',
	      laborVitalWeight1Check);
attachEventTo('laborVitalWeight1', 'onblur', laborVitalWeight1Check);


attachEventTo('laborAge', 'onblur', 
	      makeNumericRangeValidation('laborAge', 1, 120, 31));

attachEventTo('laborGestationalAge', 'onblur', 
	      makeNumericRangeValidation('laborGestationalAge', 1, 45, 86));

attachEventTo('laborUterine', 'onblur', 
	      makeNumericRangeValidation('laborUterine', 1, 37, 84));


var laborCephalicCheck =
  makeXorErrorValidation('laborPresentationCephalicOther', 72,
			 makeTestAnyNotBlank('laborPresentationCephalicOther'),
			 makeTestOneIsChecked('laborPresentation0'));
attachEventTo('laborPresentationCell', 'onclick', laborCephalicCheck);
attachEventTo('laborPresentationCephalicOther', 'onblur', laborCephalicCheck);

var laborTransverseCheck =
  makeXorErrorValidation('laborPresentationTransverseOther', 72,
			 makeTestAnyNotBlank('laborPresentationTransverseOther'),
			 makeTestOneIsChecked('laborPresentation2'));
attachEventTo('laborPresentationCell', 'onclick', laborTransverseCheck);
attachEventTo('laborPresentationTransverseOther', 'onblur', laborTransverseCheck);


var laborTarCheck =
  makeXorErrorValidation('laborTarOther', 72,
			 makeTestAnyNotBlank('laborTarOther'),
			 makeTestOneIsChecked('laborTar0'));
attachEventTo('laborTarCell', 'onclick', laborTarCheck);
attachEventTo('laborTarOther', 'onblur', laborTarCheck);


var laborProphylaxisAtHomeCheck =
  makeXorErrorValidation('laborProphylaxisAtHome0', 72,
			 makeTestOneIsChecked('laborProphylaxisAtHome0'),
			 makeTestOneIsChecked('laborProphylaxisAtHomeArv0',
					      'laborProphylaxisAtHomeArv4',
					      'laborProphylaxisAtHomeArv1',
					      'laborProphylaxisAtHomeArv5'));
attachEventTo('laborProphylaxisAtHomeCell', 'onclick', laborProphylaxisAtHomeCheck);
attachEventTo('laborProphylaxisAtHomeArvCell', 'onclick', laborProphylaxisAtHomeCheck);

var laborNewbornProphylaxisCheck =
  makeXorErrorValidation('laborNewbornProphylaxis0', 72,
			 makeTestOneIsChecked('laborNewbornProphylaxis0'),
			 makeTestOneIsChecked('laborNewbornProphylaxisArv0',
					      'laborNewbornProphylaxisArv4',
					      'laborNewbornProphylaxisArv1'));
attachEventTo('laborNewbornProphylaxisCell', 'onclick', laborNewbornProphylaxisCheck);
attachEventTo('laborNewbornProphylaxisArvCell', 'onclick', laborNewbornProphylaxisCheck);

/*
var laborMethodTest1 = makeXorErrorValidation('laborEpisio0', 72,
					      makeTestOneIsChecked('laborMethod0'),
					      makeTestOneIsChecked('laborEpisio0', 'laborEpisio1'));
attachEventTo('laborMethodCell', 'onclick', laborMethodTest1);
attachEventTo('laborMethodCell2', 'onclick', laborMethodTest1);
*/

/*
var laborMethodTest2 = makeXorErrorValidation('laborVacuum0', 72,
					      makeTestOneIsChecked('laborMethod0'),
					      makeTestOneIsChecked('laborVacuum0', 'laborVacuum1'));
attachEventTo('laborMethodCell', 'onclick', laborMethodTest2);
attachEventTo('laborMethodCell2', 'onclick', laborMethodTest2);

var laborMethodTest3 = makeXorErrorValidation('laborForceps0', 72,
					      makeTestOneIsChecked('laborMethod0'),
					      makeTestOneIsChecked('laborForceps0', 'laborForceps1'));
attachEventTo('laborMethodCell', 'onclick', laborMethodTest3);
attachEventTo('laborMethodCell2', 'onclick', laborMethodTest3);
*/

/*
attachEventTo('laborMethodCell', 'onclick',
	      makeXorErrorValidation('laborEpisioRepaired0', 72,
				     makeTestOneIsChecked('laborEpisio0'),
				     makeTestOneIsChecked('laborEpisioRepaired0', 'laborEpisioRepaired1')));
*/

var cesareanIndicationCheck =
  makeXorErrorValidation('laborCesareanIndication', 72,
			 makeTestAnyNotBlank('laborCesareanIndication'),
			 makeTestOneIsChecked('laborMethod1'));
attachEventTo('laborMethodCell', 'onclick', cesareanIndicationCheck);
attachEventTo('laborMethodCell2', 'onclick', cesareanIndicationCheck);
attachEventTo('laborCesareanIndication', 'onblur', cesareanIndicationCheck);


attachEventTo('laborPerineumLacerationCell', 'onclick',
	      makeXorErrorValidation('laborPerineumRepaired0', 72,
				     makeTestOneIsChecked('laborPerineumLaceration0'),
				     makeTestOneIsChecked('laborPerineumRepaired0',
							  'laborPerineumRepaired1')));

attachEventTo('laborVaginalBleedingCell', 'onclick',
	      makeXorErrorValidation('laborVaginalBleedingReason0', 72,
				     makeTestOneIsChecked('laborVaginalBleeding0'),
				     makeTestOneIsChecked('laborVaginalBleedingReason0',
							  'laborVaginalBleedingReason1',
							  'laborVaginalBleedingReason2',
							  'laborVaginalBleedingReason3')));
var vaginalBleedingReasonOtherCheck =
  makeXorErrorValidation('laborVaginalBleedingReasonOther', 72,
			 makeTestAnyNotBlank('laborVaginalBleedingReasonOther'),
			 makeTestOneIsChecked('laborVaginalBleedingReason3'));
attachEventTo('laborVaginalBleedingCell', 'onclick', vaginalBleedingReasonOtherCheck);
attachEventTo('laborVaginalBleedingReasonOther', 'onblur', vaginalBleedingReasonOtherCheck);



var laborStartFutureCheck = makeDateNotFutureValidation('laborStart');
attachEventTo('laborStartDate', 'onblur', laborStartFutureCheck);
attachEventTo('laborStartTime', 'onblur', laborStartFutureCheck);

var laborMembraneBrokeFutureCheck = makeDateNotFutureValidation('laborMembraneBroke');
attachEventTo('laborMembraneBrokeDate', 'onblur', laborMembraneBrokeFutureCheck);
attachEventTo('laborMembraneBrokeTime', 'onblur', laborMembraneBrokeFutureCheck);

var laborChildbirthFutureCheck = makeDateNotFutureValidation('laborChildbirth');
attachEventTo('laborChildbirthDate', 'onblur', laborChildbirthFutureCheck);
attachEventTo('laborChildbirthTime', 'onblur', laborChildbirthFutureCheck);
</script>
