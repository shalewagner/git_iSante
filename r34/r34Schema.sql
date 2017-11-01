/* modify alertLookup table */
DELETE FROM alertLookup where alertid > 93;
INSERT INTO alertLookup (alertid, alertname, descriptionen,descriptionfr,messageen,messagefr,alertgroup, priority) VALUES 
(100, 'r34alert', '', '',
'Risk:&nbsp;<input type="button" name="r34" style="background-color:blue" value="Success...Click for more..." onclick="r34Popup()"/>',
'Risque d’Échec Therapeutique :&nbsp;<input type="button" name="r34" style="background-color:blue" value="Succès...Cliquer..." onclick="r34Popup()"/>',
1, 1),
(200, 'r34alert', '', '',
'Risk:&nbsp;<input type="button" name="r34" style="background-color:lightgreen" value="Minimal Risk...Click for more..." onclick="r34Popup()"/>',
'Risque d’Échec Therapeutique :&nbsp;<input type="button" name="r34" style="background-color:lightgreen" value="Risque Minimal...Cliquer..." onclick="r34Popup()"/>',
1, 2),
(300, 'r34alert', '', '',
'Risk:&nbsp;<input type="button" name="r34" style="background-color:yellow" value="Medium Risk...Click for more..." onclick="r34Popup()"/>',
'Risque d’Échec Therapeutique :&nbsp;<input type="button" name="r34" style="background-color:yellow" value="Risque Moyen...Cliquer..." onclick="r34Popup()"/>',
1, 3),
( 400, 'r34alert', '', '',
'Risk:&nbsp;<input type="button" name="r34" style="background-color:orange" value="High Risk...Click for more..." onclick="r34Popup()"/>',
'Risque d’Échec Therapeutique :&nbsp;<input type="button" name="r34" style="background-color:orange" value="Risque Haut...Cliquer..." onclick="r34Popup()"/>',
1, 3),
( 500, 'r34alert', '', '',
'Risk:&nbsp;<input type="button" name="r34" style="background-color:red" value="Possible Failure (virologic)...Click for more..." onclick="r34Popup()"/>',
'Risque d’Échec Therapeutique :&nbsp;<input type="button" name="r34" style="background-color:red" value="Échec possible (virologique)...Cliquer..." onclick="r34Popup()"/>',
1, 5);

/* set up a regimen table */
DROP TABLE IF EXISTS r34Regimens;
CREATE TABLE IF NOT EXISTS r34Regimens (regID tinyint not null, regName varchar(11) NOT NULL, drugids varchar(11));
INSERT INTO r34Regimens VALUES 
(0,"AZT-3TC-EFV","8|11"),
(0,"AZT-3TC-EFV","11|20|34"),
(0,"AZT-3TC-EFV","8|11|20|34"),
(1,"AZT-3TC-NVP","8|23"),
(1,"AZT-3TC-NVP","20|23|34"),
(2,"d4T-3TC-EFV","11|20|29"),  
(3,"d4T-3TC-NVP","20|23|29"),  
(4,"TDF-3TC-EFV","11|20|31"),
(5,"TDF-3TC-NVP","20|23|31"),
(6,"AZT-3TC-ABC","33"),
(6,"AZT-3TC-ABC","1|8"),
(6,"AZT-3TC-ABC","1|8|20"),
(6,"AZT-3TC-ABC","1|8|34"),
(6,"AZT-3TC-ABC","1|8|20|34"),
(7,"2nd","5"),
(7,"2nd","6"),
(7,"2nd","16"),
(7,"2nd","17"),
(7,"2nd","21"),
(7,"2nd","22"),
(7,"2nd","26"),
(7,"2nd","27"),
(7,"2nd","88"),
(8,"mono","1"),
(8,"mono","11"),
(8,"mono","20"),
(8,"mono","23"),
(8,"mono","29"),
(8,"mono","31"),
(8,"mono","34");

/*select regname, group_concat(drugids separator '|') from r34Regimens group by 1;

SELECT COUNT(DISTINCT patientid) FROM longWide l, r34Regimens r 
WHERE l.regimen = r.drugids OR (INSTR(l.regimen,r.drugids) > 0 AND r.regName = '2nd');

SELECT r.regName, GROUP_CONCAT(distinct l.Regimen order by l.Regimen SEPARATOR '|') AS 'drugids', COUNT(*) , COUNT(distinct patientid)  FROM longWide l, r34Regimens r  WHERE l.regimen = r.drugids OR (INSTR(l.regimen,r.drugids) > 0 AND r.regName = '2nd') GROUP BY 1;

SELECT regid, COUNT(DISTINCT patientid) FROM longWide l, r34Regimens r WHERE l.regimen = r.drugids GROUP BY 1;
*/

CREATE TABLE IF NOT EXISTS r34Scores (
	patientid VARCHAR(11),
	calcDate DATE,
	riskScore FLOAT,
	riskLevel INT,
	PRIMARY KEY (patientid,calcDate)
);

