<TABLE WIDTH="930">
<TR>
<TD WIDTH="930">
<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=6 STYLE="font-size: 22pt"><B>EMR
Report Definitions</B></FONT></FONT></FONT></P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B><A NAME="5.0">5.0
	Report Parameters Page</A></B></FONT></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif">Several
	of the reports can be filtered or be augmented with charts based on
	parameters such as patient activity status, demographic grouping,
	treatment status, organizational level, etc.  The report parameters
	page </FONT><FONT FACE="Arial, sans-serif"><I>(see <A HREF="#5.0.1">5.0.1 Figure 1</A>
	below)</I></FONT><FONT FACE="Arial, sans-serif"> is used to set the
	filters and enter the details for how the report should be
	formatted.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" ALIGN=LEFT STYLE="margin-bottom: 0in"><A NAME="5.0.1"><IMG SRC="images/report_definitions_html_m2f9392de.jpg" NAME="graphics1" ALIGN=BOTTOM WIDTH=800 HEIGHT=374 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>5.0.1
	Figure 1: The report parameters page for the 'Test Done' report</I></FONT></FONT></P>
	<P CLASS="western" ALIGN=LEFT STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" ALIGN=LEFT STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif">For
	some reports, sections of the parameters page may be disabled
	(greyed out) because they are not relevant to that particular
	report.  In most cases, the parameter values will be automatically
	preset to the preferred settings for the report.  To run the report,
	simply click on the 'Submit' button at the bottom of the page.  </FONT>
	</P>
	<P CLASS="western" ALIGN=LEFT STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="5.1">5.1
	Relevant Definitions</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.1">5.1.1
	Start/end dates</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 The time frame to use when computing report results.  Each date
	must be given in the form MM/YY (two-digit month/two-digit year). 
	The actual dates used in computing the report will </SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal"><SPAN STYLE="font-weight: medium">be
	the last day of the month given in these date fields.  For example,
	if the 'Start Date' is given as '02/04' and the 'End Date' is given
	as '08/06', the time frame that will be used is 02/29/2004 through
	08/31/2006.</SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.2">5.1.2
	Patient status</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 The types of patients to be included in computing the report
	results <FONT COLOR="#000000"><FONT FACE="Arial, sans-serif"><I><SPAN STYLE="font-weight: medium">(see section <A HREF="helpfile.php?file=report_definitions_4.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>">4.0
	Classification of Patients by Activity Status</A> (above)
	for definitions of the individual patient activity statuses)</SPAN></I></FONT></FONT>.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.3">5.1.3
	Organizational level</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 The group of patients for which the report should be run.  If
	'Patients' is selected, the report will display individual result
	rows for each patient at the clinic site displayed that matches the
	report criteria.  If 'Clinic', 'Commune', 'Department' or 'Network'
	is selected, a count of patients that match the report criteria will
	be displayed along with a graph of the results, both broken up into
	the appropriate aggregate groups.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.4">5.1.4
	Treatment status</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif">
	 The treatment groups of patients to be included in computing the
	report results.  If an option other than 'Any' is chosen, only
	patients that belong to the specified treatment group will be
	included when calculating the report results.  The individual
	options are defined as follows:</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.4.1">5.1.4.1
			Enrolled on ART</A></I></FONT></FONT><FONT FACE="Arial, sans-serif">: 
			Patients that </FONT><FONT FACE="Arial, sans-serif">have been
			dispensed a prescribed ARV regimen excluding those who have been dispensed ARV
			drug(s) for purposes of preventing mother-to-child transmission
			(PMTCT) or post-exposure prophylaxis (PEP) during the specified time frame.</FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.4.2">5.1.4.2
			Enrolled in palliative care</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif">
			 Patients who have never been dispensed a prescribed ARV regimen
			or have never been dispensed ARV drug(s) for purposes of PMTCT or
			PEP during the specified time frame.</FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.4.3">5.1.4.3
			INH prophylaxis</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><B>
			</B></FONT><FONT FACE="Arial, sans-serif">Patients </FONT><FONT FACE="Arial, sans-serif">who
			have been dispensed a prescribed dose of Isoniazid without an
			accompanying prescription for any other anti-TB drugs (Ethambutol,</FONT><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt">
			</FONT></FONT><FONT FACE="Arial, sans-serif">Pyrazinamide,
			Rifampicin, Streptomycin) during the specified time frame.</FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.4.4">5.1.4.4
			Cotrimoxazole prophylaxis</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
			Patients who have been dispensed a prescribed dose of
			Cotrimoxazole during the specified time frame.</SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.4.5">5.1.4.5
			TB treatment</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
			Patients who have been dispensed a prescribed dose of at least
			three of the following medications simultaneously:  Ethambutol, Isoniazid,
			Pyrazinamide, Rifampicin, Streptomycin during the specified time frame.</SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.5">5.1.5
	Demographic grouping</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 In addition to the report results, the type of demographic grouping
	to be used in the accompanying chart.  If 'None' is selected, no
	chart will be generated.  If 'Gender' is selected, the pie chart
	included at the top of the report results will be grouped based on
	the genders of the patients that matched the report criteria.  If
	'Age' is </SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">selected,
	the pie chart included at the top of the report results will be
	grouped based on the ages of the patients that matched the report
	criteria.  If 'Pregnancy' is selected, the pie chart included at the
	top of the report results will be grouped based on the pregnancy
	status of the female patients who are older than 14 that matched the
	report criteria.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><I><A NAME="5.1.6">5.1.6
	Test type</A></I></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 The type of laboratory test that should be included in the report
	results.  The report results will be restricted to show only the
	type of laboratory test that is selected.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
</TD></TR>
<TR>
<TD WIDTH="930">
 <TABLE BGCOLOR="#DDDDDD" WIDTH="100%" ALIGN="CENTER">
  <TR>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&"><< 1.0 Table of Contents <<</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_4.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">< 4.0 Classification of Patients by Activity Status <</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="#_top"> ^ Return to Top ^</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_6.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">> 6.0 Active and Inactive Patients report ></A></TD>
  </TR>
 </TABLE>
</TD></TR>
</TABLE>
