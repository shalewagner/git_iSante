<?php

$reportsXMLFile = "jrxml/reports.xml";

$reportGroup = array (
	"en" => "Report Group/Report Name",
	"fr" => "Type de rapport/Nom de rapport"
);

$colLabels = array (
	"en" => "Form",
	"fr" => "Fiche"
);

$brokenPDF = array (
        "en" => "This report is temporarily unavailable in this format.",
        "fr" => "Ce rapport est temporairement indisponible dans ce format."
);

$startDateLabel = array (
   "en" => "Start Date:",
   "fr" => "Date de d&eacute;but:"
);
$endDateLabel = array (
   "en" => "End Date:",
   "fr" => "Date de fin:"
);

$dateFormat = array (
   "en" => "MM/YY",
   "fr" => "MM/AA"
);

$dateFormatWithDay = array (
   "en" => "DD/MM/YY",
   "fr" => "JJ/MM/AA"
);

$allSites = array (
	"en" => "For all sites?",
	"fr" => "Pour tous les &eacute;tabilssements?"
);

$badDate = array (
   "en" => array ("Bad Start Day", "Bad Start Month", "Bad Start Year", "Bad End Day", "Bad End Month", "Bad End Year"),
   "fr" => array ("Mauvais jour de d\u00E9but", "Mauvais mois de d\u00E9but", "Mauvaise ann\u00E9e de d\u00E9but", "Mauvais jour fin", "Mauvais mois de fin", "Mauvaise ann\u00E9e de fin")
);

$hivqualInterval = array (
   "en" => "Interval (in months)",
   "fr" => "L'intervalle (en mois)"
);

$hivqualIntervalMsg = array (
   "en" => "The interval in months must be less than or equal to the length of the analysis period.",
   "fr" => "L\u0027intervalle de mois doit \u00EAtre moins ou \u00E9gale que la longueur de la p\u00E9riode d\u0027analyse."
);

$hivqualDateRangeMsg = array (
   "en" => "The end month must be earlier than the current month for this report",
   "fr" => "Le mois de fin doit \u00EAtre pr\u00E9c\u00E9dent que le mois actuel pour ce rapport"
);

$monthlyIndIntervalMsg = array (
   "en" => "You must specify at least a one month interval for this report",
   "fr" => "Vous devez spécifier au moins un intervalle d\'un mois pour ce rapport"
);

$caseNotifTimeMsg = array (
   "en" => "This report may take several minutes to complete.",
   "fr" => "Ce rapport peut prendre plusieurs minutes pour compl\u00E9ter."
);

$waitMessageText = array (
   "en" => "Please wait while the report is computed.",
   "fr" => "Attendez svp tandis que le rapport est calcul&eacute;."
);

$formErrors = array (
   "en" => "Forms With Unresolved Validation Errors",
   "fr" => "Liste des erreurs de validation non-r&eacute;solues"
);

$validateColumnHeads = array (
	"en" => array ("Nationalid","Visit Date","Form Link","Field","Current Value","Problem(s)"),
	"fr" => array ("No. de Code National","Date de visite", "Fiche l'indicateur", "Zone d'information","Valeur courante","Probl&egrave;me(s)")
);

$modeNames = array (
	"fields" => array (
		"sexWithMale",
		"sexWithCommercialSexWorker",
		"sexWithFemale",
		"sexWithoutCondom",
		"sexWithIvDrugUser",
		"sexWithHomoBi",
		"sexAnal",
		"sexOral",
		"injectionDrugs",
		"sharedNeedles",
		"stdHistory",
		"bloodExp",
		"sexAssault",
		"verticalTransmission",
		"bloodTrans"),
	"en" => array ("Sexual intercourse with male",
		"Sexual intercourse with commercial sex worker",
		"Sexual intercourse with female",
		"Sexual intercourse without condom",
		"Sexual intercourse with an intravenous drug user",
		"Sexual intercourse with homosexual/bisexual male",
		"Anal Sex",
		"Oral Sex",
		"Injection drug use",
		"Shared needles",
		"History or presence of STD",
		"Accidental exposure to blood",
		"Sexual assult",
		"Vertical transmission",
		"Blood transfusion"),
	"fr" => array ("Rapports sexuels avec homme",
		"Rapports sexuels avec travailleur (euse) du sexe",
		"Rapports sexuels avec femme",
		"Rapports sexuels sans pr&eacute;servatif",
		"Rapports sexuels avec un(e) drogu&eacute;(e)",
		"Rapports sexuels avec homosexuel/bisexuel m&acirc;le",
		"Rapports sexuels par voie anale",
		"Rapports sexuels par voie orale",
		"Par drogue injectable",
		"A partag&eacute; des seringues",
		"Histoire/pr&#xe9;sence d'IST",
		"Exposition accidentelle au sang",
		"Agression sexuelle",
		"Transmission verticale",
		"Transfusion sanguine"
	)
);

