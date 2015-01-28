<?php

class DownloadLogic
{
    public static function GetCsvFormattedRawDataBySubjectId($subjectId, $start, $limit){
        $snapshotRows=Repository::GetRawData($subjectId,$start,$limit);
        $fields=Repository::GetFieldsForRawBySubjectId($subjectId);
        $fileString= DownloadLogic::GetCsvString($snapshotRows, $fields);
        return $fileString;
    }

    public static function GetCsvFormattedAggregatedDataBySubjectId($subjectId,$timeLevel,$geographyLevel,$ageLevel,$genderLevel){
        $snapshotRows=Repository::GetAggregatedData($subjectId,$timeLevel,$geographyLevel,$ageLevel,$genderLevel, 0, 100000);
        $fields=Repository::GetFieldsForAggregatedBySubjectId($subjectId);
        $fileString= DownloadLogic::GetCsvString($snapshotRows, $fields);
        return $fileString;
    }

    private static function GetCsvString($snapshotRows, $fields){
        $header = array();
        $ctr = 0;
        foreach ($fields as $field) {
             $header[$ctr] = $field["fieldname"];
             $ctr++;
        }
        $fileString = join(", ",$header) . "\n";
        foreach ($snapshotRows as $snapshotRow) {
            $line = join(", ", $snapshotRow) . "\n";
            $fileString=$fileString.$line;
        }
        return $fileString;
    }
}
