SELECT patientid, 
7.7*(CASE WHEN pdc90 <= .80 THEN 1 ELSE 0 END) as pdcTerm, 
9.6*(CASE WHEN whostage = 4 THEN 1 ELSE 0 END) as stageTerm, 
8.9*(CASE WHEN viscountpreart <= 160 THEN 1 ELSE 0 END) as visitCountTerm, 
6.3*(CASE WHEN gender in (1,2) THEN 1 ELSE 0 END) as genderTerm,
7.7*(CASE WHEN pdc90 <= .80 THEN 1 ELSE 0 END) + 
9.6*(CASE WHEN whostage = 4 THEN 1 ELSE 0 END) + 
8.9*(CASE WHEN viscountpreart <= 160 THEN 1 ELSE 0 END) + 
6.3*(CASE WHEN gender in (1,2) THEN 1 ELSE 0 END) as total 
from r34Summary limit 50;