$localizedMonths = array (
	"en" => array (
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	),
	"fr" => array (
		'janvier',
		 'f&eacute;vrier',
		 'mars',
		 'avril',
		 'mai',
		 'juin',
		 'juillet',
		 'ao&ucirc;t',
		 'septembre',
		 'octobre',
		 'novembre',
		 'd&eacute;cembre'
	)
);

$utf8Months = array (
	"en" => array (
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	),
	"fr" => array (
		'janvier',
		 'février',
		 'mars',
		 'avril',
		 'mai',
		 'juin',
		 'juillet',
		 'août',
		 'septembre',
		 'octobre',
		 'novembre',
		 'décembre'
	)
);

$reportFormTitle = array ("en" => "REPORTS MENU",
			  "fr" => "MENU RAPPORTS");

$reportFormTitle2 = array ("en" => "User Defined Query",
			   "fr" => "Requ&ecirc;te d&eacute;finie par l'utilisateur");

$mustSelect = array (
	"en" => "You must select a patient before running any of these reports",
	"fr" => "Vous devez choisir un patient avant d'effectuer un de ces rapports");

$adhocRep = array ("en" => "",
		   "fr" => "");

$repButton = array ("en" => "Go",
		    "fr" => "Envoyer");

$repReturn = array ("en" => "Close",
		    "fr" => "Fermer");

$adHocError = array ("en" => "You may only do SELECTs.",
		     "fr" => "Vous pouvez seulement faire SELECTs.");

$needPrint = array (
	"en" => array ("Are you sure you want to print in ", " format","Yes"),
	"fr" => array ("&Ecirc;tes-vous s&ucirc;r vous voulez-vous imprimer dans le format de ", "", "Oui")
);


//debugging code to print out the arrays
/*
foreach ($dataQuality as $report) {
  foreach ($report as $key => $value) {
    echo $key .' => '. $value . "\n";
  }
  echo "\n";
}
*/

$kickLabel = array (
	"parameters" => array (
		"en" => "Parameters for the report",
		"fr" => "Param&egrave;tres pour le rapport"
	),
	"patientStatus" => array (
		"en" => array (
			"0" => "Patient Status ",
			"1" => "Active <span class=\"small_cnt\">An active patient on ART is a patient who had a clinic visit within the last 90 days or who still uses ARVs pills during the analysis period (date of next prescription in the future). A patient active in palliative care is a patient not yet under ART and who has had a visit in the last 180 days.</span>",
			"2" => "Inactive <span class=\"small_cnt\">Inactive patient on ART is a patient whose last clinic visit was more than 90 days or who has no more ARV pills during the analysis period (date of last prescription in the past). A patient inactive in palliative care is a patient not yet under ART and who has not had a visit in the last 180 days.</span>",
			"3" => "Discontinued <span class=\"small_cnt\">(Declared discontinued via the discontinuation form)</span>"
		),
		"fr" => array (
			"0" => "Statut du patient",
			"1" => "Actifs <span class=\"small_cnt\">Un patient actif sous ARV est un patient qui a eu une visite clinique dans les 90 derniers jours ou qui a encore des ARV en main pendant la période d’analyse (date de prochaine prescription dans le futur). Un patient actif en soins palliatifs est un patient pas encore sous ARV et qui a eu une visite dans les derniers 180 jours.</span>",
			"2" => "Inactifs <span class=\"small_cnt\">Un patient inactif sous ARV est un patient dont la dernière visite clinique remonte à plus de 90 jours ou qui n’a plus d’ARV en main pendant la période d’analyse (date de dernière prescription dans le passé). Un patient actif en soins palliatifs est un patient pas encore sous ARV et qui a eu une visite dans les derniers 180 jours</span>",
			"3" => "Discontinu&eacute;s <span class=\"small_cnt\">(d&eacute;clar&eacute;s comme tels dans la fiche de discontinuation)</span>"
		)
	),
	"treatmentStatus" => array (
		"en" => array (
			"0" => "Treatment Status",
			"1" => "Any ",
			"2" => "Enrolled on ART ",
			"3" => "Enrolled in palliative care ",
			"4" => "INH prophylaxis ",
			"5" => "Cotrimoxizole ",
			"6" => "TB treatment "
		),
		"fr" => array (
			"0" => "Statut du Traitement ",
			"1" => "Tous statuts ",
			"2" => "Sous TAR ",
			"3" => "Sous soins palliatifs ",
			"4" => "Sous Prophylaxie &agrave; l'INH ",
			"5" => "Sous Cotrimoxazole ",
			"6" => "Sous traitement TB "
		)
	),
	"testType" => array (
		"en" => array (
			"0" => "Test Type",
			"1" => "CD4 ",
			"2" => "PPD ",
			"3" => "Chest X-ray ",
			"4" => "Sputum ",
			"5" => "Liver function ",
			"6" => "Hemogram (CBC) ",
			"7" => "RPR ",
			"8" => "Hepatitis ",
			"9" => "Pap "
		),
		"fr" => array (
			"0" => "Type de Tests",
			"1" => "CD4 ",
			"2" => "PPD ",
			"3" => "X-ray ",
			"4" => "Sputum ",
			"5" => "Bilan h&eacute;patique ",
			"6" => "H&eacute;mogramme ",
			"7" => "RPR ",
			"8" => "L'h&eacute;patite ",
			"9" => "Pap "
		)
	),
	"groupLevel" => array (
		"en" => array (
			"0" => "Organizational Level",
			"1" => "Patients",
			"2" => "Clinic",
			"3" => "Commune",
			"4" => "Department",
			"5" => "Network"
		),
		"fr" => array (
			"0" => "Niveau organisationnel",
			"1" => "Patients",
			"2" => "Clinique",
			"3" => "Commune",
			"4" => "D&eacute;partement",
			"5" => "R&eacute;seau"
		)
	),
	"otherLevel" => array (
		"en" => array (
			"0" => "Demographic Grouping",
			"1" => "None",
			"2" => "Gender",
			"3" => "Age",
			"4" => "Pregnancy <span class=\"small_cnt\">(Only female, age > 14)</span>"
		),
		"fr" => array (
			"0" => "Groupement d&eacute;mographique",
			"1" => "Aucun",
			"2" => "Sexe",
			"3" => "Age",
			"4" => "Grossesse <span class=\"small_cnt\">(femme seulement, &acirc;ge > 14)</span>"
		)
	)
);

