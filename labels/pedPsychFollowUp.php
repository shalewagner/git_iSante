<?php

$yesNo = array(
	"fr" => array(
		"Oui",
		"Non",
		"Inc"
	),
	"en" => array(
		"Yes",
		"No",
		"Unsure"
	)
);


$support = array(
	"fr" => array(
		"SUPPORT ",
		"Le patient a-t-il un accompagnateur (trice)?",
		"Est-ce que l'accompagnateur est venu &agrave; la visite m&eacute;dicale?",
		"L'accompagnateur a-t-il particip&eacute; &agrave; une session de formation sur le VIH/SIDA?",
		"Oui date",
		"L'accompagnateur peut-il expliqu&eacute; la fa&ccedil;on dont il dispense le r&eacute;gime au patient ",
		"Non, si non les lui expliquer",
		"A-t-on chang&eacute; d'accompagnateur depuis la derni&egrave;re visite?",
		"Oui, expliquer"
		),
	"en" => array(
		"SUPPORT",
		"The patient has a buddy?",
		"Did the buddy come to the medical exam?",
		"Did the buddy have an HIV/AIDS training session?",
		"Yes, date:",
		"Buddy can explain how it helps the patient",
		"No, if not then explain",
		"Has the buddy changed since the last visit?",
		"Yes, explain"	
		)
	);

$psychEval = array(
	"fr" => array(
		"EVALUATION PSYCHOLOGIQUE",
		"Evaluation",
		"Excellent",
		"Tr&egrave;s bien",
		"Bien",
		"Faible",
		"Tr&egrave;s faible",
		"Connaissance des couleurs",
		"Formes g&eacute;om&eacute;triques",
		"Connaissance des arbres",
		"Lat&eacute;ralisation",
		"Orientation haut 'bas",
		"Perception visuelle",
		"M&eacute;moire visuelle",
		"Motricit&eacute; fine",
		"Communication verbale",
		"Perception auditive",
		"M&eacute;moire auditive",
		"Sens du rythme",
		"Fonctionnement intellectuel",
		"Main utilis&eacute;e",
		"Dominance lat&eacute;rale",
		"Motricit&eacute; globale",
		"Remarques/ (recommandation) Plan d'action"
		),
	"en" => array(
		"PSYCHOLOGICAL EVALUATION",
		"Rating",
		"Excellent",
		"Very good",
		"Well",
		"Weak",
		"Very low",
		"Knowledge of color",
		"Geometric shapes",
		"Knowledge Tree",
		"Lateralization",
		"Up-down orientation",
		"Visual Perception",
		"Visual memory",
		"Fine Motor",
		"Oral Communication",
		"Auditory perception",
		"Auditory memory",
		"Sense of rhythm",
		"Intellectual Functioning",
		"Hand used",
		"Lateral Dominance",
		"Gross motor",
		"Notes / (recommendation) Action Plan"
		)
	);


$followUpCare = array(
	"fr" => array(
		"SUIVI DES SOINS ",
		"Est-ce que le patient a re&ccedil;u les r&eacute;f&eacute;rences et les services de conseil n&eacute;cessaires &agrave; cette visite ?	",
		"Non (pr&eacute;ciser raison)",
		"Depuis la derni&egrave;re visite m&eacute;dicale, est-ce que le patient a manqu&eacute; une visite &agrave; la clinique ?                                    ",
		"Oui, Date du R/V manqu&eacute; (jj/mm/aa)",
		"Depuis la derni&egrave;re visite le patient a-t-il manqu&eacute; d'autre rendez-vous ? ",
		"Oui, pr&eacute;ciser date o&ugrave; le patient a rat&eacute; sa visite (jj/mm/aa)       ",
		"Le patient est-il sous ARV?",
		"Oui, vous &ecirc;tes sous quel r&eacute;gime?"
		),
	"en" => array(	
		"FOLLOW-UP CARE",
		"Does the patient received references and consulting services necessary for this visit?",
		"No (specify reason )",
		"Since the last medical examination, is that the patient missed a clinic visit?",
		"Yes, Date of R / V failed (dd / mm / yy)",
		"Since the last visit the patient have missed other appointments?",
		"Yes, specify date patient missed his visit (dd / mm / yy)",
		"The patient is on ARVs it?",
		"Yes, which regime  are you under?"
		)
	);


