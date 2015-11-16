<?php

function dxMakeEmpty() {
    return "{border: false, html: '&nbsp;', ctCls: 'diagnosisPanel'}";
}

function dxMakeCategory($category) {
    $output = "{
  xtype: 'label', ctCls: 'diagnosisPanel',
  style: {'font-weight': 'bold'},
  html: '$category'
}
";
  return $output;
}

function dxMakeSpecify($concept) {
  global $tabIndex;
  $textWidget = genExtWidget($concept . '_specify', 'textfield', 0);
  $output = "{
  tabIndex: $tabIndex,
  ctCls: 'diagnosisPanel',
  style: {'margin': '0 0 0 5px'},
  $textWidget
}";
  $tabIndex += 1;
  return $output;
}

function dxMakeSelection($concept, $label) {
	global $tabIndex, $isFollowupEncounter;

	$widgets = array();

	if (! (is_null($label) && !$isFollowupEncounter)) {
		//don't render check boxes if there is no label and it is not a followup encounter
		if ($concept == "hivPositive") { 
			if (isset($GLOBALS['existingData']['hivPositiveA']) && $GLOBALS['existingData']['hivPositiveA'] == 1) {
				$checkWidget_n = "disabled: true," . genExtWidget('dummyHIV', 'checkbox', 0);
			} else {
				$checkWidget_n = genExtWidget($concept. "N", 'checkbox', 1); 
			}
		} else {
			$checkWidget_n = genExtWidget($concept. "", 'checkbox', 1);
		}
		$checkWidget_a = genExtWidget($concept. "A", 'checkbox', 1);
		if ($concept == "hivPositive") { 
			$checkWidget_g = "disabled: true," . genExtWidget($concept. "G",'checkbox',0);
		} else {
			$checkWidget_g = genExtWidget($concept. "G", 'checkbox', 1); 
		}
		if ($isFollowupEncounter) {
			$widgets[] = "tabIndex: $tabIndex, $checkWidget_n";
			$widgets[] = "tabIndex: $tabIndex + 1, $checkWidget_a";
			$widgets[] = "tabIndex: $tabIndex + 2, $checkWidget_g";
			if (is_string($label)) {
				$widgets[] = "xtype: 'label', text: '$label'";
			}
		} else {
			if (is_string($label)) {
				$checkWidget_n = "boxLabel: '$label', " . $checkWidget_n;
			}
			$widgets[] = "tabIndex: $tabIndex, $checkWidget_n";
		}
	}

	if (is_null($label)) {
		dxPrintTextCheckValidationJavascript($concept);
		$textWidget = genExtWidget($concept . '_specify', 'textfield', 0);
		$widgets[] = "tabIndex: $tabIndex, $textWidget"; 
	}

	$output = "{
	xtype: 'fieldset', layout:'column', 
	border: false,
	ctCls: 'diagnosisPanel',
	items: 
	[{" . implode("\n},{\n", $widgets) . "}]
	}
	";
	$tabIndex += 3;
	return $output; 
}

function dxMakeSelectionAndText($concept, $label) {
  dxPrintTextCheckValidationJavascript($concept);
  $label .= ', ' . _('précisez') . ' :';
  return dxMakeSelection($concept, $label) . ',' . dxMakeSpecify($concept);
}

function dxPrintTextCheckValidationJavascript($concept) {
  global $isFollowupEncounter;
  if ($isFollowupEncounter) {
    print "
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('${concept}_specify0'),
				      makeTestAnyIsChecked('${concept}1','${concept}A1','${concept}G1')));";
  } else {
    print "
buildValidation(72, makeTestAllOrNone(makeTestAnyNotBlank('${concept}_specify0'),
				      makeTestAnyIsChecked('${concept}1')));";
  }
}

function dxIndentItem($item) {
  return '{ padding: \'0 0 0 16\',' . substr($item, 1);
}

