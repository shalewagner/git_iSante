<?php

$pmtctfollowupFormTitle = array (
   "en" => array (
        "",
        "OB-GYN FOLLOWUP FORM",
        ""),
   "fr" => array (
        "",
        "FICHE DE SUIVI DES FEMMES EN CONSULTATION OBSTETRICO-GYNECOLOGIQUE",
        "")
);
$antecedents_head = array (
   "en" => array (
        "PREVIOUS OBSTETRICS"
		),
   "fr" => array (
        "ANTECEDENT OBSTETRICAUX"
		)
);           
$lastRuleDate = array (
   "en" => array (
        "Last Rule Date (GDR):"
		),
   "fr" => array (
        "Date Derni&egrave;res R&egrave;gles  (DDR):"
		)
);
$dpaDate = array (
   "en" => array (
		"DPA:"
		),
   "fr" => array (
		"DPA:"
		)
);
$oldGestWeeks = array (
   "en" => array (
        "Age Gestationnel:",
		"(week)"
		),
   "fr" => array (
        "Age Gestationnel:",
		"(semaines)"
		)
);
$drug_head = array (
   "en" => array (
		"DRUGS"
		),
   "fr" => array (
		"MEDICAMENTS"
		)
);
$treatment_subhead =  array (
   "en" => array (
        "CURRENT TREATMENTS: ARV",
		"CURRENT TREATMENTS: OTHERS",
		"DRUGS: ALLERGIES"
		),
   "fr" => array (
        "TRAITEMENTS ACTUELS : ARV",
		"TRAITEMENTS ACTUELS : AUTRES",
		"M&Eacute;DICAMENTS: ALLERGIES"
		)
);
$arv_subhead =  array (
   "en" => array (
        "Name",
		"Start Date (MM/YY)"
		),
   "fr" => array (
        "Nom",
		"Date de d&eacute;but (MM/AA)"
		)
);
$medAllergy_subhead = array (
   "en" => array (
        "M&eacute;dicaments en cours"
		),
   "fr" => array (
        "M&eacute;dicaments en cours"
		)
);
$condition_columnhead = array (
   "en" => array (
        "Diagnostic",
		"Si oui indiquer",
		"Description",
		"R&eacute;solu",
		"En cours de traitement"
		),
   "fr" => array (
        "Diagnostic",
		"Si oui indiquer",
		"Description",
		"R&eacute;solu",
		"En cours de traitement"
		)
);

$antecedents_section = array (
  "en" => array (
          "Pregnancies",
          "Deliveries",
          "Abortions",
          "Foetal death",
          "Gross a Terme",
          "Large in the long term",
          "Large Ectopique",
		  "Menarches",
		  "Beginning of the sexual relationships",
		  "Antecedant Pap Test",
		  "If so, Antc of PAP Anml",
		  "Date from the last PAP",
		  "Result",
		  "Family planning",
		  "Method used before the current pregnancy:",
		  "Dat Dern Rules <b>GDR</b>",
		  "Date from the large test positive one",
		  "DPA",
		  "PAP",
		  "Live children"
        ),
  "fr" => array (
          "Gravida",
          "Para",
          "Aborta",
          "Mort f&oelig;tale",
          "Gross a Terme",
          "Prematurit&eacute;",
          "Gross Ectopique",
		  "Menarches",
		  "Debut des relations sexuelles",
		  "Antecedant Pap Test",
		  "Si oui,  Antc de Pap Anml",
		  "Date du dernier Pap",
		  "Resultat",
		  "Planification Familiale",
		  "M&eacute;thode utilisee avant la grossesse actuelle:",
		  "Dat Dern R&egrave;gles  <b>DDR</b>",
		  "Date du test de gross positif",
		  "DPA",
		  "PAP",
		  "Enfants vivants"
		)
);



$famPlanMethod = array (
  "en" => array (
          "Condom",
          "DMPA",
          "CO",
          "Norplan",
          "Other, specify",
                "Vaginal tablet",
                "IUD",
                "Implant",
                "Tubal ligation"
        ),
  "fr" => array (
          "Condom",
          "DMPA",
          "CO",
          "Norplan",
          "Autre, sp&eacute;cifie",
                "Tablette vaginale",
                "St&eacute;rilet",
                "Implant",
                "Ligature des trompes"

                )
);

