all: messages.mo-recursive

%-recursive:
	for d in */LC_MESSAGES; do \
		(cd $$d && $(MAKE) -f ../../Makefile $*); \
	done
ref.po:
	touch $@
	find ../../../.. -name '*.php' \
	| xargs xgettext --no-location --no-wrap --sort-output -j -o $@

messages.po: def.po ref.po
	msgmerge --no-wrap --sort-output -o $@ def.po ref.po

messages.mo: messages.po
	msgfmt -o $@ messages.po

clean:
	rm -f ref.po
	rm -f messages.po
	rm -f messages.mo