$dxAll = array(
	'abscess' => _('Abcès [682.9]'),
	'acuteglomerulonephritis' => _('Glomérulonéphrite aiguë [580.9]'),
	'adfActive' => _('Adénofibrome (ADF) du sein [N60.39]'),
	'allergicrhinitis' => _('Rhinite allergique [477]'),
	'amygdalite' => _('Amygdalite') . ' [J03.90]',
	'anemia' => _('Anémie'),
	'asthmaDx' => _('Asthme [J45]'),
	'asthmeattack' => _('Crise d’asthme [J45]'),
	'atopicdermatitis' => _('Dermatite atopique [691]'),
	'avortement' => _('Avortement [O03.9]'),
	'boneFracture' => _('Fracture osseuse [T14.8]'),
	'bronchitis' => _('Bronchite [490]'),
	'burns' => _('Brûlure [T30.0]'),
	'cancer' => _('Cancer'),
	'cancerBreastActive' => _('Cancer de sein [C50.919]'),
	'cancercervical' => _('Cancer du col [C53.9]'),
	'cancercervix' => _('Cancer du col cervical'),
	'cancerEndoActive' => _('Cancer de l’endomètre [C54.1]'),
	'cancerOvaryActive' => _('Cancer de l’ovaire [C56.9]'),
	'cancerprostate' => _('Cancer de la prostate [C61]'),
	'candidVulvoActive' => _('Vulvo vaginite [N76.0]'),
	'cardiopathy' => _('Cardiopathie [I51.9]'),
	'charbon' => _('Charbon [A22.9]'),
	'cholera' => _('Choléra [A00.9]'),
	'chorioamniotite' => _('Chorioamniotite [O41.129]'),
	'conjunctivitis' => _('Conjonctivite [H10.9]'),
	'cystOvaryActive' => _('Kyste de l’ovaire [N83.29]'),
	'dengue' => _('Dengue [A90]'),
	'diabete1' => _('Diabète Type 1 [E10.9]'),
	'diabete2' => _('Diabète Type 2 [E11.9]'),
	'diabetespregnancy' => _('Diabète + grossesse [O99.810]'),
	'diarrheeAqueuse' => _('Diarrhée aigue aqueuse [R19.7]'),
	'diarrheeIndeter' => _('Diarrhée cause indéterminée [R19.7]'),
	'diarrheeSanguin' => _('Diarrhée aigue sanguinolente [R19.7]'),
	'diptheria' => _('Diphtérie [A36]'),
	'dislocation' => _('Luxation [839.8]'),
	'dxMDRtb' => _('MDR TB remplir la section Tuberculose ci-dessous [Z16.24]'),
	'dxTB' => _('Tuberculose [A15.0] remplir la section Tuberculose ci-dessous'),
	'dysOvaryActive' => _('Dystrophie ovarienne [N83.8]'),
	'eclampsia' => _('Eclampsie [O15.9]'),
	'emergencySurgery' => _('Urgence Chirurgicale'),
	'bonneSanteApparente' => _('Bonne Sante Apparente [Z00.129]'),
	'endometriosisActive' => _('Endométriose [N80.9]'),
	'epilepsy' => _('Epilepsie [G40.901]'),
	'febrileseizures' => _('Crises convulsives fébriles [780.31]'),
	'febrileSyndrome' => _('Syndrome ictérique fébrile [B15.9]'),
	'fetalDeathActive' => _('Mort fœtale [O36.4XX0]'),
	'feverHemorrhagicacute' => _('Fièvre hémorragique aiguë [N/A]'),
	'feverIndeter' => _('Fièvre, cause indéterminée [R50.9]'),
	'feverTyphoid' => _('Fièvre Typhoïde * confirmé [Z22.0]'),
	'feverTyphoidSuspected' => _('Fièvre Typhoïde * suspect [A01.00]'), 
	'fibroidUterineActive' => _('Fibrome utérin [D26.9]'),
	'fungalskin' => _('Mycose cutanée [111.9]'),
	'gastroenteritiswithdehydrationmild' => _('déshydratation légère'),
	'gastroenteritiswithdehydrationmoderate' => _('déshydratation modérée'),
	'gastroenteritiswithdehydrationsevere' => _('déshydratation sévère'),
	'gastroesophagealreflux' => _('Reflux gastro-œsophagien [530.81]'),
	'grossesse' => _('Grossesse [Z33.1]'),
	'grossesseEctopique' => _('Grossesse ectopique [O0.00]'),
	'grossesseUterine' => _('Grossesse intra utérine [Z33.1]'),
	'hemorragie' => _('Hémorragie troisième trimestre [O46.90]'),
	'hivPositive' => _('VIH/SIDA [B20]'),
	'htapregnancy' => _('HTA + grossesse [O16.9]'),
	'hyperGravi' => _('Hyperémèse gravidique [O21.0]'),
	'hypertensionArtery' => _('Hypertension artérielle [I10]'),
	'ili' => _('Syndrome Grippal'),
	'impetigo' => _('Impétigo [684]'),
	'infectionAcuteRespiratory' => _('Infection respiratoire aiguë [J06.9]'),
	'infectionTissue' => _('Infection des tissus mous'),
	'irondeficiencyanemia' => _('Anémie Carentielle [281.0]'),
	'ist' => _('IST'),
	'lepra' => _('Lèpre [A30]'),
	'lesionCervicale' => _('Lésion cervicale [D26.0]'),
	'lymphaticFilariasis' => _('Filariose lymphatique [B74.9]'),
	'maladiePelvienne' => _('Maladie inflammatoire pelvienne [N73.9]'), 
	'malariaDx' => _('Malaria (paludisme) confirmé [B52.9]'),
	'malariaDxSevere' => _('Malaria (paludisme) Grave [B52.9]'),
	'malariaDxSuspected' => _('Malaria (paludisme) suspect [B52.9]'),
	'malnutrition' => _('Malnutrition [E40]'),
	'malnutritionmild' => _('Malnutrition aigue légère [263.1]'),
	'malnutritionmoderate' => _('Malnutrition aigue modérée [263]'),
	'malnutritionsevere' => _('Malnutrition aigue sévère [261] (compl.)'),
	'malnutritionsevereSS' => _('Malnutrition aigue sévère [261] (SS compl.)'),
	'malnutritionweightloss' => _('Malnutrition/Perte de poids [E46]'),
	'membraneRupture' => _('Rupture prématurée des membranes [O42.00]'),
	'menacePrema' => _('Menace d’accouchement prématurée [O42.00]'),
	'meningitis' => _('Méningites [G03.9]'),
	'nephroticsyndrome' => _('Syndrome néphrotique [581]'),
	'obesity' => _('Obésité [278.00]'),
	'oligoamnios' => _('Oligoamnios [O41.00X0]'),
	'otherDx' => _('Autre'),
	'otherDx1' => _('Autre'),
	'otherDx2' => _('Autre'),
	'otherDx3' => _('X'),
	'otherDx4' => _('X'),
	'otherDx5' => _('X'),
	'otherDx6' => _('X'),
	'otherDx7' => _('X'),       
	'otitis' => _('Otite'),
	'parasitose' => _('Parasitose [B89]'),
	'pertusis' => _('Coqueluche [A37.90]'),
	'pneumonie' => _('Pneumonie [J18.9]'),
	'polio' => _('Poliomyélite [A80.9]'),
	'polytrauma' => _('Poly traumatisme [869.0]'),
	'preEclampsie' => _('Pré éclampsie [O14.90]'),
'psychiatriqueDisorder' => _('Trouble psychiatrique d’étiologie à investiguer [F99]'),  
	'raa' => _('Rhumatisme articulaire aigu [714.30]'),
	'rage' => _('Rage [A82.9]'),
	'retardCroissanceIU' => _('Retard croissance Intrautérin [P05.9]'),
	'rougeole' => _('Rougeole [B05.89]'),
	'rubella' => _('Rubéole [B06.89]'),
	'scabies' => _('Gale [B86]'),
	'scd' => _('Anémie Falciforme [282.6]'),
	'sexAggression' => _('Agression sexuelle [T74.21XA]'),
	'sicklecell' => _('Drépanocytose : SS/SC [D57.1]'),
	'sprain' => _('Entorse [848.9]'),
	'stress' => _('Stress post traumatique [F43.10]'),
	'stroke' => _('Accident cérébro-vasculaire [I63.50]'),
	'syphilis' => _('Syphilis [A53.9]'),
	'teigne' => _('Teigne [B35.9]'),
	'tetanus' => _('Tétanos [A35]'),
	'thrombopenie' => _('Thrombopénie [D69.6]'),
	'thrombose' => _('Thromboses'),
	'traumaHead' => _('Trauma crânien [S09.90XA]'),
	'travailActive' => _('Travail, Actif'),
	'travailLatent' => _('Travail, Latent'),	 
	'vaginalBleedingAbn' => _('Saignement utérin anormal [N93.8]'),
	'varicelle' => _('Varicelle [B01.9]'), 
	'wound' => _('Plaie'),
        'pathRenale' => _('Pathologie rénale, précisez:')
);
if ($isObgynEncounter) {
  $dxAll['genUriInfectionDx'] = _('Infection génito-urinaire (IGU) [N73.9]');
} else {
  $dxAll['genUriInfectionDx'] = _('Infection génito-urinaire');
}

