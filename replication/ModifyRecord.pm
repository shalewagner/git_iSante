
package ModifyRecord;

use strict;
use warnings;

use TableInfo;

BEGIN {
    use Exporter ();
    our ($VERSION, @ISA, @EXPORT);

    @ISA = qw(Exporter);
    @EXPORT = qw(&allRecordModifications &initClinicPatientIdMap);
}

my $dbHandle;

sub allRecordModifications {
    my ($dbh, $schemaVersion, $tableName, $fieldHash) = @_;
    $dbHandle = $dbh;
    return upgradeRecord($schemaVersion, $tableName, $fieldHash);
}

#Converts a record from an old version to the current version. 
#Returns an array of new records.
sub upgradeRecord {
    my ($schemaVersion, $tableName, $fieldHash) = @_;

    if ($tableName eq 'patient') {
	if ($schemaVersion < 19) {
	    pre7Patients($fieldHash);
	}
	if ($schemaVersion < 20) {
	    foreach my $key (keys(%$fieldHash)) {
		if (lc($key) eq 'stid') {
		    $fieldHash->{$key} =~ s/[^0-9]//g;
		}
	    }
	}
	if ($schemaVersion < 21) {
	    if (! defined $fieldHash->{'hivPositive'}) {
		$fieldHash->{'hivPositive'} = 1;
	    }
	}
	if ($schemaVersion < 23) {
	    $fieldHash->{'masterPid'} = $fieldHash->{'patientID'};
	}
    }

    if ($schemaVersion < 19) {
	if ($tableName eq 'symptoms') {
	    #note: this is a final transform and returns multiple records
	    return pre7Symptoms($fieldHash);
	}
	if ($tableName eq 'encounter') {
	    registerClinicPatientId($fieldHash);
	    if (defined $fieldHash->{'clinicPatientID'}) {
		delete $fieldHash->{'clinicPatientID'};
	    }
	}
    }

    if ($tableName eq 'obs') {
	if ($schemaVersion < 26) {
	    pre9rc2obsConceptIdRemap($fieldHash);

	    {#Default values for a few columns we don't use changed to null. Convert the old defaults to nulls.
		my %convertToNull = ('date_created' => '0000-00-00 00:00:00',
				     'creator' => '0',
				     'voided' => '0');
		while (my ($field, $value) = each(%convertToNull)) {
		    if (defined $fieldHash->{$field}
			&& $fieldHash->{$field} eq $value) {
			$fieldHash->{$field} = undef;
		    }
		}
	    }
	}
    }

    return [[$tableName, $fieldHash]];
}

{
    sub obsConceptIdRemap {
	my ($fieldHash, $idMap) = @_;
	if ( defined $fieldHash->{'concept_id'}
	     && exists($idMap->{$fieldHash->{'concept_id'}}) ) {
	    $fieldHash->{'concept_id'} = $idMap->{$fieldHash->{'concept_id'}};
	}
    }

    my $pre9rc2Map = {
	70379 => 70059,
	71004 => 70112,
	71005 => 70113,
    };
    sub pre9rc2obsConceptIdRemap {
	my $fieldHash = shift;
	obsConceptIdRemap($fieldHash, $pre9rc2Map);
    }
}

