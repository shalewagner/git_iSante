<?php
require_once 'backend.php';

/*
**	This function creates a table userTemp (based on input parameters) which can then be used downstream for queries
**	input : report category, report number, language, site, patient status, treatment type, test, start and end dates and optionally patientid
**	output: temporary table named userTemp containing qualifying patientIDs
*/
function applyCriteria ($rtype, $repNum, $site, $pType, $tType, $ttType,
			$start, $end, $patientID, $menuSelection, $gLevel = "") {
        if ($tType == 0) $tType = 1;
	$pArray = getPatientStatusArray ($pType);
	if (DEBUG_FLAG) print_r($pArray);
	$strpType = array ("regart", "missedart", "lostart", "deadart", "discart", "transart", "recentpre", "actifpre", "lostpre", "deadpre", "transpre");
	$strtType = array ("", "any","art","notart", "inh", "cot", "tb", "notenrolled");
	$strttType = array ("", "cd4", "ppd", "radiographie", "crachat", "liver", "blood", "rpr", "hepatit", "pap");
	// run a loop for all the ON values of pType
	// will be modifying the table of patientids on each pass through the loop

	// Grab patient status data using procedure, then use below:
        $patStatus = array ();
        if (DEBUG_FLAG) print "<br>patStatus call: updatePatientStatus( 2," . $end . ")";
        if (!isPatientStatusExist ($end))
          $patStatusRes = updatePatientStatus (2, $end);
        else
          $patStatusRes = getPatientStatusTemp ($end);

        $gLevelSites = array ();
        if ($gLevel > 1 && $site != "All") {
          switch ($gLevel) {
            case 2:
              $queryCol = "clinic";
              break;
            case 3:
              $queryCol = "commune";
              break;
            case 4:
              $queryCol = "department";
              break;
            case 5:
              $queryCol = "network";
              break;
            default:
              $queryCol = "";
              break;
          }
          $query = "SELECT c1.siteCode
                    FROM clinicLookup c1, clinicLookup c2
                    WHERE c1.inCPHR = 1
                     AND c1.$queryCol = c2.$queryCol
                     AND c2.siteCode IN ($site)";
          $result = dbQuery ($query);
          while ($row = psRowFetch ($result)) {
            $gLevelSites[] = $row[0];
          }
        }

        while ($row = psRowFetch ($patStatusRes)) {
          if ($site == "All" ||
              strcmp (substr ($row[0], 0, 5), $site) == 0 ||
              in_array (substr ($row[0], 0, 5), $gLevelSites)) {
            $patStatus[$row[0]] = $row[1];
          }
        }
	if (DEBUG_FLAG) print_r($patStatus);

        // Some reports should be displaying the patient status as it was at
        // the end date of the report range, not just their current status
        $customStatusReports = array (1591, 5005, 5010, 5011, 5012, 5013, 5020, 5021, 5025, 5026, 5027, 5028);

        if (in_array ($repNum, $customStatusReports)) {
          makeCustomStatusTable ($patStatus);
        }

        // Allow reports to be run for multiple sites (higher org. levels)
        if ($site == "All")
          $siteClause = "siteCode like '%'";
        else if ($gLevel > 1 && !empty ($gLevelSites))
          $siteClause = "siteCode in ('" . implode ("', '", $gLevelSites) . "')";
        else
          $siteClause = "siteCode = '$site'";

	$pCounter = true;
	for ($i = 0; $i < 11; $i++) {
		if ($pArray[$i] == 1) {
			$type = $strpType[$i];
			$type2 = $strtType[$tType];
			$type3 = $strttType[$ttType];
			$numDays = "180";
			if ($type2  == "art") $numDays = "90";
			if ($type == "new")  $numDays = "30";
			if ( empty($patientID) ) {
				$stdTarget = "patientid, max(visitDate), count(distinct visitdate)";
				$groupBy = " group by patientid";
				$orderBy = " order by 2 desc";
			} else {
				$stdTarget = "1";
				$orderBy = " and patientid = '" . $patientID . "'";
				$groupBy = " ";
			}

                        // Make a temp table to hold patient statuses instead
                        // of using long lists of patient ids. Also, insert
                        // records one at a time instead of in one giant SQL
                        // statement. Both of these changes (but especially
                        // the latter one) should speed things up considerably.
                        $tempTableNames = createTempTables ("#tempStatuses", 1, "pid varchar(11)", "pid_idx::pid");

			$query = "select " . $stdTarget . " from v_patients p, " . $tempTableNames[1] . " q where visitdate <= '$end' and p.patientid = q.pid ";
			$onART = "select patientid from pepfarTable where visitdate <= '" . $end . "' AND (forPepPmtct = 0 OR forPepPmtct IS NULL)";
			if (DEBUG_FLAG) echo "<br>" . $query . "/" . $onART . "<br>";

			/* here's the patient status block
			** status definitions */
			if ($type == "regart" && count (array_keys($patStatus, 6)) > 0) {						   
                                $qvals = array_merge(array_keys($patStatus, 6));
			} else if ($type == "missedart" && count (array_merge (array_keys ($patStatus, 8))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 8));
			} else if ($type == "lostart" && count (array_merge (array_keys ($patStatus, 9))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 9));				 
			} else if ($type == "deadart" && count (array_merge (array_keys ($patStatus, 1))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 1));
			} else if ($type == "discart" && count (array_merge (array_keys ($patStatus, 3))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 3));
			} else if ($type == "transart" && count (array_merge (array_keys ($patStatus, 2))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 2));
			} else if ($type == "recentpre" && count (array_merge (array_keys ($patStatus, 7))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 7));
			} else if ($type == "actifpre" && count (array_merge (array_keys ($patStatus, 11))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 11));
			} else if ($type == "lostpre" && count (array_merge (array_keys ($patStatus, 10))) > 0) {
                                $qvals = array_merge(array_keys($patStatus, 10));
			} else if ($type == "deadpre" && count (array_merge (array_keys ($patStatus, 4))) > 0) {
				$qvals = array_merge(array_keys($patStatus, 4));
			} else if ($type == "transpre" && count (array_merge (array_keys ($patStatus, 5))) > 0) {
				$qvals = array_merge(array_keys($patStatus, 5));								
			} else {
				continue;
			}
			if (DEBUG_FLAG) print_r($qvals);
			$qquery = "insert into " . $tempTableNames[1] . " (pid) values ";
			foreach ($qvals as $val) {
				$qry = $qquery . "('" . $val . "')";
	                	dbQuery ($qry);
            		}

			/* here's the treatment block
			** treatment definitions
			*/
			$notEnrolled = "(patientid in (select patientid from cd4Table where cd4 < 200 and cd4 <> 0 and visitdate < '" . CD4_350_DATE . "' union select patientid from cd4Table where cd4 < 350 and cd4 <> 0 and visitdate >= '" . CD4_350_DATE . "') or
			patientid in (select patientid from v_labsCompleted where testnameen = 'lymphocytes' and result <= '1200' and result <> '')
			or (patientid in (select patientid from cd4Table where cd4 < 200 and cd4 <> 0 and visitdate < '" . CD4_350_DATE . "' union select patientid from cd4Table where cd4 < 350 and cd4 <> 0 and visitdate >= '" . CD4_350_DATE . "') and
			patientid in (select patientid from v_conditions where conditionGroup = 3)
			) or patientid in (select patientid from v_conditions where conditionGroup = 4) or
			patientid in (select distinct patientid from v_medicalEligARVs where medElig in (1,2)))
			and patientid not in (" . $onART . ") and visitDate <= '" . $end . "' ";
			$inh = "select patientID from drugTable d, drugLookup l where d.drugID = l.drugID and drugName = 'isoniazid'";
			$notInh = " select patientID from drugTable d, drugLookup l where d.drugID = l.drugID and drugGroup = 'anti-tb' and drugName != 'isoniazid' ";
			$onCot = "select patientID from drugTable where drugID in (9, 69, 70)";
			$onTB = "select patientID from v_drugs where drugName in ('ethambutol','isoniazide','pyrazinamide','rifampicine','streptomycine') group by patientid having count(distinct drugName) >= 4";
			/*
			if ($type2 == "art")
				$query .= " and patientid in (" . $onART . ")";
			else if ($type2 == "notart")
				$query .= " and patientid not in  (" . $onART . ")";
			else if ($type2 == "notenrolled")
				$query .= " and " . $notEnrolled;*/
			if ($type2 == "any")
				$query .= " and 1 = 1";
			else if ($type2 == "inh")
				$query .= " and patientid in (" .  $inh . ") and patientid not in (" . $notInh . ") ";
			else if ($type2 == "cot")
				$query .= " and patientid in (" . $onCot . ")";
			else if ($type2 == "tb")
				$query .= " and patientid in (" . $onTB . ")";

			$query .= $groupBy;
			$query .= $orderBy;

			if ($pCounter) {
				if (DEBUG_FLAG) print "<br>Make tempTable query" . $i . ": " . $query . "+++<br>";
				if ($type3 != "" && $type3 != "none")
					$tableName = makeTable("temp1", $query);
				else
					$tableName = makeTable("temp", $query);
				$pCounter = false;
			} else {
				if (DEBUG_FLAG) print "<br>Insert tempTable (" . $tableName . ") query" . $i . ": " . $query . "+++<br>";
				dbQuery("insert into " . $tableName . " " . $query);
			}
		} // end of if loop
	}  // end of for loop

        // If $tableName is empty here, there were no matching patients based
        // on desired statuses, so there will be no results, create empty tables
        // and bail out
        if (empty ($tableName)) {
          $tableName = makeTable ("temp1", "select NULL, NULL, NULL");
          $tableName = makeTable ("temp", "select NULL, NULL, NULL");
          return;
        }

	if ($type3 != "" && $type3 != "none")
		addTests ($tableName, $repNum, $type2, $type3, $end, $menuSelection, $siteClause);

        if ($repNum == 5010 || $repNum == 5011 || $repNum == 5012 || $repNum == 5013) {
          // build a temp table of TB data
          $tmp_results = array ();
          $results = array ();
	  $user = substr(getSessionUser(), 0, 3);
          $name = "tbTemp";

          // Check for TB drugs
          $query = "select patientID, visitdate, dispDateMm, dispDateDd, dispDateYy from v_prescriptions where $siteClause and encounterType in (5, 18) and drugID in (13, 18, 24, 25, 30) and dispensed = 1 order by patientID asc";
	  $result = dbQuery ($query);
          $pid = 0;
          $oldDate = 0;
          $newDate = 0;
          while ($row = psRowFetch ($result)) {
            // use disp date if valid, else visit date
            if (strtotime ($row[2] . "/" . $row[3] . "/" . $row[4])) {
              $newDate = strtotime ($row[2] . "/" . $row[3] . "/" . $row[4]);
            } else {
              $newDate = strtotime ($row[1]);
            }
            if ($newDate > strtotime ($end) || $newDate < strtotime ($start)) continue;

            // if already seen patientID, only update if date is newer
            if ($pid == $row[0] && $newDate <= $oldDate) continue;
            $pid = $row[0];
            $oldDate = $newDate;
            $results[$row[0]][4] = date ("Y-m-d", $oldDate);
          }

          if ($repNum == 5010) {
            // Check for no TB, currently in treatment, suspected TB
            $query = "select patientID, visitDate, asymptomaticTb, completeTreat, currentTreat, currentProp, noTBsymptoms, propINH, suspectedTb, suspicionTBwSymptoms from v_tbStatus where $siteClause and visitDate between '" . $start . "' and '" . $end . "' and encounterType in (1, 2, 16, 17) and (asymptomaticTb = 1 or completeTreat = 1 or currentTreat = 1 or currentProp = 1 or noTBsymptoms = 1 or propINH = 1 or suspectedTb = 1 or suspicionTBwSymptoms = 1) order by patientID asc, visitDate desc";
	    $result = dbQuery ($query);
            $pid = 0;
            while ($row = psRowFetch ($result)) {
              // if already seen patientID, skip (only want most recent encounter)
              if ($pid == $row[0]) continue;
              $pid = $row[0];
              if ($row[2] == 1 || $row[3] == 1 || $row[4] == 1 || $row[5] == 1 ||
                  $row[6] == 1 || $row[7] == 1) {
                $results[$row[0]][0] = $row[1];
              }
              if ($row[8] == 1 || $row[9] == 1) {
                $results[$row[0]][1] = $row[1];
              }
            }

            // Check for symptoms of TB at most recent encounter
	    // now using concept dictionary for symptoms instead of symptoms table
            //$query = "select patientID, visitDate, cough3WeeksEqualMore, cough3WeeksLess, cough, expectoration, hemoptysie, nightsweats, feverLessMo, feverPlusMo from v_symptoms where visitDate between '" . $start . "' and '" . $end . "' and encounterType in (1, 2, 16, 17) order by patientID asc, visitDate desc";
            $query = "select e.patientID, e.visitDate from encValid e, concept c, obs o where e.$siteClause and e.encounter_id = o.encounter_id and c.concept_id = o.concept_id and c.short_name in ('cough3WeeksEqualMore', 'cough3WeeksLess', 'cough', 'expectoration', 'hemoptysie', 'nightsweats', 'feverLessMo', 'feverPlusMo') and e.visitDate between '" . $start . "' and '" . $end . "' and e.encounterType in (1, 2, 16, 17) order by e.patientID asc, e.visitDate desc";
	    $result = dbQuery ($query);
            $pid = 0;
            while ($row = psRowFetch ($result)) {
              // if already seen patientID, skip (only want most recent encounter)
              if ($pid == $row[0]) continue;
              $pid = $row[0];
              //if (($row[2] == 1 || (($row[3] == 1 || $row[4] == 1) && $row[5] == 1) || $row[6] == 1) && $row[7] == 1 && ($row[8] == 1 || $row[9] == 1)) {
                $results[$row[0]][1] = $row[1];
              //}
            }

            // Check for any TB labs
            $query = "select patientID, visitDate, resultDateMm, resultDateDd, resultDateYy from v_labsCompleted where $siteClause and encounterType in (6, 19) and labID in (131, 137, 169) order by patientID asc";
	    $result = dbQuery ($query);
            $pid = 0;
            $oldDate = 0;
            $newDate = 0;
            while ($row = psRowFetch ($result)) {
              // use result date if valid, else visit date
              if (strtotime ($row[2] . "/" . $row[3] . "/" . $row[4])) {
                $newDate = strtotime ($row[2] . "/" . $row[3] . "/" . $row[4]);
              } else {
                $newDate = strtotime ($row[1]);
              }
              if ($newDate > strtotime ($end) || $newDate < strtotime ($start)) continue;

              // if already seen patientID, only update if date is newer
              if ($pid == $row[0] && $newDate <= $oldDate) continue;
              $pid = $row[0];
              $oldDate = $newDate;
              $results[$row[0]][5] = date ("Y-m-d", $oldDate);
            }
          }

          if ($repNum == 5011 || $repNum == 5012) {
            // Check for abnormal TB labs
            $query = "select patientID, visitDate, resultDateMm, resultDateDd, resultDateYy from v_labsCompleted where $siteClause and resultAbnormal = 1 and encounterType in (6, 19) and labID in (131, 137, 169) order by patientID asc";
	    $result = dbQuery ($query);
            $pid = 0;
            $oldDate = 0;
            $newDate = 0;
            while ($row = psRowFetch ($result)) {
              // use result date if valid, else visit date
              if (strtotime ($row[2] . "/" . $row[3] . "/" . $row[4])) {
                $newDate = strtotime ($row[2] . "/" . $row[3] . "/" . $row[4]);
              } else {
                $newDate = strtotime ($row[1]);
              }
              if ($newDate > strtotime ($end) || $newDate < strtotime ($start)) continue;

              // if already seen patientID, only update if date is newer
              if ($pid == $row[0] && $newDate <= $oldDate) continue;
              $pid = $row[0];
              $oldDate = $newDate;
              $results[$row[0]][2] = date ("Y-m-d", $oldDate);
            }

            // Check for TB diagnoses
            $query = "select patientID, visitDate, conditionMm, conditionYy from v_conditions where $siteClause and encounterType in (1, 2, 16, 17) and conditionID in (20, 21, 41, 208, 397, 405, 409, 423) and conditionActive != 2 and conditionActive is not null order by patientID asc";
	    $result = dbQuery ($query);
            $pid = 0;
            $oldDate = 0;
            $newDate = 0;
            while ($row = psRowFetch ($result)) {
              // use onset date if valid, else visit date
              if (strtotime ($row[2] . "/15/" . $row[3])) {
                $newDate = strtotime ($row[2] . "/15/" . $row[3]);
              } else {
                $newDate = strtotime ($row[1]);
              }
              if ($newDate > strtotime ($end) || $newDate < strtotime ($start)) continue;

              // if already seen patientID, only update if date is newer
              if ($pid == $row[0] && $newDate <= $oldDate) continue;
              $pid = $row[0];
              $oldDate = $newDate;
              $results[$row[0]][3] = date ("Y-m-d", $oldDate);
            }
          }

          if ($repNum == 5013) {
            // Check for completed TB
            $query = "select patientID, visitDate, completeTreat, completeTreatMm, completeTreatDd, completeTreatYy from v_tbStatus where $siteClause and visitDate between '" . $start . "' and '" . $end . "' and encounterType in (1, 2, 16, 17) and completeTreat = 1 order by patientID asc, visitDate desc";
	    $result = dbQuery ($query);
            $pid = 0;
            $oldDate = 0;
            $newDate = 0;
            while ($row = psRowFetch ($result)) {
              // use complete date if valid, else visit date
              if (strtotime ($row[3] . "/" . $row[4] . "/" . $row[5])) {
                $newDate = strtotime ($row[3] . "/" . $row[4] . "/" . $row[5]);
              } else {
                $newDate = strtotime ($row[1]);
              }
              if ($newDate > strtotime ($end) || $newDate < strtotime ($start)) continue;

              // if already seen patientID, skip (only want most recent encounter)
              if ($pid == $row[0]) continue;
              $pid = $row[0];
              $results[$row[0]][6] = $row[1];
            }
          }

		$tableName = TEMP_DB . "." . $name . $user;
		$tempQry = "drop table if exists " . $tableName;
		dbQuery ($tempQry);
		$tempQry = "create table " . $tableName . " (patientID varchar(11), noTBDate date NULL, suspectTBDate date NULL, abnormalLabsDate date NULL, diagTBDate date NULL, tbDrugsDate date NULL, tbLabsDate date NULL, completeTBDate date NULL); ";
                dbQuery ($tempQry);

 		foreach ($results as $pid => $row) {
                  dbQuery ("insert " . $tableName . " values ('" . $pid . "', " . (empty ($row[0]) ? "NULL" : "'" . $row[0] . "'") . ", " . (empty ($row[1]) ? "NULL" : "'" . $row[1] . "'") . ", " . (empty ($row[2]) ? "NULL" : "'" . $row[2] . "'") . ", " . (empty ($row[3]) ? "NULL" : "'" . $row[3] . "'") . ", " . (empty ($row[4]) ? "NULL" : "'" . $row[4] . "'") . ", " . (empty ($row[5]) ? "NULL" : "'" . $row[5] . "'") . ", " . (empty ($row[6]) ? "NULL" : "'" . $row[6] . "'") . ")");
		}
        }

        if ($repNum == 5026 || $repNum == 5027) {
          // build a temp table of regimen changes
	  $user = substr(getSessionUser(), 0, 3);
          $name = "regimenTemp";
          $query = "select p1.patientid, p1.visitDate, p1.regimen from pepfarTable p1, pepfarTable p2 where p1.$siteClause and p1.patientid = p2.patientid and p1.visitDate != p2.visitDate and p1.regimen != p2.regimen and p1.visitDate between '$start' and '$end' and p2.visitDate between '$start' and '$end' group by p1.patientid, p1.visitDate, p1.regimen order by 1,2,3";
	  $result = dbQuery ($query);
          $tmp_results = array ();
          $results = array ();
          $tmp_cnt = 0;
          $cnt = 0;
          $pid = 0;
          while ($row = psRowFetch ($result)) {
            // if new patientID, add initial row to temp result set
            if ($pid != $row[0]) {
              // flush temp results to final results and reset temp
              if (count ($tmp_results) > 1) {
                $results[$cnt] = $tmp_results[$tmp_cnt - 1];
                $cnt++;
              }
              $tmp_results = array ();
              $tmp_cnt = 0;
              $pid = $row[0];
              $tmp_results[$tmp_cnt] = $row;
              $tmp_cnt++;
              continue;
            }

            // if same visitDate or regimen, skip
            if (strcmp ($tmp_results[$tmp_cnt - 1][1], $row[1]) == 0 ||
                strcmp ($tmp_results[$tmp_cnt - 1][2], $row[2]) == 0) {
              continue;
            }

            // else, see if the regimen is different in the way we want
            // if so, add row to temp result set and previous row to final set
            $regKeep = "";
            $same = 0;
            $prevReg = explode ("-", $tmp_results[$tmp_cnt - 1][2]);
            $currReg = explode ("-", $row[2]);
            foreach ($prevReg as $drug) {
              if (in_array ($drug, $currReg)) $same++;
            }
            switch ($same) {
              case 2:
                $regKeep = "subst";
                break;
              default:
                $regKeep = "switch";
                break;
            }
            if (($repNum == 5026 && strcmp ($regKeep, "subst") == 0) ||
                ($repNum == 5027 && strcmp ($regKeep, "switch") == 0)) {
              $tmp_results[$tmp_cnt] = $row;
              $results[$cnt] = $tmp_results[$tmp_cnt - 1];
              $tmp_cnt++;
              $cnt++;
            }
          }

	  $tableName = TEMP_DB . "." . $name . $user;
	  if (DEBUG_FLAG) echo "***" . $tableName . "***";
	  $tempQry = "drop table if exists " . $tableName;
	  if (DEBUG_FLAG) echo "<P>Executing: drop table if exists " . $tableName . "</P>\n";
	  dbQuery ($tempQry);
	  $tempQry = "create table " . $tableName . " (patientID varchar(11), visitDate date null, regimen varchar (64) null)";
	  if (DEBUG_FLAG) echo "***" . $tempQry . "***"; 
  	  dbQuery ($tempQry);
 	  foreach ($results as $row) {
            $tempQry = "insert " . $tableName . " values ('" . $row[0] . "', '" . $row[1] . "', '" . $row[2] . "') ";
	    if (DEBUG_FLAG) print "<br>regimenTempTable query: " . $tempQry . "<br>";
	    dbQuery($tempQry);
          }
        }

        if ($repNum == 5028) {
          // build a temp table of discontinued drugs
	  	  $user = substr(getSessionUser(), 0, 3);
          $name = "discTemp";
          $query = "select distinct d.patientID, d.stopMm, d.stopYy, d.toxicity,
          d.intolerance, d.failure, d.stockOut, d.pregnancy,
          d.patientHospitalized, d.lackMoney, d.alternativeTreatments,
          d.missedVisit, d.patientPreference, d.failureVir, d.failureImm,
          d.failureClin, d.failureProph, d.discUnknown, d.interUnk, d.finPTME,
          l.drugLabelen, l.drugLabelfr from
          drugs d, encValid e, drugLookup l, pepfarTable p where
          e.$siteClause and
          p.patientID = d.patientID and
          d.patientID = e.patientID and
          d.drugID = l.drugID and
          l.drugGroup in ('NRTIs', 'NNRTIs', 'Pls') and
          (isdate(dbo.ymdToDate(stopYy, stopMm, '01')) = 1 or
          d.toxicity = 1 or d.intolerance = 1 or d.failure = 1 or
          d.stockOut = 1 or d.pregnancy = 1 or d.patientHospitalized = 1 or
          d.lackMoney = 1 or d.alternativeTreatments = 1 or d.missedVisit = 1 or
          d.patientPreference = 1 or d.failureVir = 1 or d.failureImm = 1 or
          d.failureClin = 1 or d.failureProph = 1 or d.discUnknown = 1 or
          d.interUnk = 1 or d.finPTME = 1)";
	  $result = dbQuery ($query);

          $discXref = array (
                        "en" => array (
                          "Toxicity",
                          "Intolerance",
                          "Failure",
                          "Out of stock",
                          "Pregnancy",
                          "Patient was hospitalized",
                          "Lack of money/insurance",
                          "Alternative treatment",
                          "Missed appointment",
                          "Patient preference",
                          "Virological failure",
                          "Immunological failure",
                          "Clinical failure",
                          "Prophylactic use",
                          "Unknown",
                          "Unknown",
			  "Finished PMTCT"),
                        "fr" => array (
                          "Toxicit&#xe9;",
                          "Intol&#xe9;rance",
                          "&#xc9;chec",
                          "Rupture de stock",
                          "Grossesse",
                          "Patient a &#xe9;t&#xe9; hospitalis&#xe9;",
                          "Manque d''argent",
                          "Th&#xe9;rapies alternatives",
                          "Manque de rendez-vous",
                          "Pr&#xe9;f&#xe9;rence du patient",
                          "&#xc9;chec virologique",
                          "&#xc9;chec immunologique",
                          "&#xc9;chec clinique",
                          "Usage pour prophylaxie",
                          "Inconnu",
                          "Inconnu",
			  "Fini PTME")
                      );
          $results = array ();
          $cnt = 0;
          while ($row = psRowFetch ($result)) {
            // pull out data we're interested in and put in final array
            if (strcasecmp ($row[1], "xx") == 0) $row[1] = 6;
            if (strcasecmp ($row[2], "xx") == 0) continue;
            if (checkdate ((int)trim($row[1]), 1, (int)trim($row[2]))) {
              if (strtotime (zpad (trim($row[1]), 2) . "/01/" . assumeYear (trim($row[2]))) <= strtotime ($end) && strtotime (zpad (trim($row[1]), 2) . "/01/" . assumeYear (trim($row[2]))) >= strtotime ($start))
                $results[$cnt] = array ($row[0], "'" . assumeYear (trim($row[2])) . "-" . zpad (trim($row[1]), 2) . "-01'");
              else
                continue;
            }
            else
              $results[$cnt] = array ($row[0], "NULL");

            if (strcmp ($_GET['lang'], "en") == 0)
              array_push ($results[$cnt], $row[20]);
            else
              array_push ($results[$cnt], $row[21]);

            $failList = array ();
            for ($i = 3; $i <= 19; $i++) {
              if ($row[$i] == 1) array_push ($failList, $discXref[$_GET['lang']][$i - 3]);
            }
            // Need to limit failList length to 255 else db truncation
            $tempStr = substr (implode (", ", $failList), 0, 254);
            array_push ($results[$cnt], $tempStr);
            $cnt++;
          }

	$tableName = TEMP_DB . "." . $name . $user;
	$check = "drop table if exists " . $tableName . "; create table " . $tableName . " (patientID varchar(11), stopDate date null, drugName varchar (255), failList varchar (255) null)";
	$tempQry = $check ."; delete from " . $tableName . "; ";
	if (DEBUG_FLAG) print "<br>discTempTable query: " . $tempQry . "<br>";
	dbQuery($tempQry);
	$tempQry = "";

        // Limit compound insert statements to 50 to avoid query length limits
        $limit = 50;
        $count = 1;
	foreach ($results as $row) {
          if ($count > $limit) {
	    if (DEBUG_FLAG) print "<br>discTempTable query: " . $tempQry . "<br>";
	    dbQuery($tempQry);
            $tempQry = "";
            $count = 1;
          }
	  $tempQry .= "insert " . $tableName . " values ('" . $row[0] . "', " . $row[1] . ", '" . $row[2] . "', '" . $row[3] . "'); ";
          $count++;
	}
	if (DEBUG_FLAG) print "<br>discTempTable query: " . $tempQry . "<br>";
	if (!empty ($tempQry)) dbQuery($tempQry);
        }
}

