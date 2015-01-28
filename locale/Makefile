.PHONY: all ref.pot

all:

all-force: messages.mo-recursive
	@echo
	@echo "RESTART APACHE FOR CHANGES TO BE VISIBLE!"
	@echo

ref.pot:
	rm $@
	touch $@
	cd ../ && find ./ -name '*.php' -not \( \
		-name 'LDAPform.php' -or \
		-path './ldap/*' -or \
		-path './debian/*' \) \
	| xargs xgettext --no-wrap --sort-output --from-code=UTF-8 -j -o locale/ref.pot

%-recursive: ref.pot
	for d in */LC_MESSAGES; do \
		(cd $$d && $(MAKE) -f ../../Makefile $*); \
	done

messages.po-NEW: ../../ref.pot
	cp messages.po messages.po-NEW
	msgmerge -N --backup=none --no-wrap --sort-output -U messages.po-NEW ../../ref.pot
	../../msgfilter-manual.pl ../../translate-manual.pl messages.po-NEW messages.po-NEW2
	mv messages.po-NEW2 messages.po-NEW

messages.po: messages.po-NEW
	mv messages.po-NEW messages.po

messages.mo: messages.po
	msgfmt -o messages.mo messages.po
