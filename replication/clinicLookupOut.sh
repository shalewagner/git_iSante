#!/bin/bash
mysql -s <<EOF
select concat('update clinicLookup set dbversion = ''',dbversion, ''' where sitecode = ''', sitecode, ''';') from clinicLookup where incphr = 1;
EOF