$generalOption = array (
  "en" => array (
          "Yes",
          "No",
          "Unknown",
		  "Pos",
		  "Neg",
		  "Unknown"
        ),
  "fr" => array (
          "Oui",
          "Non",
          "Inconnu",
		  "Pos",
		  "Neg",
		  "Inconnu"
		)
);

$medAllergy_columnhead = array (
  "en" => array (
          "Nom",
		  "Dose",
		  "Date de d&eacute;but",
		  "Allergies",
		  "Nom du m&eacute;dicament",
		  "Description de la R&eacute;action"
        ),
  "fr" => array (
          "Nom",
		  "Dose",
		  "Date de d&eacute;but",
		  "Allergies",
		  "Nom du m&eacute;dicament",
		  "Description de la R&eacute;action"
		)
);
if($type == '24'){
}else{
$vih_section = array (
  "en" => array (
		  "HIV STATUS",
          "Last Test HIV",
		  "If so, date of last test HIV:",
		  "Result:",
		  "So not, negative, or unknown, to jump to the section Drugs: Allergies",
		  "Establishment where the test was carried out:",
		  "This establishment",
		  "Other:"
        ),
  "fr" => array (
		  "STATUT VIH",
	          "Dernier Test VIH",
		  "Si oui, date du dernier test VIH:",
		  "R&eacute;sultat:",
		  "Si non, n&eacute;gatif, ou inconnu, sauter &agrave; la section M&eacute;dicaments:Allergies",
		  "&Eacute;tablissement o&ugrave; le test a &eacute;t&eacute; r&eacute;alis&eacute;:",
		  "Cet &eacute;tablissement",
		  "Autre:"
		)
);
}
$transMode = array (
  "en" => array (
          "PROBABLE MODE OF TRANSMISSION",
		  "Select at least one reason below:",
		  "Man sexual relations with woman",		
		  "Woman sexual relations with woman",
		  "Sexual relations by anal way",
		  "Sexual relations with a partner VIH+",
		  "Sexual relations with a partenairequi injects drug",
		  "Sexual relations with bisexual",
		  "Sex worker",
		  "Transmission mother with child (vertical)",
		  "With divided syringes"
		),
  "fr" => array (
		  "MODE PROBABLE DE TRANSMISSION",
		  "A eu &agrave; un moment quelconque, cocher le ou les cas ci-dessous:",
		  "Rapports sexuels homme avec femme",
		  "Rapports sexuels femme avec femme",
		  "Rapports sexuels par voie anale",
		  "Rapports sexuels avec un partenaire VIH+",
		  "Rapports sexuels avec un partenaire qui s&prime;injecte la drogue",
		  "Rapports sexuels avec un bisexuel",
		  "Travailleuse (eur) du sexe",
		  "Transmission m&egrave;re &agrave; enfant (verticale)",
		  "A partag&eacute; des seringues"
		)
);

$risk_titles  = array (
  "en" => array (
		  "PROBABLE MODE OF TRANSMISSION" ,
		  "Ever had: Choose all that apply"
        ),
  "fr" => array (
		  "MODE PROBABLE DE TRANSMISSION",
		  "A eu &agrave; un moment quelconque,</b> <i>cocher pour le ou les cas ci-dessous" 
		)
);

