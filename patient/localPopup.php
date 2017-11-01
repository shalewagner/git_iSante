<?
$body .= '
<style type="text/css">
body {
	margin:50px 50px 50px 50px;
	font-size: 12pt;
}
checkbox {
	margin:5px 5px 5px 5px;
}
textarea {
	margin:5px 5px 5px 5px;
}
input {
	margin:5px 5px 5px 5px;
}
table, td, th { 
	border: 3px solid gray;
}
.li { 
	padding-left: 30px; 
}
.sup {
	position: relative;
	bottom: 1ex;
	font-size: 50%;
}
input[type=button] {
	text-align:center;
    font-size: 12pt;
    border: none;
	width: 130px;
}
input[type=text] {
	text-align:center;
    font-size: 12pt;
    border: none;
	width: 130px;
}
p.boldText {
	font-size: 16pt;
	font-weight: bold;
	line-spacing: 1
}
p.italic {
	font-size: small;
	font-style: italic;
	line-spacing: 1
}
.grayborder input[type=text] {
	border: 3px solid gray;
	width: 100px;
}
.blue input[type=text] {
    background-color: #0080ff;
}
.green input[type=text] {
    background-color: #00ff00;
}
.yellow input[type=text] {
	background-color: #ffff66;
}
.orange input[type=text] {
	background-color:#ff8000;
}
.red input[type=text] {
	background-color: #ff0000;
}
</style>';
$formTitle = array(
'fr' => '<p class="boldText">Profil de risque pour léchec thérapeutique ARV</p>',
'en' => '<p class="boldText">Risk profile for ARV therapeutic failure</p>');
$currentPercent = array(
'fr' => 'Possession moyenne des médicaments ARV (<i>au cours des 90 derniers jours</i>) : ',
'en' => 'Average possession of ARV drugs (<i>in the last 90 days</i>):');
$calendarTitle = array(
'fr' => 'Calendrier de Risque',
'en' => 'Risk Calendar');
$legend = array(
'fr' => 'Légende : 
<span class="blue"><input type="text" value="Success" readonly></span> | 
<span class="green"><input type="text" value="Risque Minimale" readonly></span> | 
<span class="yellow"><input type="text" value="Risque Moyen" readonly></span> |
<span class="orange"><input type="text" value="Risque Haut" readonly></span> |
<span class="red"><input type="text" value="Échec possible" readonly></span>',
'en' => 'Legend:
<span class="blue"><input type="text" value="Success" readonly></span> | 
<span class="green"><input type="text" value="Minimal Risk" readonly></span> | 
<span class="yellow"><input type="text" value="Medium Risk" readonly></span> |
<span class="orange"><input type="text" value="High Risk" readonly></span> |
<span class="red"><input type="text" value="Possible Failure" readonly></span>');
$xLate = array(
'fr' => 'X - Jours où le patient était en retard pour la recharge des médicaments antirétroviraux (le patient ne possédait pas de médicaments)',
'en' => 'X - Days where patient was late for refill of ART medications (patient did not possess medication)');
$adhere = array(
'fr' => '“L’Histoire de Mon Adhérence" discuté aujourd’hui : ',
'en' => '"The History of My Adherence" discussed today: ');
$yes = array(
'fr' => 'Oui',
'en' => 'Yes'
);
$no = array(
'fr' => 'Non',
'en' => 'No'
);
$history = array(
'fr' => '<p class="boldText">Commentaires antérieurs</p><i>Historique des raisons de non-adhérence et des plans d’action visant à renforcer du patient aux ARVs</i>',
'en' => '<p class="boldText">Previous comments</p><i>History of non-adherence reasons and action plans to strengthen the patient with ARVs</i>');
$planText = array(
'fr' => '<p class="boldText">Commentaires d’aujourd’hui</p><i>Décrivez brièvement les raisons de non-adhérence et/ou le plan d’action du jour visant à renforcer du patient aux ARVs</i>',
'en' => '<p class="boldText">Today’s comments</p><i>Briefly describe the reasons for non-adherence and / or the day’s action plan to strengthen the patient’s ARVs</i>');
$save = array(
'fr' => 'Sauvegarder',
'en' => 'Save');
$cancel = array(
'fr' => 'Annuler',
'en' => 'Cancel');
$explain = array(
'fr' => '<p class="boldText">Explication de la catégorie de risque</p>
<div style="font-size:small; line-height:1">La catégorie de risque se réfère au niveau de risque du patient face à l’échec thérapeutique aux ARVs. Elle est calculée en fonction des :
<ul><li>Résultats de laboratoire du patient.</li>
<li>La régularité de l’approvisionnement en médicaments ARV.</li>
<li>Données cliniques.</li>
<li>Caractéristiques démographiques.</li></ul>
Les patients présentant un risque élevé ou une suspicion d’échec virologique devraient recevoir des conseils plus intensifs pour renforcer l’adhérence à ARV.<br>
Les décisions concernant la modification du traitement antirétroviral devraient être basées sur les normes nationales sur le traitement ARV et le jugement clinique.</div>',
'en' => '<p class="boldText">Explanation of risk categories</p>
<div style="font-size:small; line-height:1">The risk category refers to the risk level of the patient faced with ARV treatment failure. It is calculated according to: 
<ul><li>Patient’s laboratory results.</li>
<li>The regular supply of ARV medicines.</li>
<li>Clinical data.</li>
<li>Demographic characteristics.</li></ul>
Patients at high risk or suspected virologic failure should receive more intensive advice to increase ARV adherence.<br>
Decisions about modifying antiretroviral therapy should be based on national standards for ARV treatment and clinical judgment.</div>');
?>            
