
<%@ page pageEncoding="UTF-8" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<%@ taglib prefix="c"   uri="http://java.sun.com/jstl/core" %>
<%@ taglib prefix="x"   uri="http://java.sun.com/jstl/xml" %>

<html>
<body>
<head>
</head>

<c:if test="${empty applicationScope.reportList}">
<x:parse var="reportList" scope="application">
   <c:import url="/reports.xml" charEncoding="UTF-8"/>
</x:parse>
</c:if>

<%-- <h2>Reports</h2> --%>

<x:forEach var="reportset" select="$reportList/reports/*">
	<h3><x:out select="$reportset/title[@lang='fr']"/></h3>
	<x:forEach var="reportSubSet" select="$reportset/*">
		<h4><x:out select="$reportSubSet/title[@lang='fr']"/></h4>
		<ul>
		<x:forEach var="report" select="$reportSubSet/report">
		        <c:set var="id"><x:out select="$report/@id"/></c:set>
			<c:url var="htmlurl" value="reportViewer">
				<c:param name="report" value="${id}"/>
				<c:param name="format" value="html"/>
			</c:url>
			<c:url var="pdfurl" value="reportViewer">
				<c:param name="report" value="${id}"/>
				<c:param name="format" value="pdf"/>
			</c:url>
			<c:url var="csvurl" value="reportViewer">
				<c:param name="report" value="${id}"/>
				<c:param name="format" value="csv"/>
			</c:url>
			<c:url var="xlsurl" value="reportViewer">
				<c:param name="report" value="${id}"/>
				<c:param name="format" value="xls"/>
			</c:url>		
					
			<li>
			<c:if test="${!empty id}">
			<a href='<c:out value="${htmlurl}"/>'>
			</c:if>
			<x:out select="$report/title[@lang='fr']"/>
			<c:if test="${!empty id}">
			</a>
			&nbsp
			<font size="2pt">
			<a href='<c:out value="${pdfurl}"/>'/>pdf</a>
			&nbsp
			<a href='<c:out value="${csvurl}"/>'/>csv</a>
			&nbsp
			<a href='<c:out value="${xlsurl}"/>'/>excel</a>
			</font>
			</c:if>
			</li>
		</x:forEach>
		</ul>
	</x:forEach>
</x:forEach>

</body>
</html>