$refEstablishDt = array (
  "en" => array (
		  "Enrollement of returning with the care with establishment of reference" 
        ),
  "fr" => array (
		  "Date d&prime;enr&ocirc;lement aux soins de l&prime;&eacute;tablissement de r&eacute;f&eacute;rence" 
		)
);
$allergy_options =  array (
  "en" => array (
          "medicaments",
		  "aliments"
        ),
  "fr" => array (
          "medicaments",
		  "aliments"
		)
);
$arv_section =  array (
  "en" => array (
          "Histoire de traitement avec les ARV",
		  "ARV en cours:",
		  "Si il y en a, lister les m&eacute;dicaments en dessous",
		  "Nom",
		  "Date de debut",
		  "Adherence(%)",
		  "Effets secondaires,autres probl&egrave;mes",
		  "Specify"	  
        ),
	"fr" => array (
          "Histoire de traitement avec les ARV",
		  "ARV en cours:",
		  "Si il y en a, lister les m&eacute;dicaments en dessous",
		  "Nom",
		  "Date de debut",
		  "Adherence(%)",
		  "Effets secondaires,autres probl&egrave;mes",
		  "Pr&eacute;ciser"
		)
);
$reactionType = array (
   "en" => array (
		"Rash",
		"RashF",
		"ABC",
		"Hives",
		"SJ",
		"Anaph",
		"Other"
	),
   "fr" => array (
		"Erup",
		"ErupF",
		"ABC",
		"Pap",
		"SJ",
		"Anaph",
		"Autre"
	)
);
$vacc_section = array (
   "en" => array (
     "VACCINS",
	 "Nom",
	 "Dose 1",
	 "Dose 2",
	 "Dose 3",
	 "Date Recue",
	 "Required today"
	 ),
   "fr" => array (
     "VACCINS",
	 "Nom",
	 "Dose 1",
	 "Dose 2",
	 "Dose 3",
	 "Date Re&ccedil;ue",
	 "Requis aujourd&prime;hui"
	 )  
);                                           
$treatment_section = array(
    "en" => array (
	  "Histoire de Traitement  ARV  II",
	  "Ant&eacute;c&eacute;dent de  traitement aux ARV:",
	  "Si oui, lister les m&eacute;dicaments en dessous",
	  "Nom",
	  "Date de debut",
	  "Date d&prime;arr&ecirc;&eacute;",
	  "Raison de la Discontinuation",
	  "Cocher si pour PTME",
      "Tox",
	  "Intol",
	  "Fail",
	  "Inconnu"
	),
    "fr" => array (     
	  "Histoire de Traitement  ARV  II",
	  "Ant&eacute;c&eacute;dent de  traitement aux ARV:",
	  "Si oui, lister les m&eacute;dicaments en dessous",
	  "Nom",
	  "Date de debut",
	  "Date d&prime;arr&ecirc;&eacute;",
	  "Raison de la Discontinuation",
	  "Cocher si pour PTME",
	  "Tox",
	  "Intol",
	  "Ech",
	  "Inconnu"
	)
);	
$propDrug_section = array (
	"en" => array (
	  "M&eacute;dicaments Prophylactiques en Cours",
	  "Nom",
	  "Date de debut",
	  "Adherence(%)",
	  "Effets Secondaires/Autres probl&egrave;mes,si il y en a"
	),
	"fr" => array (
	  "M&eacute;dicaments Prophylactiques en Cours",
	  "Nom",
	  "Date de debut",
	  "Adherence(%)",
	  "Effets Secondaires/Autres probl&egrave;mes,si il y en a"
	)
);	
$exam_section = array (
	"en" => array (
	 "SIGNS VITAUX & ANTHROPOMETRIE",
	 "Pds avant la Gross:",
	 "Pds acutel:",
	 "TA:",
	 "Pls:",
	 "FR:",
	 "To:"
	),
	"fr" => array (
	 "SIGNS VITAUX & ANTHROPOMETRIE",
	 "Pds avant la Gross:",
	 "Pds acutel:",
	 "TA:",
	 "Pls:",
	 "FR:",
	 "To:"
	)
);
$vihPos_section = array (
	"en" => array (
	 "EVALUATION AND PLANNING",
	 "1. Pregnancy of,",
	 "weeks of gestation",
	 "Risk factors, if there is a:",
	 "Plan  de naissance",
	 "Plan of birth",
	 "Artificial milk",
	 "Exclusive breast-feeding",
	 "2. Positive HIV",
	 "Clinical stage of WHO",
	 "Stage I",
	 "Stage II",
	 "Stage III",
	 "Stage IV",
	 "Patient under ARV",
	 "So not, to plan for initiation of disease prevention ARV",
	 "Selected mode",
	 "Start date",
	 "Old Gestationnel at the date planned for the beginning",
	 "3. Other diagnoses",
	 "Treatment/Plan",
	 "4. Nutritional Status",
	 "Antenatal vitamins dispensees:",
	 "Iron supplements and folic acid are exempted:",
	 "Other nutritional needs:"
	),
	"fr" => array (
	 "EVALUATION ET PLANNIFICATION",
	 "1. Grossesse de,",
	 "semaines de gestation",
	 "Facteurs de risques,  s&prime;il y en a:",
	 "Plan  de naissance",
	 "Alimentation du nourrisson",
	 "Lait artificiel",
	 "Allaitement maternel exclusif",
	 "2. VIH  Positif",
	 "Stade Clinique de l&prime;OMS",
	 "Stade I",
	 "Stade II",
	 "Stade III",
	 "Stade IV",
	 "Patiente sous ARV",
	 "Si non, planifier pour l&prime;initiation de la prophylaxie ARV",
	 "R&eacute;gime choisi",
	 "Date de d&eacute;but",
	 "Age Gestationnel a la date pr&eacute;vue pour le d&eacute;but",
	 "3. Autres diagnostics",
	 "Traitement/Plan",
	 "4. Statue Nutritionel",
	 "Vitamines Prenatales dispensees:",
	 "Suppl&eacute;ments en fer et acide folique sont dispens&eacute;s:",
	 "Autres besoins nutritionels:"
	)
);
$vital_title = array (
	"en" => array (
	 "VITAL AND ANTHROPOMETRIC SIGNS"
	),
	"fr" => array (
	 "SIGNES VITAUX ET ANTHROPOMETRIQUES"
	)
);
$vitalTempUnit = array (
	"en" => array (
	 "C",
	 "F"
	),
	"fr" => array (
	 "C",
	 "F"
	)
);
$vitalWeightUnit = array (
	"en" => array (
	 "kg",
	 "lb"
	),
	"fr" => array (
	 "kg",
	 "lb"
	)
);
$vitalRrUnit = array (
	"en" => array (
	 "/mn"
	),
	"fr" => array (
	 "/mn"
	)
);
$vitalFrUnit = array (
	"en" => array (
	 "/mn"
	),
	"fr" => array (
	 "/mn"
	)
);
$vitalBPUnit = array (
	"en" => array (
	 "cm de Hg", 
	 "mm de Hg"
	),
	"fr" => array (
	 "cm de Hg", 
	 "mm de Hg"
	)
);

