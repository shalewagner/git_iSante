/* This query maps specific test names to wildcard values 
 * used in reports.xml to look for the correct tests in reports
 * i.e. where testnamefr like '%cd4%'
 */

select 'cd4' as wildcard, labid, testnameen, testnamefr from labLookup where testnamefr like '%cd4%' union 
select 'diabetes', labid, testnameen, testnamefr from labLookup where testnamefr like '%urine%' or testnamefr like '%uree%' union
select 'hivtest', labid, testnameen, testnamefr from labLookup where testnamefr like '%hiv%' or testnamefr like '%vih%' union 
select 'malaria', labid, testnameen, testnamefr from labLookup where (testnamefr like '%malaria%' or testnamefr like '%plasmodiun%') union    
select 'pap smear', labid, testnameen, testnamefr from labLookup where testnamefr like '%pap%' or testnamefr like '%frottis%' union  
select 'syphilis', labid, testnameen, testnamefr from labLookup where testnamefr like '%syphilis%' or testnamefr like '%rpr%' union
select 'tuberculosis', labid, testnameen, testnamefr from labLookup where testnamefr like '%tb%'
order by 1,2;  

| wildcard  | labid | testnameen                                          | testnamefr                                      |
+-----------+-------+-----------------------------------------------------+-------------------------------------------------+
| cd4       |    20 | CD4/CD8 ratio                                       | CD4/CD8 ratio                                   | 
| cd4       |   102 | CD4                                                 | CD4                                             | 
| cd4       |   176 | CD4                                                 | CD4                                             | 
| cd4       |  1212 | CD4 en mm3                                          | CD4 en mm3                                      | 
| cd4       |  1213 | CD4 en %                                            | CD4 en %                                        | 
| diabetes  |   136 | Urine                                               | Urine                                           | 
| diabetes  |  1046 | Blood urea nitrogen                                 | Azote de l''Uree                                 | 
| diabetes  |  1047 | Urea                                                | Uree                                            | 
| diabetes  |  1060 | Urea                                                | Uree                                            | 
| hivtest   |    52 | HIV p24 Antigen                                     | HIV p24 Antigen                                 | 
| hivtest   |    53 | HIV-1 Antibody (EIA)                                | HIV-1 Antibody (EIA)                            | 
| hivtest   |    54 | HIV-1 Antibody (WB)                                 | HIV-1 Antibody (WB)                             | 
| hivtest   |    55 | HIV-1 DNA PCR Quantitative (Unspecified)            | HIV-1 DNA PCR Quantitative (Unspecified)        | 
| hivtest   |    56 | HIV-1 RNA Branched DNA version 1.0 Quantitative     | HIV-1 RNA Branched DNA version 1.0 Quantitative | 
| hivtest   |    57 | HIV-1 RNA Branched DNA version 2.0 Quantitative     | HIV-1 RNA Branched DNA version 2.0 Quantitative | 
| hivtest   |    58 | HIV-1 RNA Branched DNA version 3.0 Quantitative     | HIV-1 RNA Branched DNA version 3.0 Quantitative | 
| hivtest   |    59 | HIV-1 RNA Roche Amplicore RT-PCR                    | HIV-1 RNA Roche Amplicore RT-PCR                | 
| hivtest   |    60 | HIV-1 RNA Roche Ultrasensitive RT-PCR               | HIV-1 RNA Roche Ultrasensitive RT-PCR           | 
| hivtest   |    61 | HIV-1 RNA UW RT-PCR                                 | HIV-1 RNA UW RT-PCR                             | 
| hivtest   |    62 | HIV-2 Antibody                                      | HIV-2 Antibody                                  | 
| hivtest   |  1220 | HIV Rapid Test                                      | HIV test rapide                                 | 
| hivtest   |  1221 | HIV Rapid Test                                      | HIV test rapide                                 | 
| hivtest   |  1222 | HIV Rapid Test                                      | HIV test rapide                                 | 
| hivtest   |  1223 | HIV Elisa                                           | HIV Elisa                                       | 
| hivtest   |  1224 | HIV Elisa                                           | HIV Elisa                                       | 
| hivtest   |  1225 | HIV Elisa                                           | HIV Elisa                                       | 
| hivtest   |  1241 | HIV Western Blot                                    | HIV Western Blot                                | 
| hivtest   |  1242 | HIV Western Blot                                    | HIV Western Blot                                | 
| hivtest   |  1243 | HIV Western Blot                                    | HIV Western Blot                                | 
| hivtest   |  1258 | DNA HIV-1                                           | ADN VIH-1                                       | 
| malaria   |   132 | Malaria                                             | Malaria                                         | 
| malaria   |   173 | Malaria                                             | Malaria                                         | 
| malaria   |  1208 | Malaria Smear - Species                             | Recherche de plasmodiun - Especes               | 
| malaria   |  1209 | Malaria Smear - Count Trophozoites(fix these names) | Recherche de plasmodiun - Trophozoit            | 
| malaria   |  1210 | Malaria Smear - Count Gametocytes                   | Recherche de plasmodiun - Gametocyte            | 
| malaria   |  1211 | Malaria Smear - Count Schiztocytes                  | Recherche de plasmodiun - Schizonte             | 
| malaria   |  1314 | Malaria Rapid Test                                  | Malaria Test Rapide                             | 
| malaria   |  1315 | Malaria Test                                        | Malaria Test Rapide                             | 
| malaria   |  1318 | Malaria Rapid Test                                  | Malaria Test Rapide                             | 
| pap smear |   139 | Vaginal smear                                       | Frottis vaginal                                 | 
| pap smear |   178 | Pap test                                            | Pap test                                        | 
| pap smear |  1157 | Vaginal smear Gram stain                            | Frottis Vaginal/Gram                            | 
| pap smear |  1158 | Urethral smear Gram stain                           | Frottis Uretral/Gram                            | 
| syphilis  |    77 | Rapid Plasma Reagin (RPR)                           | Rapid Plasma Reagin (RPR)                       | 
| syphilis  |   129 | RPR                                                 | RPR                                             | 
| syphilis  |   168 | RPR                                                 | RPR                                             | 
| syphilis  |  1316 | Syphilis Test Rapide                                | Syphilis Test Rapide                            | 
| syphilis  |  1317 | Syphilis Test Rapide                                | Syphilis Test Rapide                            | 
| syphilis  |  1319 | Syphilis Test Rapide                                | Syphilis Test Rapide                            | 
| syphilis  |  1323 | Syphilis RPR                                        | Syphilis RPR                                    | 
| syphilis  |  1324 | Syphilis RPR                                        | Syphilis RPR                                    | 
| syphilis  |  1325 | Syphilis TPHA                                       | Syphilis TPHA                                   | 
| syphilis  |  1326 | Syphilis RPR                                        | Syphilis RPR                                    | 
| syphilis  |  1327 | Syphilis TPHA                                       | Syphilis TPHA                                   | 
| syphilis  |  1328 | Syphilis TPHA                                       | Syphilis TPHA                                   | 
| syphilis  |  1348 | Syphilis Bioline                                    | Syphilis Bioline                                | 
| syphilis  |  1349 | Syphilis Bioline                                    | Syphilis Bioline                                | 
| syphilis  |  1350 | Syphilis Bioline                                    | Syphilis Bioline                                |