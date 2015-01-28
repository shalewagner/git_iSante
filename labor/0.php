<?php
//This comment is jùst so emacs get's the character encoding correct.

require_once 'backend/form-render-ew.php';

function renderVitalSigns($num, $label) {
  ?>
<tr>
   <td colspan="2" class="s_header"><?= $label ?></td>
</tr>

<tr>
   <td colspan="2">
      <table width="100%" id="laborVitalSignsTable<?= $num ?>">
	 <tr>
	    <td>
	       Temp
	       <?= renderTextArea('laborVitalTemp' . $num, 5) ?>
	       <?= renderRadios('laborVitalTempUnit' . $num, array('C°', 'F°')) ?>
	    </td>
	    <td>
	       <?= _('Pouls') ?>
	       <?= renderTextArea('laborVitalHr' . $num, 3) ?>/mn
	    </td>
	    <td>
	       <?= _('FR') ?>
	       <?= renderTextArea('laborVitalRr' . $num, 3) ?>/mn
	    </td>
	    <td>
	       <?= _('TA') ?>
	       <?= renderTextArea('laborVitalBp' . $num, 3) ?>/<?= renderTextArea('laborVitalBpL' . $num, 3) ?>
	       <?= renderRadios('laborVitalBpUnit' . $num, array(_('cm de Hg'), _('mm de Hg'))) ?>
	    </td>
	    <td>
	       <?= _('Pds') ?>
	       <?= renderTextArea('laborVitalWeight' . $num, 3) ?>
	       <?= renderRadios('laborVitalWeightUnit' . $num, array('kg', 'lb')) ?>
	    </td>
	 </tr>
      </table>

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
	makeXorErrorValidation('laborVitalBp<?= $num ?>', 72,
			       makeTestAnyNotBlank('laborVitalBp<?= $num ?>', 
						   'laborVitalBpL<?= $num ?>'),
			       makeTestOneIsChecked('laborVitalBpUnit<?= $num ?>0',
						    'laborVitalBpUnit<?= $num ?>1'));
      attachEventTo('laborVitalSignsTable<?= $num ?>', 'onclick',
		    laborVitalBpRadio<?= $num ?>Check);
      attachEventTo('laborVitalBp<?= $num ?>', 'onblur', laborVitalBpRadio<?= $num ?>Check);
      attachEventTo('laborVitalBpL<?= $num ?>', 'onblur', laborVitalBpRadio<?= $num ?>Check);

      attachEventTo('laborVitalHr<?= $num ?>', 'onblur', 
		    makeNumericRangeValidation('laborVitalHr<?= $num ?>', 0, 360, 24));

      attachEventTo('laborVitalRr<?= $num ?>', 'onblur', 
		    makeNumericRangeValidation('laborVitalRr<?= $num ?>', 0, 360, 24));

      attachEventTo('laborVitalWeight<?= $num ?>', 'onblur',
			 makeNumericRangeValidation('laborVitalWeight<?= $num ?>', 0, 500, 25));
      var laborVitalWeight<?= $num ?>Check =
	makeXorErrorValidation('laborVitalWeight<?= $num ?>', 72,
			       makeTestAnyNotBlank('laborVitalWeight<?= $num ?>'),
			       makeTestOneIsChecked('laborVitalWeightUnit<?= $num ?>0',
						    'laborVitalWeightUnit<?= $num ?>1'));
      attachEventTo('laborVitalSignsTable<?= $num ?>', 'onclick',
		    laborVitalWeight<?= $num ?>Check);
      attachEventTo('laborVitalWeight<?= $num ?>', 'onblur', laborVitalWeight<?= $num ?>Check);
      </script>

   </td>
</tr>
  <?php
}

?>
<script language="JavaScript" type="text/javascript" src="labor/0.js"></script>

<div id="tab-panes">

<!-- ******************************************************************** -->
<!-- ************************ Labor & Delivery ************************** -->
<!-- ******************************************************************** -->

