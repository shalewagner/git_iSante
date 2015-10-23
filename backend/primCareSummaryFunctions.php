<?php
require_once ("backend.php");

function generatePrimCareSummary ($pid, $site, $lang) {
  $dateTime = $lang == "fr" ? date ("d/m/y H:i:s") : date ("m/d/y H:i:s");
  $siteName = getSiteName ($site, $lang);
  $title = $GLOBALS['primCareSummaryLabels'][$lang][0];
  $summaryFor = $GLOBALS['primCareSummaryLabels'][$lang][1];
  $nameAndId = getName ($pid) . " " . getID ($pid, "pc");
  $noteLine1 = $GLOBALS['primCareSummaryLabels'][$lang][2] . " " . substr ($dateTime, 0, 8) . " " . $GLOBALS['primCareSummaryLabels'][$lang][3];
  $noteLine2 = $GLOBALS['primCareSummaryLabels'][$lang][4] . " $siteName";
  $noteLine3 = $GLOBALS['primCareSummaryLabels'][$lang][5] . " $siteName";
  $demographicsTitle = $GLOBALS['primCareSummaryLabels'][$lang][6];
  $visitsTitle = $GLOBALS['primCareSummaryLabels'][$lang][7];
  $visitsSubTitle = $GLOBALS['primCareSummaryLabels'][$lang][8];
  $medsTitle = $GLOBALS['primCareSummaryLabels'][$lang][9];
  $bmiTitle = $GLOBALS['primCareSummaryLabels'][$lang][10];
  $obGynTitle = $GLOBALS['primCareSummaryLabels'][$lang][11];
  $pedImmTitle = $GLOBALS['primCareSummaryLabels'][$lang][12];
  $vitalsTitle = $GLOBALS['primCareSummaryLabels'][$lang][13];
  $labsTitle = $GLOBALS['primCareSummaryLabels'][$lang][14];
  $antHeCTitle = $GLOBALS['primCareSummaryLabels'][$lang][15];
  $antPeTitle = $GLOBALS['primCareSummaryLabels'][$lang][16];
  $consCaTitle = $GLOBALS['primCareSummaryLabels'][$lang][17];
  $physExTitle = $GLOBALS['primCareSummaryLabels'] [$lang][18];
  $diagTitle = $GLOBALS['primCareSummaryLabels'] [$lang][19]; 
  $condTitle = $GLOBALS['primCareSummaryLabels'][$lang][20];
  $tvisitsTitle = $GLOBALS['primCareSummaryLabels'][$lang][21];
  $pedVaccTitle	= $GLOBALS['primCareSummaryLabels'][$lang][22];
  $antObTitle = $GLOBALS['primCareSummaryLabels'][$lang][23];
  $pedAlimTitle = $GLOBALS['primCareSummaryLabels'][$lang][24];
  $pedVitaTitle = $GLOBALS['primCareSummaryLabels'][$lang][25];
  $pedPsychoDevTitle = $GLOBALS['primCareSummaryLabels'][$lang][26];
  $tpedAlimTitle = $GLOBALS['primCareSummaryLabels'][$lang][27];
  $obGynVaccTitle	= $GLOBALS['primCareSummaryLabels'][$lang][28];
  
  $queryArray = array(
       "demographics" => "select concat(fname, ' ', lname) as Nom, concat(addrDistrict,' ',addrSection) as 'Adresse, Commune',  addrTown as Localite, birthDistrict as 'Lieu de naissance',telephone, case when sex='1' then 'F' when sex='2' then 'M' end as sexe, maritalStatus as 'Statut marital', concat(dobDd,'/', dobMm,'/', dobYy) as 'Date de naissance', fnameMother as 'Prenom de la mere', occupation as 'Profession du patient', contact, addrContact as 'Adresse du contact', phoneContact as 'Telephone du contact' from patient where patientID =  '" . $pid . "'",
       "visits" => "select visitdate as 'Date de visite', frName as 'Type de visite' from encValidAll e, encTypeLookup l where e.encountertype = l.encountertype and e.patientid = '" . $pid . "' order by 1 desc limit 7",
       "relatives" => "SELECT visitdate as 'Date de visite', case when short_name = 'rel_asthme_mother' then 'asthme herite de la mere' when short_name = 'rel_asthme_father' then 'asthme herite du pere' when short_name = 'rel_asthme_bs' then 'asthme herite du frere ou de la soeur' when short_name = 'rel_cancer_mother' then 'cancer herite de la mere' when short_name = 'rel_cancer_father' then 'cancer herite du pere' when short_name = 'rel_cancer_bs' then 'cancer herite du frere ou de la soeur' when short_name = 'rel_cancer_specify' then concat('cancer du', ' ',value_text) when short_name = 'rel_cardiopathie_mother' then 'cardiopathie herite de la mere' when short_name = 'rel_cardiopathie_father' then 'cardiopathie herite du pere' when short_name = 'rel_cardiopathie_bs' then 'cardiopathie herite du frere ou de la soeur' when short_name = 'rel_diabete_mother' then 'diabete herite de la mere' when short_name = 'rel_diabete_father' then 'diabete herite du pere' when short_name = 'rel_diabete_bs' then 'diabete herite du frere ou de la soeur' when short_name = 'rel_epilepsie_mother' then 'epilepsie herite de la mere' when short_name = 'rel_epilepsie_father' then 'epilepsie herite du pere' when short_name = 'rel_epilepsie_bs' then 'epilepsie herite du frere ou de la soeur' when short_name = 'rel_hta_mother' then 'hta herite de la mere' when short_name = 'rel_hta_father' then 'hta herite du pere' when short_name = 'rel_hta_bs' then 'hta herite du frere ou de la soeur' when short_name = 'rel_pulmTBActive_mother' then 'tuberculose herite de la mere' when short_name = 'rel_pulmTBActive_father' then 'tuberculose herite du pere' when short_name = 'rel_pulmTBActive_bs' then 'tuberculose herite u frere ou de la soeur' when short_name = 'rel_mdrtb_mother' then 'mdr tb herite de la mere' when short_name = 'rel_mdrtb_father' then 'mdr tb herite du pere' when short_name = 'rel_mdrtb_bs' then 'mdr tb herite u frere ou de la soeur' else 'xxx' end as item, value_numeric as value FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '" . $pid . "' and short_name in ( 'rel_asthme_mother' , 'rel_asthme_father' , 'rel_asthme_bs' , 'rel_cancer_mother' , 'rel_cancer_father' , 'rel_cancer_bs' , 'rel_cancer_specify' , 'rel_cardiopathie_mother', 'rel_cardiopathie_father', 'rel_cardiopathie_bs' , 'rel_diabete_mother' , 'rel_diabete_father' , 'rel_diabete_bs' , 'rel_epilepsie_mother' , 'rel_epilepsie_father' , 'rel_epilepsie_bs' , 'rel_hta_mother' , 'rel_hta_father' , 'rel_hta_bs' , 'rel_pulmTBActive_mother', 'rel_pulmTBActive_father', 'rel_pulmTBActive_bs' , 'rel_mdrtb_mother' , 'rel_mdrtb_father' , 'rel_mdrtb_bs' ) order by 1 desc",
       "vitals" => "SELECT visitdate as 'Date de visite', CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') END as 'Pds(kg)', CASE WHEN vitalBpUnits = 1 THEN concat((REPLACE(LTRIM(RTRIM(vitalBp1)), ',', '.')) * 10,'/', (REPLACE(LTRIM(RTRIM(vitalBp2)), ',', '.')) * 10) else concat(vitalBp1,'/',vitalBp2) End as 'TA(mm de Hg)', concat(vitalHeight,'.',vitalHeightCm) as 'Taille(m)', CASE WHEN vitalTempUnits=2 THEN ROUND(((REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.')) * 5-(5*32))/9, 1) ELSE REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.') END as 'Temp(C)', vitalHr as 'Pouls(Bpm)', vitalRr as 'FR(/minute)' FROM  `a_vitals` WHERE patientID = '" . $pid . "' and encountertype = 27 and vitalWeight is not null order by 1 desc",
	   "obVitals" => "SELECT v.visitdate as 'Date de visite', CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') END as 'Pds(kg)', CASE WHEN vitalBpUnits = 1 THEN concat((REPLACE(LTRIM(RTRIM(vitalBp1)), ',', '.')) * 10,'/', (REPLACE(LTRIM(RTRIM(vitalBp2)), ',', '.')) * 10) else concat(vitalBp1,'/',vitalBp2) End as 'TA(mm de Hg)', concat(vitalHeight,'.',vitalHeightCm) as 'Taille(m)', CASE WHEN vitalTempUnits=2 THEN ROUND(((REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.')) * 5-(5*32))/9, 1) ELSE REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.') END as 'Temp(C)', vitalHr as 'Pouls(Bpm)', vitalRr as 'FR(/minute)', CASE 
	   WHEN short_name = 'vitalPb' then concat('PB : ', cast(value_numeric as UNSIGNED)) end as 'Pb (cm)' FROM  `a_vitals` v,obs o, concept c,encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and v.patientID=e.patientid and short_name = 'vitalPb' and v.encountertype = 24 and e.patientid = '" . $pid . "' and vitalWeight is not null  order by 1 desc
",
	   "pedVitals" => "SELECT v.visitdate as 'Date de visite', CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') END as 'Pds(kg)', CASE WHEN vitalBpUnits = 1 THEN concat((REPLACE(LTRIM(RTRIM(vitalBp1)), ',', '.')) * 10,'/', (REPLACE(LTRIM(RTRIM(vitalBp2)), ',', '.')) * 10) else concat(vitalBp1,'/',vitalBp2) End as 'TA(mm de Hg)', concat(vitalHeight,'.',vitalHeightCm) as 'Taille(m)', CASE WHEN vitalTempUnits=2 THEN ROUND(((REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.')) * 5-(5*32))/9, 1) ELSE REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.') END as 'Temp(C)', vitalHr as 'Pouls(Bpm)', vitalRr as 'FR(/minute)', CASE WHEN c.short_name = 'vitalPb' then cast(o.value_numeric as UNSIGNED) else 'xxx' end as 'PB (cm)', CASE WHEN d.short_name = 'vitalPc' then cast(p.value_numeric as UNSIGNED) else 'xxx' end as 'PC (cm)' FROM  `a_vitals` v,obs o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and v.patientID=e.patientid and c.short_name in ('vitalPb') and e.sitecode = p.location_id and e.encounter_id = p.encounter_id and p.concept_id = d.concept_id and d.short_name in ('vitalPc') and v.encountertype = 29 and e.patientid = '" . $pid . "' and vitalWeight is not null  order by 1 desc
",
	   "tvitals" => "SELECT visitdate as 'Date de visite', CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') END as 'Pds(kg)', CASE WHEN vitalBpUnits = 1 THEN concat((REPLACE(LTRIM(RTRIM(vitalBp1)), ',', '.')) * 10,'/', (REPLACE(LTRIM(RTRIM(vitalBp2)), ',', '.')) * 10) else concat(vitalBp1,'/',vitalBp2) End as 'TA(mm de Hg)', concat(vitalHeight,'.',vitalHeightCm) as 'Taille(m)', CASE WHEN vitalTempUnits=2 THEN ROUND(((REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.')) * 5-(5*32))/9, 1) ELSE REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.') END as 'Temp(C)', vitalHr as 'Pouls(Bpm)', vitalRr as 'FR(/minute)' FROM  `a_vitals` WHERE patientID = '" . $pid . "' and encountertype = 28 and vitalWeight is not null order by 1 desc limit 6",
       "tobVitals" => "SELECT v.visitdate as 'Date de visite', CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') END as 'Pds(kg)', CASE WHEN vitalBpUnits = 1 THEN concat((REPLACE(LTRIM(RTRIM(vitalBp1)), ',', '.')) * 10,'/', (REPLACE(LTRIM(RTRIM(vitalBp2)), ',', '.')) * 10) else concat(vitalBp1,'/',vitalBp2) End as 'TA(mm de Hg)', concat(vitalHeight,'.',vitalHeightCm) as 'Taille(m)', CASE WHEN vitalTempUnits=2 THEN ROUND(((REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.')) * 5-(5*32))/9, 1) ELSE REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.') END as 'Temp(C)', vitalHr as 'Pouls(Bpm)', vitalRr as 'FR(/minute)', CASE 
WHEN short_name = 'vitalPb' then concat('PB : ', cast(value_numeric as UNSIGNED)) end as 'Pb (cm)' FROM  `a_vitals` v,obs o, concept c,encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and v.patientID=e.patientid and short_name = 'vitalPb' and v.encountertype = 25 and e.patientid = '" . $pid . "' and vitalWeight is not null  order by 1 desc limit 6
",
	   "tpedVitals" => "SELECT v.visitdate as 'Date de visite', CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.453592, 1) ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') END as 'Pds(kg)', CASE WHEN vitalBpUnits = 1 THEN concat((REPLACE(LTRIM(RTRIM(vitalBp1)), ',', '.')) * 10,'/', (REPLACE(LTRIM(RTRIM(vitalBp2)), ',', '.')) * 10) else concat(vitalBp1,'/',vitalBp2) End as 'TA(mm de Hg)', concat(vitalHeight,'.',vitalHeightCm) as 'Taille(m)', CASE WHEN vitalTempUnits=2 THEN ROUND(((REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.')) * 5-(5*32))/9, 1) ELSE REPLACE(LTRIM(RTRIM(vitalTemp)), ',', '.') END as 'Temp(C)', vitalHr as 'Pouls(Bpm)', vitalRr as 'FR(/minute)', CASE WHEN c.short_name = 'vitalPb' then cast(o.value_numeric as UNSIGNED) else 'xxx' end as 'PB (cm)', CASE WHEN d.short_name = 'vitalPc' then cast(p.value_numeric as UNSIGNED) else 'xxx' end as 'PC (cm)' FROM  `a_vitals` v,obs o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and v.patientID=e.patientid and c.short_name in ('vitalPb') and e.sitecode = p.location_id and e.encounter_id = p.encounter_id and p.concept_id = d.concept_id and d.short_name in ('vitalPc') and v.encountertype = 31 and e.patientid = '" . $pid . "' and vitalWeight is not null  order by 1 desc limit 6
",
	   "labs" => " select v.testNameFr as 'Test', case when (encounterType in (6,19) and formVersion = 3) or resulttimestamp is not null then result else case when resultType = 1 and result != '' then case when result = '1' then resultLabelEn1 when result = '2' then resultLabelEn2 when result = '4' then resultLabelEn3 when result = '8' then resultLabelEn4 when result = '16' then resultLabelEn5 end when resultType = 2 and result != '' then concat(result,' ',resultLabelEn1) when resultType = 3 and result != '' then concat(result,' ',resultLabelEn1) when resultType = 4 and result != '' then case when result = '1' then resultLabelEn1 when result = '2' then resultLabelEn3 when result = '4' then resultLabelEn4 end when resultType = 5 and result IS NOT NULL then case when result2 = '1' then concat(result,' ',resultLabelEn1) when result2 = '2' then concat(result,' ',resultLabelEn2) end when resultType = 6 and result != '' then case when result = '1' then resultLabelEn1 when result = '2' then resultLabelEn5 end else '' end end as resultat, case when resultType = 2 and result2 IS NOT NULL then concat(result2,' ',resultLabelEn1) when resultType = 3 and result2 IS NOT NULL then concat(result2,' ', resultLabelEn2) when resultType = 4 and result2 IS NOT NULL then case when result2 != '1' and result2 != '2' and result2 != '4' then concat(result2,' ',resultLabelEn2) end when resultType = 6 and result2 IS NOT NULL then case when result2 = '2' then resultLabelEn3 when result2 = '3' then concat(result2,' ',resultLabelEn4) end else '' end as 'resultat 2', case when resultType = 3 and result3 IS NOT NULL then concat(result3,' ',resultLabelEn3) else '' end as 'resultat 3', substr(concat(v.minValue,'-', v.maxValue),1,20) as 'Intervalle de valeurs', v.units as Unites, resultAbnormal as 'Resultat Anormal', substr(resultRemarks,0,20) as 'Remarques sur les resultats', case when resultTimestamp is null and isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1 then concat(ymdToDate(resultDateYy,resultDateMm, resultDateDd),' (HND)') when resultTimestamp is null and isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) != 1 then concat(v.visitDate,' (DV/HND)') else date(resultTimestamp) end as 'Date Resultat' from a_labs v where ((result is not null and result <> '') or isdate(ymdToDate(resultDateYy,resultDateMm, resultDateDd)) = 1) and patientid = '" . $pid . "' order by 'Date Resultat' desc limit 25", 
       "meds" => "select visitDate as 'Date de visite', case when drugName = 'acetaminophen' then 'Acetaminophène' when drugName = 'aspirin' then 'Aspirine' when drugName = 'hydroxalum' then 'Hydroxyde d\'aluminium' when drugName = 'enalapril' then 'Enalapril' when drugName = 'hctz' then 'HCTZ' when drugName = 'amoxicilline' then 'Amoxicilline' when drugName = 'ciprofloxacin' then 'Ciprofloxacine' when drugName = 'clarithromycin' then 'Clarithromycin' when drugName = 'clindamycine' then 'Clindamycine' when drugName = 'cotrimoxazole' then case when forPepPmtct = 1 then 'Cotrimoxazole (TMS) Prophy' when forPepPmtct = 2 then 'Cotrimoxazole (TMS) Rx' else 'Cotrimoxazole (TMS)' end when drugName = 'erythromycin' then 'Erythromycin' when drugName = 'metromidazole' then 'Metromidazole' when drugName = 'doxycycline' then 'Doxycycline' when drugName = 'pnc' then 'PNC' when drugName = 'amphotericineb' then 'Amphotericine B' when drugName = 'fluconazole' then 'Fluconazole' when drugName = 'itraconazole' then 'Itraconazole' when drugName = 'ketaconazole' then 'Ketaconazole' when drugName = 'miconazole' then 'Miconazole' when drugName = 'nystatin' then 'Nystatin' when drugName = 'albendazol' then 'Albendazole' when drugName = 'chloroquine' then 'Chloroquine' when drugName = 'ivermectine' then 'Ivermectine' when drugName = 'primaquine' then 'Primaquine' when drugName = 'pyrimthamine' then 'Pyrimethamine' when drugName = 'quinine' then 'Quinine' when drugName = 'sulfadiazine' then 'Sulfadiazine' when drugName = 'ethambutol' then 'Ethambutol' when drugName = 'isoniazid' then case when forPepPmtct = 1 then 'Isoniazide (INH) Prophy' when forPepPmtct = 2 then 'Isoniazide (INH) Rx' else 'Isoniazide (INH)' end when drugName = 'pyrazinamide' then 'Pyrazinamide' when drugName = 'rifampicine' then 'Rifampicine' when drugName = 'streptomycine' then 'Streptomycine' when drugName = 'folicacid' then 'Acide Folique' when drugName = 'bcomplex' then 'B Complexe' when drugName = 'iron' then 'Fer' when drugName = 'multivitamin' then 'Multivitamin' when drugName = 'pyridoxine' then 'Pyridoxine' when drugName = 'proteinsupplement' then 'Supplément Protéinique' when drugName = 'vitaminc' then 'Vitamine C' when drugName = 'acyclovir' then 'Acyclovir' when drugName = 'loperamide' then 'Loperamide' when drugName = 'promethazine' then 'Promethazine' when drugName = 'calamine' then 'Calamine' when drugName = 'bromhexine' then 'Bromhexine' when drugName = 'benzyl' then 'Benzoate de benzyl' end as 'medicaments dispenses', case when (isdate(ymdToDate(dispDateYy,dispDateMm, dispDateDd)) = 1) then ymdToDate(dispDateYy,dispDateMm, dispDateDd) else '' end as 'date dispense' from a_medsDispensed where patientID ='".$pid."' and encounterType in(5,18) and drugName in ('acetaminophen','aspirin','hydroxalum','enalapril','hctz','amoxicilline','ciprofloxacin','clarithromycin','clindamycine','cotrimoxazole','erythromycin','metromidazole','doxycycline','pnc','amphotericineb','fluconazole','itraconazole','ketaconazole','miconazole','nystatin','albendazol','chloroquine','ivermectine','primaquine','pyrimthamine','quinine','sulfadiazine','ethambutol','isoniazid','pyrazinamide','rifampicine','streptomycine','folicacid','bcomplex','iron','multivitamin','pyridoxine','proteinsupplement','vitaminc','acyclovir','loperamide','promethazine','calamine','bromhexine','benzyl') order by 1 desc",
	   "obGyn" => "select * from prescriptions where patientid = '" . $pid . "' limit 10",
	   "antHeC" => "SELECT visitdate as 'Date de visite', case when short_name = 'rel_asthme_mother' then 'asthme herite de la mere' when short_name = 'rel_asthme_father' then 'asthme herite du pere' when short_name = 'rel_asthme_bs' then 'asthme herite du frere ou de la soeur' when short_name = 'rel_cancer_mother' then 'cancer herite de la mere' when short_name = 'rel_cancer_father' then 'cancer herite du pere' when short_name = 'rel_cancer_bs' then 'cancer herite du frere ou de la soeur' when short_name = 'rel_cancer_specify' then concat('cancer', ' ',value_text)when short_name = 'rel_cardiopathie_mother' then 'cardiopathie herite de la mere' when short_name = 'rel_cardiopathie_father' then 'cardiopathie herite du pere' when short_name = 'rel_cardiopathie_bs' then 'cardiopathie herite du frere ou de la soeur' when short_name = 'rel_diabete_mother' then 'diabete herite de la mere' when short_name = 'rel_diabete_father'   then 'diabete herite du pere' when short_name = 'rel_diabete_bs' then 'diabete herite du frere ou de la soeur' when short_name = 'rel_epilepsie_mother'  then 'epilepsie herite de la mere' when short_name = 'rel_epilepsie_father'  then 'epilepsie herite du pere' when short_name = 'rel_epilepsie_bs'   then 'epilepsie herite du frere ou de la soeur' when short_name = 'rel_hta_mother' then 'hta herite de la mere' when short_name = 'rel_hta_father' then 'hta herite du pere' when short_name = 'rel_hta_bs'  then 'hta herite du frere ou de la soeur' when short_name = 'rel_pulmTBActive_mother'  then 'tuberculose herite de la mere' when short_name = 'rel_pulmTBActive_father'  then 'tuberculose herite du pere' when short_name = 'rel_pulmTBActive_bs' then 'tuberculose herite du frere ou de la soeur' when short_name = 'rel_mdrtb_mother' then 'mdr tb contact avec la mere' when short_name = 'rel_mdrtb_father' then 'mdr tb contact avec le pere' when short_name = 'rel_mdrtb_bs' then 'mdr tb contact avec le frere ou la soeur' when short_name = 'other_relative' then value_text else 'xxx' end as antecedents FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType in (24,27,29) and short_name in('rel_asthme_mother','rel_asthme_father','rel_asthme_bs','rel_cancer_mother','rel_cancer_father','rel_cancer_bs','rel_cancer_specify','rel_cardiopathie_mother','rel_cardiopathie_father','rel_cardiopathie_bs','rel_diabete_mother','rel_diabete_father','rel_diabete_bs','rel_epilepsie_mother','rel_epilepsie_father','rel_epilepsie_bs','rel_hta_mother','rel_hta_father','rel_hta_bs','rel_pulmTBActive_mother','rel_pulmTBActive_father','rel_pulmTBActive_bs','rel_mdrtb_mother','rel_mdrtb_father','rel_mdrtb_bs','other_relative') and e.patientid = '".$pid."' order by 1 desc",
	   "antPe" => "SELECT visitdate as 'Date de visite', case when short_name = 'sym_cva' then 'accident cerebro-vasculaire' when short_name = 'sym_allergy_specify' then concat('allergies', ' ',value_text) when short_name = 'sym_asthma' then 'asthme' when short_name = 'sym_cancer_specify' then concat('cancer', ' ',value_text) when short_name = 'sym_cardiopathy' then 'cardiopathie' when short_name = 'chirurgie_specify' then concat('chirurgie', ' ', value_text) when short_name = 'sym_diabetes' then 'diabetes' when short_name = 'sym_epilepse' then 'epilepsie' when short_name = 'sym_pregnancy' then 'grossesse' when short_name = 'hemoglobinopathie_specify'  then concat('hemoglobinopathie', ' ', value_text) when short_name = 'sym_hta' then 'hta' when short_name = 'hypercholesterolemia' then 'hypercholesterolemie' when short_name = 'sym_ist_specify' then concat('ist', ' ', value_text) when short_name = 'sym_malariaGT' then 'malaria >=1 mois' when short_name = 'sym_malariaLT' then 'malaria <1 mois' when short_name = 'malnutrition' then 'malnutrition/perte de poids' when short_name = 'sym_tuberculosis' then 'tuberculose' when short_name = 'sym_mdrtb' then 'mdr tb' when short_name = 'psychiatricDisorders_specify' then concat('troubles', ' ', value_text) when short_name = 'sym_alcohol' then 'alcool' when short_name = 'drugs_specify' then value_text when short_name = 'sym_tabacco' then 'tabac' when short_name = 'personalHistoryOther1_specify' then concat('autres :', ' ', value_text) when short_name = 'sym_actualMeds' then concat('medicaments actuels:', ' ', value_text) when short_name = 'symRemarks' then concat('remarques :', ' ', value_text) else 'xxx' end as antecedents FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 27 and short_name in('sym_cva','sym_allergy_specify','sym_asthma','sym_cancer_specify','sym_cardiopathy','chirurgie_specify','sym_diabetes','sym_epilepse','sym_pregnancy','hemoglobinopathie_specify','sym_hta','hypercholesterolemia','sym_ist_specify','sym_malariaGT','sym_malariaLT','malnutrition','sym_tuberculosis','sym_mdrtb','psychiatricDisorders_specify','sym_alcohol','drugs_specify','sym_tabacco','personalHistoryOther1_specify','sym_actualMeds','symRemarks') and e.patientid = '".$pid."' order by 1 desc",
	   "obAntPe" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'sym_cva'      then 'accident cerebro-vasculaire' 
when short_Name = 'sym_allergy_specify'   then concat('allergies', ' ',value_text)
when short_name = 'sym_asthma'      then 'asthme' 
when short_name = 'sym_cancer_specify'    then concat('cancer', ' ',value_text)
when short_name = 'sym_cardiopathy'    then 'cardiopathie'
when short_name = 'chirurgie_specify'    then concat('chirurgie', ' ', value_text)
when short_name = 'sym_diabetes'     then 'diabetes'
when short_name = 'sym_epilepse'     then 'epilepsie'
when short_name = 'hemoglobinopathie_specify'  then concat('hemoglobinopathie', ' ', value_text)
when short_name = 'sym_hta'      then 'hta'
when short_name = 'hypercholesterolemia'   then 'hypercholesterolemie'
when short_name = 'sym_ist_specify'    then concat('ist', ' ', value_text)
when short_name = 'sym_malariaGT'     then 'malaria >=1 mois'
when short_name = 'sym_malariaLT'     then 'malaria <1 mois'
when short_name = 'malnutrition'     then 'malnutrition/perte de poids'
when short_name = 'sym_tuberculosis'    then 'tuberculose'
when short_name = 'sym_mdrtb'      then 'mdr tb'
when short_name = 'psychiatricDisorders_specify' then concat('troubles', ' ', value_text)
when short_name = 'sym_alcohol'     then 'alcool'
when short_name = 'drugs_specify'    then value_text
when short_name = 'sym_tabacco'     then 'tabac'
when short_name = 'personalHistoryOther1_specify' then concat('autres :', ' ', value_text)
when short_name = 'tbTestVIH'	and value_numeric = 1 then 'Statut VIH, non teste'
when short_name = 'tbTestVIH'	and value_numeric = 2 then 'Statut VIH, negatif'
when short_name = 'tbTestVIH'	and value_numeric = 4 then 'Statut VIH, positif'
when short_name = 'tbTestvihDate'	then concat('Date test VIH : ', cast(value_datetime as date))
when short_name = 'tbIoYN' and value_numeric = 1 then 'Positif, enrole en soins'
when short_name = 'tbIoYN' and value_numeric = 2 then 'Positif, non enrole en soins'
when short_name = 'tbCd4Result'	then concat('CD4 : ', cast(value_numeric as UNSIGNED))
when short_name = 'tbCd4ResultDate'	then concat('Date CD4 : ', cast(value_datetime as date))
when short_name = 'tbCd4ResultDateUnknown'	then 'Date CD4 : Inconnue'
when short_name = 'tbArvYN'	and value_numeric = 1 then 'ARV : oui'
when short_name = 'tbArvYN'	and value_numeric = 2 then 'ARV : non'
when short_name = 'tbArvMeds'	then concat('medicaments ARV : ', value_text)
when short_name = 'tbArvDate'	then concat('ARV, date debut : ', cast(value_datetime as date))
when short_name = 'propCotrimoxazole'	then 'Prophylaxie : Cotrimoxazole'
when short_name = 'propAzythromycine'	then 'Prophylaxie : Azythromycine'
when short_name = 'propFluconazole'	then 'Prophylaxie : Fluconazole'
when short_name = 'propINHprim'	then 'Prophylaxie : INH primaire'
when short_name = 'propINHsec'	then 'Prophylaxie : INH secondaire'
when short_name = 'sym_actualMeds'    then concat('medicaments actuels:', ' ', value_text)
when short_name = 'symRemarks'     then concat('remarques :', ' ', value_text)
when short_name = 'personalHistoryOther2_specify'	then concat('Autres : ',value_text) else 'xxx'
end as antecedents
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 24 and short_name in('sym_cva','sym_allergy_specify','sym_asthma','sym_cancer_specify','sym_cardiopathy','chirurgie_specify','sym_diabetes','sym_epilepse','sym_pregnancy','hemoglobinopathie_specify','sym_hta','hypercholesterolemia','sym_ist_specify','sym_malariaGT','sym_malariaLT','malnutrition','sym_tuberculosis','sym_mdrtb','psychiatricDisorders_specify','sym_alcohol','drugs_specify','sym_tabacco','personalHistoryOther1_specify','tbTestVIH','tbTestvihDate','tbIoYN','tbCd4Result','tbCd4ResultDate','tbCd4ResultDateUnknown','tbArvYN','tbArvMeds','tbArvDate','propCotrimoxazole','propAzythromycine','propFluconazole','propINHprim','propINHsec','sym_actualMeds','symRemarks','personalHistoryOther2_specify') and e.patientid = '" . $pid . "' order by 1 desc
",
	   "pedAntPe" => "SELECT visitdate as 'Date de visite', case 
when c.short_name = 'sym_allergy_specify'   then concat('allergies', ' ', o.value_text)
when c.short_name = 'sym_asthma'      then 'asthme' 
when c.short_name = 'sym_cardiopathy'    then 'cardiopathie'
when c.short_name = 'chirurgie_specify'    then concat('chirurgie', ' ', o.value_text)
when c.short_name = 'sym_diabetes'     then 'diabetes'
when c.short_name = 'diphterie'		then 'diphterie'
when c.short_name = 'sym_epilepse'     then 'epilepsie'
when c.short_name = 'hemoglobinopathie_specify'  then concat('hemoglobinopathie', ' ', o.value_text)
when c.short_name = 'sym_hta'      then 'hta'
when c.short_name = 'sym_ist_specify'    then concat('ist', ' ', o.value_text)
when c.short_name = 'sym_malariaGT'     then 'malaria >=1 mois'
when c.short_name = 'sym_malariaLT'     then 'malaria <1 mois'
when c.short_name = 'malf_cong_specify'	then concat('malformations congenitales : ',o.value_text)
when c.short_name = 'malnutrition'     then 'malnutrition/perte de poids'
when c.short_name = 'premat'		then 'prematurite'
when c.short_name = 'phRaa'		then 'RAA'
when c.short_name = 'phRougeole'	then 'Rougeole'
when c.short_name = 'sym_tuberculosis'    then 'tuberculose'
when c.short_name = 'sym_mdrtb'      then 'mdr tb'
when c.short_name = 'personalHistoryOther1_specify' then concat('autres :', ' ', o.value_text)
when c.short_name = 'personalHistoryOther2_specify' then concat('autres :', ' ', o.value_text)
when c.short_name = 'phVaricelle'		then 'varicelle'
when c.short_name = 'sym_actualMeds'    then concat('medicaments actuels:', ' ', o.value_text)
end as antecedents
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 29 and c.short_name in('sym_allergy_specify','sym_asthma','sym_cardiopathy','chirurgie_specify','sym_diabetes','diphterie','sym_epilepse','hemoglobinopathie_specify','sym_hta','sym_ist_specify','sym_malariaGT','sym_malariaLT','malf_cong_specify','malnutrition','premat','phRaa','phRougeole','sym_tuberculosis','sym_mdrtb','personalHistoryOther1_specify','personalHistoryOther2_specify','phVaricelle','sym_actualMeds')  and e.patientid = '".$pid."'
union select visitdate, case
when  o.value_numeric = 1  then concat('Hospitalisation anterieure , oui : ', p.value_text) else 'xxx'
end as item
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.encounter_id = p.encounter_id and e.sitecode = p.location_id and p.concept_id = d.concept_id and encounterType = 29 and c.short_name in('hosp') and d.short_name in ('hospSpe') and e.patientid = '".$pid."' 
union select visitdate, case
when  value_numeric = 2   then 'Hospitalisation anterieure : non'
when  value_numeric = 4	then 'Hospitalisation anterieure : Inconnu' else 'xxx'
end as antecedents 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 29 and short_name in('hosp') and e.patientid = '".$pid."' order by 1 desc
",
	   
	   "antOb" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'mensAge'      then concat('Age des menarches : ', cast(value_numeric as UNSIGNED)) 
when short_name = 'beginSex'     then concat('Age des premieres relations sexuelles : ', cast(value_numeric as UNSIGNED))
when short_name = 'numberCumPartnerSex'     then concat('Nombre cumule de partenaires sexuels : ', value_text)
when short_name = 'mensDuration'     then concat('Duree des regles : ', value_text)
when short_name = 'mensCycle'     then concat('Duree des cycles : ', value_text)
when short_name = 'pregnantDDRDt'     then concat('DDR : ', cast(value_datetime as date))
when short_name = 'DPADt'     then concat('DPA : ', cast(value_datetime as date))
when short_name = 'DPADt'     then concat('DPA : ', cast(value_datetime as date))
when short_name = 'dysmenhoree' and value_numeric =1 then 'Dysmenhoree : oui'
when short_name = 'dysmenhoree' and value_numeric =2 then 'Dysmenhoree : non'
when short_name = 'yesDysmenhoree' and value_numeric = 1 then 'Dysmenhoree : Primaire'
when short_name = 'yesDysmenhoree' and value_numeric = 2 then 'Dysmenhoree : Secondaire'
when short_name = 'infertilite' and value_numeric = 1 then 'Infertilite : Oui'
when short_name = 'infertilite' and value_numeric = 2 then 'Infertilite : Non'
when short_name = 'liveChilds'  then concat('EV : ',value_text) 
when short_name = 'grossesseGemellaire' and value_numeric =1 then 'Grossesse multiple'
when short_name = 'grossesseGemellaire' and value_numeric =2 then 'Pre eclampsie severe'
when short_name = 'grossesseGemellaire' and value_numeric =4 then 'Hemorragie de la grossesse/post partum'
when short_name = 'grossesseDt1'   then concat('Grossesse 1 : ', cast(value_datetime as date))
when short_name = 'grossesseSuivi1' and value_numeric = 1 then 'Grossesse 1, Suivi : oui'
when short_name = 'grossesseSuivi1' and value_numeric = 2 then 'Grossesse 1, Suivi : non'
when short_name = 'accouchment1' and value_numeric = 1 then 'Grossesse 1, Accouchement : Domicile'
when short_name = 'accouchment1' and value_numeric = 2 then 'Grossesse 1, Accouchement : Institution'
when short_name = 'naissanceVivante1' and value_numeric = 1 then 'Grossesse 1, Naissance vivante : oui'
when short_name = 'naissanceVivante1' and value_numeric = 2 then 'Grossesse 1, Naissance vivante : non'
when short_name = 'grossesseDt2'    then concat('Grossesse 2 : ', cast(value_datetime as date))
when short_name = 'grossesseSuivi2' and value_numeric = 1 then 'Grossesse 2, Suivi : oui'
when short_name = 'grossesseSuivi2' and value_numeric = 2 then 'Grossesse 2, Suivi : non'
when short_name = 'accouchment2' and value_numeric = 1 then 'Grossesse 2, Accouchement : Domicile'
when short_name = 'accouchment2' and value_numeric = 2 then 'Grossesse 2, Accouchement : Institution'
when short_name = 'naissanceVivante2' and value_numeric = 1 then 'Grossesse 2, Naissance vivante : oui'
when short_name = 'naissanceVivante2' and value_numeric = 2 then 'Grossesse 2, Naissance vivante : non'
when short_name = 'grossesseDt3'  then concat('Grossesse 3 : ', cast(value_datetime as date))
when short_name = 'grossesseSuivi3' and value_numeric = 1 then 'Grossesse 3, Suivi : oui'
when short_name = 'grossesseSuivi3' and value_numeric = 2 then 'Grossesse 3, Suivi : non'
when short_name = 'accouchment3' and value_numeric = 1 then 'Grossesse 3, Accouchement : Domicile'
when short_name = 'accouchment3' and value_numeric = 2 then 'Grossesse 3, Accouchement : Institution'
when short_name = 'naissanceVivante3' and value_numeric = 1 then 'Grossesse 3, Naissance vivante : oui'
when short_name = 'naissanceVivante3' and value_numeric = 2 then 'Grossesse 3, Naissance vivante : non'
when short_name = 'atcd' and value_numeric = 1 then ' ATCD de cesarienne : oui'
when short_name = 'atcd' and value_numeric = 2 then ' ATCD de cesarienne : non'
when short_name = 'indication1'  then concat('indication 1: ',value_text)
when short_name = 'date1'   then concat('indication 1: ', cast(value_datetime as date))
when short_name = 'indication2'  then concat('indication 2: ',value_text)
when short_name = 'date2'   then concat('indication 2: ', cast(value_datetime as date))
when short_name = 'cancerColon'   then concat('Date du dernier depistage du cancer du col : ', cast(value_datetime as date))
when short_name = 'methodUti'  then concat('Methode de depistage de cancer du col utilisee: ',value_text)
when short_name = 'cancerColonStatus' and value_numeric=1 then 'Resultat du depistage du cancer du col : normal'
when short_name = 'cancerColonStatus' and value_numeric=2 then 'Resultat du depistage du cancer du col : anormal'
when short_name = 'cancerColonStatus' and value_numeric=3 then 'Resultat du depistage du cancer du col : jamais realise'
when short_name = 'palpationMensuelle' and value_numeric=1 then 'Palpation mensuelle des Seins : oui'
when short_name = 'palpationMensuelle' and value_numeric=2 then 'Palpation mensuelle des Seins : non'
when short_name = 'mammograph' and value_numeric=1 then 'Mammographie (age>35 ans) : oui'
when short_name = 'mammograph' and value_numeric=2 then 'Mammographie (age>35 ans) : non'
when short_name = 'mammographNormal' and value_numeric=1 then 'Mammographie : normale'
when short_name = 'mammographNormal' and value_numeric=2 then 'Mammographie : anormale'
when short_name = 'famPlanMethod'  then concat('Methode de planification familiale : ',value_text)
when short_name = 'menopause' and value_numeric = 1 then 'Menopause : oui'
when short_name = 'menopause' and value_numeric = 2 then 'Menopause : non'
when short_name = 'menopauseAge'  then concat('Menopause : ',value_text) else 'xxx'
end as antecedents
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 24 and short_name in('mensAge','beginSex','numberCumPartnerSex','mensDuration','mensCycle','pregnantDDRDt','DPADt','dysmenhoree', 'yesDysmenhoree','infertilite','liveChilds','grossesseGemellaire','grossesseDt1','grossesseSuivi1','accouchment1','naissanceVivante1','grossesseDt2','grossesseSuivi2','accouchment2','naissanceVivante2','grossesseDt3','grossesseSuivi3','accouchment3','naissanceVivante3','atcd','indication1','date1','indication2','date2','cancerColon','methodUti','cancerColonStatus','palpationMensuelle','mammograph','mammographNormal','famPlanMethod','menopause','menopauseAge') and e.patientid = '" . $pid . "' 
union SELECT visitdate as 'Date de visite', case
when famPlan =1  then 'Panification familiale : oui '   
when famPlan =2  then 'Panification familiale : non '  else 'xxx'
end as plan
FROM a_vitals where patientID='" . $pid . "' and encounterType = 24 and famPlan in(1,2)
union SELECT visitdate as 'Date de visite', case
when gravida is not null then concat('G : ',gravida)  else 'xxx'
end as g
FROM a_vitals where patientID='" . $pid . "' and encounterType = 24 and gravida is not null 
union SELECT visitdate as 'Date de visite', case
when para is not null then concat('P : ',para)  else 'xxx'
end as p
FROM a_vitals where patientID='" . $pid . "' and encounterType = 24 and para is not null
union SELECT visitdate as 'Date de visite', case
when aborta is not null then concat('A : ',aborta)  else 'xxx'
end as a
FROM a_vitals where patientID='" . $pid . "' and encounterType = 24 and aborta is not null order by 1 desc",
	   "obVacc"	=> "SELECT visitdate as 'Date de visite', case 
when short_name = 'hepbDtD1'      then concat('Hepatite B : ', cast(value_datetime as date)) 
when short_name = 'hepbDtD2'     then concat('Hepatite B : ', cast(value_datetime as date))
when short_name = 'hepbDtD3'     then concat('Hepatite B : ', cast(value_datetime as date))
when short_name = 'hepbDtUnknown'     then 'Hepatite B : Recu, date inconnue'
when short_name = 'hepbNever'     then 'Hepatite B : Jamais recu'
when short_name = 'tetanosDtD1'      then concat('Tetanos Texoide : ', cast(value_datetime as date)) 
when short_name = 'tetanosDtD2'     then concat('Tetanos Texoide : ', cast(value_datetime as date))
when short_name = 'tetanosDtD3'     then concat('Tetanos Texoide : ', cast(value_datetime as date))
when short_name = 'tetanosDtUnknown'     then 'Tetanos Texoide : Recu, date inconnue'
when short_name = 'tetanosNever'     then 'Tetanos Texoide : Jamais recu'
when short_name = 'pnuemovaxDtD1'      then concat('Pneumovax : ', cast(value_datetime as date)) 
when short_name = 'pnuemovaxDtD2'     then concat('Pneumovax : ', cast(value_datetime as date))
when short_name = 'pnuemovaxDtD3'     then concat('Pneumovax : ', cast(value_datetime as date))
when short_name = 'pnuemovaxDtUnknown'     then 'Pneumovax : Recu, date inconnue'
when short_name = 'pnuemovaxNever'     then 'Pneumovax : Jamais recu'
when short_name = 'pneumocoqueDtD1'		 then concat('Pneumocoque : ', cast(value_datetime as date)) 
when short_name = 'pneumocoqueDtD2'		 then concat('Pneumocoque : ', cast(value_datetime as date)) 
when short_name = 'pneumocoqueDtD3'		 then concat('Pneumocoque : ', cast(value_datetime as date)) 
when short_name = 'pneumocoqueDtUnknown'	 then 'Pneumocoque : Recu, date inconnue' 
when short_name = 'pneumocoqueNever'     then 'Pneumocoque : Jamais recu'
when short_name = 'hepatiteADtD1'		 then concat('Hepatite A : ', cast(value_datetime as date)) 
when short_name = 'hepatiteADtD2'		 then concat('Hepatite A : ', cast(value_datetime as date)) 
when short_name = 'hepatiteADtUnknown'	 then 'Hepatite A : Recu, date inconnue' 
when short_name = 'hepatiteANever'     then 'Hepatite A : Jamais recu'
when short_name = 'otherVaccinDtD1'      then concat('Autre : ', cast(value_datetime as date)) 
when short_name = 'otherVaccinDtD2'     then concat('Autre : ', cast(value_datetime as date))
when short_name = 'otherVaccinDtD3'     then concat('Autre : ', cast(value_datetime as date))
when short_name = 'otherVaccinDtUnknown'     then 'Autre : Recu, date inconnue'
when short_name = 'otherVaccinNever'     then 'Autre : Jamais recu' else 'xxx'
/*otherVaccinText*/
end as vaccins 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 24 and short_name in('hepbDtD1','hepbDtD2','hepbDtD3','hepbDtUnknown','hepbNever','tetanosDtD1','tetanosDtD2','tetanosDtD3', 'tetanosDtUnknown','tetanosNever','pnuemovaxDtD1','pnuemovaxDtD2','pnuemovaxDtD3','pnuemovaxDtUnknown','pnuemovaxNever','pneumocoqueDtD1','pneumocoqueDtD2','pneumocoqueDtD3','pneumocoqueDtUnknown','pneumocoqueNever','hepatiteADtD1','hepatiteADtD2','hepatiteADtUnknown','hepatiteANever','otherVaccinDtD1','otherVaccinDtD2','otherVaccinDtD3','otherVaccinDtUnknown','otherVaccinNever') and e.patientid = '".$pid."' order by 1 desc
",
	   "pedAlim" => "SELECT visitdate as 'Date de visite', case 
when c.short_name = 'prepPour'		and o.value_numeric = 2 then 'Preparation pour nourissons(LM) : non'
when c.short_name = 'foodExclusive'  and o.value_numeric = 2 then 'Allaitement maternel exclusif : non'
when c.short_name = 'foodMix'		and o.value_numeric = 2 then 'Alimentation mixte : non' 
when c.short_name = 'foodDiverse'	and o.value_numeric = 2 then 'Diversification alimentaire : non' else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 29 and c.short_name in('foodExclusive','prepPour','foodMix','foodDiverse') and value_numeric = 2 and e.patientid = '".$pid."' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'foodMix'	and o.value_numeric = 1 then 'Alimentation mixte : oui'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 29 and c.short_name = 'foodMix' and value_numeric = 1 and e.patientid = '".$pid."' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'prepPour' and o.value_numeric = 1  then concat('Preparation pour nourissons(LM) , oui : ', p.value_text) else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 29 and c.short_name = 'prepPour' and d.short_name = 'milk_specify' and e.patientid = '".$pid."'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'foodExclusive'	 and o.value_numeric = 1 then concat('Allaitement maternel exclusif , oui : ', cast(p.value_numeric as UNSIGNED)) else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 29 and c.short_name = 'foodExclusive' and d.short_name = 'maternalSpec' and e.patientid = '".$pid."' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'foodDiverse' and o.value_numeric = 1  then concat('Diversification alimentaire, age en mois : ',cast(p.value_numeric as UNSIGNED)) else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 29 and c.short_name ='foodDiverse' and d.short_name = 'ageMonths' and e.patientid = '".$pid."' order by 1 desc
",
	   "tpedAlim" => "SELECT visitdate as 'Date de visite', case 
when c.short_name = 'prepPour'		and o.value_numeric = 2 then 'Preparation pour nourissons(LM) : non'
when c.short_name = 'foodExclusive'  and o.value_numeric = 2 then 'Allaitement maternel exclusif : non'
when c.short_name = 'foodMix'		and o.value_numeric = 2 then 'Alimentation mixte : non' 
when c.short_name = 'foodDiverse'	and o.value_numeric = 2 then 'Diversification alimentaire : non' else 'xxx'
end as 'alimentation actuelle' 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 31 and c.short_name in('foodExclusive','prepPour','foodMix','foodDiverse') and value_numeric = 2 and e.patientid = '".$pid."' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'foodMix'	and o.value_numeric = 1 then 'Alimentation mixte : oui'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 31 and c.short_name = 'foodMix' and value_numeric = 1 and e.patientid = '".$pid."' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'prepPour' and o.value_numeric = 1  then concat('Preparation pour nourissons(LM) , oui : ', p.value_text) else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'prepPour' and d.short_name = 'milk_specify' and e.patientid = '".$pid."'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'foodExclusive'	 and o.value_numeric = 1 then concat('Allaitement maternel exclusif , oui : ', cast(p.value_numeric as UNSIGNED)) else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'foodExclusive' and d.short_name = 'maternalSpec' and e.patientid = '".$pid."' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'foodDiverse' and o.value_numeric = 1  then concat('Diversification alimentaire, age en mois : ',cast(p.value_numeric as UNSIGNED)) else 'xxx'
end as 'histoire alimentaire' 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name ='foodDiverse' and d.short_name = 'ageMonths' and e.patientid = '".$pid."' order by 1 desc limit 6
",
	   "pedVacc"	=> "SELECT visitdate as 'Date de visite', case
when c.short_name = 'bcgDt1'	then concat('BCG, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'polioDtD0'	then concat('Polio, dose 0 : ', cast(o.value_datetime as date))
when c.short_name = 'polioDtD1'	then concat('Polio, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'polioDtD2'	then concat('Polio, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'polioDtD3'	then concat('Polio, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'polioDtR1'	then concat('Polio, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'polioDtR2'	then concat('Polio, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'dtperDtD1'	then concat('DTPer, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'dtperDtD2'	then concat('DTPer, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'dtperDtD3'	then concat('DTPer, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'dtperDtR1'	then concat('DTPer, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'dtperDtR2'	then concat('DTPer, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'rougeoleDtD1'	then concat('Rougeole, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'rougeoleDtD2'	then concat('Rougeole, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'rougeoleDtD3'	then concat('Rougeole, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'rougeoleDtR1'	then concat('Rougeole, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'rougeoleDtR2'	then concat('Rougeole, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'rrDtD1'	then concat('RR, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'rrDtD2'	then concat('RR, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'rrDtD3'	then concat('RR, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'rrDtR1'	then concat('RR, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'rrDtR2'	then concat('RR, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'dtDtD1'	then concat('DT, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'dtDtD2'	then concat('DT, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'dtDtD3'	then concat('DT, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'dtDtR1'	then concat('DT, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'dtDtR2'	then concat('DT, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'hepbDtD1'	then concat('Hepatite B, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'hepbDtD2'	then concat('Hepatite B, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'hepbDtD3'	then concat('Hepatite B, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'hepbDtR1'	then concat('Hepatite B, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'hepbDtR2'	then concat('Hepatite B, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'pneumocoqueDtD1'		 then concat('Pneumocoque, dose 1 : ', cast(o.value_datetime as date)) 
when c.short_name = 'pneumocoqueDtD2'		 then concat('Pneumocoque, dose 2 : ', cast(o.value_datetime as date)) 
when c.short_name = 'pneumocoqueDtD3'		 then concat('Pneumocoque, dose 3 : ', cast(o.value_datetime as date)) 
when c.short_name = 'pneumocoqueDtUnknown'	 then 'Pneumocoque : Recu, date inconnue' 
when c.short_name = 'pneumocoqueNever'     then 'Pneumocoque : Jamais recu'
when c.short_name = 'hepatiteADtD1'		 then concat('Hepatite A , dose 1: ', cast(o.value_datetime as date)) 
when c.short_name = 'hepatiteADtD2'		 then concat('Hepatite A , dose 2: ', cast(o.value_datetime as date)) 
when c.short_name = 'hepatiteADtUnknown'	 then 'Hepatite A : Recu, date inconnue' 
when c.short_name = 'hepatiteANever'     then 'Hepatite A : Jamais recu'
when c.short_name = 'rotavirusDtD1'		 then concat('Rotavirus ,dose 1: ', cast(o.value_datetime as date)) 
when c.short_name = 'rotavirusDtD2'		 then concat('Rotavirus , dose 2: ', cast(o.value_datetime as date)) 
when c.short_name = 'rotavirusDtUnknown'	 then 'Rotavirus : Recu, date inconnue' 
when c.short_name = 'rotavirusNever'     then 'Rotavirus : Jamais recu'
when c.short_name = 'varicelDtD1'		 then concat('Varicelle , dose 1: ', cast(o.value_datetime as date)) 
when c.short_name = 'varicelDtD2'		 then concat('Varicelle , dose 2: ', cast(o.value_datetime as date)) 
when c.short_name = 'varicelDtUnknown'	 then 'Varicelle : Recu, date inconnue' 
when c.short_name = 'varicelNever'     then 'Varicelle : Jamais recu'
when c.short_name = 'typhimviDtD1'		 then concat('Typhimvi , dose 1: ', cast(o.value_datetime as date)) 
when c.short_name = 'typhimviDtD2'		 then concat('Typhimvi , dose 2: ', cast(o.value_datetime as date)) 
when c.short_name = 'vtyphimviDtUnknown'	 then 'Typhimvi : Recu, date inconnue' 
when c.short_name = 'typhimviNever'     then 'Typhimvi : Jamais recu'
when c.short_name = 'menengoAcDtD1'		 then concat('MenengoAc , dose 1: ', cast(o.value_datetime as date)) 
when c.short_name = 'menengoAcDtD2'		 then concat('MenengoAc , dose 2: ', cast(o.value_datetime as date)) 
when c.short_name = 'menengoAcDtUnknown'	 then 'MenengoAc : Recu, date inconnue' 
when c.short_name = 'menengoAcNever'     then 'MenengoAc : Jamais recu'
when c.short_name = 'choleraDtD1'		 then concat('Cholera , dose 1 : ', cast(o.value_datetime as date)) 
when c.short_name = 'choleraDtD2'		 then concat('Cholera , dose 2: ', cast(o.value_datetime as date)) 
when c.short_name = 'choleraDtUnknown'	 then 'Cholera : Recu, date inconnue' 
when c.short_name = 'choleraNever'     then 'Cholera : Jamais recu'
when c.short_name = 'actHibDtD1'	then concat('Act Hib, dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'actHibDtD2'	then concat('Act Hib, dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'actHibDtD3'	then concat('Act Hib, dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'actHibDtR1'	then concat('Act Hib, rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'actHibDtR2'	then concat('Act Hib, rappel 2 : ', cast(o.value_datetime as date))
when c.short_name = 'pentavDtD1'	then concat('Pentavalent (MSPP), dose 1 : ', cast(o.value_datetime as date))
when c.short_name = 'pentavDtD2'	then concat('Pentavalent (MSPP), dose 2 : ', cast(o.value_datetime as date))
when c.short_name = 'pentavDtD3'	then concat('Pentavalent (MSPP), dose 3 : ', cast(o.value_datetime as date))
when c.short_name = 'pentavDtR1'	then concat('Pentavalent (MSPP), rappel 1 : ', cast(o.value_datetime as date))
when c.short_name = 'pentavDtR2'	then concat('Pentavalent (MSPP), rappel 2 : ', cast(o.value_datetime as date))
end as vaccins 
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and encounterType = 29 and c.short_name in('bcgDt1','polioDtD0','polioDtD1','polioDtD2','polioDtD3','polioDtR1','polioDtR2','dtperDtD1','dtperDtD2','dtperDtD3','dtperDtR1','dtperDtR2','rougeoleDtD1','rougeoleDtD2','rougeoleDtD3','rougeoleDtR1','rougeoleDtR2','rrDtD1','rrDtD2','rrDtD3','rrDtR1','rrDtR2','dtDtD1','dtDtD2','dtDtD3','dtDtR1','dtDtR2','hepbDtD1','hepbDtD2','hepbDtD3','hepbDtR1','hepbDtR2','pneumocoqueDtD1','pneumocoqueDtD2','pneumocoqueDtD3','pneumocoqueDtUnknown','pneumocoqueNever','hepatiteADtD1','hepatiteADtD2','hepatiteADtUnknown','hepatiteANever','rotavirusDtD1','rotavirusDtD2','rotavirusDtUnknown','rotavirusNever','varicelDtD1','varicelDtD2','varicelDtUnknown','varicelNever','typhimviDtD1','typhimviDtD2','typhimviDtUnknown','typhimviNever','menengoAcDtD1','menengoAcDtD2','menengoAcDtUnknown','menengoAcNever','choleraDtD1','choleraDtD2','choleraDtUnknown','choleraNever','actHibDtD1','actHibDtD2','actHibDtD3','actHibDtR1','actHibDtR2','pentavDtD1','pentavDtD2','pentavDtD3','pentavDtR1','pentavDtR2') and o.value_datetime is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'vOther1DtD1'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther1desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther1DtD2'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther1desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther1DtD3'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther1desc' then concat(p.value_text , ' ', cast(o.value_datetime as date)) 
when c.short_name = 'vOther1DtD4'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther1desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther1DtD5'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther1desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther2DtD1'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther2desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther2DtD2'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther2desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther2DtD3'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther2desc' then concat(p.value_text , ' ', cast(o.value_datetime as date)) 
when c.short_name = 'vOther2DtD4'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther2desc' then concat(p.value_text , ' ', cast(o.value_datetime as date))
when c.short_name = 'vOther2DtD5'	and o.value_datetime is not null and p.value_text is not null and d.short_name = 'vOther2desc' then concat(p.value_text , ' ', cast(o.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 29 and c.short_name in('vOther1DtD1','vOther1DtD2','vOther1DtD3','vOther1DtD4','vOther1DtD5','vOther2DtD1','vOther2DtD2','vOther2DtD3','vOther2DtD4','vOther2DtD5') and d.short_name in ('vOther1desc', 'vOther2desc') and o.value_datetime is not null and p.value_text is not null and e.patientid = '" . $pid . "' 
",
	   "tpedVacc" => "SELECT visitdate as 'Date de visite', case
when c.short_name = 'bcgDose'	and o.value_text is not null then concat('BCG, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'bcgDose' and d.short_name = 'bcgDt1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "' 
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'polioDose'	and o.value_text is not null then concat('Polio, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'polioDose' and d.short_name = 'polioDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'dtperDose'	and o.value_text is not null then concat('DTPer, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'dtperDose' and d.short_name = 'dtperDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'rougeoleDose'	and o.value_text is not null then concat('Rougeole, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'rougeoleDose' and d.short_name = 'rougeoleDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'rrDose'	and o.value_text is not null then concat('RR, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'rrDose' and d.short_name = 'rrDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'dtDose'	and o.value_text is not null then concat('DT, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'dtDose' and d.short_name = 'dtDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'hepbDose'	and o.value_text is not null then concat('Hepatite B, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'hepbDose' and d.short_name = 'hepbDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'

/*ajout de nouveaux vaccins*/
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'pneumocoqueDose'	and o.value_text is not null then concat('Pneumocoque, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'pneumocoqueDose' and d.short_name = 'pneumocoqueDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'hepatiteADose'	and o.value_text is not null then concat('Hepatite A, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'hepatiteADose' and d.short_name = 'hepatiteADtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'rotavirusDose'	and o.value_text is not null then concat('Rotavirus, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'rotavirusDose' and d.short_name = 'rotavirusDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'varicelDose'	and o.value_text is not null then concat('Varicelle, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'varicelDose' and d.short_name = 'varicelDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'typhimviDose'	and o.value_text is not null then concat('Typhimvi, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'typhimviDose' and d.short_name = 'typhimviDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'menengoAcDose'	and o.value_text is not null then concat('MenengoAc, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'menengoAcDose' and d.short_name = 'menengoAcDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'choleraDose'	and o.value_text is not null then concat('Cholera, dose ', o.value_text, ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'choleraDose' and d.short_name = 'choleraDtD1' and p.value_datetime is not null and o.value_text is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'pentavDose'	and o.value_numeric is not null then concat('Pentavalent, dose ', cast(o.value_numeric as UNSIGNED), ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and encounterType = 31 and c.short_name = 'pentavDose' and d.short_name = 'pentavDtD1' and p.value_datetime is not null and o.value_numeric is not null and e.patientid = '" . $pid . "'
union
SELECT visitdate as 'Date de visite', case
when c.short_name = 'vOther1Dose'	and o.value_numeric is not null then concat(q.value_text,', dose ', cast(o.value_numeric as UNSIGNED), ': ',cast(p.value_datetime as date)) else 'xxx'
end as vaccins 
FROM `obs` o, concept c, obs p, concept d, obs q, concept f, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id  and o.encounter_id = p.encounter_id and o.location_id = p.location_id and p.concept_id = d.concept_id and o.encounter_id = q.encounter_id and o.location_id = q.location_id and q.concept_id = f.concept_id and encounterType = 31 and c.short_name = 'vOther1Dose' and d.short_name = 'vOther1DtD0' and f.short_name = 'vOther1desc' and p.value_datetime is not null and o.value_numeric is not null and q.value_text is not null and e.patientid = '" . $pid . "' order by 1 
",
	   "pedVita" => "SELECT visitdate as 'Date de visite', case
when short_name = 'supplementVitA1'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementVitA2'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementVitA3'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementVitA4'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementVitA5'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementVitA6'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementVitA7'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementIron1'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIron2'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIron3'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIron4'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIron5'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIron6'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIron7'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIodine1'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementIodine2'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementIodine3'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementIodine4'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementIodine5'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementIodine6'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementIodine7'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementDeworm1'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementDeworm2'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementDeworm3'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementDeworm4'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementDeworm5'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementDeworm6'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementDeworm7'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementZinc1'	then concat('Zinc : ', cast(value_datetime as date))
when short_name = 'supplementZinc2'	then concat('Zinc : ', cast(value_datetime as date))
when short_name = 'supplementZinc3'	then concat('Zinc : ', cast(value_datetime as date))
when short_name = 'supplementZinc4'	then concat('Zinc : ', cast(value_datetime as date))
when short_name = 'supplementZinc5'	then concat('Zinc : ', cast(value_datetime as date))
when short_name = 'supplementZinc6'	then concat('Zinc : ', cast(value_datetime as date))
when short_name = 'supplementZinc7'	then concat('Zinc : ', cast(value_datetime as date)) else 'xxx'
end as supplement
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 29 and short_name in('supplementVitA1','supplementVitA2','supplementVitA3','supplementVitA4','supplementVitA5','supplementVitA6','supplementVitA7','supplementIron1','supplementIron2','supplementIron3','supplementIron4','supplementIron5','supplementIron6','supplementIron7','supplementIodine1','supplementIodine2','supplementIodine3','supplementIodine4','supplementIodine5','supplementIodine6','supplementIodine7','supplementDeworm1','supplementDeworm2','supplementDeworm3','supplementDeworm4','supplementDeworm5','supplementDeworm6','supplementDeworm7','supplementZinc1','supplementZinc2','supplementZinc3','supplementZinc4','supplementZinc5','supplementZinc6','supplementZinc7') and e.patientid = '".$pid."' order by value_datetime 
",
	   "tpedVita" => "SELECT visitdate as 'Date de visite', case
when short_name = 'supplementVitA1'	then concat('Vitamine A : ', cast(value_datetime as date))
when short_name = 'supplementIron1'	then concat('Fer : ', cast(value_datetime as date))
when short_name = 'supplementIodine1'	then concat('Iode : ', cast(value_datetime as date))
when short_name = 'supplementDeworm1'	then concat('Deparasitage : ', cast(value_datetime as date))
when short_name = 'supplementZinc1'	then concat('Zinc : ', cast(value_datetime as date)) else 'xxx'
end as supplement
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 31 and short_name in('supplementVitA1','supplementVitA2','supplementVitA3','supplementVitA4','supplementVitA5','supplementVitA6','supplementVitA7','supplementIron1','supplementIron2','supplementIron3','supplementIron4','supplementIron5','supplementIron6','supplementIron7','supplementIodine1','supplementIodine2','supplementIodine3','supplementIodine4','supplementIodine5','supplementIodine6','supplementIodine7','supplementDeworm1','supplementDeworm2','supplementDeworm3','supplementDeworm4','supplementDeworm5','supplementDeworm6','supplementDeworm7','supplementZinc1','supplementZinc2','supplementZinc3','supplementZinc4','supplementZinc5','supplementZinc6','supplementZinc7') and e.patientid = '".$pid."' order by value_datetime 
",
	   "consCa" => "SELECT visitdate as 'Date de visite', case when short_name = 'adenopathie' then 'adenopathie' when short_name = 'cedeme_specify' then concat('oedeme :', ' ', value_text) when short_name = 'douler_specify' then concat('douleurs :', ' ', value_text) when short_name = 'feverGreat2' then 'fievre >= 2 semaines' when short_name = 'feverLess2' then 'fievre < 2 semaines' when short_name = 'perteDePoid' then 'perte de poids' when short_name = 'sueursProfuse' then 'sueurs profuses' when short_name = 'agressionAuto' then 'agression auto-infligee' when short_name = 'sexAgressionLt72h' then 'agression sexuelle < 72h' when short_name = 'sexAgressionLe120h' then 'agression sexuelle entre 72-120h' when short_name = 'sexAgressionLe2w' then 'agression sexuelle entre 120h -2 semaines' when short_name = 'sexAgressionGt2w' then 'agression sexuelle > 2 semaines' when short_name = 'accidentVoiePublique' then 'accident voie publique' when short_name = 'brulure_specify' then concat('brulures :', ' ', value_text) when short_name = 'fractureOsseuse' then 'fracture osseuse' when short_name = 'armeFeu' then 'arme a feu' when short_name = 'armeBlanche' then 'arme blanche' when short_name = 'plaie_specify' then concat('plaie :', ' ', value_text) when short_name = 'consultationHeadTrauma' then 'trauma cranien' when short_name = 'rhinorhee' then 'ecoulement nasal' when short_name = 'epitaxis' then 'epistaxis' when short_name = 'ceilRouge' then 'oeil rouge' when short_name = 'otalgia' then 'otalgie' when short_name = 'otorrhea' then 'otorrhee' when short_name = 'brulureMictionnelles' then 'brulures mictionnelles' when short_name = 'douleurHypogastrique' then 'douleur hypogastrique' when short_name = 'dysuria' then 'dysurie' when short_name = 'encoulementUrethral' then 'ecoulement urethral' when short_name = 'hematuria' then 'hematurie' when short_name = 'hemorragieVaginale' then 'hemorragie vaginale' when short_name = 'pertesVaginales' then 'pertes vaginales' when short_name = 'pollakiurie' then 'pollakiurie' when short_name = 'polyuria' then 'polyurie' when short_name = 'pruritVulvaire' then 'prurit vulvaire' when short_name = 'ulceration' then 'ulceration' when short_name = 'retardDesRegles' then 'retard des regles' when short_name = 'mentalTrouble_specify'  then concat('troubles mentaux :', ' ', value_text) when short_name = 'aphasie' then 'aphasie' when short_name = 'boiterie' then 'boiterie/steppage' when short_name = 'cephalee' then 'cephalee/maux de tete' when short_name = 'convulsion' then 'convulsions' when short_name = 'hemiplegie' then 'hemiplegie' when short_name = 'paralysie' then 'paralysie flasque' when short_name = 'paraplegie' then 'paraplegie' when short_name = 'syncopeSymptom' then 'syncope' when short_name = 'vertiges' then 'vertiges' when short_name = 'doulersPrecordiales'   then 'douleurs precordiales' when short_name = 'doulersThoraciques' then 'douleurs thoraciques' when short_name = 'dyspnea' then 'dyspnee' when short_name = 'hemoptysia' then 'hemoptysie' when short_name = ' palpitation' then 'palpitations' when short_name = 'touxLess2' then 'toux < 2 semaines' when short_name = 'touxGreat2' then 'toux >= 2 semaines' when short_name = 'eruptionCutanees_specify' then concat('eruptions cutanees :', ' ', value_text) when short_name = 'prurit' then 'prurit' when short_name = 'constipationSymptom' then 'constipation' when short_name = 'diarrheeLess2' then 'diarrhee < 2 semaines' when short_name = 'diarrheeGreat2' then 'diarrhee >= 2 semaines' when short_name = 'abdominalPain' then 'douleur abdominale' when short_name = 'dysphagia' then 'dysphagie' when short_name = 'hematemesia' then 'hematemese' when short_name = 'ictere' then 'ictere/jaunisse' when short_name = 'inappetence' then 'inappetence/anorexie' when short_name = 'melaena' then 'melena' when short_name = 'nausea' then 'nausee' when short_name = 'pyrosisSymptom' then 'pyrosis' when short_name = 'vomisement' then 'vomissement' when short_name = 'symptomOther1' then value_text when short_name = 'symptomOther2' then value_text when short_name = 'symptomOther3' then value_text when short_name = 'symptomOther4' then value_text when short_name = 'symptomOther5' then value_text when short_name = 'symptomOther6' then value_text when short_name = 'symptomOther7' then value_text when short_name = 'symptomSpecify' then value_text else 'xxx' end as motifs FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('adenopathie','cedeme_specify','douler_specify','feverGreat2','feverLess2','perteDePoid','sueursProfuse','agressionAuto','sexAgressionLt72h','sexAgressionLe120h','sexAgressionLe2w','sexAgressionGt2w','accidentVoiePublique','brulure_specify','fractureOsseuse','armeFeu','armeBlanche','plaie_specify','consultationHeadTrauma','rhinorhee','epitaxis','ceilRouge','otalgia','otorrhea','brulureMictionnelles','douleurHypogastrique','dysuria','encoulementUrethral','hematuria','hemorragieVaginale','pertesVaginales','pollakiurie','polyuria','pruritVulvaire','ulceration','retardDesRegles','mentalTrouble_specify','aphasie','boiterie','cephalee','convulsion','hemiplegie','paralysie','paraplegie','syncopeSymptom','vertiges','doulersPrecordiales','doulersThoraciques','dyspnea','hemoptysia','palpitation','touxLess2','touxGreat2','eruptionCutanees_specify','prurit','constipationSymptom','diarrheeLess2','diarrheeGreat2','abdominalPain','dysphagia','hematemesia','ictere','inappetence','melaena','nausea','pyrosisSymptom','vomisement','symptomOther1','symptomOther2','symptomOther3','symptomOther4','symptomOther5','symptomOther6','symptomOther7','symptomSpecify') and encounterType = 27 and e.patientid = '".$pid."' order by 1 desc",
	   "obConsCa" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'amenorrhee_specify'     then concat('Amenorrhee : ',value_text)
when short_name = 'asthenia'     then 'Asthenie : '
when short_name = 'foetalMovementChangeSymptom'		then 'Changement dans la frequence et/ou intensite des mouvements foetaux'
when short_name = 'courbatures' then 'Courbatures'
when short_name = 'epigasPainSymptom' 	then 'Douleurs Epigastriques en barre'
when short_name = 'cedeme'    then 'Oedeme'
when short_name = 'feverGreat2'     then 'Fievre >= 2 semaines'
when short_name = 'feverLess2'      then 'Fievre < 2 semaines'
when short_name = 'frissons'		then 'Frissons'
when short_name = 'hypomenorrheeSymptom'		then 'Hypomenorrhee'
when short_name = 'hypermenorrheeSymptom'		then 'Hypermenorrhee'
when short_name = 'menorrheeOligoSymptom'		then 'Oligo menorrhee'
when short_name = 'vaginaLiquidSymptom'		then 'Passage de liquide par le vagin'
when short_name = 'perteDePoid'     then 'Perte de poids'
when short_name = 'familyplan'		then 'Planification familiale'
when short_name = 'polymenorrheeSymptom' then 'Poly menorrhee'
when short_name = 'ptme'		then 'PTME'
when short_name = 'vaginalBleedingSymptom'		then 'Saignement Vaginal'
when short_name = 'sueursProfuse'     then 'Sueurs profuses face/doigts'
when short_name = 'sexAgressionLt72h'    then 'agression sexuelle < 72h'
when short_name = 'sexAgressionLe120h'    then 'agression sexuelle entre 72-120h'
when short_name = 'sexAgressionLe2w'    then 'agression sexuelle entre 120h -2 semaines'
when short_name = 'sexAgressionGt2w'    then 'agression sexuelle > 2 semaines'
when short_name = 'rhinorhee'      then 'Ecoulement nasal'
when short_name = 'hypogasDouleurs'   then 'Douleurs hypogastriques'
when short_name = 'dysuria'      then 'Dysurie'
when short_name = 'pollakiurie'     then 'Pollakiurie'
when short_name = 'pruritVulvaire'     then 'Prurit Vulvaire'
when short_name = 'cephalee'      then 'Cephalee'
when short_name = 'convulsion'      then 'Convulsions'
when short_name = 'doulersPrecordiales'   then 'Douleurs precordiales'
when short_name = 'doulersThoraciques'    then 'Douleurs thoraciques'
when short_name = 'dyspnea'      then 'Dyspnee'
when short_name = 'hemoptysia'      then 'Hemoptysie'
when short_name = 'leucorheeSymptom'		then 'Leucorrhee'
when short_name = 'hypogasPain'		then 'Masse Hypogastrique'
when short_name = 'menorrhagiaSymptom'     then 'Menorragie'
when short_name = 'metrorragieSymptom'		then 'Metrorragie'
when short_name = 'touxLess2'      then 'Toux < 2 semaines'
when short_name = 'touxGreat2'      then 'Toux >= 2 semaines'
when short_name = 'visualTrouble'		then 'Troubles Visuels'
when short_name = 'vomiting'		then 'Vomissement'
when short_name = 'diarrheaSymptom'     then 'Diarrhee'
when short_name = 'abdominalPain'     then 'Douleurs abdominales'
when short_name = 'inappetence'     then 'Inappetence'
when short_name = 'symptomOther1'     then concat('Autres : ',value_text)
when short_name = 'symptomOther2'     then concat('Autres : ',value_text) else 'xxx'
end as motifs
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('amenorrhee_specify','asthenia','foetalMovementChangeSymptom','courbatures','epigasPainSymptom','cedeme','feverGreat2','feverLess2','frissons','hypomenorrheeSymptom','hypermenorrheeSymptom','menorrheeOligoSymptom','vaginaLiquidSymptom','perteDePoid','familyplan','polymenorrheeSymptom','ptme','vaginalBleedingSymptom','sueursProfuse','sexAgressionLt72h','sexAgressionLe120h','sexAgressionLe2w','sexAgressionGt2w','rhinorhee','hypogasDouleurs','dysuria','pollakiurie','pruritVulvaire','cephalee','convulsion','doulersPrecordiales','doulersThoraciques','dyspnea','hemoptysia','leucorheeSymptom','hypogasPain','menorrhagiaSymptom','metrorragieSymptom','touxLess2','touxGreat2','visualTrouble','vomiting','diarrheaSymptom','abdominalPain','inappetence','symptomOther1','symptomOther2') and encounterType = 24 and e.patientid = '".$pid."' order by 1 desc
",
	   "pedConsCa" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'asthenia'	then 'Asthenie/Lethargie'
when short_name = 'pedSympNutritionalEdema'	then 'Oedemes bilateraux (nutritionnel)'
when short_name = 'cedeme_specify'    then concat('Oedeme :', ' ', value_text)
when short_name = 'douler_specify'     then concat('Douleurs :', ' ', value_text)
when short_name = 'feverGreat2'     then 'Fievre >= 2 semaines'
when short_name = 'feverLess2'      then 'Fievre < 2 semaines'
when short_name = 'perteDePoid'     then 'Perte de poids'
when short_name = 'sueursProfuse'     then 'Sueurs profuses'
when short_name = 'continualUnexplainedCrying'	then 'Pleurs incessantes/inexpliquees'
when short_name = 'refusesBreastFeedingOrDrink'	then 'Refus de teter/boire'
when short_name = 'domesticAssault'		then 'Agression a domicile'
when short_name = 'sexAgressionLt72h'    then 'Agression sexuelle < 72h'/*(1)*/
when short_name = 'sexAgressionLe120h'    then 'Agression sexuelle entre 72-120h'/*(2)*/
when short_name = 'sexAgressionLe2w'    then 'Agression sexuelle entre 120h -2 semaines'
when short_name = 'sexAgressionGt2w'    then 'Agression sexuelle > 2 semaines'/*(3)*/
when short_name = 'accidentVoiePublique'   then 'Accident voie publique'
when short_name = 'brulure_specify'    then concat('Brulures :', ' ', value_text)
when short_name = 'fractureOsseuse'    then 'Fracture osseuse'
when short_name = 'plaie_specify'	then concat('Plaie : ', value_text)
when short_name = 'traumaCranien'   then 'Trauma cranien' 
when short_name = 'rhinorhee'      then 'Ecoulement nasal'
when short_name = 'pusEyeSecretion'	then 'Ecoulement de pus dans les yeux'
when short_name = 'ceilRouge'      then 'Oeil rouge'
when short_name = 'otalgia'      then 'Otalgie'
when short_name = 'otorrhea'      then 'Otorrhee'
when short_name = 'brulureMictionnelles'   then 'Brulures mictionnelles'
when short_name = 'dysuria'      then 'Dysurie'
when short_name = 'enuresis'	then 'Enuresie'
when short_name = 'hematuria'      then 'Hematurie'
when short_name = 'polyuria'      then 'Polyurie'
when short_name = 'pruritVulvaire'     then 'Prurit vulvaire'
when short_name = 'mentalTrouble_specify'  then concat('Troubles mentaux :', ' ', value_text)
when short_name = 'arthralgia'	then 'Arthralgie'
when short_name = 'cephalee'      then 'Cephalee/maux de tete'
when short_name = 'convulsion'      then 'Convulsions'
when short_name = 'irritabilityAgitation'	then 'Irritabilite/agitation'
when short_name = 'pedSympLethargy'	then 'Lethargie/inconscient'
when short_name = 'paralysie'      then 'Paralysie flasque'
when short_name = 'syncopeSymptom'     then 'Syncope'
when short_name = 'doulersThoraciques'    then 'Douleurs thoraciques'
when short_name = 'dyspnea'      then 'Dyspnee'
when short_name = 'hemoptysia'      then 'Hemoptysie'
when short_name = 'palpitation'     then 'Palpitations' 
when short_name = 'touxLess2'      then 'Toux < 2 semaines'
when short_name = 'touxGreat2'      then 'Toux >= 2 semaines'
when short_name = 'eruptionCutanees' then'Eruptions cutanees'
when short_name = 'ecchymosisPetechiae' 	then 'Petechie/Ecchymose'
when short_name = 'prurit'       then 'Prurit'
when short_name = 'purpura'	then 'Purpura'
when short_name = 'urticaria'	then 'Urticaire'
when short_name = 'constipationSymptom'   then 'Constipation'
when short_name = 'diarrheeLess2'     then 'Diarrhee < 2 semaines'
when short_name = 'diarrheeGreat2'     then 'Diarrhee >= 2 semaines'
when short_name = 'abdominalPain'     then 'Douleur abdominale'
when short_name = 'dysphagia'      then 'Dysphagie'
when short_name = 'hematemesia'     then 'Hematemese'
when short_name = 'ictere'       then 'Ictere/jaunisse'
when short_name = 'inappetence'     then 'Inappetence/anorexie'
when short_name = 'melaena'      then 'Melena'
when short_name = 'nausea'       then 'Nausee'
when short_name = 'prurisAni'	then 'Pruit anal'
when short_name = 'pyrosisSymptom'     then 'Pyrosis'
when short_name = 'regurgitation'		then 'Regurgitation'
when short_name = 'vomisement'      then 'Vomissement'
when short_name = 'symptomOther1'     then value_text
when short_name = 'symptomOther2'     then value_text
when short_name = 'courbatures' then 'Courbatures' 
when short_name = 'frissons'		then 'Frissons' 
when short_name = 'inssufficientWeightGain'	then 'Insuffisance gain de poids'
when short_name = 'malaise'	then 'Malaise'
when short_name = 'myalgie'		then 'Myalgie'
when short_name = 'leucorheeSymptom'		then 'Leucorrhee'
when short_name = 'symptomSpecify'	then value_text else 'xxx'
end as motifs
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('cedeme_specify','douler_specify','feverGreat2','feverLess2','perteDePoid','sueursProfuse','sexAgressionLt72h','sexAgressionLe120h','sexAgressionLe2w','sexAgressionGt2w','accidentVoiePublique','brulure_specify','fractureOsseuse','consultationHeadTrauma','rhinorhee','ceilRouge','otalgia','otorrhea','brulureMictionnelles','dysuria','hematuria','polyuria','pruritVulvaire','mentalTrouble_specify','cephalee','convulsion','paralysie','syncopeSymptom','doulersThoraciques','dyspnea','hemoptysia','palpitation','touxLess2','touxGreat2','eruptionCutanees_specify','prurit','constipationSymptom','diarrheeLess2','diarrheeGreat2','abdominalPain','dysphagia','hematemesia','ictere','inappetence','melaena','nausea','pyrosisSymptom','vomisement','symptomOther1','symptomOther2','purpura','frissons','myalgie','courbatures','regurgitation','prurisAni','enuresis','irritabilityAgitation','arthralgia','urticaria','ecchymosisPetechiae','domesticAssault','pusEyeSecretion','refusesBreastFeedingOrDrink','continualUnexplainedCrying','malaise','inssufficientWeightGain','asthenia','leucorheeSymptom','traumaCranien','eruptionCutanees','palpitation','pedSympLethargy','pedSympNutritionalEdema','plaie_specify','symptomSpecify') and encounterType = 29 and e.patientid = '".$pid."' order by 1 desc
",
	   "tconsCa" => "SELECT visitdate as 'Date de visite', case when short_name = 'adenopathie' then 'adenopathie' when short_name = 'cedeme_specify' then concat('oedeme :', ' ', value_text) when short_name = 'douler_specify' then concat('douleurs :', ' ', value_text) when short_name = 'feverGreat2' then 'fievre >= 2 semaines' when short_name = 'feverLess2' then 'fievre < 2 semaines' when short_name = 'perteDePoid' then 'perte de poids' when short_name = 'sueursProfuse' then 'sueurs profuses' when short_name = 'agressionAuto' then 'agression auto-infligee' when short_name = 'sexAgressionLt72h' then 'agression sexuelle < 72h' when short_name = 'sexAgressionLe120h' then 'agression sexuelle entre 72-120h' when short_name = 'sexAgressionLe2w' then 'agression sexuelle entre 120h -2 semaines' when short_name = 'sexAgressionGt2w' then 'agression sexuelle > 2 semaines' when short_name = 'accidentVoiePublique' then 'accident voie publique' when short_name = 'brulure_specify' then concat('brulures :', ' ', value_text) when short_name = 'fractureOsseuse' then 'fracture osseuse' when short_name = 'armeFeu' then 'arme a feu' when short_name = 'armeBlanche' then 'arme blanche' when short_name = 'plaie_specify' then concat('plaie :', ' ', value_text) when short_name = 'consultationHeadTrauma' then 'trauma cranien' when short_name = 'rhinorhee' then 'ecoulement nasal' when short_name = 'epitaxis' then 'epistaxis' when short_name = 'ceilRouge' then 'oeil rouge' when short_name = 'otalgia' then 'otalgie' when short_name = 'otorrhea' then 'otorrhee' when short_name = 'brulureMictionnelles' then 'brulures mictionnelles' when short_name = 'douleurHypogastrique' then 'douleur hypogastrique' when short_name = 'dysuria' then 'dysurie' when short_name = 'encoulementUrethral' then 'ecoulement urethral' when short_name = 'hematuria' then 'hematurie' when short_name = 'hemorragieVaginale' then 'hemorragie vaginale' when short_name = 'pertesVaginales' then 'pertes vaginales' when short_name = 'pollakiurie' then 'pollakiurie' when short_name = 'polyuria' then 'polyurie' when short_name = 'pruritVulvaire' then 'prurit vulvaire' when short_name = 'ulceration' then 'ulceration' when short_name = 'retardDesRegles' then 'retard des regles' when short_name = 'mentalTrouble_specify'  then concat('troubles mentaux :', ' ', value_text) when short_name = 'aphasie' then 'aphasie' when short_name = 'boiterie' then 'boiterie/steppage' when short_name = 'cephalee' then 'cephalee/maux de tete' when short_name = 'convulsion' then 'convulsions' when short_name = 'hemiplegie' then 'hemiplegie' when short_name = 'paralysie' then 'paralysie flasque' when short_name = 'paraplegie' then 'paraplegie' when short_name = 'syncopeSymptom' then 'syncope' when short_name = 'vertiges' then 'vertiges' when short_name = 'doulersPrecordiales'   then 'douleurs precordiales' when short_name = 'doulersThoraciques' then 'douleurs thoraciques' when short_name = 'dyspnea' then 'dyspnee' when short_name = 'hemoptysia' then 'hemoptysie' when short_name = ' palpitation' then 'palpitations' when short_name = 'touxLess2' then 'toux < 2 semaines' when short_name = 'touxGreat2' then 'toux >= 2 semaines' when short_name = 'eruptionCutanees_specify' then concat('eruptions cutanees :', ' ', value_text) when short_name = 'prurit' then 'prurit' when short_name = 'constipationSymptom' then 'constipation' when short_name = 'diarrheeLess2' then 'diarrhee < 2 semaines' when short_name = 'diarrheeGreat2' then 'diarrhee >= 2 semaines' when short_name = 'abdominalPain' then 'douleur abdominale' when short_name = 'dysphagia' then 'dysphagie' when short_name = 'hematemesia' then 'hematemese' when short_name = 'ictere' then 'ictere/jaunisse' when short_name = 'inappetence' then 'inappetence/anorexie' when short_name = 'melaena' then 'melena' when short_name = 'nausea' then 'nausee' when short_name = 'pyrosisSymptom' then 'pyrosis' when short_name = 'vomisement' then 'vomissement' when short_name = 'symptomOther1' then value_text when short_name = 'symptomOther2' then value_text when short_name = 'symptomOther3' then value_text when short_name = 'symptomOther4' then value_text when short_name = 'symptomOther5' then value_text when short_name = 'symptomOther6' then value_text when short_name = 'symptomOther7' then value_text when short_name = 'symptomSpecify' then value_text else 'xxx' end as motifs FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('adenopathie','cedeme_specify','douler_specify','feverGreat2','feverLess2','perteDePoid','sueursProfuse','agressionAuto','sexAgressionLt72h','sexAgressionLe120h','sexAgressionLe2w','sexAgressionGt2w','accidentVoiePublique','brulure_specify','fractureOsseuse','armeFeu','armeBlanche','plaie_specify','consultationHeadTrauma','rhinorhee','epitaxis','ceilRouge','otalgia','otorrhea','brulureMictionnelles','douleurHypogastrique','dysuria','encoulementUrethral','hematuria','hemorragieVaginale','pertesVaginales','pollakiurie','polyuria','pruritVulvaire','ulceration','retardDesRegles','mentalTrouble_specify','aphasie','boiterie','cephalee','convulsion','hemiplegie','paralysie','paraplegie','syncopeSymptom','vertiges','doulersPrecordiales','doulersThoraciques','dyspnea','hemoptysia','palpitation','touxLess2','touxGreat2','eruptionCutanees_specify','prurit','constipationSymptom','diarrheeLess2','diarrheeGreat2','abdominalPain','dysphagia','hematemesia','ictere','inappetence','melaena','nausea','pyrosisSymptom','vomisement','symptomOther1','symptomOther2','symptomOther3','symptomOther4','symptomOther5','symptomOther6','symptomOther7','symptomSpecify') and encounterType = 28 and e.patientid = '".$pid."' order by 1 desc limit 6",
	   "tpedConsCa" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'asthenia'	then 'Asthenie/Lethargie'
when short_name = 'pedSympNutritionalEdema'	then 'Oedemes bilateraux (nutritionnel)'
when short_name = 'cedeme_specify'    then concat('Oedeme :', ' ', value_text)
when short_name = 'douler_specify'     then concat('Douleurs :', ' ', value_text)
when short_name = 'feverGreat2'     then 'Fievre >= 2 semaines'
when short_name = 'feverLess2'      then 'Fievre < 2 semaines'
when short_name = 'perteDePoid'     then 'Perte de poids'
when short_name = 'sueursProfuse'     then 'Sueurs profuses'
when short_name = 'continualUnexplainedCrying'	then 'Pleurs incessantes/inexpliquees'
when short_name = 'refusesBreastFeedingOrDrink'	then 'Refus de teter/boire'
when short_name = 'domesticAssault'		then 'Agression a domicile'
when short_name = 'sexAgressionLt72h'    then 'Agression sexuelle < 72h'/*(1)*/
when short_name = 'sexAgressionLe120h'    then 'Agression sexuelle entre 72-120h'/*(2)*/
when short_name = 'sexAgressionLe2w'    then 'Agression sexuelle entre 120h -2 semaines'
when short_name = 'sexAgressionGt2w'    then 'Agression sexuelle > 2 semaines'/*(3)*/
when short_name = 'accidentVoiePublique'   then 'Accident voie publique'
when short_name = 'brulure_specify'    then concat('Brulures :', ' ', value_text)
when short_name = 'fractureOsseuse'    then 'Fracture osseuse'
when short_name = 'plaie_specify'	then concat('Plaie : ', value_text)
when short_name = 'traumaCranien'   then 'Trauma cranien' 
when short_name = 'rhinorhee'      then 'Ecoulement nasal'
when short_name = 'pusEyeSecretion'	then 'Ecoulement de pus dans les yeux'
when short_name = 'ceilRouge'      then 'Oeil rouge'
when short_name = 'otalgia'      then 'Otalgie'
when short_name = 'otorrhea'      then 'Otorrhee'
when short_name = 'brulureMictionnelles'   then 'Brulures mictionnelles'
when short_name = 'dysuria'      then 'Dysurie'
when short_name = 'enuresis'	then 'Enuresie'
when short_name = 'hematuria'      then 'Hematurie'
when short_name = 'polyuria'      then 'Polyurie'
when short_name = 'pruritVulvaire'     then 'Prurit vulvaire'
when short_name = 'mentalTrouble_specify'  then concat('Troubles mentaux :', ' ', value_text)
when short_name = 'arthralgia'	then 'Arthralgie'
when short_name = 'cephalee'      then 'Cephalee/maux de tete'
when short_name = 'convulsion'      then 'Convulsions'
when short_name = 'irritabilityAgitation'	then 'Irritabilite/agitation'
when short_name = 'pedSympLethargy'	then 'Lethargie/inconscient'
when short_name = 'paralysie'      then 'Paralysie flasque'
when short_name = 'syncopeSymptom'     then 'Syncope'
when short_name = 'doulersThoraciques'    then 'Douleurs thoraciques'
when short_name = 'dyspnea'      then 'Dyspnee'
when short_name = 'hemoptysia'      then 'Hemoptysie'
when short_name = 'palpitation'     then 'Palpitations' 
when short_name = 'touxLess2'      then 'Toux < 2 semaines'
when short_name = 'touxGreat2'      then 'Toux >= 2 semaines'
when short_name = 'eruptionCutanees' then'Eruptions cutanees'
when short_name = 'ecchymosisPetechiae' 	then 'Petechie/Ecchymose'
when short_name = 'prurit'       then 'Prurit'
when short_name = 'purpura'	then 'Purpura'
when short_name = 'urticaria'	then 'Urticaire'
when short_name = 'constipationSymptom'   then 'Constipation'
when short_name = 'diarrheeLess2'     then 'Diarrhee < 2 semaines'
when short_name = 'diarrheeGreat2'     then 'Diarrhee >= 2 semaines'
when short_name = 'abdominalPain'     then 'Douleur abdominale'
when short_name = 'dysphagia'      then 'Dysphagie'
when short_name = 'hematemesia'     then 'Hematemese'
when short_name = 'ictere'       then 'Ictere/jaunisse'
when short_name = 'inappetence'     then 'Inappetence/anorexie'
when short_name = 'melaena'      then 'Melena'
when short_name = 'nausea'       then 'Nausee'
when short_name = 'prurisAni'	then 'Pruit anal'
when short_name = 'pyrosisSymptom'     then 'Pyrosis'
when short_name = 'regurgitation'		then 'Regurgitation'
when short_name = 'vomisement'      then 'Vomissement'
when short_name = 'symptomOther1'     then value_text
when short_name = 'symptomOther2'     then value_text
when short_name = 'courbatures' then 'Courbatures' 
when short_name = 'frissons'		then 'Frissons' 
when short_name = 'inssufficientWeightGain'	then 'Insuffisance gain de poids'
when short_name = 'malaise'	then 'Malaise'
when short_name = 'myalgie'		then 'Myalgie'
when short_name = 'leucorheeSymptom'		then 'Leucorrhee'
when short_name = 'symptomSpecify'	then value_text else 'xxx'
end as motifs
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('cedeme_specify','douler_specify','feverGreat2','feverLess2','perteDePoid','sueursProfuse','sexAgressionLt72h','sexAgressionLe120h','sexAgressionLe2w','sexAgressionGt2w','accidentVoiePublique','brulure_specify','fractureOsseuse','consultationHeadTrauma','rhinorhee','ceilRouge','otalgia','otorrhea','brulureMictionnelles','dysuria','hematuria','polyuria','pruritVulvaire','mentalTrouble_specify','cephalee','convulsion','paralysie','syncopeSymptom','doulersThoraciques','dyspnea','hemoptysia','palpitation','touxLess2','touxGreat2','eruptionCutanees_specify','prurit','constipationSymptom','diarrheeLess2','diarrheeGreat2','abdominalPain','dysphagia','hematemesia','ictere','inappetence','melaena','nausea','pyrosisSymptom','vomisement','symptomOther1','symptomOther2','purpura','frissons','myalgie','courbatures','regurgitation','prurisAni','enuresis','irritabilityAgitation','arthralgia','urticaria','ecchymosisPetechiae','domesticAssault','pusEyeSecretion','refusesBreastFeedingOrDrink','continualUnexplainedCrying','malaise','inssufficientWeightGain','asthenia','leucorheeSymptom','traumaCranien','eruptionCutanees','palpitation','pedSympLethargy','pedSympNutritionalEdema','plaie_specify','symptomSpecify') and encounterType = 31 and e.patientid = '".$pid."' order by 1 desc limit 6
",
	   "tobConsCa" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'amenorrhee_specify'     then concat('Amenorrhee : ',value_text)
when short_name = 'asthenia'     then 'Asthenie : '
when short_name = 'foetalMovementChangeSymptom'		then 'Changement dans la frequence et/ou intensite des mouvements foetaux'
when short_name = 'courbatures' then 'Courbatures'
when short_name = 'epigasPainSymptom' 	then 'Douleurs Epigastriques en barre'
when short_name = 'cedeme'    then 'Oedeme'
when short_name = 'feverGreat2'     then 'Fievre >= 2 semaines'
when short_name = 'feverLess2'      then 'Fievre < 2 semaines'
when short_name = 'frissons'		then 'Frissons'
when short_name = 'hypomenorrheeSymptom'		then 'Hypomenorrhee'
when short_name = 'hypermenorrheeSymptom'		then 'Hypermenorrhee'
when short_name = 'menorrheeOligoSymptom'		then 'Oligo menorrhee'
when short_name = 'vaginaLiquidSymptom'		then 'Passage de liquide par le vagin'
when short_name = 'perteDePoid'     then 'Perte de poids'
when short_name = 'familyplan'		then 'Planification familiale'
when short_name = 'polymenorrheeSymptom' then 'Poly menorrhee'
when short_name = 'ptme'		then 'PTME'
when short_name = 'vaginalBleedingSymptom'		then 'Saignement Vaginal'
when short_name = 'sueursProfuse'     then 'Sueurs profuses face/doigts'
when short_name = 'sexAgressionLt72h'    then 'agression sexuelle < 72h'
when short_name = 'sexAgressionLe120h'    then 'agression sexuelle entre 72-120h'
when short_name = 'sexAgressionLe2w'    then 'agression sexuelle entre 120h -2 semaines'
when short_name = 'sexAgressionGt2w'    then 'agression sexuelle > 2 semaines'
when short_name = 'rhinorhee'      then 'Ecoulement nasal'
when short_name = 'hypogasDouleurs'   then 'Douleurs hypogastriques'
when short_name = 'dysuria'      then 'Dysurie'
when short_name = 'pollakiurie'     then 'Pollakiurie'
when short_name = 'pruritVulvaire'     then 'Prurit Vulvaire'
when short_name = 'cephalee'      then 'Cephalee'
when short_name = 'convulsion'      then 'Convulsions'
when short_name = 'doulersPrecordiales'   then 'Douleurs precordiales'
when short_name = 'doulersThoraciques'    then 'Douleurs thoraciques'
when short_name = 'dyspnea'      then 'Dyspnee'
when short_name = 'hemoptysia'      then 'Hemoptysie'
when short_name = 'leucorheeSymptom'		then 'Leucorrhee'
when short_name = 'hypogasPain'		then 'Masse Hypogastrique'
when short_name = 'menorrhagiaSymptom'     then 'Menorragie'
when short_name = 'metrorragieSymptom'		then 'Metrorragie'
when short_name = 'touxLess2'      then 'Toux < 2 semaines'
when short_name = 'touxGreat2'      then 'Toux >= 2 semaines'
when short_name = 'visualTrouble'		then 'Troubles Visuels'
when short_name = 'vomiting'		then 'Vomissement'
when short_name = 'diarrheaSymptom'     then 'Diarrhee'
when short_name = 'abdominalPain'     then 'Douleurs abdominales'
when short_name = 'inappetence'     then 'Inappetence'
when short_name = 'symptomOther1'     then concat('Autres : ',value_text)
when short_name = 'symptomOther2'     then concat('Autres : ',value_text) else 'xxx'
end as motifs
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('amenorrhee_specify','asthenia','foetalMovementChangeSymptom','courbatures','epigasPainSymptom','cedeme','feverGreat2','feverLess2','frissons','hypomenorrheeSymptom','hypermenorrheeSymptom','menorrheeOligoSymptom','vaginaLiquidSymptom','perteDePoid','familyplan','polymenorrheeSymptom','ptme','vaginalBleedingSymptom','sueursProfuse','sexAgressionLt72h','sexAgressionLe120h','sexAgressionLe2w','sexAgressionGt2w','rhinorhee','hypogasDouleurs','dysuria','pollakiurie','pruritVulvaire','cephalee','convulsion','doulersPrecordiales','doulersThoraciques','dyspnea','hemoptysia','leucorheeSymptom','hypogasPain','menorrhagiaSymptom','metrorragieSymptom','touxLess2','touxGreat2','visualTrouble','vomiting','diarrheaSymptom','abdominalPain','inappetence','symptomOther1','symptomOther2') and encounterType = 25 and e.patientid = '".$pid."' order by 1 desc limit 6
",
	   "physEx" => "SELECT visitdate as 'Date de visite', case when short_name = 'physicalHead' and value_numeric = '2' then 'Tete : Anormal' when short_name = 'physicalNose' and value_numeric = '2' then 'Nez : Anormal' when short_name = 'physicalMouth' and value_numeric = '2' then 'Bouche : Anormal' when short_name = 'physicalEar' and value_numeric = '2' then 'Oreille : Anormal' when short_name = 'physicalCollar' and value_numeric = '2' then 'Cou : Anormal' when short_name = 'physicalHeart' and value_numeric = '2' then 'Coeur : Anormal' when short_name = 'physicalGenitals' 	and value_numeric = '2' then 'Organes genitaux : Anormal' when short_name = 'physicalMembers' and value_numeric = '2' then 'Membres : Anormal' when short_name = 'physicalRectum' and value_numeric = '2' then 'Toucher rectal : Anormal' when short_name = 'physicalNeurological' and value_numeric = '2' then 'Examen neurologique : Anormal' when short_name = 'physicalCervical' and value_numeric = '2' then 'Cervicale : Lymphadenopathy present' when short_name = 'physicalSupraclavicular'	and value_numeric = '2' then 'Supraclaviculaire : Lymphadenopathy present' when short_name = 'physicalAxillary' and value_numeric = '2' then 'Axilaire : Lymphadenopathy present' when short_name = 'physicalInguinal' and value_numeric = '2' then 'Inguinale : Lymphadenopathy present' when short_name = 'otherExamComment123' then value_text else 'xxx' end as examen FROM `obs` o, concept c, encValidAll e  WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 27 and short_name in('physicalHead','physicalNose','physicalMouth','physicalEar','physicalCollar','physicalHeart','physicalGenitals','physicalMembers','physicalRectum','physicalNeurological','physicalCervical','physicalSupraclavicular','physicalAxillary','physicalInguinal','otherExamComment123') and (value_numeric in(2) or value_text is not null) and e.patientid = '".$pid."' union SELECT visitdate, case when physicalEyes = '2' then 'Yeux : Anormal' else 'xxx' end as Yeux FROM a_vitals where patientID='".$pid."' and physicalEyes in(2) and encounterType = 27 union SELECT visitdate, case when physicalLungs = '2' then 'Poumons : Anormal' else 'xxx' end as Poumons FROM a_vitals where patientID='".$pid."' and physicalLungs in(2) and encounterType = 27 union SELECT visitdate, case when physicalAbdomen = '2' then 'Abdomen : Anormal' else 'xxx' end as Abdomen FROM a_vitals where patientID='".$pid."' and physicalAbdomen in(2) and encounterType = 27 union SELECT visitdate, case when physicalSkin = '2' then 'Peau : Anormal'  else 'xxx' end as Peau FROM a_vitals where patientID='".$pid."' and physicalSkin in(2) and encounterType = 27 order by 1 desc",
	   "obPhysEx" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'physicalHead' 		and value_numeric = '2' then 'Tete : Anormal' 
when short_name = 'physicalNeck' 		and value_numeric = '2' then 'Cou + Thyroide : Anormal' 
when short_name = 'physicalHeart' 		and value_numeric = '2' then 'Coeur : Anormal' 
when short_name = 'physicalCentres'		and value_numeric = '2'	then 'Seins : Anormal'
when short_name = 'physicalUterine' 	and value_numeric = '2' then 'Uterus : Anormal'
when short_name = 'physicalExternalGenitals' 	and value_numeric = '2' then 'Organes genitaux Externes : Anormal' 
when short_name = 'physicalVagina'		and value_numeric = '2' then 'Vagin : Anormal'
when short_name = 'physicalCollar'		and value_numeric = '2'	then 'Col : Anormal'
when short_name = 'physicalAppendices'	and value_numeric = '2' then 'Annexes : Anormal' 
when short_name = 'physicalMembers' 	and value_numeric = '2' then 'Membres : Anormal' 
when short_name = 'physicalRectum' 		and value_numeric = '2' then 'Toucher rectal : Anormal' 
when short_name = 'physicalTendonReflexes'		and value_numeric = '2' then 'Reflexes Osteo-Tendineux'
when short_name = 'physicalCervical' 			and value_numeric = '2' then 'Cervicale : Lymphadenopathy present' 
when short_name = 'physicalSupraclavicular'		and value_numeric = '2' then 'Supraclaviculaire : Lymphadenopathy present' 
when short_name = 'physicalAxillary' 			and value_numeric = '2' then 'Axilaire : Lymphadenopathy present' 
when short_name = 'physicalInguinal' 			and value_numeric = '2' then 'Inguinale : Lymphadenopathy present'
when short_name = 'physicalOtherText'	then concat('Autre : ', value_text) 
when short_name = 'otherExamComment123'			then value_text
when short_name = 'laborFetalHeartRate'		then concat('Rythme cardiaque foetal : ',value_text,'/min')
when short_name = 'laborUterine'		then concat('Hauteur uterine : ', value_text, ' cm')
when short_name = 'examObOedeme'		and value_numeric = '1' then 'Oedeme : oui'
when short_name = 'examObOedeme'		and value_numeric = '2' then 'Oedeme : non'
when short_name = 'laborPresentation'	and value_numeric = '1'	then 'Presentation : Cephalique(C)'
when short_name = 'laborPresentation'	and value_numeric = '2'	then 'Presentation : Siege(S)'
when short_name = 'laborPresentation'	and value_numeric = '4' then 'Presentation : Transversale(T)'
when short_name = 'examObPosition'		and value_numeric = '1' then 'Position : Droite'
when short_name = 'examObPosition'		and value_numeric = '2' then 'Position : Gauche'
when short_name = 'examObContraction'	and value_numeric = '1'	then 'Contraction uterine : oui'
when short_name = 'examObContraction'	and value_numeric = '2'	then 'Contraction uterine : non' else 'xxx'
end as examen
FROM `obs` o, concept c, encValidAll e  WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('physicalHead','physicalNeck','physicalHeart','physicalCentres','physicalUterine','physicalExternalGenitals','physicalVagina','physicalCollar','physicalAppendices','physicalMembers','physicalRectum','physicalTendonReflexes','physicalCervical','physicalSupraclavicular','physicalAxillary','physicalInguinal','physicalOtherText','otherExamComment123','laborFetalHeartRate','laborUterine','examObOedeme','laborPresentation','examObPosition','examObContraction') and encounterType = 24 and e.patientid = '".$pid."' 
union SELECT visitdate, case  
when physicalGeneral = '2' 				then 'General : Anormal' else 'xxx'
end as 'General'
FROM a_vitals where patientID='".$pid."' and encounterType = 24 and physicalGeneral in(2)
union SELECT visitdate, case
when physicalLungs = '2' 				then 'Poumons : Anormal' else 'xxx'
end as Poumons
FROM a_vitals where patientID='".$pid."' and encounterType = 24 and physicalLungs in(2)
union SELECT visitdate, case
when physicalAbdomen = '2'				then 'Abdomen : Anormal' else 'xxx'
end as Abdomen
FROM a_vitals where patientID='".$pid."' and encounterType = 24 and physicalAbdomen in(2)
union SELECT visitdate, case
when physicalSkin = '2' 				then 'Peau : Anormal'  else 'xxx'
end as Peau
FROM a_vitals where patientID='".$pid."' and encounterType = 24 and physicalSkin in(2) order by 1 desc",
	   "pedPhysEx" => "SELECT visitdate as 'Date de visite', case 
when c.short_name = 'physicalHead' 		and o.value_numeric = '2' then 'Tete : Anormal'
when c.short_name = 'physicalNose' 		and o.value_numeric = '2' then 'Nez : Anormal' 
when c.short_name = 'physicalMouth' 		and o.value_numeric = '2' then 'Bouche : Anormal' 
when c.short_name = 'physicalEar' 		and o.value_numeric = '2' then 'Oreille : Anormal' 
when c.short_name = 'physicalCollar' 		and o.value_numeric = '2' then 'Cou : Anormal' 
when c.short_name = 'physicalHeart' 		and o.value_numeric = '2' then 'Coeur : Anormal' 
when c.short_name = 'physicalGenitals' 	and o.value_numeric = '2' then 'Organes genitaux : Anormal' 
when c.short_name = 'physicalMembers' 	and o.value_numeric = '2' then 'Membres : Anormal' 
when c.short_name = 'physicalAnus'		and o.value_numeric = '2'	then 'Anus : Anormal'
when c.short_name = 'physicalNeurological' 		and o.value_numeric = '2' then 'Examen neurologique : Anormal'
when c.short_name = 'physicalCervical' 			and o.value_numeric = '2' then 'Cervicale : Lymphadenopathy present' 
when c.short_name = 'physicalSupraclavicular'		and o.value_numeric = '2' then 'Supraclaviculaire : Lymphadenopathy present' 
when c.short_name = 'physicalAxillary' 			and o.value_numeric = '2' then 'Axilaire : Lymphadenopathy present' 
when c.short_name = 'physicalInguinal' 			and o.value_numeric = '2' then 'Inguinale : Lymphadenopathy present' 
when c.short_name = 'otherExamComment123'			then o.value_text else 'xxx'
end as examen
FROM `obs` o, concept c, encValidAll e  WHERE  e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and c.short_name in('physicalHead','physicalNose','physicalMouth','physicalEar','physicalCollar','physicalHeart','physicalGenitals','physicalMembers','physicalRectum','physicalNeurological','physicalCervical','physicalSupraclavicular','physicalAxillary','physicalInguinal','otherExamComment123','physicalAnus') and o.value_numeric =2 and encounterType = 29 and e.patientid = '".$pid."' 
union SELECT visitdate as 'Date de visite', case 
when c.short_name = 'physicalTanner' 		and o.value_numeric = '2' then concat('Tanner S : ', p.value_text,' P: ',q.value_text, ' Anormal') 
end as examen
FROM `obs` o, concept c, obs p, concept d, obs q, concept f, encValidAll e  WHERE d.short_name = 'tannerS' and f.short_name = 'tannerP' and e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.sitecode = p.location_id and e.encounter_id = p.encounter_id and p.concept_id = d.concept_id and e.sitecode = q.location_id and e.encounter_id = q.encounter_id and q.concept_id = f.concept_id and c.short_name = 'physicalTanner' and o.value_numeric =2 and encounterType = 29 and e.patientid = '".$pid."' 
union SELECT visitdate, case  
when physicalEyes = '2' 				then 'Yeux : Anormal' else 'xxx'
end as Yeux
FROM a_vitals where patientID='".$pid."' and encounterType = 29 and physicalEyes in(2)
union SELECT visitdate, case
when physicalLungs = '2' 				then 'Poumons : Anormal' else 'xxx'
end as Poumons
FROM a_vitals where patientID='".$pid."' and encounterType = 29 and physicalLungs in(2)
union SELECT visitdate, case
when physicalAbdomen = '2'				then 'Abdomen : Anormal' else 'xxx'
end as Abdomen
FROM a_vitals where patientID='".$pid."' and encounterType = 29 and physicalAbdomen in(2)
union SELECT visitdate, case
when physicalSkin = '2' 				then 'Peau : Anormal'  else 'xxx'
end as Peau
FROM a_vitals where patientID='".$pid."' and encounterType = 29 and physicalSkin in(2) order by 1 desc",
	   "tphysEx" => "SELECT visitdate as 'Date de visite', case when short_name = 'physicalHead' and value_numeric = '2' then 'Tete : Anormal' when short_name = 'physicalNose' and value_numeric = '2' then 'Nez : Anormal' when short_name = 'physicalMouth' and value_numeric = '2' then 'Bouche : Anormal' when short_name = 'physicalEar' and value_numeric = '2' then 'Oreille : Anormal' when short_name = 'physicalCollar' and value_numeric = '2' then 'Cou : Anormal' when short_name = 'physicalHeart' and value_numeric = '2' then 'Coeur : Anormal' when short_name = 'physicalGenitals' 	and value_numeric = '2' then 'Organes genitaux : Anormal' when short_name = 'physicalMembers' and value_numeric = '2' then 'Membres : Anormal' when short_name = 'physicalRectum' and value_numeric = '2' then 'Toucher rectal : Anormal' when short_name = 'physicalNeurological' and value_numeric = '2' then 'Examen neurologique : Anormal' when short_name = 'physicalCervical' and value_numeric = '2' then 'Cervicale : Lymphadenopathy present' when short_name = 'physicalSupraclavicular'	and value_numeric = '2' then 'Supraclaviculaire : Lymphadenopathy present' when short_name = 'physicalAxillary' and value_numeric = '2' then 'Axilaire : Lymphadenopathy present' when short_name = 'physicalInguinal' and value_numeric = '2' then 'Inguinale : Lymphadenopathy present' when short_name = 'otherExamComment123' then value_text else 'xxx' end as examen FROM `obs` o, concept c, encValidAll e  WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 28 and short_name in('physicalHead','physicalNose','physicalMouth','physicalEar','physicalCollar','physicalHeart','physicalGenitals','physicalMembers','physicalRectum','physicalNeurological','physicalCervical','physicalSupraclavicular','physicalAxillary','physicalInguinal','otherExamComment123') and (value_numeric in(2) or value_text is not null) and e.patientid = '".$pid."' union SELECT visitdate, case when physicalEyes = '2' then 'Yeux : Anormal' else 'xxx' end as Yeux FROM a_vitals where patientID='".$pid."' and physicalEyes in(2) and encounterType = 28 union SELECT visitdate, case when physicalLungs = '2' then 'Poumons : Anormal' else 'xxx' end as Poumons FROM a_vitals where patientID='".$pid."' and physicalLungs in(2) and encounterType = 28 union SELECT visitdate, case when physicalAbdomen = '2' then 'Abdomen : Anormal' else 'xxx' end as Abdomen FROM a_vitals where patientID='".$pid."' and physicalAbdomen in(2) and encounterType = 28 union SELECT visitdate, case when physicalSkin = '2' then 'Peau : Anormal'  else 'xxx' end as Peau FROM a_vitals where patientID='".$pid."' and physicalSkin in(2) and encounterType = 28 order by 1 desc limit 6",
	   "tpedPhysEx" => "SELECT visitdate as 'Date de visite', case 
when c.short_name = 'physicalHead' 		and o.value_numeric = '2' then 'Tete : Anormal'
when c.short_name = 'physicalNose' 		and o.value_numeric = '2' then 'Nez : Anormal' 
when c.short_name = 'physicalMouth' 		and o.value_numeric = '2' then 'Bouche : Anormal' 
when c.short_name = 'physicalEar' 		and o.value_numeric = '2' then 'Oreille : Anormal' 
when c.short_name = 'physicalCollar' 		and o.value_numeric = '2' then 'Cou : Anormal' 
when c.short_name = 'physicalHeart' 		and o.value_numeric = '2' then 'Coeur : Anormal' 
when c.short_name = 'physicalGenitals' 	and o.value_numeric = '2' then 'Organes genitaux : Anormal' 
when c.short_name = 'physicalMembers' 	and o.value_numeric = '2' then 'Membres : Anormal' 
when c.short_name = 'physicalAnus'		and o.value_numeric = '2'	then 'Anus : Anormal'
when c.short_name = 'physicalNeurological' 		and o.value_numeric = '2' then 'Examen neurologique : Anormal'
when c.short_name = 'physicalCervical' 			and o.value_numeric = '2' then 'Cervicale : Lymphadenopathy present' 
when c.short_name = 'physicalSupraclavicular'		and o.value_numeric = '2' then 'Supraclaviculaire : Lymphadenopathy present' 
when c.short_name = 'physicalAxillary' 			and o.value_numeric = '2' then 'Axilaire : Lymphadenopathy present' 
when c.short_name = 'physicalInguinal' 			and o.value_numeric = '2' then 'Inguinale : Lymphadenopathy present' 
when c.short_name = 'otherExamComment123'			then o.value_text else 'xxx'
end as examen
FROM `obs` o, concept c, encValidAll e  WHERE  e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and c.short_name in('physicalHead','physicalNose','physicalMouth','physicalEar','physicalCollar','physicalHeart','physicalGenitals','physicalMembers','physicalRectum','physicalNeurological','physicalCervical','physicalSupraclavicular','physicalAxillary','physicalInguinal','otherExamComment123','physicalAnus') and o.value_numeric =2 and encounterType = 31 and e.patientid = '".$pid."' 
union SELECT visitdate as 'Date de visite', case 
when c.short_name = 'physicalTanner' 		and o.value_numeric = '2' then concat('Tanner S : ', p.value_text,' P: ',q.value_text, ' Anormal') 
end as examen
FROM `obs` o, concept c, obs p, concept d, obs q, concept f, encValidAll e  WHERE d.short_name = 'tannerS' and f.short_name = 'tannerP' and e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.sitecode = p.location_id and e.encounter_id = p.encounter_id and p.concept_id = d.concept_id and e.sitecode = q.location_id and e.encounter_id = q.encounter_id and q.concept_id = f.concept_id and c.short_name = 'physicalTanner' and o.value_numeric =2 and encounterType = 31 and e.patientid = '".$pid."' 
union SELECT visitdate, case  
when physicalEyes = '2' 				then 'Yeux : Anormal' else 'xxx'
end as Yeux
FROM a_vitals where patientID='".$pid."' and encounterType = 31 and physicalEyes in(2)
union SELECT visitdate, case
when physicalLungs = '2' 				then 'Poumons : Anormal' else 'xxx'
end as Poumons
FROM a_vitals where patientID='".$pid."' and encounterType = 31 and physicalLungs in(2)
union SELECT visitdate, case
when physicalAbdomen = '2'				then 'Abdomen : Anormal' else 'xxx'
end as Abdomen
FROM a_vitals where patientID='".$pid."' and encounterType = 31 and physicalAbdomen in(2)
union SELECT visitdate, case
when physicalSkin = '2' 				then 'Peau : Anormal'  else 'xxx'
end as Peau
FROM a_vitals where patientID='".$pid."' and encounterType = 31 and physicalSkin in(2) order by 1 desc",
	   "tobPhysEx" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'physicalHead' 		and value_numeric = '2' then 'Tete : Anormal' 
when short_name = 'physicalNeck' 		and value_numeric = '2' then 'Cou + Thyroide : Anormal' 
when short_name = 'physicalHeart' 		and value_numeric = '2' then 'Coeur : Anormal' 
when short_name = 'physicalCentres'		and value_numeric = '2'	then 'Seins : Anormal'
when short_name = 'physicalUterine' 	and value_numeric = '2' then 'Uterus : Anormal'
when short_name = 'physicalExternalGenitals' 	and value_numeric = '2' then 'Organes genitaux Externes : Anormal' 
when short_name = 'physicalVagina'		and value_numeric = '2' then 'Vagin : Anormal'
when short_name = 'physicalCollar'		and value_numeric = '2'	then 'Col : Anormal'
when short_name = 'physicalAppendices'	and value_numeric = '2' then 'Annexes : Anormal' 
when short_name = 'physicalMembers' 	and value_numeric = '2' then 'Membres : Anormal' 
when short_name = 'physicalRectum' 		and value_numeric = '2' then 'Toucher rectal : Anormal' 
when short_name = 'physicalTendonReflexes'		and value_numeric = '2' then 'Reflexes Osteo-Tendineux'
when short_name = 'physicalCervical' 			and value_numeric = '2' then 'Cervicale : Lymphadenopathy present' 
when short_name = 'physicalSupraclavicular'		and value_numeric = '2' then 'Supraclaviculaire : Lymphadenopathy present' 
when short_name = 'physicalAxillary' 			and value_numeric = '2' then 'Axilaire : Lymphadenopathy present' 
when short_name = 'physicalInguinal' 			and value_numeric = '2' then 'Inguinale : Lymphadenopathy present'
when short_name = 'physicalOtherText'	then concat('Autre : ', value_text) 
when short_name = 'otherExamComment123'			then value_text
when short_name = 'laborFetalHeartRate'		then concat('Rythme cardiaque foetal : ',value_text,'/min')
when short_name = 'laborUterine'		then concat('Hauteur uterine : ', value_text, ' cm')
when short_name = 'examObOedeme'		and value_numeric = '1' then 'Oedeme : oui'
when short_name = 'examObOedeme'		and value_numeric = '2' then 'Oedeme : non'
when short_name = 'laborPresentation'	and value_numeric = '1'	then 'Presentation : Cephalique(C)'
when short_name = 'laborPresentation'	and value_numeric = '2'	then 'Presentation : Siege(S)'
when short_name = 'laborPresentation'	and value_numeric = '4' then 'Presentation : Transversale(T)'
when short_name = 'examObPosition'		and value_numeric = '1' then 'Position : Droite'
when short_name = 'examObPosition'		and value_numeric = '2' then 'Position : Gauche'
when short_name = 'examObContraction'	and value_numeric = '1'	then 'Contraction uterine : oui'
when short_name = 'examObContraction'	and value_numeric = '2'	then 'Contraction uterine : non' else 'xxx'
end as examen
FROM `obs` o, concept c, encValidAll e  WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and short_name in('physicalHead','physicalNeck','physicalHeart','physicalCentres','physicalUterine','physicalExternalGenitals','physicalVagina','physicalCollar','physicalAppendices','physicalMembers','physicalRectum','physicalTendonReflexes','physicalCervical','physicalSupraclavicular','physicalAxillary','physicalInguinal','physicalOtherText','otherExamComment123','laborFetalHeartRate','laborUterine','examObOedeme','laborPresentation','examObPosition','examObContraction') and encounterType = 25 and e.patientid = '".$pid."' 
union SELECT visitdate, case  
when physicalGeneral = '2' 				then 'General : Anormal' else 'xxx'
end as 'General'
FROM a_vitals where patientID='".$pid."' and encounterType = 25 and physicalGeneral in(2)
union SELECT visitdate, case
when physicalLungs = '2' 				then 'Poumons : Anormal' else 'xxx'
end as Poumons
FROM a_vitals where patientID='".$pid."' and encounterType = 25 and physicalLungs in(2)
union SELECT visitdate, case
when physicalAbdomen = '2'				then 'Abdomen : Anormal' else 'xxx'
end as Abdomen
FROM a_vitals where patientID='".$pid."' and encounterType = 25 and physicalAbdomen in(2)
union SELECT visitdate, case
when physicalSkin = '2' 				then 'Peau : Anormal'  else 'xxx'
end as Peau
FROM a_vitals where patientID='".$pid."' and encounterType = 25 and physicalSkin in(2) order by 1 desc limit 6",
	   "pedPsychoDev" => "SELECT visitdate as 'Date de visite', case
when short_name = 'psychomotorGrossMotor'	and value_numeric = 1 then 'Motricite globale : Developpement normal pour age'
when short_name = 'psychomotorGrossMotor'	and value_numeric = 2 then 'Motricite globale : Retard du developpement'
when short_name = 'psychomotorFineMotor'	and value_numeric = 1 then 'Motricite fine : Developpement normal pour age'
when short_name = 'psychomotorFineMotor'	and value_numeric = 2 then 'Motricite fine : Retard du developpement'
when short_name = 'psychomotorLanguageComprehension'	and value_numeric = 1 then 'Langage/Comprehension : Developpement normal pour age'
when short_name = 'psychomotorLanguageComprehension'	and value_numeric = 2 then 'Langage/Comprehension : Retard du developpement'
when short_name = 'psychomotorSocialContact'	and value_numeric = 1 then 'Contact social : Developpement normal pour age'
when short_name = 'psychomotorSocialContact'	and value_numeric = 2 then 'Contact social : Retard du developpement'
end as evaluation
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 29 and short_name in('psychomotorGrossMotor','psychomotorFineMotor','psychomotorLanguageComprehension','psychomotorSocialContact') and e.patientid = '".$pid."' order by 1 desc 
",
	   "tpedPsychoDev" => "SELECT visitdate as 'Date de visite', case
when short_name = 'psychomotorGrossMotor'	and value_numeric = 1 then 'Motricite globale : Developpement normal pour age'
when short_name = 'psychomotorGrossMotor'	and value_numeric = 2 then 'Motricite globale : Retard du developpement'
when short_name = 'psychomotorFineMotor'	and value_numeric = 1 then 'Motricite fine : Developpement normal pour age'
when short_name = 'psychomotorFineMotor'	and value_numeric = 2 then 'Motricite fine : Retard du developpement'
when short_name = 'psychomotorLanguageComprehension'	and value_numeric = 1 then 'Langage/Comprehension : Developpement normal pour age'
when short_name = 'psychomotorLanguageComprehension'	and value_numeric = 2 then 'Langage/Comprehension : Retard du developpement'
when short_name = 'psychomotorSocialContact'	and value_numeric = 1 then 'Contact social : Developpement normal pour age'
when short_name = 'psychomotorSocialContact'	and value_numeric = 2 then 'Contact social : Retard du developpement'
end as evaluation
FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and encounterType = 31 and short_name in('psychomotorGrossMotor','psychomotorFineMotor','psychomotorLanguageComprehension','psychomotorSocialContact') and e.patientid = '".$pid."' order by 1 desc limit 6 
",
	   "diag" => "SELECT visitdate as 'Date de visite', case when short_name = 'stroke' then 'Accident cerebro-vasculaire' when short_name = 'anemia_specify' then concat('anemie:',' ',value_text) when short_name = 'asthmaDx' then 'Asthme' when short_name = 'cardiopathy' then 'Cardiopathie' when short_name = 'diabete1' then 'Diabete type 1' when short_name = 'diabete2' then 'Diabete type 2' when short_name = 'diarrheeAqueuse' then 'Diarrhee aigue aqueuse' when short_name = 'diarrheeSanguin'    then 'Diarrhee aigue sanguinolente' when short_name = 'sicklecell' then 'Drepanocytose' when short_name = 'epilepsy' then 'Epilepsie' when short_name = 'feverIndeter' then 'Fievre, cause indeterminee' when short_name = 'grossesse' then 'Grossesse' when short_name = 'hypertensionArtery' then 'Hypertension arterielle' when short_name = 'malnutritionweightloss'  then 'Malnutrition/Perte de poids' when short_name = 'emergencySurgery' then 'Urgence Chirurgicale' when short_name = 'amygdalite' then 'Amygdalite' when short_name = 'charbon_specify' then concat('Charbon',' ',value_text) when short_name = 'cholera' then 'Cholera' when short_name = 'conjunctivitis_specify'  then concat('Conjonctivite',' ',value_text) when short_name = 'pertusis' then 'Coqueluche' when short_name = 'dengue_specify' then concat('Dengue: ',' ',value_text) when short_name = 'diptheria' then 'Diphterie' when short_name = 'feverHemorrhagicacute'  then 'Fievre hemorragique aigue' when short_name = 'feverTyphoid' then 'Fievre typhoide confirme' when short_name = 'feverTyphoidSuspected' then 'Fievre typhoide suspect' when short_name = 'lymphaticFilariasis' then 'Filariose lymphatique' when short_name = 'scabies' then 'Gale' when short_name = 'infectionAcuteRespiratory' then 'Infection respiratoire aigue' when short_name = 'genUriInfectionDx' then 'Infection genito-urinaire' when short_name = 'infectionTissue' then 'Infection des tissus mous' when short_name = 'ist_specify' then concat('IST',' ',value_text) when short_name = 'lepra' then 'Lepre' when short_name = 'malariaDxSuspected' then 'Malaria (paludisme) suspect' when short_name = 'malariaDx' then 'Malaria (paludisme) confirme' when short_name = 'meningitis_specify' then concat('Meningites: ',' ',value_text) when short_name = 'otitis_specify' then concat('Otite: ',' ',value_text) when short_name = 'parasitose' then 'Parasitose' when short_name = 'pneumonie' then 'Pneumonie' when short_name = 'polio' then 'Poliomyelite' when short_name = 'rage' then 'Rage' when short_name = 'rougeole' then 'Rougeole' when short_name = 'rubella' then 'Rubeole' when short_name = 'febrileSyndrome' then 'Syndrome icterique febrile' when short_name = 'teigne' then 'Teigne' when short_name = 'tetanus' then 'Tetanos' when short_name = 'dxTB' then 'Tuberculose' when short_name = 'dxMDRtb' then 'MDR TB' when short_name = 'varicelle' then 'Varicelle' when short_name = 'hivPositiveN' then 'VIH/SIDA' when short_name = 'psychiatriqueDisorder' then 'Troubles psychiatriques d\'etiologie a investiguer' when short_name = 'stress' then 'Stress post traumatique' when short_name = 'sexAggression' then 'Agression sexuelle' when short_name = 'burns_specify' then concat('Brulure: ',value_text) when short_name = 'boneFracture_specify' then concat('Fracture osseuse: ',value_text) when short_name = 'wound_specify' then concat('Plaie: ',value_text) when short_name = 'traumaHead' then 'Trauma cranien' when short_name = 'cancercervical' then 'Cancer du col' when short_name = 'cancerprostate' then 'Cancer de la prostate' when short_name = 'cancerBreastActive' then 'Cancer de sein' when short_name = 'otherDx1_specify' then concat('Autre: ' ,value_text) when short_name = 'otherDiagnosesComment' then concat('Remarque: ',value_text) else 'xxx' end as diagnostics FROM `obs` o, concept c, encValidAll e  WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and (value_boolean = 1 or value_text is not null) and encounterType = 27 and short_name in ( 'stroke', 'anemia_specify', 'asthmaDx', 'cardiopathy', 'diabete1', 'diabete2', 'diarrheeAqueuse', 'diarrheeSanguin', 'sicklecell', 'epilepsy', 'feverIndeter', 'grossesse', 'hypertensionArtery', 'malnutritionweightloss', 'emergencySurgery', 'amygdalite', 'charbon_specify', 'cholera', 'conjunctivitis_specify', 'pertusis', 'dengue_specify', 'diptheria', 'feverHemorrhagicacute', 'feverTyphoid', 'feverTyphoidSuspected', 'lymphaticFilariasis', 'scabies', 'infectionAcuteRespiratory', 'genUriInfectionDx', 'infectionTissue', 'ist_specify', 'lepra', 'malariaDxSuspected', 'malariaDx', 'meningitis_specify', 'otitis_specify', 'parasitose', 'pneumonie', 'polio', 'rage', 'rougeole', 'rubella', 'febrileSyndrome', 'teigne', 'tetanus', 'dxTB', 'dxMDRtb', 'varicelle', 'hivPositiveN', 'psychiatriqueDisorder', 'stress', 'sexAggression', 'burns_specify', 'boneFracture_specify', 'wound_specify', 'traumaHead', 'cancercervical', 'cancerprostate', 'cancerBreastActive', 'otherDx1_specify', 'otherDiagnosesComment' ) order by 1 desc",
	   "obDiag" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'sexAggression'        then 'Agression sexuelle'  
when short_name = 'adfActive'    then 'Adenofibrome (ADF) du sein'
when short_name = 'anemia'     then 'Anemie'
when short_name = 'avortement_specify'     then concat('Avortement : ', value_text)
when short_name = 'cancerEndoActive'     then 'Cancer de l\'endometre'
when short_name = 'cancerOvaryActive'     then 'Cancer de l\'ovaire'
when short_name = 'cancerBreastActive_specify'    then concat('Cancer de sein : ',value_text)
when short_name = 'cardiopathy_specify'    then concat('Cardiopathie : ',value_text) 
when short_name = 'chorioamniotite'     then 'Chorioamniotite'
when short_name = 'diabetespregnancy_specify'     then concat('Diabete + Grossesse : ', value_text)
when short_name = 'dysOvaryActive_specify'    then concat('Dystrophie ovarienne : ', value_text)
when short_name = 'eclampsia'     then 'Eclampsie'
when short_name = 'endometriosisActive_specify'   then concat('Endometriose : ',value_text)
when short_name = 'fibroidUterineActive_specify'  then concat('Fibrome uterin : ',value_text)
when short_name = 'grossesseEctopique_specify'   then concat('Grossesse ectopique : ', value_text)
when short_name = 'grossesseUterine'     then 'Grossesse intra-uterine'
when short_name = 'htapregnancy'    then 'HTA + Grossesse'
when short_name = 'hemorragie_specify'      then concat('Hemorragie troisieme trimestre : ', value_text)
when short_name = 'hyperGravi'  then 'Hyperemese Gravidique'
when short_name = 'genUriInfectionDx'     then 'Infection genito-urinaire'
when short_name = 'ist_specify'    then concat('IST: ',value_text)
when short_name = 'cystOvaryActive_specify'     then concat('Kyste de l\'ovaire : ', value_text)
when short_name = 'lesionCervicale_specify'  then concat('Lesion cervicale : ', value_text)
when short_name = 'maladiePelvienne'    then 'Maladie inflammatoire pelvienne'
when short_name = 'malariaDxSuspected'  then 'Malaria (paludisme) suspect'
when short_name = 'malariaDx'   then 'Malaria (paludisme) confirme'
when short_name = 'menacePrema'      then 'Menace d\'accouchement prematuree'
when short_name = 'oligoamnios' then 'Oligoamnios'
when short_name = 'pathRenale'   then 'Pathologie renale'
when short_name = 'preEclampsie_specify'    then concat('Pre eclampsie ', value_text)
when short_name = 'retardCroissanceIU'     then 'Retard croissance IntraUterin'
when short_name = 'membraneRupture'      then 'Rupture prematuree des membranes'
when short_name = 'vaginalBleedingAbn'   then 'Saignement uterin anormal'
when short_name = 'syphilis'     then 'Syphilis'
when short_name = 'thrombopenie'   then 'Thrombopenie'
when short_name = 'thrombose'    then 'Thromboses'
when short_name = 'dxTB'     then 'Tuberculose'
when short_name = 'dxMDRtb'     then 'MDR TB'
when short_name = 'travailLatent'      then 'Travail, Latent'
when short_name = 'travailActive'      then 'Travail, Actif'
when short_name = 'hivPositiveN'     then 'VIH/SIDA'
when short_name = 'otherDx_specify'      then concat('Autre : ', value_text)
when short_name = 'otherDx2_specify'    then concat('Autre : ', value_text) else 'xxx'
end as diagnostics
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null) and encounterType = 24 and
short_name in ('sexAggression','adfActive','anemia','avortement_specify','cancerEndoActive','cancerOvaryActive','cancerBreastActive_specify','cardiopathy_specify','chorioamniotite','diabetespregnancy_specify','dysOvaryActive_specify','eclampsia','endometriosisActive_specify','fibroidUterineActive_specify','grossesseEctopique_specify','grossesseUterine','htapregnancy','hemorragie_specify','hyperGravi','genUriInfectionDx','ist_specify','cystOvaryActive_specify','lesionCervicale_specify','maladiePelvienne','malariaDxSuspected','malariaDx','menacePrema','oligoamnios','pathRenale','preEclampsie_specify','retardCroissanceIU','membraneRupture','vaginalBleedingAbn','syphilis','thrombopenie','thrombose','dxTB','dxMDRtb','travailLatent','travailActive','hivPositiveN','otherDx_specify','otherDx2_specify')
order by 1 desc",
	   "pedDiag" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'irondeficiencyanemia'        then 'Anemie Carentielle'  
when short_name = 'scd'    then 'Anemie falciforme'
when short_name = 'asthmaDx'     then 'Asthme'
when short_name = 'bronchitis'     then 'Bronchite'
when short_name = 'cardiopathy'     then 'Cardiopathie'
when short_name = 'febrileseizures'     then 'Crises convulsives febriles'
when short_name = 'malnutritionmild'    then 'Malnutrition aigue legere'
when short_name = 'malnutritionmoderate'    then 'Malnutrition aigue moderee' 
when short_name = 'malnutritionsevere'     then 'Malnutrition aigue severe (compl)'
when short_name = 'malnutritionsevereSS'     then 'Malnutrition aigue severe (SS compl.)'
when short_name = 'atopicdermatitis'    then 'Dermatite atopique'
when short_name = 'diabete1'     then 'Diabete Type 1'
when short_name = 'diarrheeAqueuse'   then 'Diarrhee aigue aqueuse'
when short_name = 'diarrheeSanguin'  then 'Diarrhee aigue sanguinolente'
when short_name = 'diarrheeIndeter'   then 'Diarrhee cause indeterminee'
when short_name = 'sicklecell'     then 'Drepanocytose : SS/SC'
when short_name = 'epilepsy'    then 'Epilepsie'
when short_name = 'feverIndeter'      then 'Fievre cause indeterminee'
when short_name = 'gastroenteritiswithdehydrationmild' then 'Gastro-enterite avec : deshydratation legere'
when short_name = 'gastroenteritiswithdehydrationmoderate'     then 'Gastro-enterite avec : deshydratation moderee'
when short_name = 'gastroenteritiswithdehydrationsevere'    then 'Gastro-enterite avec : deshydratation severe'
when short_name = 'grossesse'     then 'Grossesse'
when short_name = 'obesity'  then 'Obesite'
when short_name = 'raa'    then 'Rhumatisme articulaire aigu'
when short_name = 'allergicrhinitis'  then 'Rhinite allergique'
when short_name = 'gastroesophagealreflux'   then 'Reflux gastro-oesophagien'
when short_name = 'nephroticsyndrome'      then 'Syndrome nephrotique'
when short_name = 'emergencySurgery_specify' then concat('Urgence chirurgicale ', value_text)
when short_name = 'abscess_specify'   then concat('Abces : ', value_text)
when short_name = 'amygdalite'    then 'Amygdalite'
when short_name = 'charbon_specify'     then concat('Charbon ',value_text)
when short_name = 'cholera'      then 'Cholera'
when short_name = 'conjunctivitis_specify'   then concat('Conjonctivite : ', value_text)
when short_name = 'pertusis'     then 'Coqueluche'
when short_name = 'dengue_specify'   then concat('Dengue: ',value_text)
when short_name = 'diptheria'    then 'Diphterie'
when short_name = 'feverHemorrhagicacute'     then 'Fievre hemorragique aigue'
when short_name = 'feverTyphoid'     then 'Fievre typhoide confirmee'
when short_name = 'feverTyphoidSuspected'      then 'Fievre typhoide suspect'
when short_name = 'lymphaticFilariasis'      then 'Filariose lymphatique'
when short_name = 'scabies'     then 'Gale'
when short_name = 'acuteglomerulonephritis'      then 'Glomerulonephrite aigu'
when short_name = 'impetigo'    then 'Impetigo'
when short_name = 'genUriInfectionDx'       then 'Infection genito-urinaire'
when short_name = 'infectionAcuteRespiratory'      then 'Infection respiratoire aigue'
when short_name = 'ist_specify'		then concat('IST: ', value_text)
when short_name = 'lepra'      then 'Lepre'
when short_name = 'malariaDxSuspected'    then 'Malaria (paludisme) suspect'
when short_name = 'malariaDx'      then 'Malaria (paludisme) confirme'
when short_name = 'meningitis_specify'      then concat('Meningites : ', value_text)
when short_name = 'fungalskin_specify'      then concat('Mycose cutanee : ', value_text)
when short_name = 'otitis_specify'      then concat('Otite : ', value_text)
when short_name = 'parasitose'      then 'Parasitose'
when short_name = 'pneumonie'      then 'Pneumonie'
when short_name = 'polio'      then 'Poliomyelite'
when short_name = 'rage'      then 'Rage'
when short_name = 'rougeole'      then 'Rougeole'
when short_name = 'rubella'      then 'Rubeole'
when short_name = 'febrileSyndrome'      then 'Syndrome icterique febrile'
when short_name = 'teigne' then 'Teigne'
when short_name = 'tetanus' then 'Tetanos'
when short_name = 'dxTB'	then 'Tuberculose'
when short_name = 'dxMDRtb' then 'MDR TB'
when short_name = 'varicelle'	then 'Varicelle'
when short_name = 'hivPositiveN'	then 'VIH/SIDA'
when short_name = 'psychiatriqueDisorder' then 'Trouble psychiatrique d\'etiologie a investiguer'
when short_name = 'stress'	then 'Stress post traumatique'
when short_name = 'sexAggression' then 'Agression sexuelle'
when short_name = 'burns_specify'	then concat('Brulure : ',value_text)
when short_name = 'sprain_specify'	then concat('Entorse : ', value_text)
when short_name = 'boneFracture_specify'	then concat('Fracture osseuse : ', value_text)
when short_name = 'dislocation_specify'	then concat('Luxation : ', value_text)
when short_name = 'wound_specify'	then concat('Plaie : ', value_text)
when short_name = 'polytrauma'	then 'Poly traumatisme'
when short_name = 'traumaHead'	then 'Trauma cranien'
when short_name = 'otherDx1_specify'	then concat('Autre : ', value_text)
when short_name = 'otherDx2_specify'	then concat('Autre : ', value_text)
when short_name = 'otherDiagnosesComment'	then concat('Remarque : ', value_text) else 'xxx'
end as diagnostics
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null) and encounterType = 29 and
short_name in ( 'irondeficiencyanemia', 'scd', 'asthmaDx', 'bronchitis', 'cardiopathy', 'febrileseizures', 'malnutritionmild', 'malnutritionmoderate', 'malnutritionsevere', 'malnutritionsevereSS', 'atopicdermatitis', 'diabete1', 'diarrheeAqueuse', 'diarrheeSanguin', 'diarrheeIndeter', 'sicklecell', 'epilepsy', 'feverIndeter', 'gastroenteritiswithdehydrationmild', 'gastroenteritiswithdehydrationmoderate', 'gastroenteritiswithdehydrationsevere', 'grossesse', 'obesity', 'raa', 'allergicrhinitis', 'gastroesophagealreflux', 'nephroticsyndrome', 'emergencySurgery_specify', 'abscess_specify', 'amygdalite', 'charbon_specify', 'cholera', 'conjunctivitis_specify', 'pertusis', 'dengue_specify', 'diptheria', 'feverHemorrhagicacute', 'feverTyphoid', 'feverTyphoidSuspected', 'lymphaticFilariasis', 'scabies', 'acuteglomerulonephritis', 'impetigo', 'genUriInfectionDx', 'infectionAcuteRespiratory', 'ist_specify', 'lepra', 'malariaDxSuspected', 'malariaDx', 'meningitis_specify', 'fungalskin_specify', 'otitis_specify', 'parasitose', 'pneumonie', 'polio', 'rage', 'rougeole', 'rubella', 'febrileSyndrome', 'teigne', 'tetanus','dxTB','dxMDRtb','varicelle','hivPositiveN','psychiatriqueDisorder','stress','sexAggression','burns_specify','sprain_specify','boneFracture_specify','dislocation_specify','wound_specify','polytrauma','traumaHead','otherDx1_specify','otherDx2_specify','otherDiagnosesComment')
order by 1 desc",
	   "tdiag" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'stroke' then 'Accident cerebro-vasculaire'
when short_name = 'strokeA' then 'Accident cerebro-vasculaire : Actif'
when short_name = 'strokeG' then 'Accident cerebro-vasculaire : Gueri' 
when short_name = 'anemia_specify' then concat('anemie:',' ',value_text) 
when short_name = 'anemia_specifyA' then concat('anemie:',' ',value_text,' : Actif') 
when short_name = 'anemia_specifyG' then concat('anemie:',' ',value_text,' : Gueri') 
when short_name = 'asthmaDx' then 'Asthme' 
when short_name = 'asthmaDxA' then 'Asthme : Actif' 
when short_name = 'asthmaDxG' then 'Asthme : Gueri' 
when short_name = 'cardiopathy' then 'Cardiopathie'
when short_name = 'cardiopathyA' then 'Cardiopathie : Actif'
when short_name = 'cardiopathyG' then 'Cardiopathie : Gueri' 
when short_name = 'diabete1' then 'Diabete type 1'
when short_name = 'diabete1A' then 'Diabete type 1 : Actif'
when short_name = 'diabete1G' then 'Diabete type 1 : Gueri' 
when short_name = 'diabete2' then 'Diabete type 2' 
when short_name = 'diabete2A' then 'Diabete type 2 : Actif'
when short_name = 'diabete2G' then 'Diabete type 2 : Gueri'
when short_name = 'diarrheeAqueuse' then 'Diarrhee aigue aqueuse'
when short_name = 'diarrheeAqueuseA' then 'Diarrhee aigue aqueuse : Actif'
when short_name = 'diarrheeAqueuseG' then 'Diarrhee aigue aqueuse : Gueri' 
when short_name = 'diarrheeSanguin'    then 'Diarrhee aigue sanguinolente'
when short_name = 'diarrheeSanguinA'    then 'Diarrhee aigue sanguinolente : Actif'
when short_name = 'diarrheeSanguinG'    then 'Diarrhee aigue sanguinolente : Gueri' 
when short_name = 'sicklecell' then 'Drepanocytose' 
when short_name = 'sicklecellA' then 'Drepanocytose : Actif'
when short_name = 'sicklecellG' then 'Drepanocytose : Gueri'
when short_name = 'epilepsy' then 'Epilepsie'
when short_name = 'epilepsyA' then 'Epilepsie : Actif'
when short_name = 'epilepsyG' then 'Epilepsie : Gueri' 
when short_name = 'feverIndeter' then 'Fievre, cause indeterminee' 
when short_name = 'feverIndeterA' then 'Fievre, cause indeterminee : Actif'
when short_name = 'feverIndeterG' then 'Fievre, cause indeterminee : Gueri'
when short_name = 'grossesse' then 'Grossesse'
when short_name = 'grossesseA' then 'Grossesse : Actif'
when short_name = 'grossesseG' then 'Grossesse : Gueri' 
when short_name = 'hypertensionArtery' then 'Hypertension arterielle' 
when short_name = 'hypertensionArteryA' then 'Hypertension arterielle : Actif'
when short_name = 'hypertensionArteryG' then 'Hypertension arterielle : Gueri'
when short_name = 'malnutritionweightloss'  then 'Malnutrition/Perte de poids'
when short_name = 'malnutritionweightlossA'  then 'Malnutrition/Perte de poids : Actif' 
when short_name = 'malnutritionweightlossG'  then 'Malnutrition/Perte de poids : Gueri'  
when short_name = 'emergencySurgery' then 'Urgence Chirurgicale' 
when short_name = 'emergencySurgeryA' then 'Urgence Chirurgicale : Actif' 
when short_name = 'emergencySurgeryG' then 'Urgence Chirurgicale : Gueri' 
when short_name = 'amygdalite' then 'Amygdalite' 
when short_name = 'amygdaliteA' then 'Amygdalite : Actif'
when short_name = 'amygdaliteG' then 'Amygdalite : Gueri'
when short_name = 'charbon_specify' then concat('Charbon',' ',value_text) 
when short_name = 'charbon_specifyA' then concat('Charbon',' ',value_text,' : Actif') 
when short_name = 'charbon_specifyG' then concat('Charbon',' ',value_text,' : Gueri') 
when short_name = 'cholera' then 'Cholera' 
when short_name = 'choleraA' then 'Cholera : Actif'
when short_name = 'choleraG' then 'Cholera : Gueri'
when short_name = 'conjunctivitis_specify'  then concat('Conjonctivite',' ',value_text)
when short_name = 'conjunctivitis_specifyA'  then concat('Conjonctivite',' ',value_text,' : Actif')
when short_name = 'conjunctivitis_specifyG'  then concat('Conjonctivite',' ',value_text,' : Gueri') 
when short_name = 'pertusis' then 'Coqueluche' 
when short_name = 'pertusisA' then 'Coqueluche : Actif'
when short_name = 'pertusisG' then 'Coqueluche : Gueri'
when short_name = 'dengue_specify' then concat('Dengue: ',' ',value_text) 
when short_name = 'dengue_specifyA' then concat('Dengue: ',' ',value_text,' : Actif') 
when short_name = 'dengue_specifyG' then concat('Dengue: ',' ',value_text,' : Gueri') 
when short_name = 'diptheria' then 'Diphterie'
when short_name = 'diptheriaA' then 'Diphterie : Actif'
when short_name = 'diptheriaG' then 'Diphterie : Gueri' 
when short_name = 'feverHemorrhagicacute'  then 'Fievre hemorragique aigue' 
when short_name = 'feverHemorrhagicacuteA'  then 'Fievre hemorragique aigue : Actif' 
when short_name = 'feverHemorrhagicacuteG'  then 'Fievre hemorragique aigue : Gueri' 
when short_name = 'feverTyphoid' then 'Fievre typhoide confirme' 
when short_name = 'feverTyphoidA' then 'Fievre typhoide confirme : Actif' 
when short_name = 'feverTyphoidG' then 'Fievre typhoide confirme : Gueri' 
when short_name = 'feverTyphoidSuspected' then 'Fievre typhoide suspect' 
when short_name = 'feverTyphoidSuspectedA' then 'Fievre typhoide suspect : Actif' 
when short_name = 'feverTyphoidSuspectedG' then 'Fievre typhoide suspect : Gueri' 
when short_name = 'lymphaticFilariasis' then 'Filariose lymphatique' 
when short_name = 'lymphaticFilariasisA' then 'Filariose lymphatique : Actif' 
when short_name = 'lymphaticFilariasisG' then 'Filariose lymphatique : Gueri' 
when short_name = 'scabies' then 'Gale' 
when short_name = 'scabiesA' then 'Gale : Actif' 
when short_name = 'scabiesG' then 'Gale : Gueri' 
when short_name = 'infectionAcuteRespiratory' then 'Infection respiratoire aigue' 
when short_name = 'infectionAcuteRespiratoryA' then 'Infection respiratoire aigue : Actif' 
when short_name = 'infectionAcuteRespiratoryG' then 'Infection respiratoire aigue : Gueri' 
when short_name = 'genUriInfectionDx' then 'Infection genito-urinaire' 
when short_name = 'genUriInfectionDxA' then 'Infection genito-urinaire : Actif' 
when short_name = 'genUriInfectionDxG' then 'Infection genito-urinaire : Gueri' 
when short_name = 'infectionTissue' then 'Infection des tissus mous'
when short_name = 'infectionTissueA' then 'Infection des tissus mous : Actif'
when short_name = 'infectionTissueG' then 'Infection des tissus mous : Gueri' 
when short_name = 'ist_specify' then concat('IST',' ',value_text) 
when short_name = 'ist_specify' then concat('IST',' ',value_text,' : Actif') 
when short_name = 'ist_specify' then concat('IST',' ',value_text,' : Gueri') 
when short_name = 'lepra' then 'Lepre' 
when short_name = 'lepraA' then 'Lepre : Actif'
when short_name = 'lepraG' then 'Lepre : Gueri'
when short_name = 'malariaDxSuspected' then 'Malaria (paludisme) suspect' 
when short_name = 'malariaDxSuspectedA' then 'Malaria (paludisme) suspect : Actif' 
when short_name = 'malariaDxSuspectedG' then 'Malaria (paludisme) suspect : Gueri' 
when short_name = 'malariaDx' then 'Malaria (paludisme) confirme'
when short_name = 'malariaDxA' then 'Malaria (paludisme) confirme : Actif'
when short_name = 'malariaDxG' then 'Malaria (paludisme) confirme : Gueri' 
when short_name = 'meningitis_specify' then concat('Meningites: ',' ',value_text)
when short_name = 'meningitis_specifyA' then concat('Meningites: ',' ',value_text,' : Actif')
when short_name = 'meningitis_specifyG' then concat('Meningites: ',' ',value_text,' : Gueri') 
when short_name = 'otitis_specify' then concat('Otite: ',' ',value_text)
when short_name = 'otitis_specifyA' then concat('Otite: ',' ',value_text,' : Actif')
when short_name = 'otitis_specifyG' then concat('Otite: ',' ',value_text,' : Gueri') 
when short_name = 'parasitose' then 'Parasitose' 
when short_name = 'parasitoseA' then 'Parasitose : Actif'
when short_name = 'parasitoseG' then 'Parasitose : Gueri'
when short_name = 'pneumonie' then 'Pneumonie' 
when short_name = 'pneumonieA' then 'Pneumonie : Actif'
when short_name = 'pneumonieG' then 'Pneumonie : Gueri'
when short_name = 'polio' then 'Poliomyelite'
when short_name = 'polioA' then 'Poliomyelite : Actif'
when short_name = 'polioG' then 'Poliomyelite : Gueri' 
when short_name = 'rage' then 'Rage'
when short_name = 'rageA' then 'Rage : Actif' 
when short_name = 'rageG' then 'Rage : Gueri' 
when short_name = 'rougeole' then 'Rougeole' 
when short_name = 'rougeoleA' then 'Rougeole : Actif'
when short_name = 'rougeoleG' then 'Rougeole : Gueri'
when short_name = 'rubella' then 'Rubeole' 
when short_name = 'rubellaA' then 'Rubeole : Actif'
when short_name = 'rubellaG' then 'Rubeole : Gueri'
when short_name = 'febrileSyndrome' then 'Syndrome icterique febrile' 
when short_name = 'febrileSyndromeA' then 'Syndrome icterique febrile : Actif' 
when short_name = 'febrileSyndromeG' then 'Syndrome icterique febrile : Gueri' 
when short_name = 'teigne' then 'Teigne' 
when short_name = 'teigneA' then 'Teigne : Actif' 
when short_name = 'teigneG' then 'Teigne : Gueri' 
when short_name = 'tetanus' then 'Tetanos'
when short_name = 'tetanusA' then 'Tetanos : Actif'
when short_name = 'tetanusG' then 'Tetanos : Gueri' 
when short_name = 'dxTB' then 'Tuberculose' 
when short_name = 'dxTBA' then 'Tuberculose : Actif' 
when short_name = 'dxTBG' then 'Tuberculose : Gueri' 
when short_name = 'dxMDRtb' then 'MDR TB'
when short_name = 'dxMDRtbA' then 'MDR TB : Actif'
when short_name = 'dxMDRtbG' then 'MDR TB : Gueri' 
when short_name = 'varicelle' then 'Varicelle' 
when short_name = 'varicelleA' then 'Varicelle : Actif'
when short_name = 'varicelleG' then 'Varicelle : Gueri'
when short_name = 'hivPositiveN' then 'VIH/SIDA' 
when short_name = 'hivPositiveNA' then 'VIH/SIDA : Actif'
when short_name = 'hivPositiveNG' then 'VIH/SIDA : Gueri'
when short_name = 'psychiatriqueDisorder' then 'Troubles psychiatriques d\'etiologie a investiguer' 
when short_name = 'psychiatriqueDisorderA' then 'Troubles psychiatriques d\'etiologie a investiguer : Actif' 
when short_name = 'psychiatriqueDisorderG' then 'Troubles psychiatriques d\'etiologie a investiguer : Gueri' 
when short_name = 'stress' then 'Stress post traumatique' 
when short_name = 'stressA' then 'Stress post traumatique : Actif' 
when short_name = 'stressG' then 'Stress post traumatique : Gueri' 
when short_name = 'sexAggression' then 'Agression sexuelle' 
when short_name = 'sexAggressionA' then 'Agression sexuelle : Actif' 
when short_name = 'sexAggressionG' then 'Agression sexuelle : Gueri' 
when short_name = 'burns_specify' then concat('Brulure: ',value_text) 
when short_name = 'burns_specifyA' then concat('Brulure: ',value_text,' : Actif') 
when short_name = 'burns_specifyG' then concat('Brulure: ',value_text,' : Gueri') 
when short_name = 'boneFracture_specify' then concat('Fracture osseuse: ',value_text) 
when short_name = 'boneFracture_specifyA' then concat('Fracture osseuse: ',value_text,' : Actif') 
when short_name = 'boneFracture_specifyG' then concat('Fracture osseuse: ',value_text,' : Gueri') 
when short_name = 'wound_specify' then concat('Plaie: ',value_text) 
when short_name = 'wound_specifyA' then concat('Plaie: ',value_text,' : Actif')
when short_name = 'wound_specifyG' then concat('Plaie: ',value_text,' : Gueri')
when short_name = 'traumaHead' then 'Trauma cranien' 
when short_name = 'traumaHeadA' then 'Trauma cranien : Actif' 
when short_name = 'traumaHeadG' then 'Trauma cranien : Gueri' 
when short_name = 'cancercervical' then 'Cancer du col'
when short_name = 'cancercervicalA' then 'Cancer du col : Actif'
when short_name = 'cancercervicalG' then 'Cancer du col : Gueri' 
when short_name = 'cancerprostate' then 'Cancer de la prostate' 
when short_name = 'cancerprostateA' then 'Cancer de la prostate : Actif' 
when short_name = 'cancerprostateG' then 'Cancer de la prostate : Gueri' 
when short_name = 'cancerBreastActive' then 'Cancer de sein' 
when short_name = 'cancerBreastActiveA' then 'Cancer de sein : Actif' 
when short_name = 'cancerBreastActiveG' then 'Cancer de sein : Gueri' 
when short_name = 'otherDx1_specify' then concat('Autre: ' ,value_text)
when short_name = 'otherDx1_specifyA' then concat('Autre: ' ,value_text,' : Actif') 
when short_name = 'otherDx1_specifyG' then concat('Autre: ' ,value_text,' : Gueri')  
when short_name = 'otherDiagnosesComment' then concat('Remarque: ',value_text)
when short_name = 'otherDiagnosesCommentA' then concat('Remarque: ',value_text,' : Actif')
when short_name = 'otherDiagnosesCommentG' then concat('Remarque: ',value_text,' : Gueri') else 'xxx' end as diagnostics FROM `obs` o, concept c, encValidAll e  WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and (value_boolean = 1 or value_text is not null) and encounterType = 28 and short_name in ( 'stroke','strokeA','strokeG', 'anemia_specify','anemia_specifyA','anemia_specifyG', 'asthmaDx','asthmaDxA','asthmaDxG', 'cardiopathy', 'cardiopathyA','cardiopathyG','diabete1', 'diabete1A','diabete1G','diabete2', 'diabete2A','diabete2G','diarrheeAqueuse', 'diarrheeAqueuseA','diarrheeAqueuseG','diarrheeSanguin','diarrheeSanguinA','diarrheeSanguinG', 'sicklecell','sicklecellA','sicklecellG', 'epilepsy','epilepsyA','epilepsyG', 'feverIndeter','feverIndeterA','feverIndeterG', 'grossesse','grossesseA','grossesseG', 'hypertensionArtery','hypertensionArteryA','hypertensionArteryG', 'malnutritionweightloss', 'malnutritionweightlossA','malnutritionweightlossG','emergencySurgery','emergencySurgeryA','emergencySurgeryG', 'amygdalite','amygdaliteA','amygdaliteG', 'charbon_specify','charbon_specifyA','charbon_specifyG', 'cholera','choleraA','choleraG', 'conjunctivitis_specify','conjunctivitis_specifyA','conjunctivitis_specifyG', 'pertusis','pertusisA','pertusisG', 'dengue_specify','dengue_specifyA','dengue_specifyG', 'diptheria','diptheriaA','diptheriaG', 'feverHemorrhagicacute','feverHemorrhagicacuteA','feverHemorrhagicacuteG', 'feverTyphoid','feverTyphoidA','feverTyphoidG', 'feverTyphoidSuspected','feverTyphoidSuspectedA','feverTyphoidSuspectedG', 'lymphaticFilariasis','lymphaticFilariasisA','lymphaticFilariasisG', 'scabies','scabiesA','scabiesG', 'infectionAcuteRespiratory', 'infectionAcuteRespiratoryA','infectionAcuteRespiratoryG','genUriInfectionDx','genUriInfectionDxA','genUriInfectionDxG', 'infectionTissue','infectionTissueA','infectionTissueG', 'ist_specify','ist_specifyA','ist_specifyG', 'lepra', 'lepraA', 'lepraG', 'malariaDxSuspected','malariaDxSuspectedA','malariaDxSuspectedG', 'malariaDx','malariaDxA','malariaDxG', 'meningitis_specify','meningitis_specifyA','meningitis_specifyG', 'otitis_specify', 'otitis_specifyA','otitis_specifyG','parasitose','parasitoseA','parasitoseG', 'pneumonie','pneumonieA','pneumonieG', 'polio','polioA','polioG', 'rage','rageA','rageG', 'rougeole','rougeoleA','rougeoleG', 'rubella', 'rubellaA','rubellaG','febrileSyndrome','febrileSyndromeA','febrileSyndromeG', 'teigne','teigneA','teigneG', 'tetanus','tetanusA','tetanusG', 'dxTB','dxTBA','dxTBG', 'dxMDRtb','dxMDRtbA', 'dxMDRtbG',  'varicelle','varicelleA','varicelleG', 'hivPositiveN','hivPositiveNA','hivPositiveNG', 'psychiatriqueDisorder','psychiatriqueDisorderA','psychiatriqueDisorderG', 'stress','stressA','stressG', 'sexAggression','sexAggressionA','sexAggressionG', 'burns_specify','burns_specifyA','burns_specifyG', 'boneFracture_specify','boneFracture_specifyA','boneFracture_specifyG', 'wound_specify','wound_specifyA','wound_specifyG', 'traumaHead','traumaHeadA','traumaHeadG', 'cancercervical','cancercervicalA','cancercervicalG', 'cancerprostate','cancerprostateA','cancerprostateG', 'cancerBreastActive','cancerBreastActiveA','cancerBreastActiveG', 'otherDx1_specify','otherDx1_specifyA','otherDx1_specifyG', 'otherDiagnosesComment' ) order by 1 desc limit 6",
	   "tpedDiag" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'irondeficiencyanemia'        then 'Anemie Carentielle' 
when short_name = 'irondeficiencyanemiaA'        then 'Anemie Carentielle : Actif'  
when short_name = 'irondeficiencyanemiaG'        then 'Anemie Carentielle : Gueri'   
when short_name = 'scd'    then 'Anemie falciforme'
when short_name = 'scdA'    then 'Anemie falciforme : Actif'
when short_name = 'scdG'    then 'Anemie falciforme : Gueri'
when short_name = 'asthmaDx'     then 'Asthme'
when short_name = 'asthmaDxA'     then 'Asthme : Actif'
when short_name = 'asthmaDxG'     then 'Asthme : Gueri'
when short_name = 'bronchitis'     then 'Bronchite'
when short_name = 'bronchitisA'     then 'Bronchite : Actif'
when short_name = 'bronchitisG'     then 'Bronchite : Gueri'
when short_name = 'cardiopathy'     then 'Cardiopathie'
when short_name = 'cardiopathyA'     then 'Cardiopathie : Actif'
when short_name = 'cardiopathyG'     then 'Cardiopathie : Gueri'
when short_name = 'febrileseizures'     then 'Crises convulsives febriles'
when short_name = 'febrileseizuresA'     then 'Crises convulsives febriles : Actif'
when short_name = 'febrileseizuresG'     then 'Crises convulsives febriles : Gueri'
when short_name = 'malnutritionmild'    then 'Malnutrition aigue legere'
when short_name = 'malnutritionmildA'    then 'Malnutrition aigue legere : Actif'
when short_name = 'malnutritionmildG'    then 'Malnutrition aigue legere : Gueri'
when short_name = 'malnutritionmoderate'    then 'Malnutrition aigue moderee' 
when short_name = 'malnutritionmoderateA'    then 'Malnutrition aigue moderee : Actif' 
when short_name = 'malnutritionmoderateG'    then 'Malnutrition aigue moderee : Gueri' 
when short_name = 'malnutritionsevere'     then 'Malnutrition aigue severe (compl)'
when short_name = 'malnutritionsevereA'     then 'Malnutrition aigue severe (compl) : Actif'
when short_name = 'malnutritionsevereG'     then 'Malnutrition aigue severe (compl) : Gueri'
when short_name = 'malnutritionsevereSS'     then 'Malnutrition aigue severe (SS compl.)'
when short_name = 'malnutritionsevereSSA'     then 'Malnutrition aigue severe (SS compl.) : Actif'
when short_name = 'malnutritionsevereSSG'     then 'Malnutrition aigue severe (SS compl.) : Gueri'
when short_name = 'atopicdermatitis'    then 'Dermatite atopique'
when short_name = 'atopicdermatitisA'    then 'Dermatite atopique : Actif'
when short_name = 'atopicdermatitisG'    then 'Dermatite atopique : Gueri'
when short_name = 'diabete1'     then 'Diabete Type 1'
when short_name = 'diabete1A'     then 'Diabete Type 1 : Actif'
when short_name = 'diabete1G'     then 'Diabete Type 1 : Gueri'
when short_name = 'diarrheeAqueuse'   then 'Diarrhee aigue aqueuse'
when short_name = 'diarrheeAqueuseA'   then 'Diarrhee aigue aqueuse : Actif'
when short_name = 'diarrheeAqueuseG'   then 'Diarrhee aigue aqueuse : Gueri'
when short_name = 'diarrheeSanguin'  then 'Diarrhee aigue sanguinolente'
when short_name = 'diarrheeSanguinA'  then 'Diarrhee aigue sanguinolente : Actif'
when short_name = 'diarrheeSanguinG'  then 'Diarrhee aigue sanguinolente : Gueri'
when short_name = 'diarrheeIndeter'   then 'Diarrhee cause indeterminee'
when short_name = 'diarrheeIndeterA'   then 'Diarrhee cause indeterminee : Actif'
when short_name = 'diarrheeIndeterG'   then 'Diarrhee cause indeterminee : Gueri'
when short_name = 'sicklecell'     then 'Drepanocytose : SS/SC'
when short_name = 'sicklecellA'     then 'Drepanocytose : SS/SC (Actif)'
when short_name = 'sicklecellG'     then 'Drepanocytose : SS/SC (Gueri)'
when short_name = 'epilepsy'    then 'Epilepsie'
when short_name = 'epilepsyA'    then 'Epilepsie : Actif'
when short_name = 'epilepsyG'    then 'Epilepsie : Gueri'
when short_name = 'feverIndeter'      then 'Fievre cause indeterminee'
when short_name = 'feverIndeterA'      then 'Fievre cause indeterminee : Actif'
when short_name = 'feverIndeterG'      then 'Fievre cause indeterminee : Gueri'
when short_name = 'gastroenteritiswithdehydrationmild' then 'Gastro-enterite avec : deshydratation legere'
when short_name = 'gastroenteritiswithdehydrationmildA' then 'Gastro-enterite avec : deshydratation legere (Actif)'
when short_name = 'gastroenteritiswithdehydrationmildG' then 'Gastro-enterite avec : deshydratation legere(Gueri)'
when short_name = 'gastroenteritiswithdehydrationmoderate'     then 'Gastro-enterite avec : deshydratation moderee'
when short_name = 'gastroenteritiswithdehydrationmoderateA'     then 'Gastro-enterite avec : deshydratation moderee (Actif)'
when short_name = 'gastroenteritiswithdehydrationmoderateG'     then 'Gastro-enterite avec : deshydratation moderee (Gueri)'
when short_name = 'gastroenteritiswithdehydrationsevere'    then 'Gastro-enterite avec : deshydratation severe'
when short_name = 'gastroenteritiswithdehydrationsevereA'    then 'Gastro-enterite avec : deshydratation severe (Actif)'
when short_name = 'gastroenteritiswithdehydrationsevereG'    then 'Gastro-enterite avec : deshydratation severe (Gueri)'
when short_name = 'grossesse'     then 'Grossesse'
when short_name = 'grossesseA'     then 'Grossesse : Actif'
when short_name = 'grossesseG'     then 'Grossesse : Gueri'
when short_name = 'obesity'  then 'Obesite'
when short_name = 'obesityA'  then 'Obesite : Actif'
when short_name = 'obesityG'  then 'Obesite : Gueri'
when short_name = 'raa'    then 'Rhumatisme articulaire aigu'
when short_name = 'raaA'    then 'Rhumatisme articulaire aigu : Actif'
when short_name = 'raaG'    then 'Rhumatisme articulaire aigu : Gueri'
when short_name = 'allergicrhinitis'  then 'Rhinite allergique'
when short_name = 'allergicrhinitisA'  then 'Rhinite allergique : Actif'
when short_name = 'allergicrhinitisG'  then 'Rhinite allergique : Gueri'
when short_name = 'gastroesophagealreflux'   then 'Reflux gastro-oesophagien'
when short_name = 'gastroesophagealrefluxA'   then 'Reflux gastro-oesophagien : Actif'
when short_name = 'gastroesophagealrefluxG'   then 'Reflux gastro-oesophagien : Gueri'
when short_name = 'nephroticsyndrome'      then 'Syndrome nephrotique'
when short_name = 'nephroticsyndromeA'      then 'Syndrome nephrotique : Actif'
when short_name = 'nephroticsyndromeG'      then 'Syndrome nephrotique : Gueri'
when short_name = 'emergencySurgery_specify' then concat('Urgence chirurgicale ', value_text)
when short_name = 'abscess_specify'   then concat('Abces : ', value_text)
when short_name = 'amygdalite'    then 'Amygdalite'
when short_name = 'amygdaliteA'    then 'Amygdalite : Actif'
when short_name = 'amygdaliteG'    then 'Amygdalite : Gueri'
when short_name = 'charbon_specify'     then concat('Charbon ',value_text)
when short_name = 'cholera'      then 'Cholera'
when short_name = 'choleraA'      then 'Cholera : Actif'
when short_name = 'choleraG'      then 'Cholera : Gueri'
when short_name = 'conjunctivitis_specify'   then concat('Conjonctivite : ', value_text)
when short_name = 'pertusis'     then 'Coqueluche'
when short_name = 'pertusisA'     then 'Coqueluche : Actif'
when short_name = 'pertusisG'     then 'Coqueluche : Gueri'
when short_name = 'dengue_specify'   then concat('Dengue: ',value_text)
when short_name = 'diptheria'    then 'Diphterie'
when short_name = 'diptheriaA'    then 'Diphterie : Actif'
when short_name = 'diptheriaG'    then 'Diphterie : Gueri'
when short_name = 'feverHemorrhagicacute'     then 'Fievre hemorragique aigue'
when short_name = 'feverHemorrhagicacuteA'     then 'Fievre hemorragique aigue : Actif'
when short_name = 'feverHemorrhagicacuteG'     then 'Fievre hemorragique aigue : Gueri'
when short_name = 'feverTyphoid'     then 'Fievre typhoide confirmee'
when short_name = 'feverTyphoidA'     then 'Fievre typhoide confirmee : Actif'
when short_name = 'feverTyphoidG'     then 'Fievre typhoide confirmee : Gueri'
when short_name = 'feverTyphoidSuspected'      then 'Fievre typhoide suspect'
when short_name = 'feverTyphoidSuspectedA'      then 'Fievre typhoide suspect : Actif'
when short_name = 'feverTyphoidSuspectedG'      then 'Fievre typhoide suspect : Gueri'
when short_name = 'lymphaticFilariasis'      then 'Filariose lymphatique'
when short_name = 'lymphaticFilariasisA'      then 'Filariose lymphatique : Actif'
when short_name = 'lymphaticFilariasisG'      then 'Filariose lymphatique : Gueri'
when short_name = 'scabies'     then 'Gale'
when short_name = 'scabiesA'     then 'Gale : Actif'
when short_name = 'scabiesG'     then 'Gale : Gueri'
when short_name = 'acuteglomerulonephritis'      then 'Glomerulonephrite aigu'
when short_name = 'acuteglomerulonephritisA'      then 'Glomerulonephrite aigu : Actif'
when short_name = 'acuteglomerulonephritisG'      then 'Glomerulonephrite aigu : Gueri'
when short_name = 'impetigo'    then 'Impetigo'
when short_name = 'impetigoA'    then 'Impetigo : Actif'
when short_name = 'impetigoG'    then 'Impetigo : Gueri'
when short_name = 'genUriInfectionDx'       then 'Infection genito-urinaire'
when short_name = 'genUriInfectionDxA'       then 'Infection genito-urinaire : Actif'
when short_name = 'genUriInfectionDxG'       then 'Infection genito-urinaire : Gueri'
when short_name = 'infectionAcuteRespiratory'      then 'Infection respiratoire aigue'
when short_name = 'infectionAcuteRespiratoryA'      then 'Infection respiratoire aigue : Actif'
when short_name = 'infectionAcuteRespiratoryG'      then 'Infection respiratoire aigue : Gueri'
when short_name = 'ist_specify'		then concat('IST: ', value_text)
when short_name = 'lepra'      then 'Lepre'
when short_name = 'lepraA'      then 'Lepre : Actif'
when short_name = 'lepraG'      then 'Lepre : Gueri'
when short_name = 'malariaDxSuspected'    then 'Malaria (paludisme) suspect'
when short_name = 'malariaDxSuspectedA'    then 'Malaria (paludisme) suspect : Actif'
when short_name = 'malariaDxSuspectedG'    then 'Malaria (paludisme) suspect : Gueri'
when short_name = 'malariaDx'      then 'Malaria (paludisme) confirme'
when short_name = 'malariaDxA'      then 'Malaria (paludisme) confirme : Actif'
when short_name = 'malariaDxG'      then 'Malaria (paludisme) confirme : Gueri'
when short_name = 'meningitis_specify'      then concat('Meningites : ', value_text)
when short_name = 'fungalskin_specify'      then concat('Mycose cutanee : ', value_text)
when short_name = 'otitis_specify'      then concat('Otite : ', value_text)
when short_name = 'parasitose'      then 'Parasitose'
when short_name = 'parasitoseA'      then 'Parasitose : Actif'
when short_name = 'parasitoseG'      then 'Parasitose : Gueri'
when short_name = 'pneumonie'      then 'Pneumonie'
when short_name = 'pneumonieA'      then 'Pneumonie : Actif'
when short_name = 'pneumonieG'      then 'Pneumonie : Gueri'
when short_name = 'polio'      then 'Poliomyelite'
when short_name = 'polioA'      then 'Poliomyelite : Actif'
when short_name = 'polioG'      then 'Poliomyelite : Gueri'
when short_name = 'rage'      then 'Rage'
when short_name = 'rageA'      then 'Rage : Actif'
when short_name = 'rageG'      then 'Rage : Gueri'
when short_name = 'rougeole'      then 'Rougeole'
when short_name = 'rougeoleA'      then 'Rougeole : Actif'
when short_name = 'rougeoleG'      then 'Rougeole : Gueri'
when short_name = 'rubella'      then 'Rubeole'
when short_name = 'rubellaA'      then 'Rubeole : Actif'
when short_name = 'rubellaG'      then 'Rubeole : Gueri'
when short_name = 'febrileSyndrome'      then 'Syndrome icterique febrile'
when short_name = 'febrileSyndromeA'      then 'Syndrome icterique febrile : Actif'
when short_name = 'febrileSyndromeG'      then 'Syndrome icterique febrile : Gueri'
when short_name = 'teigne' then 'Teigne'
when short_name = 'teigneA' then 'Teigne : Actif'
when short_name = 'teigneG' then 'Teigne : Gueri'
when short_name = 'tetanus' then 'Tetanos'
when short_name = 'tetanusA' then 'Tetanos : Actif'
when short_name = 'tetanusG' then 'Tetanos : Gueri'
when short_name = 'dxTB'	then 'Tuberculose'
when short_name = 'dxTBA'	then 'Tuberculose : Actif'
when short_name = 'dxTBG'	then 'Tuberculose : Gueri'
when short_name = 'dxMDRtb' then 'MDR TB'
when short_name = 'dxMDRtbA' then 'MDR TB : Actif'
when short_name = 'dxMDRtbG' then 'MDR TB : Gueri'
when short_name = 'varicelle'	then 'Varicelle'
when short_name = 'varicelleA'	then 'Varicelle : Actif'
when short_name = 'varicelleG'	then 'Varicelle : Gueri'
when short_name = 'hivPositiveN'	then 'VIH/SIDA'
when short_name = 'hivPositiveNA'	then 'VIH/SIDA : Actif'
when short_name = 'hivPositiveNG'	then 'VIH/SIDA : Gueri'
when short_name = 'psychiatriqueDisorder' then 'Trouble psychiatrique d\'etiologie a investiguer'
when short_name = 'psychiatriqueDisorderA' then 'Trouble psychiatrique d\'etiologie a investiguer : Actif'
when short_name = 'psychiatriqueDisorderG' then 'Trouble psychiatrique d\'etiologie a investiguer : Gueri'
when short_name = 'stress'	then 'Stress post traumatique'
when short_name = 'stressA'	then 'Stress post traumatique : Actif'
when short_name = 'stressG'	then 'Stress post traumatique : Gueri'
when short_name = 'sexAggression' then 'Agression sexuelle'
when short_name = 'sexAggressionA' then 'Agression sexuelle : Actif'
when short_name = 'sexAggressionG' then 'Agression sexuelle : Gueri'
when short_name = 'burns_specify'	then concat('Brulure : ',value_text)
when short_name = 'sprain_specify'	then concat('Entorse : ', value_text)
when short_name = 'boneFracture_specify'	then concat('Fracture osseuse : ', value_text)
when short_name = 'dislocation_specify'	then concat('Luxation : ', value_text)
when short_name = 'wound_specify'	then concat('Plaie : ', value_text)
when short_name = 'polytrauma'	then 'Poly traumatisme'
when short_name = 'polytraumaA'	then 'Poly traumatisme : Actif'
when short_name = 'polytraumaG'	then 'Poly traumatisme : Gueri'
when short_name = 'traumaHead'	then 'Trauma cranien'
when short_name = 'traumaHeadA'	then 'Trauma cranien : Actif'
when short_name = 'traumaHeadG'	then 'Trauma cranien : Gueri'
when short_name = 'otherDx1_specify'	then concat('Autre : ', value_text)
when short_name = 'otherDx2_specify'	then concat('Autre : ', value_text)
when short_name = 'otherDiagnosesComment'	then concat('Remarque : ', value_text) else 'xxx'
end as diagnostics
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null) and encounterType = 31 and
short_name in ( 'irondeficiencyanemia','irondeficiencyanemiaA','irondeficiencyanemiaG', 'scd', 'scdA','scdG','asthmaDx','asthmaDxA','asthmaDxG', 'bronchitis','bronchitisA','bronchitisG', 'cardiopathy','cardiopathyA','cardiopathyG', 'febrileseizures','febrileseizuresA','febrileseizuresG', 'malnutritionmild','malnutritionmildA','malnutritionmildG', 'malnutritionmoderate','malnutritionmoderateA','malnutritionmoderateG', 'malnutritionsevere','malnutritionsevereA','malnutritionsevereG', 'malnutritionsevereSS','malnutritionsevereSSA','malnutritionsevereSSG', 'atopicdermatitis','atopicdermatitisA','atopicdermatitisG', 'diabete1','diabete1A','diabete1G', 'diarrheeAqueuse','diarrheeAqueuseA','diarrheeAqueuseG', 'diarrheeSanguin','diarrheeSanguinA','diarrheeSanguinG', 'diarrheeIndeter','diarrheeIndeterA','diarrheeIndeterG', 'sicklecell','sicklecellA','sicklecellG', 'epilepsy','epilepsyA','epilepsyG', 'feverIndeter','feverIndeterA','feverIndeterG', 'gastroenteritiswithdehydrationmild','gastroenteritiswithdehydrationmildA','gastroenteritiswithdehydrationmildG', 'gastroenteritiswithdehydrationmoderate','gastroenteritiswithdehydrationmoderateA','gastroenteritiswithdehydrationmoderateG', 'gastroenteritiswithdehydrationsevere','gastroenteritiswithdehydrationsevereA','gastroenteritiswithdehydrationsevereG', 'grossesse','grossesseA','grossesseG', 'obesity','obesityA','obesityG', 'raa','raaA','raaG', 'allergicrhinitis','allergicrhinitisA','allergicrhinitisG', 'gastroesophagealreflux','gastroesophagealrefluxA','gastroesophagealrefluxG', 'nephroticsyndrome','nephroticsyndromeA','nephroticsyndromeG', 'emergencySurgery_specify', 'abscess_specify', 'amygdalite','amygdaliteA','amygdaliteG', 'charbon_specify', 'cholera','choleraA','choleraG', 'conjunctivitis_specify', 'pertusis','pertusisA','pertusisG', 'dengue_specify', 'diptheria','diptheriaA','diptheriaG', 'feverHemorrhagicacute', 'feverHemorrhagicacuteA','feverHemorrhagicacuteG','feverTyphoid','feverTyphoidA','feverTyphoidG', 'feverTyphoidSuspected', 'feverTyphoidSuspectedA','feverTyphoidSuspectedG','lymphaticFilariasis','lymphaticFilariasisA','lymphaticFilariasisG', 'scabies','scabiesA','scabiesG', 'acuteglomerulonephritis','acuteglomerulonephritisA', 'acuteglomerulonephritisG',  'impetigo','impetigoA','impetigoG', 'genUriInfectionDx','genUriInfectionDxA','genUriInfectionDxG', 'infectionAcuteRespiratory','infectionAcuteRespiratoryA','infectionAcuteRespiratoryG', 'ist_specify', 'lepra','lepraA','lepraG', 'malariaDxSuspected','malariaDxSuspectedA','malariaDxSuspectedG', 'malariaDx','malariaDxA','malariaDxG', 'meningitis_specify', 'fungalskin_specify', 'otitis_specify', 'parasitose','parasitoseA','parasitoseG', 'pneumonie','pneumonieA','pneumonieG', 'polio','polioA','polioG', 'rage','rageA','rageG', 'rougeole','rougeoleA','rougeoleG', 'rubella','rubellaA','rubellaG', 'febrileSyndrome','febrileSyndromeA','febrileSyndromeG', 'teigne','teigneA','teigneG', 'tetanus','tetanusA','tetanusG','dxTB','dxTBA','dxTBG','dxMDRtb','dxMDRtbA','dxMDRtbG','varicelle','varicelleA','varicelleG','hivPositiveN','hivPositiveNA','hivPositiveNG','psychiatriqueDisorder','psychiatriqueDisorderA','psychiatriqueDisorderG','stress','stressA','stressG','sexAggression','sexAggressionA','sexAggressionG','burns_specify','sprain_specify','boneFracture_specify','dislocation_specify','wound_specify','polytrauma','polytraumaA','polytraumaG','traumaHead','traumaHeadA','traumaHeadG','otherDx1_specify','otherDx2_specify','otherDiagnosesComment')
order by 1 desc limit 6",
	   "tobDiag" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'sexAggression'        then 'Agression sexuelle'  
when short_name = 'sexAggressionA'        then 'Agression sexuelle : Actif'  
when short_name = 'sexAggressionG'        then 'Agression sexuelle : Gueri'  
when short_name = 'adfActive'    then 'Adenofibrome (ADF) du sein'
when short_name = 'adfActiveA'    then 'Adenofibrome (ADF) du sein : Actif'
when short_name = 'adfActiveG'    then 'Adenofibrome (ADF) du sein : Gueri'
when short_name = 'anemia'     then 'Anemie'
when short_name = 'anemiaA'     then 'Anemie : Actif'
when short_name = 'anemiaG'     then 'Anemie : Gueri'
when short_name = 'avortement_specify'     then concat('Avortement : ', value_text)
when short_name = 'cancerEndoActive'     then 'Cancer de l\'endometre'
when short_name = 'cancerEndoActiveA'     then 'Cancer de l\'endometre : Actif'
when short_name = 'cancerEndoActiveG'     then 'Cancer de l\'endometre : Gueri'
when short_name = 'cancerOvaryActive'     then 'Cancer de l\'ovaire'
when short_name = 'cancerOvaryActiveA'     then 'Cancer de l\'ovaire : Actif'
when short_name = 'cancerOvaryActiveG'     then 'Cancer de l\'ovaire : Gueri'
when short_name = 'cancerBreastActive_specify'    then concat('Cancer de sein : ',value_text)
when short_name = 'cardiopathy_specify'    then concat('Cardiopathie : ',value_text) 
when short_name = 'chorioamniotite'     then 'Chorioamniotite'
when short_name = 'chorioamniotiteA'     then 'Chorioamniotite : Actif'
when short_name = 'chorioamniotiteG'     then 'Chorioamniotite : Gueri'
when short_name = 'diabetespregnancy_specify'     then concat('Diabete + Grossesse : ', value_text)
when short_name = 'dysOvaryActive_specify'    then concat('Dystrophie ovarienne : ', value_text)
when short_name = 'eclampsia'     then 'Eclampsie'
when short_name = 'eclampsiaA'     then 'Eclampsie : Actif'
when short_name = 'eclampsiaG'     then 'Eclampsie : Gueri'
when short_name = 'endometriosisActive_specify'   then concat('Endometriose : ',value_text)
when short_name = 'fibroidUterineActive_specify'  then concat('Fibrome uterin : ',value_text)
when short_name = 'grossesseEctopique_specify'   then concat('Grossesse ectopique : ', value_text)
when short_name = 'grossesseUterine'     then 'Grossesse intra-uterine'
when short_name = 'grossesseUterineA'     then 'Grossesse intra-uterine : Actif'
when short_name = 'grossesseUterineG'     then 'Grossesse intra-uterine : Gueri'
when short_name = 'htapregnancy'    then 'HTA + Grossesse'
when short_name = 'htapregnancyA'    then 'HTA + Grossesse : Actif'
when short_name = 'htapregnancyG'    then 'HTA + Grossesse : Gueri'
when short_name = 'hemorragie_specify'      then concat('Hemorragie troisieme trimestre : ', value_text)
when short_name = 'hyperGravi'  then 'Hyperemese Gravidique'
when short_name = 'hyperGraviA'  then 'Hyperemese Gravidique : Actif'
when short_name = 'hyperGraviG'  then 'Hyperemese Gravidique : Gueri'
when short_name = 'genUriInfectionDx'     then 'Infection genito-urinaire'
when short_name = 'genUriInfectionDxA'     then 'Infection genito-urinaire : Actif'
when short_name = 'genUriInfectionDxG'     then 'Infection genito-urinaire : Gueri'
when short_name = 'ist_specify'    then concat('IST: ',value_text)
when short_name = 'cystOvaryActive_specify'     then concat('Kyste de l\'ovaire : ', value_text)
when short_name = 'lesionCervicale_specify'  then concat('Lesion cervicale : ', value_text)
when short_name = 'maladiePelvienne'    then 'Maladie inflammatoire pelvienne'
when short_name = 'maladiePelvienneA'    then 'Maladie inflammatoire pelvienne : Actif'
when short_name = 'maladiePelvienneG'    then 'Maladie inflammatoire pelvienne : Gueri'
when short_name = 'malariaDxSuspected'  then 'Malaria (paludisme) suspect'
when short_name = 'malariaDxSuspectedA'  then 'Malaria (paludisme) suspect : Actif'
when short_name = 'malariaDxSuspectedG'  then 'Malaria (paludisme) suspect : Gueri'
when short_name = 'malariaDx'   then 'Malaria (paludisme) confirme'
when short_name = 'malariaDxA'   then 'Malaria (paludisme) confirme : Actif'
when short_name = 'malariaDxG'   then 'Malaria (paludisme) confirme : Gueri'
when short_name = 'menacePrema'      then 'Menace d\'accouchement prematuree'
when short_name = 'menacePremaA'      then 'Menace d\'accouchement prematuree : Actif'
when short_name = 'menacePremaG'      then 'Menace d\'accouchement prematuree : Gueri'
when short_name = 'oligoamnios' then 'Oligoamnios'
when short_name = 'oligoamniosA' then 'Oligoamnios : Actif'
when short_name = 'oligoamniosG' then 'Oligoamnios : Gueri'
when short_name = 'pathRenale'   then 'Pathologie renale'
when short_name = 'pathRenaleA'   then 'Pathologie renale : Actif'
when short_name = 'pathRenaleG'   then 'Pathologie renale : Gueri'
when short_name = 'preEclampsie_specify'    then concat('Pre eclampsie ', value_text)
when short_name = 'retardCroissanceIU'     then 'Retard croissance IntraUterin'
when short_name = 'retardCroissanceIUA'     then 'Retard croissance IntraUterin : Actif'
when short_name = 'retardCroissanceIUG'     then 'Retard croissance IntraUterin : Gueri'
when short_name = 'membraneRupture'      then 'Rupture prematuree des membranes'
when short_name = 'membraneRuptureA'      then 'Rupture prematuree des membranes : Actif'
when short_name = 'membraneRuptureG'      then 'Rupture prematuree des membranes : Gueri'
when short_name = 'vaginalBleedingAbn'   then 'Saignement uterin anormal'
when short_name = 'vaginalBleedingAbnA'   then 'Saignement uterin anormal : Actif'
when short_name = 'vaginalBleedingAbnG'   then 'Saignement uterin anormal : Gueri'
when short_name = 'syphilis'     then 'Syphilis'
when short_name = 'syphilisA'     then 'Syphilis : Actif'
when short_name = 'syphilisG'     then 'Syphilis : Gueri'
when short_name = 'thrombopenie'   then 'Thrombopenie'
when short_name = 'thrombopenieA'   then 'Thrombopenie : Actif'
when short_name = 'thrombopenieG'   then 'Thrombopenie : Gueri'
when short_name = 'thrombose'    then 'Thromboses'
when short_name = 'thromboseA'    then 'Thromboses : Actif'
when short_name = 'thromboseG'    then 'Thromboses : Gueri'
when short_name = 'dxTB'     then 'Tuberculose'
when short_name = 'dxTBA'     then 'Tuberculose : Actif'
when short_name = 'dxTBG'     then 'Tuberculose : Gueri'
when short_name = 'dxMDRtb'     then 'MDR TB'
when short_name = 'dxMDRtbA'     then 'MDR TB : Actif'
when short_name = 'dxMDRtbG'     then 'MDR TB : Gueri'
when short_name = 'travailLatent'      then 'Travail, Latent'
when short_name = 'travailLatentA'      then 'Travail, Latent : Actif'
when short_name = 'travailLatentG'      then 'Travail, Latent : Gueri'
when short_name = 'travailActive'      then 'Travail, Actif'
when short_name = 'travailActiveA'      then 'Travail, Actif : Actif'
when short_name = 'travailActiveG'      then 'Travail, Actif : Gueri'
when short_name = 'hivPositiveN'     then 'VIH/SIDA'
when short_name = 'hivPositiveNA'     then 'VIH/SIDA : Actif'
when short_name = 'otherDx_specify'      then concat('Autre : ', value_text)
when short_name = 'otherDx2_specify'    then concat('Autre : ', value_text) else 'xxx'
end as diagnostics
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null) and encounterType = 25 and
short_name in ('sexAggression','sexAggressionA','sexAggressionG','adfActive','adfActiveA','adfActiveG','anemia','anemiaA','anemiaG','avortement_specify','cancerEndoActive','cancerEndoActiveA','cancerEndoActiveG','cancerOvaryActive','cancerOvaryActiveA','cancerOvaryActiveG','cancerBreastActive_specify','cardiopathy_specify','chorioamniotite','chorioamniotiteA','chorioamniotiteG','diabetespregnancy_specify','dysOvaryActive_specify','eclampsia','eclampsiaA','eclampsiaG','endometriosisActive_specify','fibroidUterineActive_specify','grossesseEctopique_specify','grossesseUterine','grossesseUterineA','grossesseUterineG','htapregnancy','htapregnancyA','htapregnancyG','hemorragie_specify','hyperGravi','hyperGraviA','hyperGraviG','genUriInfectionDx','genUriInfectionDxA','genUriInfectionDxG','ist_specify','cystOvaryActive_specify','lesionCervicale_specify','maladiePelvienne','maladiePelvienneA','maladiePelvienneG','malariaDxSuspected','malariaDxSuspectedA','malariaDxSuspectedG','malariaDx','malariaDxA','malariaDxG','menacePrema','menacePremaA','menacePremaG','oligoamnios','oligoamniosA','oligoamniosG','pathRenale','pathRenaleA','pathRenaleG','preEclampsie_specify','retardCroissanceIU','retardCroissanceIUA','retardCroissanceIUG','membraneRupture','membraneRuptureA','membraneRuptureG','vaginalBleedingAbn','vaginalBleedingAbnA','vaginalBleedingAbnG','syphilis','syphilisA','syphilisG','thrombopenie','thrombopenieA','thrombopenieG','thrombose','thromboseA','thromboseG','dxTB','dxTBA','dxTBG','dxMDRtb','dxMDRtbA','dxMDRtbG','travailLatent','travailLatentA','travailLatentG','travailActive','travailActiveA','travailActiveG','hivPositiveN','hivPositiveNA','otherDx_specify','otherDx2_specify')
order by 1 desc limit 6",
	   "cond" => "SELECT visitdate as 'Date de visite', case when short_name = 'blood_group' then 'Groupe sanguin : 'when short_name = 'ultrasoundTest_specify' then concat('Echographie: ',value_text) when short_name = 'cd4TestOrder' then 'CD4' when short_name = 'psaTest' then 'PSA' when short_name = 'malariaTestRapid' then 'Malaria : TDR' when short_name = 'malariaResultRapid' and value_numeric ='1' then 'Malaria microscopie : Resultat negatif' when short_name = 'malariaResultRapid' and value_numeric ='2' then 'Malaria microscopie : Resultat positif' when short_name = 'malariaResultRapid' and value_numeric ='3' then 'Malaria microscopie : Resultat inconnu' when short_name = 'seroHeliTest' then 'Serologie a Helicobacter Pylori' when short_name = 'hemoglobinelectrophoresisTest' then 'Electrophorese de l\'hemoglobine' when short_name = 'asatalatTest' then 'ASAT/ALAT' when short_name = 'ureaTest' then 'Uree/Creatinine' when short_name = 'spitTest' then 'Crachats en serie' when short_name = 'serologiehivTest' then 'Serologie VIH' when short_name = 'ivaTest' then 'VIA' when short_name = 'radiographTest_specify' then concat('Radiographie: ',value_text) when short_name = 'widalTest' then 'Widal' when short_name = 'labOther1_specify' then concat('Autres: ',value_text) when short_name = 'labOther2_specify' then concat('Autres: ',value_text) when short_name = 'rr' then 'RR' when short_name = 'toxTetanus1DtToday' then 'DT/Tetanos toxoide' when short_name = 'immunOtherText1' then concat('Autre: ',value_text) when short_name = 'medicinePres1' then concat('Medicaments prescrits/Posologie(1)',value_text) when short_name = 'medicinePres2' then concat('Medicaments prescrits/Posologie(2)',value_text) when short_name = 'medicinePres3' then concat('Medicaments prescrits/Posologie(3)',value_text) when short_name = 'medicinePres4' then concat('Medicaments prescrits/Posologie(4)',value_text) when short_name = 'medicinePres5' then concat('Medicaments prescrits/Posologie(5)',value_text) when short_name = 'psychologue' then 'Psychologue' when short_name = 'progNutrition' then 'Programme de nutrition' when short_name = 'planFamily' then 'Planification familiale' when short_name = 'referenceForm' then 'Fiches de reference remplies' when short_name = 'hospitalisation' then 'Hospitalisation' when short_name = 'referClinic_specify' then concat('Autre etablissement/clinique: ',value_text) else 'xxx' end as 'conduite a tenir' FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and (value_boolean = 1 or value_text is not null or value_numeric is not null) and encounterType = 27 and short_name in ( 'blood_group','ultrasoundTest_specify', 'cd4TestOrder','psaTest', 'malariaTestRapid', 'malariaResultRapid','seroHeliTest','hemoglobinelectrophoresisTest','asatalatTest','ureaTest','spitTest','serologiehivTest','ivaTest','radiographTest_specify','widalTest','labOther1_specify','labOther2_specify','rr','toxTetanus1DtToday','immunOtherText1','medicinePres1','medicinePres2','medicinePres3','medicinePres4','medicinePres5','psychologue','progNutrition','planFamily','referenceForm','hospitalisation','referClinic_specify') union select visitDate, case  when testNameEn = 'Blood Type' then 'Groupe sanguin' when testNameEn = 'C Reactive Protein (CRP)' then 'C Reactive Proteine' when testNameEn = 'Pap test' then 'PAP test' when testNameEn = 'Hemoculture' then 'Hemogramme' when testNameEn = 'Fasting Glucose' then 'Glycemie' when testNameEn = 'RPR' then 'Serologie syphilis' when testNameEn = 'PPD/Mantoux' then 'PPD' when testNameEn = 'Sickling test' then 'Sickling test' when testNameEn = 'Vaginal smear' then 'Frottis vaginal/Gouttes pendantes' when testNameEn = 'Urine' then 'Urines' when testNameEn = 'Stool' then 'Selles' when testNameEn = 'Pregnancy test' then 'Test de grossesse' when testNameEn = 'Hepatitis B, presence of:' then 'Hepatite B' else 'xxx' end as item FROM a_labs where encounterType in(24,27,29) and patientID='".$pid."' and testNameEn in ('Blood Type','C Reactive Protein (CRP)','Pap test','Hemoculture','Fasting Glucose','RPR','PPD/Mantoux','Sickling test','Vaginal smear','Urine','Stool','Pregnancy test','Hepatitis B, presence of:') order by 1 desc",
	   "obCond" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'blood_group' then 'Groupe sanguin : '
when short_name = 'ultrasoundTest_specify'        then concat('Echographie: ',value_text)
when short_name = 'cd4TestOrder'      then 'CD4'
when short_name = 'malariaTestRapid' then 'Malaria : TDR' 
when short_name = 'malariaResultRapid' and value_numeric ='1' then 'Malaria microscopie : Resultat negatif'
when short_name = 'malariaResultRapid' and value_numeric ='2' then 'Malaria microscopie : Resultat positif'
when short_name = 'malariaResultRapid' and value_numeric ='3' then 'Malaria microscopie : Resultat inconnu'
when short_name = 'hemoglobinelectrophoresisTest' then 'Electrophorese de l\'hemoglobine'
when short_name = 'asatalatTest' then 'ASAT/ALAT'
when short_name = 'ureaTest' then 'Uree/Creatinine'
when short_name = 'prolactineTest' then 'Prolactine'
when short_name = 'fshlhTest' then 'FSH/LH'
when short_name = 'estrogenprogestoroneTest' then 'Oestrogene/Progesterone'
when short_name = 'serologiehivTest' then 'Serologie VIH'
when short_name = 'ivaTest' then 'VIA'
when short_name = 'radiographTest_specify' then concat('Radiographie: ',value_text)
when short_name = 'labOther1_specify' then concat('Autres: ',value_text)
when short_name = 'labOther2_specify' then concat('Autres: ',value_text)
when short_name = 'toxTetanus1DtToday' then 'DT/Tetanos toxoide' /*dans vaccination*/
when short_name = 'immunOtherText1' then concat('Autre: ',value_text) /*dans vaccination*/
when short_name = 'medicinePres1' then concat('Medicaments prescrits/Posologie(1) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres2' then concat('Medicaments prescrits/Posologie(2) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres3' then concat('Medicaments prescrits/Posologie(3) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres4' then concat('Medicaments prescrits/Posologie(4) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres5' then concat('Medicaments prescrits/Posologie(5) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'psychologue' then 'Psychologue' /*dans reference*/
when short_name = 'progNutrition' then 'Programme de nutrition' /*dans reference*/
when short_name = 'planFamily' then 'Planification familiale' /*dans reference*/
when short_name = 'referenceForm' then 'Fiches de reference remplies' /*dans reference*/
when short_name = 'hospitalisation' then 'Hospitalisation' /*dans reference*/
when short_name = 'referenceSTA'	then 'Salle de travail et d\'accouchement(STA)'
when short_name = 'referenceStructureCommunautaire'		then 'Structure communautaire'
when short_name = 'referClinic_specify' then concat('Autre etablissement/clinique: ',value_text) /*dans reference*/
/*dans planification familiale*/
when short_name = 'famPlanMethodCounseling' then 'Counseling effectue'
when short_name = 'beginBCDt' 	then concat('Counseling, date debut : ', cast(value_datetime as date)) 
when short_name = 'endBCDt'		then concat('Counseling, date d\'arret : ', cast(value_datetime as date))
when short_name = 'currentBCUse'	then 'Utilisation Courante'
/* pas de methode condom dans la base?*/
when short_name = 'famPlanMethodLigature'	then 'Methode PF administree, Ligature des trompes'
when short_name = 'famPlanMethodPillCombined'	then 'Methode PF administree, Pilule : Combine'
when short_name = 'famPlanMethodPillOnly'		then 'Methode PF administree, Pilule : Progestatif seule'
when short_name = 'famPlanMethodImplants'		then 'Methode PF administree, Implant'
when short_name = 'famPlanMethodSterile'		then 'Methode PF administree, Sterilet'
when short_name = 'famPlanMethodInjectable'		then 'Methode PF administree, Injectable'
when short_name = 'famPlanMethodCollier'		then 'Methode PF administree, Collier(jour fixe) :'
when short_name = 'famPlanMethodCollierDt'		then concat('date administration Methode PF, Collier :', cast(value_datetime as date))
when short_name = 'famPlanOther_specify'		then concat('Planification familiale, autre : ', value_text)
/*dans suivi et planification*/
when short_name = 'evalplanWeekOfPregnancy'		then concat('Semaine de gestation : ',value_text)
when short_name = 'evalplanRiskFactorAucune'	then 'Facteur de risque : Aucune'
when short_name = 'evalplanRiskFactorAncienne' 	then 'Facteur de risque : Ancienne cesarisee'
when short_name = 'evalplanRiskFactorAnemie'	then 'Facteur de risque : Anemie'
when short_name = 'evalplanRiskFactorDiabete'	then 'Facteur de risque : Diabete'
when short_name = 'evalplanRiskFactorOedeme'	then 'Facteur de risque : Oedeme'
when short_name = 'evalplanRiskFactorParite'	then 'Facteur de risque : Grande parite'
when short_name = 'evalplanRiskFactor18'		then 'Facteur de risque : <18 ans'
when short_name = 'evalplanRiskFactor35'		then 'Facteur de risque : >35 ans'
when short_name = 'evalplanRiskFactorMultiple'	then 'Facteur de risque : Grossesse multiple'
when short_name = 'evalplanRiskFactorAntepartum'	then 'Facteur de risque : Hemorragie antepartum'
when short_name = 'evalplanRiskFactorHypertension'	then 'Facteur de risque : Hypertension'
when short_name = 'evalplanRiskFactorPoids'		then 'Facteur de risque : Poids stationnaire'
when short_name = 'evalplanRiskFactorVIH'		then 'Facteur de risque : VIH'
when short_name = 'evalplanRiskFactorTaille'	then 'Facteur de risque : taille<150 cm'
when short_name = 'evalplanHIVCounselingPretestDate'	then concat('Counseling pretest : ',cast(value_datetime as date))
when short_name = 'evalplanHIVCounselingPosttestDate'	then concat('Counseling post test : ',cast(value_datetime as date))
when short_name = 'evalplanHIVCounselingPartner' and value_numeric = 1	then 'Reference partenaire : oui'
when short_name = 'evalplanHIVCounselingPartner' and value_numeric = 2	then 'Reference partenaire : non'
when short_name = 'evalplanHIVCounselingPartnerResult'	and value_numeric = 1 then 'Reference partenaire : positif'
when short_name = 'evalplanHIVCounselingPartnerResult'	and value_numeric = 2 then 'Reference partenaire : negatif'
when short_name = 'evalplanHIVCounselingPartnerResult'	and value_numeric = 3 then 'Reference partenaire : Indetermine'
when short_name = 'evalplanHIVCounselingReason'	 	and value_text is not null	then concat('Motif de depistage : ',value_text)
when short_name = 'evalplanHIVStage1'	then 'VIH positif, Stade OMS : Stade I'
when short_name = 'evalplanHIVStage2'	then 'VIH positif, Stade OMS : Stade II'
when short_name = 'evalplanHIVStage3'	then 'VIH positif, Stade OMS : Stade III'
when short_name = 'evalplanHIVStage4'	then 'VIH positif, Stade OMS : Stade IV'
when short_name = 'evalplanHIVStageUnknown'	then 'VIH positif, Stade OMS : Stade inconnu'
when short_name = 'evalplanCD4Count' then concat('Numeration ou taux de CD4 : ', value_text)
when short_name = 'evalplanARVYesDate'	then concat('Patiente sous ARV : oui, Date de debut ',cast(value_datetime as date))
when short_name = 'evalplanARVDate'	then concat('Patiente sous ARV : non, Date prevue pour l\'initiation de la prophylaxie ',cast(value_datetime as date)) 
when short_name = 'planCotrimoxazole'	then 'Prophylaxie : Cotrimoxazole'
when short_name = 'planAzythromycine'	then 'Prophylaxie : Azythromycine'
when short_name = 'planFluconazole'	then 'Prophylaxie : Fluconazole' 
when short_name = 'planINHprim'	then 'Prophylaxie : INH primaire'
when short_name = 'planINHsec'	then 'Prophylaxie : INH secondaire' else 'xxx'
end as 'conduite a tenir'
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null or value_numeric is not null or value_datetime is not null) and encounterType = 24 and
short_name in ( 'blood_group','ultrasoundTest_specify', 'cd4TestOrder','psaTest', 'malariaTestRapid', 'malariaResultRapid','seroHeliTest','hemoglobinelectrophoresisTest','asatalatTest','ureaTest','spitTest','serologiehivTest','ivaTest','radiographTest_specify','widalTest','labOther1_specify','labOther2_specify','rr','toxTetanus1DtToday','immunOtherText1','medicinePres1','medicinePres2','medicinePres3','medicinePres4','medicinePres5','psychologue','progNutrition','planFamily','referenceForm','hospitalisation','referClinic_specify','famPlanMethodCounseling','beginBCDt','endBCDt','currentBCUse','famPlanMethodLigature','famPlanMethodPillCombined','famPlanMethodPillOnly','famPlanMethodImplants','famPlanMethodSterile','famPlanMethodInjectable','famPlanMethodCollier','famPlanMethodCollierDt','famPlanOther_specify','evalplanWeekOfPregnancy','evalplanRiskFactorAucune','evalplanRiskFactorAncienne','evalplanRiskFactorAnemie','evalplanRiskFactorDiabete','evalplanRiskFactorOedeme','evalplanRiskFactorParite','evalplanRiskFactor18','evalplanRiskFactor35','evalplanRiskFactorMultiple','evalplanRiskFactorAntepartum','evalplanRiskFactorHypertension','evalplanRiskFactorPoids','evalplanRiskFactorVIH','evalplanRiskFactorTaille','evalplanHIVCounselingPretestDate','evalplanHIVCounselingPosttestDate','evalplanHIVCounselingPartner','evalplanHIVCounselingPartnerResult','evalplanHIVCounselingReason','evalplanHIVStage1','evalplanHIVStage2','evalplanHIVStage3','evalplanHIVStage4','evalplanHIVStageUnknown','evalplanCD4Count','evalplanARVYesDate','evalplanARVDate','planCotrimoxazole','planAzythromycine','planFluconazole','planINHprim','planINHsec','referenceSTA','referenceStructureCommunautaire')
union select visitDate, case 
when testNameEn = 'Blood Type' then 'Groupe sanguin' /* 2 fois*/
when testNameEn = 'C Reactive Protein (CRP)' then 'C Reactive Proteine'
when testNameEn = 'Pap test' then 'PAP test'
when testNameEn = 'Hemoculture' then 'Hemogramme'
when testNameEn = 'Fasting Glucose' then 'Glycemie'
when testNameEn = 'RPR' then 'Serologie syphilis'
when testNameEn = 'PPD/Mantoux' then 'PPD'
when testNameEn = 'Sickling test' then 'Sickling test'
when testNameEn = 'Vaginal smear' then 'Frottis vaginal/Gouttes pendantes'
when testNameEn = 'Urine' then 'Urines'
when testNameEn = 'Stool' then 'Selles'
when testNameEn = 'Pregnancy test' then 'Test de grossesse'
when testNameEn = 'Hepatitis B, presence of:' then 'Hepatite B' /*dans vaccination*/ else 'xxx'
end as item
FROM a_labs where encounterType = 24 and patientID='".$pid."' and testNameEn in ('Blood Type','C Reactive Protein (CRP)','Pap test','Hemoculture','Fasting Glucose','RPR','PPD/Mantoux','Sickling test','Vaginal smear','Urine','Stool','Pregnancy test','Hepatitis B, presence of:')
order by 1 desc",
	   "pedCond" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'blood_group' then 'Groupe sanguin : '
when short_name = 'ultrasoundTest_specify'        then concat('Echographie: ',value_text)
when short_name = 'cd4TestOrder'      then 'CD4'
when short_name = 'malariaTestRapid' then 'Malaria : TDR' 
when short_name = 'malariaResultRapid' and value_numeric ='1' then 'Malaria microscopie : Resultat negatif'
when short_name = 'malariaResultRapid' and value_numeric ='2' then 'Malaria microscopie : Resultat positif'
when short_name = 'malariaResultRapid' and value_numeric ='3' then 'Malaria microscopie : Resultat inconnu'
when short_name = 'seroHeliTest' then 'Serologie a Helicobacter Pylori'
when short_name = 'hemoglobinelectrophoresisTest' then 'Electrophorese de l\'hemoglobine'
when short_name = 'ureaTest' then 'Uree/Creatinine'
when short_name = 'spitTest' then 'Crachats en serie'
when short_name = 'serologiehivTest' then 'Serologie VIH'
when short_name = 'radiographTest_specify' then concat('Radiographie: ',value_text)
when short_name = 'widalTest' then 'Widal'
when short_name = 'labOther1_specify' then concat('Autres: ',value_text)
when short_name = 'labOther2_specify' then concat('Autres: ',value_text)
when short_name = 'medicinePres1' then concat('Medicaments prescrits/Posologie(1)',value_text)
when short_name = 'medicinePres2' then concat('Medicaments prescrits/Posologie(2)',value_text)
when short_name = 'medicinePres3' then concat('Medicaments prescrits/Posologie(3)',value_text)
when short_name = 'medicinePres4' then concat('Medicaments prescrits/Posologie(4)',value_text)
when short_name = 'medicinePres5' then concat('Medicaments prescrits/Posologie(5)',value_text)
when short_name = 'nutritionalSupport' and value_numeric = 2 then 'Support nutritionnel : non'
when short_name = 'nutritionalSupport' and value_numeric = 1 then 'Support nutritionnel : oui'
when short_name = 'nutritionalSupportEnrichedMilk'	then 'Support nutritionnel : Lait enrichi'
when short_name = 'nutritionalSupportLM'	then 'Support nutritionnel : Preparation pour nourissons(LM)'
when short_name = 'nutritionalSupportMedicaMamba'	then 'Support nutritionnel : Medica Mamba'
when short_name = 'nutritionalSupportDryRations'	then 'Support nutritionnel : Ration seche'
when short_name = 'nutritionalSupportOther_specify'	then concat('Support nutritionnel : ',value_text)
when short_name = 'progNutrition' then 'Programme de nutrition'
when short_name = 'referenceForm' then 'Fiches de reference remplies'
when short_name = 'hospitalisation' then 'Hospitalisation'
when short_name = 'referOtherService_specify' then concat('Autres services : ', value_text)
when short_name = 'referenceVaccination'	then 'Vaccination'
when short_name = 'referClinic_specify' then concat('Autre etablissement/clinique: ',value_text) else 'xxx'
end as 'conduite a tenir'
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null or value_numeric is not null) and encounterType = 29 and
short_name in ( 'blood_group','ultrasoundTest_specify', 'cd4TestOrder','malariaTestRapid', 'malariaResultRapid','seroHeliTest','hemoglobinelectrophoresisTest','ureaTest','spitTest','serologiehivTest','radiographTest_specify','widalTest','labOther1_specify','labOther2_specify','medicinePres1','medicinePres2','medicinePres3','medicinePres4','medicinePres5','progNutrition','referenceForm','hospitalisation','referClinic_specify','nutritionalSupport','nutritionalSupportEnrichedMilk','nutritionalSupportLM','nutritionalSupportMedicaMamba','nutritionalSupportDryRations','nutritionalSupportOther_specify','referOtherService_specify','referenceVaccination')
union select visitDate, case 
when testNameEn = 'Blood Type' then 'Groupe sanguin'
when testNameEn = 'C Reactive Protein (CRP)' then 'C Reactive Proteine'
when testNameEn = 'Hemoculture' then 'Hemogramme'
when testNameEn = 'Fasting Glucose' then 'Glycemie'
when testNameEn = 'RPR' then 'Serologie syphilis'
when testNameEn = 'PPD/Mantoux' then 'PPD'
when testNameEn = 'Sickling test' then 'Sickling test'
when testNameEn = 'Vaginal smear' then 'Frottis vaginal/Gouttes pendantes'
when testNameEn = 'Urine' then 'Urines'
when testNameEn = 'Stool' then 'Selles'
when testNameEn = 'Pregnancy test' then 'Test de grossesse' else 'xxx'
end as item
FROM a_labs where encounterType = 29 and patientID='".$pid."' and testNameEn in ('Blood Type','C Reactive Protein (CRP)','Pap test','Hemoculture','Fasting Glucose','RPR','PPD/Mantoux','Sickling test','Vaginal smear','Urine','Stool','Pregnancy test','Hepatitis B, presence of:')
order by 1 desc",
	   "tcond" => "SELECT visitdate as 'Date de visite', case when short_name = 'blood_group' then 'Groupe sanguin : 'when short_name = 'ultrasoundTest_specify' then concat('Echographie: ',value_text) when short_name = 'cd4TestOrder' then 'CD4' when short_name = 'psaTest' then 'PSA' when short_name = 'malariaTestRapid' then 'Malaria : TDR' when short_name = 'malariaResultRapid' and value_numeric ='1' then 'Malaria microscopie : Resultat negatif' when short_name = 'malariaResultRapid' and value_numeric ='2' then 'Malaria microscopie : Resultat positif' when short_name = 'malariaResultRapid' and value_numeric ='3' then 'Malaria microscopie : Resultat inconnu' when short_name = 'seroHeliTest' then 'Serologie a Helicobacter Pylori' when short_name = 'hemoglobinelectrophoresisTest' then 'Electrophorese de l\'hemoglobine' when short_name = 'asatalatTest' then 'ASAT/ALAT' when short_name = 'ureaTest' then 'Uree/Creatinine' when short_name = 'spitTest' then 'Crachats en serie' when short_name = 'serologiehivTest' then 'Serologie VIH' when short_name = 'ivaTest' then 'VIA' when short_name = 'radiographTest_specify' then concat('Radiographie: ',value_text) when short_name = 'widalTest' then 'Widal' when short_name = 'labOther1_specify' then concat('Autres: ',value_text) when short_name = 'labOther2_specify' then concat('Autres: ',value_text) when short_name = 'rr' then 'RR' when short_name = 'toxTetanus1DtToday' then 'DT/Tetanos toxoide' when short_name = 'immunOtherText1' then concat('Autre: ',value_text) when short_name = 'medicinePres1' then concat('Medicaments prescrits/Posologie(1)',value_text) when short_name = 'medicinePres2' then concat('Medicaments prescrits/Posologie(2)',value_text) when short_name = 'medicinePres3' then concat('Medicaments prescrits/Posologie(3)',value_text) when short_name = 'medicinePres4' then concat('Medicaments prescrits/Posologie(4)',value_text) when short_name = 'medicinePres5' then concat('Medicaments prescrits/Posologie(5)',value_text) when short_name = 'psychologue' then 'Psychologue' when short_name = 'progNutrition' then 'Programme de nutrition' when short_name = 'planFamily' then 'Planification familiale' when short_name = 'referenceForm' then 'Fiches de reference remplies' when short_name = 'hospitalisation' then 'Hospitalisation' when short_name = 'referClinic_specify' then concat('Autre etablissement/clinique: ',value_text) else 'xxx' end as 'conduite a tenir' FROM `obs` o, concept c, encValidAll e WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and (value_boolean = 1 or value_text is not null or value_numeric is not null) and encounterType = 28 and short_name in ( 'blood_group','ultrasoundTest_specify', 'cd4TestOrder','psaTest', 'malariaTestRapid', 'malariaResultRapid','seroHeliTest','hemoglobinelectrophoresisTest','asatalatTest','ureaTest','spitTest','serologiehivTest','ivaTest','radiographTest_specify','widalTest','labOther1_specify','labOther2_specify','rr','toxTetanus1DtToday','immunOtherText1','medicinePres1','medicinePres2','medicinePres3','medicinePres4','medicinePres5','psychologue','progNutrition','planFamily','referenceForm','hospitalisation','referClinic_specify') union select visitDate, case  when testNameEn = 'Blood Type' then 'Groupe sanguin' when testNameEn = 'C Reactive Protein (CRP)' then 'C Reactive Proteine' when testNameEn = 'Pap test' then 'PAP test' when testNameEn = 'Hemoculture' then 'Hemogramme' when testNameEn = 'Fasting Glucose' then 'Glycemie' when testNameEn = 'RPR' then 'Serologie syphilis' when testNameEn = 'PPD/Mantoux' then 'PPD' when testNameEn = 'Sickling test' then 'Sickling test' when testNameEn = 'Vaginal smear' then 'Frottis vaginal/Gouttes pendantes' when testNameEn = 'Urine' then 'Urines' when testNameEn = 'Stool' then 'Selles' when testNameEn = 'Pregnancy test' then 'Test de grossesse' when testNameEn = 'Hepatitis B, presence of:' then 'Hepatite B' else 'xxx' end as item FROM a_labs where encounterType = 28 and patientID='".$pid."' and testNameEn in ('Blood Type','C Reactive Protein (CRP)','Pap test','Hemoculture','Fasting Glucose','RPR','PPD/Mantoux','Sickling test','Vaginal smear','Urine','Stool','Pregnancy test','Hepatitis B, presence of:') order by 1 desc limit 6",
	   "tobCond" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'blood_group' then 'Groupe sanguin : '
when short_name = 'ultrasoundTest_specify'        then concat('Echographie: ',value_text)
when short_name = 'cd4TestOrder'      then 'CD4'
when short_name = 'malariaTestRapid' then 'Malaria : TDR' 
when short_name = 'malariaResultRapid' and value_numeric ='1' then 'Malaria microscopie : Resultat negatif'
when short_name = 'malariaResultRapid' and value_numeric ='2' then 'Malaria microscopie : Resultat positif'
when short_name = 'malariaResultRapid' and value_numeric ='3' then 'Malaria microscopie : Resultat inconnu'
when short_name = 'hemoglobinelectrophoresisTest' then 'Electrophorese de l\'hemoglobine'
when short_name = 'asatalatTest' then 'ASAT/ALAT'
when short_name = 'ureaTest' then 'Uree/Creatinine'
when short_name = 'prolactineTest' then 'Prolactine'
when short_name = 'fshlhTest' then 'FSH/LH'
when short_name = 'estrogenprogestoroneTest' then 'Oestrogene/Progesterone'
when short_name = 'serologiehivTest' then 'Serologie VIH'
when short_name = 'ivaTest' then 'VIA'
when short_name = 'radiographTest_specify' then concat('Radiographie: ',value_text)
when short_name = 'labOther1_specify' then concat('Autres: ',value_text)
when short_name = 'labOther2_specify' then concat('Autres: ',value_text)
when short_name = 'toxTetanus1DtToday' then 'DT/Tetanos toxoide' /*dans vaccination*/
when short_name = 'immunOtherText1' then concat('Autre: ',value_text) /*dans vaccination*/
when short_name = 'medicinePres1' then concat('Medicaments prescrits/Posologie(1) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres2' then concat('Medicaments prescrits/Posologie(2) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres3' then concat('Medicaments prescrits/Posologie(3) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres4' then concat('Medicaments prescrits/Posologie(4) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'medicinePres5' then concat('Medicaments prescrits/Posologie(5) : ',value_text) /*dans medicaments prescrits/posologie*/
when short_name = 'psychologue' then 'Psychologue' /*dans reference*/
when short_name = 'progNutrition' then 'Programme de nutrition' /*dans reference*/
when short_name = 'planFamily' then 'Planification familiale' /*dans reference*/
when short_name = 'referenceForm' then 'Fiches de reference remplies' /*dans reference*/
when short_name = 'hospitalisation' then 'Hospitalisation' /*dans reference*/
when short_name = 'referenceSTA'	then 'Salle de travail et d\'accouchement(STA)'
when short_name = 'referenceStructureCommunautaire'		then 'Structure communautaire'
when short_name = 'referClinic_specify' then concat('Autre etablissement/clinique: ',value_text) /*dans reference*/
/*dans planification familiale*/
when short_name = 'famPlanMethodCounseling' then 'Counseling effectue'
when short_name = 'beginBCDt' 	then concat('Counseling, date debut : ', cast(value_datetime as date)) 
when short_name = 'endBCDt'		then concat('Counseling, date d\'arret : ', cast(value_datetime as date))
when short_name = 'currentBCUse'	then 'Utilisation Courante'
/* pas de methode condom dans la base?*/
when short_name = 'famPlanMethodLigature'	then 'Methode PF administree, Ligature des trompes'
when short_name = 'famPlanMethodPillCombined'	then 'Methode PF administree, Pilule : Combine'
when short_name = 'famPlanMethodPillOnly'		then 'Methode PF administree, Pilule : Progestatif seule'
when short_name = 'famPlanMethodImplants'		then 'Methode PF administree, Implant'
when short_name = 'famPlanMethodSterile'		then 'Methode PF administree, Sterilet'
when short_name = 'famPlanMethodInjectable'		then 'Methode PF administree, Injectable'
when short_name = 'famPlanMethodCollier'		then 'Methode PF administree, Collier(jour fixe) :'
when short_name = 'famPlanMethodCollierDt'		then concat('date administration Methode PF, Collier :', cast(value_datetime as date))
when short_name = 'famPlanOther_specify'		then concat('Planification familiale, autre : ', value_text)
/*dans suivi et planification*/
when short_name = 'evalplanWeekOfPregnancy'		then concat('Semaine de gestation : ',value_text)
when short_name = 'evalplanRiskFactorAucune'	then 'Facteur de risque : Aucune'
when short_name = 'evalplanRiskFactorAncienne' 	then 'Facteur de risque : Ancienne cesarisee'
when short_name = 'evalplanRiskFactorAnemie'	then 'Facteur de risque : Anemie'
when short_name = 'evalplanRiskFactorDiabete'	then 'Facteur de risque : Diabete'
when short_name = 'evalplanRiskFactorOedeme'	then 'Facteur de risque : Oedeme'
when short_name = 'evalplanRiskFactorParite'	then 'Facteur de risque : Grande parite'
when short_name = 'evalplanRiskFactor18'		then 'Facteur de risque : <18 ans'
when short_name = 'evalplanRiskFactor35'		then 'Facteur de risque : >35 ans'
when short_name = 'evalplanRiskFactorMultiple'	then 'Facteur de risque : Grossesse multiple'
when short_name = 'evalplanRiskFactorAntepartum'	then 'Facteur de risque : Hemorragie antepartum'
when short_name = 'evalplanRiskFactorHypertension'	then 'Facteur de risque : Hypertension'
when short_name = 'evalplanRiskFactorPoids'		then 'Facteur de risque : Poids stationnaire'
when short_name = 'evalplanRiskFactorVIH'		then 'Facteur de risque : VIH'
when short_name = 'evalplanRiskFactorTaille'	then 'Facteur de risque : taille<150 cm'
when short_name = 'evalplanHIVCounselingPretestDate'	then concat('Counseling pretest : ',cast(value_datetime as date))
when short_name = 'evalplanHIVCounselingPosttestDate'	then concat('Counseling post test : ',cast(value_datetime as date))
when short_name = 'evalplanHIVCounselingPartner' and value_numeric = 1	then 'Reference partenaire : oui'
when short_name = 'evalplanHIVCounselingPartner' and value_numeric = 2	then 'Reference partenaire : non'
when short_name = 'evalplanHIVCounselingPartnerResult'	and value_numeric = 1 then 'Reference partenaire : positif'
when short_name = 'evalplanHIVCounselingPartnerResult'	and value_numeric = 2 then 'Reference partenaire : negatif'
when short_name = 'evalplanHIVCounselingPartnerResult'	and value_numeric = 3 then 'Reference partenaire : Indetermine'
when short_name = 'evalplanHIVCounselingReason'	 	and value_text is not null	then concat('Motif de depistage : ',value_text)
when short_name = 'evalplanHIVStage1'	then 'VIH positif, Stade OMS : Stade I'
when short_name = 'evalplanHIVStage2'	then 'VIH positif, Stade OMS : Stade II'
when short_name = 'evalplanHIVStage3'	then 'VIH positif, Stade OMS : Stade III'
when short_name = 'evalplanHIVStage4'	then 'VIH positif, Stade OMS : Stade IV'
when short_name = 'evalplanHIVStageUnknown'	then 'VIH positif, Stade OMS : Stade inconnu'
when short_name = 'evalplanCD4Count' then concat('Numeration ou taux de CD4 : ', value_text)
when short_name = 'evalplanARVYesDate'	then concat('Patiente sous ARV : oui, Date de debut ',cast(value_datetime as date))
when short_name = 'evalplanARVDate'	then concat('Patiente sous ARV : non, Date prevue pour l\'initiation de la prophylaxie ',cast(value_datetime as date)) 
when short_name = 'planCotrimoxazole'	then 'Prophylaxie : Cotrimoxazole'
when short_name = 'planAzythromycine'	then 'Prophylaxie : Azythromycine'
when short_name = 'planFluconazole'	then 'Prophylaxie : Fluconazole' 
when short_name = 'planINHprim'	then 'Prophylaxie : INH primaire'
when short_name = 'planINHsec'	then 'Prophylaxie : INH secondaire' else 'xxx'
end as 'conduite a tenir'
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null or value_numeric is not null or value_datetime is not null) and encounterType = 25 and
short_name in ( 'blood_group','ultrasoundTest_specify', 'cd4TestOrder','psaTest', 'malariaTestRapid', 'malariaResultRapid','seroHeliTest','hemoglobinelectrophoresisTest','asatalatTest','ureaTest','spitTest','serologiehivTest','ivaTest','radiographTest_specify','widalTest','labOther1_specify','labOther2_specify','rr','toxTetanus1DtToday','immunOtherText1','medicinePres1','medicinePres2','medicinePres3','medicinePres4','medicinePres5','psychologue','progNutrition','planFamily','referenceForm','hospitalisation','referClinic_specify','famPlanMethodCounseling','beginBCDt','endBCDt','currentBCUse','famPlanMethodLigature','famPlanMethodPillCombined','famPlanMethodPillOnly','famPlanMethodImplants','famPlanMethodSterile','famPlanMethodInjectable','famPlanMethodCollier','famPlanMethodCollierDt','famPlanOther_specify','evalplanWeekOfPregnancy','evalplanRiskFactorAucune','evalplanRiskFactorAncienne','evalplanRiskFactorAnemie','evalplanRiskFactorDiabete','evalplanRiskFactorOedeme','evalplanRiskFactorParite','evalplanRiskFactor18','evalplanRiskFactor35','evalplanRiskFactorMultiple','evalplanRiskFactorAntepartum','evalplanRiskFactorHypertension','evalplanRiskFactorPoids','evalplanRiskFactorVIH','evalplanRiskFactorTaille','evalplanHIVCounselingPretestDate','evalplanHIVCounselingPosttestDate','evalplanHIVCounselingPartner','evalplanHIVCounselingPartnerResult','evalplanHIVCounselingReason','evalplanHIVStage1','evalplanHIVStage2','evalplanHIVStage3','evalplanHIVStage4','evalplanHIVStageUnknown','evalplanCD4Count','evalplanARVYesDate','evalplanARVDate','planCotrimoxazole','planAzythromycine','planFluconazole','planINHprim','planINHsec','referenceSTA','referenceStructureCommunautaire')
union select visitDate, case 
when testNameEn = 'Blood Type' then 'Groupe sanguin' /* 2 fois*/
when testNameEn = 'C Reactive Protein (CRP)' then 'C Reactive Proteine'
when testNameEn = 'Pap test' then 'PAP test'
when testNameEn = 'Hemoculture' then 'Hemogramme'
when testNameEn = 'Fasting Glucose' then 'Glycemie'
when testNameEn = 'RPR' then 'Serologie syphilis'
when testNameEn = 'PPD/Mantoux' then 'PPD'
when testNameEn = 'Sickling test' then 'Sickling test'
when testNameEn = 'Vaginal smear' then 'Frottis vaginal/Gouttes pendantes'
when testNameEn = 'Urine' then 'Urines'
when testNameEn = 'Stool' then 'Selles'
when testNameEn = 'Pregnancy test' then 'Test de grossesse'
when testNameEn = 'Hepatitis B, presence of:' then 'Hepatite B' /*dans vaccination*/ else 'xxx'
end as item
FROM a_labs where encounterType = 25 and patientID='".$pid."' and testNameEn in ('Blood Type','C Reactive Protein (CRP)','Pap test','Hemoculture','Fasting Glucose','RPR','PPD/Mantoux','Sickling test','Vaginal smear','Urine','Stool','Pregnancy test','Hepatitis B, presence of:')
order by 1 desc limit 6",
	   "tpedCond" => "SELECT visitdate as 'Date de visite', case 
when short_name = 'blood_group' then 'Groupe sanguin : '
when short_name = 'ultrasoundTest_specify'        then concat('Echographie: ',value_text)
when short_name = 'cd4TestOrder'      then 'CD4'
when short_name = 'malariaTestRapid' then 'Malaria : TDR' 
when short_name = 'malariaResultRapid' and value_numeric ='1' then 'Malaria microscopie : Resultat negatif'
when short_name = 'malariaResultRapid' and value_numeric ='2' then 'Malaria microscopie : Resultat positif'
when short_name = 'malariaResultRapid' and value_numeric ='3' then 'Malaria microscopie : Resultat inconnu'
when short_name = 'seroHeliTest' then 'Serologie a Helicobacter Pylori'
when short_name = 'hemoglobinelectrophoresisTest' then 'Electrophorese de l\'hemoglobine'
when short_name = 'ureaTest' then 'Uree/Creatinine'
when short_name = 'spitTest' then 'Crachats en serie'
when short_name = 'serologiehivTest' then 'Serologie VIH'
when short_name = 'radiographTest_specify' then concat('Radiographie: ',value_text)
when short_name = 'widalTest' then 'Widal'
when short_name = 'labOther1_specify' then concat('Autres: ',value_text)
when short_name = 'labOther2_specify' then concat('Autres: ',value_text)
when short_name = 'medicinePres1' then concat('Medicaments prescrits/Posologie(1)',value_text)
when short_name = 'medicinePres2' then concat('Medicaments prescrits/Posologie(2)',value_text)
when short_name = 'medicinePres3' then concat('Medicaments prescrits/Posologie(3)',value_text)
when short_name = 'medicinePres4' then concat('Medicaments prescrits/Posologie(4)',value_text)
when short_name = 'medicinePres5' then concat('Medicaments prescrits/Posologie(5)',value_text)
when short_name = 'nutritionalSupport' and value_numeric = 2 then 'Support nutritionnel : non'
when short_name = 'nutritionalSupport' and value_numeric = 1 then 'Support nutritionnel : oui'
when short_name = 'nutritionalSupportEnrichedMilk'	then 'Support nutritionnel : Lait enrichi'
when short_name = 'nutritionalSupportLM'	then 'Support nutritionnel : Preparation pour nourissons(LM)'
when short_name = 'nutritionalSupportMedicaMamba'	then 'Support nutritionnel : Medica Mamba'
when short_name = 'nutritionalSupportDryRations'	then 'Support nutritionnel : Ration seche'
when short_name = 'nutritionalSupportOther_specify'	then concat('Support nutritionnel : ',value_text)
when short_name = 'progNutrition' then 'Programme de nutrition'
when short_name = 'referenceForm' then 'Fiches de reference remplies'
when short_name = 'hospitalisation' then 'Hospitalisation'
when short_name = 'referOtherService_specify' then concat('Autres services : ', value_text)
when short_name = 'referenceVaccination'	then 'Vaccination'
when short_name = 'referClinic_specify' then concat('Autre etablissement/clinique: ',value_text) else 'xxx'
end as 'conduite a tenir'
FROM `obs` o, concept c, encValidAll e 
WHERE e.sitecode = o.location_id and e.encounter_id = o.encounter_id and o.concept_id = c.concept_id and e.patientid = '".$pid."' and
(value_boolean = 1 or value_text is not null or value_numeric is not null) and encounterType = 31 and
short_name in ( 'blood_group','ultrasoundTest_specify', 'cd4TestOrder','malariaTestRapid', 'malariaResultRapid','seroHeliTest','hemoglobinelectrophoresisTest','ureaTest','spitTest','serologiehivTest','radiographTest_specify','widalTest','labOther1_specify','labOther2_specify','medicinePres1','medicinePres2','medicinePres3','medicinePres4','medicinePres5','progNutrition','referenceForm','hospitalisation','referClinic_specify','nutritionalSupport','nutritionalSupportEnrichedMilk','nutritionalSupportLM','nutritionalSupportMedicaMamba','nutritionalSupportDryRations','nutritionalSupportOther_specify','referOtherService_specify','referenceVaccination')
union select visitDate, case 
when testNameEn = 'Blood Type' then 'Groupe sanguin'
when testNameEn = 'C Reactive Protein (CRP)' then 'C Reactive Proteine'
when testNameEn = 'Hemoculture' then 'Hemogramme'
when testNameEn = 'Fasting Glucose' then 'Glycemie'
when testNameEn = 'RPR' then 'Serologie syphilis'
when testNameEn = 'PPD/Mantoux' then 'PPD'
when testNameEn = 'Sickling test' then 'Sickling test'
when testNameEn = 'Vaginal smear' then 'Frottis vaginal/Gouttes pendantes'
when testNameEn = 'Urine' then 'Urines'
when testNameEn = 'Stool' then 'Selles'
when testNameEn = 'Pregnancy test' then 'Test de grossesse' else 'xxx'
end as item
FROM a_labs where encounterType = 31 and patientID='".$pid."' and testNameEn in ('Blood Type','C Reactive Protein (CRP)','Pap test','Hemoculture','Fasting Glucose','RPR','PPD/Mantoux','Sickling test','Vaginal smear','Urine','Stool','Pregnancy test','Hepatitis B, presence of:')
order by 1 desc limit 6"
	   );
  
  $demographics = outputQueryRows($queryArray["demographics"]);
  $meds =         outputQueryRows($queryArray["meds"]); 
  $vitals =       outputQueryRows($queryArray["vitals"]);
  $obVitals =     outputQueryRows($queryArray["obVitals"]); 
  $pedVitals =    outputQueryRows($queryArray["pedVitals"]);   
  $tvitals =      outputQueryRows($queryArray["tvitals"]);
  $relatives =    outputQueryRows($queryArray["relatives"]); 
  $labs =         outputQueryRows($queryArray["labs"]); 
  $visits =       outputQueryRows($queryArray["visits"]);
  $obGyn =        outputQueryRows($queryArray["obGyn"]);
  $antHeC = 	  outputQueryRows($queryArray["antHeC"]);
  $antPe =		  outputQueryRows($queryArray["antPe"]);
  $obAntPe =	  outputQueryRows($queryArray["obAntPe"]);
  $pedAntPe =	  outputQueryRows($queryArray["pedAntPe"]);
  $pedAlim = 	  outputQueryRows($queryArray["pedAlim"]);
  $consCa =		  outputQueryRows($queryArray["consCa"]);
  $obConsCa =	  outputQueryRows($queryArray["obConsCa"]);
  $pedConsCa =	  outputQueryRows($queryArray["pedConsCa"]);
  $tconsCa =	  outputQueryRows($queryArray["tconsCa"]);
  $physEx = 	  outputQueryRows($queryArray["physEx"]);
  $obPhysEx =	  outputQueryRows($queryArray["obPhysEx"]);
  $pedPhysEx =	  outputQueryRows($queryArray["pedPhysEx"]);
  $tphysEx = 	  outputQueryRows($queryArray["tphysEx"]);
  $pedPsychoDev = outputQueryRows($queryArray["pedPhysEx"]);
  $diag = 		  outputQueryRows($queryArray["diag"]);
  $obDiag =		  outputQueryRows($queryArray["obDiag"]);
  $pedDiag =	  outputQueryRows($queryArray["pedDiag"]);
  $tdiag = 		  outputQueryRows($queryArray["tdiag"]);
  $cond = 		  outputQueryRows($queryArray["cond"]);
  $obCond = 	  outputQueryRows($queryArray["obCond"]);
  $pedCond = 	  outputQueryRows($queryArray["pedCond"]);
  $tcond = 		  outputQueryRows($queryArray["tcond"]);
  
  if (isPediatric($pid)) {
$pedVitals = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$vitalsTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ped. Vitals. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedVitals .= outputQueryRows($queryArray["pedVitals"]);
} else $pedVitals = '';

if (isPediatric($pid)) {
$tpedVitals = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$vitalsTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ped. Vitals. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedVitals .= outputQueryRows($queryArray["tpedVitals"]);
} else $tpedVitals = '';

if (isPediatric($pid)) {
$pedAntPe = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$antPeTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ped. Ant. Perso data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedAntPe .= outputQueryRows($queryArray["pedAntPe"]);
} else $pedAntPe = '';  

if (isPediatric($pid)) {
$pedAlim = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedAlimTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ped. Histoire Alimentaire data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedAlim .= outputQueryRows($queryArray["pedAlim"]);
} else $pedAlim = ''; 

if (isPediatric($pid)) {
$tpedAlim = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$tpedAlimTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ped. Histoire Alimentaire data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedAlim .= outputQueryRows($queryArray["tpedAlim"]);
} else $tpedAlim = '';  
  
  if (isPediatric($pid)) {
$pedVacc = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedVaccTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vaccination. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedVacc .= outputQueryRows($queryArray["pedVacc"]);
} else $pedVacc = '';

if (isPediatric($pid)) {
$tpedVacc = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedVaccTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vaccination. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedVacc .= outputQueryRows($queryArray["tpedVacc"]);
} else $tpedVacc = '';

if (isPediatric($pid)) {
$pedVita = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedVitaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Supplement en vit. A data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedVita .= outputQueryRows($queryArray["pedVita"]);
} else $pedVita = '';

if (isPediatric($pid)) {
$tpedVita = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedVitaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Supplement en vit. A data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedVita .= outputQueryRows($queryArray["tpedVita"]);
} else $tpedVita = ''; 

if (isPediatric($pid)) {
$pedPhysEx = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$physExTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Examens physiques. data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedPhysEx .= outputQueryRows($queryArray["pedPhysEx"]);
} else $pedPhysEx = ''; 

if (isPediatric($pid)) {
$tpedPhysEx = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$physExTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Examens physiques. data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedPhysEx .= outputQueryRows($queryArray["tpedPhysEx"]);
} else $tpedPhysEx = ''; 

if (isPediatric($pid)) {
$pedPsychoDev = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedPsychoDevTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Evaluation dvpt psychomoteur . data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedPsychoDev .= outputQueryRows($queryArray["pedPsychoDev"]);
} else $pedPsychoDev = '';

if (isPediatric($pid)) {
$tpedPsychoDev = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$pedPsychoDevTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Evaluation dvpt psychomoteur . data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedPsychoDev .= outputQueryRows($queryArray["tpedPsychoDev"]);
} else $tpedPsychoDev = ''; 

if (isPediatric($pid)) {
$pedCond = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$condTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir. data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedCond .= outputQueryRows($queryArray["pedCond"]);
} else $pedCond = '';

if (isPediatric($pid)) {
$tpedCond = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$condTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir. data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedCond .= outputQueryRows($queryArray["tpedCond"]);
} else $tpedCond = ''; 

if (isPediatric($pid)) {
$pedDiag = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$diagTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Diagnostic. data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedDiag .= outputQueryRows($queryArray["pedDiag"]);
} else $pedDiag = ''; 

if (isPediatric($pid)) {
$tpedDiag = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$diagTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Diagnostic. data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedDiag .= outputQueryRows($queryArray["tpedDiag"]);
} else $tpedDiag = ''; 

if (isObgyn($pid)) {
$antOb = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$antObTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ant. Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$antOb .= outputQueryRows($queryArray["antOb"]);
} else $antOb = '';

if (isObgyn($pid)) {
$obVacc = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$obGynVaccTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vaccins data pour patients Obst-gyn goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obVacc .= outputQueryRows($queryArray["obVacc"]);
} else $obVacc = '';

if (isObgyn($pid)) {
$obVitals = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$vitalsTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients Obst-gyn goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obVitals .= outputQueryRows($queryArray["obVitals"]);
} else $obVitals = '';

if (isObgyn($pid)) {
$tobVitals = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$vitalsTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients Obst-gyn goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tobVitals .= outputQueryRows($queryArray["tobVitals"]);
} else $tobVitals = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$antPe = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$antPeTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ant. personnels pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$antPe .= outputQueryRows($queryArray["antPe"]);
} else $antPe = '';

if (isObgyn($pid)) {
$obAntPe = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$antPeTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Ant. Pe pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obAntPe .= outputQueryRows($queryArray["obAntPe"]);
} else $obAntPe = '';

if (isObgyn($pid)) {
$obConsCa = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$consCaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Motifs de consultation pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obConsCa .= outputQueryRows($queryArray["obConsCa"]);
} else $obConsCa = '';

if (isObgyn($pid)) {
$tobConsCa = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$consCaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Motifs de consultation pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tobConsCa .= outputQueryRows($queryArray["tobConsCa"]);
} else $tobConsCa = '';

if (isObgyn($pid)) {
$obPhysEx = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$physExTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Examens physiques pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obPhysEx .= outputQueryRows($queryArray["obPhysEx"]);
} else $obPhysEx = '';

if (isObgyn($pid)) {
$tobPhysEx = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$physExTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Examens physiques pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tobPhysEx .= outputQueryRows($queryArray["tobPhysEx"]);
} else $tobPhysEx = '';

if (isObgyn($pid)) {
$obCond = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$condTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obCond .= outputQueryRows($queryArray["obCond"]);
} else $obCond = '';

if (isObgyn($pid)) {
$tobCond = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$condTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tobCond .= outputQueryRows($queryArray["tobCond"]);
} else $tobCond = '';

if (isObgyn($pid)) {
$obDiag = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$diagTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Diagnostics pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$obDiag .= outputQueryRows($queryArray["obDiag"]);
} else $obDiag = '';

if (isObgyn($pid)) {
$tobDiag = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$diagTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Diagnostics pour patients Obst-gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tobDiag .= outputQueryRows($queryArray["tobDiag"]);
} else $tobDiag = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$vitals = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$vitalsTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vitals pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$vitals .= outputQueryRows($queryArray["vitals"]);
} else $vitals = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$tvitals = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$vitalsTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Vitals pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tvitals .= outputQueryRows($queryArray["tvitals"]);
} else $tvitals = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$consCa = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$consCaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Motifs de consultation pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$consCa .= outputQueryRows($queryArray["consCa"]);
} else $consCa = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$tconsCa = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$consCaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Motifs de consultation pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tconsCa .= outputQueryRows($queryArray["tconsCa"]);
} else $tconsCa = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$physEx = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$physExTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Examens physiques pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$physEx .= outputQueryRows($queryArray["physEx"]);
} else $physEx = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$tphysEx = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$physExTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Examens physiques pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tphysEx .= outputQueryRows($queryArray["tphysEx"]);
} else $tphysEx = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$diag = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$diagTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Impr. cliniques/diagnostics pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$diag .= outputQueryRows($queryArray["diag"]);
} else $diag = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$tdiag = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$diagTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Impr. cliniques/diagnostics pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tdiag .= outputQueryRows($queryArray["tdiag"]);
} else $tdiag = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$cond = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$condTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$cond .= outputQueryRows($queryArray["cond"]);
} else $cond = '';

if (!(isObgyn($pid) or isPediatric($pid))) {
$tcond = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$condTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir pour patients non obgyn et non ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tcond .= outputQueryRows($queryArray["tcond"]);
} else $tcond = '';

if (isPediatric($pid)) {
$pedConsCa = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$consCaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Motifs de consultation pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$pedConsCa .= outputQueryRows($queryArray["pedConsCa"]);
} else $pedConsCa = '';

if (isPediatric($pid)) {
$tpedConsCa = '
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
 <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">'.$consCaTitle.'</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Motifs de consultation pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->';
$tpedConsCa .= outputQueryRows($queryArray["tpedConsCa"]);
} else $tpedConsCa = '';

  $summary = <<<EOF
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
    a {text-decoration: none}
  </style>
</head>
<body text="#000000" link="#000000" alink="#000000" vlink="#000000">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width: 50%"><span style="font-family: Lucida Console; font-size: 12.0px;">$siteName</span></td>
  <td style="width: 50%;text-align: right;"><span style="font-family: Lucida Console; font-size: 12.0px;">$summaryFor:</span></td>
</tr>
<tr valign="top">
  <td style="width: 50%;text-align: justify;"><span style="font-family: Lucida Console; font-size: 12.0px;">$dateTime</span></td>
  <td style="width:50%;text-align: right;"><span style="font-family: Lucida Console; font-size: 12.0px;">$nameAndId</span></td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 16.0px; font-weight: bold;">$title</span></td>
</tr>
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; color: #CC0000; font-size: 14.0px; font-weight: bold;">$noteLine1</span></td>
</tr>
<tr valign="top">
  <td colspan="86" style="text-align: center;"><span style="font-family: Lucida Console; color: #CC0000; font-size: 14.0px; font-weight: bold;">$noteLine2</span></td>
</tr>
<tr valign="top">
  <td colspan="86" style="text-align: center;"><span style="font-family: Lucida Console; color: #CC0000; font-size: 14.0px; font-weight: bold;">$noteLine3</span></td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">$demographicsTitle</span></td>
</tr>
</table>

<!-- ********************************************************************* -->
<!-- ****************** Demographic data goes here *********************** -->
<!-- ********************************************************************* -->
$demographics

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">$visitsTitle</span></td>
</tr>
<tr valign="top">
  <td colspan="86" style="text-align: center;"><span style="font-family: Lucida Console; font-size: 12.0px; font-weight: bold;">$visitsSubTitle</span></td>
</tr> 
</table>

<!-- ********************************************************************* -->
<!-- ****************** Visit data goes here ***************************** -->
<!-- ********************************************************************* -->
$visits

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">$antHeCTitle</span></td>
</tr> 
</table>

<!-- ********************************************************************* -->
<!-- ****************** HC antecedents data goes here ************************ -->
<!-- ********************************************************************* -->
$antHeC


<!-- ********************************************************************* -->
<!-- ****************** antecedents personnels data pour patients non obstetrico-gynecologiques, non ped. goes here ************************ -->
<!-- ********************************************************************* -->
$antPe

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients non obstetrico-gynecologiques, non ped. goes here ************************ -->
<!-- ********************************************************************* -->
$vitals

<!-- ********************************************************************* -->
<!-- ****************** Ant. Personnels pour patients Obst-gyn data goes here ************************ -->
<!-- ********************************************************************* -->
$obAntPe

<!-- ********************************************************************* -->
<!-- ****************** Ant. Personnels pour patients Ped. data goes here ************************ -->
<!-- ********************************************************************* -->
$pedAntPe

<!-- ********************************************************************* -->
<!-- ****************** Histoire alimentaire pour patients Ped. data goes here ************************ -->
<!-- ********************************************************************* -->
$pedAlim

<!-- ********************************************************************* -->
<!-- ****************** Ant. Obst-gyn data goes here ************************ -->
<!-- ********************************************************************* -->
$antOb

<!-- ********************************************************************* -->
<!-- ****************** Vaccins data pour patients Obst-gyn goes here ************************ -->
<!-- ********************************************************************* -->
$obVacc

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients Obst-gyn goes here ************************ -->
<!-- ********************************************************************* -->
$obVitals

<!-- ********************************************************************* -->
<!-- ****************** Vaccination data goes here ************************ -->
<!-- ********************************************************************* -->
$pedVacc

<!-- ********************************************************************* -->
<!-- ****************** Supplement en vit. A data goes here ************************ -->
<!-- ********************************************************************* -->
$pedVita

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients pediatriques goes here ************************ -->
<!-- ********************************************************************* -->
$pedVitals

<!-- ********************************************************************* -->
<!-- ****************** Consultation causes data pour patients non obgyn et non ped goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$consCa

<!-- ********************************************************************* -->
<!-- ****************** Consultation causes pour patients Obst-gyn goes here ************************ -->
<!-- ********************************************************************* -->
$obConsCa

<!-- ********************************************************************* -->
<!-- ****************** Consultation causes pour patients Ped. goes here ************************ -->
<!-- ********************************************************************* -->
$pedConsCa


<!-- ********************************************************************* -->
<!-- ****************** Physical Exam data pour patients non obgyn et non ped goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$physEx

<!-- ********************************************************************* -->
<!-- ****************** Physical Exam data pour patients Obst-gyn goes here ************************ -->
<!-- ********************************************************************* -->
$obPhysEx

<!-- ********************************************************************* -->
<!-- ****************** Physical Exam data pour patients Ped. goes here ************************ -->
<!-- ********************************************************************* -->
$pedPhysEx

<!-- ********************************************************************* -->
<!-- ****************** Evaluation devpt. psychomoteur data pour patients Ped. goes here ************************ -->
<!-- ********************************************************************* -->
$pedPsychoDev

<!-- ********************************************************************* -->
<!-- ****************** Diagnostic data pour patients non obgyn et non ped goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$diag

<!-- ********************************************************************* -->
<!-- ****************** Diagnostic data pour patients Obst-gyn goes here ************************ -->
<!-- ********************************************************************* -->
$obDiag

<!-- ********************************************************************* -->
<!-- ****************** Diagnostic data pour patients Ped. goes here ************************ -->
<!-- ********************************************************************* -->
$pedDiag


<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$cond

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir pour patients Obst-gyn goes here ************************ -->
<!-- ********************************************************************* -->
$obCond

<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir pour patients Ped. goes here ************************ -->
<!-- ********************************************************************* -->
$pedCond


<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">$tvisitsTitle</span></td>
</tr>

<!-- ********************************************************************* -->
<!-- ****************** Vitals data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tvitals

<!-- ********************************************************************* -->
<!-- ****************** Histoire alimentaire pour patients Ped. data goes here ************************ -->
<!-- ********************************************************************* -->
$tpedAlim

<!-- ********************************************************************* -->
<!-- ****************** Vaccination pour patients Ped. data goes here ************************ -->
<!-- ********************************************************************* -->
$tpedVacc

<!-- ********************************************************************* -->
<!-- ****************** Supplement alimentaire pour patients Ped. data goes here ************************ -->
<!-- ********************************************************************* -->
$tpedVita

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients pediatriques goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tpedVitals

<!-- ********************************************************************* -->
<!-- ****************** Vitals data pour patients ob/gyn goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tobVitals


<!-- ********************************************************************* -->
<!-- ****************** Consultation causes data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tconsCa

<!-- ********************************************************************* -->
<!-- ****************** Consultation causes pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tpedConsCa

<!-- ********************************************************************* -->
<!-- ****************** Consultation causes pour patients ob/gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tobConsCa


<!-- ********************************************************************* -->
<!-- ****************** Physical Exam data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tphysEx

<!-- ********************************************************************* -->
<!-- ****************** Physical Exam pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tpedPhysEx

<!-- ********************************************************************* -->
<!-- ****************** Eval. dvpt psychomoteur pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tpedPsychoDev

<!-- ********************************************************************* -->
<!-- ****************** Physical Exam pour patients ob/gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tobPhysEx


<!-- ********************************************************************* -->
<!-- ****************** Diagnostic data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tdiag

<!-- ********************************************************************* -->
<!-- ****************** Diagnostics pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tpedDiag

<!-- ********************************************************************* -->
<!-- ****************** Diagnostics pour patients ob/gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tobDiag


<!-- ********************************************************************* -->
<!-- ****************** Conduite a tenir data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tcond

<!-- ********************************************************************* -->
<!-- ****************** Diagnostics pour patients ped. data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tpedCond

<!-- ********************************************************************* -->
<!-- ****************** Diagnostics pour patients ob/gyn data goes here, if applicable ********** -->
<!-- ********************************************************************* -->
$tobCond

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">$labsTitle</span></td>
</tr> 
</table>

<!-- ********************************************************************* -->
<!-- ****************** Labs result data goes here ************************ -->
<!-- ********************************************************************* -->
$labs

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
  <td style="width:100%;text-align: center;padding-top:12px;"><span style="font-family: Lucida Console; font-size: 14.0px; font-weight: bold;">$medsTitle</span></td>
</tr> 
</table>

<!-- ********************************************************************* -->
<!-- ****************** Medication data goes here ************************ -->
<!-- ********************************************************************* -->
$meds 

</body>
</html>
EOF;

  return ($summary);
}

function outputQueryRows($qry) {
        $output = '';
        // execute the query 
        $arr = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC); 
        if (count($arr) == 0) return '<p><center><font color="red"><bold>Aucuns résultats trouvés</bold></font></center><p>';
        // set up the table
        $output = '<center><table border="1">';
        // loop on the results 
        $i = 0;
        foreach($arr as $row) {
               if ($i == 0) { 
                       // output the column header 
                       $output .= '<tr>';
                       foreach($row as $key => $value) $output .= '<th>' . $key . '</th>';
                       $output .= '</tr>'; 
                       $i++;
               } 
               $output .= '<tr>';
               foreach($row as $key => $value) $output .= '<td>' . $value . '</td>';
               $output .= '</tr>';
        }
        // close the table 
        $output .= '</table></center>';
        return $output;
}
?>
