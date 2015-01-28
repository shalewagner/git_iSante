
package edu.washington.cirg.web.jasper;

import edu.washington.cirg.web.jasper.ReportViewer;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.IOException;
import java.io.OutputStream;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Properties;
import java.util.Set;
import java.util.Vector;

import javax.naming.NamingException;
import javax.servlet.ServletConfig;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;


public class ReportViewerServlet extends HttpServlet {

    private static Log log = LogFactory.getLog(ReportViewerServlet.class);

    private static final String REPORT_DEF_FILE_URL = "/reports.xml";

    public ReportViewerServlet() {
        super();
    }

    public void init(ServletConfig config) throws ServletException {
        super.init(config);
    }

    public void doGet(HttpServletRequest req, HttpServletResponse resp)
	throws ServletException, IOException {
	doPost(req, resp);
    }

    public void doPost(HttpServletRequest req, HttpServletResponse resp)
        throws ServletException, IOException {

	String reportFormat = req.getParameter("format");
	reportFormat = reportFormat.toUpperCase();
	if ("PDF".equals(reportFormat)) {
	    resp.setContentType("application/pdf");
	} else if ("HTML".equals(reportFormat)) {
	    resp.setContentType("text/html");
	} else if ("XLS".equals(reportFormat)) {
	    resp.setContentType("application/x-excel");
	    resp.setHeader("Content-disposition", "attachment; filename=\"cnics.xls\"");
	}

	InputStream reportsXml = getServletContext().getResourceAsStream(REPORT_DEF_FILE_URL);
	if ( reportsXml == null ) {
	    throw new ServletException("Unable to load file: " + REPORT_DEF_FILE_URL);
	}
	
	String jrXmlPath = getServletContext().getRealPath("reports");

	Map imagesMap = new HashMap();
        req.getSession().setAttribute("IMAGES_MAP", imagesMap);
	//req.getSession().setAttribute(ImageServlet.DEFAULT_JASPER_PRINT_SESSION_ATTRIBUTE,
	//			      jasperPrint);
	String imageBaseUrl = "image.jsp?image=";
	//"image.jsp?x=" + System.identityHashCode(jasperPrint) + "&image="

	ReportViewer reportViewer = new ReportViewer(reportsXml, jrXmlPath, imagesMap, imageBaseUrl,
						     "/etc/isante/my.cnf");
	reportViewer.makeReport(req.getParameterMap(),
				(OutputStream)resp.getOutputStream());
    }

}
