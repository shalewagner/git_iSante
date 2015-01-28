/* to get password for logging in
 * more /usr/share/tomcat5.5/conf/Catalina/localhost/haitiOpenElis.xml
 * psql -h localhost -U clinlims clinlims
 */
drop view clinlims.sampletracking;
alter table clinlims.patient_identity alter column identity_data type varchar(255);
alter table clinlims.person alter column last_name type varchar(255);
alter table clinlims.person alter column first_name type varchar(255);
alter table clinlims.person alter column middle_name type varchar(255);
alter table clinlims.person alter column street_address type varchar(255);
alter table clinlims.person alter column home_phone type varchar(255);
alter table clinlims.person alter column work_phone type varchar(255);
alter table clinlims.person alter column cell_phone type varchar(255);
alter table clinlims.person alter column fax type varchar(255);
alter table clinlims.person alter column email type varchar(255);
alter table clinlims.person alter column country type varchar(255);
alter table clinlims.person alter column city type varchar(255);
alter table clinlims.person alter column multiple_unit type varchar(255);
alter table clinlims.person_address alter column value type varchar(255);
alter table clinlims.patient alter column external_id type varchar( 255 );
alter table clinlims.patient alter column national_id type varchar(255);
alter table clinlims.patient alter column birth_place type varchar(255);