<?php

#this first group should probably all be dynamic configuration parameters
define('CONSOLIDATED_DB', 'itech');
define("PATIENT_TRANSFER_KEY", "aLShh9QZ3Z98UImP");
define("CONSOLIDATED_SERVER", "isante.ugp.ht/consolidatedId/isante");
define("NATIONAL_IDENTIFIED_SERVER", "isante.ugp.ht/consolidatedId/isante");

define('EXTJS_VERSION', '3.4.0');
define('EXTJS_ADAPTER', 'adapter/jquery/ext-jquery-adapter.js');
define('JQUERY_VERSION', '1.7.2.min');
define('HIGHCHARTS_VERSION', '2.2.3');

define ("ENCOUNTERS_PER_PAGE", 20);
define ("ENCOUNTERS_IN_MENU", 5);
define ("PATIENTS_PER_PAGE", 20 );
define ("MAX_REPORT_ROWS", 3000 );
define ("ERR_COLOR", "#DD3344");
define ("MENU_ERR_COLOR", "#FF7777");
define ("MENU_REV_COLOR", "#EEEE77");
define ("MENU_DEL_COLOR", "#C0C0C0");
define ("JASPER_RENDERER", "./jrReport.php");
define ("PREGNANT_TARGET", "CASE WHEN pregnant = 1 THEN 'Oui' ELSE 'Non' END");
define ("GENDER_TARGET", "CASE WHEN sex = 1 THEN 'F' WHEN sex = 2 THEN CASE WHEN LOWER('lang') = 'fr' THEN 'H' ELSE 'M' END ELSE CASE WHEN LOWER('lang') = 'fr' THEN 'I' ELSE 'U' END END");
define ("PERCENT_TARGET", "left(convert(varchar,convert(float,count(COUNTTARGET))/TOTAL.*100.),4)");
define ("DATA_ENTRY", "-1");
define ("READ", "0");
define ("READ_WRITE", "1");
define ("ADMIN", "2");
define ("ADMINPLUS", "3");
define ("CD4_350_DATE", "2009-12-31");
define ("PMTCT_14_WEEKS_DATE", "2010-12-31");
define ("IMM_2009_DATE", "2009-06-30");
define ("DAYS_IN_YEAR", "365.242199");
define ("DAYS_IN_MONTH", "30.4368");
define ("TB_SYMP_EVAL_DATE", "2010-12-31");
define ("OPTION_B_PLUS_DATE", "2012-03-31");
define ("AGE_DIST_TARGET2","
CASE
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 0 and 14 THEN '0-14'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 0 and 14 THEN '0-14'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 0 and 14 THEN '0-14'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 15 and 20 THEN '15-20'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 15 and 20 THEN '15-20'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 15 and 20 THEN '15-20'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 21 and 30 THEN '21-30'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 21 and 30 THEN '21-30'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 21 and 30 THEN '21-30'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 31 and 40 THEN '31-40'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 31 and 40 THEN '31-40'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 31 and 40 THEN '31-40'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 41 and 50 THEN '41-50'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 41 and 50 THEN '41-50'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 41 and 50 THEN '41-50'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 51 and 60 THEN '51-60'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 51 and 60 THEN '51-60'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 51 and 60 THEN '51-60'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 61 and 70 THEN '61-70'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 61 and 70 THEN '61-70'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 61 and 70 THEN '61-70'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 71 and 80 THEN '71-80'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 71 and 80 THEN '71-80'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 71 and 80 THEN '71-80'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 81 and 90 THEN '81-90'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 81 and 90 THEN '81-90'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 81 and 90 THEN '81-90'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 91 and 100 THEN '91-100'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 91 and 100 THEN '91-100'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 91 and 100 THEN '91-100'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) between 101 and 110 THEN '101-110'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) between 101 and 110 THEN '101-110'
WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 AND DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) between 101 and 110 THEN '101-110'
ELSE 'inconnu'
END");