#update a few fields in the patient records
{
    # build an array of clinicPatientIDs to use when inserting patient records
    # only look in encounter records of type 10/15
    my %clinicPatientID = ();

    sub registerClinicPatientId {
	my ($encounterRecord) = @_;

	if ( exists($encounterRecord->{'clinicPatientID'})
	     && ( ($encounterRecord->{'encounterType'} == 10)
		  || ($encounterRecord->{'encounterType'} == 15) ) )
	{
	    $clinicPatientID{$encounterRecord->{'patientID'}} = $encounterRecord->{'clinicPatientID'};
	}
    }

    sub initClinicPatientIdMap {
	my $dbh = shift;
	$dbHandle = $dbh;

	my $clinicPatientIdDate =
	    $dbHandle->selectall_arrayref('
select patientID, clinicPatientID from patient
where clinicPatientID is not null
 and clinicPatientID != \'\'
', { Slice => {} });
	foreach my $row (@$clinicPatientIdDate) {
	    $clinicPatientID{$row->{'patientID'}} = $row->{'clinicPatientID'};
	}
    }

    sub pre7Patients {
	my $fieldHash = shift;

	#remove fields that are no longer needed
	delete $fieldHash->{'patient_id'};
	delete $fieldHash->{'nxtDrugVisitDd'};
	delete $fieldHash->{'nxtDrugVisitMm'};
	delete $fieldHash->{'nxtDrugVisitYy'};
	delete $fieldHash->{'nxtVisitDd'};
	delete $fieldHash->{'nxtVisitMm'};
	delete $fieldHash->{'nxtVisitYy'};
	
	#add new fields
	if (! defined $fieldHash->{'location_id'}) {
	    $fieldHash->{'location_id'} = substr($fieldHash->{'patientID'},0,5);
	}
	if (! defined $fieldHash->{'person_id'}) {
	    $fieldHash->{'person_id'} = substr($fieldHash->{'patientID'},5);
	}
	if (! defined $fieldHash->{'clinicPatientID'}) {
	    $fieldHash->{'clinicPatientID'} = $clinicPatientID{$fieldHash->{'patientID'}};
	}
    }
}

#Generic function for creating obs records out of something else.
#$actions is a list of functions that will be applied to the input record.
#Each action will either return a new obs record or undef.
sub convertToObs {
    my ($tableName, $fieldHash, $actions) = @_;

    my $encounterRecord = lookupEncounter($tableName, $fieldHash);
    if (!defined($encounterRecord)) {
	return [];
    }

    my $newObsRecords = []; #hold all new obs records
    my %baseObsRecord = (); #hold all common fields for the new obs records
    $baseObsRecord{'person_id'} = substr($encounterRecord->{'patientID'}, 5);
    $baseObsRecord{'location_id'} = $encounterRecord->{'siteCode'};
    $baseObsRecord{'encounter_id'} = $encounterRecord->{'encounter_id'};
    if (defined($encounterRecord->{'visitDate'})) {
	$baseObsRecord{'obs_datetime'} = $encounterRecord->{'visitDate'};
    } else {
	my $yearPrefix = '20';
	if ($encounterRecord->{'visitDateYy'} > 30) {
	    $yearPrefix = '19';
	}
	$baseObsRecord{'obs_datetime'} = $yearPrefix
	    . sprintf('%02d-%02d-%02d',
		      $encounterRecord->{'visitDateYy'},
		      $encounterRecord->{'visitDateMm'},
		      $encounterRecord->{'visitDateDd'});
    }

    map {
	my $obs = $_->($fieldHash, \%baseObsRecord);
	if (defined($obs)) {
	    push @$newObsRecords, ['obs', $obs];
	}
    } @$actions;

    return $newObsRecords
}

#If the concept short_name is the same as the original record's column name
#and the concept type is text
#then this function can be used to quickly create acitons for making that conversion
sub makeObsTextAction {
    my $textSymptom = shift;
    return sub {
	my $fieldHash = shift;
	my %obsData = %{shift()};
	if (defined($fieldHash->{$textSymptom}) && $fieldHash->{$textSymptom} ne '') {
	    $obsData{'concept_id'} = getConceptId($textSymptom);
	    $obsData{'value_text'} = $fieldHash->{$textSymptom};
	    return \%obsData;
	} else {
	    return undef;
	}
    }
}

#If the concept short_name is the same as the original record's column name
#and the concept type is boolean
#then this function can be used to quickly create acitons for making that conversion
sub makeObsBoolAction {
    my $boolSymptom = shift;
    return sub {
	my $fieldHash = shift;
	my %obsData = %{shift()};
	if (defined($fieldHash->{$boolSymptom}) && $fieldHash->{$boolSymptom} == 1) {
	    $obsData{'concept_id'} = getConceptId($boolSymptom);
	    $obsData{'value_boolean'} = $fieldHash->{$boolSymptom};
	    return \%obsData;
	} else {
	    return undef;
	}
    }
}

#need to convert symptoms records to obs records
{
    my @symptomActions = ();

    my @textSymptoms = qw(pedSympCoughText pedSympRashText otherSymptoms);
    map {push @symptomActions, makeObsTextAction($_)} @textSymptoms;

    my @boolSymptoms = qw(sympOther abPain anorexia asymptomaticWho chronicWeakness
			      cough3WeeksEqualMore cough3WeeksLess cough diarrheaLessMo
			      diarrheaPlusMo dyspnea expectoration feverLessMo
			      feverPlusMo headache hemoptysie lymphadenopathies nausea
			      nightSweats numbness odynophagia pedSympAsthenia
			      pedSympDiarrhea pedSympEarache pedSympInsuffWt
			      pedSympIrritability pedSympLethargy pedSympMuscPain
			      pedSympPrurigo pedSympRegurg pedSympSeizure pedSympVision
			      pedSympWhoDiarrhea pedSympWhoWtLoss2 pedSympWhoWtLoss3
			      pedSympWtLoss prurigo sympRash vomiting
			      weightLossLessTenPercMo weightLossPlusTenPercMo);
    map {push @symptomActions, makeObsBoolAction($_)} @boolSymptoms;

    push @symptomActions, sub {
	my $fieldHash = shift;
	my %obsData = %{shift()};
	if ( defined($fieldHash->{'wtLossTenPercWithDiarrMo'}) 
	     && defined($fieldHash->{'diarrheaLessMo'})
	     && defined($fieldHash->{'diarrheaPlusMo'})
	     && $fieldHash->{'wtLossTenPercWithDiarrMo'} == 1
	     && ($fieldHash->{'diarrheaLessMo'} == 1
		 || $fieldHash->{'diarrheaPlusMo'} == 1)
	    ) {
	    $obsData{'concept_id'} = getConceptId('wtLossTenPercWithDiarrMo');
	    $obsData{'value_boolean'} = '1';
	    return \%obsData;
	} else {
	    return undef;
	}
    };

    sub pre7Symptoms {
	my $fieldHash = shift;
	return convertToObs('symptoms', $fieldHash, \@symptomActions);
    }
}

sub lookupEncounter {
    my ($tableName, $fieldHash) = @_;

    my @encounterKey =
	('siteCode', 'seqNum', 'patientID', 'visitDateDd', 'visitDateMm', 'visitDateYy');
    my @encounterKeyValues = map {$fieldHash->{$_}} @encounterKey;
    my $findEncounterSql = '
select *
from encounter
where ' . join(' and ', map {$_ . ' = ?'} @encounterKey);

    my $encounterRecords = 
	$dbHandle->selectall_arrayref($findEncounterSql, {Slice => {}}, @encounterKeyValues);

    if (scalar(@$encounterRecords) != 1) {
	print 'Problem looking for encounter with: ' 
	    . join(', ', map {$_ . '=' . $fieldHash->{$_}} @encounterKey)
	    . "\n\n";
	incrementTableInfo($tableName, 'errorC', 1);
	return undef;
    } else {
	return $encounterRecords->[0];
    }
}

{
    my %conceptIdCache = ();

    sub getConceptId {
	my $concept = shift;
	if (! defined $conceptIdCache{$concept}) {
	    my $lookupSql = 'select * from concept where short_name = ?';
	    my $conceptRecord = $dbHandle->selectrow_hashref($lookupSql, undef, $concept);
	    if (defined($conceptRecord)) {
		$conceptIdCache{$concept} = $conceptRecord->{'concept_id'};
	    }
	}
	return $conceptIdCache{$concept};
    }
}

1;
