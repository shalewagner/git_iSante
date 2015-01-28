<TABLE WIDTH="930">
<TR>
<TD WIDTH="930">
<P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=6 STYLE="font-size: 22pt"><B>EMR
Report Definitions</B></FONT></FONT></FONT></P>
<P CLASS="western" STYLE="margin-bottom: 0in"><BR>
</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B><A NAME="19.0">19.0
	Data Quality: Data Cleaning</A></B></FONT></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">These
	reports cover all patients regardless of activity and treatment
	status and are meant to give individual results in various
	categories where data is invalid on specific patient forms.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="19.1">19.1
	Usage</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">To
	use these reports, simply click on the linked report title.  The
	report parameters page does not apply to these reports.</FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="19.2">19.2
	Results</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><FONT FACE="Arial, sans-serif">The
	report results will appear in a new browser window (or a new browser
	tab, depending on how your browser is configured).  An example
	results header is shown in <A HREF="#19.2.1">19.2.1 Figure 21</A> </FONT><FONT FACE="Arial, sans-serif"><I>(below)</I></FONT><FONT FACE="Arial, sans-serif">.
	 </FONT>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><A NAME="19.2.1"><IMG SRC="images/report_definitions_html_7f464ab3.jpg" NAME="graphics21" ALIGN=BOTTOM WIDTH=800 HEIGHT=87 BORDER=0></A></P>
	<P CLASS="western" ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I>19.2.1
	Figure 21: Results header for the 'Forms With Errors' report</I></FONT></FONT></P>
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
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><B><A NAME="19.3">19.3
	Relevant Definitions</A></B></FONT></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT FACE="Arial, sans-serif"><I>(see
	section <A HREF="helpfile.php?file=report_definitions_6.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>#6.3">6.3 Relevant Definitions</A> above for definitions of the column
	titled 'Clinic Patient ID')</I></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><BR><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="19.3.1">19.3.1
	Possible duplicate registrations</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 Patients for which there might be more than one registration form
	completed.  The results of this report will display all of the
	demographic information on the potentially duplicated registration
	forms so that they can be manually inspected and corrected, if
	necessary.  This data is derived from all of the registration forms
	entered for the specified clinic site.  The following fields from the registration forms are compared and if they all identically match another record, then both of those patients are displayed in the report results:</SPAN></FONT></P>
	<UL>
		<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT FACE="Arial, sans-serif">First name</FONT>
		<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT FACE="Arial, sans-serif">Last name</FONT>
		<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT FACE="Arial, sans-serif">Date of birth</FONT>
		<LI STYLE="list-style: disc outside;margin-left: 25px"><FONT FACE="Arial, sans-serif">Mother's first name</FONT>
	</UL>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
	<P CLASS="western" STYLE="margin-bottom: 0in"><FONT COLOR="#000080"><FONT FACE="Arial, sans-serif"><FONT SIZE=3><I><A NAME="19.3.2">19.3.2
	Forms with errors (consolidated error report)</A></I></FONT></FONT></FONT><FONT FACE="Arial, sans-serif"><I>:</I></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">
	 Forms</SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal"><B>
	</B></SPAN></FONT><FONT FACE="Arial, sans-serif"><SPAN STYLE="font-style: normal">which
	have any items that have not passed the field validation criteria. 
	The report results identify the specific data element which violates
	the validation criteria.  It will also display the type of form
	which can be clicked to view/correct the original form.</SPAN></FONT></P>
	<P CLASS="western" STYLE="margin-bottom: 0in; font-style: normal"><BR>
	</P>
</TD></TR>
<TR>
<TD WIDTH="930">
 <TABLE BGCOLOR="#DDDDDD" WIDTH="100%" ALIGN="CENTER">
  <TR>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_1.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&"><< 1.0 Table of Contents <<</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_18.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">< 18.0 Data Quality: Invalid Data <</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="#_top"> ^ Return to Top ^</A></TD>
   <TD ALIGN="CENTER" WIDTH="25%"><A CLASS="pages" HREF="helpfile.php?file=report_definitions_20.0&extension=php&titleen=EMR%20Report%20Definitions&titlefr=Rapport%20D%e9finitions&lang=<?php echo $lang;?>&">> 20.0 Data Quality: Data Management Process ></A></TD>
  </TR>
 </TABLE>
</TD></TR>
</TABLE>
