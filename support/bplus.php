<?
$_REQUEST['noid'] = 'true';
chdir('/var/www/isante/');
include "backend.php";
$queryList = array (         
/* pregnancy */
'pregBplus' => "select left(p.patientid,5) as sitecode, p.* from dw_pregnancy_ranges p, bplusPids b where p.patientid = b.patientid",
/* encounter table */
'encBplus' => "select e.patientid, sitecode, encountertype as form_id, ymdtodate(visitdateyy, visitdatemm, visitdatedd) as visitdate, seqNum, ymdtodate(nxtVisitYy, nxtVisitMm, nxtVisitDd) as nxtVisitDate, date(createdate) as createdate, date(lastModified) as lastModified from encounter e, bplusPids b where e.patientid = b.patientid and e.encStatus < 255",
/* registration */
'regBplus' => "select p.patientid, sitecode, ymdtodate(visitdateyy, visitdatemm, visitdatedd) as registration_date, sex as gender, addrDistrict, addrSection, addrTown, dobyy, dobmm, dobdd, ageYears, maritalstatus from patient p, bplusPids b, encounter e where p.patientid = e.patientid and p.patientid = b.patientid and encountertype in (10,15) and e.encStatus < 255",
/* initial visit get vitals, tbStatus, observations (obs), medicalEligARVs, arvAndPregnancy, diagnoses (conditions), drug history (drugs) */
/* vitals remove: firsttestotherfactext famplanothertext otherstdtext otherinfectext othermentalhealthtext drugothertext hospitalizedtext pedfoodallergtext medrecord followupnotes */ 
'vitalsBplus' => "select e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate ,v.siteCode ,v.patientID, v.seqNum ,scheduledvisit,vitalheight,vitalweight,vitalprevwt,pregnant,pregnantlmpdd,pregnantlmpmm,pregnantlmpyy,functionalstatus,firsttestmm,firsttestyy,firsttestthisfac,firsttestotherfac,repeattestmm,repeattestyy,lowestcd4cnt,lowestcd4cntmm,lowestcd4cntnotdone,lowestcd4cntyy,firstviralload,firstviralloadnotdone,firstviralloadmm,firstviralloadyy,famplan,famplanmethodcondom,famplanmethoddmpa,famplanmethodocpills,famplanmethodtuballig,famplanother,vitalweightunits,vitalprevwtunits,firsttestdd,repeattestdd,firstcareotherdd,firstcaretoday,firstcareother,firstcareothermm,firstcareotheryy,transferin,transferonarv,lowestcd4cntdd,firstviralloaddd,vitalheightcm,pregnantprenatal,pregnantprenatalfirstdd,pregnantprenatalfirstyy,pregnantprenatallastdd,pregnantprenatallastmm,pregnantprenatallastyy,paptest,paptestdd,paptestmm,paptestyy,gravida,para,aborta,children,pregnancydesired,familyplanningdesired from bplusPids b, encounter e, vitals v where b.patientid = v.patientid and b.patientid = e.patientid and e.sitecode = v.sitecode and e.visitdateyy = v.visitdateyy and e.visitdatemm = v.visitdatemm and e.visitdatedd = v.visitdatedd and e.seqNum = v.seqNum and e.encStatus < 255 and e.encountertype in (1,2,16,17,24,25)",
'tbStatusBplus' => "select e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate, v.* from bplusPids b, encounter e, tbStatus v where b.patientid = v.patientid and b.patientid = e.patientid and e.sitecode = v.sitecode and e.visitdateyy = v.visitdateyy and e.visitdatemm = v.visitdatemm and e.visitdatedd = v.visitdatedd and e.seqNum = v.seqNum and e.encStatus < 255 and e.encountertype in (1,2,16,17,24,25)",
'visitObsBplus' => "select e.patientid, e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate, e.sitecode, e.seqNum, c.short_name as name, case when c.datatype_id = 1 then v.value_numeric when c.datatype_id = 3 then v.value_text when c.datatype_id = 6 then v.value_datetime when c.datatype_id = 10 then v.value_boolean else 'XX' end as 'value' from bplusPids b, encounter e, obs v, concept c where v.concept_id = c.concept_id and b.patientid = concat(v.location_id, v.person_id) and b.patientid = e.patientid and e.encounter_id = v.encounter_id and e.encStatus < 255 and e.encountertype in (1,2,16,17)",
'eligibleBplus' => "select e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate, v.* from bplusPids b, encounter e, medicalEligARVs v where b.patientid = v.patientid and b.patientid = e.patientid and e.sitecode = v.sitecode and e.visitdateyy = v.visitdateyy and e.visitdatemm = v.visitdatemm and e.visitdatedd = v.visitdatedd and e.seqNum = v.seqNum and e.encStatus < 255 and e.encountertype in (1,2,16,17)",
'arvAndBplus' => "select e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate, v.* from bplusPids b, encounter e, arvAndPregnancy v where b.patientid = v.patientid and b.patientid = e.patientid and e.sitecode = v.sitecode and e.visitdateyy = v.visitdateyy and e.visitdatemm = v.visitdatemm and e.visitdatedd = v.visitdatedd and e.seqNum = v.seqNum and e.encStatus < 255 and e.encountertype in (1,2,16,17)",
/* diagnosis */ 
'dxBplus' => "select p.* from v_conditions p, bplusPids b where p.patientid = b.patientid and p.encountertype in (1,2,16,17)",
/* drug history */ 
'drugBplus' => "select p.* from v_drugs p, bplusPids b where p.patientid = b.patientid and p.encountertype in (1,2,16,17)",
/* pharmacy */
'rxBplus' => "select p.*,case when o.value_boolean=1 then 'communautaires' else null end as dispensation, ymdtodate(p.visitdateyy,p.visitdatemm,p.visitdatedd) as visitDate, l.drugname, ymdtodate(e.nxtVisitYy, e.nxtVisitMm, e.nxtVisitDd) as nxtVisitDate from drugLookup l, prescriptions p, bplusPids b, encounter e left outer join obs o on (o.encounter_id=e.encounter_id and o.concept_id=71642 and o.location_id=e.siteCode and e.patientid=concat(o.location_id,person_id)) where p.patientid = b.patientid and p.drugid = l.drugid and p.patientid = e.patientid and p.sitecode = e.sitecode and p.visitdateyy = e.visitdateyy and p.visitdatemm = e.visitdatemm and p.visitdatedd = e.visitdatedd and p.seqNum = e.seqNum and e.encountertype in (5,18) and e.encStatus < 255 and  (dispensed = 1 or dispAltDosage is not null or dispAltDosageSpecify is not null or dispAltNumDays is not null or dispAltNumDaysSpecify is not null or dispDateYy is not null or dispDateDd is not null or dispDateMm is not null or dispDateYy is not null or dispAltNumPills is not null) and (l.drugGroup in ('NRTIs', 'Pls', 'NNRTIs', 'Anti-TB') or l.drugName like 'cotrimoxazole%')",
/* laboratory remove: resultremarks sendingsitename testnameen testnamefr */ 
'labBplus' => "select p.siteCode ,p.patientID ,ymdtodate(p.visitDateYy ,p.visitDateMm ,p.visitDateDd) as visitdate ,p.labID ,p.result ,p.result2 ,p.units ,p.resultDateDd ,p.resultDateMm ,p.resultDateYy ,p.seqNum ,p.ordered ,p.resultAbnormal ,p.result3 ,p.result4 ,p.accessionNumber ,p.sendingSiteID ,p.sectionOrder  ,p.panelOrder ,p.testOrder ,p.resultTimestamp ,p.resultStatus ,p.supersededDate from labs p, bplusPids b, encounter e where p.patientid = b.patientid and p.patientid = e.patientid and e.encountertype in (6,13,19) and p.sitecode = e.sitecode and e.encStatus < 255 and p.visitdateyy = e.visitdateyy and p.visitdatemm = e.visitdatemm and p.visitdatedd = e.visitdatedd and p.seqNum = e.seqNum and result is not null and result <> ''",
/* OB visit */
'obBplus' => "select e.patientid, e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate, e.sitecode, e.seqNum, c.short_name as name, case when 
c.datatype_id = 1 then v.value_numeric 
when c.datatype_id = 3 then v.value_text 
when c.datatype_id = 6 then v.value_datetime 
when c.datatype_id = 10 then v.value_boolean else 'XX' end as 'value' from bplusPids b, encounter e, obs v, concept c 
where v.concept_id = c.concept_id and 
b.patientid = concat(v.location_id, v.person_id) and 
b.patientid = e.patientid and 
e.encounter_id = v.encounter_id and 
e.encStatus < 255 and e.encountertype in (24,25)",
/* labor/delivery */
'laborBplus' => "select e.patientid, e.encountertype as form_id, ymdtodate(e.visitdateyy, e.visitdatemm, e.visitdatedd) as visitdate, e.sitecode, e.seqNum, c.short_name as name, case when c.datatype_id = 1 then v.value_numeric when c.datatype_id = 3 then v.value_text when c.datatype_id = 6 then v.value_datetime when c.datatype_id = 10 then v.value_boolean else 'XX' end as 'value' from bplusPids b, encounter e, obs v, concept c where v.concept_id = c.concept_id and b.patientid = concat(v.location_id, v.person_id) and b.patientid = e.patientid and e.encounter_id = v.encounter_id and e.encStatus < 255 and e.encountertype = 26",        
/* art adherence remove: reasonothertext evaluationothertext sideothertext adherenceremark */
'adherBplus' => "select ymdtodate(e.visitdateyy,e.visitdatemm,e.visitdatedd) as visitDate, a.siteCode ,a.patientID,a.seqNum ,a.missedDoses ,a.doseProp ,a.reasonNotAvail ,a.reasonSideEff ,a.reasonFinished ,a.reasonLost ,a.reasonNotComf ,a.reasonOther ,a.reasonForgot ,a.reasonTooSick ,a.reasonTravel ,a.reasonDidNotWant ,a.reasonNoSwallow ,a.reasonNoFood ,a.sideNausea ,a.sideDiarrhea ,a.sideRash ,a.sideHeadache ,a.sideAbPain ,a.sideWeak ,a.sideNumb ,a.reasonPrison ,a.reasonFeelWell ,a.pickupPersonName ,a.pickupPersonRel ,a.dbSite ,a.evaluationDoctor ,a.evaluationPharmacien ,a.evaluationNurse ,a.evaluationSocialWorker ,a.evaluationAgent ,a.evaluationOther  ,a.behaviorProblem ,a.neuroMuscularDisorder ,a.jaundice severeAllergicReactions from bplusPids b, adherenceCounseling a, encounter e where b.patientid = a.patientid and b.patientid = e.patientid and a.sitecode = e.sitecode and e.encStatus < 255 and a.visitdateyy = e.visitdateyy and a.visitdatemm = e.visitdatemm and a.visitdatedd = e.visitdatedd and a.seqNum = e.seqNum and e.encountertype in (14,20)",        
/* discontinuation */   
'discBplus' => "select left(b.patientid,5) as sitecode, b.patientid, date(d.discDate) as discDate, d.discType, r.reasonDescEn from bplusPids b, discTable d, discReasonLookup r where b.patientid = d.patientid and d.discType = r.discType",  
/* counseling  */  
'houseBplus' => "select c.patientid, c.sitecode, ymdtodate(c.visitdateyy,c.visitdatemm,c.visitdatedd) as visitdate, c.seqNum, count(*) as houseCount, sum(case when hivStatus = 1 then 1 else 0 end) as hivPos, sum(case when hivStatus = 2 then 1 else 0 end) as hivNeg, sum(case when hivStatus = 4 then 1 else 0 end) as hivUnk from bplusPids b, householdComp c where b.patientid = c.patientid group by 1,2,3,4", 
'buddyBplus' => "select distinct ymdtodate(u.visitdateyy,u.visitdatemm,u.visitdatedd) as visitdate, u.* from bplusPids b, buddies u where b.patientid = u.patientid and supportAccomp = 1",  
/* committee remove: othermedeligtext othermedreftext notesarvenroll */ 
'commitBplus' => "select ymdtodate(visitdateyy,visitdatemm,visitdatedd) as reportDate, a.siteCode ,a.patientID ,a.seqNum ,a.arv ,a.initiateTB ,a.TBprogram ,a.PMTCTprogram ,a.continueTB ,a.inadPsychPro ,a.psychEval ,a.familyPlanProg ,a.poorAdherence ,a.ARVadherCoun ,a.immunProg ,a.patientPref ,a.ARVeducCoun ,a.hospitalization ,a.inadPrepForAd ,a.otherMedRef ,a.doesntAccAcc ,a.psychSocialCoun ,a.doesntAccHome ,a.weakFamilySupp ,a.barriersToReg ,a.transAssProg ,a.livesOutsideZone ,a.otherARVprog ,a.progHasRlimit ,a.ARVsTempUn ,a.otherMedElig ,a.nextVisitWeeks ,a.nextVisitDD ,a.nextVisitMM ,a.nextVisitYY ,a.arvEver ,a.committeeApproval ,a.committeeApprovalDateDd ,a.committeeApprovalDateMm ,a.committeeApprovalDateYy ,a.tWaitListOther ,a.tWaitList ,a.dbSite ,a.pedArvEver ,a.pedArvKnown ,a.pedNextVisitDays ,a.pedNextVisitWeeks ,a.pedNextVisitMos from bplusPids b, arvEnrollment a where a.arv is not null and a.arv <> 0 and b.patientid = a.patientid",
/* sites with lat/long */
'sites' => "select department, commune, clinic, network, c.sitecode, c.dbsite, lat, lng, date(max(lastModified)) as lastReplication 
from clinicLookup c, encounter e 
where c.incphr = 1 and c.sitecode = e.sitecode
group by 5 order by 5",
/* first obgyn visit (a) */
'firstObgyn' => "select m.sitecode, year(m.mindt) as yy, month(m.mindt) as mm, count(*) from ( 
select sitecode, e.patientid, min(visitdate) as mindt 
from encValidAll e, dw_pregnancy_ranges p, bplusPids b
where e.patientid = b.patientid and
e.patientid = p.patientid and 
e.visitdate between p.startDate and p.stopDate and 
e.encountertype in (24,25) group by 1,2
) m group by 1,2,3",
/* all obgyn (b) */
'allObgyn' => "select sitecode, year(visitdate) as yy, month(visitdate) as mm, count(*) 
from encValidAll e, dw_pregnancy_ranges p, bplusPids b 
where e.patientid = b.patientid and
e.patientid = p.patientid and 
e.visitdate between p.startDate and p.stopDate and
encountertype in (24,25) group by 1,2,3",
/* duplicate patients */
'duplicates' => "select d.match_id, e.patientid, e.sitecode, date(min(visitdate)) as minDate, date(max(visitdate)) as maxDate, d.counter from dupNames d, encValidAll e, patient p where d.lname = p.lname and d.fname = p.fname and d.dobyy = p.dobyy and d.dobmm = p.dobmm and d.dobdd = p.dobdd and d.sex = p.sex and d.fnameMother = p.fnameMother and e.patientid = p.patientid group by 1,2 order by 1,2" 
);  
// generate bplusPids patient reference list
$qry = "drop table if exists bplusPids";
$result = database()->query($qry);
$qry = "create table bplusPids select b.patientid from ( select p.patientid, min(CASE WHEN ISDATE(ymdToDate(p.dispDateYy, p.dispDateMm, p.dispDateDd)) = 1 THEN ymdToDate(p.dispDateYy, p.dispDateMm, p.dispDateDd) WHEN ISDATE(ymdToDate(p.dispDateYy, p.dispDateMm, 1)) = 1 THEN ymdToDate(p.dispDateYy, p.dispDateMm, 1) ELSE ymdToDate(p.visitDateYy, p.visitDateMm, p.visitDateDd) end) as mDt from prescriptions p, drugLookup d, patient t where p.patientid = t.patientid and (dispensed = 1 or dispAltDosage is not null or dispAltDosageSpecify is not null or dispAltNumDays is not null or dispAltNumDaysSpecify is not null or dispDateYy is not null or dispDateDd is not null or dispDateMm is not null or dispDateYy is not null or dispAltNumPills is not null) and p.drugID = d.drugID and druggroup in (?,?,?,?) group by 1 having mDt > ?) b, patient t where b.patientid = t.patientid and patStatus < 255";
$result = database()->query($qry,array('NRTIs', 'Pls', 'NNRTIs','II', '2010-01-01'));
$qry = "alter table bplusPids add primary key (patientid)";
$result = database()->query($qry); 