// NEW PLAN: dxAll then add later for a specify or other.
// sor array look s like this:
//$dxexamplearry array (0=>{0=>'stroke',1=>true, 2=>false, 3=>true});

if ($isFollowupEncounter) $nag = _('N&nbsp; &nbsp;A&nbsp; &nbsp;G&nbsp;&nbsp;&nbsp;&nbsp;');
else $nag = '';

if ($isAdultEncounter) {
  $dxThisItems = array();
  // concept, t for textbox, n for notification asterisk
  $dxThisItems[] = dxMakeCategory($nag . _('Générales    [Code CIM 10]'));
  $dxThisItems[] = array('concept' => 'stroke', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'anemia', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'asthmaDx', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'cardiopathy', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'diabete1', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'diabete2', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'diarrheeAqueuse', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'diarrheeSanguin', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'sicklecell', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'epilepsy', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'feverIndeter', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'grossesse', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'hypertensionArtery', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'malnutritionweightloss', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'emergencySurgery', 't' => false , 'n' => false);
  $dxThisItems[] = dxMakeCategory(_('Maladies infectieuses'));
  $dxThisItems[] = array('concept' => 'amygdalite', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'charbon', 't' => true , 'n' => true);
  $dxThisItems[] = array('concept' => 'cholera', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'conjunctivitis', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'pertusis', 't' => false , 'n' => true);
  $dxThisItems[] = dxMakeEmpty(); 
  $dxThisItems[] = dxMakeEmpty(); 
  $dxThisItems[] = dxMakeEmpty();
 
// column 2
  $dxThisItems[] = dxMakeCategory($nag . _('Maladies Infectieuses    [Code CIM 10]'));
  $dxThisItems[] = array('concept' => 'dengue', 't' => true , 'n' => true);  
  $dxThisItems[] = array('concept' => 'diptheria', 't' => false, 'n' => true);
  $dxThisItems[] = array('concept' => 'feverHemorrhagicacute', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'feverTyphoid', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'feverTyphoidSuspected', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'lymphaticFilariasis', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'scabies', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'infectionAcuteRespiratory', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'genUriInfectionDx', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'infectionTissue', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'ist', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'lepra', 't' => false, 'n' => false);  
//  $dxThisItems[] = "{
//	  xtype: 'label', ctCls: 'diagnosisPanel',
//	  html: '" . _('Malaria (paludiame) * [B52.9]') . ":'
//	}";
  $dxThisItems[] = array('concept' => 'malariaDxSuspected', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'malariaDx', 't' => false , 'n' => true); 
//$dxThisItems[] = dxIndentItem(dxMakeSelection('malariaDxSuspected', $dxAll['malariaDxSuspected']));
//$dxThisItems[] = dxIndentItem(dxMakeSelection('malariaDx', $dxAll['malariaDx']));
//$dxThisItems[] = dxIndentItem(dxMakeSelection('malariaDxSevere', $dxAll['malariaDxSevere']));
  $dxThisItems[] = array('concept' => 'meningitis', 't' => true , 'n' => true);
  $dxThisItems[] = array('concept' => 'otitis', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'parasitose', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'pneumonie', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'polio', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'rage', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'rougeole', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'rubella', 't' => false , 'n' => true); 
  $dxThisItems[] = array('concept' => 'febrileSyndrome', 't' => false, 'n' => true);

// column 3
  $dxThisItems[] = dxMakeCategory($nag . _('Maladies Infectieuses    [Code CIM 10]'));
  $dxThisItems[] = array('concept' => 'teigne', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'tetanus', 't' => false , 'n' => true);
  $dxThisItems[] = array('concept' => 'dxTB', 't' => false , 'n' => false); 
  $dxThisItems[] = array('concept' => 'dxMDRtb', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'varicelle', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'hivPositive', 't' => false , 'n' => true);
  $dxThisItems[] = dxMakeCategory(_('Psychiatrie'));
  $dxThisItems[] = array('concept' => 'psychiatriqueDisorder', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'stress', 't' => false , 'n' => false);
  $dxThisItems[] = dxMakeCategory(_('Trauma'));
  $dxThisItems[] = array('concept' => 'sexAggression', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'burns', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'boneFracture', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'wound', 't' => true , 'n' => false);
  $dxThisItems[] = array('concept' => 'traumaHead', 't' => false , 'n' => false);
  $dxThisItems[] = dxMakeCategory(_('Pathologies tumorales'));
  $dxThisItems[] = array('concept' => 'cancercervical', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'cancerprostate', 't' => false , 'n' => false);
  $dxThisItems[] = array('concept' => 'cancerBreastActive', 't' => false , 'n' => false);
  $dxThisItems[] = dxMakeCategory(_('Autres'));
  $dxThisItems[] = dxMakeSpecify('otherDx1', null);
  $dxThisItems[] = dxMakeSpecify('otherDx2', null);
  $dxThisItems[] = dxMakeEmpty();
}

