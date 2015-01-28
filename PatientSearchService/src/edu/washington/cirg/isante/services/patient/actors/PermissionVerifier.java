package edu.washington.cirg.isante.services.patient.actors;

import javax.servlet.ServletContext;

public class PermissionVerifier implements IPermisionVerifier {

	public int hasPermision(String name, String password, ServletContext context) {
		final String SVC_USERNAME = context.getInitParameter("svcUsername").trim();
		final String SVC_PASSWORD = context.getInitParameter("svcPassword").trim();
		final String MSH_USERNAME = context.getInitParameter("mshUsername").trim();
		final String MSH_PASSWORD = context.getInitParameter("mshPassword").trim();
		final String CIRG_USERNAME = context.getInitParameter("cirgUsername").trim();
		final String CIRG_PASSWORD = context.getInitParameter("cirgPassword").trim();

		if ((!"".equals(SVC_USERNAME)) &&
			(!"".equals(SVC_PASSWORD)) &&
			SVC_USERNAME.equals(name) &&
			SVC_PASSWORD.equals(password)) {
			return 1;
		} else if ((!"".equals(MSH_USERNAME)) &&
			       (!"".equals(MSH_PASSWORD)) &&
			       MSH_USERNAME.equals(name) &&
			       MSH_PASSWORD.equals(password)) {
			return 2;
		} else if ((!"".equals(CIRG_USERNAME)) &&
				   (!"".equals(CIRG_PASSWORD)) &&
				   CIRG_USERNAME.equals(name) &&
				   CIRG_PASSWORD.equals(password)) {
			return 3;
		} else {
			return 0;
		}
	}

}
