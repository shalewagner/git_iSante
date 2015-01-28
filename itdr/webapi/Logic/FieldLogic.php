<?php

class FieldLogic
{
    private static function CreateDataField($field){
        $fieldDto = new DataField();
        $fieldDto->fieldId=$field["fieldid"];
        $fieldDto->fieldName=$field["fieldname"];
        $fieldDto->fieldDisplayName=$field["displayname"];
        $fieldDto->fieldType=$field["fieldtypeid"];
        return $fieldDto;
    }

    public static function GetFieldsAsDtos($subjectid, $rawOrAggregate){
        if ($rawOrAggregate=0){
            $fields = Repository::GetFieldsForRawBySubjectId(1);
        }
        else {
            $fields = Repository::GetFieldsForAggregatedBySubjectId(1);
        }
        $fieldDtos=array_map("FieldLogic::CreateDataField", $fields);
        return $fieldDtos;
    }
}