if ($isObgynEncounter) {
    $dxThisItems = array (
      dxMakeCategory($nag . _('Pathologies    [Code CIM 10]')),
      array('concept' => 'sexAggression', 't' => false , 'n' => false), 
      array('concept' => 'adfActive', 't' => false , 'n' => false), 
      array('concept' => 'anemia', 't' => false , 'n' => false),
      array('concept' => 'avortement', 't' => true , 'n' => false), 
      array('concept' => 'cancerEndoActive', 't' => false , 'n' => false), 
      array('concept' => 'cancerOvaryActive', 't' => false , 'n' => false), 
      array('concept' => 'cancerBreastActive', 't' => true , 'n' => false),
      array('concept' => 'cardiopathy', 't' => true , 'n' => false),
      array('concept' => 'chorioamniotite', 't' => false , 'n' => false), 
      array('concept' => 'diabetespregnancy', 't' => true , 'n' => false), 
      array('concept' => 'dysOvaryActive', 't' => true , 'n' => false), 
      array('concept' => 'eclampsia', 't' => false , 'n' => false),
      dxMakeEmpty(),
      dxMakeEmpty(),
      dxMakeEmpty(),
      dxMakeEmpty(),

      dxMakeCategory($nag . _('Pathologies    [Code CIM 10]')),
      array('concept' => 'endometriosisActive', 't' => true , 'n' => false),
      array('concept' => 'fibroidUterineActive', 't' => true , 'n' => false),
      array('concept' => 'grossesseEctopique', 't' => true , 'n' => false), 
      array('concept' => 'grossesseUterine', 't' => false , 'n' => false), 
      array('concept' => 'htapregnancy', 't' => false , 'n' => false), 
      array('concept' => 'hemorragie', 't' => true , 'n' => false), 
      array('concept' => 'hyperGravi', 't' => false , 'n' => false), 
      array('concept' => 'genUriInfectionDx', 't' => false , 'n' => false), 
      array('concept' => 'ist', 't' => true , 'n' => false), 
      array('concept' => 'cystOvaryActive', 't' => true , 'n' => false),
      array('concept' => 'lesionCervicale', 't' => true, 'n' => false), 
      array('concept' => 'maladiePelvienne', 't' => false , 'n' => false),
      array('concept' => 'malariaDxSuspected', 't' => false , 'n' => true),
      array('concept' => 'malariaDx', 't' => false , 'n' => true),

      dxMakeCategory($nag . _('Pathologies    [Code CIM 10]')),
      array('concept' => 'menacePrema', 't' => false , 'n' => false), 
      array('concept' => 'fetalDeathActive', 't' => false, 'n' => false),
      array('concept' => 'oligoamnios', 't' => false , 'n' => false),
      array('concept' => 'pathRenale', 't' => false , 'n' => false),
      array('concept' => 'preEclampsie', 't' => true , 'n' => false),
      array('concept' => 'retardCroissanceIU', 't' => false , 'n' => false), 
      array('concept' => 'membraneRupture', 't' => false , 'n' => false), 
      array('concept' => 'vaginalBleedingAbn', 't' => false , 'n' => false),
      array('concept' => 'syphilis', 't' => false , 'n' => false), 
      array('concept' => 'thrombopenie', 't' => false , 'n' => false), 
      array('concept' => 'thrombose', 't' => false , 'n' => false),
      array('concept' => 'dxTB', 't' => false , 'n' => false),
      array('concept' => 'dxMDRtb', 't' => false , 'n' => false),
      array('concept' => 'travailLatent', 't' => false , 'n' => false),
      array('concept' => 'travailActive', 't' => false , 'n' => false), 
      array('concept' => 'hivPositive', 't' => false , 'n' => false), 
      array('concept' => 'candidVulvoActive', 't' => false , 'n' => false), 
      '{xtype: \'label\', text: \'' . _('Autre, précisez') . ':\'}',
      dxMakeSpecify('otherDx', null),
      dxMakeSpecify('otherDx2', null)
    );
}

