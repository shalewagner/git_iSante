package edu.washington.cirg.isante.services.patient;

import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.text.ParseException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.ws.rs.Encoded;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.WebApplicationException;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.Response.Status;

import edu.washington.cirg.isante.services.patient.actors.CirgPatientProfileRetriever;
import edu.washington.cirg.isante.services.patient.actors.MshPatientProfileRetriever;
import edu.washington.cirg.isante.services.patient.actors.PatientProfileRetriever;
import edu.washington.cirg.isante.services.patient.actors.PermissionVerifier;
import edu.washington.cirg.isante.services.patient.actors.IPatientProfileRetriever;
import edu.washington.cirg.isante.services.patient.actors.IPermisionVerifier;
import edu.washington.cirg.isante.services.patient.beans.PatientProfile;
import edu.washington.cirg.isante.services.patient.beans.PatientProfiles;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

@Produces("application/xml")
@Path("patients")
public class PatientSearch {

	@Context ServletContext context;
	@GET
	@Produces("application/xml")
	public PatientProfiles getPatients(@QueryParam("first") @Encoded String firstName,
									   @QueryParam("last") @Encoded String lastName,
									   @QueryParam("ST") String STNumber,
									   @QueryParam("nationalId") String nationalId,
									   @QueryParam("name") String requesterName,
									   @QueryParam("pwd") String requesterPassword,
									   @QueryParam("site") String siteCode,
									   @QueryParam("debug") Boolean debugFlag) {

		Log log = LogFactory.getLog(PatientSearch.class);
		if (debugFlag == null) debugFlag = Boolean.FALSE;
		PatientProfiles patients = null;
		
		final String DB_TYPE = context.getInitParameter("dbType").trim();
		final String DB_ENCODING = context.getInitParameter("dbEncoding").trim();
		final String JNDI_DATA_SOURCE = "jdbc/PatientSearchService" + DB_TYPE;

		try {
			if (firstName != null) firstName = URLDecoder.decode(firstName, DB_ENCODING);
			if (lastName != null) lastName = URLDecoder.decode(lastName, DB_ENCODING);
		} catch (UnsupportedEncodingException e) {
			log.error(e, e);
		}
			
		try {
			if (DB_TYPE == null || "".equals(DB_TYPE) ||
				!("MsSql".equals(DB_TYPE) || "MySql".equals(DB_TYPE))) {
				if (debugFlag) log.error("Invalid values in context configuration file.");
				throw new ServletException("Invalid values in context configuration file.");
			}

			int z = verifyRequester(requesterName, requesterPassword, context);
			if (z > 0) {
				patients = createPatientList(firstName, lastName, STNumber, nationalId, siteCode, z,
											 DB_TYPE, JNDI_DATA_SOURCE, log, debugFlag);
			} else {
				if (debugFlag) log.error("Unauthorized user.");
				throw new WebApplicationException(Status.UNAUTHORIZED);
			}
		} catch (Exception e) {
			log.error(e, e);
			e.printStackTrace(System.out);
			throw new WebApplicationException(Status.INTERNAL_SERVER_ERROR);
		}
		
		return patients;
	}
	
	private int verifyRequester(String requesterName, String requesterPassword,
			                    ServletContext context) {
		IPermisionVerifier verifier = new PermissionVerifier();
		return verifier.hasPermision(requesterName, requesterPassword, context);
	}

	private PatientProfiles createPatientList(String firstName, String lastName,
			                                  String st_number, String nationalId,
			                                  String siteCode, int type, String db, String ds,
			                                  Log log, Boolean debugFlag) throws ParseException {
		PatientProfiles patients = new PatientProfiles();

		Map<String, String> map = new HashMap<String, String>();
		putIfNotNull(map, firstName, IPatientProfileRetriever.FIRST_NAME_KEY);
		putIfNotNull(map, lastName, IPatientProfileRetriever.LAST_NAME_KEY);
		putIfNotNull(map, st_number, IPatientProfileRetriever.ST_NUMBER_KEY);
		putIfNotNull(map, nationalId, IPatientProfileRetriever.NATIONALID_KEY);
		putIfNotNull(map, siteCode, IPatientProfileRetriever.SITE_CODE_KEY);

		IPatientProfileRetriever retriever = null;
		switch (type) {
			case 1:
				retriever = new PatientProfileRetriever();
				break;
			case 2:
				retriever = new MshPatientProfileRetriever();
				break;
			case 3:
				retriever = new CirgPatientProfileRetriever();
				break;
			default:
				break;
		}
		List<PatientProfile> patientList = retriever.searchForProfiles(context, map, db, ds, log, debugFlag);
		patients.setPatients(patientList);

		return patients;
	}

	private void putIfNotNull(Map<String, String> map, String value, String key) {
		if (value != null) {
			map.put(key, value.trim());
		}

	}
}