$abuseEval = array(
	"fr" => array(
		"EVALUATION DE TRAITEMENT ABUSIF PAR LE PARTENAIRE OU LA FAMILLE",
		"Le patient a subi",
		"Dans le pass&eacute;",
		"En cours",
		"Partenaire",
		"Membre de la famille",
		"Violence &eacute;motionnelle",
		"Violence verbale",
		"Violence physique",
		"Expliquer dans la partie Remarque/plan d'action",
		"Vivez-vous une situation stressante? (Cochez vos r&eacute;ponses) ",
		"Maux de t&ecirc;te ",
		"Naus&eacute;e",
		"Perte d'app&eacute;tit",
		"Vomissement",
		"Diarrh&eacute;e",
		"Pigmentation des ongles",
		"Insomnie",
		"Cauchemars",
		"Perte de cheveux",
		"D&eacute;coloration de la peau",
		"Fi&egrave;vre souvent forte et sueurs",
		"Irritations de la gorge",
		"Mains moites",
		"Mains et pieds glac&eacute;s",
		"Difficult&eacute; &agrave; avaler",
		"Gourmandise chronique",
		"Sommeil prolong&eacute;",
		"Angoisse au sujet de votre sant&eacute;",
		"Tabagisme et exc&egrave;s d'alcool",
		"Indigestion",
		"Palpitations ",
		"B&acirc;illements et soupirs ",
		"Esprit constamment au galot",
		"Perte d'int&eacute;r&ecirc;t",
		"Douleurs musculaires (&eacute;paule, dos, estomac)",
		"Fatigue apr&egrave;s une nuit de repos",
		"Difficult&eacute; de concentration",
		"Crises de larme",
		"Dess&eacute;chement de la bouche",
		"Irritabilit&eacute;",
		"Probl&egrave;mes sexuels",
		"Pi&egrave;tre estime de soi",
		"Convulsion musculaire",
		"Probl&egrave;mes menstruels",
		"Irritation des intestins",
		"Toux s&egrave;che",
		"Autres: "
		),
	"en" => array(
		"EVALUATION OF ABUSIVE TREATMENT BY THE PARTNER OR FAMILY", //0
		"The patient underwent",
		"In the past",
		"Ongoing",
		"Partner",
		"Family member", //5
		"Emotional abuse",
		"Verbal abuse",
		"Physical violence",
		"Explain in the Note / Action Plan",
		"Are you in a stressful situation? (Check your answers)", //10
		"Headaches",
		"Nausea",
		"Loss of appetite",
		"Vomiting",
		"Diarrhea", //15
		"Pigmentation of nails",
		"Insomnia",
		"Nightmares",
		"Hair Loss",
		"Skin discoloration", //20
		"Often high fever and sweats",
		"Sore throat",
		"Sweaty palms",
		"Hands and feet icy",
		"Difficulty swallowing", //25
		"Chronic overeating",
		"Prolonged sleep",
		"Anxiety about your health",
		"Smoking and excessive alcohol",
		"Indigestion", //30
		"Palpitations",
		"Yawns and sighs",
		"Spirit constantly galot",
		"Loss of interest",
		"Muscle pain (shoulder, back, stomach)", //35
		"Fatigue after a night of rest",
		"Difficulty concentrating",
		"Crying",
		"Dry mouth",
		"Irritability", //40
		"Sexual problems",
		"Poor self-esteem",
		"Muscular convulsions",
		"Menstrual Problems",
		"Irritable bowel", //45
		"Dry Cough",
		"Other: "
		)
	);