DROP TABLE IF EXISTS r34RiskLookup;
CREATE TABLE r34RiskLookup (
	riskLevel bigint,
	riskScoreLow FLOAT NULL DEFAULT NULL,
	riskScoreHigh FLOAT NULL DEFAULT NULL,
	riskNameen varchar(50),
	riskNamefr varchar(50),
	PRIMARY KEY (riskLevel)
);

INSERT INTO r34RiskLookup VALUES 
(100, NULL, NULL, 'Success', 'Succès'),
(200, 215, NULL, 'Low Risk', 'Risque Minimal'),
(300, 215, 270, 'Medium Risk', 'Risque Moyen'),
(400, NULL, 270, 'High Risk', 'Risque Haut'),
(500, NULL, NULL, 'Possible Failure (virologic)', 'Échec possible (virologique)');

DROP TABLE IF EXISTS r34Summary;
CREATE TABLE r34Summary (
  patientid       VARCHAR(11) NOT NULL,
  regimen         TINYINT NULL,
  pregnant        TINYINT NOT NULL DEFAULT 0,
  gender          TINYINT NOT NULL DEFAULT 0,
  agecat          TINYINT NOT NULL DEFAULT 0,
  marital_status  INT NOT NULL DEFAULT 0,
  preartdays      INT NOT NULL DEFAULT 0,
  bmi             FLOAT NULL,
  bmicat          INT NOT NULL DEFAULT 4,
  whostage        TINYINT NOT NULL DEFAULT 5,
  encdatefirst    DATE DEFAULT NULL,
  regdatefirst    DATE DEFAULT NULL,
  artStartDate    DATE DEFAULT NULL,
  baselineCD4     FLOAT NULL DEFAULT NULL,
  baselineCD4cat  TINYINT NULL DEFAULT NULL,
  vllast_date     DATE,
  vllast_pfail    TINYINT NOT NULL DEFAULT 0,
  vllast_success  TINYINT NOT NULL DEFAULT 0,
  risk_gender     FLOAT NOT NULL DEFAULT 0, 
  risk_age        FLOAT NOT NULL DEFAULT 0,
  risk_marital    FLOAT NOT NULL DEFAULT 0,
  risk_cd4        FLOAT NOT NULL DEFAULT 0,
  risk_bmi        FLOAT NOT NULL DEFAULT 0,
  risk_who        FLOAT NOT NULL DEFAULT 0,
  risk_test       FLOAT NOT NULL DEFAULT 0,
  risk_regimen    FLOAT NOT NULL DEFAULT 0,
  risk_pdc        FLOAT NOT NULL DEFAULT 0,  
  risk_pdcfall    FLOAT NOT NULL DEFAULT 0,
  risk_gap3       FLOAT NOT NULL DEFAULT 0,
  risk_preart     FLOAT NOT NULL DEFAULT 0,
  riskScore       FLOAT NOT NULL DEFAULT 0,
  pdc0            FLOAT NOT NULL DEFAULT 0,
  pdc90           FLOAT NOT NULL DEFAULT 0,
  pdc180          FLOAT NOT NULL DEFAULT 0,
  pdcfall         TINYINT NOT NULL DEFAULT 0,
  gap3count180    INT NOT NULL DEFAULT 0,
  riskLevel       BIGINT NOT NULL DEFAULT 0,
  PRIMARY KEY (patientid)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS r34pregNames;
CREATE TABLE r34pregNames (short_name varchar(50));
INSERT INTO r34pregNames VALUES
('retardCroissanceIU'), 
('birthPlanHIVPrevention'), 
('motherPregWeeks'),
('pregnantDDRYy'), 
('pregnantDDRDd'), 
('pregnantDDRMm'), 
('eclampsiaA'), 
('hemorragieA'), 
('membraneRuptureA'),
('menacePremaA'), 
('hyperGraviA'), 
('preEclampsieA'), 
('htapregnancyA'), 
('grossesseUterineG'), 
('breastfeeding'), 
('eclampsia'), 
('hemorragie'), 
('membraneRupture'), 
('menacePrema'), 
('diabetespregnancy'), 
('grossesseEctopique'), 
('preEclampsie'), 
('foetalMovementChangeSymptom'), 
('hyperGravi'), 
('htapregnancy'), 
('homeVisit'), 
('HIVBabyPreventionPlan'), 
('groupSupport'), 
('educationBddy'), 
('residentialPlanMatron'), 
('birthTransitionPlan'), 
('motherClub'), 
('dispensationARV'), 
('ptme'), 
('educationInd'), 
('evalplanWeekOfPregnancy'), 
('birthHospitalName'), 
('grossesseUterineA'), 
('birthPlace'), 
('antenatalVisit'), 
('suiviPrenatal'), 
('laborFetalHeartRate'), 
('grossesseUterine'), 
('examObPosition'), 
('laborPresentation'), 
('examObContraction'), 
('laborUterine'); 

DROP TABLE IF EXISTS r34stageNames;
CREATE TABLE r34stageNames (short_name varchar(50), stage TINYINT);
TRUNCATE TABLE r34stageNames;
INSERT INTO r34stageNames (short_name, stage) VALUES
('weightLossPlusTenPercMo', 3),
('wtLossTenPercWithDiarrMo', 4),
('diarrheaPlusMo', 3),
('feverPlusMo', 3);