$rep510Prompts = array (
	"en" => array ("Enter number of forms you want to see","Enter user who entered forms"),
	"fr" => array ("&Eacute;crivez le nombre de fiches que vous voulez voir","Presentez lutilisateur qui a ecrit des formes")
);
fixLabelsCharset($rep510Prompts);

$repDatePrompts = array (
	"en" => array ("Enter a start date","Enter an end date"),
	"fr" => array ("Écrivez une date de début","Écrivez une date de fin")
);
fixLabelsCharset($repDatePrompts);

$patientCount = array (
	"en" => "Count",
	"fr" => "Nombre"
);

$report520Labels = array (
  "en" => array ("Pregnant women enrolled", "Count", "Percentage", "Monotherapy", "Bitherapy", "Tritherapy", "Total", "Pregnant women under tritherapy", "Other", "Total for all sites"),
  "fr" => array ("Femmes enceintes sous TAR", "Compte", "Pourcentage", "Monoth&eacute;rapie", "Bith&eacute;rapie", "Trith&eacute;rapie", "Total", "Femmes enceintes sous trith&eacute;rapie", "Autre", "Totaux pour tous les cliniques")
);

$dispenseWarnings = array (
	"en" => array("You must select a specific network--All will not work.", "Your date range is too large--range must be <= 2 months."),
	"fr" => array("Vous devez choisir un réseau spécifique--`Tous` ne fonctionneront pas.", "Votre gamme de date est trop étendue--la gamme doit être <= 2 mois.")
);

$buttonLbls = array( 
	"fr" => array("Soumettre", "Annuler"), 
	"en" => array ("Submit", "Reset")
);

