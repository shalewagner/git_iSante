<?php
require_once 'backend/database-mysql.php';

/*
Table columns which involve patient weight.

vitals.vitalWeight - used on most forms
vitals.vitalWeightUnits
vitals.pedVitBirWt - used on HIV pediatric intake form
vitals.pedVitBirWtUnits

This is a list of all concepts which include the word weight. We need to collect weight data from some of these as well from the vitals table.

birthWeight - Birth weight of patient on pediatric intake form. Need to use birthday instead of encounter date.
birthWeightUnits - Birth weight of patient on pediatric intake form. Need to use birthday instead of encounter date.
laborVitalWeight1 - Used on version 1 and 0 labor from. 
laborVitalWeightUnit1 - Used on version 1 and 0 labor from.

Concepts below here are weight related but can't be used.

Postpartum weights from version 0 labor from. They appear to have never been used in the application.
laborVitalWeight2
laborVitalWeight3
laborVitalWeightUnit2
laborVitalWeightUnit3

Weight of newborn from version 0 labor form.
laborWeight
laborWeightUnit

These are used in version 1 of the labor form. They are used to record the history of past births and are not for the weight of the patient.
birthHistoryWeight1
birthHistoryWeight2
birthHistoryWeight3
birthHistoryWeight4
birthHistoryWeightUnit1
birthHistoryWeightUnit2
birthHistoryWeightUnit3
birthHistoryWeightUnit4

Looks like this is used in version 0 of the pmtct followup form but I can't find where. Current OBS records which use this seem to not have valid weight data. Maybe this was a radio button.
vitalWeight1

These weight concepts are defined but not used in the application.
a6VitalWeight
a6VitalWeight1
a6VitalWeightUnit
birthNNWeight
birthNNWeightUnit
birthNNWeight1
inssufficientWeightGain
malnutritionweightloss
malnutritionweightlossA
malnutritionweightlossG
ppVitalWeight
ppVitalWeight1
ppVitalWeightUnit
weightLossLessTenPercMo
weightLossPlusTenPercMo
workVitalWeight
workVitalWeight1
workVitalWeightUnit
 */

/*
This is a list of all concepts and columns which include the word weight, hauteur or taille.

Table Columns
vitals.pedVitBirLen - birth weight collected on HIV intake form
vitals.vitalHeight - height in m (must be added to vitalHeightCm)
vitals.vitalHeightCm - height in cm

Concept Names
vitalHeightCm - height in cm (duplicated from vitals.vitalHeightCm so don't use)

Concepts below can't be used.

These concepts are used to collect data about the patients past births so we don't need them.
birthHistoryHeight1
birthHistoryHeight2
birthHistoryHeight3
birthHistoryHeight4

Looks like this was used in version 0 of the pmtct followup form but I can't find out where. Only two instances of this were ever record so seems safe to ignore.
childUterHeight

Not used in the application.
physicalUterineHeight

Not a patient height.
uterHeight

*/

/*
This is a list of all concepts and columns which might be related to head circumference. This is abbreviated PC in French for périmètre crânien.

Table Columns
vitals.pedVitCurHeadCirc - used in HIV pediatric intake and followup forms
vitals.pedVitBirPc - used in HIV pediatric intake, use birth date

Concept Names
vitalPc - used on primary care forms

birthHistoryHeadCircumference1 - this are birth history for the mother so can't use
birthHistoryHeadCircumference2
birthHistoryHeadCircumference3
birthHistoryHeadCircumference4

*/

