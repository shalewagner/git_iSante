create temporary table ldapList (username varchar(25), fullname varchar(50));
insert into ldapList (username, fullname) values
('user1','Fred blipert'),
('user2','Sally blipert');

select privlevel,case when privlevel = 3 then 'super'
when privlevel = 2 then 'admin'
when privlevel = 1 then 'read/write'
else 'read'end as 'Privilege level',p.username,l.fullname,c.clinic, cnt
from userPrivilege p,
(select username, count(distinct sitecode) as cnt from siteAccess group by 1) s,
clinicLookup c,ldapList l
where p.username = l.username and p.sitecode = c.sitecode and p.username = s.username
order by 1 desc,3; 

