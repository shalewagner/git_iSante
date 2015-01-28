<a href="downloadraw.php?subjectIdRaw=1">Download here</a>
<br>
<a href="Export\malaria.csv">Download file directly</a>
<br>
<a href="fields.php?subjectid=1">fields</a>
<br>
<a href="aggregateddata.php?subjectId=1&timeLevel=0&geographyLevel=0&ageLevel=0&genderLevel=0&gridType=0&start=0&limit=100">raw</a>
<br>
<a href="aggregateddata.php?subjectId=1&timeLevel=1&geographyLevel=0&ageLevel=0&genderLevel=0&gridType=0&start=0&limit=100">aggregated field list</a>
<br>
<a href="aggregateddata.php?subjectId=1&timeLevel=1&geographyLevel=0&ageLevel=0&genderLevel=0&gridType=1&start=0&limit=100">aggregated field list by time interval</a>

<br>
<a href="downloadaggregated.php?subjectId=1&timeLevel=0&geographyLevel=0&ageLevel=0&genderLevel=0&gridType=0&start=0&limit=100">Download aggregated</a>
<br>


<form method="post" action="query.php">
    <input type="text" name="requestJson" value="">
    <button type="submit">go</button>
</form>
<br>
<form name="input" action="customindicator.php" method="post">
    Get Custom Indicator: <input type="text" name="requestJson">
    <input type="submit" value="Submit">
</form>


<form name="input" action="createuserindicator.php" method="post">
    Request Data for Create Indicator: <input type="text" name="indicator">
    <input type="submit" value="Submit">
</form>

<a href="apitest.php?equation='1+1'">Run equation</a>
<?PHP
phpinfo();
?>