$cd4_section = array (
	"en" => array (
	 "If so, date:",
	 "Result",
	 "The most recent CD4"
	),
	"fr" => array (
	 "Si oui, date:",
	 "R&eacute;sultat:",
	 "CD4 le plus r&eacute;cent"
	)
);   
$tb_header =  array (
	"en" => array (
	 "TB ANTECEDENT"
	),
	"fr" => array (
	 "ANT&Eacute;C&Eacute;DENT DE TB"
	)
);   

$noPreTB =  array (
	"en" => array (
	 "No the antecedent of tuberculosis",
	 "Contact TB"
	),
	"fr" => array (
	 "Pas d&prime;ant&eacute;c&eacute;dent de tuberculose",
	 "Contact TB"

	)
); 
$birthPlan_header = array (
    "en" => array (
	 "DATE DES VISITES PRENATALES"
	),
	"fr" => array (
	 "DATE DES VISITES PRENATALES"
	)
);

$birthPlan_section = array (
    "en" => array (
	 "Probable childbirth date",
	 "Where",
	 "Hospital",
	 "Home",
	 "Obstetrician name and addr",
	 "Guide"
	),
	"fr" => array (
	 "Date probable d&prime;accouchement",
	 "Lieu",
	 "H&ocirc;pital",
	 "Domicile",
	 "Nom et adresse de l&prime;accoucheur",
	 "Accompagnateur"
	)
);
$allergies_subhead = array (
   "en" => array (
	"Name",
	"Start date (MM/YY)",
	"Stop date (MM/YY)"
	),
   "fr" => array (
	"Nom",
	"Date de d&#xe9;but (MM/AA)",
	"Date de arr&#xea;t (MM/AA)"
	)
);
$allergies_codes= array (
   "en" => array (
     "CODES:"
	),
   "fr" => array (
	"CODES:"
	)
);
$antenatalVisit_title =  array (
    "en" => array (
	 "PLAN OF BIRTH",
	 ),
	"fr" => array (
	 "PLAN DE NAISSANCE",
	)
);

