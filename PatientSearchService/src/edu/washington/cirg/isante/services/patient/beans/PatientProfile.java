package edu.washington.cirg.isante.services.patient.beans;

public class PatientProfile {
	
	private String firstName;
	private String lastName;
	private String gender;
	private String mothersFirstName;
	private String contactName;
	private String telephone;
	private String patientStatus;
	private String patientId;
	private String STNumber;
	private String nationalId;
	private String GUID;
	private String occupation;
	private String pregnant;
	private String pregnancyWeeks;
	private String clinSumLink;
	private String hivPositive;
	private Address address = new Address();
	private PatientDOB DOB = new PatientDOB();
	private PatientCd4 CD4 = new PatientCd4();
	private PatientWt wt = new PatientWt();
	private PatientHt ht = new PatientHt();
	private PatientArt artStart = new PatientArt();
	private PatientEncounters encs = new PatientEncounters();
	private PatientRegimen reg = new PatientRegimen();
//	private PatientMedications medications = new PatientMedications();
//
//	public void setMedications(PatientMedications meds) {
//		medications = meds;
//	}
//
//	public PatientMedications getMedications() {
//		return medications;
//	}
	
	public void setRegimen(PatientRegimen reg) {
		this.reg = reg;
	}

	public PatientRegimen getRegimen() {
		return reg;
	}
	
	public void setRegDay(String day) {
		reg.setDay(day);
	}

	public void setRegMonth(String month) {
		reg.setMonth(month);
	}

	public void setRegYear(String year) {
		reg.setYear(year);
	}
	
	public void setEncounters(PatientEncounters encs) {
		this.encs = encs;
	}

	public PatientEncounters getEncounters() {
		return encs;
	}
	
	public void setEncDay(String day) {
		encs.setDay(day);
	}

	public void setEncMonth(String month) {
		encs.setMonth(month);
	}

	public void setEncYear(String year) {
		encs.setYear(year);
	}
	
	public void setEncCount(String count) {
		encs.setCount(count);
	}
	
	public void setArtStart(PatientArt artStart) {
		this.artStart = artStart;
	}

	public PatientArt getArtStart() {
		return artStart;
	}
	
	public void setArtDay(String day) {
		artStart.setDay(day);
	}

	public void setArtMonth(String month) {
		artStart.setMonth(month);
	}

	public void setArtYear(String year) {
		artStart.setYear(year);
	}
	
	public void setHt(PatientHt ht) {
		this.ht = ht;
	}

	public PatientHt getHt() {
		return ht;
	}
	
	public void setHtDay(String day) {
		ht.setDay(day);
	}

	public void setHtMonth(String month) {
		ht.setMonth(month);
	}

	public void setHtYear(String year) {
		ht.setYear(year);
	}
	
	public void setHtValue(String value) {
		ht.setValue(value);
	}
	
	public void setWt(PatientWt wt) {
		this.wt = wt;
	}

	public PatientWt getWt() {
		return wt;
	}
	
	public void setWtDay(String day) {
		wt.setDay(day);
	}

	public void setWtMonth(String month) {
		wt.setMonth(month);
	}

	public void setWtYear(String year) {
		wt.setYear(year);
	}
	
	public void setWtValue(String value) {
		wt.setValue(value);
	}
	
	public void setCd4(PatientCd4 cd4) {
		CD4 = cd4;
	}

	public PatientCd4 getCd4() {
		return CD4;
	}
	
	public void setCd4Day(String day) {
		CD4.setDay(day);
	}

	public void setCd4Month(String month) {
		CD4.setMonth(month);
	}

	public void setCd4Year(String year) {
		CD4.setYear(year);
	}
	
	public void setCd4Count(String count) {
		CD4.setCount(count);
	}
	
	public void setDOB(PatientDOB dob) {
		DOB = dob;
	}

	public PatientDOB getDOB() {
		return DOB;
	}
	
	public String getFirstName() {
		return firstName;
	}
	
	public void setFirstName(String firstName) {
		this.firstName = firstName;
	}
	
	public String getLastName() {
		return lastName;
	}
	
	public void setLastName(String lastName) {
		this.lastName = lastName;
	}
	
	public String getGender() {
		return gender;
	}
	
	public void setGender(String gender) {
		this.gender = gender;
	}

	public void setDayDOB(String dayDOB) {
		DOB.setDay(dayDOB);
	}

	public void setMonthDOB(String monthDOB) {
		DOB.setMonth(monthDOB);
	}

	public void setYearDOB(String yearDOB) {
		DOB.setYear(yearDOB);
	}
	
	public String getMothersFirstName() {
		return mothersFirstName;
	}
	
	public void setMothersFirstName(String mothersFirstName) {
		this.mothersFirstName = mothersFirstName;
	}
	
	public String getContactName() {
		return contactName;
	}
	
	public void setContactName(String contact) {
		this.contactName = contact;
	}
	
	public String getTelephone() {
		return telephone;
	}
	
	public void setTelephone(String telephone) {
		this.telephone = telephone;
	}
	
	public String getPatientStatus() {
		return patientStatus;
	}
	
	public void setPatientStatus(String patientStatus) {
		this.patientStatus = patientStatus;
	}
	
	public String getOccupation() {
		return occupation;
	}
	
	public void setOccupation(String occupation) {
		this.occupation = occupation;
	}
	
	public String getSTNumber() {
		return STNumber;
	}
	
	public void setSTNumber(String number) {
		STNumber = number;
	}
	
	public String getPatientId() {
		return patientId;
	}
	
	public void setPatientId(String patientId) {
		this.patientId = patientId;
	}
	
	public String getNationalId() {
		return nationalId;
	}
	
	public void setNationalId(String nationalId) {
		this.nationalId = nationalId;
	}
	
	public String getGUID() {
		return GUID;
	}
	
	public void setGUID(String guid) {
		GUID = guid;
	}

	public String getPregnant() {
		return pregnant;
	}
	
	public void setPregnant(String preg) {
		this.pregnant = preg;
	}

	public String getPregnancyWeeks() {
		return pregnancyWeeks;
	}
	
	public void setPregnancyWeeks(String weeks) {
		this.pregnancyWeeks = weeks;
	}

	public String getClinicalSummaryLink() {
		return clinSumLink;
	}
	
	public void setClinicalSummaryLink(String url) {
		clinSumLink = url;
	}

	public String getHivPositive() {
		return hivPositive;
	}
	
	public void setHivPositive(String hivPos) {
		hivPositive = hivPos;
	}

	public void setStreet(String street) {
		address.setStreet(street);
	}

	public void setTown(String town) {
		address.setTown(town);
	}
	
	public void setSection(String section) {
		address.setSection(section);
	}
	
	public void setDistrict(String district) {
		address.setDistrict(district);
	}

	public void setAddress(Address address) {
		this.address = address;
	}

	public Address getAddress() {
		return address;
	}

}