$tables = array ("adherenceCounseling", "allergies", "allowedDisclosures", "arvAndPregnancy", "arvEnrollment", "buddies", "comprehension", "conditions", "discEnrollment", "drugs", "followupTreatment", "homeCareVisits", "householdComp", "immunizations", "labs", "medicalEligARVs", "needsAssessment", "otherDrugs", "otherLabs", "otherPrescriptions", "patientEducation", "pedHistory", "pedLabs", "prescriptions", "referrals", "tbStatus", "vitals", "riskAssessment", "riskAssessments", "prescriptionOtherFields", "otherImmunizations");

$norm_tables = array ("allergies", "allowedDisclosures", "conditions", "drugs", "householdComp", "immunizations", "labs", "otherDrugs", "otherLabs", "otherPrescriptions", "pedLabs", "prescriptions", "referrals", "riskAssessments", "obs", "otherImmunizations");

$arvs = array (
  "abacavir", "combivir", "didanosine", "emtricitabine", "lamivudine", "stavudine", "tenofovir", "trizivir", "zidovudine",
  "subhead5", "efavirenz", "nevirapine",
  "subhead16", "atazanavir", "atazanavirPlusBostRtv", "indinavir", "indinavirPlusBostRtv", "lopinavirPlusBostRtv", "other1", "other2");

//no of elements in each arv section/subhead. Has to be reviewed/updated when arvs array is updated
$arvSubHeadElems = array(9,2,7);

$pedArvList = array ("abacavir", "combivir", "didanosine", "emtricitabine", "lamivudine", "stavudine", "tenofovir", "trizivir", "zidovudine",
	"subhead5", "efavirenz", "nevirapine", "subhead16", "atazanavir", "atazanavirPlusBostRtv", "indinavir", "indinavirPlusBostRtv", "lopinavirPlusBostRtv", "other1");

//no of elements in each arv section/subhead. Has to be reviewed/updated when arvs array is updated
$pedArvSubHeadElems = array(9,2,6);

$rxs = array ("abacavir", "combivir", "didanosine", "emtricitabine", "lamivudine", "stavudine", "trizivir", "zidovudine", "tenofovir",
  "subhead4", "efavirenz", "nevirapine",
  "subhead5", "atazanavir", "atazanavirPlusBostRtv", "indinavir", "indinavirPlusBostRtv", "lopinavirPlusBostRtv");
$rxs_1 = array ("abacavir", "combivir", "didanosine", "emtricitabine", "lamivudine", "stavudine", "tenofovir", "trizivir", "zidovudine",
  "subhead4", "efavirenz", "nevirapine",
  "subhead5", "atazanavir", "atazanavirPlusBostRtv", "indinavir", "indinavirPlusBostRtv", "lopinavirPlusBostRtv");

//no of elements in each rx section/subhead. Has to be reviewed/updated when rxs array is updated
$rxSubHeadElems = array(9,2,5);

$pedRxs = array ("abacavir", "combivir", "didanosine", "emtricitabine", "lamivudine", "stavudine", "trizivir", "zidovudine", "tenofovir", "subhead4", "efavirenz", "nevirapine", "subhead16", "lopinavirPlusBostRtv", "nelfinavir", "saquinavir", "ritonavir2");

//no of elements in each rx section/subhead. Has to be reviewed/updated when rxs array is updated
$pedRxSubHeadElems = array(14,4,7);

$other_rxs = array ("subhead10", "acetaminophen", "aspirin", "ibuprofen", "paracetamol", "tylenol",
	"subhead101","hydroxalum","subhead102","enalapril", "hctz", "subhead11", "albendazol", "ciprofloxacin", "erythromycin", "metromidazole","doxycycline","pnc",
	"subhead12", "cotrimoxazole", "fluconazole", "ketaconazole", "miconazole", "nystatin",
	"subhead13", "ethambutol", "isoniazid", "pyrazinamide", "rifampicine", "streptomycine",
	"subhead14", "bcomplex", "folicacid", "iron", "multivitamin", "proteinsupplement", "vitaminc",
	"subhead15", "acyclovir", "loperamide", "promethazine","calamine","bromhexine","benzyl",
	"subhead9", "other1", "other2", "other3", "other4", "other5");
