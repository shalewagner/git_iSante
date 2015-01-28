drop table dupRecords
go
CREATE TABLE dupRecords (
	siteCode char (10) ,
	patientID varchar (11) ,
	visitDateDd char (2) ,
	visitDateMm char (2) ,
	visitDateYy char (2) ,
	seqNum int,
	objectID int,
	tabName varchar(20),
	dupCount int
)
go
insert into dupRecords
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'adherenceCounseling' as TabName, count(*) from adherenceCounseling group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'allergies' as TabName, count(*) from allergies group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'allowedDisclosures' as TabName, count(*) from allowedDisclosures group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'arvAndPregnancy' as TabName, count(*) from arvAndPregnancy group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'arvEnrollment' as TabName, count(*) from arvEnrollment group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'buddies' as TabName, count(*) from buddies group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'comprehension' as TabName, count(*) from comprehension group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'encounter' as TabName, count(*) from encounter group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'discEnrollment' as TabName, count(*) from discEnrollment group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'followupTreatment' as TabName, count(*) from followupTreatment group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'homeCareVisits' as TabName, count(*) from homeCareVisits group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'householdComp' as TabName, count(*) from householdComp group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'medicalEligARVs' as TabName, count(*) from medicalEligARVs group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'needsAssessment' as TabName, count(*) from needsAssessment group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'patientEducation' as TabName, count(*) from patientEducation group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'referrals' as TabName, count(*) from referrals group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'riskAssessment' as TabName, count(*) from riskAssessment group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'symptoms' as TabName, count(*) from symptoms group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'tbStatus' as TabName, count(*) from tbStatus group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, 0 as normID,'vitals' as TabName, count(*) from vitals group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum having count(*) > 1
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, conditionID,'conditions' as TabName, count(*) from conditions group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, conditionID having count(*) > 1 
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, drugID, 'drugs' as TabName, count(*) from drugs group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, drugID having count(*) > 1 
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, labID, 'labs' as TabName, count(*) from labs group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, labID having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, drugID, 'prescriptions' as TabName, count(*) from prescriptions group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, drugID having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, len(drugName), 'otherDrugs' as TabName, count(*) from otherDrugs group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, drugName having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, len(labName), 'otherLabs' as TabName, count(*) from otherLabs group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, labName having count(*) > 1  
union
select sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, len(drug), 'otherPrescriptions' as TabName, count(*) from otherPrescriptions group by sitecode, patientid, visitdatedd, visitdatemm, visitdateyy, seqnum, drug having count(*) > 1
go
select tabName, count(*) from dupRecords group by tabName
go