$antenatalVisit_subhead =  array (
    "en" => array (
	 "DATE FROM THE ANTENATAL VISITS",
	 ),
	"fr" => array (
	 "DATE DES VISITES PRENATALES",
	)
);
$postinatalVisit_title =  array (
    "en" => array (
	 "DATE FROM THE POSTNATAL VISITS",
	 ),
	"fr" => array (
	 "DATE DES VISITES POSTNATALES",
	)
);
$visitSeq = array (
    "en" => array (
	 "",
	 "1st visit",
	 "2nd visit",
	 "3rd visit",
	 "4th visit",
	 "5th visit",
	 "6th visit",
	 "7th visit",
	 "8th visit",
	 "9th visit",
	 "10th visit"
	),
	"fr" => array (
	 "",
	 "1ere visite",
	 "2e visite",
	 "3e visite",
	 "4e visite",
	 "5e visite",
	 "6e visite",
	 "7e visite",
	 "8e visite",
	 "9e visite",
	 "10e visite"
	)
);
$sideEffects = array(
   "en" => array (
    "Nausea",
    "Nausea or vomiting",
	"Diarrhea",
	"Diarrhea",
	"Rash",
	"Rash",
	"Headache",
	"Headache",
	"AbPain",
	"Abdominal pain",
	"Weak",
	"Weakness",
	"Numb",
	"Paraesthesia/tingling",
	"Jaundice",
	"Jaundice",
	"Allergy",
	"Severe allergic reactions",
	"Bd",
	"Behavioral disorder",
	"Nd",
	"Neurological disorder"
   ),
   "fr" => array (
    "Naus&#xe9;e",
    "Naus&#xe9;e ou vomissement",
	"Diarrh&#xe9;e",
	"Diarrh&#xe9;e",
	"Ec",
	"Eruption cutan&#xe9;e",
	"Mt",
	"Maux de t&#xea;te",
	"Da",
	"Douleur abdominale",
	"Faiblesse",
	"Faiblesse",
	"Numb",
	"Paresth&#xe9;sie/fourmillement",
	"Ict&#xE8;re",
	"Ict&#xE8;re",
	"Rasa",
	"R&#xE9;actions allergiques syst&#xE9;miques aigu&#xEB;s",
	"Tc",
	"Troubles du comportement",
	"Tn",
	"Troubles neuro-musculaires"
   )
); 
$physicalGeneral_1 = array (
    "en" => array (
	 "general state"
	),
	"fr" => array (
	 "Etat g&eacute;n&eacute;ral"
	)
);
$physicalHead = array (
    "en" => array (
	 "head"
	),
	"fr" => array (
	 "T&ecirc;te"
	)
);
$physicalNeck = array (
    "en" => array (
	 "Neck + thyroid"
	),
	"fr" => array (
	 "Cou + thyro&iuml;de"
	)
);
$physicalHeart = array (
    "en" => array (
	 "Heart"
	),
	"fr" => array (
	 "C&oelig;ur"
	)
);
$physicalCentres = array (
    "en" => array (
	 "Centres"
	),
	"fr" => array (
	 "Seins"
	)
);
$physicalUterineHeight = array (
    "en" => array (
	 "Uterine height"
	),
	"fr" => array (
	 "Hauteur Ut&eacute;rine"
	)
);
$physicalExternalGenitals = array (
    "en" => array (
	 "External genitals"
	),
	"fr" => array (
	 "Organes G&eacute;nitaux Externes"
	)
);
$physicalVaginalExam = array (
    "en" => array (
	 "Examination Vaginal"
	),
	"fr" => array (
	 "Toucher Vaginal"
	)
);
$physicalVagina = array (
    "en" => array (
	 "Vagina"
	),
	"fr" => array (
	 "Vagin"
	)
);
$physicalCollar = array (
    "en" => array (
	 "Collar"
	),
	"fr" => array (
	 "Col"
	)
);
$physicalAppendices = array (
    "en" => array (
	 "Appendices"
	),
	"fr" => array (
	 "Annexes"
	)
);
$physicalRectum = array (
    "en" => array (
	 "Rectum"
	),
	"fr" => array (
	 "Rectum"
	)
);
$physicalMembers = array (
    "en" => array (
	 "Members"
	),
	"fr" => array (
	 "Membres"
	)
);
$physicalTendonReflexes = array (
    "en" => array (
	 "Tendon reflexes"
	),
	"fr" => array (
	 "Reflexes ost&eacute;o-tendineux"
	)
);