$other_rxs_1 = array ("subhead10", "acetaminophen", "aspirin",
	"subhead101","hydroxalum","subhead102","enalapril", "hctz",
	"subhead11", "amoxicilline" , "ciprofloxacin", "clarithromycin", "clindamycine", "cotrimoxazole", "erythromycin", "metromidazole","doxycycline","pnc",
	"subhead12", "amphotericineb", "fluconazole", "itraconazole", "ketaconazole", "miconazole", "nystatin",
	"subhead100", "albendazol", "chloroquine","ivermectine", "primaquine", "pyrimthamine", "quinine", "sulfadiazine",
	"subhead13", "ethambutol", "isoniazid", "pyrazinamide", "rifampicine", "streptomycine",
	"subhead14", "folicacid", "bcomplex", "iron", "multivitamin", "pyridoxine", "proteinsupplement", "vitaminc",
	"subhead15", "acyclovir", "loperamide", "promethazine","calamine","bromhexine","benzyl",
	"subhead9", "other1", "other2", "other3", "other4", "other5");

$pedOther_rxs = array ("subhead1", "asa", "diclofenac", "ibuprofen", "paracetamol",
	"subhead2", "amoxicilline", "amoxicillineclav", "azithromycin", "ciprofloxacin", "clarithromycin", "cotrimoxazole", "erythromycin",
	"subhead3", "amphotericineb", "fluconazole", "itraconazole", "ketaconazole", "miconazole", "nystatin",
	"subhead4", "ethambutol", "isoniazid", "pyrazinamide", "rifampicine", "streptomycine",
	"subhead5", "albendazol", "chloroquine", "ivermectine", "mebendazole", "metromidazole", "primaquine", "pyrimthamine", "quinine", "sulfadiazine",
	"subhead6", "folicacid", "bcomplex", "iron", "multivitamin", "proteinsupplement",
	"subhead7", "acyclovir", "loperamide", "promethazine", "other1", "other2", "other3", "other4", "other5");

//in the future, think about selecting this from the database
//in the lablookup table, the field version[x], instead of a flag, could show the order in which the fields should be displayed
//and have -1 to flag fields that do not belong to that version.
//the content of the following arrays would come from the labName field of the lablookup table

$labs0 = array ("rapidHiv", "elisa", "cd4", "viralLoad",
	"subhead3", "bloodtype", "aso","ccmh","tcmh","vgm", "reticulocyte", "sickling", "wbc", "lymphocytes", "monocytes", "polymorphs", "eospinophils", "basophils", "hematocrit", "platelets", "esr",
	"subhead4", "sodium", "potassium", "chlorine", "bicarbonate", "bloodUrea","creatinine","crp", "randomGlucose", "fastingGlucose",
	"subhead5", "astSgot","altSgpt", "totalBilirubin", "amylase",
	"subhead6", "totalCholesterol", "ldl","hdl", "triglyceride", "rpr",
	"subhead7", "ppdMantoux", "sputum", "malaria", "malariaRapid", "toxoplasmosis", "pregnancy", "frottisvaginal","phosphatasealcaline", "otherLab2");

$labs1 = array ("rapidHiv", "elisa", "cd4", "viralLoad",
	"subhead31", "wbc","lymphocytes", "monocytes", "polymorphsEospinophils", "polymorphsNeutrophils","polymorphsBasophils", "hematocrit", "hemoglobine", "platelets", "esr","reticulocyte", "electrophorese", "bloodtype","aso","ccmh","tcmh","vgm",
	"subhead4", "sodium","potassium", "chlorine", "bicarbonate", "bloodUrea", "creatinine","crp","randomGlucose", "fastingGlucose",
	"subhead5", "astSgot", "altSgpt","totalBilirubin", "amylase", "lipase",
	"subhead6", "totalCholesterol", "ldl","hdl", "triglyceride",
	"subhead61", "hepatitisA", "hepatitisB", "hepatitisC",
	"subhead7", "rpr", "ppdMantoux", "sputum", "hemoculture", "malaria", "malariaRapid", "toxoplasmosis", "pregnancy", "sickling","phosphatasealcaline", "otherLab2");