// setup for duplicate patients
$qry = "drop table if exists dupNames";
$result = database()->query($qry);
$qry = "create table dupNames ( match_id int unsigned not null auto_increment, lname varchar(255) , fname varchar(255) , dobyy char(4) , dobmm char(2) , dobdd char(2) , sex tinyint(3) unsigned , fnameMother varchar(255) , counter bigint(21) , primary key (match_id) )"; 
$result = database()->query($qry);
$qry = "insert into dupNames (lname, fname, dobyy, dobmm, dobdd, sex, fnameMother, counter) select lname, fname, dobyy, dobmm, dobdd, sex, fnameMother, count(*) from patient where patStatus < 255 group by 1,2,3,4,5,6,7 having count(*) > 1";

$counter = 0;
$result = database()->query($qry);
foreach($queryList as $fh => $qry) {
        writeNancyFile($fh, $qry);
        $counter++;
        echo $counter . ":" . $fh . "\n";   
}
function writeNancyFile($fh, $qry) { 
        $myfile = fopen("/home/itech/nancy/" . $fh . ".txt", "w"); 
        $result = databaseSelect()->query($qry);
        $flag = 0;
        while ($row = $result->fetch()) {
                if ($flag === 0) {
                        $fields = array_keys($row);
                        foreach ($fields as $value) {
                                if ($flag) fwrite($myfile, "|");
                                fwrite($myfile, $value);
                                $flag = 1;  
                        }
                        fwrite($myfile, PHP_EOL);
                }
                $flag2 = 0;
                foreach($row as $key => $val) {
                        if ($flag2) fwrite($myfile, "|");  
                        $val = str_replace('"', '', $val);
                        if ($val === "") $val = "X";
                        fwrite($myfile, $val);
                        $flag2 = 1;
                }
                fwrite($myfile, PHP_EOL);
        }
        fclose($myfile);        
}
?>
