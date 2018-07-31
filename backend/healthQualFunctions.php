<?php
require_once 'backend/hivQualFunctions.php';

$indicatorProperties = array (

  /*
  01:	Retention des patients en prise en charge ARV
  19:	Detection precoce du VIH pediatrique
  12:	Proportion d'enfants exposés au VIH ayant un test PCR négatif au cours de la période danalyse
  
  05:	Enrôlement ARV
  14:	PTME
  15:	Rétention à 12 mois
  
  07:	Évaluation de l'adhérence
  08:	Niveau d'adhérence
  10:	Proportion de patients VIH+ sous traitement ARV ayant bénéficié d'une évaluation de leur Charge virale 
  
  11:	Proportion de patients VIH+ sous traitement ARV depuis plus de 6 mois ayant une charge virale indétectable
  09:	Dépistage de la TB
  04:  	Prophylaxie à l'INH
  */
  
  '01' => array ('numFunct' => 'getHealthQualInd1Num', 'denFunct' => 'getHealthQualInd1Den'),
  /*'02' => array ('numFunct' => 'getHealthQualInd2Num', 'denFunct' => 'getHealthQualInd2Den'),
  '03' => array ('numFunct' => 'getHealthQualInd3Num', 'denFunct' => 'getHealthQualInd3Den'),*/
  '04' => array ('numFunct' => 'getHealthQualInd4Num', 'denFunct' => 'getHealthQualInd4Den'),
  '05' => array ('numFunct' => 'getInd3Num', 'denFunct' => 'getInd3Den'),
  /*'06A' => array ('numFunct' => 'getInd4Num', 'denFunct' => 'getInd4ADen'),
  '06B' => array ('numFunct' => 'getInd4Num', 'denFunct' => 'getInd4BDen'),*/
  /*indicateur 6 : Nouvel indicateur*/
  '12' => array ('numFunct' => 'getHealthQualInd6Num', 'denFunct' => 'getHealthQualInd6Den'),
  '07' => array ('numFunct' => 'getInd5Num', 'denFunct' => 'getInd5Den'),
  '08' => array ('numFunct' => 'getHealthQualInd8Num', 'denFunct' => 'getHealthQualInd8Den'),
  '09' => array ('numFunct' => 'getInd6Num', 'denFunct' => 'getInd6Den'),
  '10' => array ('numFunct' => 'getHealthQualInd10Num', 'denFunct' => 'getHealthQualInd10Den'),
  //Nouvel indicateur
  '11' => array ('numFunct' => 'getHealthQualInd11Num', 'denFunct' => 'getHealthQualInd11Den'),
  /*'11' => array ('numFunct' => 'getInd7Num', 'denFunct' => 'getInd7Den'),
  '12' => array ('numFunct' => 'getHealthQualInd12Num', 'denFunct' => 'getHealthQualInd12Den'),
  '13' => array ('numFunct' => 'getInd8Num', 'denFunct' => 'getInd8Den'),*/
  '14' => array ('numFunct' => 'getInd9Num', 'denFunct' => 'getInd9Den'),
  //nouvel indicateur : Retention a 12 mois
  '15' => array ('numFunct' => 'getHealthQualInd15Num', 'denFunct' => 'getHealthQualInd15Den'),
  /*'15' => array ('numFunct' => 'getHealthQualInd15Num', 'denFunct' => 'getHealthQualInd15Den'),
  '16' => array ('numFunct' => 'getHealthQualInd16Num', 'denFunct' => 'getHealthQualInd16Den'),
  '17' => array ('numFunct' => 'getHealthQualInd17Num', 'denFunct' => 'getHealthQualInd17Den'),
  '18' => array ('numFunct' => 'getInd10Num', 'denFunct' => 'getInd10Den'),*/
  '19' => array ('numFunct' => 'getHealthQualInd19Num', 'denFunct' => 'getHealthQualInd19Den'));
  
