package edu.washington.cirg.isante.services.patient.actors;

import java.text.ParseException;
import java.util.List;
import java.util.Map;

import javax.servlet.ServletContext;

import org.apache.commons.logging.Log;

import edu.washington.cirg.isante.services.patient.beans.PatientProfile;


public interface IPatientProfileRetriever {

	public static final String FIRST_NAME_KEY = "firstName";
	public static final String LAST_NAME_KEY = "lastName";
	public static final String ST_NUMBER_KEY = "stNumber";
	public static final String NATIONALID_KEY = "nationalId";
	public static final String SITE_CODE_KEY = "siteCode";
	

	/**
	 * @param searchTerms -- Map of search terms.  The keys will be one of above public
	 * 						 static keys.  The keys may not all be in the map or they may
	 * 						 have null or empty values
	 * @param requesterName -- The name used to authenticate for use of the service
	 * @param requesterPassword -- The password being used to authenticate for the use of
	 * 							   the service
	 * @return The list of found profiles. May be empty but should not be null;
	 * @throws ParseException 
	 */
	public List<PatientProfile> searchForProfiles(ServletContext context, Map<String, String> searchTerms,
			 									  String dbType, String dataSource, Log log,
			 									  Boolean debugFlag) throws ParseException;
}
