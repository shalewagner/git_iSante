/*select 'union select ''', table_name, ''' , count(*) from ', table_name from information_schema.tables where table_space = 'openmrs'; */

select 'adherenceCounseling' , count(*) from adherenceCounseling
union select 'allergies' , count(*) from allergies
union select 'allowedDisclosures' , count(*) from allowedDisclosures
union select 'arvAndPregnancy' , count(*) from arvAndPregnancy
union select 'arvEnrollment' , count(*) from arvEnrollment
union select 'buddies' , count(*) from buddies
union select 'comprehension' , count(*) from comprehension
union select 'conditions' , count(*) from conditions
union select 'discEnrollment' , count(*) from discEnrollment
union select 'drugs' , count(*) from drugs
union select 'encounter' , count(*) from encounter
union select 'followupTreatment' , count(*) from followupTreatment
union select 'homeCareVisits' , count(*) from homeCareVisits
union select 'householdComp' , count(*) from householdComp
union select 'immunizations' , count(*) from immunizations
union select 'labs' , count(*) from labs
union select 'medicalEligARVs' , count(*) from medicalEligARVs
union select 'needsAssessment' , count(*) from needsAssessment
union select 'obs' , count(*) from obs
union select 'otherDrugs' , count(*) from otherDrugs
union select 'otherLabs' , count(*) from otherLabs
union select 'otherPrescriptions' , count(*) from otherPrescriptions
union select 'patient' , count(*) from patient
union select 'patientEducation' , count(*) from patientEducation
union select 'pedHistory' , count(*) from pedHistory
union select 'pedLabs' , count(*) from pedLabs
union select 'prescriptionOtherFields' , count(*) from prescriptionOtherFields
union select 'prescriptions' , count(*) from prescriptions
union select 'referrals' , count(*) from referrals
union select 'riskAssessments' , count(*) from riskAssessments
union select 'symptoms' , count(*) from symptoms
union select 'tbStatus' , count(*) from tbStatus
union select 'vitals' , count(*) from vitals
