
.PHONY: all clean

all: PatientSearchService.war

PatientSearchService.war: $(wildcard src/*.java)
	@echo Building .war
	@ant package

clean:
	@ant clean
