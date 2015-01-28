<?php

$householdCompLabels = array (
"householdName" => array ("name" => "householdName", "type" => "text"),
"householdAge" => array ("name" => "householdAge", "type" => "text"),
"householdRel" => array ("name" => "householdRel", "type" => "text"),
"householdHiv" => array ("name" => "hivStatus", "type" => "radio"),
"householdDisc" => array ("name" => "householdDisc", "type" => "radio"),
);

$arvLabels = array (
"StartMm" => array ("name" => "startMm", "type" => "text"),
"StartYy" => array ("name" => "startYy", "type" => "text"),
"Continued" => array ("name" => "isContinued", "type" => "checkbox"),
"StopMm" => array ("name" => "stopMm", "type" => "text"),
"StopYy" => array ("name" => "stopYy", "type" => "text"),
"DiscTox" => array ("name" => "toxicity", "type" => "checkbox"),
"ProphDose" => array ("name" => "prophDose", "type" => "checkbox"),
"DiscIntol" => array ("name" => "intolerance", "type" => "checkbox"),
"DiscFail" => array ("name" => "failure", "type" => "checkbox"),
"DiscFailVir" => array ("name" => "failureVir", "type" => "checkbox"),
"DiscFailImm" => array ("name" => "failureImm", "type" => "checkbox"),
"DiscFailClin" => array ("name" => "failureClin", "type" => "checkbox"),
"DiscProph" => array ("name" => "failureProph", "type" => "checkbox"),
"DiscUnknown" => array ("name" => "discUnknown", "type" => "checkbox"),
"InterStock" => array ("name" => "stockOut", "type" => "checkbox"),
"InterPreg" => array ("name" => "pregnancy", "type" => "checkbox"),
"InterHop" => array ("name" => "patientHospitalized", "type" => "checkbox"),
"InterMoney" => array ("name" => "lackMoney", "type" => "checkbox"),
"InterAlt" => array ("name" => "alternativeTreatments", "type" => "checkbox"),
"InterLost" => array ("name" => "missedVisit", "type" => "checkbox"),
"InterPref" => array ("name" => "patientPreference", "type" => "checkbox"),
"InterUnk" => array ("name" => "interUnk", "type" => "checkbox"),
"Comments" => array ("name" => "reasonComments", "type" => "text"),
"forPepPmtct" => array("name" => "forPepPmtct", "type" => "checkbox"),
"finPTME" => array("name" => "finPTME", "type" => "checkbox")
);

$conditionLabels = array (
"Mm" => array ("name" => "conditionMm", "type" => "text"),
"Yy" => array ("name" => "conditionYy", "type" => "text"),
"Active" => array ("name" => "conditionActive", "type" => "checkbox"),
"Comment" => array ("name" => "conditionComment", "type" => "text")
);

$allowedDiscLabels = array (
"Name" => array ("name" => "disclosureName", "type" => "text"),
"Rel" => array ("name" => "disclosureRel", "type" => "text"),
"Address" => array ("name" => "disclosureAddress", "type" => "text"),
"Telephone" => array ("name" => "disclosureTelephone", "type" => "text")
);

$allergyLabels = array (
"Name" => array ("name" => "allergyName", "type" => "text"),
"MM" => array ("name" => "allergyStartMm", "type" => "text"),
"YY" => array ("name" => "allergyStartYy", "type" => "text"),
"SpMM" => array ("name" => "allergyStopMm", "type" => "text"),
"SpYY" => array ("name" => "allergyStopYy", "type" => "text"),
"Rash" => array ("name" => "rash", "type" => "checkbox"),
"RashF" => array ("name" => "rashF", "type" => "checkbox"),
"ABC" => array ("name" => "ABC", "type" => "checkbox"),
"Hives" => array ("name" => "hives", "type" => "checkbox"),
"SJ" => array ("name" => "SJ", "type" => "checkbox"),
"Anaph" => array ("name" => "anaph", "type" => "checkbox"),
"Other" => array ("name" => "allergyOther", "type" => "checkbox")
);

