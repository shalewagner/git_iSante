
INSERT INTO `immunizationLookup` (`immunizationID`, `immunizationCode`, `immunizationNameEn`, `immunizationNameFr`) VALUES
(13, 'Rotavirus', 'Rotavirus', 'Rotavirus'),
(14, 'Pneumocoque', 'Pneumocoque', 'Pneumocoque'),
(15, 'Varicel', 'Varicela', 'Varicel'),
(16, 'Typhimvi', 'Typhimvi', 'Typhimvi'),
(17, 'Menengo', 'Menengo AC', 'Menengo AC'),
(18, 'Hepatite', 'Hepatite A', 'Hepatite A'),
(19, 'Cholera', 'Cholera', 'Cholera');

INSERT INTO `immunizationRendering` (`immunizationRendering_id`, `immunizationID`, `immunizationEncounterType`, `immunizationFormVersion`, `immunizationGroup`, `immunizationOrderEn`, `immunizationOrderFr`, `immunizationCnt`) VALUES
(24, 13, 16, 0, 1, 9, 9, 2),
(25, 14, 16, 0, 1, 10, 10, 3),
(26, 15, 16, 0, 1, 11, 11, 2),
(27, 16, 16, 0, 1, 12, 12, 2),
(28, 17, 16, 0, 1, 13, 13, 2),
(29, 18, 16, 0, 1, 14, 14, 2),
(30, 19, 16, 0, 1, 15, 15, 2),
(31, 13, 17, 0, 1, 9, 9, 2),
(32, 14, 17, 0, 1, 10, 10, 3),
(33, 15, 17, 0, 1, 11, 11, 2),
(34, 16, 17, 0, 1, 12, 12, 2),
(35, 17, 17, 0, 1, 13, 13, 2),
(36, 18, 17, 0, 1, 14, 14, 2),
(37, 19, 17, 0, 1, 15, 15, 2);

update immunizationRendering set immunizationOrderEn=16,immunizationOrderFr=16 where immunizationID=9 and immunizationEncounterType in (16,17);
