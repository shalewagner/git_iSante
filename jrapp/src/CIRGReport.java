/*
 * Copyright 2005 (C) University of Washington. All Rights Reserved.
 * Clinical Informatics Research Group (CIRG)
 * Created on Apr 21, 2005
 * $Id: CIRGReport.java,v 1.1 2005/05/02 23:04:28 ddrozd Exp $
 */
package edu.washington.cirg.web.jasper;

import java.io.File;
import java.util.HashMap;
import java.util.Map;

import net.sf.jasperreports.engine.JRException;
import net.sf.jasperreports.engine.JasperReport;
import net.sf.jasperreports.engine.util.JRLoader;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

/** 
 * @author <a href="mailto:ddrozd@u.washington.edu">Dan Drozd</a>
 * @version $Revision: 1.1 $
 *
 */
public class CIRGReport {

    private static Log log = LogFactory.getLog(CIRGReport.class);

    private String title;
    private String id;
    private String path;
    private JasperReport report;
    private Map<String, Object> parameters;
    private File reportFile;
    
    public CIRGReport(String id, String title, String path) throws JRException {
        this.id = id;
        this.title = title;
        this.path = path;
        parameters = new HashMap<String, Object>();

        reportFile = new File(path);

        report = 
            (JasperReport)JRLoader.loadObject(reportFile.getPath());
        
        parameters.put("Title", title);
        parameters.put("BaseDir", reportFile.getParentFile());
    }
    
    public CIRGReport() {
        super();
    }

    
    
    /**
     * @return Returns the reportFile.
     */
    public File getReportFile() {
        return reportFile;
    }
    /**
     * @param reportFile The reportFile to set.
     */
    public void setReportFile(File reportFile) {
        this.reportFile = reportFile;
    }
    /**
     * @return Returns the mParameters.
     */
    public Map<String, Object> getParameters() {
        return parameters;
    }
    /**
     * @param parameters The parameters to set.
     */
    public void setParameters(Map<String, Object> parameters) {
        this.parameters = parameters;
    }
    /**
     * @return Returns the report.
     */
    public JasperReport getReport() {
        return report;
    }
    /**
     * @param report The report to set.
     */
    public void setReport(JasperReport report) {
        this.report = report;
    }
   /**
    * @return Returns the id.
    */
   public String getId() {
       return id;
   }
   /**
    * @param id The id to set.
    */
   public void setId(String id) {
       this.id = id;
   }
   /**
    * @return Returns the path.
    */
   public String getPath() {
       return path;
   }
   /**
    * @param path The path to set.
    */
   public void setPath(String path) {
       this.path = path;
   }
   /**
    * @return Returns the title.
    */
   public String getTitle() {
       return title;
   }
   /**
    * @param title The title to set.
    */
   public void setTitle(String title) {
       this.title = title;
   }
}