$medical_head = array (
    "en" => array (
	 "CLINICAL EXAMINATION"
	),
	"fr" => array (
	 "EXAMEN CLINIQUE"
	)
);
$foeCardRhythm = array (
    "en" => array (
	 "Foetal cardiac rhythm",
	 "/mn"
	),
	"fr" => array (
	 "Rythme cardiaque foetal",
	 "/mn"
	)
);
$oedema  = array (
    "en" => array (
	 "Oedema"
	),
	"fr" => array (
	 "&OElig;d&egrave;me"
	)
);

$presentation = array (
    "en" => array (
	 "Presentation",
	 "C(cephalic)",
	 "S(sit)",
	 "T(transversal)"
	),
	"fr" => array (
	 "Pr&eacute;sentation",
	 "C(c&eacute;phalique)",
	 "S(si&egrave;ge)",
	 "T(transversale)"
	)
);
$uterContraction = array (
    "en" => array (
	 "Uterine contraction"
	),
	"fr" => array (
	 "Contraction ut&eacute;rine"
	)
);
$vihPos_section = array (
	"en" => array (
	 "EVALUATION AND PLANNING",
	 "1. Pregnancy, weeks of gestation:",
	 "Risk factors, if there is a:",
	 "Plan of birth",
	 "Artificial milk",
	 "Exclusive breast-feeding",
	 "2. Other diagnoses or concerns",
	 "Treatment/Plan",
	 "3. Positive HIV",
	 "So not, to jump has next section",
	 "Clinical stage of WHO",
	 "Stage I",
	 "Stage II",
	 "Stage III",
	 "Stage IV",
	 "Patient under ARV",
	 "So not, to plan for initiation of disease prevention ARV",
	 "Selected mode",
	 "Start date",
	 "Old Gestationnel at the date planned for the beginning",
	 "weeks"
	),
	"fr" => array (
	 "EVALUATION ET PLANNIFICATION",
	 "1. Grossesse, semaines de gestation :",
	 "Facteurs de risques,  s&prime;il y en a:",
	 "Alimentation du nourrisson",
	 "Lait artificiel",
	 "Allaitement maternel exclusif",
	 "2. Autres diagnostics ou pr&eacute;occupations",
	 "Traitement/Plan",
	 "3. VIH  Positif",
	 "Si non, sauter a prochaine section",
	 "Stade Clinique de l&prime;OMS",
	 "Stade I",
	 "Stade II",
	 "Stade III",
	 "Stade IV",
	 "Patiente sous ARV",
	 "Si non, planifier pour l&prime;initiation de la prophylaxie ARV",
	 "R&eacute;gime choisi",
	 "Date de d&eacute;but",
	 "Age Gestationnel a la date pr&eacute;vue pour le d&eacute;but:",
	 "semaines"
	)
);
$vihPos_head = array (
    "en" => array (
	 "EVALUATION AND PLANNING"
	),
	"fr" => array (
	 "EVALUATION ET PLANNIFICATION"
	)
);
$otherInv_head = array (
    "en" => array (
	 "OTHER INTERVENTIONS"
	),
	"fr" => array (
	 "AUTRES INTERVENTIONS"
	)
);
$ironDisFolicAcid = array (
    "en" => array (
	 "Iron and/or distributed folic acid"
	),
	"fr" => array (
	 "Fer et/ou acide folique distribu&eacute;"
	)
);
$exemptAntVitamin = array (
    "en" => array (
	 "Exempted Antenatal vitamins"
	),
	"fr" => array (
	 "Vitamines Pr&eacute;natales dispens&eacute;es"
	)
);
$peCounseling = array (
    "en" => array (
	 "PF: Counseling",
	 "If so, the method or No PF registers:"
	),
	"fr" => array (
	 "PF: Counseling",
	 "Si oui, inscrive la m&eacute;thode ou no PF :"
	)
);
$foodOfNN = array (
    "en" => array (
	 "Food of NN: Counseling"
	),
	"fr" => array (
	 "Alimentation du NN&eacute;: Counseling"
	)
);
$treatmentTB = array (
    "en" => array (
	 "Treatment anti TB "
	),
	"fr" => array (
	 "Treatment anti TB "
	)
);
$medProp = array (
    "en" => array (
	 "If so, meds and proportions:"
	),
	"fr" => array (
	 "Si oui, meds et dose:"
	)
);
$INHPrevention = array (
    "en" => array (
	 "Disease prevention with the INH"
	),
	"fr" => array (
	 "Prophylaxie &agrave; L&prime;INH"
	)
);
$cotrim = array (
    "en" => array (
	 "Disease prevention with Cotrim"
	),
	"fr" => array (
	 "Prophylaxie &agrave; Cotrim"
	)
);
$tetanic = array (
    "en" => array (
	 "Tetanic anti vaccine"
	),
	"fr" => array (
	 "Vaccin anti t&eacute;tanique"
	)
);
$doses = array (
    "en" => array (
	 "Dose 1",
	 "Does 2"
	),
	"fr" => array (
	 "Dose 1",
	 "Does 2"
	)
);
$malaria = array (
    "en" => array (
	 "Malaria (intermittent Preventive medication)"
	),
	"fr" => array (
	 "Malaria (Traitement pr&eacute;ventif intermittent)"
	)
);
$underART = array (
    "en" => array (
	 "Placed under ART",
	 "If so, meds:"
	),
	"fr" => array (
	 "Plac&eacute;e sous ART",
	 "Si oui, meds:"
	)
);
$adherenceARV = array (
    "en" => array (
	 "Counseling on adherence in ARVs"
	),
	"fr" => array (
	 "Counseling sur l&prime;adh&eacute;rence aux ARVs"
	)
);
$workChildBirth_head = array (
    "en" => array (
	 "WORK AND CHILDBIRTH"
	),
	"fr" => array (
	 "TRAVAIL ET ACCOUCHEMENT"
	)
);
$place = array (
    "en" => array (
	 "Where",
	 "Hospital",
	 "Home"
	),
	"fr" => array (
	 "Lieu",
	 "H&ocirc;pital",
	 "Domicile"
	)
);
$returnWorkHour = array (
    "en" => array (
	 "Go back and Hour to beginning of Work:"
	),
	"fr" => array (
	 "Date  et Heure de d&eacute;but du Travail: "
	)
);
$urgentContact =  array (
    "en" => array (
	 "Contact in the event of urgency:"
	),
	"fr" => array (
	 "Contact en cas d&prime;urgence:"
	)
);
$birthDateHour =  array (
    "en" => array (
	 "<b>Childbirth:</b> Date and Hour:"
	),
	"fr" => array (
	 "<b>Accouchement:</b>	Date et Heure:"
	)
);
$childWeeks =  array (
    "en" => array (
	 "Old gest.:",
	 "weeks"
	),
	"fr" => array (
	 "Age gest.:",
	 "semaines"
	)
);
$vaginal =  array (
    "en" => array (
	 "Vaginal:",
	 "Episio",
	 "Vacuum"
	),
	"fr" => array (
	 "Vaginal:",
	 "Episio",
	 "Vacuum"
	)
);
$uterHeight = array (
    "en" => array (
	 "Uterine height",
	 "cm"
	),
	"fr" => array (
	 "Hauteur Ut&eacute;rine",
	 "cm"
	)
);


