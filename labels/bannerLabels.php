<?php
$banner1 = array (
  "en" => "Clinical and Population Health Record<br /> Version 2",
	"fr" => "I-TECH Haiti Syst&#xe8;me De Collecte De Donn&#xe9;es VIH<br /> Version 2"
);
$bannerHelp = array (
  "en" => "Help",
  "fr" => "Aide"
);
$bannerSite = array (
  "en" => "Site",
  "fr" => "&#xc9;tablissement"
);
$bannerLogout = array (
  "en" => "Logout",
  "fr" => "D&eacute;connexion"
);
$bannerUser = array (
  "en" => "Current User:",
  "fr" => "Utilisateur actuel:"
);
$topLabels = array (
	"en" => array (
		"Overview",
		"Patients",
		"Registry",
		"Reports",
		"Data Quality",
		"Administration",
		"Help"
	),
	"fr" => array (
		"Vue d’ensemble",
		"Patients",
		"Registre",
		"Rapports",
		"Qualit&eacute; des donn&eacute;es",
		"Administration",
		"Aide"
	)
);
$topLabelsId = array (
    "top-overview",
    "top-patients",
    "top-registry",
    "top-reports",
    "top-data",
    "top-admin",
    "top-help"
);
$groups = array (
	"Home"				=> array ("splash", "deid"),
	"Patients"      	=> array ("find", "register", "pedregister", "selected"),
	"Registry"       	=> array ("registryPreARV", "registryARV"),
	"Evaluation"   		=> array ("kickPoint", "qualityCare", "aggregatePop"),
	"DataQuality"  	=> array ("dataQuality", "assignGender"),
	"Administration" 	=> array ("setPrivs","maintainLDAP","maintainSites","adhocSetup"),
	"Help"          	=> array ("announcements","reportDef", "changedoc", "reportFAQ", "about", "changedoc9")
);
// labels for menuitems
$cmdLabel = array (
	"en" => array (
		"Summary",
		"Consolidated Site",
		"Search",
		"Add Adult Patient",
		"Add Pediatric Patient",
		"Current Patient",
		"Delete Patient",
		"Pre-ARV Registry",
		"ARV Registry",
		"Patient Status",
		"Quality of Care",
		"Program Management",
		"Data Quality",
		"Demographic Information Correction",
		"Set user access level",
		"Add/Delete Users",
		"Configuration",
		"Query",
		"Announcements",
		"Report Definitions",
		"New in version 6.0",
		"Frequently Asked Questions",
		"More about this application",
		"Transfer patient(s) into clinic",
		"New in version 9.0",
		"New in version 8.0",
		"Patient Record Request/Transfer User Guide",
		"Add patient via records request or transfer",
		"User Management",
		"Primary Care",
		"Ob/Gyn",
		"Search With Fingerprint",
		"PMTCT",
		"Antenatal",
		"Delivery",
		"Postnatal",
		"Other",
		"Malaria Surveillance",
		"Lab Order Queue Status",
		"Nutrition Surveillance",
		"TB Surveillance",
		"Register or Update Smartcard",
		"HIV Status",
		"OB/GYN Surveillance",
		"Data quality Surveillance",
		"MER Indicator",
		"Upload Viral Load",
		'Weekly monitoring',
		"ART Drugs Dispense"
	),
	"fr" => array (
		"R&eacute;capitulatif",
		"Site consolid&eacute; &nbsp;&nbsp;&nbsp;&nbsp;",
		"Rechercher",
		"Ajouter patient adulte",
		"Ajouter patient p&eacute;diatrique",
		"Patient en cours",
		"Supprimer patient",
		"Registre Pr&eacute;-ARV",
		"Registre ARV",
		"Statut des Patients",
		"Qualit&eacute; des soins",
		"Gestion de programme",
		"Qualit&eacute; des donn&eacute;es",
		"Mise &agrave; jour d\'information d&eacute;mographique",
		"D&eacute;terminer le niveau d\'acc&egrave;s d\'utilisateur",
		"Ajouter/supprimer utilisateur",
		"Configuration",
		"Requ&ecirc;te",
		"Nouveaut&eacute;s",
		"D&eacute;finitions de rapport",
		"Nouveau dans la version 6.0",
		"Questions fr&eacute;quemment pos&eacute;es",
		"&Agrave; propos de l&#39;application",
		"Transf&eacute;rez les patients dans la clinique",
		"Nouveau dans la version 9.0",
		"Nouveau dans la version 8.0",
		"Guide d’utilisateur Requ&ecirc;te de dossiers patient/Transfert",
		"Ajouter patient via une demande de dossier ou une demande de transfert",
		"Gestion d’utilisateur",
		"Soins de sant&eacute; primaire",
		"Ob-Gyn",
		"Recherche avec empreinte digitale",
		"PTME",
		"Prénatal",
		"Accouchement",
		"Postnatal",
		"Autre",
		"Surveillance du paludisme",
		"File d’attente des ordres laboratoires",
		"Surveillance de la nutrition",
		"Surveillance de la tuberculose",
		"Écriture de smartcard",
		"VIH Status",
		"Surveillance de l'OB/GYN",
		"Surveillance de la Qualité de données",
		"Indicateur MER",
		"T&eacute;l&eacute;chargement Charge Virale",
		"Surveillance Hepdomadaire",
		"Distribution de Medicament ARV"
	)
);
// pages mapped to labels. Also used to define IDs in navigation structure
$cmdList = array (
	"splash",
	"deid",
	"find",
	"register",
	"pedregister",
	"currentPatient",
	"deletePat",
	"registryPreARV",
	"registryARV",
	"kickPoint",
	"qualityCare",
	"aggregatePop",
	"dataQuality",
	"assignGender",
	"setPrivs",
	"maintainLDAP",
	"config",
	"adhocSetup",
	"announcements",
	"reportDef",
	"changedoc",
	"reportFAQ",
	"about",
	"patientTransfer",
	"changedoc9",
	"changedoc8",
	"recordRequest",
	"findGlobal",
	"maintainLDAP",
	"primaryCare",
	"obGyn",
	"GetID",
	"obGynPmtct",
	"obGynAntenatal",
	"obGynDelivery",
	"obGynPostnatal",
	"obGynOther",
	"malaria",
	"encounterStatus",
	"nutrition",
	"tb",
	"writeSmartcard",
	"hivstatus",
	"hepdo",
	"artDist"
);

$sumTitle = array (
   "en" => "Medical summary",
   "fr" => "Resum&eacute; du dossier m&eacute;dical"
);

$noSiteAssigned = array ( 
	"en" => "Not Assigned",
	"fr" => "Non assign&eacute;"
);

//FIXME - both translations by Google.
$noCurrentPatient = array ( 
	"en" => "No patient has been selected.",
	"fr" => "Aucun patient n'a &eacute;t&eacute; s&eacute;lectionn&eacute;."
);
$noFingerprintMessage = array ( 
	"en" => "Fingerprinting is unavailable. Must be using Internet Explorer and have a fingerprint scanner connected.",
	"fr" => "Empreintes digitales n'est pas disponible. Devez utiliser Internet Explorer et ont un scanner d'empreintes digitales connect&eacute;."
);
$noSmartcardMessage = array ( 
	"en" => "Smartcard is unavailable. Must be using Internet Explorer and have a smartcard reader and fingerprint scanner connected.",
	"fr" => "Smartcard n'est pas disponible. Devez utiliser Internet Explorer et ont un lecteur smartcard et un scanner d'empreintes digitales connect&eacute;s."
);

?>
