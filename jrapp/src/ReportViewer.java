
package edu.washington.cirg.web.jasper;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.IOException;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.lang.ClassLoader;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.Properties;
import java.util.Set;
import java.util.Vector;
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import net.sf.jasperreports.engine.JRException;
import net.sf.jasperreports.engine.JRExporterParameter;
import net.sf.jasperreports.engine.JRParameter;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.JasperReport;
import net.sf.jasperreports.engine.JasperRunManager;
import net.sf.jasperreports.engine.export.JRCsvExporter;
import net.sf.jasperreports.engine.export.JRHtmlExporter;
import net.sf.jasperreports.engine.export.JRHtmlExporterParameter;
import net.sf.jasperreports.engine.export.JRXlsExporter;
import net.sf.jasperreports.engine.export.JRXlsExporterParameter;
import net.sf.jasperreports.j2ee.servlets.ImageServlet;

import org.dom4j.Document;
import org.dom4j.DocumentException;
import org.dom4j.Element;
import org.dom4j.io.SAXReader;

import org.apache.commons.configuration.INIConfiguration;

public class ReportViewer {

    private static final String JNDI_DATA_SOURCE_NAME = "jdbc/itech_reports";
    private static final String PARAM_REPORT_KEY = "report";
    private static final String PARAM_REPORT_FORMAT = "format";
    private static final String PARAM_REPORT_PID = "pid";
    private static final String PARAM_REPORT_LANG = "lang";

    private static final String PARAM_REPORT_SITE = "site";
    private static final String PARAM_REPORT_GLEVEL = "gLevel";
    private static final String PARAM_REPORT_OLEVEL = "oLevel";
    private static final String PARAM_REPORT_USER = "user";
    private static final String PARAM_REPORT_TOTAL = "total";
    private static final String PARAM_REPORT_SITENAME = "siteName";
    
    private static final String PARAM_REPORT_QUERYCHART = "queryChart";
    private static final String PARAM_REPORT_QUERYTABLE = "queryTable";
    
    private static final String PARAM_REPORT_DIRECTORY = "reportDir";



    private Map<String, CIRGReport> mReports;
    private Map<String, Boolean> mFormats;

    private enum Format {HTML, CSV, PDF, XLS};


    public static java.io.BufferedWriter out = null;

    //locate of database configuration file
    private String configFileLocation;

    //store the URL to the root of the calling application
    private String applicationRootUrl = null;

    //store images generated during html output
    private Map imagesMap;
    //base URL where html images can be retrieved
    private String imageBaseUrl;


    public ReportViewer(InputStream reportsXml, String jrXmlPath,
			Map imagesMap, String imageBaseUrl, String configFileLocation) {
	this.imagesMap = imagesMap;
	this.imageBaseUrl = imageBaseUrl;
	this.configFileLocation = configFileLocation;

	//load reports.xml and all the .jasper files
	try {
	    mReports = loadReportDefs(reportsXml, jrXmlPath + File.separator + "mysql");
	} catch (Exception e) {
	    System.out.println("Error loading reports.xml or .jasper files.");
	    e.printStackTrace(System.out);
	}

        mFormats = new HashMap<String, Boolean>();
        mFormats.put("html", true);
        mFormats.put("pdf", true);
        mFormats.put("csv", true);
        mFormats.put("xls", true);
    }


    private Map<String, CIRGReport> loadReportDefs(InputStream reportsXml, String jrXmlPath)
        throws DocumentException, JRException {

        Map<String, CIRGReport> mReports =
            new HashMap<String, CIRGReport>();

        SAXReader reader = new SAXReader();
        Document doc = reader.read(reportsXml);

        List reports = doc.selectNodes("//report");
        for ( Iterator iterator = reports.iterator(); iterator.hasNext(); ) {
	    Element element = (Element) iterator.next();
            String sId = element.valueOf("@id");
            String title = element.valueOf("title[@lang='fr']");
            String query = element.valueOf("query");
            List reportFiles = element.elements("reportFile");
            for ( Iterator temp = reportFiles.iterator(); temp.hasNext(); ) {
		Element tempElement = (Element)temp.next();
                String groupLevel = tempElement.attributeValue("groupLevel");
                String otherLevel = tempElement.attributeValue("otherLevel");

                String reportFile = jrXmlPath + File.separator + tempElement.getText();

                if ((new File(reportFile)).canRead() && (tempElement.getText() != "")) {
                    String key = ReportViewer.getKey(sId, groupLevel, otherLevel);
                    CIRGReport report = new CIRGReport(key, title, reportFile);
                    HashMap<String, Object> reportParameters =
                        new HashMap<String, Object>(report.getParameters());
                    reportParameters.put("query", query);
                    reportParameters.put("title",title);
                    report.setParameters(reportParameters);
                    mReports.put(key, report);
                }
	    }
        }
        return mReports;
    }

