:: concepts
set TABLES=clinics.csv departments.csv status.csv networks.csv encounter.csv

for %%C in (%TABLES%) do (
copy C:\wamp\www\concepts\DSPL\%%C C:\Users\tlabarre.CIRG-FROST\Documents\isante-database\DSPL\%%C
)

:: departments
set TABLES=departments_slice.csv departments_sex_slice.csv departments_hiv_slice.csv departments_status_slice.csv departments_hiv_status_slice.csv departments_sex_status_slice.csv departments_sex_hiv_slice.csv departments_sex_hiv_status_slice.csv national_slice.csv national_sex_slice.csv national_hiv_slice.csv national_status_slice.csv national_hiv_status_slice.csv national_sex_status_slice.csv national_sex_hiv_slice.csv national_sex_hiv_status_slice.csv

for %%C in (%TABLES%) do (
copy C:\wamp\www\concepts\DSPL\%%C C:\Users\tlabarre.CIRG-FROST\Documents\isante-database\DSPL\%%C
)

:: clinics
set TABLES=clinics_slice.csv clinics_sex_slice.csv clinics_hiv_slice.csv clinics_status_slice.csv clinics_hiv_status_slice.csv clinics_sex_status_slice.csv clinics_sex_hiv_slice.csv clinics_sex_hiv_status_slice.csv 

for %%C in (%TABLES%) do (
copy C:\wamp\www\concepts\DSPL\%%C C:\Users\tlabarre.CIRG-FROST\Documents\isante-database\DSPL\%%C
)

:: encounter
set TABLES=clinics_encounter_slice.csv departments_encounter_slice.csv national_encounter_slice.csv 

for %%C in (%TABLES%) do (
copy C:\wamp\www\concepts\DSPL\%%C C:\Users\tlabarre.CIRG-FROST\Documents\isante-database\DSPL\%%C
)


xcopy DSPL DSPLtoZip /i /h
"C:\Program Files (x86)\WinRAR\WinRAR.EXE" m -r "DSPL.zip" "DSPLtoZip" 