$reportFilteringLabels = array (
  "en" => array (
    0 => "Indicator",
    1 => "Hide details with no results.",
    2 => "Week",
    3 => "Month",
    4 => "Year",
    5 => "Older",
    6 => "Newer",
    7 => "Show",
    8 => "Details",
    9 => "Choose Time Period",
    10 => "Filter",
    11 => "No details",
    12 => "Show Details (optional)",
    13 => "by",
    14 => "from",
    15 => "to",
    16 => "Empty detail rows are hidden.",
    17 => " and ",
    18 => "Malaria Reports",
    19 => "Report Filter",
    20 => "Week",
    21 => "F",
    22 => "M",
    23 => "Patient count ",
    24 => "U",
    25 => "First Name",
    26 => "Last Name",
    27 => "Gender",
    28 => "Birth Date",
    29 => "Sort details",
    30 => "Name",
    31 => "Count",
    32 => "Reporting Filters",
    33 => "View Patient List",
    34 => "View Chart",
    35 => "There are no matching records.",
    36 => "Update Report",
    37 => "click the <i class='icon-chevron-down icon-gray'></i> to view.",
    38 => "No town listed.",
    39 => "Patient Commune - Town",
    40 => "View count by ",
    41 => "Help using this report.",
    42 => "Nutrition Surveillance",
    43 => "Indicator Definition",
    44 => "Female",
    45 => "Male",
    46 => "Total",
    47 => "Save CSV file",
    48 => "View the data",
    49 => " of ",
    50 => "All indicators",
    51 => "Indicator Type",
    52 => "All",
    53 => "Numerator",
    54 => "Denominator",
    55 => "Complement",
    56 => "Next Visit Date"
  ),
  "fr" => array (
    0 => "Indicateur",
    1 => "Masquer les détails avec aucun résultat.",
    2 => "Semaine",
    3 => "Mois",
    4 => "Ann&eacute;e",
    5 => "Anciens resultats",
    6 => "Nouveaux resultats",
    7 => "Voir ",
    8 => "Détails ",
    9 => "Choisir une période ",
    10 => "Filtre",
    11 => "Pas de détails",
    12 => "Afficher les détails (facultatif)",
    13 => "par ",
    14 => "de",
    15 => "à",
    16 => "Lignes de détail vides sont masquées.",
    17 => " et ",
    18 => "Rapports paludisme",
    19 => "Rapport filtre ",
    20 => "Sem.",
    21 => "F",
    22 => "H",
    23 => "Nombre de patients ",
    24 => "I",
    25 => "Prénom",
    26 => "Nom",
    27 => "Sexe",
    28 => "Date de naissance",
    29 => "Trier les détails ",
    30 => "Nom",
    31 => "Comte",
    32 => "Rapports filtres ",
    33 => "Afficher la liste des patients",
    34 => "Afficher le graphique",
    35 => "Il n'y a pas d'enregistrements correspondants",
    36 => "Mise à jour du rapport ",
    37 => "cliquez sur <i class='icon-chevron-down icon-gray'></i> pour voir",
    38 => "Aucune localité indiquée.",
    39 => "Patient Commune - Localité",
    40 => "Afficher totale par ",
    41 => "Aide à l'utilisation du présent rapport.",
    42 => "Surveillance de la nutrition",
    43 => "Définition de l\'indicateur",
    44 => "Femme",
    45 => "Homme",
    46 => "Totale",
    47 => "Enregistrer le fichier CSV",
    48 => "Voir les données",
    49 => " d' ",
    50 => "Tous les indicateurs",
    51 => "Type d'indicateur",
    52 => "Tous",
    53 => "Numérateur",
    54 => "Dénominateur",
    55 => "Complément",
    56 => "Date de Prochaine Visite"
  )
);

$report540Labels = array (
  "en" => array (
    "The start date must be prior to the end date.",
    "The end date must be prior to the current date.",
    "Acute hemorrhagic fever",
    "Suspected case of bacterial meningitis",
    "Suspected case of diphtheria",
    "Suspected case of acute flaccid paralysis",
    "Suspected case of measles",
    "Bitten by animal suspected of rabies",
    "Suspected case of malaria",
    "Confirmed case of malaria",
    "Suspected case of dengue",
    "Fever of unknown origin",
    "Febrile icteric syndrome",
    "Non-bloody diarrhea",
    "Acute bloody diarrhea",
    "Suspected case of typhoid",
    "Suspected case of pertussis",
    "Acute respiratory infection",
    "Suspected case of TB",
    "Suspected case of tetanus",
    "Suspected case of cutaneous anthrax",
    "Third trimester or pregnancy complications",
    "New patients seen with other conditions",
    "All selected sites",
    "Diseases / Syndromes",
    "close all",
    "open all",
    "Grand total"
  ),
  "fr" => array (
    "La date de début doit être antérieure à la date de fin.",
    "La date de fin doit être antérieure à la date actuelle.",
    "Syndrome de fièvre hémorragique aiguë",
    "Cas suspect de méningite bactérienne",
    "Cas suspect de diphtérie",
    "Cas suspect de paralysie flasque aiguë",
    "Cas suspect de rougeole",
    "Morsure par animal suspecté de rage",
    "Cas suspect de paludisme (malaria)",
    "Cas confirmé de paludisme (malaria)",
    "Cas suspect de dengue",
    "Fièvre d´origine inconnue",
    "Syndrome ictérique fébrile",
    "Diarrhée aiguë non-sanglante",
    "Diarrhée aiguë sanglante",
    "Cas suspect de typhoïde",
    "Cas suspect de coqueluche",
    "Infection respiratoire aiguë",
    "Cas suspect de tuberculose",
    "Cas suspect de tétanos",
    "Cas suspect de charbon cutané",
    "Troisième trimestre de grossesse ou complications de grossesse",
    "Nouveaux patients vus avec d´autres conditions",
    "Tous les établissements sélectionnés",
    "Maladies / Syndromes",
    "fermer tout",
    "ouvrir tout",
    "Total général"
  )
);
?>
