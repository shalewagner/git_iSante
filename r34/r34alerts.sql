DELETE FROM alertLookup where alertid > 93;
INSERT INTO alertLookup (alertid, alertname, descriptionfr,descriptionen,messagefr,messageen,alertgroup, priority) VALUES (
100,
'r34alert',
'',
'',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:blue" value="Success...Click for more..." onclick="r34Popup()"/>',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:blue" value="Succès...Cliquez pour plus d’informations..." onclick="r34Popup()"/>',
1,
1);
INSERT INTO alertLookup (alertid, alertname, descriptionfr,descriptionen,messagefr,messageen,alertgroup, priority) VALUES (
200,
'r34alert',
'',
'',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:lightgreen" value="Minimal Risk...Click for more..." onclick="r34Popup()"/>',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:lightgreen" value="Risque Minimal...Cliquez pour plus d’informations..." onclick="r34Popup()"/>',
1,
2);
INSERT INTO alertLookup (alertid, alertname, descriptionfr,descriptionen,messagefr,messageen,alertgroup, priority) VALUES (
300,
'r34alert',
'',
'',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:yellow" value="Medium Risk...Click for more..." onclick="r34Popup()"/>',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:yellow" value="Risque Moyen...Cliquez pour plus d’informations..." onclick="r34Popup()"/>',
1,
3);
INSERT INTO alertLookup (alertid, alertname, descriptionfr,descriptionen,messagefr,messageen,alertgroup, priority) VALUES (
400,
'r34alert',
'',
'',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:orange" value="High Risk...Click for more..." onclick="r34Popup()"/>',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:orange" value="Risque Haut...Cliquez pour plus d’informations..." onclick="r34Popup()"/>',
1,
3);
INSERT INTO alertLookup (alertid, alertname, descriptionfr,descriptionen,messagefr,messageen,alertgroup, priority) VALUES (
500,
'r34alert',
'',
'',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:red" value="Possible Failure (virologic)...Click for more..." onclick="r34Popup()"/>',
'HIV Status&nbsp;<input type="button" name="r34" style="background-color:red" value="Échec possible (virologique)...Cliquez pour plus d’informations..." onclick="r34Popup()"/>',
1,
5);
DELETE FROM patientAlert WHERE alertID BETWEEN 100 AND 500;
INSERT INTO patientAlert 
SELECT LEFT(s.patientid,5)+0, s.patientid, CASE WHEN riskScore <= 215 THEN 200 WHEN riskScore > 215 AND riskScore <= 270 THEN 300 ELSE 400 END, mDt 
FROM r34Scores s, (select patientid, max(calcDate) as mDt FROM r34Scores GROUP BY 1) b
WHERE s.patientid = b.patientid AND s.calcDate = b.mDt