    private String getRequestParameter(Map allParameters, String key) {
	String[] values = (String[])allParameters.get(key);
	if (values == null) {
	    return null;
	} else {
	    return values[0];
	}
    }

    public void makeReport(Map allParameters, OutputStream outputStream)
        throws IOException {

	applicationRootUrl = getRequestParameter(allParameters, "applicationRootUrl");
	String reportId = getRequestParameter(allParameters, PARAM_REPORT_KEY);
        String reportFormat = getRequestParameter(allParameters, PARAM_REPORT_FORMAT);
	String gLevelStr = getRequestParameter(allParameters, PARAM_REPORT_GLEVEL);
	int gLevel= convertStr(gLevelStr);
	String oLevelStr = getRequestParameter(allParameters, PARAM_REPORT_OLEVEL);
	int oLevel = convertStr(oLevelStr);
	String key = getKey(reportId, gLevelStr, oLevelStr);

        if ( ! isValidRequest(allParameters) ) {
            //log.error("Bad request");
	    Set<String> allReportKeys = mReports.keySet();
	    //resp.getWriter().println("All keys");
	    for (String k : allReportKeys) {
		//resp.getWriter().println(k);
	    }
	    throw new IOException("isValidRequest() returned false.");
        }
	
	reportFormat = reportFormat.toUpperCase();
	
	String lang = getRequestParameter(allParameters, PARAM_REPORT_LANG);
	String site = getRequestParameter(allParameters, PARAM_REPORT_SITE);
	String user = getRequestParameter(allParameters, PARAM_REPORT_USER);
	String total = getRequestParameter(allParameters, PARAM_REPORT_TOTAL);
	String siteName = getRequestParameter(allParameters, PARAM_REPORT_SITENAME);
	String pid = getRequestParameter(allParameters, PARAM_REPORT_PID);
	
	CIRGReport report = mReports.get(key);
	//writeLog(report.getReportFile().getAbsolutePath());
	Map paraMap = report.getParameters();
        Format f = Format.valueOf(reportFormat);


	//get parameters from config file
	INIConfiguration iniFile = null;
	try {
	    iniFile = new INIConfiguration(this.configFileLocation);
	} catch (Exception e) {
	    e.printStackTrace();
	    throw new IOException("iniFile didn't load");
	}

	String jdbcDriverClassName = "com.mysql.jdbc.Driver";
	String dbHost = "jdbc:mysql://" + iniFile.getString("client.host").trim() + ":3306";
	String dbName = iniFile.getString("client.database").trim();
	String dbUser = iniFile.getString("client.user").trim();
	String dbPassword = iniFile.getString("client.password").trim();


        try {
	    //get connection to database
	    Connection conn = null;
	    try {
		Class.forName(jdbcDriverClassName).newInstance();
	    } catch (InstantiationException e) {
		//log.error(e);
		throw new SQLException("InstantiationException: Unable to instantiate driver class");
	    } catch (IllegalAccessException e) {
		//log.error(e);
		throw new SQLException("IllegalAccessException: Unable to access driver class");
	    } catch (ClassNotFoundException e) {
		//log.error(e);
		throw new SQLException("ClassNotFoundException: Unable to locate driver class");
	    }

	    conn = DriverManager.getConnection(dbHost + "/" + dbName, dbUser, dbPassword);

            if ( conn == null ) {
                //log.error("Connection is null");
                throw new IOException("Unable to obtain a database connection");
            }




            JasperReport jreport = report.getReport();

            Map<String, Object> parameters = new HashMap<String, Object>(report.getParameters());

	    File reportPath = (File)paraMap.get("BaseDir");

	    if (null != reportPath) {
		parameters.put(PARAM_REPORT_DIRECTORY, reportPath.getAbsolutePath()+File.separator);
	    }
	    parameters.put(PARAM_REPORT_TOTAL,total);
	    parameters.put(PARAM_REPORT_SITENAME,siteName);
	    parameters.put(PARAM_REPORT_PID,pid);
	    parameters.put(PARAM_REPORT_LANG,lang);
            Locale locale = null;
            if ("en".equalsIgnoreCase(lang)) {
              locale = new Locale("en", "US");
            } else {
              locale = new Locale("fr", "FR");
            }
            parameters.put(JRParameter.REPORT_LOCALE, locale);
	    
	    //Pass all parameters from the request to the report renderer.
	    for (Object paramKeyObject : allParameters.keySet()) {
		String paramKey = (String)paramKeyObject;
		if (!parameters.containsKey(paramKey)) {
		    String paramValue = getRequestParameter(allParameters, paramKey);
		    if (paramValue != null) {
			parameters.put(paramKey, paramValue);
		    }
		}
	    }
	    
	    parameters.put("queryChart", getRequestParameter(allParameters, "queryChart"));
	    parameters.put("queryTable", getRequestParameter(allParameters, "queryTable"));

            switch ( f ) {
            case PDF:
                doPDF(report.getReportFile().getPath(), parameters,
		      conn, outputStream);
                break;
            case HTML:
                doHTML(jreport, parameters, conn, outputStream);
                break;
            case CSV:
                doCSV(jreport, parameters, conn, outputStream);
                break;
            case XLS:
                doExcel(jreport, parameters, conn, outputStream);
                break;
            default:
                //log.error("Unknown format [ " + f + " ]");
		break;
            }


	    if (conn != null) {
		conn.close();
	    }

        } catch ( SQLException e ) {
	    System.out.println(e);
            //log.error(e, e);
            throw new IOException();
        } catch ( JRException e ) {
	    e.printStackTrace();
            //log.error(e, e);
            throw new IOException();
        }

    }