$pedLabs = array ("rapidHiv", "elisa", "cd4", "viralLoad", "pcr", "antigen",
	"subhead31", "wbc", "lymphocytes", "monocytes", "polymorphsEospinophils", "polymorphsNeutrophils", "polymorphsBasophils", "hematocrit", "hemoglobine", "platelets", "esr", "reticulocyte", "electrophorese", "bloodtype",
	"subhead4", "sodium", "potassium", "chlorine", "bicarbonate", "bloodUrea", "creatinine", "randomGlucose", "fastingGlucose", "crp",
	"subhead5", "astSgot", "altSgpt", "totalBilirubin",
	"subhead6", "totalCholesterol", "ldl", "hdl", "triglyceride",
	"subhead61", "hepatitisA", "hepatitisB", "hepatitisC",
	"subhead7", "rpr", "ppdMantoux", "sputum", "hemoculture", "malaria", "malariaRapid", "toxoplasmosis", "pregnancy", "measles", "cytomegalovirus", "amylase", "lipase", "otherLab1", "otherLab2");

$langs = array ("en", "fr");
$def_lang = "fr";

$max_allergies = 3;
$max_otherDrugs = 3;
$max_otherRxs = 9;
$max_otherLabs = 2;
$max_householdComp = 10;
$max_disclose = 4;
$max_infoChange = 2;
$max_immunizations = 4; 
$max_otherImmunizations = 3;
$max_pedLabs = 3;

$encType = array (
"en" => array (
	"0" => "Search",
	"1" => "Adult Intake",
	"2" => "Followup",
	"3" => "Couns. Intake",
	"4" => "Couns. Followup",
	"5" => "Prescription",
	"6" => "Laboratory",
	"7" => "Home Visit",
	"9" => "Referral Tracking",
	"10" => "Registration",
	"11" => "Selection Committee Report",
	"12" => "Discontinuation",
        "13" => "External Lab Results",
	"14" => "Adherence",
	"15" => "Pediatric Registration",
	"16" => "Pediatric Intake",
	"17" => "Pediatric Followup",
	"18" => "Pediatric Prescription",
	"19" => "Pediatric Laboratory",
	"20" => "Pediatric Adherence",
	"21" => "Pediatric Discontinuation",
	"22" => "Show all forms",
	"23" => "Cover Sheet",
	"24" => "Ob/Gyn Intake",
	"25" => "Ob/Gyn Followup",
	"26" => "Labor & Delivery",
	"27" => "Primary care-intake",
	"28" => "Primary care-followup",
	"29" => "Primary care-pediatric intake",
	"30" => "Records request",
	"31" => "Primary care-pediatric followup",
        "32" => "Imaging and other",
        "33" => "Records from smartcard",
        "34" => "HSYS"
	),
"fr" => array (
	"0" => "Rechercher",
	"1" => "Saisie premi&#xe8;re visite adult",
	"2" => "Visite de suivi",
	"3" => "Fiche counseling enr&#xf4;lement",
	"4" => "Fiche counseling suivi soins",
	"5" => "Ordonnance m&#xe9;dicale",
	"6" => "Analyses de laboratoire",
	"7" => "Visite &#xe0; domicile",
	"9" => "Suivi de la r&eacute;f&eacute;rence",
	"10" => "Enregistrement",
	"11" => "Rapport du comit&eacute; de S&eacute;lection",
	"12" => "Rapport d'arr&ecirc;t du programme soins et traitement VIH/SIDA",
        "13" => "Résultats de laboratoire externe",
	"14" => "Adh&eacute;rence",
	"15" => "Enregistrement p&#xe9;diatrique",
	"16" => "Saisie premi&#xe8;re visite p&#xe9;diatrique",
	"17" => "Visite de suivi p&#xe9;diatrique",
	"18" => "Ordonnance m&#xe9;dicale p&#xe9;diatrique",
	"19" => "Analyses de laboratoire",
	"20" => "Adh&#xe9;rence p&#xe9;diatrique",
	"21" => "Rapport d'arr&ecirc;t du programme soins et traitement VIH/SIDA p&#xe9;diatrique",
	"22" => "Regarder Toutes les Fiches",
	"23" => "Page de couverture",
	"24" => _("Fiche de Première Consultation OB-GYN"),
	"25" => "Fiche de Consultation OB-GYN",
	"26" => "Fiche de travail et d'accouchement", 
	"27" => _("Soins de santé primaire--première consultation"),
	"28" => _("Soins de santé primaire--consultation"),
	"29" => _("Soins de santé primaire--première consultation pédiatrique"),
	"30" => "Demande de dossier",
	"31" => _("Soins de santé primaire--consultation pédiatrique"),
        "32" => _("Imagerie et autres"),
        "33" => "Dossier de smartcard",
        "34" => "HSYS"
	)
);

