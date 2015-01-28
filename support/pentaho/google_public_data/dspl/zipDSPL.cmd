:: more header.txt > datatable.csv
:: more +1 extract.csv >> datatable.csv
more header.txt > datatable.csv
cat extract.csv >> datatable.csv

/usr/local/python-2.6.8/bin/python dsplgen.py -o output datatable.csv

/usr/local/python-2.6.8/bin/python relabel/relabel.py output/dataset.xml relabel/description.txt output/dataset.xml

:: concepts
set TABLES=sex_table.csv department_table.csv clinic_table.csv pregnant_table.csv patientStatus_table.csv

for %%C in (%TABLES%) do (
copy tables\%%C output\%%C
)

xcopy output DSPLtoZip /i /h
"C:\Program Files\WinRAR\WinRAR.EXE" m -r "DSPL.zip" "DSPLtoZip" 
