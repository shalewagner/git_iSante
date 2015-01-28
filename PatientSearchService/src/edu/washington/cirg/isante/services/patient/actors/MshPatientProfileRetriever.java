package edu.washington.cirg.isante.services.patient.actors;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
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
import edu.washington.cirg.isante.services.patient.beans.PatientArt;
import edu.washington.cirg.isante.services.patient.beans.PatientCd4;
import edu.washington.cirg.isante.services.patient.beans.PatientDOB;
import edu.washington.cirg.isante.services.patient.beans.PatientEncounters;
import edu.washington.cirg.isante.services.patient.beans.PatientHt;
import edu.washington.cirg.isante.services.patient.beans.PatientProfile;
import edu.washington.cirg.isante.services.patient.beans.PatientWt;

public class MshPatientProfileRetriever implements IPatientProfileRetriever {

	public static final int	MILLIS_PER_WEEK = 604800000;
	public static final int MILLIS_4_DAYS = 345600000;
	
	public List<PatientProfile> searchForProfiles(ServletContext context, Map<String, String> searchTerms,
												  String dbType, String dataSource, Log log,
												  Boolean debugFlag) throws ParseException {
		
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
        Statement subStmt = null;
        ResultSet subRs = null;
        String sql = "";
        PatientProfile pp = null;
        PatientDOB dob = null;
        PatientCd4 cd4 = null;
        PatientHt ht = null;
        PatientWt wt = null;
        PatientArt art = null;
        PatientEncounters encs = null;
        
        try {
            conn = DBUtils.getConnection(dataSource);
            if ( conn == null ) {
            	log.error("Unable to obtain a database connection.");
                throw new ServletException("Unable to obtain a database connection.");
            }
            
            // Build sql string
            sql = "SELECT DISTINCT patientID, fname, lname, dobDd, dobMm, dobYy, sex, fnameMother, " +
            	  "addrDistrict, addrSection, addrTown, clinicPatientID, nationalID, occupation, isPediatric, " +
            	  "contact, telephone, statusDescFr AS patientStatus, patGuid FROM patient, patientStatusLookup " +
            	  "WHERE patientStatus = statusValue AND patStatus = 0 ";
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
            	pp = new PatientProfile();
            	dob = new PatientDOB();
            	cd4 = new PatientCd4();
            	ht = new PatientHt();
            	wt = new PatientWt();
            	art = new PatientArt();
            	encs = new PatientEncounters();
            	
            	// The following profile elements should not be sent at all for this retriever
                pp.setPatientId(null);
            	pp.setRegimen(null);
            	pp.setClinicalSummaryLink(null);
            	
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
                		dob.setYear(rs.getString("dobYy").trim());
                	}
                }
                if (rs.getString("dobMm") != null &&
                	!"".equals(rs.getString("dobMm").trim())) {
                	Matcher m = validMonth.matcher(rs.getString("dobMm").trim());
                	if (m.matches()) {
                		dob.setMonth(rs.getString("dobMm").trim());
                	}
                }
                if (rs.getString("dobDd") != null &&
                	!"".equals(rs.getString("dobDd").trim())) {
                	Matcher m = validDay.matcher(rs.getString("dobDd").trim());
                	if (m.matches()) {
                		dob.setDay(rs.getString("dobDd").trim());
                	}
                }
                pp.setDOB(dob);
                if ("1".equals(rs.getString("sex"))) {
                	pp.setGender("F");
                } else if ("2".equals(rs.getString("sex"))) {
                	pp.setGender("H");
                } else {
                	pp.setGender("I");
                }
                if (rs.getString("fnameMother") != null &&
                	!"".equals(rs.getString("fnameMother").trim())) {
                	pp.setMothersFirstName(rs.getString("fnameMother").trim());
                } else {
                	pp.setMothersFirstName("");
                }
                if (rs.getString("contact") != null &&
                   	!"".equals(rs.getString("contact").trim())) {
                   	pp.setContactName(rs.getString("contact").trim());
                } else {
                 	pp.setContactName("");
                }
                if (rs.getString("telephone") != null &&
                    !"".equals(rs.getString("telephone").trim())) {
                    pp.setTelephone(rs.getString("telephone").trim());
                } else {
                    pp.setTelephone("");
                }
                if (rs.getString("patientStatus") != null &&
                    !"".equals(rs.getString("patientStatus").trim())) {
                    pp.setPatientStatus(rs.getString("patientStatus").trim());
                } else {
                    pp.setPatientStatus("");
                }
                if (rs.getString("nationalID") != null &&
                	!"".equals(rs.getString("nationalID").trim())) {
                	pp.setNationalId(rs.getString("nationalID").trim());
                } else {
                	pp.setNationalId("");
                }
                if (rs.getString("clinicPatientID") != null &&
                	!"".equals(rs.getString("clinicPatientID").trim())) {
                	pp.setSTNumber(rs.getString("clinicPatientID").trim());
                } else {
                	pp.setSTNumber("");
                }
                if (rs.getString("patGuid") != null &&
                    !"".equals(rs.getString("patGuid").trim())) {
                	pp.setGUID(rs.getString("patGuid").trim());
                } else {
                	// GUID is required by the XML schema, so return empty tag
                	pp.setGUID("");
                }
                if (rs.getString("addrDistrict") != null &&
                	!"".equals(rs.getString("addrDistrict").trim())) {
                	pp.setDistrict(rs.getString("addrDistrict").trim());
                } else {
                	pp.setDistrict("");
                }
                if (rs.getString("addrSection") != null &&
					  !"".equals(rs.getString("addrSection").trim())) {
                	pp.setSection(rs.getString("addrSection").trim());
                } else {
                	pp.setSection("");
                }
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
                } else {
                	pp.setOccupation("");
                }
                if ("F".equals(pp.getGender())) {
                	String ymd = ("MsSql".equals(dbType)) ? "dbo.ymdToDate" : "ymdToDate";
                    String top = ("MsSql".equals(dbType)) ? "TOP 1" : "";
                    String result = ("MsSql".equals(dbType)) ? "CONVERT(int, result)" : "ROUND(result)";
                    String limit = ("MySql".equals(dbType)) ? "LIMIT 1" : "";
                	String getDate = ("MsSql".equals(dbType)) ? "GETDATE()" : "CURDATE()";
                	String between = ("MsSql".equals(dbType)) ? "DATEADD(mm, -9, GETDATE()) AND GETDATE()" :
                												"DATE_ADD(CURDATE(), INTERVAL - 9 MONTH) AND CURDATE()";
                    String pregQuery = "SELECT p.patientID, MAX(CASE WHEN ISNUMERIC(pregnantLmpDd) <> 1 AND " +
                    				   "ISDATE(" + ymd + "(pregnantLmpYy,pregnantLmpMm,'15')) = 1 AND " + ymd +
                    				   "(pregnantLmpYy,pregnantLmpMm, '15') < " + getDate + " THEN " + ymd +
                    				   "(pregnantLmpYy,pregnantLmpMm,'15') WHEN " +
                    				   "ISNUMERIC(pregnantLmpDd) = 1 AND ISDATE(" + ymd + "(pregnantLmpYy, " +
                    				   "pregnantLmpMm, pregnantLmpDd)) = 1 AND " + ymd + "(pregnantLmpYy, " +
                    				   "pregnantLmpMm, pregnantLmpDd) < " + getDate + " THEN " + ymd + "(pregnantLmpYy, " +
                    				   "pregnantLmpMm, pregnantLmpDd) ELSE NULL END) AS lmpDate " +
                    				   "FROM a_vitals p, (SELECT " + top + " patientID, value FROM (SELECT patientID, pregnant as value, " +
                    				   "visitdate FROM a_vitals WHERE patientID = '" + rs.getString("patientID") + "' AND visitdate " +
                    				   "BETWEEN " + between + " AND pregnant IN (1, 2) UNION SELECT patientID, " + result + " as value, " +
                    				   ymd + "(resultDateYy, resultDateMm, resultDateDd) as visitdate FROM a_labsCompleted WHERE " +
                    				   "patientID = '" + rs.getString("patientID") + "' AND labID IN (134) AND ISDATE(" + ymd +
                    				   "(resultDateYy, resultDateMm, resultDateDd)) = 1 AND " + ymd + "(resultDateYy, resultDateMm, " +
                    				   "resultDateDd) BETWEEN " + between + " AND result IN (1, 2)) t1 ORDER BY visitdate DESC " + limit +
                    				   ") t2 WHERE p.patientID = '" + rs.getString("patientID") + "' AND p.patientID = t2.patientID AND " +
                    				   "t2.value = 1 GROUP by p.patientID";

                    if (debugFlag) log.info("Pregnancy subquery = '" + pregQuery + "'");
                    subStmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                    							   ResultSet.CONCUR_READ_ONLY);
                    subRs = subStmt.executeQuery(pregQuery);
                    if (subRs.next()) {
                		pp.setPregnant("Oui");
                    	if (subRs.getString("lmpDate") != null &&
                    		!"".equals(subRs.getString("lmpDate").trim())) {
                    		SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd");
                    		int weeks = -1;
                    		weeks = getWeekDelta(df.parse(subRs.getString("lmpDate").trim()), new Date());
                    		if (weeks >= 0 && weeks <= 46) {
                    			pp.setPregnancyWeeks(Integer.toString(weeks));
                    		} else {
                    			pp.setPregnancyWeeks("N/A");
                    		}
                    	} else {
                        	pp.setPregnancyWeeks("N/A");
                    	}
                    } else {
                    	pp.setPregnant("Non");
                    	pp.setPregnancyWeeks("N/A");
                    }
                } else {
                	pp.setPregnant("Non");
                	pp.setPregnancyWeeks("N/A");
                }

                String top = ("MsSql".equals(dbType)) ? "TOP 1" : "";
                String limit = ("MySql".equals(dbType)) ? "LIMIT 1" : "";
                String cd4Query = "SELECT " + top + " cd4, visitdate, DAY(visitdate) AS day, " +
                				  "MONTH(visitdate) AS month, YEAR(visitdate) AS year FROM cd4Table " +
                				  "WHERE patientid = '" + rs.getString("patientID") + "' ORDER BY 2 DESC " + limit;
            	
                if (debugFlag) log.info("CD4 subquery = '" + cd4Query + "'");
                subStmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                							   ResultSet.CONCUR_READ_ONLY);
                subRs = subStmt.executeQuery(cd4Query);
                if (subRs.next()) {
                    if (subRs.getString("cd4") != null &&
                        !"".equals(subRs.getString("cd4").trim())) {
                       	cd4.setCount(subRs.getString("cd4").trim());
                    }
                    if (subRs.getString("year") != null &&
                        !"".equals(subRs.getString("year").trim())) {
                        Matcher m = validYear.matcher(zeroPad(subRs.getString("year").trim(), 2));
                        if (m.matches()) {
                        	cd4.setYear(zeroPad(subRs.getString("year").trim(), 2));
                        }
                    }
                    if (subRs.getString("month") != null &&
                       	!"".equals(subRs.getString("month").trim())) {
                      	Matcher m = validMonth.matcher(zeroPad(subRs.getString("month").trim(), 2));
                       	if (m.matches()) {
                       		cd4.setMonth(zeroPad(subRs.getString("month").trim(), 2));
                       	}
                    }
                    if (subRs.getString("day") != null &&
                       	!"".equals(subRs.getString("day").trim())) {
                       	Matcher m = validDay.matcher(zeroPad(subRs.getString("day").trim(), 2));
                       	if (m.matches()) {
                       		cd4.setDay(zeroPad(subRs.getString("day").trim(), 2));
                      	}
                    }
                }
                pp.setCd4(cd4);
                