if ($isPediatricEncounter) {
  $dxThisItems = array(
    dxMakeCategory($nag . _('Générale    [Code CIM 10]')),
    array('concept' => 'irondeficiencyanemia', 't' => false , 'n' => false), 
    array('concept' => 'scd', 't' => false , 'n' => false), 
    array('concept' => 'asthmaDx', 't' => false , 'n' => false),  
    array('concept' => 'bronchitis', 't' => false , 'n' => false), 
    array('concept' => 'cardiopathy', 't' => false , 'n' => false), 
    array('concept' => 'febrileseizures', 't' => false , 'n' => false), 
    array('concept' => 'malnutritionmild', 't' => false , 'n' => false), 
    array('concept' => 'malnutritionmoderate', 't' => false , 'n' => false), 
    array('concept' => 'malnutritionsevere', 't' => false , 'n' => false),
    array('concept' => 'malnutritionsevereSS', 't' => false , 'n' => false),  
    array('concept' => 'atopicdermatitis', 't' => false , 'n' => false), 
    array('concept' => 'diabete1', 't' => false , 'n' => false), 
    array('concept' => 'diarrheeAqueuse', 't' => false , 'n' => true), 
    array('concept' => 'diarrheeSanguin', 't' => false , 'n' => true), 
    array('concept' => 'diarrheeIndeter', 't' => false , 'n' => false), 
    array('concept' => 'sicklecell', 't' => false , 'n' => false), 
    array('concept' => 'epilepsy', 't' => false , 'n' => false), 
    array('concept' => 'feverIndeter', 't' => false , 'n' => false),
    "{ xtype: 'label', ctCls: 'diagnosisPanel', html: '" . _('Gastro-entérite [558.9] avec') . ":' }",
      dxIndentItem(dxMakeSelection('gastroenteritiswithdehydrationmild', $dxAll['gastroenteritiswithdehydrationmild'])),
      dxIndentItem(dxMakeSelection('gastroenteritiswithdehydrationmoderate', $dxAll['gastroenteritiswithdehydrationmoderate'])),
      dxIndentItem(dxMakeSelection('gastroenteritiswithdehydrationsevere', $dxAll['gastroenteritiswithdehydrationsevere'])),
    array('concept' => 'grossesse', 't' => false , 'n' => false), 
    array('concept' => 'obesity', 't' => false , 'n' => false), 
    array('concept' => 'raa', 't' => false , 'n' => false), 
    array('concept' => 'allergicrhinitis', 't' => false , 'n' => false), 
    array('concept' => 'gastroesophagealreflux', 't' => false , 'n' => false), 
    array('concept' => 'nephroticsyndrome', 't' => false , 'n' => false), 
    array('concept' => 'emergencySurgery', 't' => true , 'n' => false),
    array('concept' => 'bonneSanteApparente', 't' => false , 'n' => false),
	dxMakeEmpty(), 
    dxMakeEmpty(),
    dxMakeEmpty(),
    dxMakeEmpty(),

    // 2nd column starts here
    dxMakeCategory($nag . _('Maladies infectieuses    [Code CIM 10]')),
    array('concept' => 'abscess', 't' => true , 'n' => false), 
    array('concept' => 'amygdalite', 't' => false , 'n' => false),
    array('concept' => 'charbon', 't' => true , 'n' => true), 
    array('concept' => 'cholera', 't' => false , 'n' => true), 
    array('concept' => 'conjunctivitis', 't' => true , 'n' => false), 
    array('concept' => 'pertusis', 't' => false , 'n' => true), 
    array('concept' => 'dengue', 't' => true , 'n' => true), 
    array('concept' => 'diptheria', 't' => false , 'n' => true), 
    array('concept' => 'feverHemorrhagicacute', 't' => false , 'n' => false), 
    array('concept' => 'feverTyphoid', 't' => false , 'n' => true),
    array('concept' => 'feverTyphoidSuspected', 't' => false , 'n' => true), 
    array('concept' => 'lymphaticFilariasis', 't' => false , 'n' => false), 
    array('concept' => 'scabies', 't' => false , 'n' => false), 
    array('concept' => 'acuteglomerulonephritis', 't' => false , 'n' => false), 
    array('concept' => 'impetigo', 't' => false , 'n' => false), 
    array('concept' => 'genUriInfectionDx', 't' => false , 'n' => false), 
    array('concept' => 'infectionAcuteRespiratory', 't' => false , 'n' => false), 
    array('concept' => 'ist', 't' => true , 'n' => false), 
    array('concept' => 'lepra', 't' => false, 'n' => false),
    array('concept' => 'malariaDxSuspected', 't' => false , 'n' => true),
    array('concept' => 'malariaDx', 't' => false , 'n' => true),
    array('concept' => 'meningitis', 't' => true , 'n' => true), 
    array('concept' => 'fungalskin', 't' => true , 'n' => false), 
    array('concept' => 'otitis', 't' => true , 'n' => false), 
    array('concept' => 'parasitose', 't' => false , 'n' => false), 
    array('concept' => 'pneumonie', 't' => false , 'n' => false),
 
    // 3rd column starts here 
    dxMakeCategory($nag . _('Maladies infectieuses    [Code CIM 10]')),
    array('concept' => 'polio', 't' => false , 'n' => true), 
    array('concept' => 'rage', 't' => false , 'n' => true), 
    array('concept' => 'rougeole', 't' => false , 'n' => true), 
    array('concept' => 'rubella', 't' => false, 'n' => false),
    array('concept' => 'febrileSyndrome', 't' => false , 'n' => true), 
    array('concept' => 'teigne', 't' => false , 'n' => false), 
    array('concept' => 'tetanus', 't' => false , 'n' => false), 
    array('concept' => 'dxTB', 't' => false , 'n' => false), 
    array('concept' => 'dxMDRtb', 't' => false , 'n' => true),
    array('concept' => 'varicelle', 't' => false, 'n' => false),
    array('concept' => 'hivPositive', 't' => false , 'n' => true), 
    dxMakeCategory(_('Psychiatrie')),
    array('concept' => 'psychiatriqueDisorder', 't' => false , 'n' => false),
    array('concept' => 'stress', 't' => false , 'n' => false), 
    dxMakeCategory(_('Trauma')),
    array('concept' => 'sexAggression', 't' => false , 'n' => false), 
    array('concept' => 'burns', 't' => true , 'n' => false), 
    array('concept' => 'sprain', 't' => true , 'n' => false), 
    array('concept' => 'boneFracture', 't' => true , 'n' => false), 
    array('concept' => 'dislocation', 't' => true , 'n' => false), 
    array('concept' => 'wound', 't' => true , 'n' => true), 
    array('concept' => 'polytrauma', 't' => false , 'n' => false), 
    array('concept' => 'traumaHead', 't' => false , 'n' => false), 
    dxMakeCategory(_('Autres Pathologies')),
    dxMakeSpecify('otherDx1', null),
    dxMakeSpecify('otherDx2', null),
    dxMakeEmpty(),
    dxMakeEmpty()
    );
}

