/* 2009 2nd line regimens added: */
insert into regimen values (100, '2nd2009-1',31,20,6,'','TNF-3TC-ATV/r', '2nd2009-1');
/* select * from regimen where drugid1 in (31,20,6) and drugid2 in (31,20,6) and drugid3 in (31,20,6); */
insert into regimen values (101, '2nd2009-2',31,20,21,'','TNF-3TC-LPV/r','2nd2009-2');   
/* select * from regimen where drugid1 in (31,20,21) and drugid2 in (31,20,21) and drugid3 in (31,20,21); */
insert into regimen values (102,'2nd2009-3',31,12,6,'','TNF-FTC-ATV/r', '2nd2009-3');
/* select * from regimen where drugid1 in (31,12,6) and drugid2 in (31,12,6) and drugid3 in (31,12,6); */ 
/* already a valid regimen: TNF + FTC + LPV/r   2nd2009-4  
*** select * from regimen where drugid1 in (31,12,21) and drugid2 in (31,12,21) and drugid3 in (31,12,21); */
insert into regimen values (103,'2nd2009-5',8,6,0,'', 'AZT-3TC-ATV/r','2nd2009-5');
insert into regimen values (104,'2nd2009-5', 34,20,6,'', 'AZT-3TC-ATV/r', '2nd2009-5'); 
/*select * from regimen where drugid1 in (8,6) and drugid2 in (8,6);
select * from regimen where drugid1 in (34,20,6) and drugid2 in (34,20,6) and drugid3 in (34,20,6); */
/* already a valid regimen AZT + 3TC + LPV/r   2nd2009-6
*** select * from regimen where drugid1 in (8,21) and drugid2 in (8,21);
*** select * from regimen where drugid1 in (34,20,21) and drugid2 in (34,20,21) and drugid3 in (34,20,21); 
   don't understand "double" TNF + 3TC + double LPV/r  2nd2009-7
                             TNF + FTC + double LPV/r  2nd2009-8
                             AZT + 3TC + double LPV/r  2nd2009-9    */
insert into regimen values (105,'2nd2009-10',8,31,6,'','AZT-TNF-3TC-ATV/r', '2nd2009-10');
/* but can't do 4 drug version of this regimen   AZT + TNF + 3TC + ATV/r  2nd2009-10 
select * from regimen where drugid1 in (8,31,6) and drugid2 in (8,31,6) and drugid3 in (8,31,6);
*** or this one:               AZT + TNF + FTC + ATV/r  */  
insert into regimen values (106,'2nd2009-12',8,31,21,'','AZT-TNF-3TC-LPV/r', '2nd2009-12'); 
/* but can't do 4 drug version of this regimen    AZT + TNF + 3TC + LPV/r  
select * from regimen where drugid1 in (8,31,21) and drugid2 in (8,31,21) and drugid3 in (8,31,21); */  

select * from regimen where regID > 99;
