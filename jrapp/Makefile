
.PHONY: all jrxml clean

all: ITECH_Reports.jar jrxml

jrxml: $(wildcard ../jrxml/mysql/*.jrxml)
	@ant jasperBuild

ITECH_Reports.jar: $(wildcard src/*.java)
	@ant package

clean:
	@ant clean