    private void doPDF(String reportPath, Map parameters,
		       Connection conn, OutputStream outputStream)
	throws IOException, JRException {

        byte[] bytes = JasperRunManager.runReportToPdf(reportPath, parameters, conn);
        outputStream.write(bytes, 0, bytes.length);
    }

    private void doHTML(JasperReport report, Map parameters,
			Connection conn, OutputStream outputStream)
	throws IOException, JRException {

        JasperPrint jasperPrint =
            JasperFillManager.fillReport(report, parameters, conn);

        JRHtmlExporter exporter = new JRHtmlExporter();

        exporter.setParameter(JRExporterParameter.JASPER_PRINT, jasperPrint);
        exporter.setParameter(JRExporterParameter.OUTPUT_STREAM, outputStream);
        exporter.setParameter(JRHtmlExporterParameter.IMAGES_MAP, imagesMap);
        exporter.setParameter(JRHtmlExporterParameter.IMAGES_URI, imageBaseUrl);

        exporter.exportReport();
    }

    private void doCSV(JasperReport report, Map parameters,
		       Connection conn, OutputStream outputStream) 
	throws IOException, JRException {

        JasperPrint jasperPrint =
            JasperFillManager.fillReport(report, parameters, conn);

        JRCsvExporter exporter = new JRCsvExporter();
        exporter.setParameter(JRExporterParameter.JASPER_PRINT, jasperPrint);
        exporter.setParameter(JRExporterParameter.OUTPUT_STREAM, outputStream);

        exporter.exportReport();
    }

    private void doExcel(JasperReport report, Map parameters,
			 Connection conn, OutputStream outputStream)
	throws IOException, JRException {

        JRXlsExporter exporter = new JRXlsExporter();

        JasperPrint jasperPrint =
            JasperFillManager.fillReport(report, parameters, conn);

        exporter.setParameter(JRExporterParameter.JASPER_PRINT, jasperPrint);
        exporter.setParameter(JRExporterParameter.OUTPUT_STREAM, outputStream);
        exporter.setParameter(JRXlsExporterParameter.IS_ONE_PAGE_PER_SHEET, Boolean.FALSE);
        exporter.setParameter(JRXlsExporterParameter.IS_REMOVE_EMPTY_SPACE_BETWEEN_ROWS, Boolean.TRUE);
        exporter.setParameter(JRXlsExporterParameter.IS_AUTO_DETECT_CELL_TYPE, Boolean.TRUE);
        exporter.setParameter(JRXlsExporterParameter.IS_WHITE_PAGE_BACKGROUND, Boolean.FALSE);

        exporter.exportReport();
    }

    private boolean isValidRequest(Map allParameters) {
        String reportId = getRequestParameter(allParameters, PARAM_REPORT_KEY);
        String reportFormat = getRequestParameter(allParameters, PARAM_REPORT_FORMAT);
	String gLevel= getRequestParameter(allParameters, PARAM_REPORT_GLEVEL);
	String oLevel = getRequestParameter(allParameters, PARAM_REPORT_OLEVEL);
	String key = getKey(reportId, gLevel, oLevel);

        if ( reportId == null ) {
	    System.out.println("reportId is null");
            return false;
        } else if ( reportId.equals("")) {
	    System.out.println("reportId is empty string");
            return false;
        } else if ( mReports.get(key) == null ) {
	    System.out.println("Can't find report: " + key);
            return false;
        }

        if ( reportFormat == null ) {
	    System.out.println("Report format is null");
            return false;
        } else if ( reportFormat.equals("")) {
	    System.out.println("Report format is empty string");
            return false;
        } else if ( mFormats.get(reportFormat) == null  ||
		    mFormats.get(reportFormat) == false ) {
	    System.out.println("Report doesn't support format");
            return false;
        }

       return true;
    }

    public static String getKey(String id, String groupLevel,String otherLevel){
	String key = id+"[";
	key += groupLevel==null?"":groupLevel;
	key += "][";
	key += otherLevel==null?"":otherLevel;
	key += "]";
	return key;
    }

    private static int convertStr(String str) {
	int result =  -1;
	try {
	    result = Integer.valueOf(str).intValue();
	}
	catch(NumberFormatException nfe) {
	}
	return result;
    }
}
