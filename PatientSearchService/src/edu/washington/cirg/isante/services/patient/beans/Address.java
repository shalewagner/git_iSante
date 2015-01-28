package edu.washington.cirg.isante.services.patient.beans;

public class Address {

	private String street;
	private String town;
	private String section;
	private String district;
	
	public void setStreet(String street) {
		this.street = street;
	}
	public String getStreet() {
		return street;
	}
	public void setTown(String town) {
		this.town = town;
	}
	public String getTown() {
		return town;
	}
	public void setSection(String section) {
		this.section = section;
	}
	public String getSection() {
		return section;
	}
	public void setDistrict(String district) {
		this.district = district;
	}
	public String getDistrict() {
		return district;
	}

}
