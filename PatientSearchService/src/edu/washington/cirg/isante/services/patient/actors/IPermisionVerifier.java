package edu.washington.cirg.isante.services.patient.actors;

import javax.servlet.ServletContext;

public interface IPermisionVerifier {
	public int hasPermision(String name, String password, ServletContext context);
}
