package edu.washington.cirg.isante.services.patient.beans;

import java.util.List;
import javax.xml.bind.annotation.XmlElement;

public class PatientMedications {

	private List<PatientMedication> medsList;
	
	public void setMedications(List<PatientMedication> meds) {
		this.medsList = meds;
	}
	@XmlElement(name="medication")
	public List<PatientMedication> getMedications() {
		return medsList;
	}

}