$caesSection =  array (
    "en" => array (
	 "Section Caesarean",
	 "CS+ Hyst&eacute;rectomie"
	),
	"fr" => array (
	 "Section C&eacute;sarienne",
	 "CS+ Hyst&eacute;rectomie"
	)
);
$childDelivery = array (
    "en" => array (
	 "Delivery",
	 "Natural",
	 "Artificial"
	),
	"fr" => array (
	 "D&eacute;livrance:",
	 "Naturelle",
	 "Artificielle"
	)
);
$childRhythm =  array (
    "en" => array (
	 "Cardiac foetal rate/rhythm:"
	),
	"fr" => array (
	 "Rythme cardiaque foetal:"
	)
);
$childLaceration = array (
    "en" => array (
	 "Laceration of p&eacute;rin&eacute;e:",
	 "If Laceration of p&eacute;rin&eacute;e, Repair:"
	),
	"fr" => array (
	 "Lac&eacute;ration du p&eacute;rin&eacute;e:",
	 "Si Lac&eacute;ration du p&eacute;rin&eacute;e, R&eacute;paration:"
	)
);
$fever = array (
    "en" => array (
	 "Fever"
	),
	"fr" => array (
	 "Fi&egrave;vre"
	)
);
$membRupture = array (
    "en" => array (
	 "Rupture of the membranes",
	 "Spontaneous",
	 "Caused"
	),
	"fr" => array (
	 "Rupture des membranes",
	 "Spontan&eacute;e",
	 "Provoqu&eacute;e"
	)
);


