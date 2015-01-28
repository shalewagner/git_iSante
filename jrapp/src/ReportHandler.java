/*
 * Copyright 2005 (C) University of Washington. All Rights Reserved.
 * Clinical Informatics Research Group (CIRG)
 * Created on Apr 14, 2005
 * $Id: ReportHandler.java,v 1.1 2005/05/02 23:04:28 ddrozd Exp $
 */

package edu.washington.cirg.web.jasper;

import java.util.HashMap;
import java.util.Map;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.dom4j.DocumentException;

/** 
 * @author <a href="mailto:ddrozd@u.washington.edu">Dan Drozd</a>
 * @version $Revision: 1.1 $
 *
 */
public class ReportHandler {

    private static Log log = LogFactory.getLog(ReportHandler.class);
    private static final String REPORT_DEF_FILE = "reports.xml";
    
    private enum Format { html, csv, pdf };
    
    private int id;
    private CIRGReport report;
   
    private String format;
    
    private static Map<Integer, CIRGReport> mReports;
    
    static {
        
        try {
            mReports = loadReportDefs();
        } catch ( DocumentException e ) {
            log.error(e, e);
        }
        
    }
    
    
    private static Map<Integer, CIRGReport> loadReportDefs() throws DocumentException {

        Map<Integer, CIRGReport> mReports = new HashMap<Integer, CIRGReport>();
       /*
        mReports.put(1, new CIRGReport(1, "My first report", "reports/blart1.jasper"));
        mReports.put(1, new CIRGReport(2, "My first report", "reports/blart2.jasper"));
        mReports.put(1, new CIRGReport(3, "My first report", "reports/blart3.jasper"));
        mReports.put(1, new CIRGReport(4, "My first report", "reports/blart4.jasper"));
        mReports.put(1, new CIRGReport(5, "My first report", "reports/blart5.jasper"));
        mReports.put(1, new CIRGReport(6, "My first report", "reports/blart6.jasper"));
        mReports.put(1, new CIRGReport(7, "My first report", "reports/blart7.jasper"));
        
       
        
        ClassLoader loader = Thread.currentThread().getContextClassLoader();
        
        InputStream in = loader.getResourceAsStream(REPORT_DEF_FILE);
        if ( in == null ) {
            throw new IllegalArgumentException("Unable to load file " + REPORT_DEF_FILE + " it can't be located on classpath");
        }
        
        SAXReader reader = new SAXReader();
        Document doc;
        try {
            doc = reader.read(in);
        } catch ( DocumentException de ) {
            log.error(de);
            throw de;
        }
        List reports = doc.selectNodes("//report");
        
        for ( Iterator iterator = reports.iterator(); iterator.hasNext(); ) {
            Element element = (Element) iterator.next();
            String sId = element.valueOf("@id");
            String title = element.valueOf("title");
            String path = element.valueOf("path");
            int id = Integer.parseInt(sId);
            Report report = new Report(id, title, path);
            mReports.put(id, report);
        }
  */      
        return mReports;
    }

  /*  
    private void writeToPDF() {
        File reportFile = new File(realReportPath);

        Map<String, Object> parameters = new HashMap<String, Object>();
        parameters.put("ReportTitle", report.getTitle());
        parameters.put("BaseDir", reportFile.getParentFile());
        
        byte[] bytes = 
            JasperRunManager.runReportToPdf(reportFile.getPath(), parameters, conn);
        
        resp.setContentType("application/pdf");
        resp.setContentLength(bytes.length);
        
        ServletOutputStream sos = resp.getOutputStream();
        sos.write(bytes, 0, bytes.length);
        sos.flush();
        sos.close();
    }
    
    private void writeHTML() {
        
        File reportFile = new File(realReportPath);
        
        JasperReport jasperReport = 
            (JasperReport)JRLoader.loadObject(reportFile.getPath());
        
        Map<String, Object> parameters = new HashMap<String, Object>();
        parameters.put("ReportTitle", report.getTitle());
        parameters.put("BaseDir", reportFile.getParentFile());
        
        JasperPrint jasperPrint =
            JasperFillManager.fillReport(jasperReport, parameters, conn);
        
        JRHtmlExporter exporter = new JRHtmlExporter();
        
        StringBuilder sb = new StringBuilder();
        
        Map imagesMap = new HashMap();
        session.setAttribute("IMAGES_MAP", imagesMap);
        
        exporter.setParameter(JRExporterParameter.JASPER_PRINT, jasperPrint);
        exporter.setParameter(JRExporterParameter.OUTPUT_WRITER, out);
        exporter.setParameter(JRHtmlExporterParameter.IMAGES_MAP, imagesMap);
        exporter.setParameter(JRHtmlExporterParameter.IMAGES_URI, "image.jsp?image=");
        
        exporter.exportReport();
    }
*/  
    
    
    
    
    /**
     * @return Returns the report.
     */
    public CIRGReport getReport() {
        if ( report == null ) {
            report = mReports.get(id);
        }
        return report;
    }
    /**
     * @param report The report to set.
     */
    public void setReport(CIRGReport report) {
        this.report = report;
    }
    /**
     * @return Returns the id.
     */
    public int getId() {
        return id;
    }
    /**
     * @param id The report to set.
     */
    public void setId(int id) {
        this.id = id;
        this.report = mReports.get(id);
    }
    
    
    public String getTitle() {
        return report.getTitle();
    }
    
    /**
     * 
     */
    public ReportHandler() {
        super();
    }
 

    public String getFormat() {
        return format.toString();
    }

    public void setFormat(String format) {
        Format.valueOf(format);
        this.format = format;
    }
}
