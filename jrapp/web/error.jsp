<%@ page isErrorPage="true" %>
<%@ page import="java.io.*" %>

<html>
<head>
<title>
CNICS Error Page
</title>
</head>

<body>
<span class="bnew">The application encountered the following error:</span>
<pre>
<% exception.printStackTrace(new PrintWriter(out)); %>
</pre>
</body>
</html>