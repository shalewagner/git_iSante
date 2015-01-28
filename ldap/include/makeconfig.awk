#!/bin/awk -f
# Create template configuration file

BEGIN {
	# FILENAME is not set in the BEGIN block.  Calling getline will set
	# FILENAME, but it will discard the first line of the input file.  In
	# this case, the first line is known to be the PHP opening tag.
	getline

	# Print opening PHP tag and header comments
	print "<?php"
	print "/**"
	print " * Local configuration"
	print " *"
	print " * See " FILENAME " for a description of each setting and the default"
	print " * values."
	print " */"
	print ""
}

/^\$cfg/ {
	# Print configuration variable, commented out
	print "//" $0
}

END {
	# Print closing PHP tag
	print "?>"
}
