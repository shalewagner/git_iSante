insert into alertLookup (alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority) values
(7,'nextDisensation30D',
'Tout patient dont la prochaine date de dispensation (next_disp) arrive dans les 30 prochains jours par rapport à la date de consultation actuelle',
'All patients whose next dispensation date (next_disp) will arrive within 30 days of the current consultation date',
'Le patient doit venir renflouer ses ARV dans les 30 prochains jours.',
'The patient must replenish his ARVs within the next 30 days.',
2,1),(8,'nextDisensation',
'Patient dont la prochaine date de dispensation se situe dans le passe par rapport à la date de consultation actuelle',
'All patients whose next dispensing date (next_disp) is in the past from the current consultation date',
'Le patient n a plus de médicaments disponibles',
'Patient no longer has medications available',2,2);