function insertHealthqualStaticRows ($data) {
  $indArray = array (/*"01,02,03", "04,05,06", "07,08,09",
                     "10,11,12", "13,14,15", "16,17,18",
                     "19"*/"01,19,12","05,14,15","07,08,10","11,09,04");
  $keys = implode (", ", array_keys ($data));
  $vals = implode (", ", array_values ($data));

  foreach ($indArray as $indList) {
    dbQuery("
     INSERT staticReportData ($keys, value4)
     VALUES ($vals, '$indList')");
  }
}

function generateAgeGenderGroups ($in, $site, $dt) {
  $out = array ("adultsM" => array (), "adultsF" => array (),
                "kidsM" => array (), "kidsF" => array ());
  global $setupTableNames;

  $result = dbQuery ("
    SELECT p.patientID, t.startDays, p.sex
    FROM patient p, " . $setupTableNames[1] . " t
    WHERE p.patientID = t.patientID");

  while ($row = psRowFetch ($result)) {
    if ($row[1] < (15 * DAYS_IN_YEAR)) {
      if ($row[2] == 1) {
        array_push ($out["kidsF"], $row[0]);
      } else if ($row[2] == 2) {
        array_push ($out["kidsM"], $row[0]);
      }
    } else if ($row[1] >= (15 * DAYS_IN_YEAR)) {
      if ($row[2] == 1) {
        array_push ($out["adultsF"], $row[0]);
      } else if ($row[2] == 2) {
        array_push ($out["adultsM"], $row[0]);
      }
    }
  }
   
  return (array ("adultsM" => array_intersect ($in, $out["adultsM"]),
                 "adultsF" => array_intersect ($in, $out["adultsF"]),
                 "kidsM" => array_intersect ($in, $out["kidsM"]),
                 "kidsF" => array_intersect ($in, $out["kidsF"])));
}

function setupHealthQual ($repNum, $site, $start, $end) {
  global $setupTableNames;

  $setupTableNames = createTempTables ("#setupHealthQual", 5, array ("patientID varchar(11), startDays mediumint, endDays mediumint", "patientID varchar(11), lmpDate date, eligDate date", "patientID varchar(11)", "patientID varchar(11)", "category varchar(3), measure decimal(4,1), threshold decimal(3,1)"), array ("pat_idx::patientID", "pat_idx::patientID", "pat_idx::patientID", "pat_idx::patientID", "main_idx::category, measure"));

  fillPidAgeTable ($setupTableNames[1], $site, $start, $end);
  fillLmpTable ($setupTableNames[2], $site, $end, getEligDays ($repNum, $start));

  // Most indicators don't count pediatric patients with negative PCR result
  /*dbQuery ("INSERT INTO " . $setupTableNames[3] . "
    SELECT DISTINCT v.patientID
    FROM v_labsCompleted v, " . $setupTableNames[1] . " t
    WHERE v.labID = '181'
     AND v.result = '2'
     AND v.patientID = t.patientID
     AND t.startDays >= 0
     AND t.startDays < 15 * " . DAYS_IN_YEAR . "
     AND ISNUMERIC(LTRIM(RTRIM(v.resultDateDd))) = 1
     AND ISNUMERIC(LTRIM(RTRIM(v.resultDateMm))) = 1
     AND ISNUMERIC(LTRIM(RTRIM(v.resultDateYy))) = 1
     AND dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd))) <= '$end'");

  // All indicators don't count discontinued patients
  dbQuery ("INSERT INTO " . $setupTableNames[4] . "
    SELECT DISTINCT patientID
    FROM discTable
    WHERE sitecode = '$site'
     AND discDate <= '$end'");*/

  // Severe malnutrition indicator needs -3 SD from median values (source = WHO)
  /*dbQuery ("INSERT INTO " . $setupTableNames[5] . " VALUES
    ('ml2', 45.0, 1.9), ('ml2', 45.5, 1.9), ('ml2', 46.0, 2.0),
    ('ml2', 46.5, 2.1), ('ml2', 47.0, 2.1), ('ml2', 47.5, 2.2),
    ('ml2', 48.0, 2.3), ('ml2', 48.5, 2.3), ('ml2', 49.0, 2.4),
    ('ml2', 49.5, 2.5), ('ml2', 50.0, 2.6), ('ml2', 50.5, 2.7),
    ('ml2', 51.0, 2.7), ('ml2', 51.5, 2.8), ('ml2', 52.0, 2.9),
    ('ml2', 52.5, 3.0), ('ml2', 53.0, 3.1), ('ml2', 53.5, 3.2),
    ('ml2', 54.0, 3.3), ('ml2', 54.5, 3.4), ('ml2', 55.0, 3.6),
    ('ml2', 55.5, 3.7), ('ml2', 56.0, 3.8), ('ml2', 56.5, 3.9),
    ('ml2', 57.0, 4.0), ('ml2', 57.5, 4.1), ('ml2', 58.0, 4.3),
    ('ml2', 58.5, 4.4), ('ml2', 59.0, 4.5), ('ml2', 59.5, 4.6),
    ('ml2', 60.0, 4.7), ('ml2', 60.5, 4.8), ('ml2', 61.0, 4.9),
    ('ml2', 61.5, 5.0), ('ml2', 62.0, 5.1), ('ml2', 62.5, 5.2),
    ('ml2', 63.0, 5.3), ('ml2', 63.5, 5.4), ('ml2', 64.0, 5.5),
    ('ml2', 64.5, 5.6), ('ml2', 65.0, 5.7), ('ml2', 65.5, 5.8),
    ('ml2', 66.0, 5.9), ('ml2', 66.5, 6.0), ('ml2', 67.0, 6.1),
    ('ml2', 67.5, 6.2), ('ml2', 68.0, 6.3), ('ml2', 68.5, 6.4),
    ('ml2', 69.0, 6.5), ('ml2', 69.5, 6.6), ('ml2', 70.0, 6.6),
    ('ml2', 70.5, 6.7), ('ml2', 71.0, 6.8), ('ml2', 71.5, 6.9),
    ('ml2', 72.0, 7.0), ('ml2', 72.5, 7.1), ('ml2', 73.0, 7.2),
    ('ml2', 73.5, 7.2), ('ml2', 74.0, 7.3), ('ml2', 74.5, 7.4),
    ('ml2', 75.0, 7.5), ('ml2', 75.5, 7.6), ('ml2', 76.0, 7.6),
    ('ml2', 76.5, 7.7), ('ml2', 77.0, 7.8), ('ml2', 77.5, 7.9),
    ('ml2', 78.0, 7.9), ('ml2', 78.5, 8.0), ('ml2', 79.0, 8.1),
    ('ml2', 79.5, 8.2), ('ml2', 80.0, 8.2), ('ml2', 80.5, 8.3),
    ('ml2', 81.0, 8.4), ('ml2', 81.5, 8.5), ('ml2', 82.0, 8.5),
    ('ml2', 82.5, 8.6), ('ml2', 83.0, 8.7), ('ml2', 83.5, 8.8),
    ('ml2', 84.0, 8.9), ('ml2', 84.5, 9.0), ('ml2', 85.0, 9.1),
    ('ml2', 85.5, 9.2), ('ml2', 86.0, 9.3), ('ml2', 86.5, 9.4),
    ('ml2', 87.0, 9.5), ('ml2', 87.5, 9.6), ('ml2', 88.0, 9.7),
    ('ml2', 88.5, 9.8), ('ml2', 89.0, 9.9), ('ml2', 89.5, 10.0),
    ('ml2', 90.0, 10.1), ('ml2', 90.5, 10.2), ('ml2', 91.0, 10.3),
    ('ml2', 91.5, 10.4), ('ml2', 92.0, 10.5), ('ml2', 92.5, 10.6),
    ('ml2', 93.0, 10.7), ('ml2', 93.5, 10.7), ('ml2', 94.0, 10.8),
    ('ml2', 94.5, 10.9), ('ml2', 95.0, 11.0), ('ml2', 95.5, 11.1),
    ('ml2', 96.0, 11.2), ('ml2', 96.5, 11.3), ('ml2', 97.0, 11.4),
    ('ml2', 97.5, 11.5), ('ml2', 98.0, 11.6), ('ml2', 98.5, 11.7),
    ('ml2', 99.0, 11.8), ('ml2', 99.5, 11.9), ('ml2', 100.0, 12.0),
    ('ml2', 100.5, 12.1), ('ml2', 101.0, 12.2), ('ml2', 101.5, 12.3),
    ('ml2', 102.0, 12.4), ('ml2', 102.5, 12.5), ('ml2', 103.0, 12.6),
    ('ml2', 103.5, 12.7), ('ml2', 104.0, 12.8), ('ml2', 104.5, 12.9),
    ('ml2', 105.0, 13.0), ('ml2', 105.5, 13.2), ('ml2', 106.0, 13.3),
    ('ml2', 106.5, 13.4), ('ml2', 107.0, 13.5), ('ml2', 107.5, 13.6),
    ('ml2', 108.0, 13.7), ('ml2', 108.5, 13.8), ('ml2', 109.0, 14.0),
    ('ml2', 109.5, 14.1), ('ml2', 110.0, 14.2),
    ('mg2', 65.0, 5.9), ('mg2', 65.5, 6.0), ('mg2', 66.0, 6.1),
    ('mg2', 66.5, 6.1), ('mg2', 67.0, 6.2), ('mg2', 67.5, 6.3),
    ('mg2', 68.0, 6.4), ('mg2', 68.5, 6.5), ('mg2', 69.0, 6.6),
    ('mg2', 69.5, 6.7), ('mg2', 70.0, 6.8), ('mg2', 70.5, 6.9),
    ('mg2', 71.0, 6.9), ('mg2', 71.5, 7.0), ('mg2', 72.0, 7.1),
    ('mg2', 72.5, 7.2), ('mg2', 73.0, 7.3), ('mg2', 73.5, 7.4),
    ('mg2', 74.0, 7.4), ('mg2', 74.5, 7.5), ('mg2', 75.0, 7.6),
    ('mg2', 75.5, 7.7), ('mg2', 76.0, 7.7), ('mg2', 76.5, 7.8),
    ('mg2', 77.0, 7.9), ('mg2', 77.5, 8.0), ('mg2', 78.0, 8.0),
    ('mg2', 78.5, 8.1), ('mg2', 79.0, 8.2), ('mg2', 79.5, 8.3),
    ('mg2', 80.0, 8.3), ('mg2', 80.5, 8.4), ('mg2', 81.0, 8.5),
    ('mg2', 81.5, 8.6), ('mg2', 82.0, 8.7), ('mg2', 82.5, 8.7),
    ('mg2', 83.0, 8.8), ('mg2', 83.5, 8.9), ('mg2', 84.0, 9.0),
    ('mg2', 84.5, 9.1), ('mg2', 85.0, 9.2), ('mg2', 85.5, 9.3),
    ('mg2', 86.0, 9.4), ('mg2', 86.5, 9.5), ('mg2', 87.0, 9.6),
    ('mg2', 87.5, 9.7), ('mg2', 88.0, 9.8), ('mg2', 88.5, 9.9),
    ('mg2', 89.0, 10.0), ('mg2', 89.5, 10.1), ('mg2', 90.0, 10.2),
    ('mg2', 90.5, 10.3), ('mg2', 91.0, 10.4), ('mg2', 91.5, 10.5),
    ('mg2', 92.0, 10.6), ('mg2', 92.5, 10.7), ('mg2', 93.0, 10.8),
    ('mg2', 93.5, 10.9), ('mg2', 94.0, 11.0), ('mg2', 94.5, 11.1),
    ('mg2', 95.0, 11.1), ('mg2', 95.5, 11.2), ('mg2', 96.0, 11.3),
    ('mg2', 96.5, 11.4), ('mg2', 97.0, 11.5), ('mg2', 97.5, 11.6),
    ('mg2', 98.0, 11.7), ('mg2', 98.5, 11.8), ('mg2', 99.0, 11.9),
    ('mg2', 99.5, 12.0), ('mg2', 100.0, 12.1), ('mg2', 100.5, 12.2),
    ('mg2', 101.0, 12.3), ('mg2', 101.5, 12.4), ('mg2', 102.0, 12.5),
    ('mg2', 102.5, 12.6), ('mg2', 103.0, 12.8), ('mg2', 103.5, 12.9),
    ('mg2', 104.0, 13.0), ('mg2', 104.5, 13.1), ('mg2', 105.0, 13.2),
    ('mg2', 105.5, 13.3), ('mg2', 106.0, 13.4), ('mg2', 106.5, 13.5),
    ('mg2', 107.0, 13.7), ('mg2', 107.5, 13.8), ('mg2', 108.0, 13.9),
    ('mg2', 108.5, 14.0), ('mg2', 109.0, 14.1), ('mg2', 109.5, 14.3),
    ('mg2', 110.0, 14.4), ('mg2', 110.5, 14.5), ('mg2', 111.0, 14.6),
    ('mg2', 111.5, 14.8), ('mg2', 112.0, 14.9), ('mg2', 112.5, 15.0),
    ('mg2', 113.0, 15.2), ('mg2', 113.5, 15.3), ('mg2', 114.0, 15.4),
    ('mg2', 114.5, 15.6), ('mg2', 115.0, 15.7), ('mg2', 115.5, 15.8),
    ('mg2', 116.0, 16.0), ('mg2', 116.5, 16.1), ('mg2', 117.0, 16.2),
    ('mg2', 117.5, 16.4), ('mg2', 118.0, 16.5), ('mg2', 118.5, 16.7),
    ('mg2', 119.0, 16.8), ('mg2', 119.5, 16.9), ('mg2', 120.0, 17.1),
    ('fl2', 45.0, 1.9), ('fl2', 45.5, 2.0), ('fl2', 46.0, 2.0),
    ('fl2', 46.5, 2.1), ('fl2', 47.0, 2.2), ('fl2', 47.5, 2.2),
    ('fl2', 48.0, 2.3), ('fl2', 48.5, 2.4), ('fl2', 49.0, 2.4),
    ('fl2', 49.5, 2.5), ('fl2', 50.0, 2.6), ('fl2', 50.5, 2.7),
    ('fl2', 51.0, 2.8), ('fl2', 51.5, 2.8), ('fl2', 52.0, 2.9),
    ('fl2', 52.5, 3.0), ('fl2', 53.0, 3.1), ('fl2', 53.5, 3.2),
    ('fl2', 54.0, 3.3), ('fl2', 54.5, 3.4), ('fl2', 55.0, 3.5),
    ('fl2', 55.5, 3.6), ('fl2', 56.0, 3.7), ('fl2', 56.5, 3.8),
    ('fl2', 57.0, 3.9), ('fl2', 57.5, 4.0), ('fl2', 58.0, 4.1),
    ('fl2', 58.5, 4.2), ('fl2', 59.0, 4.3), ('fl2', 59.5, 4.4),
    ('fl2', 60.0, 4.5), ('fl2', 60.5, 4.6), ('fl2', 61.0, 4.7),
    ('fl2', 61.5, 4.8), ('fl2', 62.0, 4.9), ('fl2', 62.5, 5.0),
    ('fl2', 63.0, 5.1), ('fl2', 63.5, 5.2), ('fl2', 64.0, 5.3),
    ('fl2', 64.5, 5.4), ('fl2', 65.0, 5.5), ('fl2', 65.5, 5.5),
    ('fl2', 66.0, 5.6), ('fl2', 66.5, 5.7), ('fl2', 67.0, 5.8),
    ('fl2', 67.5, 5.9), ('fl2', 68.0, 6.0), ('fl2', 68.5, 6.1),
    ('fl2', 69.0, 6.1), ('fl2', 69.5, 6.2), ('fl2', 70.0, 6.3),
    ('fl2', 70.5, 6.4), ('fl2', 71.0, 6.5), ('fl2', 71.5, 6.5),
    ('fl2', 72.0, 6.6), ('fl2', 72.5, 6.7), ('fl2', 73.0, 6.8),
    ('fl2', 73.5, 6.9), ('fl2', 74.0, 6.9), ('fl2', 74.5, 7.0),
    ('fl2', 75.0, 7.1), ('fl2', 75.5, 7.1), ('fl2', 76.0, 7.2),
    ('fl2', 76.5, 7.3), ('fl2', 77.0, 7.4), ('fl2', 77.5, 7.4),
    ('fl2', 78.0, 7.5), ('fl2', 78.5, 7.6), ('fl2', 79.0, 7.7),
    ('fl2', 79.5, 7.7), ('fl2', 80.0, 7.8), ('fl2', 80.5, 7.9),
    ('fl2', 81.0, 8.0), ('fl2', 81.5, 8.1), ('fl2', 82.0, 8.1),
    ('fl2', 82.5, 8.2), ('fl2', 83.0, 8.3), ('fl2', 83.5, 8.4),
    ('fl2', 84.0, 8.5), ('fl2', 84.5, 8.6), ('fl2', 85.0, 8.7),
    ('fl2', 85.5, 8.8), ('fl2', 86.0, 8.9), ('fl2', 86.5, 9.0),
    ('fl2', 87.0, 9.1), ('fl2', 87.5, 9.2), ('fl2', 88.0, 9.3),
    ('fl2', 88.5, 9.4), ('fl2', 89.0, 9.5), ('fl2', 89.5, 9.6),
    ('fl2', 90.0, 9.7), ('fl2', 90.5, 9.8), ('fl2', 91.0, 9.9),
    ('fl2', 91.5, 10.0), ('fl2', 92.0, 10.1), ('fl2', 92.5, 10.1),
    ('fl2', 93.0, 10.2), ('fl2', 93.5, 10.3), ('fl2', 94.0, 10.4),
    ('fl2', 94.5, 10.5), ('fl2', 95.0, 10.6), ('fl2', 95.5, 10.7),
    ('fl2', 96.0, 10.8), ('fl2', 96.5, 10.9), ('fl2', 97.0, 11.0),
    ('fl2', 97.5, 11.1), ('fl2', 98.0, 11.2), ('fl2', 98.5, 11.3),
    ('fl2', 99.0, 11.4), ('fl2', 99.5, 11.5), ('fl2', 100.0, 11.6),
    ('fl2', 100.5, 11.7), ('fl2', 101.0, 11.8), ('fl2', 101.5, 11.9),
    ('fl2', 102.0, 12.0), ('fl2', 102.5, 12.1), ('fl2', 103.0, 12.3),
    ('fl2', 103.5, 12.4), ('fl2', 104.0, 12.5), ('fl2', 104.5, 12.6),
    ('fl2', 105.0, 12.7), ('fl2', 105.5, 12.8), ('fl2', 106.0, 13.0),
    ('fl2', 106.5, 13.1), ('fl2', 107.0, 13.2), ('fl2', 107.5, 13.3),
    ('fl2', 108.0, 13.5), ('fl2', 108.5, 13.6), ('fl2', 109.0, 13.7),
    ('fl2', 109.5, 13.9), ('fl2', 110.0, 14.0),
    ('fg2', 65.0, 5.6), ('fg2', 65.5, 5.7), ('fg2', 66.0, 5.8),
    ('fg2', 66.5, 5.8), ('fg2', 67.0, 5.9), ('fg2', 67.5, 6.0),
    ('fg2', 68.0, 6.1), ('fg2', 68.5, 6.2), ('fg2', 69.0, 6.3),
    ('fg2', 69.5, 6.3), ('fg2', 70.0, 6.4), ('fg2', 70.5, 6.5),
    ('fg2', 71.0, 6.6), ('fg2', 71.5, 6.7), ('fg2', 72.0, 6.7),
    ('fg2', 72.5, 6.8), ('fg2', 73.0, 6.9), ('fg2', 73.5, 7.0),
    ('fg2', 74.0, 7.0), ('fg2', 74.5, 7.1), ('fg2', 75.0, 7.2),
    ('fg2', 75.5, 7.2), ('fg2', 76.0, 7.3), ('fg2', 76.5, 7.4),
    ('fg2', 77.0, 7.5), ('fg2', 77.5, 7.5), ('fg2', 78.0, 7.6),
    ('fg2', 78.5, 7.7), ('fg2', 79.0, 7.8), ('fg2', 79.5, 7.8),
    ('fg2', 80.0, 7.9), ('fg2', 80.5, 8.0), ('fg2', 81.0, 8.1),
    ('fg2', 81.5, 8.2), ('fg2', 82.0, 8.3), ('fg2', 82.5, 8.4),
    ('fg2', 83.0, 8.5), ('fg2', 83.5, 8.5), ('fg2', 84.0, 8.6),
    ('fg2', 84.5, 8.7), ('fg2', 85.0, 8.8), ('fg2', 85.5, 8.9),
    ('fg2', 86.0, 9.0), ('fg2', 86.5, 9.1), ('fg2', 87.0, 9.2),
    ('fg2', 87.5, 9.3), ('fg2', 88.0, 9.4), ('fg2', 88.5, 9.5),
    ('fg2', 89.0, 9.6), ('fg2', 89.5, 9.7), ('fg2', 90.0, 9.8),
    ('fg2', 90.5, 9.9), ('fg2', 91.0, 10.0), ('fg2', 91.5, 10.1),
    ('fg2', 92.0, 10.2), ('fg2', 92.5, 10.3), ('fg2', 93.0, 10.4),
    ('fg2', 93.5, 10.5), ('fg2', 94.0, 10.6), ('fg2', 94.5, 10.7),
    ('fg2', 95.0, 10.8), ('fg2', 95.5, 10.8), ('fg2', 96.0, 10.9),
    ('fg2', 96.5, 11.0), ('fg2', 97.0, 11.1), ('fg2', 97.5, 11.2),
    ('fg2', 98.0, 11.3), ('fg2', 98.5, 11.4), ('fg2', 99.0, 11.5),
    ('fg2', 99.5, 11.6), ('fg2', 100.0, 11.7), ('fg2', 100.5, 11.9),
    ('fg2', 101.0, 12.0), ('fg2', 101.5, 12.1), ('fg2', 102.0, 12.2),
    ('fg2', 102.5, 12.3), ('fg2', 103.0, 12.4), ('fg2', 103.5, 12.5),
    ('fg2', 104.0, 12.6), ('fg2', 104.5, 12.8), ('fg2', 105.0, 12.9),
    ('fg2', 105.5, 13.0), ('fg2', 106.0, 13.1), ('fg2', 106.5, 13.3),
    ('fg2', 107.0, 13.4), ('fg2', 107.5, 13.5), ('fg2', 108.0, 13.7),
    ('fg2', 108.5, 13.8), ('fg2', 109.0, 13.9), ('fg2', 109.5, 14.1),
    ('fg2', 110.0, 14.2), ('fg2', 110.5, 14.4), ('fg2', 111.0, 14.5),
    ('fg2', 111.5, 14.7), ('fg2', 112.0, 14.8), ('fg2', 112.5, 15.0),
    ('fg2', 113.0, 15.1), ('fg2', 113.5, 15.3), ('fg2', 114.0, 15.4),
    ('fg2', 114.5, 15.6), ('fg2', 115.0, 15.7), ('fg2', 115.5, 15.9),
    ('fg2', 116.0, 16.0), ('fg2', 116.5, 16.2), ('fg2', 117.0, 16.3),
    ('fg2', 117.5, 16.5), ('fg2', 118.0, 16.6), ('fg2', 118.5, 16.8),
    ('fg2', 119.0, 16.9), ('fg2', 119.5, 17.1), ('fg2', 120.0, 17.3),
    ('fg5', 61, 11.8), ('fg5', 62, 11.8), ('fg5', 63, 11.8),
    ('fg5', 64, 11.8), ('fg5', 65, 11.7), ('fg5', 66, 11.7),
    ('fg5', 67, 11.7), ('fg5', 68, 11.7), ('fg5', 69, 11.7),
    ('fg5', 70, 11.7), ('fg5', 71, 11.7), ('fg5', 72, 11.7),
    ('fg5', 73, 11.7), ('fg5', 74, 11.7), ('fg5', 75, 11.7),
    ('fg5', 76, 11.7), ('fg5', 77, 11.7), ('fg5', 78, 11.7),
    ('fg5', 79, 11.7), ('fg5', 80, 11.7), ('fg5', 81, 11.7),
    ('fg5', 82, 11.7), ('fg5', 83, 11.7), ('fg5', 84, 11.8),
    ('fg5', 85, 11.8), ('fg5', 86, 11.8), ('fg5', 87, 11.8),
    ('fg5', 88, 11.8), ('fg5', 89, 11.8), ('fg5', 90, 11.8),
    ('fg5', 91, 11.8), ('fg5', 92, 11.8), ('fg5', 93, 11.8),
    ('fg5', 94, 11.9), ('fg5', 95, 11.9), ('fg5', 96, 11.9),
    ('fg5', 97, 11.9), ('fg5', 98, 11.9), ('fg5', 99, 11.9),
    ('fg5', 100, 11.9), ('fg5', 101, 12.0), ('fg5', 102, 12.0),
    ('fg5', 103, 12.0), ('fg5', 104, 12.0), ('fg5', 105, 12.0),
    ('fg5', 106, 12.1), ('fg5', 107, 12.1), ('fg5', 108, 12.1),
    ('fg5', 109, 12.1), ('fg5', 110, 12.1), ('fg5', 111, 12.2),
    ('fg5', 112, 12.2), ('fg5', 113, 12.2), ('fg5', 114, 12.2),
    ('fg5', 115, 12.3), ('fg5', 116, 12.3), ('fg5', 117, 12.3),
    ('fg5', 118, 12.3), ('fg5', 119, 12.4), ('fg5', 120, 12.4),
    ('fg5', 121, 12.4), ('fg5', 122, 12.4), ('fg5', 123, 12.5),
    ('fg5', 124, 12.5), ('fg5', 125, 12.5), ('fg5', 126, 12.5),
    ('fg5', 127, 12.6), ('fg5', 128, 12.6), ('fg5', 129, 12.6),
    ('fg5', 130, 12.7), ('fg5', 131, 12.7), ('fg5', 132, 12.7),
    ('fg5', 133, 12.8), ('fg5', 134, 12.8), ('fg5', 135, 12.8),
    ('fg5', 136, 12.9), ('fg5', 137, 12.9), ('fg5', 138, 12.9),
    ('fg5', 139, 13.0), ('fg5', 140, 13.0), ('fg5', 141, 13.0),
    ('fg5', 142, 13.1), ('fg5', 143, 13.1), ('fg5', 144, 13.2),
    ('fg5', 145, 13.2), ('fg5', 146, 13.2), ('fg5', 147, 13.3),
    ('fg5', 148, 13.3), ('fg5', 149, 13.3), ('fg5', 150, 13.4),
    ('fg5', 151, 13.4), ('fg5', 152, 13.5), ('fg5', 153, 13.5),
    ('fg5', 154, 13.5), ('fg5', 155, 13.6), ('fg5', 156, 13.6),
    ('fg5', 157, 13.6), ('fg5', 158, 13.7), ('fg5', 159, 13.7),
    ('fg5', 160, 13.8), ('fg5', 161, 13.8), ('fg5', 162, 13.8),
    ('fg5', 163, 13.9), ('fg5', 164, 13.9), ('fg5', 165, 13.9),
    ('fg5', 166, 14.0), ('fg5', 167, 14.0), ('fg5', 168, 14.0),
    ('fg5', 169, 14.1), ('fg5', 170, 14.1), ('fg5', 171, 14.1),
    ('fg5', 172, 14.1), ('fg5', 173, 14.2), ('fg5', 174, 14.2),
    ('fg5', 175, 14.2), ('fg5', 176, 14.3), ('fg5', 177, 14.3),
    ('fg5', 178, 14.3), ('fg5', 179, 14.3),
    ('mg5', 61, 12.1), ('mg5', 62, 12.1), ('mg5', 63, 12.1),
    ('mg5', 64, 12.1), ('mg5', 65, 12.1), ('mg5', 66, 12.1),
    ('mg5', 67, 12.1), ('mg5', 68, 12.1), ('mg5', 69, 12.1),
    ('mg5', 70, 12.1), ('mg5', 71, 12.1), ('mg5', 72, 12.1),
    ('mg5', 73, 12.1), ('mg5', 74, 12.2), ('mg5', 75, 12.2),
    ('mg5', 76, 12.2), ('mg5', 77, 12.2), ('mg5', 78, 12.2),
    ('mg5', 79, 12.2), ('mg5', 80, 12.2), ('mg5', 81, 12.2),
    ('mg5', 82, 12.2), ('mg5', 83, 12.2), ('mg5', 84, 12.3),
    ('mg5', 85, 12.3), ('mg5', 86, 12.3), ('mg5', 87, 12.3),
    ('mg5', 88, 12.3), ('mg5', 89, 12.3), ('mg5', 90, 12.3),
    ('mg5', 91, 12.3), ('mg5', 92, 12.3), ('mg5', 93, 12.4),
    ('mg5', 94, 12.4), ('mg5', 95, 12.4), ('mg5', 96, 12.4),
    ('mg5', 97, 12.4), ('mg5', 98, 12.4), ('mg5', 99, 12.4),
    ('mg5', 100, 12.4), ('mg5', 101, 12.5), ('mg5', 102, 12.5),
    ('mg5', 103, 12.5), ('mg5', 104, 12.5), ('mg5', 105, 12.5),
    ('mg5', 106, 12.5), ('mg5', 107, 12.5), ('mg5', 108, 12.6),
    ('mg5', 109, 12.6), ('mg5', 110, 12.6), ('mg5', 111, 12.6),
    ('mg5', 112, 12.6), ('mg5', 113, 12.6), ('mg5', 114, 12.7),
    ('mg5', 115, 12.7), ('mg5', 116, 12.7), ('mg5', 117, 12.7),
    ('mg5', 118, 12.7), ('mg5', 119, 12.8), ('mg5', 120, 12.8),
    ('mg5', 121, 12.8), ('mg5', 122, 12.8), ('mg5', 123, 12.8),
    ('mg5', 124, 12.9), ('mg5', 125, 12.9), ('mg5', 126, 12.9),
    ('mg5', 127, 12.9), ('mg5', 128, 13.0), ('mg5', 129, 13.0),
    ('mg5', 130, 13.0), ('mg5', 131, 13.0), ('mg5', 132, 13.1),
    ('mg5', 133, 13.1), ('mg5', 134, 13.1), ('mg5', 135, 13.1),
    ('mg5', 136, 13.2), ('mg5', 137, 13.2), ('mg5', 138, 13.2),
    ('mg5', 139, 13.2), ('mg5', 140, 13.3), ('mg5', 141, 13.3),
    ('mg5', 142, 13.3), ('mg5', 143, 13.4), ('mg5', 144, 13.4),
    ('mg5', 145, 13.4), ('mg5', 146, 13.5), ('mg5', 147, 13.5),
    ('mg5', 148, 13.5), ('mg5', 149, 13.6), ('mg5', 150, 13.6),
    ('mg5', 151, 13.6), ('mg5', 152, 13.7), ('mg5', 153, 13.7),
    ('mg5', 154, 13.7), ('mg5', 155, 13.8), ('mg5', 156, 13.8),
    ('mg5', 157, 13.8), ('mg5', 158, 13.9), ('mg5', 159, 13.9),
    ('mg5', 160, 14.0), ('mg5', 161, 14.0), ('mg5', 162, 14.0),
    ('mg5', 163, 14.1), ('mg5', 164, 14.1), ('mg5', 165, 14.1),
    ('mg5', 166, 14.2), ('mg5', 167, 14.2), ('mg5', 168, 14.3),
    ('mg5', 169, 14.3), ('mg5', 170, 14.3), ('mg5', 171, 14.4),
    ('mg5', 172, 14.4), ('mg5', 173, 14.5), ('mg5', 174, 14.5),
    ('mg5', 175, 14.5), ('mg5', 176, 14.6), ('mg5', 177, 14.6),
    ('mg5', 178, 14.6), ('mg5', 179, 14.7)
  ");*/

}

function cleanupHealthQual () {
  global $setupTableNames;

  dropTempTables ($setupTableNames);  
}

function healthQual($repNum, $site, $intervalLength, $startDate, $endDate = null) {
  global $indicatorProperties;
  global $setupTableNames;

  if (DEBUG_FLAG) echo "<BR />Entering healthQual: " . date ("Y-m-d H:i:s")  . " - site = $site - date = $endDate<BR />\n";

  setupHealthQual ($repNum, $site, $startDate, $endDate);

  $site = trim($site);
  $numM = 0;
  $numF = 0;
  $denM = 0; 
  $denF = 0; 
  $pedMNum = 0;
  $pedFNum = 0;
  $pedMDen = 0;
  $pedFDen = 0;
  $pidsByAgeSex = array ();
  $tmpDen = array ();
  $tmpNum = array ();
  $tmpInd = array ('01' => array (), /*'02' => array (), '03' => array (),*/
                   '04' => array (), '05' => array (), /*'06A' => array (),
                   '06B' => array (),*/ '12' => array (),'07' => array (), '08' => array (),
                   '09' => array (), '10' => array (), '11' => array (),
                   /*'12' => array (), '13' => array (),*/ '14' => array (),
                   '15' => array (), /*'16' => array (), '17' => array (),
                   '18' => array (),*/ '19' => array ());
  $tmpPedInd = array ('01' => array (), /*'02' => array (), '03' => array (),*/
                      '04' => array (), '05' => array (), /*'06A' => array (),
                      '06B' => array (),*/ '12' => array (),'07' => array (), '08' => array (),
                      '09' => array (), '10' => array (), '11' => array (),
                      /*'12' => array (), '13' => array (),*/ '14' => array (),
                      '15' => array (), /*'16' => array (), '17' => array (),
                      '18' => array (),*/ '19' => array ());

  if ($endDate == null) {
    $endDate = date ('Y-m-d');
  }

  // make sure patient status data exists
  // need $startDate and $endDate, $endDate - 3 months and $endDate - 6 months
  $checkDates = array ($startDate, $endDate);
  array_push ($checkDates, monthDiff(-3, $endDate), monthDiff(-6, $endDate));
  foreach ($checkDates as $checkDate) {
    if (!isPatientStatusExist($checkDate)) {
      updatePatientStatus(2, $checkDate);
    }
  }
  
  foreach ($indicatorProperties as $indicatorName => $indicatorProperty) {
    if (DEBUG_FLAG) echo "<BR />Running indicator #$indicatorName: " 
		      . date ("Y-m-d H:i:s")  . "<BR />\n";

    $tmpDen = call_user_func($indicatorProperty[denFunct], $repNum, $site, $intervalLength, $startDate, $endDate);
    $pidsByAgeSex = generateAgeGenderGroups ($tmpDen, $site, $startDate);
    $denM = count ($pidsByAgeSex["adultsM"]);
    $denF = count ($pidsByAgeSex["adultsF"]);
    $pedDenM = count ($pidsByAgeSex["kidsM"]);
    $pedDenF = count ($pidsByAgeSex["kidsF"]);
    
    if (DEBUG_FLAG) echo "<BR />Den. done, now num.:  " . date ("Y-m-d H:i:s")  . "<BR />\n";

    $tmpNum = array_intersect($tmpDen,
                              call_user_func($indicatorProperty[numFunct],
                                             $repNum, $site, $intervalLength,
                                             $startDate, $endDate));
    $numM = count (array_intersect ($tmpNum, $pidsByAgeSex["adultsM"]));
    $numF = count (array_intersect ($tmpNum, $pidsByAgeSex["adultsF"]));
    $pedNumM = count (array_intersect ($tmpNum, $pidsByAgeSex["kidsM"]));
    $pedNumF = count (array_intersect ($tmpNum, $pidsByAgeSex["kidsF"]));

    if ($pedDenM == 0) {
      $pedRatioM = "0";
    } else {
      $pedRatioM = round(100*$pedNumM/$pedDenM, 1);
    }
    
    if ($pedDenF == 0) {
      $pedRatioF = "0";
    } else {
      $pedRatioF = round(100*$pedNumF/$pedDenF, 1);
    }
    
    if ($pedDenM + $pedDenF == 0) {
      $pedRatio = "0";
    } else {
      $pedRatio = round(100*($pedNumM + $pedNumF)/($pedDenM + $pedDenF), 1);
    }
    
    if ($denM == 0) {
      $ratioM = "0";
    } else {
      $ratioM = round(100*$numM/$denM, 1);
    }
    
    if ($denF == 0) {
      $ratioF = "0";
    } else {
      $ratioF = round(100*$numF/$denF, 1);
    }
    
    if ($denM + $denF == 0) {
      $ratio = "0";
    } else {
      $ratio = round(100*($numM + $numF)/($denM + $denF), 1);
    }
    
    array_push($tmpInd[$indicatorName],
	       $startDate, $endDate, $numM, $numF, $numM + $numF, $denM, $denF, $denM + $denF, $ratioM, $ratioF, $ratio);

    array_push($tmpPedInd[$indicatorName],
               $startDate, $endDate, $pedNumM, $pedNumF, $pedNumM + $pedNumF, $pedDenM, $pedDenF, $pedDenM + $pedDenF, $pedRatioM, $pedRatioF, $pedRatio);
  }
  
  /* Insert values into pre-existing temp table */
  $tmpCases = array ();
  $cases = array ();

  /*$result = dbQuery ("SELECT DISTINCT p.patientID FROM patientStatusTemp s, patient p LEFT JOIN " . $setupTableNames[3] . " t2 ON p.patientID = t2.patientID LEFT JOIN " . $setupTableNames[4] . " t3 ON p.patientID = t3.patientID WHERE s.patientID = p.patientID AND s.endDate = '$endDate' AND s.patientStatus IN (2, 3, 4, 5, 6, 7, 8, 10) AND p.location_id = '$site' AND p.patStatus = 0 AND p.hivPositive = 1 AND t2.patientID IS NULL AND t3.patientID IS NULL");
  while ($row = psRowFetch ($result)) {
    array_push ($tmpCases, $row[0]);
  }*/
  $cases = generateAgeGenderGroups ($tmpCases, $site, $startDate);

  // insert into table, or update if rows already exists
  $colSql = "(lastRun, startDate, endDate, siteCode, casesM, casesF";
  $pedValSql = $valSql = "('" . date ("Y-m-d H:i:s") . "', '$startDate', '$endDate', '$site'";
  $valSql .= ", '" . count ($cases["adultsM"]) . "', '" . count ($cases["adultsF"]) . "'";
  $pedValSql .= ", '" . count ($cases["kidsM"]) . "', '" . count ($cases["kidsF"]) . "'";
  foreach ($tmpInd as $k => $v) {
    if ($k == "06B") continue;
    if ($k == "06A") $k = "06";
    $colSql .= ", ind" . $k . "_num_m, ind" . $k . "_num_f, ind" . $k . "_num_total, ind" . $k . "_den_m, ind" . $k . "_den_f, ind" . $k . "_den_total, ind" . $k . "_ratio_m, ind" . $k . "_ratio_f, ind" . $k . "_ratio_total";
    $valSql .= ", " . $v[2] . ", " . $v[3] . ", " . $v[4] .
               ", " . $v[5] . ", " . $v[6] . ", " . $v[7] .
               ", '" . $v[8] . "', '" . $v[9] . "', '" . $v[10] . "'";
  }
  $colSql .= ", row_type)";
  $valSql .= ", 1)";
  foreach ($tmpPedInd as $k => $v) {
    if ($k == "06A") continue;
    if ($k == "06B") $k = "06";
    $pedValSql .= ", " . $v[2] . ", " . $v[3] . ", " . $v[4] .
                  ", " . $v[5] . ", " . $v[6] . ", " . $v[7] .
                  ", '" . $v[8] . "', '" . $v[9] . "', '" . $v[10] . "'";
  }
  $pedValSql .= ", 2)";
  
  dbQuery("
DELETE FROM healthQual
WHERE siteCode = '$site'
 AND startDate = '$startDate'
 AND endDate = '$endDate'");

  dbQuery("INSERT healthQual " . $colSql . " VALUES " . $valSql);
  
  dbQuery("INSERT healthQual " . $colSql . " VALUES " . $pedValSql);

  if (DEBUG_FLAG) echo "<BR />Leaving healthQual: " . date ("Y-m-d H:i:s")  . "<BR />\n";

  cleanupHealthQual ();
}

// Patient Retention in ART Care
  
function getHealthQualInd1Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientid 
FROM pepfarTable p
 
WHERE p.siteCode = '$site'
 
 AND p.visitDate <= '$endDate'
 AND p.patientID not in(select distinct patientID from discEnrollment where sitecode = '$site' and (reasonDiscTransfer=1 or LOWER(discReasonOtherText) like '%transfert%') and ymdToDate(visitDateYy,visitDateMm,visitDateDd) <= '$endDate')
 AND p.patientID not in(select distinct patientID from patient where sitecode = '$site' and patientStatus is NULL OR patientStatus=0) 
 "));
}

function getHealthQualInd1Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  /*$threeMonths = monthDiff(-3, $endDate);
  
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e
WHERE e.encounterType IN " . visitList ("hivQual") . "
 AND e.siteCode = '$site'
 AND e.visitDate BETWEEN '$threeMonths' AND '$endDate'"));*/
 
 global $setupTableNames;
 $threeMonths = monthDiff(-3, $endDate);

  /*return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM (select p.patientId, max(p.visitDate) as date_visit from pepfarTable p 
, patientStatusTemp t
WHERE p.siteCode = '$site'
 AND p.patientID = t.patientID
 AND (t.patientStatus = 6 OR t.patientStatus = 8)
 
 AND p.visitDate <= '$endDate'
  GROUP BY 1
 HAVING date_visit BETWEEN '$threeMonths' AND '$endDate'
 ) l"));*/
 
 return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM (select p.patientId, p.visitDate from pepfarTable p
WHERE p.siteCode = '$site' AND p.visitDate BETWEEN '$startDate' AND '$endDate'
 
  GROUP BY 1

 UNION
select p.patientId, DATE_ADD(ymdToDate(p.dispDateYy, dispDateMm, dispDateDd), INTERVAL numDaysDesc DAY) from prescriptions p 
WHERE p.siteCode = '$site'
AND p.drugID in (1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88, 89, 90, 91)
AND DATE_ADD(ymdToDate(p.dispDateYy, dispDateMm, dispDateDd), INTERVAL numDaysDesc DAY) BETWEEN '$startDate' AND '$endDate'  
   GROUP BY 1
 

 ) l"));
}

// Patient Retention in Clinical Care
  
/*function getHealthQualInd2Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#healthQualInd2Den", 1, "patientID varchar(11)", "pid_idx::patientID");

  /* Don't count anyone who initiated ART */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT DISTINCT patientid FROM pepfarTable WHERE siteCode = '$site' AND (forPepPmtct = 0 OR forPepPmtct IS NULL) GROUP BY patientid HAVING MIN(visitDate) <= '$endDate'");

  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientID 
FROM patientStatusTemp s, patient p
 LEFT JOIN " . $tempTableNames[1] . " t1 ON p.patientID = t1.patientID
 LEFT JOIN " . $setupTableNames[3] . " t2 ON p.patientID = t2.patientID
 LEFT JOIN " . $setupTableNames[4] . " t3 ON p.patientID = t3.patientID
WHERE p.location_id = '$site'
 AND s.patientID = p.patientID
 AND s.endDate = '$endDate'
 AND s.patientStatus IN (2, 3, 4, 5, 6, 7, 8, 10)
 AND p.patStatus = 0
 AND p.hivPositive = 1
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
 AND t3.patientID IS NULL"));

  dropTempTables ($tempTableNames);  
  return $result;
}