//                if (rs.getString("isPediatric") != null && "1".equals(rs.getString("isPediatric").trim())) {
                	String htQuery = "SELECT " + top + " REPLACE(LTRIM(RTRIM(vitalHeight)), ',', '.') AS m, " +
					 				 "REPLACE(LTRIM(RTRIM(vitalHeightCm)), ',', '.') AS cm, visitdate, " + 
					 				 "DAY(visitdate) AS day, MONTH(visitdate) AS month, " +
					 				 "YEAR(visitdate) AS year FROM a_vitals WHERE patientid = '" + 
					 				 rs.getString("patientID") + "' AND encounterType IN (1, 2, 16, 17) AND " +
					 				 "(ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)), ',', '.')) = 1 OR " +
					 				 "ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)), ',', '.')) = 1) ORDER BY 2 DESC " + limit;
                    if (debugFlag) log.info("Height subquery = '" + htQuery + "'");
                    subStmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                    							   ResultSet.CONCUR_READ_ONLY);
                    subRs = subStmt.executeQuery(htQuery);
                    if (subRs.next()) {
                    	String finalHt = "";
                    	ht.setUnit("meters");
                    	if (subRs.getString("m") != null &&
                    		!"".equals(subRs.getString("m").trim())) {
                    		finalHt = finalHt.concat(subRs.getString("m"));
                    	}
                    	if (subRs.getString("cm") != null &&
                        	!"".equals(subRs.getString("cm").trim())) {
                        	finalHt = finalHt.concat("." + subRs.getString("cm"));
                        }
                		ht.setValue(finalHt);
                    	if (subRs.getString("year") != null &&
                    		!"".equals(subRs.getString("year").trim())) {
                    		Matcher m = validYear.matcher(zeroPad(subRs.getString("year").trim(), 2));
                    		if (m.matches()) {
                    			ht.setYear(zeroPad(subRs.getString("year").trim(), 2));
                    		}
                    	}
                    	if (subRs.getString("month") != null &&
                    		!"".equals(subRs.getString("month").trim())) {
                    		Matcher m = validMonth.matcher(zeroPad(subRs.getString("month").trim(), 2));
                    		if (m.matches()) {
                    			ht.setMonth(zeroPad(subRs.getString("month").trim(), 2));
                    		}
                    	}
                    	if (subRs.getString("day") != null &&
                    		!"".equals(subRs.getString("day").trim())) {
                    		Matcher m = validDay.matcher(zeroPad(subRs.getString("day").trim(), 2));
                    		if (m.matches()) {
                    			ht.setDay(zeroPad(subRs.getString("day").trim(), 2));
                    		}
                    	}
                    }
                    pp.setHt(ht);