function doStringSubstitutions ($qry, $site, $start, $end, $pid, $network='', $user=null) {
  //replace the '$site', '$start', '$end', '$pid', '$lang', '$user', '$network', '$user', '$days_in_year', '$computed_age', '$localized_gender' variables that are inside query strings
  if (is_null($user)) {
    $user = substr(getSessionUser(),0,3);
  }
  $qry = str_replace('$site', $site, $qry);
  $qry = str_replace('$network', $network, $qry); 
  $qry = str_replace('$start', $start, $qry);
  $qry = str_replace('$end', $end, $qry);
  $qry = str_replace('$pid', $pid, $qry);
  $qry = str_replace('$lang', $GLOBALS['lang'], $qry);
  $qry = str_replace('$user', $user, $qry);
  $qry = str_replace('\$user', $user, $qry);
  $qry = str_replace('$days_in_year', DAYS_IN_YEAR, $qry);
  $qry = str_replace('$computed_age', "CASE WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, '06', '15')) = 1 THEN DATEDIFF(year, dbo.ymdToDate(dobYy, '06', '15'), GETDATE()) WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '15')) = 1 THEN DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, '15'), GETDATE()) WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1 THEN DATEDIFF(year, dbo.ymdToDate(dobYy, dobMm, dobDd), GETDATE()) ELSE 'N/A' END", $qry);
  $qry = str_replace('$localized_gender', str_replace ('lang', $GLOBALS['lang'], GENDER_TARGET), $qry);
  return ($qry);
}