function getHealthQualInd2Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  $sixMonths = monthDiff(-6, $endDate);
  
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e
WHERE e.encounterType IN " . visitList ("hivQual") . "
 AND e.siteCode = '$site'
 AND e.visitDate BETWEEN '$sixMonths' AND '$endDate'"));
}

// CD4 Monitoring
   
function getHealthQualInd3Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#healthQualInd3Den", 2, array ("patientID varchar(11), enrollDate date", "patientID varchar(11), maxDate date"), "pid_idx::patientID");

  /* Lookup patient enrollment dates */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT e.patientID, MIN(e.visitDate) FROM encValid e WHERE e.siteCode = '$site' AND e.encounterType IN (10, 15) AND e.visitDate <= '$endDate' GROUP BY e.patientID"); 

  /* Lookup patient's earliest visit within the period */
  /*dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT e.patientID, MAX(e.visitDate) FROM encValid e WHERE e.siteCode = '$site' AND e.encounterType IN " . visitList ("hivQual") . " AND e.visitDate BETWEEN '$startDate' AND '$endDate' GROUP BY e.patientID"); 

  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, " . $tempTableNames[1] . " t2, " . $tempTableNames[2] . " t3
 LEFT JOIN " . $setupTableNames[3] . " t4 ON t3.patientID = t4.patientID
 LEFT JOIN " . $setupTableNames[4] . " t5 ON t3.patientID = t5.patientID
 " . (strtotime ($endDate) > strtotime (CD4_350_DATE) ? "
 LEFT JOIN " . $setupTableNames[1] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN eligibility l ON t3.patientID = l.patientID" : "") . "
WHERE e.siteCode = '$site'
 AND e.patientID = t2.patientID
 AND e.patientID = t3.patientID
 AND t2.enrollDate <= DATEADD(mm, -6, t3.maxDate)
 " . (strtotime ($endDate) > strtotime (CD4_350_DATE) ? "
 AND
 (
  t1.startDays >= 15 * " . DAYS_IN_YEAR . "
  OR
  (t1.startDays >= 0
   AND t1.startDays < 15 * " . DAYS_IN_YEAR . "
   AND l.visitDate <= '$startDate'
   AND l.reason IN ('cd4LT200', 'eligByAge', 'eligByCond', 'eligPcr', 'tlcLT1200', 'WHOIII-2', 'WHOIIICond', 'WHOIV')
   AND l.criteriaVersion = 2)
 )" : "") . " 
 AND t4.patientID IS NULL
 AND t5.patientID IS NULL"));

  dropTempTables ($tempTableNames);  
  return $result;
}

function getHealthQualInd3Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#healthQualInd3Num", 1, "patientID varchar(11), maxDate date", "pid_idx::patientID");

  /* Lookup patient's earliest visit within the period */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT e.patientID, MAX(e.visitDate) FROM encValid e WHERE e.siteCode = '$site' AND e.encounterType IN " . visitList ("hivQual") . " AND e.visitDate BETWEEN '$startDate' AND '$endDate' GROUP BY e.patientID"); 

  $result = fetchFirstColumn(dbQuery("
SELECT l.patientid
FROM cd4Table l, " . $tempTableNames[1] . " t1
WHERE l.patientid = t1.patientID
 AND l.visitDate BETWEEN DATEADD(mm, -12, t1.maxDate) AND t1.maxDate
GROUP BY l.patientID
HAVING COUNT(l.visitDate) >= 2"));

  dropTempTables ($tempTableNames);  
  return $result;
}

// CD4 at Enrollment

function getHealthQualInd4Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT e.patientID 
FROM encValid e
 LEFT JOIN " . $setupTableNames[3] . " t3 ON e.patientID = t3.patientID
 LEFT JOIN " . $setupTableNames[4] . " t4 ON e.patientID = t4.patientID
 " . (strtotime ($endDate) > strtotime (CD4_350_DATE) ? "
 LEFT JOIN " . $setupTableNames[1] . " t1 ON e.patientID = t1.patientID
 LEFT JOIN eligibility l ON e.patientID = l.patientID" : "") . "
WHERE e.siteCode = '$site'
 " . (strtotime ($endDate) > strtotime (CD4_350_DATE) ? "
 AND
 (
  t1.startDays >= 15 * " . DAYS_IN_YEAR . "
  OR
  (t1.startDays >= 0
   AND t1.startDays < 15 * " . DAYS_IN_YEAR . "
   AND l.visitDate <= '$startDate'
   AND l.reason IN ('cd4LT200', 'eligByAge', 'eligByCond', 'eligPcr', 'tlcLT1200', 'WHOIII-2', 'WHOIIICond', 'WHOIV')
   AND l.criteriaVersion = 2)
 )" : "") . " 
 AND e.encounterType IN (10, 15)
 AND t3.patientID IS NULL
 AND t4.patientID IS NULL
GROUP BY e.patientID 
HAVING MIN(e.visitDate) BETWEEN '$startDate' AND '$endDate'"));
}

