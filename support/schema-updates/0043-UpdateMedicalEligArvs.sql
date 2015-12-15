call AddColumnUnlessExists(Database(), 'medicalEligARVs', 'protocoleTestTraitement', 'tinyint unsigned null default null comment "add for arv eligibility reason" after nephropathieVih');
go