$arvInitiation = array(
	"fr" => array(
		"EVALUATION A INITIER AUX ARV",
		"Education du patient",
		"Niveau de compr&eacute;hension",
		"Connaissance des modes de traitement aux ARV",
		"Aucun",
		"Moyen",
		"Excellent",
		"Les ARVs ne gu&eacute;rissent pas le VIH",
		"Le patient peut expliquer la fa&ccedil;on de prendre son r&eacute;gime",
		"Connaissance des effets des ARVs sur l'organisme"
		),
	"en" => array(
		"EVALUATION TO INITIATE THE ART",
		"Patient Education",
		"Level of understanding",
		"Knowledge of methods ARV treatment",
		"Low",
		"Average",
		"Excellent",
		"ARVs do not cure HIV",
		"The patient can explain how to take his regime",
		"Knowledge of effects of ARVs on the body"
		)
	);

$evalProbs = array(	
	"fr" => array(
		"Evaluation des probl&egrave;mes/besoins",
		"Probl&egrave;me",
		"Statut",
		"Services",
		"Fait",
		"R&eacute;f", //5
		"Indisp",
		"Niveau de compr&eacute;hension limit&eacute; quant au traitement ARV et au besoin d'adh&eacute;re", 
		"ind&eacute;termin&eacute;",
		"Counseling / &eacute;ducation &agrave; l'adh&eacute;rence aux ARVs",
		"Risque continu de transmission du VIH", //10
		"Counseling / &eacute;ducation &agrave; l'adh&eacute;rence aux ARVs",
		"Probl&egrave;mes de sant&eacute; mentale",
		"&Eacute;valuation Psychiatrique / Traitement",
		"D&eacute;pendance &agrave; l'alcool ou drogue", //15
		"Service de traitement",
		"Risque de violence familiale",
		"Service de lutte contre la violence familiale",
		"Planning Familial",
		"Programme de planification familiale", //20
		"Barri&egrave;res au transport",
		"Programme d'assistance au transport",
		"Alimentation non suffisante",
		"Aide alimentaire",
		"Probl&egrave;mes d'habitation", //25
		"Programme de logement",
		"Probl&egrave;mes d'hygi&egrave;ne",
		"Programme d'hygi&egrave;ne / sanitaire",
		"Autre",
		"Pr&eacute;ciser" //30 actually this is 29...

		),
	"en" => array(
		"Evaluation of problems / needs",
		"Issue",
		"Status",
		"Services",
		"Done",
		"Ref.",
		"Not done",
		"Limited level of understanding about ARV treatment and the need to adhere",
		"Unknown or invalid language",
		"Counseling / Education adherence to ARVs",
		"Continued risk of HIV transmission",
		"Counseling / Education adherence to ARVs",
		"Mental Health Problems",
		"Psychiatric Evaluation / Treatment",
		"Dependence on alcohol or drugs",
		"Processing service",
		"Risk of Domestic Violence",
		"service fight against domestic violence",
		"Family Planning",
		"Family Planning Program",
		"Barriers to Transport",
		"Program of Assistance to the Transport",
		"Food insufficient",
		"Food Aid",
		"Housing problems",
		"Housing Program",
		"Hygiene problems",
		"Health Program / Health",
		"Other",
		"Clarify "
		)
	);

$services = array(
	"fr" => array(
		"SERVICES OFFERTS AUX PATIENTS",
		"R&eacute;f&eacute;rence vers une organisation communautaire de support",
		"R&eacute;f&eacute;rence vers un groupe de support ou post test club",
		"Support  nutritionnel",
		"Frais de transport ",
		"Provision de condom",
		"Choix d'une m&eacute;thode de contraception",
		"Autres, pr&eacute;ciser: ",
		"Date du prochain R/V (jj/mm/aa)",
		"Signature du conseiller"
		),
	"en" => array(
		"SERVICES OFFERED TO PATIENTS",
		"Reference to a community organization support",
		"Reference to a support group or post-test club",
		"Nutritional support",
		"Freight",
		"Provision of condoms",
		"Choosing a method of contraception",
		"Other, specify: ",
		"Date of the next visit with the psychologist (dd/mm/yy)",
		"Signature conseiller"
		)
	);


?>