function getHealthQualInd4Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT l.patientid
FROM cd4Table l, (
 SELECT e.patientID, MIN(e.visitDate) AS enrollDate
 FROM encValid e
 WHERE e.siteCode = '$site'
  AND e.encounterType IN (10, 15)
 GROUP BY e.patientID 
 HAVING MIN(e.visitDate) BETWEEN '$startDate' AND '$endDate') t
WHERE t.patientID = l.patientID
 AND l.visitDate BETWEEN DATEADD(mm, -2, t.enrollDate) AND DATEADD(mm, 2, t.enrollDate)
GROUP BY l.patientID
HAVING COUNT(l.visitDate) >= 1"));
}*/

//nouvel indicateur ARV en cours
/*function getHealthQualInd4Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT v.patientID
FROM patient
WHERE patientStatus in(6,8)"));
}*/

//nouvel indicateur ARV en cours
/*function getHealthQualInd4Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT v.patientID
FROM patient
WHERE patientStatus in(6,8)"));
}*/

// Level of Adherence
   
function getHealthQualInd8Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  /*global $setupTableNames;
  $rangeStart = monthDiff (-3, $endDate);

  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT p.patientid 
FROM encValid e, pepfarTable p
 LEFT JOIN " . $setupTableNames[3] . " t1 ON p.patientID = t1.patientID
 LEFT JOIN " . $setupTableNames[4] . " t2 ON p.patientID = t2.patientID
WHERE e.siteCode = '$site'
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND p.visitDate <= '$rangeStart'
 AND p.patientid = e.patientID
 AND e.encounterType IN (14, 20)
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL"));*/
 
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
select p.patientId, min(p.visitDate) as date_visit from pepfarTable p, encValid e
WHERE p.siteCode = '$site'
 AND p.patientID=e.patientID
 AND p.patientID not in(select distinct patientID from discEnrollment d where d.sitecode = '$site' and (reasonDiscTransfer=1 or reasonDiscDeath=1 or LOWER(discReasonOtherText) like '%transfert%') and ymdToDate(visitDateYy,visitDateMm,visitDateDd) <= '$endDate')
 AND p.patientID not in(select distinct patientID from patient q where location_id = '$site' and patientStatus is NULL OR patientStatus=0)
 AND e.encounterType IN (14, 20)
 AND timestampdiff(month, e.visitDate,'$endDate') between 0 and 3
 GROUP BY 1
 HAVING datediff(mm,date_visit, '$endDate') >=3"));
}