$placenta = array (
    "en" => array (
	 "Placenta:",
	 "Complete",
	 "Incomplete"
	),
	"fr" => array (
	 "Placenta:",
	 "Complet/Total",
	 "Incomplet"
	)
);
$workDateHour =  array (
    "en" => array (
	 "Date and hour"
	),
	"fr" => array (
	 "Date et Heure"
	)
);
$haemorrhage = array (
    "en" => array (
	 "Vaginal haemorrhage:"
	),
	"fr" => array (
	 "H&eacute;morragie vaginale:"
	)
);
$childLA = array (
    "en" => array (
	 "LA:",
	 "Clearly",
	 "Tinted",
	 "M&eacute;coniale"
	),
	"fr" => array (
	 "LA:",
	 "Clair",
	 "Teint&eacute;",
	 "M&eacute;coniale"
	)
);
$transfusion = array (
    "en" => array (
	 "Transfusion"
	),
	"fr" => array (
	 "Transfusion"
	)
);
$arvPrevention = array (
    "en" => array (
	 "If positive HIV:",
	 "Disease prevention ARV:",
	 "NVP",
	 "AZT+3TC",
	 "TAR  specify:"
	),
	"fr" => array (
	 "Si VIH positif:",
	 "Prophylaxie ARV:",
	 "NVP",
	 "AZT+3TC",
	 "TAR Sp&eacute;cifier:"
	 
	)
);
$birthNN = array (
    "en" => array (
	 "NN&eacute;:",
	 "Apgar with 1mn:",
	 "5mn:",
	 "Pds:"
	),
	"fr" => array (
	 "NN&eacute;:",
	 "Apgar &agrave; 1mn:",
	 "5mn:",
	 "Pds:"
	)
);
$startDate = array (
    "en" => array (
	 "Start date (< 72 hours):"
	),
	"fr" => array (
	 "Date de d&eacute;but (< 72 heures):"
	)
);
$nutritionConseling = array (
    "en" => array (
	 "Counseling on the nutrition of the Born one:"
	),
	"fr" => array (
	 "Counseling sur la nutrition du Nn&eacute;:"
	)
);
$otherMedications = array (
    "en" => array (
	 "Other medications:"
	),
	"fr" => array (
	 "Autres m&eacute;dications:"
	)
);
$workVitalSign_head = array (
    "en" => array (
	 "VITAL SIGNS WITH WORK"
	),
	"fr" => array (
	 "SIGNES VITAUX AU TRAVAIL"
	)
);
$postPartumVitalSign_head = array (
    "en" => array (
	 "VITAL SIGNS OF POST PARTUM"
	),
	"fr" => array (
	 "SIGNES VITAUX DU POST PARTUM"
	)
);
$after6VitalSign_head = array (
    "en" => array (
	 "VITAL SIGNS 6:00 AFTER"
	),
	"fr" => array (
	 "SIGNES VITAUX 6H APRES"
	)
);
$otherDiagnose_head  = array (
    "en" => array (
	 "OTHER DIAGNOSES OR CURRENT CONCERNS"
	),
	"fr" => array (
	 "AUTRES DIAGNOSTICS OU PR&Eacute;OCCUPATIONS ACTUELLES"
	)
);
$otherText = array (
   "en" => array (
	"",
	"Other, specify:",
	""),
   "fr" => array (
	"",
	"Autres, <i>pr&#xe9;ciser&nbsp;</i>:",
	"")
);
$noLead = array (
    "en" => array (
	 "Not led"
	),
	"fr" => array (
	 "Non conduit"
	)
);


?>