//                }
                
                String convertStart = ("MsSql".equals(dbType)) ? "CONVERT(FLOAT, " : "";
                String convertEnd = ("MsSql".equals(dbType)) ? ")" : "";
                String wtQuery = "SELECT " + top + " CASE WHEN vitalWeightUnits = 1 THEN " +
                				 "REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.') ELSE " +
                				 "ROUND(" + convertStart + "REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')" + convertEnd + " / 2.20462262, 0) END " +
                				 "AS wt, visitdate, DAY(visitdate) AS day, MONTH(visitdate) AS month, " +
                				 "YEAR(visitdate) AS year FROM a_vitals WHERE encounterType IN (1, 2, 16, 17) AND " +
                				 "ISNUMERIC(vitalWeight) = 1 AND vitalWeightUnits > 0 AND patientid = '" +
                				 rs.getString("patientID") + "' ORDER BY 2 DESC " + limit;

                if (debugFlag) log.info("Weight subquery = '" + wtQuery + "'");
                subStmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                							   ResultSet.CONCUR_READ_ONLY);
                subRs = subStmt.executeQuery(wtQuery);
                if (subRs.next()) {
                	wt.setUnit("kgs");
                	if (subRs.getString("wt") != null &&
                		!"".equals(subRs.getString("wt").trim())) {
                		wt.setValue(subRs.getString("wt").trim());
                	}
                	if (subRs.getString("year") != null &&
                		!"".equals(subRs.getString("year").trim())) {
                		Matcher m = validYear.matcher(zeroPad(subRs.getString("year").trim(), 2));
                		if (m.matches()) {
                			wt.setYear(zeroPad(subRs.getString("year").trim(), 2));
                		}
                	}
                	if (subRs.getString("month") != null &&
                		!"".equals(subRs.getString("month").trim())) {
                		Matcher m = validMonth.matcher(zeroPad(subRs.getString("month").trim(), 2));
                		if (m.matches()) {
                			wt.setMonth(zeroPad(subRs.getString("month").trim(), 2));
                		}
                	}
                	if (subRs.getString("day") != null &&
                		!"".equals(subRs.getString("day").trim())) {
                		Matcher m = validDay.matcher(zeroPad(subRs.getString("day").trim(), 2));
                		if (m.matches()) {
                			wt.setDay(zeroPad(subRs.getString("day").trim(), 2));
                		}
                	}
                }
                pp.setWt(wt);

                String artQuery = "SELECT " + top + " visitdate, DAY(visitdate) AS day, MONTH(visitdate) " +
				  				  "AS month, YEAR(visitdate) AS year FROM pepfarTable WHERE patientid = '" +
				  				  rs.getString("patientID") + "' ORDER BY 1 DESC " + limit;

                if (debugFlag) log.info("ART subquery = '" + artQuery + "'");
                subStmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                							   ResultSet.CONCUR_READ_ONLY);
                subRs = subStmt.executeQuery(artQuery);
                if (subRs.next()) {
                	if (subRs.getString("year") != null &&
                		!"".equals(subRs.getString("year").trim())) {
                		Matcher m = validYear.matcher(zeroPad(subRs.getString("year").trim(), 2));
                		if (m.matches()) {
                			art.setYear(zeroPad(subRs.getString("year").trim(), 2));
                		}
                	}
                	if (subRs.getString("month") != null &&
                		!"".equals(subRs.getString("month").trim())) {
                		Matcher m = validMonth.matcher(zeroPad(subRs.getString("month").trim(), 2));
                		if (m.matches()) {
                			art.setMonth(zeroPad(subRs.getString("month").trim(), 2));
                		}
                	}
                	if (subRs.getString("day") != null &&
                		!"".equals(subRs.getString("day").trim())) {
                		Matcher m = validDay.matcher(zeroPad(subRs.getString("day").trim(), 2));
                		if (m.matches()) {
                			art.setDay(zeroPad(subRs.getString("day").trim(), 2));
                		}
                	}
                }
                pp.setArtStart(art);

                String encQuery = "SELECT MAX(visitDate) as visitdate, COUNT(*) as cnt, DAY(MAX(visitDate)) AS day, " +
				  				  "MONTH(MAX(visitDate)) AS month, YEAR(MAX(visitDate)) AS year " +
				  				  "FROM encValidAll WHERE patientid = '" + rs.getString("patientID") + "' GROUP BY patientID";

                if (debugFlag) log.info("Encounters subquery = '" + encQuery + "'");
                subStmt = conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,
                							   ResultSet.CONCUR_READ_ONLY);
                subRs = subStmt.executeQuery(encQuery);
                if (subRs.next()) {
                	if (subRs.getString("cnt") != null &&
                		!"".equals(subRs.getString("cnt").trim())) {
                		encs.setCount(subRs.getString("cnt").trim());
                	}
                	if (subRs.getString("year") != null &&
                		!"".equals(subRs.getString("year").trim())) {
                		Matcher m = validYear.matcher(zeroPad(subRs.getString("year").trim(), 2));
                		if (m.matches()) {
                			encs.setYear(zeroPad(subRs.getString("year").trim(), 2));
                		}
                	}
                	if (subRs.getString("month") != null &&
                		!"".equals(subRs.getString("month").trim())) {
                		Matcher m = validMonth.matcher(zeroPad(subRs.getString("month").trim(), 2));
                		if (m.matches()) {
                			encs.setMonth(zeroPad(subRs.getString("month").trim(), 2));
                		}
                	}
                	if (subRs.getString("day") != null &&
                		!"".equals(subRs.getString("day").trim())) {
                		Matcher m = validDay.matcher(zeroPad(subRs.getString("day").trim(), 2));
                		if (m.matches()) {
                			encs.setDay(zeroPad(subRs.getString("day").trim(), 2));
                		}
                	}
                }
                pp.setEncounters(encs);

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
        	e.printStackTrace(System.out);
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

	private static final int getWeekDelta(Date date1, Date date2) {

		long diff = Math.abs(date1.getTime() - date2.getTime());
		long weeks = diff / MILLIS_PER_WEEK;

		if (weeks == 0) {

			Calendar min = Calendar.getInstance();
			Calendar max = Calendar.getInstance();

			min.setTime(date1.before(date2) ? date1 : date2);
			max.setTime(date1.before(date2) ? date2 : date1);

			if ((max.get(Calendar.DAY_OF_WEEK) - min.get(Calendar.DAY_OF_WEEK)) >= 4) {
				weeks++;
			}
		} else if ((diff % MILLIS_PER_WEEK) >= MILLIS_4_DAYS) {
			weeks++;
		}

		return (int) weeks;
	}
	
	private static final String zeroPad(String input, int len) {
		return (input.length() < len ? "0" + input : input);
	}
}
