package edu.washington.cirg.isante.services.patient.beans;

import javax.xml.bind.annotation.XmlAttribute;



public class PatientCd4 {
	private String count;
	private String day;
	private String month;
	private String year;
	
	@XmlAttribute
	public String getCount() {
		return count;
	}
	public void setCount(String count) {
		this.count = count;
	}
	
	@XmlAttribute
	public String getDay() {
		return day;
	}
	public void setDay(String day) {
		this.day = day;
	}
	
	@XmlAttribute
	public String getMonth() {
		return month;
	}
	public void setMonth(String month) {
		this.month = month;
	}
	
	@XmlAttribute
	public String getYear() {
		return year;
	}
	
	
	public void setYear(String year) {
		this.year = year;
	}
	
}
