
package edu.washington.cirg.web.jasper;

import edu.washington.cirg.web.jasper.ReportViewer;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileReader;
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

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;


public class ReportViewerCgi {

    private static Log log = LogFactory.getLog(ReportViewerCgi.class);

    public static void main (String[] args) throws IOException {

	String tempFolder = args[0];
	String userNameSafe = args[1];

	String argumentsFileName = tempFolder + File.separator 
	    + "jasperArguments-" + userNameSafe + ".txt";

	//BufferedReader argumentsFile = 
	//    new BufferedReader(new InputStreamReader(new FileInputStream(argumentsFileName),
	//					     "8859_1"));
	BufferedReader argumentsFile = 
	    new BufferedReader(new InputStreamReader(new FileInputStream(argumentsFileName),
						     "UTF8"));

	HashMap<String, String[]> requestParameters = new HashMap<String, String[]>();

	String line = null;
	while ( (line = argumentsFile.readLine()) != null) {
	    String[] valueArray = new String[1];
	    valueArray[0] = argumentsFile.readLine();
	    requestParameters.put(line, valueArray);
	    //System.out.println(line + "<br>");
	    //System.out.println(valueArray[0] + "<br>");
	}

	InputStream reportsXml;
	try {
	    reportsXml = new FileInputStream("jrxml" + File.separator + "reports.xml");
	} catch (java.io.FileNotFoundException e) {
	    System.out.println("Unable to load reports.xml file from URL.");
	    throw new IllegalArgumentException();
	}
	
	String jrXmlPath = "jrapp" + File.separator + "reports-binary";

	Map imagesMap = new HashMap();
	String imageBaseUrl = "jrImage.php?image=";
	
	ReportViewer reportViewer = new ReportViewer(reportsXml, jrXmlPath, imagesMap, imageBaseUrl,
						     requestParameters.get("configFileLocation")[0]);
	ByteArrayOutputStream outputBuffer = new ByteArrayOutputStream();
	reportViewer.makeReport(requestParameters, outputBuffer);

	//first write all images to the temp folder if their are any
	Iterator imageIterator = imagesMap.entrySet().iterator();
	while (imageIterator.hasNext()) {
	    Map.Entry pairs = (Map.Entry)imageIterator.next();

	    String imageName = (String)pairs.getKey();
	    imageName = imageName.replaceAll("[^A-Za-z0-9]", "");
	    imageName = "jasper" + imageName + "-" + userNameSafe + ".png";

	    byte[] imageData = (byte[])pairs.getValue();

	    FileOutputStream imageFile = 
		new FileOutputStream(tempFolder + File.separator + imageName);
	    imageFile.write(imageData, 0, imageData.length);
	    imageFile.close();
	}

	byte[] outputData = outputBuffer.toByteArray();

	String reportFileName = "jasperReport-" + userNameSafe + ".bin";
	FileOutputStream reportFile = 
	    new FileOutputStream(tempFolder + File.separator + reportFileName);
	reportFile.write(outputData, 0, outputData.length);
	reportFile.close();
    }
}