function getHealthQualInd8Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  /*$tempTableNames = createTempTables ("#healthQualInd8Num", 2, array ("patientID varchar(11), doseProp tinyint unsigned", "patientID varchar(11), doseAvg decimal(4,2)"), "pid_idx::patientID");

  /* Collect all doseProp values to be able to compute average */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN e.patientID, CASE WHEN a.doseProp = 1 THEN 0 WHEN a.doseProp BETWEEN 2 AND 3 THEN 1 WHEN a.doseProp BETWEEN 4 AND 7 THEN 2 WHEN a.doseProp BETWEEN 8 AND 15 THEN 3 WHEN a.doseProp BETWEEN 16 AND 31 THEN 4 WHEN a.doseProp BETWEEN 32 AND 63 THEN 5 WHEN a.doseProp BETWEEN 64 AND 127 THEN 6 WHEN a.doseProp BETWEEN 128 AND 255 THEN 7 WHEN a.doseProp BETWEEN 256 AND 511 THEN 8 WHEN a.doseProp BETWEEN 512 AND 1023 THEN 9 WHEN a.doseProp >= 1024 THEN 10 END AS doseProp FROM encValid e, adherenceCounseling a WHERE e.siteCode = '$site' AND e.encounterType IN (14, 20) AND e.patientID = a.patientID AND e.siteCode = a.siteCode AND e.visitDateDd = a.visitDateDd AND e.visitDateMm = a.visitDateMm AND e.visitDateYy = a.visitDateYy AND e.seqNum = a.seqNum AND a.doseProp IS NOT NULL AND a.doseProp > 0 AND e.visitDate BETWEEN '$startDate' AND '$endDate'");

  /* Compute average per patient */
  /*dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT patientID, AVG(doseProp) FROM " . $tempTableNames[1] . " t1 GROUP BY 1");

  $result = fetchFirstColumn(dbQuery("
SELECT t2.patientID 
FROM " . $tempTableNames[2] . " t2
WHERE t2.doseAvg >= 9.5"));

  dropTempTables ($tempTableNames);
  return $result;*/
  
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
select p.patientId, min(p.visitDate) as date_visit from pepfarTable p, adherenceCounseling ad
WHERE p.siteCode = '$site'
 and p.patientID=ad.patientID
 and doseProp in(512,1024)
 and ymdToDate(ad.visitDateYy,ad.visitDateMm,ad.visitDateDd) between '$startDate' and '$endDate'
 GROUP BY 1
 HAVING datediff(mm,date_visit, '$endDate') >=3"));
}
/*
// Isoniazid Prophylaxis

function getHealthQualInd10Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#healthQualInd10Den", 9, array ("patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date, maxSeq tinyint unsigned", "patientID varchar(11), hivStat tinyint unsigned", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11)"), "pat_idx::patientID");

  /* Don't count patients with active TB, regardless of treatment status */

  /* First, check for active diagnoses */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN e.patientID, MAX(e.visitDate) FROM encValid e, conditions c WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND (c.conditionID IN (20,21,41,208,397,405,409,423) AND ((c.conditionActive IN (1,5) AND e.encounterType IN (16,17)) OR (c.conditionActive IN (1,4,5) AND e.encounterType IN (1,2)) OR (c.conditionActive = 1 AND e.encounterType IN (24,25)))) AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");
  dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT STRAIGHT_JOIN e.patientID, MAX(e.visitDate) FROM encValid e, conditions c WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND (c.conditionID IN (20,21,41,208,397,405,409,423) AND ((c.conditionActive IN (2,3,6,7) AND e.encounterType IN (1,2,16,17)) OR (c.conditionActive > 1 AND e.encounterType IN (24,25)))) AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");

  /* If marked 'resolved' after 'active', then remove from active list */
  /*dbQuery ("DELETE t1 FROM " . $tempTableNames[1] . " t1, " . $tempTableNames[2] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Pull most recent 'treatment completed' or 'asymptomatic' date */
  /*dbQuery ("INSERT INTO " . $tempTableNames[3] . " SELECT STRAIGHT_JOIN e.patientID, CASE WHEN c.completeTreat = 1 THEN MAX(dbo.ymdToDate(c.completeTreatYy, c.completeTreatMm, c.completeTreatDd)) WHEN c.asymptomaticTb = 1 OR c.noTBsymptoms = 1 THEN e.visitDate END FROM tbStatus c, encValid e WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND e.encounterType IN (1,2,16,17) AND ((c.completeTreat = 1 AND ISDATE(dbo.ymdToDate(c.completeTreatYy, c.completeTreatMm, c.completeTreatDd)) = 1 AND dbo.ymdToDate(c.completeTreatYy, c.completeTreatMm, c.completeTreatDd) <= '$endDate') OR c.asymptomaticTb = 1 OR c.noTBsymptoms = 1) AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");

  /* Check for negative lab tests */
  /*dbQuery ("INSERT INTO " . $tempTableNames[6] . " SELECT STRAIGHT_JOIN e.patientID, MAX(CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END) FROM encValid e, labs l WHERE e.patientID = l.patientID AND e.siteCode = l.siteCode AND e.visitDateDd = l.visitDateDd AND e.visitDateMm = l.visitDateMm AND e.visitDateYy = l.visitDateYy AND e.seqNum = l.seqNum AND ((e.encounterType IN (6, 19) AND l.ordered = 1 AND l.labID = 130 AND ISNUMERIC(l.result) AND l.result < 5) OR (e.encounterType IN (6, 19) AND l.ordered = 1 AND l.labID IN (131, 169, 172) AND ISNUMERIC(l.result) AND l.result = 2) OR (LOWER(l.testNameFr) LIKE '%ppd qual%' AND LOWER(LTRIM(RTRIM(l.result))) LIKE '%non%' AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%ppd quant%' AND ISNUMERIC(l.result) AND l.result < 5 AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%tuberculos%' AND LOWER(LTRIM(RTRIM(l.result))) NOT LIKE '%pos%' AND LOWER(l.sampleType) = 'expectoration') OR ((LOWER(l.testNameFr) LIKE '%baar%' OR LOWER(l.testNameFr LIKE '%barr%')) AND LOWER(LTRIM(RTRIM(l.result))) LIKE '%nég%' AND LOWER(l.sampleType) IN ('liquide pleural', 'expectoration', 'sputum'))) AND e.siteCode = '$site' AND CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END <= '$endDate' GROUP BY 1");

  /* If treatment completed after diagnosis, then not active */
  /*dbQuery ("DELETE t1 FROM " . $tempTableNames[1] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* If negative lab result after diagnosis, then not active */
  /*dbQuery ("DELETE t1 FROM " . $tempTableNames[1] . " t1, " . $tempTableNames[6] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Next, check for positive lab tests */
  /*dbQuery ("INSERT INTO " . $tempTableNames[7] . " SELECT STRAIGHT_JOIN e.patientID, MAX(CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END) FROM encValid e, labs l WHERE e.patientID = l.patientID AND e.siteCode = l.siteCode AND e.visitDateDd = l.visitDateDd AND e.visitDateMm = l.visitDateMm AND e.visitDateYy = l.visitDateYy AND e.seqNum = l.seqNum AND ((e.encounterType IN (6, 19) AND l.ordered = 1 AND ISNUMERIC(l.result) AND l.labID = 130 AND l.result >= 5) OR (e.encounterType IN (6, 19) AND l.ordered = 1 AND ISNUMERIC(l.result) AND l.labID IN (131, 169, 172) AND l.result = 1) OR (LOWER(l.testNameFr) LIKE '%ppd qual%' AND LOWER(LTRIM(RTRIM(l.result))) NOT LIKE '%non%' AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%ppd quant%' AND ISNUMERIC(l.result) AND l.result > 0 AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%tuberculos%' AND LOWER(LTRIM(RTRIM(l.result))) LIKE '%pos%' AND LOWER(l.sampleType) = 'expectoration') OR ((LOWER(l.testNameFr) LIKE '%baar%' OR LOWER(l.testNameFr LIKE '%barr%')) AND LOWER(LTRIM(RTRIM(l.result))) NOT LIKE '%nég%' AND LOWER(l.sampleType) IN ('liquide pleural', 'expectoration', 'sputum'))) AND e.siteCode = '$site' AND CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END <= '$endDate' GROUP BY 1");

  /* If treatment completed after positive lab test, then not active */
  /*dbQuery ("DELETE t1 FROM " . $tempTableNames[7] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* If negative lab result after positive lab result, then not active */
  /*dbQuery ("DELETE t1 FROM " . $tempTableNames[7] . " t1, " . $tempTableNames[6] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Finally, check for indications of treatment: */
  /*   A) 2 or more anti-TB meds dispensed on the same date */
  /*   B) 'Currently on treatment' selected on intake/f-u forms */
  /*dbQuery ("INSERT INTO " . $tempTableNames[8] . " SELECT STRAIGHT_JOIN e.patientID, MAX(CASE WHEN ISDATE(dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01'))) = 1 THEN dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01')) ELSE e.visitDate END) FROM encValid e, prescriptions p, drugLookup d WHERE d.drugID = p.drugID AND d.drugGroup = 'Anti-TB' AND (p.forPepPmtct IS NULL OR p.forPepPmtct <> 1) AND e.patientID = p.patientID AND e.siteCode = p.siteCode AND e.visitDateDd = p.visitDateDd AND e.visitDateMm = p.visitDateMm AND e.visitDateYy = p.visitDateYy AND e.seqNum = p.seqNum AND e.siteCode = '$site' AND CASE WHEN ISDATE(dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01'))) = 1 THEN dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01')) ELSE e.visitDate END <= '$endDate' GROUP BY 1 HAVING COUNT(DISTINCT p.drugID) >= 2");
  dbQuery ("TRUNCATE TABLE " . $tempTableNames[2]);
  dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT STRAIGHT_JOIN e.patientID, MAX(e.visitDate) FROM encValid e, tbStatus t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.encounterType IN (1, 2, 16, 17) AND t.currentTreat = 1 AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");
  
  /* If treatment completed, then not active */
  /*dbQuery ("DELETE t1 FROM " . $tempTableNames[8] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");
  dbQuery ("DELETE t1 FROM " . $tempTableNames[2] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Merge all active TB patients into one table */
  /*dbQuery ("INSERT INTO " . $tempTableNames[9] . " SELECT patientID FROM " . $tempTableNames[1] . " UNION SELECT patientID FROM " . $tempTableNames[7] . " UNION SELECT patientID FROM " . $tempTableNames[8] . " UNION SELECT patientID FROM " . $tempTableNames[2]);

  /* Read HIV status from pediatric patient's most recent form */
  /*dbQuery ("INSERT INTO " . $tempTableNames[4] . " SELECT e.patientID, MAX(e.visitDate), MAX(e.seqNum) FROM encValid e, vitals t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND e.encounterType IN (16, 17) AND t.pedCurrHiv >= 1 AND e.visitDate <= '$endDate' GROUP BY 1");
  dbQuery ("INSERT INTO " . $tempTableNames[5] . " SELECT DISTINCT e.patientID, t.pedCurrHiv FROM encValid e, vitals t, " . $tempTableNames[4] . " t1 WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND e.encounterType IN (16, 17) AND e.patientID = t1.patientID AND e.visitDate = t1.maxDate AND e.seqNum = t1.maxSeq");

  // Adults
  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $tempTableNames[9] . " t2 ON t3.patientID = t2.patientID
WHERE e.patientID = t3.patientID
 AND t3.startDays >= 15 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL"));

  // Ped. infected >= 1 yr. old
  $result1 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, " . $tempTableNames[5] . " t4, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $tempTableNames[9] . " t2 ON t3.patientID = t2.patientID
 LEFT JOIN " . $setupTableNames[3] . " t5 ON t3.patientID = t5.patientID
WHERE e.patientID = t4.patientID
 AND t4.hivStat > 1
 AND e.patientID = t3.patientID
 AND t3.startDays >= " . DAYS_IN_YEAR . "
 AND t3.startDays < 15 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
 AND t5.patientID IS NULL"));

  // Ped. infected < 1 yr. old
  $result2 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_tbStatus t, encValid e, " . $tempTableNames[5] . " t4, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $setupTableNames[3] . " t2 ON t3.patientID = t2.patientID
WHERE e.patientID = t4.patientID
 AND t4.hivStat > 1
 AND e.patientID = t.patientID
 AND t.pedTbEvalRecentExp = 1
 AND t.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = t3.patientID
 AND t3.startDays >= 0
 AND t3.startDays < " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL"));

  // Ped. exposed
  $result3 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_tbStatus t, encValid e, " . $tempTableNames[5] . " t4, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $tempTableNames[9] . " t2 ON t3.patientID = t2.patientID
 LEFT JOIN " . $setupTableNames[3] . " t5 ON t3.patientID = t5.patientID
WHERE e.patientID = t4.patientID
 AND t4.hivStat = 1
 AND e.patientID = t.patientID
 AND t.pedTbEvalRecentExp = 1
 AND t.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = t3.patientID
 AND t3.startDays >= 0
 AND t3.startDays < 15 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
 AND t5.patientID IS NULL"));

  dropTempTables ($tempTableNames);  
  return array_merge($result, $result1, $result2, $result3);
}

function getHealthQualInd10Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e, tbStatus t
WHERE e.patientID = t.patientID
 AND e.siteCode = t.siteCode
 AND e.visitDateDd = t.visitDateDd
 AND e.visitDateMm = t.visitDateMm
 AND e.visitDateYy = t.visitDateYy
 AND e.seqNum = t.seqNum
 AND e.siteCode = '$site'
 AND (t.currentProp = 1 OR t.propINH = 1)
 AND e.encounterType IN (1, 2, 16, 17)
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
UNION
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e, prescriptions t
WHERE e.patientID = t.patientID
 AND e.siteCode = t.siteCode
 AND e.visitDateDd = t.visitDateDd
 AND e.visitDateMm = t.visitDateMm
 AND e.visitDateYy = t.visitDateYy
 AND e.seqNum = t.seqNum
 AND e.siteCode = '$site'
 AND e.encounterType IN (5, 18)
 AND t.drugID IN (18)
 AND t.forPepPmtct = 1
 AND t.dispensed = 1
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
}

// Severe Malnutrition Monitoring

function getHealthQualInd12Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $threeMonths = monthDiff(-3, $endDate);
  $sixMonths = monthDiff(-6, $endDate);

  $tempTableNames = createTempTables ("#healthQualInd12Den", 2, "patientID varchar(11), visitDate date", "pat_visit_idx::patientID, visitDate");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT patientID, MAX(visitDate) FROM v_vitals WHERE siteCode = '$site' AND (ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)), ',', '.')) = 1 OR ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)), ',', '.')) = 1) GROUP BY patientID");
  
  dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT patientID, MAX(visitDate) FROM v_vitals WHERE siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) = 1 AND visitDate BETWEEN '$startDate' AND '$endDate' GROUP BY patientID");
	
  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValid e, " . $tempTableNames[1] . " t1,
 " . $tempTableNames[2] . " t2,
 " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[3] . " t4 ON t3.patientID = t4.patientID
 LEFT JOIN " . $setupTableNames[4] . " t5 ON t3.patientID = t5.patientID
WHERE e.patientID = t1.patientID
 AND e.patientID = t2.patientID
 AND e.patientID = t3.patientID
 AND
 (
  (t3.startDays >= 0 AND t3.startDays < 10 * " . DAYS_IN_YEAR . " AND
   t2.visitDate BETWEEN '$threeMonths' AND '$endDate')
  OR
  (t3.startDays >= 10 * " . DAYS_IN_YEAR . "
   AND t3.startDays < 19 * " . DAYS_IN_YEAR . " AND
   t2.visitDate BETWEEN '$sixMonths' AND '$endDate')
  OR
   t3.startDays >= 19 * " . DAYS_IN_YEAR . "
 )
 AND t4.patientID IS NULL
 AND t5.patientID IS NULL"));

  $result2 = fetchFirstColumn(dbQuery("
SELECT DISTINCT v.patientID
FROM v_vitals v, " . $setupTableNames[1] . " t1
 LEFT JOIN " . $setupTableNames[3] . " t2 ON t1.patientID = t2.patientID
 LEFT JOIN " . $setupTableNames[4] . " t3 ON t1.patientID = t3.patientID
WHERE v.patientID = t1.patientID
 AND v.visitDate BETWEEN '$startDate' AND '$endDate'
 AND v.encounterType IN (16, 17)
 AND t1.startDays >= " . DAYS_IN_MONTH . "
 AND t1.startDays < 6 * " . DAYS_IN_YEAR . "
 AND
  (ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitCurBracCirc)), ',', '.')) = 1
   OR
   ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitCurCircCirc)), ',', '.')) = 1
  )
 AND t2.patientID IS NULL
 AND t3.patientID IS NULL"));
  
  dropTempTables ($tempTableNames);  
  return array_unique (array_merge ($result, $result2));
}

function getHealthQualInd12Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#healthQualInd12Num", 8, array ("patientID varchar(11), maxDate date, maxSeq tinyint unsigned", "patientID varchar(11), maxDate date, maxSeq tinyint unsigned", "patientID varchar(11), height decimal(4,1)", "patientID varchar(11), weight decimal(4,1)", "patientID varchar(11), maxDate date, maxSeq tinyint unsigned", "patientID varchar(11), maxDate date, maxSeq tinyint unsigned", "patientID varchar(11), armCirc decimal(4,2)", "patientID varchar(11), acHcRatio decimal(4,2)"), "pat_idx::patientID");

  /* Read most recent weights and heights/lengths */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT patientID, MAX(visitDate), MAX(seqNum) FROM v_vitals WHERE siteCode = '$site' AND (ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)), ',', '.')) = 1 OR ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)), ',', '.')) = 1) AND encounterType IN (1, 2, 16, 17) AND visitDate <= '$endDate' GROUP BY 1");
  dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT patientID, MAX(visitDate), MAX(seqNum) FROM v_vitals WHERE siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) = 1 AND encounterType IN (1, 2, 16, 17) AND visitDate <= '$endDate' GROUP BY 1");
  dbQuery ("INSERT INTO " . $tempTableNames[3] . " SELECT DISTINCT v.patientID, CASE WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)),',','.')) = 1 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)),',','.')) = 1 THEN REPLACE(LTRIM(RTRIM(v.vitalHeight)),',','.') * 100 + REPLACE(LTRIM(RTRIM(v.vitalHeightCm)),',','.') WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)),',','.')) = 1 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)),',','.')) <> 1 THEN REPLACE(LTRIM(RTRIM(v.vitalHeight)),',','.') * 100 WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)),',','.')) <> 1 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)),',','.')) = 1 THEN REPLACE(LTRIM(RTRIM(v.vitalHeightCm)),',','.') END FROM v_vitals v, " . $tempTableNames[1] . " t1 WHERE v.siteCode = '$site' AND (ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)), ',', '.')) = 1 OR ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)), ',', '.')) = 1) AND v.encounterType IN (1, 2, 16, 17) AND v.visitDate <= '$endDate' AND v.patientID = t1.patientID AND v.visitDate = t1.maxDate AND v.seqNum = t1.maxSeq");
  dbQuery ("INSERT INTO " . $tempTableNames[4] . " SELECT DISTINCT v.patientID, CASE WHEN v.vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(v.vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(v.vitalWeight)), ',', '.') END FROM v_vitals v, " . $tempTableNames[2] . " t1 WHERE v.siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalWeight)), ',', '.')) = 1 AND v.encounterType IN (1, 2, 16, 17) AND v.visitDate <= '$endDate' AND v.patientID = t1.patientID AND v.visitDate = t1.maxDate AND v.seqNum = t1.maxSeq");

  /* Read most recent arm circumference and AC/HC ratio */
  /*dbQuery ("INSERT INTO " . $tempTableNames[5] . " SELECT patientID, MAX(visitDate), MAX(seqNum) FROM v_vitals WHERE siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(pedVitCurBracCirc)), ',', '.')) = 1 AND encounterType IN (16, 17) AND visitDate BETWEEN '$startDate' AND '$endDate' GROUP BY 1");
  dbQuery ("INSERT INTO " . $tempTableNames[6] . " SELECT patientID, MAX(visitDate), MAX(seqNum) FROM v_vitals WHERE siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(pedVitCurCircCirc)), ',', '.')) = 1 AND encounterType IN (16, 17) AND visitDate BETWEEN '$startDate' AND '$endDate' GROUP BY 1");
  dbQuery ("INSERT INTO " . $tempTableNames[7] . " SELECT DISTINCT v.patientID, REPLACE(LTRIM(RTRIM(v.pedVitCurBracCirc)), ',', '.') FROM v_vitals v, " . $tempTableNames[5] . " t1 WHERE v.siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitCurBracCirc)), ',', '.')) = 1 AND v.encounterType IN (16, 17) AND v.visitDate BETWEEN '$startDate' AND '$endDate' AND v.patientID = t1.patientID AND v.visitDate = t1.maxDate AND v.seqNum = t1.maxSeq");
  dbQuery ("INSERT INTO " . $tempTableNames[8] . " SELECT DISTINCT v.patientID, CASE WHEN REPLACE(LTRIM(RTRIM(v.pedVitCurCircCirc)), ',', '.') < 1 THEN REPLACE(LTRIM(RTRIM(v.pedVitCurCircCirc)), ',', '.') * 100 ELSE REPLACE(LTRIM(RTRIM(v.pedVitCurCircCirc)), ',', '.') END FROM v_vitals v, " . $tempTableNames[6] . " t1 WHERE v.siteCode = '$site' AND ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitCurCircCirc)), ',', '.')) = 1 AND v.encounterType IN (16, 17) AND v.visitDate BETWEEN '$startDate' AND '$endDate' AND v.patientID = t1.patientID AND v.visitDate = t1.maxDate AND v.seqNum = t1.maxSeq");

  // Adults <= 16 BMI
  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT t1.patientID 
FROM " . $setupTableNames[1] . " t1, " . $tempTableNames[3] . " t2,
 " . $tempTableNames[4] . " t3
WHERE t1.patientID = t2.patientID
 AND t1.patientID = t3.patientID
 AND t1.startDays >= 15 * " . DAYS_IN_YEAR . "
 AND t3.weight / ((t2.height / 100) * (t2.height / 100)) <= 16"));

  // Ped. 0 to 14 yrs. < -3 SD from median for gender and length/height
  $result1 = fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientID
FROM patient p, " . $setupTableNames[1] . " t1,
 " . $tempTableNames[3] . " t2,
 " . $tempTableNames[4] . " t3,
 " . $setupTableNames[5] . " t4
WHERE p.patientID = t1.patientID
 AND p.patientID = t2.patientID
 AND p.patientID = t3.patientID
 AND t1.startDays >= 0
 AND t1.startDays < 15 * " . DAYS_IN_YEAR . "
 AND
  CASE WHEN p.sex = 1 AND t1.startDays < 2 * " . DAYS_IN_YEAR . " THEN 'fl2'
  WHEN p.sex = 1 AND t1.startDays >= 2 * " . DAYS_IN_YEAR . " AND t1.startDays < 5 * " . DAYS_IN_YEAR . " THEN 'fg2'
  WHEN p.sex = 1 AND t1.startDays >= 5 * " . DAYS_IN_YEAR . " THEN 'fg5'
  WHEN p.sex = 2 AND t1.startDays < 2 * " . DAYS_IN_YEAR . " THEN 'ml2'
  WHEN p.sex = 2 AND t1.startDays >= 2 * " . DAYS_IN_YEAR . " AND t1.startDays < 5 * " . DAYS_IN_YEAR . " THEN 'mg2'
  WHEN p.sex = 2 AND t1.startDays >= 5 * " . DAYS_IN_YEAR . " THEN 'mg5'
  END = t4.category
 AND
  CASE WHEN t1.startDays < 5 * " . DAYS_IN_YEAR . " THEN ROUND(t2.height * 2) / 2
  WHEN t1.startDays >= 5 * " . DAYS_IN_YEAR . " THEN FLOOR(t1.startDays / " . DAYS_IN_MONTH . ")
  END = t4.measure
 AND
  CASE WHEN t1.startDays < 5 * " . DAYS_IN_YEAR . " THEN t3.weight
  WHEN t1.startDays >= 5 * " . DAYS_IN_YEAR . " THEN t3.weight / ((t2.height / 100) * (t2.height / 100))
  END < t4.threshold"));

  // Ped. 1 mo. to 5 yrs. MUAC < 12.5 cm
  $result2 = fetchFirstColumn(dbQuery("
SELECT DISTINCT t1.patientID 
FROM " . $setupTableNames[1] . " t1, " . $tempTableNames[7] . " t2
WHERE t1.patientID = t2.patientID
 AND t1.startDays >= " . DAYS_IN_MONTH . "
 AND t1.startDays < 6 * " . DAYS_IN_YEAR . "
 AND t2.armCirc < 12.5"));

  // Ped. 1 mo. to 5 yrs. AC/HC ratio < 25%
  $result3 = fetchFirstColumn(dbQuery("
SELECT DISTINCT t1.patientID 
FROM " . $setupTableNames[1] . " t1, " . $tempTableNames[8] . " t2
WHERE t1.patientID = t2.patientID
 AND t1.startDays >= " . DAYS_IN_MONTH . "
 AND t1.startDays < 6 * " . DAYS_IN_YEAR . "
 AND t2.acHcRatio < 25"));

  dropTempTables ($tempTableNames);  
  return array_unique (array_merge ($result, $result1, $result2, $result3));
}

// Syphilis Treatment

function getHealthQualInd15Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#healthQualInd15Den", 1, "patientID varchar(11)", "pat_idx::patientID");

  /* Collect positive syphilis cases */
  /*dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT e.patientID FROM encValid e, obs o WHERE e.encounter_id = o.encounter_id AND e.siteCode = o.location_id AND o.concept_id IN (71021, 71022) AND e.siteCode = '$site' AND e.visitDate BETWEEN '$startDate' AND '$endDate'");
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT e.patientID FROM encValid e, conditions c WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND (c.conditionID IN (350) AND ((c.conditionActive IN (1,5) AND e.encounterType IN (16,17)) OR (c.conditionActive IN (1,4,5) AND e.encounterType IN (1,2)) OR (c.conditionActive = 1 AND e.encounterType IN (24,25)))) AND e.siteCode = '$site' AND e.visitDate BETWEEN '$startDate' AND '$endDate'");
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT patientID FROM v_labsCompleted WHERE LOWER(testNameFr) LIKE '%syphilis%' AND ((LOWER(LTRIM(RTRIM(result))) IS NOT NULL AND LOWER(LTRIM(RTRIM(result))) != '' AND LOWER(LTRIM(RTRIM(result))) NOT LIKE '%neg%' AND LOWER(LTRIM(RTRIM(result))) NOT LIKE '%nég%') OR (LOWER(LTRIM(RTRIM(result2))) IS NOT NULL AND LOWER(LTRIM(RTRIM(result2))) != '' AND LOWER(LTRIM(RTRIM(result2))) NOT LIKE '%neg%' AND LOWER(LTRIM(RTRIM(result2))) NOT LIKE '%nég%') OR (LOWER(LTRIM(RTRIM(result3))) IS NOT NULL AND LOWER(LTRIM(RTRIM(result3))) != '' AND LOWER(LTRIM(RTRIM(result3))) NOT LIKE '%neg%' AND LOWER(LTRIM(RTRIM(result3))) NOT LIKE '%nég%') OR (LOWER(LTRIM(RTRIM(result4))) IS NOT NULL AND LOWER(LTRIM(RTRIM(result4))) != '' AND LOWER(LTRIM(RTRIM(result4))) NOT LIKE '%neg%' AND LOWER(LTRIM(RTRIM(result4))) NOT LIKE '%nég%')) AND siteCode = '$site' AND dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd) BETWEEN '$startDate' AND '$endDate'");

  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientID
FROM patient p, " . $tempTableNames[1] . " t1, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t2 ON t3.patientID = t2.patientID
WHERE p.patientID = t1.patientID
 AND p.sex = 1
 AND p.patientID = t3.patientID
 AND t3.startDays >= " . DAYS_IN_YEAR . " * 15
 AND t2.patientID IS NULL"));

  dropTempTables ($tempTableNames);  
  return $result;
}

function getHealthQualInd15Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e, prescriptions t
WHERE e.patientID = t.patientID
 AND e.siteCode = t.siteCode
 AND e.visitDateDd = t.visitDateDd
 AND e.visitDateMm = t.visitDateMm
 AND e.visitDateYy = t.visitDateYy
 AND e.seqNum = t.seqNum
 AND e.siteCode = '$site'
 AND t.drugID in (79, 84)
 AND e.encounterType IN (5, 18)
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
}

// Cervical Cancer Screening

function getHealthQualInd16Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientID
FROM patient p, encValid e, " . $setupTableNames[1] . " t1
 LEFT JOIN " . $setupTableNames[4] . " t2 ON t1.patientID = t2.patientID
WHERE p.patientID = e.patientID
 AND p.patientID = t1.patientID
 AND p.sex = 1
 AND t1.startDays >= " . DAYS_IN_YEAR . " * 25
 AND t1.startDays < " . DAYS_IN_YEAR . " * 65
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t2.patientID IS NULL"));
}

function getHealthQualInd16Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  $twelveMonths = monthDiff(-12, $endDate);

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT v.patientID
FROM v_labs v
WHERE v.labID IN ('178')
 AND v.siteCode = '$site'
 AND v.visitDate BETWEEN '$twelveMonths' AND '$endDate'"));
}

// Mental Health Evaluation

function getHealthQualInd17Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e
 LEFT JOIN " . $setupTableNames[4] . " t2 ON e.patientID = t2.patientID
WHERE e.siteCode = '$site'
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t2.patientID IS NULL"));
}

function getHealthQualInd17Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e, needsAssessment n
WHERE e.siteCode = '$site'
 AND e.patientID = n.patientID
 AND e.siteCode = n.siteCode
 AND e.visitDateYy = n.visitDateYy
 AND e.visitDateMm = n.visitDateMm
 AND e.visitDateDd = n.visitDateDd
 AND e.seqNum = n.seqNum
 AND (n.needsAssLimitUnderStatus > 0
 OR n.needsAssLimitUnderSvcs > 0
 OR n.needsAssLimitUnderDel > 0
 OR n.needsAssLimitUnderRef > 0
 OR n.needsAssLimitUnderUn > 0
 OR n.needsAssDenialStatus > 0
 OR n.needsAssDenialSvcs > 0
 OR n.needsAssDenialDel > 0
 OR n.needsAssDenialRef > 0
 OR n.needsAssDenialUn > 0
 OR n.needsAssOngRiskStatus > 0
 OR n.needsAssOngRiskSvcs > 0
 OR n.needsAssOngRiskDel > 0
 OR n.needsAssOngRiskRef > 0
 OR n.needsAssOngRiskUn > 0
 OR n.needsAssBarrHomeStatus > 0
 OR n.needsAssBarrHomeSvcs > 0
 OR n.needsAssBarrHomeDel > 0
 OR n.needsAssBarrHomeRef > 0
 OR n.needsAssBarrHomeUn > 0
 OR n.needsAssMentHealStatus > 0
 OR n.needsAssMentHealSvcs > 0
 OR n.needsAssMentHealDel > 0
 OR n.needsAssMentHealRef > 0
 OR n.needsAssMentHealUn > 0
 OR n.needsAssSevDeprStatus > 0
 OR n.needsAssSevDeprSvcs > 0
 OR n.needsAssSevDeprDel > 0
 OR n.needsAssSevDeprRef > 0
 OR n.needsAssSevDeprUn > 0
 OR n.needsAssPregStatus > 0
 OR n.needsAssPregSvcs > 0
 OR n.needsAssPregDel > 0
 OR n.needsAssPregRef > 0
 OR n.needsAssPregUn > 0
 OR n.needsAssDrugsStatus > 0
 OR n.needsAssDrugsSvcs > 0
 OR n.needsAssDrugsDel > 0
 OR n.needsAssDrugsRef > 0
 OR n.needsAssDrugsUn > 0
 OR n.needsAssViolStatus > 0
 OR n.needsAssViolSvcs > 0
 OR n.needsAssViolDel > 0
 OR n.needsAssViolRef > 0
 OR n.needsAssViolUn > 0
 OR n.needsAssFamPlanStatus > 0
 OR n.needsAssFamPlanSvcs > 0
 OR n.needsAssFamPlanDel > 0
 OR n.needsAssFamPlanRef > 0
 OR n.needsAssFamPlanUn > 0
 OR n.needsAssTransStatus > 0
 OR n.needsAssTransSvcs > 0
 OR n.needsAssTransDel > 0
 OR n.needsAssTransRef > 0
 OR n.needsAssTransUn > 0
 OR n.needsAssHousingStatus > 0
 OR n.needsAssHousingSvcs > 0
 OR n.needsAssHousingDel > 0
 OR n.needsAssHousingRef > 0
 OR n.needsAssHousingUn > 0
 OR n.needsAssNutrStatus > 0
 OR n.needsAssNutrSvcs > 0
 OR n.needsAssNutrDel > 0
 OR n.needsAssNutrRef > 0
 OR n.needsAssNutrUn > 0
 OR n.needsAssHygStatus > 0
 OR n.needsAssHygSvcs > 0
 OR n.needsAssHygDel > 0
 OR n.needsAssHygRef > 0
 OR n.needsAssHygUn > 0
 OR n.needsAssOtherStatus > 0
 OR n.needsAssOtherSvcs > 0
 OR n.needsAssOtherDel > 0
 OR n.needsAssOtherRef > 0
 OR n.needsAssOtherUn > 0
 OR LTRIM(RTRIM(n.needsAssOtherText)) != ''
 OR LTRIM(RTRIM(n.needsAssOtherSvcsText)) != '')"));
}*/