$typeArray = array (
	"0" => "find",
	"1" => "intake",
	"2" => "followup",
	"3" => "counselingintake",
	"4" => "counselingfollowup",
	"5" => "prescription",
	"6" => "laboratory",
	"7" => "homevisit",
	"9" => "referral",
	"10" => "register",
	"11" => "selection",
	"12" => "discontinuation",
	"14" => "adherence",
	"15" => "pedregister",
	"16" => "pedintake",
	"17" => "pedfollowup",
	"18" => "pedprescription",
	"19" => "pedlaboratory",
	"20" => "pedadherence",
	"21" => "peddiscontinuation",
	"22" => "allEnc",
	"23" => "coversheet",
	"24" => "pmtctintake",
	"25" => "pmtctfollowup",
	"26" => "labor",
	"27" => "primaryIntake",
	"28" => "primaryFollowup",
	"29" => "pedPrimaryIntake",
	"30" => "transfer",
	"31" => "pedPrimaryFollowup",
        "32" => "imaging",
        "33" => "transfer",
        "34" => "hsys"
); 

// pediatric types must be mapped to adult types to return the correct file name (i.e. pedintake is called via intake.php&type=16, not pedintake.php&type=16)
$mapArray = array ("10" => "10", "15" => "10", "1" => "1","2" => "2", "5" => "5", "6" => "6", "14" => "14", "3" => "3", "4" => "4", "7" => "7", 
"9" => "9", "11" => "11", "12" => "12", "16" => "1", "17" => "2", "18" => "5", "19" => "6", "20" => "14", "21" => "12", "24" => "24", 
"25" => "25", "26" => "26", "27" => "27", "28" => "28", "29"=>"29", "30" => "30", "31" => "31", "32" => "32", "33" => "33");

$rootArray = array (
	"0" => "find",
	"10" => "register",
	"1" => "intake",
	"2" => "followup",
	"5" => "prescription",
	"6" => "laboratory",
	"14" => "adherence",
	"3" => "counselingintake",
	"4" => "counselingfollowup",
	"7" => "homevisit",
	"9" => "referral",
	"11" => "selection",
	"12" => "discontinuation", 
	"15" => "register",
	"16" => "intake",
	"17" => "followup",
	"18" => "prescription",
	"19" => "laboratory",
	"20" => "adherence",
	"21" => "discontinuation",
	"22" => "allEnc",
	"23" => "coversheet",
	"24" => "pmtctintake",
	"25" => "pmtctfollowup",
	"26" => "labor",
	"27" => "primaryIntake",
	"28" => "primaryFollowup",
	"29" => "pedPrimaryIntake",
	"30" => "transfer",
	"31" => "pedPrimaryFollowup",
	"32" => "imaging",
        "33" => "smartcard",
        "34" => "hsysreport"
);
// the current version of the forms
$formVersion = array (
	"0" => "0",
	"1" => "1",
	"2" => "1",
	"3" => "0",
	"4" => "0",
	"5" => "1",
	"6" => "3",
	"7" => "0",
	"9" => "0",
	"10" => "1",
	"11" => "0",
	"12" => "1", 
	"14" => "0",
	"15" => "0",
	"16" => "0",
	"17" => "0",
	"18" => "0",
	"19" => "3",
	"20" => "0",
	"21" => "0",
	"22" => "0",
	"23" => "0",
	"24" => "2",
	"25" => "2",
	"26" => "3",
	"27" => "0",
	"28" => "0",
	"29" => "0",
	"30" => "0",
	"31" => "0",
	"32" => "0",
        "33" => "0",
        "34" => "0"
);

?>
