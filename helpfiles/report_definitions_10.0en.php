<TABLE WIDTH="930">
<TR>
<TD WIDTH="930">
<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=6 STYLE="font-size: 22pt"><B>EMR
Report Definitions</B></FONT></FONT></FONT></P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B><A NAME="10.0">10.0
	Quality of Care: Eligible for TB treatment but not initiated</A></B></FONT></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif">This
	category includes four reports to be used as reminders for TB
	treatment for specific patients at the selected clinic site.  Three
	of the reports list patients that meet certain criteria related to
	TB but have not yet received any treatment for TB.  The fourth
	report displays a list of patients for whom TB treatment has been
	completed.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="10.1">10.1
	Usage</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">To
	use these reports, simply select one or more patient status groups
	from the 'Patient Status' section of the report parameters page,
	select a date range and select any other criteria on that page to be
	used in generating the report results that are desired <I>(see
	section <A HREF="helpfile.php?file=report_definitions_5.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#5.0">5.0 Report Parameters Page</A> above for definitions of the
	sections on the report parameters page)</I>.  Then, click the
	'Submit' button.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="10.2">10.2
	Results</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">The
	report results will appear in a new browser window (or a new browser
	tab, depending on how your browser is configured).  An example
	results header is shown in <A HREF="#10.2.1">10.2.1 Figure 9</A> </FONT><FONT FACE="Arial, sans-serif"><I>(below)</I></FONT><FONT FACE="Arial, sans-serif">.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><A NAME="10.2.1"><IMG SRC="images/report_definitions_html_m4fa92ea1.jpg" NAME="graphics9" ALIGN=BOTTOM WIDTH=800 HEIGHT=138 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>10.2.1
	Figure 9: Results header for the 'Patients with signs and symptoms
	of TB, but with no sputum or X-ray test' report</I></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">There
	are three action buttons at the top of the report results.  The
	'Close' button will close the report results window (or tab).  The
	'pdf' and 'excel' buttons will generate alternate versions of the
	same report results in either PDF or CSV formats respectively.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">Below
	the three action buttons is a summary of the parameters used to
	generate the report results as provided on the report parameters
	page.  Underneath the parameter summary is the results header.  Each
	of the columns can be sorted in ascending or descending order by
	clicking on the down arrow (left side) or up arrow (right side) next
	to the column title.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="10.3">10.3
	Relevant Definitions</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><I>(see
	section <A HREF="helpfile.php?file=report_definitions_6.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#6.3">6.3 Relevant Definitions</A> above for definitions of the
	columns titled 'Clinic Patient ID', 'National ID', 'First Name',
	'Last Name', 'Gender', 'Age', 'Status' and 'Last Date')</I></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.1">10.3.1
	Signs and symptoms evocative of TB</A></I></FONT></FONT><I>:</I>
	 The reason why the patient has a suspected diagnosis
	of TB.  This data is derived from the <SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">following
	locations within the EMR:</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px">
			<FONT FACE="Arial, sans-serif"><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">Any
			non-resolved TB diagnosis entered on a patient's intake or
			follow-up form in the sections titled 'Past and Present Diagnoses
			by WHO Stage' or 'Current Diagnoses/Evolution'.  </SPAN></SPAN></SPAN><SPAN LANG="en-US"><I><B><SPAN STYLE="background: transparent">Note:</SPAN></B></I></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">
			 This section is titled 'Past and Present Diagnoses' on the
			pediatric versions of the forms.</SPAN></SPAN></SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT FACE="Arial, sans-serif"><SPAN LANG="en-US"><SPAN STYLE="font-style: normal"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">The
			element titled 'Suspected TB, refer for evaluation' or '</SPAN></SPAN></SPAN></SPAN></FONT>TB
			suspected based upon symptoms' selected on a patient's intake or
			follow-up form in the section titled 'TB Status' or 'TB
			Evaluation'.
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px">
			<FONT FACE="Arial, sans-serif"><SPAN STYLE="background: transparent">Any
			of the following combinations of selected symptoms on a patient's
			most recent intake or follow-up form in the sections titled
			'Symptoms' and 'Symptoms by WHO Stage'. <I><B>Note:</B></I> The
			equivalent section for 'Symptoms by WHO Stage' is titled 'Symptoms
			Qualifying for WHO Stages I-IV' on the pediatric versions of the
			forms.</SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<UL>
				<LI STYLE="list-style: square outside;margin-left: 50px">
				<FONT FACE="Arial, sans-serif"><SPAN STYLE="background: transparent">'Cough
				&gt; 3 weeks' and 'Night sweats' and either 'Fever &lt;1 month'
				or 'Fever &gt;1 month'</SPAN></FONT>
				<LI STYLE="list-style: square outside;margin-left: 50px">
				<FONT FACE="Arial, sans-serif"><SPAN STYLE="background: transparent">'Cough,
				productive' and 'Night sweats' and either 'Fever &lt;1 month' or
				'Fever &gt;1 month'</SPAN></FONT>
				<LI STYLE="list-style: square outside;margin-left: 50px">
				<FONT FACE="Arial, sans-serif"><SPAN STYLE="background: transparent">'Hemoptysis'
				and 'Night sweats' and either 'Fever &lt;1 month' or 'Fever &gt;1
				month'</SPAN></FONT>
			</UL>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.2">10.3.2
	No sputum or X-ray test</A></I></FONT></FONT><I>:</I>
	 The absence of a sputum or chest X-ray test result for a patient. 
	This data is derived from a patient's laboratory forms for the tests
	titled 'Sputum' and 'Chest X-Ray' where no <SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">test
	result is entered in the column titled 'Result' or the box titled
	'Results'.</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.3">10.3.3
	Patients with abnormal sputum or X-ray test results</A></I></FONT></FONT><I>:</I>
	 <SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">An
	abnormal result for the tests titled 'Sputum' or 'Chest X-Ray'. 
	This data is derived from any laboratory test titled 'Sputum' or
	'Chest X-Ray' with a result designated as abnormal on the patient's
	laboratory forms in the column titled 'Abnormal result'.</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.4">10.3.4
	No established TB diagnosis</A></I></FONT></FONT><I>:</I>
	 The absence of a TB diagnosis for a patient.  This data is derived
	from a<SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">ny
	non-resolved TB diagnosis entered on a patient's intake or follow-up
	form in the sections titled 'Past and Present Diagnoses by WHO
	Stage' or 'Current Diagnoses/Evolution'.  </SPAN></SPAN></SPAN><SPAN LANG="en-US"><I><B><SPAN STYLE="background: transparent">Note:</SPAN></B></I></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">
	 This section is titled 'Past and Present Diagnoses' on the
	pediatric versions of the forms.</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.5">10.3.5
	Patients with TB diagnosis</A></I></FONT></FONT><I>:</I>
	 The existence of a TB diagnosis for a patient.  This data is
	derived from a<SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">ny
	non-resolved TB diagnosis entered on a patient's intake or follow-up
	form in the sections titled 'Past and Present Diagnoses by WHO
	Stage' or 'Current Diagnoses/Evolution'.  </SPAN></SPAN></SPAN><SPAN LANG="en-US"><I><B><SPAN STYLE="background: transparent">Note:</SPAN></B></I></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">
	 This section is titled 'Past and Present Diagnoses' on the
	pediatric versions of the forms.</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.6">10.3.6
	No treatment</A></I></FONT></FONT><I>:</I>
	 No TB medications or only one medication dispensed for a patient<SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">.
	 This data is derived from any of the medications titled 'Ethambutol',
	'Isoniazide (INH)', 'Pyrazinamide', </SPAN></SPAN></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">'Rifampicine'
	or 'Streptomycin' designated as dispensed on the patient's
	prescription forms in </SPAN></SPAN></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">the
	section titled 'Other medications' under the heading 'TB Drugs'.</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="10.3.7">10.3.7
	Patients having completed TB treatment</A></I></FONT></FONT><I>:</I>
	 Patients who have completed a course of treatment for TB.<SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">
	 This data is derived from the any of the elements titled 'TB
	treatment completed' </SPAN></SPAN></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">selected
	on a patient's intake or follow-up forms in the section titled 'TB
	Status' or 'TB Evaluation'.</SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
</TD></TR>
<TR>
<TD WIDTH="930">
 <TABLE BGCOLOR="#DDDDDD" WIDTH="100%" ALIGN="CENTER">
  <TR>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&"><< 1.0 Table of Contents <<</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_9.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">< 9.0 Quality of Care: Care Reminders <</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="#_top"> ^ Return to Top ^</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_11.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">> 11.0 Quality of Care: Regimens and drug discontinuations ></A></TD>
  </TR>
 </TABLE>
</TD></TR>
</TABLE>
