package edu.washington.cirg.isante.services.patient.beans;

import java.util.List;

import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlElementWrapper;
import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement(name = "PatientSearchReply")
public class PatientProfiles{

	
	private List<PatientProfile> patientList;

	public void setPatients(List<PatientProfile> patients) {
		this.patientList = patients;
	}

	@XmlElementWrapper(name = "Patients")
	@XmlElement(name = "Patient")
	public List<PatientProfile> getPatients() {
		return patientList;
	}

}
