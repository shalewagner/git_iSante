<TABLE WIDTH="930">
<TR>
<TD WIDTH="930">
<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=6 STYLE="font-size: 22pt"><B>EMR
Report Definitions</B></FONT></FONT></FONT></P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B><A NAME="8.0">8.0
	Quality of Care: Lab Test Reminders</A></B></FONT></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">There
	are three reports in this category that will provide a list of
	patients at the currently selected clinic site that either have had
	a particular test completed, have not had a particular test
	completed, or are due to be tested within the next 30 days.  These
	reports may be used to discover whether or not patients have had a specfic test done or to plan follow-up care steps for specific patients
	(prospective care report use).  For example, the 'Test done' report
	could be used to quickly determine which of the patients at the
	reporting clinic site have had a specific laboratory test
	completed.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="8.1">8.1
	Usage</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">To
	use these reports, simply select one or more patient status groups
	from the 'Patient Status' section of the report parameters page,
	select a date range, select a test from the 'Test Type' section and
	select any other criteria on that page to be used in generating the
	report results that are desired </FONT><FONT FACE="Arial, sans-serif"><I>(see
	section <A HREF="helpfile.php?file=report_definitions_5.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#5.0">5.0 Report Parameters Page</A> above for definitions of the
	sections on the report parameters page)</I></FONT><FONT FACE="Arial, sans-serif">.
	 Then, click the 'Submit' button.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><B>Note:</B></FONT><FONT FACE="Arial, sans-serif">
	The 'Test needed in 30 days' report restricts the list of selectable
	tests to CD4, liver function and CBC tests.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="8.2">8.2
	Results</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">The
	report results will appear in a new browser window (or a new browser
	tab, depending on how your browser is configured).  An example
	results header is shown in <A HREF="#8.2.1">8.2.1 Figure 4</A> </FONT><FONT FACE="Arial, sans-serif"><I>(below)</I></FONT><FONT FACE="Arial, sans-serif">.
	 </FONT>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><A NAME="8.2.1"><IMG SRC="images/report_definitions_html_m2f93c839.jpg" NAME="graphics4" ALIGN=BOTTOM WIDTH=800 HEIGHT=138 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>8.2.1
	Figure 4: Results header for the 'Test done' report</I></FONT></FONT></P>
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
	<P CLASS="western" ALIGN=LEFT STYLE="margin-bottom: 0in"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="8.3">8.3
	Relevant Definitions</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><I>(see
	section <A HREF="helpfile.php?file=report_definitions_6.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#6.3">6.3 Relevant Definitions</A> above for definitions of the
	columns titled 'Clinic Patient ID', 'National ID', 'First Name',
	'Last Name', 'Gender', 'Age', 'Status' and 'Last Date')</I></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="8.3.1">8.3.1
	Never had test</A></I></FONT></FONT><I>:</I>
	 A patient who has never had the indicated test completed.  This
	data is derived from any completed lab test
	results on the patient's laboratory forms in the column titled
	'Result'.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="8.3.2">8.3.2
	Test done</A></I></FONT></FONT><I>:</I>
	 A patient who has had the indicated test completed.  This data is
	derived from any completed lab test results on the patient's
	laboratory forms in the column titled 'Result'.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><FONT SIZE=3><I><A NAME="8.3.3">8.3.3
	Test needed in 30 days</A></I></FONT></FONT><I>:</I>
	 A patient who will require an additional test result within the
	next 30 days.  This data is derived from the lab test result dates
	for the indicated lab test on the patient's laboratory forms in the
	column titled 'Date of result'.  For all patients, 'test needed'
	is defined as not having a test result within the last 8 months.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
	</P>
</TD></TR>
<TR>
<TD WIDTH="930">
  <TABLE BGCOLOR="#DDDDDD" WIDTH="100%" ALIGN="CENTER">
  <TR>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&"><< 1.0 Table of Contents <<</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_7.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">< 7.0 Quality of Care: Appointment Reminders <</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="#_top"> ^ Return to Top ^</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_9.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">> 9.0 Quality of Care: Care Reminders ></A></TD>
  </TR>
 </TABLE>
</TD></TR>
</TABLE>