function writeCoverGraphDataJson($pid) {
  $location_id = substr($pid, 0, 5);
  $person_id = substr($pid, 5);


  //write out birth date if there is a valid one
  $birthDay = getData('dobDd', 'textarea');
  $birthMonth = getData('dobMm', 'textarea');
  $birthYear = getData('dobYy', 'textarea');
  if (is_numeric($birthDay) && is_numeric($birthMonth) && is_numeric($birthYear)) {
    $ymdBirthDate = sprintf('%04d-%02d-%02d', $birthYear, $birthMonth, $birthDay);
    echo 'CoverSheetGraph.patientBirthDate = Date.parseDate(' . json_encode($ymdBirthDate) . ", 'Y-m-d');\n\n";
  } else {
    $ymdBirthDate = null;
    echo 'CoverSheetGraph.patientBirthDate = null;';
  }


  //write out patient gender if there is a valid one
  $gender = getData("sex", "textarea");
  if ($gender == 1) {
    echo 'CoverSheetGraph.patientGender = "female";';
  } else if ($gender == 2) {
    echo 'CoverSheetGraph.patientGender = "male";';
  } else {
    echo 'CoverSheetGraph.patientGender = null;';
  }


  //collect weight data
  $birthWeightRows = array();
  if (isset($ymdBirthDate)) {
    $primaryBirthWeightRows = database()->query('
select visitdate,
 obs.value_text as value,
 case when obs2.value_numeric = 2 then 1 else 2 end as unit
from obs
join concept on obs.concept_id = concept.concept_id
join obs as obs2 using (location_id, encounter_id)
join concept as concept2 on obs2.concept_id = concept2.concept_id
join encValidAll on obs.encounter_id = encValidAll.encounter_id and obs.location_id = encValidAll.siteCode
where concept.short_name = ?
 and concept2.short_name = ?
 and location_id = ?
 and obs.person_id = ?
order by visitdate desc
limit 1', array('birthWeight', 'birthWeightUnits',
		$location_id, $person_id))->fetchAll();
    
    $hivBirthWeightRows = database()->query('
select visitdate,
 pedVitBirWt as value,
 pedVitBirWtUnits as unit
from a_vitals 
where pedVitBirWt is not null
 and pedVitBirWt != ?
 and pedVitBirWtUnits is not null
 and pedVitBirWtUnits in (1, 2)
 and patientid = cast(? as char(11))
order by visitdate desc
limit 1', array('', $pid))->fetchAll();
    
    //If both possible source of birth weight have a value pick only the most recent one.
    if (count($primaryBirthWeightRows) == 1 && count($hivBirthWeightRows) == 1) {
      if ($primaryBirthWeightRows[0]['visitdate'] > $hivBirthWeightRows[0]['visitdate']) {
	$birthWeightRows = array(array('displayDate' => $ymdBirthDate,
				       'value' => $primaryBirthWeightRows[0]['value'],
				       'unit' => $primaryBirthWeightRows[0]['unit']));
      } else {
	$birthWeightRows = array(array('displayDate' => $ymdBirthDate,
				       'value' => $hivBirthWeightRows[0]['value'],
				       'unit' => $hivBirthWeightRows[0]['unit']));
      }
    } else if (count($primaryBirthWeightRows) == 1) {
	$birthWeightRows = array(array('displayDate' => $ymdBirthDate,
				       'value' => $primaryBirthWeightRows[0]['value'],
				       'unit' => $primaryBirthWeightRows[0]['unit']));
    } else if (count($hivBirthWeightRows) == 1) {
	$birthWeightRows = array(array('displayDate' => $ymdBirthDate,
				       'value' => $hivBirthWeightRows[0]['value'],
				       'unit' => $hivBirthWeightRows[0]['unit']));
    }
  }

  $vitalsTableWeightRows = database()->query('
select visitdate as displayDate,
 vitalWeight as value,
 vitalWeightUnits as unit
from a_vitals 
where vitalWeight is not null
 and vitalWeight != ?
 and vitalWeightUnits is not null
 and vitalWeightUnits in (1, 2)
 and patientid = cast(? as char(11))', array('', $pid))->fetchAll();

  $laborWeightRows = database()->query('
select visitdate as displayDate,
 obs.value_text as value,
 obs2.value_numeric as unit
from obs
join concept on obs.concept_id = concept.concept_id
join obs as obs2 using (location_id, encounter_id)
join concept as concept2 on obs2.concept_id = concept2.concept_id
join encValidAll on obs.encounter_id = encValidAll.encounter_id and obs.location_id = encValidAll.siteCode
where concept.short_name = ?
 and concept2.short_name = ?
 and location_id = ?
 and obs.person_id = ?', array('laborVitalWeight1', 'laborVitalWeightUnit1',
			       $location_id, $person_id))->fetchAll();

  $weightDataOutput = array();
  foreach (array_merge($vitalsTableWeightRows,
		       $laborWeightRows,
		       $birthWeightRows) as $row) {
    $value = preg_replace('/,/', '.', $row['value']); // change numbers like 1,22 into 1.22
    if (is_numeric($value)) {
      if ($row['unit'] != 1) {
	$value = $value * 0.45359; // convert lbs into kg
      }
      $weightDataOutput[] = array($row['displayDate'], $value + 0);
    }
  }

  
  //collect cd4 data
  $cd4DataOutput = array();
  foreach (database()->query('
select date(visitdate) as displayDate, cd4 as value
from cd4Table
where patientid = cast(? as char(11))', array($pid))->fetchAll() as $row) {
    $cd4DataOutput[] = array($row['displayDate'], $row['value'] + 0);
  }


  //collect height data
  $vitalsTableBirthHeightRows = array();
  if (isset($ymdBirthDate)) {
    $vitalsTableBirthHeightRows = database()->query('
select ? as displayDate,
 0 as meters,
 pedVitBirLen as centimeters
from a_vitals
where pedVitBirLen is not null
 and pedVitBirLen != ?
 and patientid = cast(? as char(11))
order by visitdate desc
limit 1', array($ymdBirthDate, '', $pid))->fetchAll();
  }

  $vitalsTableHeightRows = database()->query('
select visitdate as displayDate,
 vitalHeight as meters,
 vitalHeightCm as centimeters
from a_vitals
where not (vitalHeight is null and vitalHeightCm is null)
 and not (vitalHeight = ? and vitalHeightCm = ?)
 and patientid = cast(? as char(11))', array('', '', $pid))->fetchAll();

  $heightDataOutput = array();
  foreach (array_merge($vitalsTableBirthHeightRows,
		       $vitalsTableHeightRows) as $row) {
    $height = null;
    $meters = preg_replace('/,/', '.', $row['meters']); // change numbers like 1,22 into 1.22
    $centimeters = preg_replace('/,/', '.', $row['centimeters']);
    if (is_numeric($meters)) {
      $height = $meters * 100;
    }
    if (is_numeric($centimeters)) {
      if (isset($height)) {
	$height = $height + $centimeters;
      } else {
	$height = $centimeters;
      }
    }
    if (isset($height)) {
      $heightDataOutput[] = array($row['displayDate'], $height + 0);
    }
  }


  //collect head circumference data
  $birthHeadCircumferenceRows = array();
  if (isset($ymdBirthDate)) {
    $birthHeadCircumferenceRows = database()->query('
select ? as displayDate,
 pedVitBirPc as value
from a_vitals 
where pedVitBirPc is not null
 and pedVitBirPc != ?
 and patientid = cast(? as char(11))
order by visitdate desc
limit 1', array($ymdBirthDate, '', $pid))->fetchAll();
  }

  $hivHeadCircumferenceRows = database()->query('
select visitdate as displayDate,
 pedVitCurHeadCirc as value
from a_vitals 
where pedVitCurHeadCirc is not null
 and pedVitCurHeadCirc != ?
 and patientid = cast(? as char(11))', array('', $pid))->fetchAll();

  $primaryHeadCircumferenceRows = database()->query('
select visitdate as displayDate,
 obs.value_numeric as value
from obs
join concept on obs.concept_id = concept.concept_id
join encValidAll on obs.encounter_id = encValidAll.encounter_id and obs.location_id = encValidAll.siteCode
where concept.short_name = ?
 and value_numeric is not null
 and location_id = ?
 and obs.person_id = ?', array('vitalPc', $location_id, $person_id))->fetchAll();

  $headCircumferenceDataOutput = array();
  foreach (array_merge($birthHeadCircumferenceRows,
		       $hivHeadCircumferenceRows,
		       $primaryHeadCircumferenceRows) as $row) {
    $value = preg_replace('/,/', '.', $row['value']); // change numbers like 1,22 into 1.22
    if (is_numeric($value)) {
      $headCircumferenceDataOutput[] = array($row['displayDate'], $value + 0);
    }
  }

  //write out JSON arrays for all the collected data
?>
CoverSheetGraph.data = {};
CoverSheetGraph.data.weight = CoverSheetGraph.dataArrayFormat(<?= json_encode($weightDataOutput) ?>);
CoverSheetGraph.data.cd4 = CoverSheetGraph.dataArrayFormat(<?= json_encode($cd4DataOutput) ?>);
CoverSheetGraph.data.height = CoverSheetGraph.dataArrayFormat(<?= json_encode($heightDataOutput) ?>);
CoverSheetGraph.data.headCircumference =
    CoverSheetGraph.dataArrayFormat(<?= json_encode($headCircumferenceDataOutput) ?>);
/** Removing for now - combinedHeightWeight isn't being used & GrowthChart is
    no longer being calculated. **/
    CoverSheetGraph.data.combinedHeightWeight = 
    GrowthChart.DataInput.matchDate(CoverSheetGraph.data.height,
				    CoverSheetGraph.data.weight); 
<?php
}
?>
