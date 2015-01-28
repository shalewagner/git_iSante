
.PHONY: all jrapp sqlProcess mysql-udf PatientSearchService gnuGet debian locale clean-bin dev test release

all: jrapp PatientSearchService gnuGet

#these build GNU gettext binaries, the output is checked into SVN
locale:
	make -C locale

gnuGet:
	make -C ldap/include/locale

#these build Java byte-code, the output is checked into SVN
jrapp:
	make -C jrapp

PatientSearchService:
	make -C PatientSearchService

#these build and clean CPU specific binaries, the output is NOT checked into SVN
sqlProcess:
	make -C sqlProcess

mysql-udf:
	make -C support/schema-user-functions

clean-bin:
	make -C support/schema-user-functions clean
	make -C sqlProcess clean

#these build debian packages
debian:
	svn log -r COMMITTED | ./debian/log-gen.pl > debian/changelog
	fakeroot ./debian/rules binary
	make clean-bin

dev:
	./debian/version-gen.php dev > debian/version.ini
	make debian

test:
	./debian/version-clean-check.sh
	./debian/version-gen.php test > debian/version.ini
	make debian

release:
	./debian/version-clean-check.sh
	./debian/version-gen.php > debian/version.ini
	make debian
