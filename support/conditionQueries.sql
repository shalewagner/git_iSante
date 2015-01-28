/* This query maps specific condition names to wildcard values 
 * used in reports.xml to look for the correct conditions for reports
 * i.e. where testnamefr like '%cd4%'
 */
 
select 'diabetes', conditionsID, conditionCode, conditionNameEn, conditionGroup, conditionDisplay, conditionSort from conditionLookup where conditionCode like '%urin%' or conditionNameFr like '%urin%' or conditionNameEn like '%urin%' union
select 'malariaL', conditionsID, conditionCode, conditionNameEn, conditionGroup, conditionDisplay, conditionSort from conditionLookup where conditionCode like '%malaria%' or conditionNameFr like '%malaria%' or conditionNameEn like '%malaria%' or conditionsID in (45, 335, 716,717) union
select 'malariaC', concept_id, short_name, description, null, null,  null from concept where concept_id in (71148,71149,71150) or short_name like 'malaria%' or short_name like 'malariaSuspected%' or short_name like 'malariaSevere%' union
select 'hiv', conditionsID, conditionCode, conditionNameEn, conditionGroup, conditionDisplay, conditionSort from conditionLookup where conditionCode like '%vih%' or conditionNameFr like '%vih%' or conditionNameEn like '%vih%' union 
select 'tuberculosisL', conditionsID, conditionCode, conditionNameEn, conditionGroup, conditionDisplay, conditionSort from conditionLookup where conditionCode like '%tb%' or conditionNameFr like '%tb%' or conditionNameEn like '%tb%' or conditionsID in (20, 21, 41, 208, 405, 409, 423) union
select 'tuberculosisC', concept_id, short_name, description, null, null,  null from concept where concept_id in (70351, 71224, 71271)     
or short_name like 'tbDx%' order by 1,2;


/*
$syndromes = array (
array ( "label" => "Acute hemorrhagic fever", "concepts" => "('70882')", "conditions" => "('')" ), 
array ( "label" => "Suspected case of bacterial meningitis", "concepts" => "('70320')", "conditions" => "('205')" ), 
array ( "label" => "Suspected case of diphtheria", "concepts" => "('70296')", "conditions" => "('')" ), 
array ( "label" => "Suspected case of acute flaccid paralysis", "concepts" => "('70201')", "conditions" => "('')" ), 
array ( "label" => "Suspected case of measles", "concepts" => "('70339')", "conditions" => "('47')" ), 
array ( "label" => "Bitten by animal suspected of rabies", "concepts" => "('70336')", "conditions" => "('')" ), 
array ( "label" => "Suspected case of malaria", "concepts" => "('70850', '71148')", "conditions" => "('45', '335', '716')" ), 
array ( "label" => "Confirmed case of malaria", "concepts" => "('71149')", "conditions" => "('717')", ), 
array ( "label" => "Suspected case of dengue", "concepts" => "('70292')", "conditions" => "('')" ), 
array ( "label" => "Fever of unknown origin", "concepts" => "('70246')", "conditions" => "('')" ), 
array ( "label" => "Febrile icteric syndrome", "concepts" => "('70342')", "conditions" => "('')" ), 
array ( "label" => "Non-bloody diarrhea", "concepts" => "('70258')", "conditions" => "('')" ), 
array ( "label" => "Acute bloody diarrhea", "concepts" => "('70261')", "conditions" => "('')" ), 
array ( "label" => "Suspected case of typhoid", "concepts" => "('70302')", "conditions" => "('50')" ), 
array ( "label" => "Suspected case of pertussis", "concepts" => "('70289')", "conditions" => "('')" ), 
array ( "label" => "Acute respiratory infection", "concepts" => "('70308')", "conditions" => "('9', '403')" ), 
array ( "label" => "Suspected case of TB", "concepts" => "('70351', '71224', '71271')", "conditions" => "('20', '21', '41', '208', '405', '409', '423')" ), 
array ( "label" => "Suspected case of tetanus", "concepts" => "('70348', '70855')", "conditions" => "('')" ), 
array ( "label" => "Suspected case of cutaneous anthrax", "concepts" => "('70279')", "conditions" => "('')" ), 
array ( "label" => "Third trimester or pregnancy complications", "concepts" => "('7209', '70057', '70066', '70067', '70069', '70078', '70082', '70084', '70086', '70087', '70103')", "conditions" => "('439', '713')" ), 
array ( "label" => "New patients seen with other conditions", "concepts" => "", "conditions" => "" ) );


$report540Labels = array (
  "en" => array (
0    "The start date must be prior to the end date.",
1    "The end date must be prior to the current date.",
2    "",
3    ,
4    ,
5    ,
6    ,
7    ,
8    ,
9    ,
10    ,
11    ,
12    ,
13    ,
14    ,
15    ,
16    ,
17    ,
18    "Suspected case of TB",
19    "Suspected case of tetanus",
20    "Suspected case of cutaneous anthrax",
21    "Third trimester or pregnancy complications",
22    "New patients seen with other conditions",
*/