function genSemiAnnual ($rtype, $repNum, $site, $pStatus, $tStatus, $tType, $start, $end, $pid, $menuSelection) {
	$user = substr(getSessionUser(),0,3);
	include ("semiQueries.php");
	$testname = array ("", "CD4", "PPD", "Chest X-Ray", "Sputum", "ALT/SGOT", "platelets", "%RPR", "Hepatitis", "Pap test");
	$testClause = array (
		"",
		"cd4Table",
		"v_labsCompleted where testnameen like 'PPD%' ",
		"v_labsCompleted where testnameen = 'Chest X-Ray' ",
		"v_labsCompleted where testnameen = 'Sputum' ",
		"v_labsCompleted where testnamefr in ('ALT/SGPT', 'AST/SGOT') ",
		"v_bloodEval ",
		"v_labsCompleted where testnameen like '%RPR' ",
		"v_labsCompleted where testnameen like 'Hepatitis B%' or testnameen like 'Hepatitis C%' ",
		"v_labsCompleted where testnameen = 'Pap test' "
	);
	$qry = str_replace('$labtest', $testClause[$tType], $query[$repNum][0]);
	//if (DEBUG_FLAG) print "<br>temp0: " . $qry;
	$tableName = makeTable ("temp", $qry);
	$qry = doStringSubstitutions ($query[$repNum][1], $site, $start, $end, $pid);
	//if (DEBUG_FLAG) print "<br>temp1: " . $qry;
	$tableName1 = makeTable ("temp1", $qry);
        $tableName2 = "";
	for ($i = 2; $i <= count ($query[$repNum]) - 1; $i++) {
		$curQuery = doStringSubstitutions ($query[$repNum][$i], $site, $start, $end, $pid);
                // 5040 is a special case because the eligibility criteria
                // are different depending on whether they're measured prior
                // to or after CD4_350_DATE.  Therefore, we need two tables
                // to hold minimum eligibility dates based on criteria version.
                if ($repNum == "5040") {
                        $tableName2 = makeTable ("temp" . $i, $curQuery);
                } else {
		        if (DEBUG_FLAG) print "<br>temp" . $i . ": " . $curQuery;
		        dbQuery($curQuery);
                }
	}

        $today = getdate ();
        $yrSt = 2004;
        $yrEnd = $today['year'] - 1;

        $bucketLabels = array ("en" => array (), "fr" => array ());
        $bucketArray = array ();
        for ($i = $yrSt; $i <= $yrEnd; $i++) {
          if ($today['year'] >= $i) {
            $strArr = array ("en" => $i . ", 1st half", "fr" => $i . ", 1er 6 mois");
            $bucketLabels["en"][] = $strArr["en"];
            $bucketLabels["fr"][] = $strArr["fr"];
            $bucketArray[$strArr[$_GET['lang']]] = array ($i . "-01-01", $i . "-06-30");
            if ($today['year'] > $i || $today['mon'] >= 7) {
              $strArr = array ("en" => $i . ", 2nd half", "fr" => $i . ", 2ème 6 mois");
              $bucketLabels["en"][] = $strArr["en"];
              $bucketLabels["fr"][] = $strArr["fr"];
              $bucketArray[$strArr[$_GET['lang']]] = array ($i . "-07-01", $i . "-12-31");
            }
          }
        }

	// generate denominator array
        $caseStmt = "";
        $caseStmt2 = "";
	foreach ($bucketArray as $casePeriod => $caseRange)
                if ($repNum == "5040") {
                        if (strtotime ($caseRange[1]) <= strtotime (CD4_350_DATE)) {
                                $caseStmt .= "when q.maxDate between '" . $caseRange[0] . "' and '" . $caseRange[1] . "' then '" . $casePeriod . "' ";
                        } else {
                                $caseStmt2 .= "when q.maxDate between '" . $caseRange[0] . "' and '" . $caseRange[1] . "' then '" . $casePeriod . "' ";
                        }
                } else {
		        $caseStmt .= "when q.maxDate between '" . $caseRange[0] . "' and '" . $caseRange[1] . "' then '" . $casePeriod . "' ";
                }
	$qry = "select siteCode, case $caseStmt end as period,
	count(distinct q.patientid) as numPatients
	from $tableName1 q, clinicLookup c where siteCode = left(q.patientid,5) and q.maxDate between '$yrSt-01-01' and '" . ($repNum == "5040" ? date("Y", strtotime(CD4_350_DATE)) : $yrEnd) . "-12-31'
	group by siteCode, case $caseStmt end";
        if ($repNum == "5040")
                $qry .= " union select siteCode, case $caseStmt2 end as period,
	        count(distinct q.patientid) as numPatients
	        from $tableName2 q, clinicLookup c where siteCode = left(q.patientid,5) and q.maxDate between '" . (date("Y", strtotime(CD4_350_DATE)) + 1) . "-01-01' and '$yrEnd-12-31'
	        group by siteCode, case $caseStmt2 end";
        $qry .= " order by 1,3";

	if (DEBUG_FLAG) print "<p>Denominator Query: " . $qry;

	/*  Here are the tests we are doing for numerator/denominator
	**  5030 ever had test # had test/# n,a
	**  5031 followup test varies by test
	**  5040 ART dispensed within 3 months (90 days) of qualifying
	**  5041 CTX dispensed within 3 months (90 days) of qualifying
	**  5042 CTX continued 1 dispense in last 2 months of period/1st dispense
	**  5043 TB treatment drugs dispensed within 3 months (90 days) of qualifying
	**  5044 TB continued 1 dispense of at least 2 drugs during last 2 months of period
	**  5045 ever had PCP sometime in the period (no test)
	**  5046 ever had TB sometime in the period (no test)
	*/

	// run the denominator query and put the results in the finalArray
	$result = dbQuery ($qry);
	$finalArray = array();
	while ($row = psRowFetch ($result)) {
                if (!isset ($finalArray[$row['siteCode']])) {
                  $finalArray[$row['siteCode']] = array ();
                }
		$finalArray[$row['siteCode']][$row["period"]] = array (0, $row["numPatients"]);
        }

	// numerator query
	$artDays = 150;
	$ccDays = 150;
	if ($tType == 1 || $tType == 5) {
		$artDays = 240;
		$ccDays = 420;
	}

        $caseStmt = "";
        $caseStmt2 = "";
	foreach ($bucketArray as $casePeriod => $caseRange) {
		$numeratorTerm = "";
		switch ($repNum) {
		case "5031":
		    $numeratorTerm = " and ((datediff(dd,s.maxDate,'" . $caseRange[1] . "') <= " . $artDays . " and s.visitCnt = 1) or (datediff(dd,s.maxDate,'" . $caseRange[1] . "') <= " . $ccDays . " and s.visitCnt = 0)) ";
			break;
		case "5040":
		case "5041":
		case "5043":
			$numeratorTerm = " and datediff(dd,s.maxDate,q.maxDate) <= 90 ";
		}
                if ($repNum == "5040") {
                        if (strtotime ($caseRange[1]) <= strtotime (CD4_350_DATE)) { 
		                $caseStmt .= "when q.maxDate between '" . $caseRange[0] . "' and '" . $caseRange[1] . "' and q.patientid = s.patientid " . $numeratorTerm . " then '" . $casePeriod . "' ";
                        } else {
		                $caseStmt2 .= "when q.maxDate between '" . $caseRange[0] . "' and '" . $caseRange[1] . "' and q.patientid = s.patientid " . $numeratorTerm . " then '" . $casePeriod . "' ";
                        }
                } else {
		        $caseStmt .= "when q.maxDate between '" . $caseRange[0] . "' and '" . $caseRange[1] . "' and q.patientid = s.patientid " . $numeratorTerm . " then '" . $casePeriod . "' ";
                }
	}
	$qry = "select siteCode, case $caseStmt end as period,
	count(distinct s.patientid) as numPatients from $tableName s, $tableName1 q, clinicLookup c
	where siteCode = left(q.patientid,5) and s.patientid = q.patientid and q.maxDate between '$yrSt-01-01' and '" . ($repNum == "5040" ? date("Y", strtotime(CD4_350_DATE)) : $yrEnd) . "-12-31' and s.maxDate between '$yrSt-01-01' and '" . ($repNum == "5040" ? date("Y", strtotime(CD4_350_DATE)) : $yrEnd) . "-12-31'
	group by siteCode, case $caseStmt end";
        if ($repNum == "5040")
                $qry .= " union select siteCode, case $caseStmt2 end as period,
                count(distinct s.patientid) as numPatients
                from $tableName s, $tableName2 q, clinicLookup c where siteCode = left(q.patientid,5) and s.patientid = q.patientid and q.maxDate between '" . (date("Y", strtotime(CD4_350_DATE)) + 1) . "-01-01' and '$yrEnd-12-31' and s.maxDate between '" . (date("Y", strtotime(CD4_350_DATE)) + 1) . "-01-01' and '$yrEnd-12-31'
                group by siteCode, case $caseStmt2 end";
        $qry .= " order by 1,3";

	if (DEBUG_FLAG) print "<p>numerator: " . $qry;

	// run the numerator query
	$result = dbQuery ($qry);
	while ($row = psRowFetch ($result))
		$finalArray[$row['siteCode']][$row["period"]][0] = $row["numPatients"];

	// create/zero the finalSemiYear table
	$tableName = makeATable ("finalSemiYear", "siteCode char(5), timeperiod varchar(64), numerator int, denominator int, percentage int");

	//if (DEBUG_FLAG) print "<table border=\"1\"><tr><th>Site-Period</th><th>Num</th><th>Den</th><th>%</th></tr>";
	foreach ($finalArray as $key => $result) {
          foreach ($result as $period => $values) {
	    if ($values[1] != "") {
		//if (DEBUG_FLAG) print "<tr><td>" . $key . "</td><td>" . $result[0] . "</td><td>" . $result[1] . "</td><td>" . number_format($result[0]/$result[1]*100) . "</td></tr>";
//		$parts = explode("-", $key);
//		dbQuery("insert into " . $tableName . " values ('" . $parts[0] . "','" . $parts[1] . "'," . $result[0] . "," . $result[1] . "," . number_format($result[0]/$result[1]*100) . ")");
		dbQuery("insert into " . $tableName . " values ('" . $key . "','" . $period . "'," . $values[0] . "," . $values[1] . "," . number_format($values[0]/$values[1]*100) . ")");
            }
	  }
	}
	//if (DEBUG_FLAG) print "</table>";
	return ($tableName);
}

