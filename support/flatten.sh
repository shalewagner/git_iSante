# takes an unflattened php file with no suffix, ie "allergies"
# and generates "allergies.php" flattened in 3 steps
# 1. remove tab characters
tr -d '\t' < $1 > $1.tmp
# 2. remove single line comments (anywhere in a line)
awk '{ cnt = split($0,a,"//"); if (cnt > 1) print a[1]; else print $0; }' < $1.tmp > $1.tmp2
# 3. remove carriagereturn/line feeds and compress whitespace
tr -s '\r\n' ' ' < $1.tmp2 > $1.php
rm $1.tmp
rm $1.tmp2