// nouvel indicateur : Retention a 12 mois 

function getHealthQualInd15Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  /*global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM (select p.patientId, min(p.visitDate) as date_visit from pepfarTable p
LEFT JOIN " . $setupTableNames[3] . " t1 ON p.patientID = t1.patientID
LEFT JOIN " . $setupTableNames[4] . " t2 ON p.patientID = t2.patientID
WHERE p.siteCode = '$site'
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND p.visitDate <= '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL GROUP BY 1
 HAVING datediff(day,date_visit, '$startDate') <=365 and datediff(day,date_visit, '$endDate') >=365
) l"));*/

global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM (select p.patientId, min(p.visitDate) as date_visit from pepfarTable p

WHERE p.siteCode = '$site'
 AND p.patientID not in(select distinct patientID from discEnrollment where sitecode = '$site' and (reasonDiscTransfer=1 or LOWER(discReasonOtherText) like '%transfert%') and ymdToDate(visitDateYy,visitDateMm,visitDateDd) <= '$endDate')
 AND p.patientID not in(select distinct patientID from patient where sitecode = '$site' and patientStatus is NULL OR patientStatus=0)
 AND p.visitDate <= '$endDate'
 GROUP BY 1
 HAVING datediff(day,date_visit, '$startDate') <=365 and datediff(day,date_visit, '$endDate') >=365
) l"));
}