function makeATable ($name, $createCols) {
	$user = substr(getSessionUser(), 0, 3);
	$tableName = TEMP_DB . "." . $name . $user;

	$check = "drop table if exists " . $tableName . "; create table " 
	  . $tableName . " (" . $createCols . ")";

	$tempQry = $check ."; delete from " . $tableName;
	dbQuery($tempQry);
	return ($tableName);
}

function prepareReportQueries($xmlRep, $rtype, $repNum, $lang, $site, $pStatus, $tStatus, $tType,
			      $gLevel, $oLevel, $start, $end, $pid, $ddValue,
			      $nForms, $creator, $order, $oDir, $user=null) {
  $tableName =  '';
  $menuSelection = $xmlRep[0]->menuSelection;

  if (strtotime ($end) > strtotime (date ("Y-m-d"))) $end = date ("Y-m-d");
  if ($pStatus + $tStatus + $tType + $gLevel + $oLevel == 0) {
    if ($repNum > 600 && $repNum < 604) {
      // These reports need a custom patient status table created
      // First get patient status data
      $patStatus = array ();
      if (DEBUG_FLAG) print "<br>patStatus call: updatePatientStatus( 2," . $end . ")";
      if (!isPatientStatusExist ($end))
        $patStatusRes = updatePatientStatus (2, $end);
      else
        $patStatusRes = getPatientStatusTemp ($end);

      while ($row = psRowFetch ($patStatusRes)) {
        if (strcmp (substr ($row[0], 0, 5), $site) == 0) {
          $patStatus[$row[0]] = $row[1];
        }
      }

      // Now make table
      makeCustomStatusTable ($patStatus);
    }

    $queryTable = $xmlRep[0]->query;
    if ($menuSelection == 'dateToday' || $menuSelection == 'dateDisplay') {
      $start = '2001-01-01';
      $end = date('Y-m-d');
    }
    if ($repNum == 510) {
      $queryTable = str_replace('$nForms', $nForms, $queryTable);
      $queryTable = str_replace('$creator', $creator, $queryTable);
    }
    $queryTable = doStringSubstitutions($queryTable, $site, $start, $end, $pid, $ddValue, $user);
  } else {
    if ($rtype == 'clinicalCare' || $rtype == 'qualityCare') {
      // for new/active/atrisk/inactive/disc patients reporting
      // this generates $usrtemp/$usrtemp1 tables using $pstatus, $tStatus, $tType
      if ($repNum > 5029 && $repNum < 5047) {
	$tableName = genSemiAnnual($rtype, $repNum, $site, $pStatus, $tStatus,
				   $tType, $start, $end, '', 'dateNo');
      } else {
	applyCriteria($rtype, $repNum, $ddValue, $pStatus, $tStatus,
		      $tType, $start, $end, $pid, $menuSelection, $gLevel);
      }
    } else {
      $pStatus = (string) $xmlRep[0]['patientStatus'];
      $tStatus = (string) $xmlRep[0]['treatmentStatus'];
      $tType = (string) $xmlRep[0]['patientStatus'];
      $gLevel = (string) $xmlRep[0]->groupLevel;
      $oLevel = (string) $xmlRep[0]->otherLevel;
      $ddValue = '';
    }
    // this reads the xml file and pieces together the final query from there
    if ($repNum > 5029 && $repNum < 5047) {
      $queryTable = buildSemiQuery($tableName, $gLevel, $ddValue);
    } else
      $queryTable = buildReportQuery($xmlRep, $rtype, $repNum, $lang, $site, $pStatus, $tStatus,
				     $gLevel, $oLevel, $start, $end, $pid, $ddValue, $user);
  }
  
  
  $queryTable = stripslashes($queryTable);
  $queryChart = $queryTable;
  
  if ($oLevel == 4) $tableName = makeTable('latestVitals',
'select v.patientid, max(visitdate), count(*)
from v_vitals v, patient p
where v.patientid = p.patientid
and isnumeric(ageYears) = 1
and convert(int,ageYears) > 14
and sex = 1
and pregnant in (0,1)
group by v.patientid');
  
  // in the case where user asks for aggregated result when detail is patient level, need different query for detail
  if ($gLevel == 1 && $oLevel > 1) {
    //  pretend $oLevel = 1, except that when pregnancy is checked, delete males and those under 15;
    $queryTable = buildReportQuery($xmlRep, $rtype, $repNum, $lang, $site, $pStatus, $tStatus,
				   $gLevel, 1, $start, $end, $pid, $ddValue, $user);
    if ($oLevel == 4) {
      dbQuery('delete from ' . TEMP_DB . '.temp' . substr(getSessionUser(), 0, 3) . ' where patientid not in (select w.patientid from latestVitals' . substr(getSessionUser(), 0, 3) . ' w, v_vitals w2 where w.patientid = w2.patientid and w.maxdate = w2.visitdate)');
    }
    $queryTable = stripslashes($queryTable);
    eval("\$queryTable = \"$queryTable\";");
  }

  if ( $order != '' ) {
    $parts = preg_split('/order by /i', $queryTable);
    $queryTable = '';
    for ($i = 0; $i < count($parts) - 1; $i++) {
      $queryTable .= $parts[$i] . ' order by ';
    }
    $queryTable .= $order . ' ' . $oDir;
  }

  return array($queryTable, $queryChart, $tableName,
	       $start, $end, $pStatus, $tStatus, $tType,
	       $gLevel, $oLevel, $ddValue);
}

function getTotal($qry) {
  if (DEBUG_FLAG) print '<br>Total query: ' . $qry . '<br>';
  $result = dbQuery ($qry);
  while ($row = psRowFetch ($result)) {
    return ($row[0]);
    break;
  }
}

function buildReportQuery($xmlRep, $rtype, $repNum, $lang, $site, $pStatus, $tStatus,
			  $gLevel, $oLevel, $start, $end, $pid, $ddValue, $user=null) {

  if ($oLevel == 4) $tableName = makeTable('latestVitals',
"select v.patientid, max(visitdate), count(*)
from v_vitals v, patient p
where v.patientid = p.patientid
and isnumeric(ageYears) = 1
and floor(ageYears) > 14
and sex = 1
and pregnant in (0,1)
and visitdate <= '$end'
group by v.patientid");
  if ($rtype == 'clinicalCare' || $rtype == 'qualityCare') {
    $targetList = (string)$xmlRep[0]->targetList;
    $aggregateItems = (string)$xmlRep[0]->aggregateItems;
    $fromClause = (string)$xmlRep[0]->fromClause;
    $whereClause = (string)$xmlRep[0]->whereClause;
    $groupBy = (string)$xmlRep[0]->groupBy;
    $havingClause = (string)$xmlRep[0]->havingClause;
    $orderBy = (string)$xmlRep[0]->orderBy;
    $query = 'select ';

    if ($gLevel != 1) $site = '%';

    // TODO (remove this after changing strategy for reading xml file???)
    if ($targetList == '') $targetList = "distinct ltrim(rtrim(p.clinicPatientID)) as clinicPatientID, p.patientID, p.nationalID, ltrim(rtrim(p.fname)) as fName, ltrim(rtrim(p.lname)) as lName, CASE WHEN sex = 1 THEN 'F' WHEN sex = 2 THEN 'H' ELSE 'I' END as 'sex', ageYears as 'age', case when p.patientid in (select patientid from pepfarTable where (forPepPmtct = 0 OR forPepPmtct IS NULL)) then 'ART' else 'CC' end as status, maxDate as LastDate";
    if ($aggregateItems == "") $aggregateItems = "count(distinct p.patientID) as 'Compte', round(count(distinct p.patientID) / \$total * 100.00, 2) as 'Pour cent'";
    if ($fromClause == "") $fromClause = TEMP_DB . ".temp" . substr(getSessionUser(),0,3) . " t, v_patients p, clinicLookup a";
    if ($whereClause == "") $whereClause =  "t.patientID = p.patientID and a.sitecode = p.sitecode and a.sitecode like '$site' and p.encounterType in (10, 15)";
    if ($orderBy == "") $orderBy = "1";

    // construct the target list
    if ($gLevel == 1) {
      if ($oLevel == 1) $query .= $targetList;
      else if ($oLevel == 2) $query .= str_replace ('lang', $lang, GENDER_TARGET) . " as Sexe," . $aggregateItems;
      else if ($oLevel == 3) $query .= AGE_DIST_TARGET2 . " as 'AgeGroupe'," . $aggregateItems;
      else if ($oLevel == 4) $query .= PREGNANT_TARGET . " as Grossesse," . $aggregateItems;
    } else {
      if ($rtype == "aggregatePop")
	$query .= $targetList . ", ";
      if ($gLevel == 2) $query .= "clinic as Clinic";
      if ($gLevel == 3) $query .= "Commune";
      //if ($gLevel == 4) $query .= "department as D&eacute;partement";
      if ($gLevel == 4) $query .= "department as Department";
      if ($gLevel == 5) $query .= "Network";
      if ($rtype == "clinicalCare" || $rtype == "qualityCare") {
	if ($oLevel == 2) $query .= ", " . str_replace ('lang', $lang, GENDER_TARGET) . " as Sexe ";
	if ($oLevel == 3) $query .= ", " . AGE_DIST_TARGET2 . " as 'AgeGroupe' ";
	if ($oLevel == 4) $query .= ", " . PREGNANT_TARGET . " as 'Grossesse' ";
      }
      $query .= "," . $aggregateItems;
    }

    // add the from clause
    $query .= " from " . $fromClause;
    
    if ($oLevel == 4) $query .= ", " . $tableName . " w, v_vitals w2";
    
    // construct the where clause
    $pregClause = "w.patientid = p.patientid and p.sex = 1 and w2.pregnant in (0,1) and w.patientid = w2.patientid and w.maxdate = w2.visitdate and w.maxdate = t.maxdate ";
    if (!empty($whereClause)) {
      // add on the ddValue clause depending upon $gLevel
      if (!empty($ddValue)) {
	if ($ddValue != "All") {
          $subWhere = strpos ($ddValue, ",") !== false ? " in ($ddValue)" : " = '$ddValue'";
	  if ($gLevel == 1) $whereClause .= " and a.clinic in (select clinic from clinicLookup where sitecode $subWhere";
	  if ($gLevel == 2) $whereClause .= " and a.clinic in (select clinic from clinicLookup where sitecode $subWhere";
	  if ($gLevel == 3) $whereClause .= " and a.commune in (select commune from clinicLookup where sitecode $subWhere";
	  if ($gLevel == 4) $whereClause .= " and a.department in (select department from clinicLookup where sitecode $subWhere";
	  if ($gLevel == 5) $whereClause .= " and a.network in (select network from clinicLookup where sitecode $subWhere";
	  $whereClause .=  ")";
	}
      }
      $query .= " where " . $whereClause;
      if ($oLevel == 4) $query .= " and " . $pregClause;
    } else {
      if ($oLevel == 4) $query .= " where " . $pregClause;
    }
    
    // construct the group by clause
    if ($gLevel + $oLevel > 2) {
      $query .= " group by ";
      if ($gLevel == 1) {
	if ($oLevel == 2) $query .= str_replace ('lang', $lang, GENDER_TARGET);
	if ($oLevel == 3) $query .= AGE_DIST_TARGET2;
	if ($oLevel == 4) $query .= PREGNANT_TARGET;
      } else {
	if ($rtype == "aggregatePop")
	  $query .= $groupBy . ", ";
	if ($gLevel == 2) $query .= "clinic";
	if ($gLevel == 3) $query .= "commune";
	if ($gLevel == 4) $query .= "department";
	if ($gLevel == 5) $query .= "network";
	if ($rtype == "clinicalCare" || $rtype == "qualityCare") {
	  if ($oLevel == 2) $query .= ", " . str_replace ('lang', $lang, GENDER_TARGET);
	  if ($oLevel == 3) $query .= ", " . AGE_DIST_TARGET2;
	  if ($oLevel == 4) $query .= ", " . PREGNANT_TARGET;
	}
      }
      //$query .= " with rollup ";
    } else {
      if (!empty ($groupBy)) $query .= " group by $groupBy";
    } 
    
    // add having clause
    if (!empty($havingClause) && $gLevel != 1)
      $query .= " having " . $havingClause;
    
    // construct the order by clause
    if (!empty($orderBy)) {
      $query .= " order by ";
      if ($gLevel == 1 && $oLevel == 1)
	$query .= $orderBy;
      else {
/*
				if ($rtype == "aggregatePop")
					$query .= "grouping(" . $groupBy . "), " . $groupBy . ", ";
				if ($gLevel == 2) $query .= "grouping(clinic),clinic";
				if ($gLevel == 3) $query .= "grouping(commune),commune";
				if ($gLevel == 4) $query .= "grouping(department),department";
				if ($gLevel == 5) $query .= "grouping(network), network";
				if ($rtype == "clinicalCare" || $rtype == "qualityCare") {
					if ($oLevel > 1) {
						if ($gLevel == 1)
							$query .= " grouping(";
						else
							$query .= ", grouping(";
						if ($oLevel == 2) $query .= str_replace ('lang', $lang, GENDER_TARGET) . "), " . str_replace ('lang', $lang, GENDER_TARGET);
						if ($oLevel == 3) $query .= AGE_DIST_TARGET2 . ")," . AGE_DIST_TARGET2;
						if ($oLevel == 4) $query .= PREGNANT_TARGET . ")," .  PREGNANT_TARGET;
*/
	if ($rtype == "aggregatePop")
	  $query .= $groupBy . ", ";
	if ($gLevel == 2) $query .= "clinic";
	if ($gLevel == 3) $query .= "commune";
	if ($gLevel == 4) $query .= "department";
	if ($gLevel == 5) $query .= "network";
	if ($rtype == "clinicalCare" || $rtype == "qualityCare") {
	  if ($oLevel > 1) {
	    if ($gLevel > 1) $query .= ", ";
	    if ($oLevel == 2) $query .= str_replace ('lang', $lang, GENDER_TARGET);
	    if ($oLevel == 3) $query .= AGE_DIST_TARGET2;
	    if ($oLevel == 4) $query .= PREGNANT_TARGET;
	  }
	}
      }
    }
  } else {
    $query = (string)$xmlRep[0]->query;
    $gLevel = 0;
  }
  //echo "<br>Query before first String substitutions: " . $query . "<br>";
  $query = doStringSubstitutions($query, $site, $start, $end, $pid, '', $user);
  //echo "<br>Query after first String substitutions: " . $query . "<br>";
  if ($gLevel > 1 || $oLevel > 1) {
    $targItem = explode(",",$aggregateItems);
    if (count($targItem) > 0) {
      $totalQry = "select " . $targItem[0] . " from " . $fromClause . " where " . $whereClause;
      if (!empty($havingClause))
	$totalQry .= " having " . $havingClause;
      $totalQry = doStringSubstitutions($totalQry, $site, $start, $end, $pid, '', $user);
      if (DEBUG_FLAG) print $totalQry;
      $total = getTotal($totalQry);
      $GLOBALS['reportTotal'] = $total;
      if (empty ($total))
	$fTotal = 0.0;
      else
	$fTotal = (float) $total;
      $sTotal = sprintf("%F",$fTotal);
      $query = str_replace('$total', $sTotal, $query);
      //echo "<br>fTotal: " . $fTotal . "   sTotal: " . $sTotal . " query: " . $query . "<br>";

      // Store drill-down data (just pids for now) for this report/user for later queries
      if ($gLevel > 1) {
        $pidsQry = "SELECT p.patientID FROM " . $fromClause . " WHERE " . $whereClause;
        if (!empty ($havingClause))
	  $pidsQry .= " HAVING " . $havingClause;
        $pidsQry = doStringSubstitutions ($pidsQry, $site, $start, $end, $pid, '', $user);
        if (DEBUG_FLAG) print $pidsQry;
        if (is_null ($user)) {
          $user = getSessionUser ();
        }
        $pidsTable = "temp" . $repNum . $user;
        dbQuery ("DROP TABLE IF EXISTS $pidsTable");
        dbQuery ("CREATE TABLE $pidsTable (pid varchar(11), INDEX pid_idx (pid))");
        dbQuery ("INSERT INTO $pidsTable $pidsQry");
      }
    }
  }
  return $query;
}

function buildSemiQuery ($tableName, $gLevel, $ddValue) {
  switch ($gLevel) {
  case "2":
    $entity = "Clinic";
    break;
  case "3":
    $entity = "Commune";
    break;
  case "4":
    $entity = "Department";
    break;
  case "5":
    $entity = "Network";
  }
  if ($ddValue == "All") {
    $qry = "select " . $entity . ", timeperiod, sum(numerator) as Numerator, sum(denominator) as Denominator, convert(int, convert(float, sum(numerator))*100 / convert(float,sum(denominator))) as '%' from " . $tableName . " f, clinicLookup c where f.siteCode = c.siteCode";
    $qry .= " group by " . $entity . ", timeperiod order by " . $entity . ", timeperiod";
  } else {
    $qry = "select timeperiod, sum(numerator) as Numerator, sum(denominator) as Denominator, convert(int, convert(float, sum(numerator))*100 / convert(float,sum(denominator))) as '%' from " . $tableName . " f, clinicLookup c where f.siteCode = c.siteCode";
    $qry .= " and c." . $entity . " in (select " . $entity . " from clinicLookup where siteCode = '" . $ddValue . "') ";
    $qry .= " group by timeperiod order by timeperiod";
  }
  
  return ($qry);
}

?>
