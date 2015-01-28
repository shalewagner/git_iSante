# Create local configuration template from default configuration

all: config.php

config.php: config.default.php
	awk -f makeconfig.awk config.default.php > $@

clean:
	rm -f config.php
