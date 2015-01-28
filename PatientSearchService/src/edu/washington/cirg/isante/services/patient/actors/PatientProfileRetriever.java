package edu.washington.cirg.isante.services.patient.actors;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.ws.rs.WebApplicationException;
import javax.ws.rs.core.Response.Status;

import org.apache.commons.logging.Log;

import edu.washington.cirg.db.DBUtils;
import edu.washington.cirg.isante.services.patient.beans.PatientProfile;

public class PatientProfileRetriever implements IPatientProfileRetriever {

	public List<PatientProfile> searchForProfiles(ServletContext context, Map<String, String> searchTerms,
												  String dbType, String dataSource, Log log,
												  Boolean debugFlag) {
		
		String firstName = searchTerms.get(IPatientProfileRetriever.FIRST_NAME_KEY);
		String lastName = searchTerms.get(IPatientProfileRetriever.LAST_NAME_KEY);
		String stNumber = searchTerms.get(IPatientProfileRetriever.ST_NUMBER_KEY);
		String nationalId = searchTerms.get(IPatientProfileRetriever.NATIONALID_KEY);
		
		if (firstName == null) firstName = "";
		if (lastName == null) lastName = "";
		if (stNumber == null) stNumber = "";
		if (nationalId == null) nationalId = "";
		
		List<PatientProfile> patientList = new ArrayList<PatientProfile>();
		
		// No search parameters given means no results
		if ("".equals(firstName) && "".equals(lastName) &&
			"".equals(stNumber) && "".equals(nationalId)) {
			log.info("No search parameters provided.");
			return patientList;
		}
		
        Connection conn = null;
        Statement stmt = null;
        ResultSet rs = null;
        String sql = "";
        
        try {
            conn = DBUtils.getConnection(dataSource);
            if ( conn == null ) {
            	log.error("Unable to obtain a database connection.");
                throw new ServletException("Unable to obtain a database connection.");
            }
            
            // Build sql string
            sql = "SELECT fname, lname, dobDd, dobMm, dobYy, sex, fnameMother, " +
            	  "addrDistrict, addrSection, addrTown, clinicPatientID, nationalID, " +
            	  "occupation, patGuid FROM patient WHERE patStatus = 0 ";
            if (!"".equals(firstName)) {
            	sql += "AND UPPER(fname) = '" + firstName.toUpperCase() + "' ";
            }
            if (!"".equals(lastName)) {
            	sql += "AND UPPER(lname) = '" + lastName.toUpperCase() + "' ";
            }
            if (!"".equals(stNumber)) {
            	sql += "AND UPPER(clinicPatientID) LIKE '%" + stNumber.toUpperCase() + "%' ";
            }
            if (!"".equals(nationalId)) {
            	sql += "AND UPPER(nationalID) = '" + nationalId.toUpperCase() + "' ";
            }

            if (debugFlag) log.info("SQL query = '" + sql + "'");
            stmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                    					ResultSet.CONCUR_READ_ONLY);
            rs = stmt.executeQuery(sql);
            Pattern validYear = Pattern.compile( "([0-9]{4})" );
            Pattern validMonth = Pattern.compile( "(0[1-9]|1[012])" );
            Pattern validDay = Pattern.compile( "(0[1-9]|[12][0-9]|3[01])" );
            
            //... iterate through the result set ...
            while (rs.next()) {
                PatientProfile pp = new PatientProfile();
                
            	// The following profile elements should not be sent at all for this retriever
                pp.setPatientId(null);
            	pp.setRegimen(null);
            	pp.setClinicalSummaryLink(null);
            	pp.setContactName(null);
            	pp.setTelephone(null);
            	pp.setPatientStatus(null);
            	pp.setPregnant(null);
            	pp.setPregnancyWeeks(null);
            	pp.setCd4(null);
            	pp.setWt(null);
            	pp.setHt(null);
            	pp.setArtStart(null);
            	pp.setEncounters(null);

                if (rs.getString("fname") != null &&
                	!"".equals(rs.getString("fname").trim())) {
                	pp.setFirstName(rs.getString("fname").trim());
                } else {
                	// First name is required by the XML schema, so return empty tag
                	pp.setFirstName("");
                }
                if (rs.getString("lname") != null &&
                	!"".equals(rs.getString("lname").trim())) {
                	pp.setLastName(rs.getString("lname").trim());
                } else {
                	// Last name is required by the XML schema, so return empty tag
                	pp.setLastName("");
                }
                if (rs.getString("dobYy") != null &&
                	!"".equals(rs.getString("dobYy").trim())) {
                	Matcher m = validYear.matcher(rs.getString("dobYy").trim());
                	if (m.matches()) {
                		pp.setYearDOB(rs.getString("dobYy").trim());
                	}
                }
                if (rs.getString("dobMm") != null &&
                	!"".equals(rs.getString("dobMm").trim())) {
                	Matcher m = validMonth.matcher(rs.getString("dobMm").trim());
                	if (m.matches()) {
                		pp.setMonthDOB(rs.getString("dobMm").trim());
                	}
                }
                if (rs.getString("dobDd") != null &&
                	!"".equals(rs.getString("dobDd").trim())) {
                	Matcher m = validDay.matcher(rs.getString("dobDd").trim());
                	if (m.matches()) {
                		pp.setDayDOB(rs.getString("dobDd").trim());
                	}
                }
                if ("1".equals(rs.getString("sex"))) {
                	pp.setGender("F");
                } else if ("2".equals(rs.getString("sex"))) {
                	pp.setGender("M");
                } else {
                	pp.setGender("U");
                }
                if (rs.getString("fnameMother") != null &&
                	!"".equals(rs.getString("fnameMother").trim())) {
                	pp.setMothersFirstName(rs.getString("fnameMother").trim());
                }
                if (rs.getString("nationalID") != null &&
                	!"".equals(rs.getString("nationalID").trim())) {
                	pp.setNationalId(rs.getString("nationalID").trim());
                }
                if (rs.getString("clinicPatientID") != null &&
                	!"".equals(rs.getString("clinicPatientID").trim())) {
                	pp.setSTNumber(rs.getString("clinicPatientID").trim());
                }
                if (rs.getString("patGuid") != null &&
                    !"".equals(rs.getString("patGuid").trim())) {
                	pp.setGUID(rs.getString("patGuid").trim());
                } else {
                	// GUID is required by the XML schema, so return empty tag
                	pp.setGUID("");
                }
//                if (rs.getString("addrDistrict") != null &&
//                	!"".equals(rs.getString("addrDistrict").trim())) {
//                	pp.setStreet(rs.getString("addrDistrict").trim());
//                }
//                if (rs.getString("addrSection") != null &&
//					  !"".equals(rs.getString("addrSection").trim())) {
//                	pp.set???(rs.getString("addrSection").trim());
//                }
                if (rs.getString("addrTown") != null &&
                	!"".equals(rs.getString("addrTown").trim())) {
                	pp.setTown(rs.getString("addrTown").trim());
                } else {
                	// Town is required by the XML schema, so return empty tag
                	pp.setTown("");
                }
                if (rs.getString("occupation") != null &&
                	!"".equals(rs.getString("occupation").trim())) {
                	pp.setOccupation(rs.getString("occupation").trim());
                }
                patientList.add(pp);
            }
            
            rs.close();
            rs = null;
            stmt.close();
            stmt = null;
            conn.close();
            conn = null;

            return patientList;

        } catch (Exception e) {
        	log.error(e, e);
        	throw new WebApplicationException(Status.INTERNAL_SERVER_ERROR);   
    	} finally {
    		if (rs != null) {
    			try {
    				rs.close();
    		    } catch (Exception e) {
    		    	log.error(e, e);
    		    	throw new WebApplicationException(Status.INTERNAL_SERVER_ERROR);
    		    }
    		    rs = null;
    		}
    		if (stmt != null) {
    			try {
    				stmt.close();
    			} catch (Exception e) {
    				log.error(e, e);
    	        	throw new WebApplicationException(Status.INTERNAL_SERVER_ERROR);
    			}
    			stmt = null;
    		}
            if (conn != null) {
                try {
                    conn.close();
                } catch ( Exception e ) {
                	log.error(e, e);
                	throw new WebApplicationException(Status.INTERNAL_SERVER_ERROR);
                }
                conn = null;
            }
    	}
	}

}