function getHealthQualInd15Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
   /*global $setupTableNames;
   $threeMonths = monthDiff(-3, $endDate);

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM (select p.patientId, min(p.visitDate) as date_visit, max(p.visitDate) as visitMax from pepfarTable p 
LEFT JOIN " . $setupTableNames[3] . " t1 ON p.patientID = t1.patientID
 LEFT JOIN " . $setupTableNames[4] . " t2 ON p.patientID = t2.patientID , patientStatusTemp t
WHERE p.siteCode = '$site'
 AND p.patientID = t.patientID
 AND t.patientStatus = 6 
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND p.visitDate <= '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL GROUP BY 1
 HAVING datediff(day, date_visit,'$startDate') <=365 and datediff(day, date_visit, '$endDate') >=365
 and visitMax BETWEEN '$threeMonths' AND '$endDate'
 ) l"));*/
 
 global $setupTableNames;
   $threeMonths = monthDiff(-3, $endDate);

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM (select p.patientId, min(p.visitDate) as date_visit, max(p.visitDate) as visitMax from pepfarTable p 

WHERE p.siteCode = '$site'
 AND p.visitDate <= '$endDate'
 GROUP BY 1
 HAVING datediff(day, date_visit,'$startDate') <=365 and datediff(day, date_visit, '$endDate') >=365
 and visitMax BETWEEN '$threeMonths' AND '$endDate'
 ) l"));
}

// Pediatric Early HIV Detection

function getHealthQualInd19Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  /*return fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValid e, " . $setupTableNames[1] . " t1
 LEFT JOIN " . $setupTableNames[4] . " t2 ON t1.patientID = t2.patientID
WHERE e.patientID = t1.patientID
 AND t1.startDays >= 28
 AND t1.startDays < 2 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t2.patientID IS NULL"));*/
 
 return fetchFirstColumn(dbQuery("
SELECT DISTINCT patientID
FROM v_patients p
WHERE 
 p.siteCode = '$site'
 AND datediff(week,ymdtoDate(dobYy,dobMm,dobDd),'$endDate') between 4 and 52
 
 UNION
 
SELECT DISTINCT p.patientID
FROM patient p, a_labs v
WHERE 
 p.patientID=v.patientID
 AND v.siteCode = '$site'
 AND (v.labID in(1563,1564,100) or (v.labID in(1649,1650) and v.labID in(1652,1653)))
 AND ymdtoDate(resultDateYy, resultDateMm,resultDateDd) between '$startDate' and '$endDate'
 AND datediff(month,ymdtoDate(dobYy,dobMm,dobDd),'$endDate') between 12 and 17
 AND LOWER(LTRIM(RTRIM(v.result))) like '%pos%'"));
}

function getHealthQualInd19Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT v.patientID
FROM a_labs v, patient p
WHERE 
 v.patientID=p.patientID
 AND v.labID = '181'
 AND v.siteCode = '$site'
 AND datediff(week,ymdtoDate(dobYy,dobMm,dobDd),'$endDate') between 4 and 52
 AND v.visitDate <= '$endDate'"));
}



//nouvel indicateur : PCR négatif (denominateur) 
function getHealthQualInd6Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("

SELECT p.patientID, ymdtoDate(resultDateYy, resultDateMm,resultDateDd) as resultDate
FROM v_labs v, patient p
WHERE v.labID = '181'
 AND v.patientID = p.patientID

 AND timestampdiff(week,ymdToDate(dobYy,dobMm,dobDd),'$endDate') between 4 and 72
 AND v.siteCode = '$site'
 AND ymdtoDate(resultDateYy, resultDateMm,resultDateDd) BETWEEN '$startDate' AND '$endDate'"));
}


//nouvel indicateur : PCR négatif 
function getHealthQualInd6Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
  select v1.patientID, v.resultDate, v1.result FROM (SELECT patientID,max(ymdtoDate(resultDateYy, resultDateMm,resultDateDd)) as resultDate
FROM v_labs
WHERE labID = '181' AND siteCode = '$site' 
AND ymdtoDate(resultDateYy, resultDateMm,resultDateDd) BETWEEN '$startDate' AND '$endDate' group by 1) v, v_labs v1 
where v1.patientID=v.patientID 
AND v.resultDate=ymdtoDate(v1.resultDateYy, v1.resultDateMm,v1.resultDateDd) 
AND (v1.result='2' or LOWER(LTRIM(RTRIM(v1.result))) like '%neg%')"));
}

// nouvel indicateur : Proportion de patients VIH+ sous traitement ARV 
//ayant bénéficié d'une évaluation de leur Charge virale à 6 mois après 
//le début de leur traitement
/*function getHealthQualInd10Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientID
FROM (select v. patientID, min(v.visitDate), min(p.visitDate), result FROM pepfarTable p, v_labs v
WHERE p.patientID=v.patientID
AND labID in(103,1257)
AND v.siteCode = '$site'
AND (result is not null and result !='')
 AND v.visitDate <= '$endDate'
 GROUP BY 1
HAVING datediff(mm, min(p.visitDate),min(v.visitDate)) >= 6) l"));

}*/

/*le denominateur de indicateur 11 est le num de cet indicateur (reunion avec Nicasky)*/
function getHealthQualInd10Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientID
FROM (select p.patientID, min(p.visitDate), result, v.visitDate FROM pepfarTable p, v_labs v
WHERE p.patientID=v.patientID
AND p. siteCode = '$site'
AND labID in(103,1257)
AND (result is not null and result !='')
 AND v.visitDate between '$startDate' AND '$endDate'
GROUP BY 1
HAVING datediff(mm, min(p.visitDate),'$endDate') >= 18) l"));
}

// le den de cet indicateur est un sous-ensemble du den de indicateur 1
function getHealthQualInd10Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
global $setupTableNames;	
return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientID
FROM (select p.patientID, min(visitDate), max(visitDate) FROM pepfarTable p

WHERE  siteCode = '$site'
 AND visitDate <= '$endDate'
AND p.patientID not in(select distinct patientID from discEnrollment where sitecode = '$site' and (reasonDiscTransfer=1 or reasonDiscDeath=1 or LOWER(discReasonOtherText) like '%transfert%') and ymdToDate(visitDateYy,visitDateMm,visitDateDd) <= '$endDate')
 AND p.patientID not in(select distinct patientID from patient where sitecode = '$site' and patientStatus is NULL OR patientStatus=0)
 
GROUP BY 1
HAVING datediff(mm, min(visitDate),'$endDate') >= 18
AND max(visitDate) between '$startDate' AND '$endDate') l"));

}

/*function getHealthQualInd1Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientid 
FROM pepfarTable p
 LEFT JOIN " . $setupTableNames[3] . " t1 ON p.patientID = t1.patientID
 LEFT JOIN " . $setupTableNames[4] . " t2 ON p.patientID = t2.patientID
WHERE p.siteCode = '$site'
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND p.visitDate <= '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL"));
}*/

// nouvel indicateur : Proportion de patients VIH+ sous traitement ARV 
// depuis plus de 6 mois ayant une charge virale indétectable

// Num : Nombre de patients VH+ placés sous ARV depuis plus de 6 mois ayant 
// une charge virale indétectable (derniere charge virale) durant la période d’analyse

// Den : Nombre de patients places sous ARV depuis plus de 6 mois ayant 
// bénéficié d’une évaluation de la charge virale durant la période d’analyse.

function getHealthQualInd11Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientID
FROM (select v. patientID, min(p.visitDate), result, max(dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd)))) FROM pepfarTable p, v_labs v
WHERE p.patientID=v.patientID
AND labID in(103,1257)
AND v.siteCode = '$site'
AND (result like '%Ind%' or result like '%ind%' or (ISNUMERIC(result)=1 AND result < 1000))
AND (result is not null and result !='')
 
 GROUP BY 1
HAVING datediff(mm, min(p.visitDate),'$endDate') >= 6 
AND max(dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd)))) between '$startDate' AND '$endDate') l"));

}

function getHealthQualInd11Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
return fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientID
FROM (select p.patientID, min(p.visitDate), result, v.visitDate,max(dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd)))) FROM pepfarTable p, v_labs v
WHERE p.patientID=v.patientID
AND p. siteCode = '$site'
AND p.patientID not in(select distinct patientID from discEnrollment where sitecode = '$site' and (reasonDiscTransfer=1 or reasonDiscDeath=1 or LOWER(discReasonOtherText) like '%transfert%') and ymdToDate(visitDateYy,visitDateMm,visitDateDd) <= '$endDate')
 AND p.patientID not in(select distinct patientID from patient where location_id = '$site' and patientStatus is NULL OR patientStatus=0) 
AND labID in(103,1257)
AND (result is not null and result !='')
 AND v.visitDate between '$startDate' AND '$endDate'