$tableColumns = 3;

$dxItemsEXT = array(); // output
foreach ($dxThisItems as $item) {
    if (is_string($item)) {
        $dxItemsEXT[] = $item;
    } else {
        $description = $dxAll[$item['concept']] . ( $item['n'] ? '*': ''); 
        $textbox = $item['t'];

        if ($textbox) {
            $dxItemsEXT[] = dxMakeSelectionAndText($item['concept'], $description);
        } else {
            $dxItemsEXT[] = dxMakeSelection($item['concept'], $description);
        }
    }
} 

$finalMessage = "";
if ($isFollowupEncounter)
	$finalMessage .= _('N: nouveau, A: actif, G: guéri') . "<br />";
if ($isAdultEncounter || $isPediatricEncounter || $isObgynEncounter)
	$finalMessage .= _('* Notifiez le Ministère de la Santé pour le registre de surveillance épidémiologique.');
?>

var diagnosisPanel = new Ext.FormPanel({
    title: '<?=_('IMPRESSIONS CLINIQUES/DIAGNOSTIQUES')?>',
    id: 'diagnoses',
    autoHeight: true,
    padding: 8,
    defaults: {
	    style: {
		marginBottom: '0.25em'
	    },
	    layout: 'form'
    },
    items: [{
		xtype: 'fieldset',
		border: false,
		layout: {type: 'table', columns: <?=$tableColumns?>},
		items: transposeExtTableItems([<?=implode(",\n", $dxItemsEXT)?>], <?=$tableColumns?>, {xtype: 'label', text:''})
	},{
		fieldLabel: '<?=_("Remarque")?>', 
		width: '70em',
		height: '3em', 
		<?=genExtWidget('otherDiagnosesComment', 'textarea', 0)?> 
    },{
		xtype: 'label',
        height: '2em',
		style: {display: 'block'},
                style: { 'font-style': 'italic' },
		html: '<?=$finalMessage?>'
	}] 
}); 