$otherDrugLabels = array (
"Text" => array ("name" => "drugName", "type" => "text"),
"MM" => array ("name" => "startMm", "type" => "text"),
"YY" => array ("name" => "startYy", "type" => "text"),
"Continued" => array ("name" => "isContinued", "type" => "checkbox"),
"SpMM" => array ("name" => "stopMm", "type" => "text"),
"SpYY" => array ("name" => "stopYy", "type" => "text"),
"DiscTox" => array ("name" => "toxicity", "type" => "checkbox"),
"ProphDose" => array ("name" => "prophDose", "type" => "checkbox"),
"DiscIntol" => array ("name" => "intolerance", "type" => "checkbox"),
"DiscFail" => array ("name" => "failure", "type" => "checkbox"),
"DiscFailVir" => array ("name" => "failureVir", "type" => "checkbox"),
"DiscFailImm" => array ("name" => "failureImm", "type" => "checkbox"),
"DiscFailClin" => array ("name" => "failureClin", "type" => "checkbox"),
"DiscProph" => array ("name" => "failureProph", "type" => "checkbox"),
"DiscUnknown" => array ("name" => "discUnknown", "type" => "checkbox"),
"InterStock" => array ("name" => "stockOut", "type" => "checkbox"),
"InterPreg" => array ("name" => "pregnancy", "type" => "checkbox"),
"InterHop" => array ("name" => "patientHospitalized", "type" => "checkbox"),
"InterMoney" => array ("name" => "lackMoney", "type" => "checkbox"),
"InterAlt" => array ("name" => "alternativeTreatments", "type" => "checkbox"),
"InterLost" => array ("name" => "missedVisit", "type" => "checkbox"),
"InterPref" => array ("name" => "patientPreference", "type" => "checkbox"),
"InterUnk" => array ("name" => "interUnk", "type" => "checkbox"),
"Comments" => array ("name" => "reasonComments", "type" => "text"),
"finPTME" => array ("name" => "finPTME", "type" => "checkbox")
);

$otherLabLabels = array (
"TestText" => array ("name" => "labName", "type" => "text"),
"Test" => array ("name" => "ordered", "type" => "checkbox"),
"TestResult" => array ("name" => "result", "type" => "text"),
"TestDd" => array ("name" => "resultDateDd", "type" => "text"),
"TestMm" => array ("name" => "resultDateMm", "type" => "text"),
"TestYy" => array ("name" => "resultDateYy", "type" => "text"),
"TestAbnormal" => array ("name" => "resultAbnormal", "type" => "checkbox"),
);

$otherRxLabels = array (
"RxText" => array ("name" => "drug", "type" => "text"),
"StdDosage" => array ("name" => "stdDosage", "type" => "checkbox"),
"StdDosageSpecify" => array ("name" => "stdDosageSpecify", "type" => "text"),
"PedDosageSpecify" => array ("name" => "pedDosageDesc", "type" => "text"),
"PedPresSpecify" => array ("name" => "pedPresentationDesc", "type" => "text"),
"AltDosage" => array ("name" => "altDosage", "type" => "checkbox"),
"AltDosageSpecify" => array ("name" => "altDosageSpecify", "type" => "text"),
"NumDays" => array ("name" => "numDays", "type" => "checkbox"),
"NumDaysDesc" => array ("name" => "numDaysDesc", "type" => "text"),
"Dispensed" => array ("name" => "dispensed", "type" => "checkbox"),
"DispDateDd" => array ("name" => "dispDateDd", "type" => "text"),
"DispDateMm" => array ("name" => "dispDateMm", "type" => "text"),
"DispDateYy" => array ("name" => "dispDateYy", "type" => "text"),
"DispAltDosage" => array ("name" => "dispAltDosage", "type" => "checkbox"),
"DispAltDosageSpecify" => array ("name" => "dispAltDosageSpecify", "type" => "text"),
"DispAltNumDays" => array ("name" => "dispAltNumDays", "type" => "checkbox"),
"DispAltNumDaysSpecify" => array ("name" => "dispAltNumDaysSpecify", "type" => "text"),
"DispAltNumPills" => array ("name" => "dispAltNumPills", "type" => "text")
);