<div id="pane1">
<table width="100%">
   <tr>
      <td colspan="2" class="s_header"><?= _('TRAVAIL ET ACCOUCHEMENT') ?></td>
   </tr>
   <tr>
      <td width="50%" valign="top">
	 <table>
	    <tr>
	       <td id="laborLocationCell">
		  <?= _('Lieu') ?>
		  <?= renderRadio('laborLocation', 1, _('Hôpital')) ?>
		  <?= renderTextArea('laborLocationHospital', 25) ?>
		  <?= renderRadio('laborLocation', 0, _('Domicile')) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <table style="border-collapse: collapse; border: 0px;"><tr>
		  <td><?= _('Date et Heure de début du Travail') ?>&nbsp;</td>
		  <td><?= renderDateTimeInput('laborStart') ?></td>
		  </tr></table>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('Age gestationnel') ?>
		  <?= renderTextArea('laborGestationalAge', 2) ?>
		  <?= _('semaines') ?>
		  &nbsp;&nbsp;
		  <?= _('Hauteur Utérine') ?>
		  <?= renderTextArea('laborUterine', 2) ?>
		  cm
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('Présentation') ?>
		  <?= renderRadios('laborPresentation', array(_('Céphalique'), _('Siège'), _('Transversale'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('Rythme cardiaque foetal') ?>
		  <?= renderTextArea('laborFetalHeartRate', 3) ?>
		  <?= _('Fièvre') ?>
		  <?= renderRadios('laborFever', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <b><?= _('Rupture des membranes') ?></b>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= renderRadios('laborInduced', array(_('Spontanée'), _('Provoquée'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <table style="border-collapse: collapse; border: 0px;"><tr>
		  <td><?= _('Date/Heure') ?>&nbsp;</td>
		  <td><?= renderDateTimeInput('laborMembraneBroke') ?></td>
		  </tr></table>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('LA') ?>
		  <?= renderRadios('laborFeces', array(_('Clair'), _('Teinté'), _('Méconiale'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <b><?= _('Si ViH positif') ?></b>
	       </td>
	    </tr>
	    <tr>
	       <td id="laborProphylaxisArvCell">
		  <?= _('Prophylaxie ARV') ?><br>
		  <?= renderRadios('laborProphylaxisArv', array('NVP', 'AZT+3TC', _('Aucune'), _('TAR Spécifier'))) ?>
		  <?= renderTextArea('laborProphylaxisArvOther', 11) ?>
	       </td>
	    </tr>
	    <tr>
	       <td id="laborProphylaxisAtHomeCell">
		  <?= _('Si a domicile, avoir pris prophylaxie') ?>
		  <?= renderRadios('laborProphylaxisAtHome', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td id="laborProphylaxisAtHomeArvCell">
		  <?= _('Si oui') ?>
		  <?= renderRadios('laborProphylaxisAtHomeArv', array('NVP', 'AZT+3TC', _('TAR Spécifier'))) ?>
		  <?= renderTextArea('laborProphylaxisAtHomeArvOther', 11) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <table>
		     <tr>
			<td>
			   <?= _('Date de début (< 72 heures)') ?>
			</td>
			<td>
			   <?= renderTextArea('laborOnset', 5) ?>
			</td>
		     </tr>
		  </table>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('Autres médications') ?>
		  <?= renderTextArea('laborOtherMedications', 45) ?>
	       </td>
	    </tr>
	 </table>
      </td>
      <td width="50%" valign="top">
	 <table>
	    <tr>
	       <td>
		  <b><?= _('Contact en cas d\'urgence') ?></b><br>
		  <?= renderTextArea('laborContact', 55) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <b><?= _('Accouchement') ?></b>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <table style="border-collapse: collapse; border: 0px;"><tr>
		  <td><?= _('Date/Heure') ?>&nbsp;</td>
		  <td><?= renderDateTimeInput('laborChildbirth') ?></td>
		  </tr></table>
	       </td>
	    </tr>
	    <tr>
	       <td id="laborMethodCell">
		  <?= renderRadio('laborMethod', 0, _('Vaginal')) ?>
		  <i><?= _('Episio') ?></i>
		  <?= renderRadios('laborEpisio', array(_('Oui'), _('Non'))) ?>
		  <i><?= _('Vacuum') ?></i>
		  <?= renderRadios('laborVacuum', array(_('Oui'), _('Non'))) ?>
		  <br>
		  <?= renderRadio('laborMethod', 1, _('Section Césarienne')) ?>
		  <?= renderRadio('laborMethod', 2, _('CS+Hystérectomie')) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <?= _('Si l\'accouchement ete a domicile, assiste par matronne') ?>
		  <?= renderRadios('laborMidwife', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <table style="border-collapse: collapse; border: 0px;">
		     <tr>
			<td><b><?= _('Délivrance') ?></b></td>
			<td><?= renderRadios('laborDelivery',
			   array(_('Naturelle'), _('Artificielle'))) ?></td>
		     </tr>
		     <tr>
			<td style="padding-right: 1ex;">
			   <?= _('Lacération du périnée') ?>
			</td>
			<td><?= renderRadios('laborPerineumLaceration', array(_('Oui'), _('Non'))) ?></td>
		     </tr>
		     <tr>
			<td>&nbsp;&nbsp;&nbsp;<?= _('Si oui, réparation') ?></td>
			<td><?= renderRadios('laborPerineumRepaired', array(_('Oui'), _('Non'))) ?></td>
		     </tr>
		     <tr>
			<td><?= _('Placenta') ?></td>
			<td><?= renderRadios('laborPlacenta',
			   array(_('Complet/Total'), _('Incomplet'))) ?></td>
		     </tr>
		     <tr>
			<td><?= _('Hémorragie vaginale') ?></td>
			<td><?= renderRadios('laborVaginalBleeding', array(_('Oui'), _('Non'))) ?></td>
		     </tr>
		     <tr>
			<td><?= _('Transfusion') ?></td>
			<td><?= renderRadios('laborTransfusion', array(_('Oui'), _('Non'))) ?></td>
		     </tr>
		  </table>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <b><?= _('NNé') ?></b>
		  <?= _('Apgar à') ?> 1mn
		  <?= renderTextArea('laborApgar1mn', 2) ?>
		  5mn
		  <?= renderTextArea('laborApgar5mn', 2) ?>
		  <?= renderRadios('laborDeath', array(_('Mort'))) ?>
	       </td>
	    </tr>
	    <tr>
	       <td id="laborWeightCell">
		  <?= _('Pds') ?>
		  <?= renderTextArea('laborWeight', 4) ?>
		  <?= renderRadios('laborWeightUnit', array('kg', 'lb')) ?>
	       </td>
	    </tr>
	    <tr>
	       <td>
		  <b><?= _('Counseling sur la nutrition du Nné') ?></b>
		  <?= renderRadios('laborNutritionCounseling', array(_('Oui'), _('Non'))) ?>
	       </td>
	    </tr>
	 </table>
      </td>
   </tr>

   <?php renderVitalSigns(1, _('SIGNES VITAUX AU TRAVAIL')); ?>
   <?php renderVitalSigns(2, _('SIGNES VITAUX DU POST-PARTUM IMMEDIAT')); ?>
   <?php renderVitalSigns(3, _('SIGNES VITAUX A 6 HEURES DU POST-PARTUM')); ?>

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
attachEventTo('laborGestationalAge', 'onblur', 
	      makeNumericRangeValidation('laborGestationalAge', 1, 45, 86));

attachEventTo('laborUterine', 'onblur', 
	      makeNumericRangeValidation('laborUterine', 1, 37, 84));

attachEventTo('laborWeight', 'onblur', 
	      makeNumericRangeValidation('laborWeight', 0, 500, 25));

var laborWeightCheck =
  makeXorErrorValidation('laborWeight', 72,
			 makeTestAnyNotBlank('laborWeight'),
			 makeTestOneIsChecked('laborWeightUnit0', 'laborWeightUnit1'));
attachEventTo('laborWeightCell', 'onclick', laborWeightCheck);
attachEventTo('laborWeight', 'onblur', laborWeightCheck);

attachEventTo('laborMethodCell', 'onclick',
	      makeXorErrorValidation('laborEpisio0', 72,
				     makeTestOneIsChecked('laborMethod0'),
				     makeTestOneIsChecked('laborEpisio0', 'laborEpisio1')));

attachEventTo('laborMethodCell', 'onclick',
	      makeXorErrorValidation('laborVacuum0', 72,
				     makeTestOneIsChecked('laborMethod0'),
				     makeTestOneIsChecked('laborVacuum0', 'laborVacuum1')));

var laborLocationCheck =
  makeXorErrorValidation('laborLocationHospital', 72,
			 makeTestAnyNotBlank('laborLocationHospital'),
			 makeTestOneIsChecked('laborLocation1'));
attachEventTo('laborLocationCell', 'onclick', laborLocationCheck);
attachEventTo('laborLocationHospital', 'onblur', laborLocationCheck);

var laborProphylaxisArvCheck =
  makeXorErrorValidation('laborProphylaxisArvOther', 72,
			 makeTestAnyNotBlank('laborProphylaxisArvOther'),
			 makeTestOneIsChecked('laborProphylaxisArv3'));
attachEventTo('laborProphylaxisArvCell', 'onclick', laborProphylaxisArvCheck);
attachEventTo('laborProphylaxisArvOther', 'onblur', laborProphylaxisArvCheck);

var laborProphylaxisAtHomeArvCheck =
  makeXorErrorValidation('laborProphylaxisAtHomeArvOther', 72,
			 makeTestAnyNotBlank('laborProphylaxisAtHomeArvOther'),
			 makeTestOneIsChecked('laborProphylaxisAtHomeArv2'));
attachEventTo('laborProphylaxisAtHomeArvCell', 'onclick', laborProphylaxisAtHomeArvCheck);
attachEventTo('laborProphylaxisAtHomeArvOther', 'onblur', laborProphylaxisAtHomeArvCheck);

var laborProphylaxisAtHomeCheck =
  makeXorErrorValidation('laborProphylaxisAtHome0', 72,
			 makeTestOneIsChecked('laborProphylaxisAtHome0'),
			 makeTestOneIsChecked('laborProphylaxisAtHomeArv0',
					      'laborProphylaxisAtHomeArv1',
					      'laborProphylaxisAtHomeArv2'));
attachEventTo('laborProphylaxisAtHomeCell', 'onclick', laborProphylaxisAtHomeCheck);
attachEventTo('laborProphylaxisAtHomeArvCell', 'onclick', laborProphylaxisAtHomeCheck);

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
