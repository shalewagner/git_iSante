<TABLE WIDTH="930">
<TR>
<TD WIDTH="930">
<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=6 STYLE="font-size: 22pt"><B>EMR
Report Definitions</B></FONT></FONT></FONT></P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B><A NAME="20.0">20.0
	Data Quality: Data Management Process</A></B></FONT></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">These
	reports cover all patients regardless of activity and treatment
	status and are meant to give individual results in various
	categories for data entry management.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="20.1">20.1
	Usage</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">To
	use these reports, simply click on the linked report title.  The
	report parameters page does not apply to these reports.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="20.2">20.2
	Results</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">The
	report results will appear in a new browser window (or a new browser
	tab, depending on how your browser is configured).  An example
	results header is shown in <A HREF="#20.2.1">20.2.1 Figure 22</A> </FONT><FONT FACE="Arial, sans-serif"><I>(below)</I></FONT><FONT FACE="Arial, sans-serif">.
	 </FONT>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><A NAME="20.2.1"><IMG SRC="images/report_definitions_html_m2291c657.jpg" NAME="graphics22" ALIGN=BOTTOM WIDTH=725 HEIGHT=80 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>20.2.1
	Figure 22: Results header for the 'Patients with only registration
	form' report</I></FONT></FONT></P>
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
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="20.3">20.3
	Relevant Definitions</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><I>(see
	section <A HREF="helpfile.php?file=report_definitions_6.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#6.3">6.3 Relevant Definitions</A> above for definitions of the
	columns titled 'Clinic Patient ID', 'National ID, 'First Name',
	'Last Name' and 'Last Date')</I></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="20.3.1">20.3.1
	Visit date/data entry lag</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 This report displays the average number of days of delay between
	visit date and data entry date, based upon records entered during
	the period of the report.  This report can be used on a monthly
	basis to track the data entry process: an average delay of less than
	three days is desirable.  This data is derived from the field titled
	'Date of visit' located at the top of all forms.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="20.3.2">20.3.2
	Forms recently entered</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 This report displays forms</SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal"><B>
	</B></SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">which
	have been recently entered into the system.  It prompts the user for
	two additional parameters before displaying the results </SPAN></FONT><FONT FACE="Arial, sans-serif"><I>(see
	<A HREF="#20.3.2.1">20.3.2.1 Figure 23</A> below)</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">.
	 It requests the maximum number of forms that should be displayed
	('100' is displayed as the default) and the user name of the data
	entry clerk, if only forms for that clerk should be displayed in the
	report results (enter '%' for this parameter if all user names
	should be displayed).  The report results display the clinic patient
	ID, the user name of the data entry clerk who entered the form, the
	creation date and the date the form was most recently modified.  It
	will also display the type of form which can be clicked to
	view/correct </SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">the
	original form.</SPAN></FONT></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in; font-style: normal">
	<BR>
	</P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><IMG SRC="images/report_definitions_html_m7d5ff893.jpg" NAME="graphics23" ALIGN=BOTTOM WIDTH=320 HEIGHT=121 BORDER=0>
	 
	<A NAME="20.3.2.1"><IMG SRC="images/report_definitions_html_m706671ac.jpg" NAME="graphics24" ALIGN=BOTTOM WIDTH=320 HEIGHT=120 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>20.3.2.1
	Figure 23: Additional parameter prompts for the 'Forms Recently
	Entered' report</I></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif"><FONT COLOR="#000080"><I><A NAME="20.3.3">20.3.3
	Forms entered last week</A></I></FONT><I>:</I>  This report displays the
	number of forms that have been entered into the system within the
	last seven days.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="20.3.4">20.3.4
	Forms entered last month</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 This report displays the number of forms that have been entered
	into the system within the last thirty days.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="20.3.5">20.3.5
	Patients with only registration form</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 This indicates patients with a registration form entered, but no
	other forms.  In recognition of the fact that there may be a time
	lag between patient visits and data entry, this report examines
	registration forms that were created at least seven days prior to
	the report date.  This report will allow DQMs to identify cases
	where clinical team members may be failing to use the standardized
	medical record forms in providing patient care.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="20.3.6">20.3.6
	Patients with no intake form</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 This report indicates patients with registration forms and at least
	one other type of form, but without clinical intake forms.  This
	report will allow DQMs to identify cases where clinical team members
	may be failing to use the standardized medical record forms in
	providing patient care.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
</TD></TR>
<TR>
<TD WIDTH="930">
 <TABLE BGCOLOR="#DDDDDD" WIDTH="100%" ALIGN="CENTER">
  <TR>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&"><< 1.0 Table of Contents <<</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_19.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">< 19.0 Data Quality: Data Cleaning <</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="#_top"> ^ Return to Top ^</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_21.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">> 21.0 Data Quality: Demographic Information Correction ></A></TD>
  </TR>
 </TABLE>
</TD></TR>
</TABLE>