$immLabels = array (  
"Dd" => array ("name" => "immunizationDd", "type" => "text"),
"Mm" => array ("name" => "immunizationMm", "type" => "text"),
"Yy" => array ("name" => "immunizationYy", "type" => "text"),
"Given" => array ("name" => "immunizationGiven", "type" => "checkbox"),
"Doses" => array ("name" => "immunizationDoses", "type" => "text")
);

$rxLabels = array (
"StdDosage" => array ("name" => "stdDosage", "type" => "checkbox"),
"StdDosageSpecify" => array ("name" => "stdDosageSpecify", "type" => "text"),
"PedDosageSpecify" => array ("name" => "pedDosageDesc", "type" => "text"),
"PedPresSpecify" => array ("name" => "pedPresentationDesc", "type" => "text"),
"AltDosage" => array ("name" => "altDosage", "type" => "checkbox"),
"AltDosageSpecify" => array ("name" => "altDosageSpecify", "type" => "text"),
"NumDays" => array ("name" => "numDays", "type" => "checkbox"),
"NumDaysDesc" => array ("name" => "numDaysDesc", "type" => "text"),
"Dispensed" => array ("name" => "dispensed", "type" => "checkbox"),
"DispDateDd" => array ("name" => "dispDateDd", "type" => "text"),
"DispDateMm" => array ("name" => "dispDateMm", "type" => "text"),
"DispDateYy" => array ("name" => "dispDateYy", "type" => "text"),
"DispAltDosage" => array ("name" => "dispAltDosage", "type" => "checkbox"),
"DispAltDosageSpecify" => array ("name" => "dispAltDosageSpecify", "type" => "text"),
"DispAltNumDays" => array ("name" => "dispAltNumDays", "type" => "checkbox"),
"DispAltNumDaysSpecify" => array ("name" => "dispAltNumDaysSpecify", "type" => "text"),
"forPepPmtct" => array ("name" => "forPepPmtct", "type" => "radio"),
"DispAltNumPills" => array ("name" => "dispAltNumPills", "type" => "text")
);

$labLabels = array (
"Test" => array ("name" => "ordered", "type" => "checkbox"),
"TestResult" => array ("name" => "result", "type" => "text"),
"TestResult2" => array ("name" => "result2", "type" => "text"),
"TestResult3" => array ("name" => "result3", "type" => "text"),
"TestResult4" => array ("name" => "result4", "type" => "text"),
"TestDd" => array ("name" => "resultDateDd", "type" => "text"),
"TestMm" => array ("name" => "resultDateMm", "type" => "text"),
"TestYy" => array ("name" => "resultDateYy", "type" => "text"),
"TestAbnormal" => array ("name" => "resultAbnormal", "type" => "checkbox"),
"TestRemarks" => array ("name" => "resultRemarks", "type" => "text"),
);

$pedLabsLabels = array (
"Age" => array ("name" => "pedLabsResultAge", "type" => "text"),
"AgeUnits" => array ("name" => "pedLabsResultAgeUnits", "type" => "checkbox"),
"Res" => array ("name" => "pedLabsResult", "type" => "checkbox")
);

$refLabels = array (
"Checked" => array ("name" => "referralChecked", "type" => "checkbox"),
"Clinic" => array ("name" => "refClinic", "type" => "text"),
"AdateDd" => array ("name" => "refAdateDd", "type" => "text"),
"AdateMm" => array ("name" => "refAdateMm", "type" => "text"),
"AdateYy" => array ("name" => "refAdateYy", "type" => "text"),
"FdateDd" => array ("name" => "refFdateDd", "type" => "text"),
"FdateMm" => array ("name" => "refFdateMm", "type" => "text"),
"FdateYy" => array ("name" => "refFdateYy", "type" => "text"),
"Akept" => array ("name" => "refAkept", "type" => "checkbox")
);

$riskLabels = array (
"Answer"  => array ("name" => "riskAnswer", "type" => "checkbox"),
"Dd"      => array ("name" => "riskDd",     "type" => "text"),
"Mm"      => array ("name" => "riskMm",     "type" => "text"),
"Yy"      => array ("name" => "riskYy",     "type" => "text"),
"Comment" => array ("name" => "riskComment","type" => "text")   
); 

?>
