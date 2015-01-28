<TABLE WIDTH="930">
<TR>
<TD WIDTH="930">
<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=6 STYLE="font-size: 22pt"><B>EMR
Report Definitions</B></FONT></FONT></FONT></P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B><A NAME="18.0">18.0
	Data Quality: Invalid Data</A></B></FONT></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">These
	reports cover all patients regardless of activity and treatment
	status and are meant to give individual results in various
	categories where data is invalid on specific patient forms.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="18.1">18.1
	Usage</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">To
	use these reports, simply click on the linked report title.  The
	report parameters page does not apply to these reports.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="18.2">18.2
	Results</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">The
	report results will appear in a new browser window (or a new browser
	tab, depending on how your browser is configured).  An example
	results header is shown in <A HREF="#18.2.1">18.2.1 Figure 20</A> </FONT><FONT FACE="Arial, sans-serif"><I>(below)</I></FONT><FONT FACE="Arial, sans-serif">.
	 </FONT>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><A NAME="#18.2.1"><IMG SRC="images/report_definitions_html_m62cfe464.jpg" NAME="graphics20" ALIGN=BOTTOM WIDTH=731 HEIGHT=79 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>18.2.1
	Figure 20: Results header for the 'Visit Date Later Than Entry Date'
	report</I></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">There
	are two action buttons at the top of the report results.  The
	'Close' button will close the report results window (or tab).  The
	'excel' button will generate an alternate version of the same report
	results in CSV format.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">Below
	the two action buttons is the results header.  Each of the columns
	can be sorted in ascending or descending order by clicking on the
	down arrow (left side) or up arrow (right side) next to the column
	title.</FONT></P>
	<P CLASS="western" ALIGN=LEFT STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="18.3">18.3
	Relevant Definitions</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><I>(see
	section <A HREF="helpfile.php?file=report_definitions_6.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#6.3">6.3 Relevant Definitions</A> above for definitions of the
	columns titled 'Clinic Patient ID', 'National ID' and 'Last Date')</I></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="18.3.1">18.3.1
	Visit date later than entry date</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 Forms for which the visit date specified is later than the date
	when the form was entered.  This type of error will cause bad data
	to appear in reports that use visit date to time events.  The
	results of this report will display the visit date that was entered
	on the form and the date that the form was entered into the system. 
	It will also display the type of form which can be clicked to
	view/correct the original form.  This data is derived from the field
	titled 'Date of visit' located at the top of all forms.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="18.3.2">18.3.2
	Bad visit date</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 Forms for which the visit date is invalid.  This type of error will
	cause bad data to appear in reports that use visit date to time
	events.  The results of this report will display the bad visit date
	that was entered on the form.  It will also display the type of form
	which can be clicked to view/correct the original form.  This data
	is derived from the field titled 'Date of visit' located at the top
	of all forms.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="18.3.3">18.3.3
	Patients with activity after being discontinued</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 Forms that have been entered for a patient who has previously been
	discontinued from the HIV/AIDS treatment program.  The results of this report will display
	discontinuation date for the patient and the visit date that was
	entered on the form.  It will also display the type of form which
	can be clicked to view/correct the original form.  This data is
	derived from the </SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN LANG="en-US"><SPAN STYLE="font-style: normal"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">following
	locations within the EMR:</SPAN></SPAN></SPAN></SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px">
			<FONT FACE="Arial, sans-serif"><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">A
			valid date entered on a patient's discontinuation form in the
			field titled 'Disenrollment date of the HIV/AIDS treatment
			program'</SPAN></SPAN></SPAN><SPAN LANG="en-US"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">.</SPAN></SPAN></SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT FACE="Arial, sans-serif"><SPAN LANG="en-US"><SPAN STYLE="font-style: normal"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">A
			valid date entered on a patient's discontinuation form in the
			field titled 'Date of last contact with the patient'</SPAN></SPAN></SPAN></SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN LANG="en-US"><SPAN STYLE="font-style: normal"><SPAN STYLE="font-weight: medium"><SPAN STYLE="background: transparent">.</SPAN></SPAN></SPAN></SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px">
			<FONT FACE="Arial, sans-serif"><SPAN STYLE="background: transparent">The
			option titled 'Death' selected in the section titled 'Reason for
			program disenrollment' and a valid date entered on a patient's
			discontinuation form in the field titled 'Date' next to the
			'Presumed cause of death' options.</SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal; font-weight: medium">
	<BR>
	</P>
	<UL>
		<UL>
			<LI STYLE="list-style: disc outside;margin-left: 25px">
			<FONT FACE="Arial, sans-serif"><SPAN STYLE="background: transparent">A
			valid date entered on a patient's discontinuation form in the
			field titled 'Date of visit' if no other date is specified on the
			same form.</SPAN></FONT>
		</UL>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
</TD></TR>
<TR>
<TD WIDTH="930">
 <TABLE BGCOLOR="#DDDDDD" WIDTH="100%" ALIGN="CENTER">
  <TR>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&"><< 1.0 Table of Contents <<</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_17.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">< 17.0 Data Quality: Missing Data <</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="#_top"> ^ Return to Top ^</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_19.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">> 19.0 Data Quality: Data Cleaning ></A></TD>
  </TR>
 </TABLE>
</TD></TR>
</TABLE>