GROUP BY 1
HAVING datediff(mm, min(p.visitDate),'$endDate') >= 6
AND datediff(mm,max(dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd)))),'$endDate') <= 12) l"));

}

function getHealthQualInd4Num ($repNum, $site, $intervalLength, $startDate, $endDate) {
  /*return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e, tbStatus t
WHERE e.patientID = t.patientID
 AND e.siteCode = t.siteCode
 AND e.visitDateDd = t.visitDateDd
 AND e.visitDateMm = t.visitDateMm
 AND e.visitDateYy = t.visitDateYy
 AND e.seqNum = t.seqNum
 AND e.siteCode = '$site'
 AND (t.currentProp = 1 OR t.propINH = 1)
 AND e.encounterType IN (1, 2, 16, 17)
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
UNION
SELECT STRAIGHT_JOIN DISTINCT e.patientID
FROM encValid e, prescriptions t
WHERE e.patientID = t.patientID
 AND e.siteCode = t.siteCode
 AND e.visitDateDd = t.visitDateDd
 AND e.visitDateMm = t.visitDateMm
 AND e.visitDateYy = t.visitDateYy
 AND e.seqNum = t.seqNum
 AND e.siteCode = '$site'
 AND e.encounterType IN (5, 18)
 AND t.drugID IN (18)
 AND t.forPepPmtct = 1
 AND t.dispensed = 1
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));*/
 
 return fetchFirstColumn(dbQuery("
SELECT distinct p.patientID
FROM pepfarTable p, prescriptions m
WHERE p.patientID = m.patientID
 AND p.siteCode = '$site'
 AND m.drugID=18
 AND m.forPepPmtct = 1
 AND ymdToDate(m.dispDateYy,m.dispDateMm,m.dispDateDd) BETWEEN '$startDate' AND '$endDate'"));
 
}

// Isoniazid Prophylaxis

function getHealthQualInd4Den ($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  //$tempTableNames = createTempTables ("#healthQualInd10Den", 9, array ("patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date, maxSeq tinyint unsigned", "patientID varchar(11), hivStat tinyint unsigned", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), maxDate date", "patientID varchar(11)"), "pat_idx::patientID");

  /* Don't count patients with active TB, regardless of treatment status */

  /* First, check for active diagnoses */
  //dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN e.patientID, MAX(e.visitDate) FROM encValid e, conditions c WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND (c.conditionID IN (20,21,41,208,397,405,409,423) AND ((c.conditionActive IN (1,5) AND e.encounterType IN (16,17)) OR (c.conditionActive IN (1,4,5) AND e.encounterType IN (1,2)) OR (c.conditionActive = 1 AND e.encounterType IN (24,25)))) AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");
  //dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT STRAIGHT_JOIN e.patientID, MAX(e.visitDate) FROM encValid e, conditions c WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND (c.conditionID IN (20,21,41,208,397,405,409,423) AND ((c.conditionActive IN (2,3,6,7) AND e.encounterType IN (1,2,16,17)) OR (c.conditionActive > 1 AND e.encounterType IN (24,25)))) AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");

  /* If marked 'resolved' after 'active', then remove from active list */
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[1] . " t1, " . $tempTableNames[2] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Pull most recent 'treatment completed' or 'asymptomatic' date */
  //dbQuery ("INSERT INTO " . $tempTableNames[3] . " SELECT STRAIGHT_JOIN e.patientID, CASE WHEN c.completeTreat = 1 THEN MAX(dbo.ymdToDate(c.completeTreatYy, c.completeTreatMm, c.completeTreatDd)) WHEN c.asymptomaticTb = 1 OR c.noTBsymptoms = 1 THEN e.visitDate END FROM tbStatus c, encValid e WHERE e.patientID = c.patientID AND e.siteCode = c.siteCode AND e.visitDateDd = c.visitDateDd AND e.visitDateMm = c.visitDateMm AND e.visitDateYy = c.visitDateYy AND e.seqNum = c.seqNum AND e.encounterType IN (1,2,16,17) AND ((c.completeTreat = 1 AND ISDATE(dbo.ymdToDate(c.completeTreatYy, c.completeTreatMm, c.completeTreatDd)) = 1 AND dbo.ymdToDate(c.completeTreatYy, c.completeTreatMm, c.completeTreatDd) <= '$endDate') OR c.asymptomaticTb = 1 OR c.noTBsymptoms = 1) AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");

  /* Check for negative lab tests */
  //dbQuery ("INSERT INTO " . $tempTableNames[6] . " SELECT STRAIGHT_JOIN e.patientID, MAX(CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END) FROM encValid e, labs l WHERE e.patientID = l.patientID AND e.siteCode = l.siteCode AND e.visitDateDd = l.visitDateDd AND e.visitDateMm = l.visitDateMm AND e.visitDateYy = l.visitDateYy AND e.seqNum = l.seqNum AND ((e.encounterType IN (6, 19) AND l.ordered = 1 AND l.labID = 130 AND ISNUMERIC(l.result) AND l.result < 5) OR (e.encounterType IN (6, 19) AND l.ordered = 1 AND l.labID IN (131, 169, 172) AND ISNUMERIC(l.result) AND l.result = 2) OR (LOWER(l.testNameFr) LIKE '%ppd qual%' AND LOWER(LTRIM(RTRIM(l.result))) LIKE '%non%' AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%ppd quant%' AND ISNUMERIC(l.result) AND l.result < 5 AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%tuberculos%' AND LOWER(LTRIM(RTRIM(l.result))) NOT LIKE '%pos%' AND LOWER(l.sampleType) = 'expectoration') OR ((LOWER(l.testNameFr) LIKE '%baar%' OR LOWER(l.testNameFr LIKE '%barr%')) AND LOWER(LTRIM(RTRIM(l.result))) LIKE '%nég%' AND LOWER(l.sampleType) IN ('liquide pleural', 'expectoration', 'sputum'))) AND e.siteCode = '$site' AND CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END <= '$endDate' GROUP BY 1");

  /* If treatment completed after diagnosis, then not active */
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[1] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* If negative lab result after diagnosis, then not active */
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[1] . " t1, " . $tempTableNames[6] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Next, check for positive lab tests */
  //dbQuery ("INSERT INTO " . $tempTableNames[7] . " SELECT STRAIGHT_JOIN e.patientID, MAX(CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END) FROM encValid e, labs l WHERE e.patientID = l.patientID AND e.siteCode = l.siteCode AND e.visitDateDd = l.visitDateDd AND e.visitDateMm = l.visitDateMm AND e.visitDateYy = l.visitDateYy AND e.seqNum = l.seqNum AND ((e.encounterType IN (6, 19) AND l.ordered = 1 AND ISNUMERIC(l.result) AND l.labID = 130 AND l.result >= 5) OR (e.encounterType IN (6, 19) AND l.ordered = 1 AND ISNUMERIC(l.result) AND l.labID IN (131, 169, 172) AND l.result = 1) OR (LOWER(l.testNameFr) LIKE '%ppd qual%' AND LOWER(LTRIM(RTRIM(l.result))) NOT LIKE '%non%' AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%ppd quant%' AND ISNUMERIC(l.result) AND l.result > 0 AND LOWER(l.sampleType) = 'in vivo') OR (LOWER(l.testNameFr) LIKE '%tuberculos%' AND LOWER(LTRIM(RTRIM(l.result))) LIKE '%pos%' AND LOWER(l.sampleType) = 'expectoration') OR ((LOWER(l.testNameFr) LIKE '%baar%' OR LOWER(l.testNameFr LIKE '%barr%')) AND LOWER(LTRIM(RTRIM(l.result))) NOT LIKE '%nég%' AND LOWER(l.sampleType) IN ('liquide pleural', 'expectoration', 'sputum'))) AND e.siteCode = '$site' AND CASE WHEN ISDATE(dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1 THEN dbo.ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) ELSE e.visitDate END <= '$endDate' GROUP BY 1");

  /* If treatment completed after positive lab test, then not active */
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[7] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* If negative lab result after positive lab result, then not active */
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[7] . " t1, " . $tempTableNames[6] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Finally, check for indications of treatment: */
  /*   A) 2 or more anti-TB meds dispensed on the same date */
  /*   B) 'Currently on treatment' selected on intake/f-u forms */
  //dbQuery ("INSERT INTO " . $tempTableNames[8] . " SELECT STRAIGHT_JOIN e.patientID, MAX(CASE WHEN ISDATE(dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01'))) = 1 THEN dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01')) ELSE e.visitDate END) FROM encValid e, prescriptions p, drugLookup d WHERE d.drugID = p.drugID AND d.drugGroup = 'Anti-TB' AND (p.forPepPmtct IS NULL OR p.forPepPmtct <> 1) AND e.patientID = p.patientID AND e.siteCode = p.siteCode AND e.visitDateDd = p.visitDateDd AND e.visitDateMm = p.visitDateMm AND e.visitDateYy = p.visitDateYy AND e.seqNum = p.seqNum AND e.siteCode = '$site' AND CASE WHEN ISDATE(dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01'))) = 1 THEN dbo.ymdToDate(p.dispDateYy, p.dispDateMm, IFNULL(p.dispDateDd, '01')) ELSE e.visitDate END <= '$endDate' GROUP BY 1 HAVING COUNT(DISTINCT p.drugID) >= 2");
  //dbQuery ("TRUNCATE TABLE " . $tempTableNames[2]);
  //dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT STRAIGHT_JOIN e.patientID, MAX(e.visitDate) FROM encValid e, tbStatus t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.encounterType IN (1, 2, 16, 17) AND t.currentTreat = 1 AND e.siteCode = '$site' AND e.visitDate <= '$endDate' GROUP BY 1");
  
  /* If treatment completed, then not active */
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[8] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");
  //dbQuery ("DELETE t1 FROM " . $tempTableNames[2] . " t1, " . $tempTableNames[3] . " t2 WHERE t1.patientID = t2.patientID AND t2.maxDate > t1.maxDate");

  /* Merge all active TB patients into one table */
  //dbQuery ("INSERT INTO " . $tempTableNames[9] . " SELECT patientID FROM " . $tempTableNames[1] . " UNION SELECT patientID FROM " . $tempTableNames[7] . " UNION SELECT patientID FROM " . $tempTableNames[8] . " UNION SELECT patientID FROM " . $tempTableNames[2]);

  /* Read HIV status from pediatric patient's most recent form */
  //dbQuery ("INSERT INTO " . $tempTableNames[4] . " SELECT e.patientID, MAX(e.visitDate), MAX(e.seqNum) FROM encValid e, vitals t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND e.encounterType IN (16, 17) AND t.pedCurrHiv >= 1 AND e.visitDate <= '$endDate' GROUP BY 1");
  //dbQuery ("INSERT INTO " . $tempTableNames[5] . " SELECT DISTINCT e.patientID, t.pedCurrHiv FROM encValid e, vitals t, " . $tempTableNames[4] . " t1 WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND e.encounterType IN (16, 17) AND e.patientID = t1.patientID AND e.visitDate = t1.maxDate AND e.seqNum = t1.maxSeq");

  // Adults
  /*$result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $tempTableNames[9] . " t2 ON t3.patientID = t2.patientID
WHERE e.patientID = t3.patientID
 AND t3.startDays >= 15 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL"));

  // Ped. infected >= 1 yr. old
  $result1 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, " . $tempTableNames[5] . " t4, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $tempTableNames[9] . " t2 ON t3.patientID = t2.patientID
 LEFT JOIN " . $setupTableNames[3] . " t5 ON t3.patientID = t5.patientID
WHERE e.patientID = t4.patientID
 AND t4.hivStat > 1
 AND e.patientID = t3.patientID
 AND t3.startDays >= " . DAYS_IN_YEAR . "
 AND t3.startDays < 15 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
 AND t5.patientID IS NULL"));

  // Ped. infected < 1 yr. old
  $result2 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_tbStatus t, encValid e, " . $tempTableNames[5] . " t4, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $setupTableNames[3] . " t2 ON t3.patientID = t2.patientID
WHERE e.patientID = t4.patientID
 AND t4.hivStat > 1
 AND e.patientID = t.patientID
 AND t.pedTbEvalRecentExp = 1
 AND t.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = t3.patientID
 AND t3.startDays >= 0
 AND t3.startDays < " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL"));

  // Ped. exposed
  $result3 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_tbStatus t, encValid e, " . $tempTableNames[5] . " t4, " . $setupTableNames[1] . " t3
 LEFT JOIN " . $setupTableNames[4] . " t1 ON t3.patientID = t1.patientID
 LEFT JOIN " . $tempTableNames[9] . " t2 ON t3.patientID = t2.patientID
 LEFT JOIN " . $setupTableNames[3] . " t5 ON t3.patientID = t5.patientID
WHERE e.patientID = t4.patientID
 AND t4.hivStat = 1
 AND e.patientID = t.patientID
 AND t.pedTbEvalRecentExp = 1
 AND t.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = t3.patientID
 AND t3.startDays >= 0
 AND t3.startDays < 15 * " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("registrations") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
 AND t5.patientID IS NULL"));

  dropTempTables ($tempTableNames);  
  return array_merge($result, $result1, $result2, $result3);*/
  
  return fetchFirstColumn(dbQuery("
SELECT distinct p.patientID, min(p.visitDate)
FROM pepfarTable p
WHERE p.siteCode = '$site'
 AND p.patientID not in (select distinct patientID from prescriptions 
 where drugID in(13,18,24,25,30) and (forPepPmtct is NULL or forPepPmtct=2)  
 AND ymdToDate(dispDateYy,dispDateMm,dispDateDd) BETWEEN '$startDate' AND '$endDate')
 AND p.patientID not in(select distinct patientID from discEnrollment where sitecode = '$site' and (reasonDiscTransfer=1 or reasonDiscDeath=1 or LOWER(discReasonOtherText) like '%transfert%') and ymdToDate(visitDateYy,visitDateMm,visitDateDd) <= '$endDate')
 AND p.patientID not in(select distinct patientID from patient where sitecode = '$site' and patientStatus is NULL OR patientStatus=0)
 GROUP BY 1
 HAVING min(p.visitDate) BETWEEN '$startDate' AND '$endDate'"));
}

?>
