ALTER TABLE  `medicalEligARVs` ADD  `ChildLT5ans` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `medEligHAART` ,
ADD  `coinfectionTbHiv` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `ChildLT5ans` ,
ADD  `coinfectionHbvHiv` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `coinfectionTbHiv` ,
ADD  `coupleSerodiscordant` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `coinfectionHbvHiv` ,
ADD  `pregnantWomen` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `coupleSerodiscordant` ,
ADD  `breastfeedingWomen` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `pregnant` ,
ADD  `patientGt50ans` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `breastfeeding`,
ADD  `nephropathieVih` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT  'add for arv eligibility reason' AFTER  `breastfeeding`;

go
