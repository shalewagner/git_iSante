<?php

class AggregatedDataLogic
{
    public static function GetAggregatedDataAsDtos($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel,$filter){
        if ($filter){
            $malariaRows = Repository::GetAggregatedDataFilteredByAgeAndGender($timeLevel, $geographyLevel,$ageLevel,$genderLevel);
        }
        else {
            $malariaRows = Repository::GetAggregatedData($subjectId, $timeLevel, $geographyLevel,$ageLevel,$genderLevel);
        }
        $malariaDtos=array_map("AggregatedDataLogic::CreateAggregateMalariaObject", $malariaRows);
        return $malariaDtos;
    }

    public static function GetRawDataAsDtos($subjectId, $start, $limit){
        $malariaRows = Repository::GetRawData($subjectId, $start, $limit);
        $malariaDtos=array_map("AggregatedDataLogic::CreateRawMalariaObject", $malariaRows);
        return $malariaDtos;
    }

    public static function GetDataByTimeInterval($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel){
        $malariaDtos=AggregatedDataLogic::GetAggregatedDataAsDtos($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel,false);
        $aggregate=1;
        $fieldDtos = FieldLogic::GetFieldsAsDtos($subjectId,$aggregate);

        $gridRows=array();
        foreach ($fieldDtos as $field){
                $gridRow=new GridRow();
                $gridRow->name= $field->fieldName;
                array_push($gridRows, $gridRow);
        }

        $sortedSubset=Sorting::GetSortedIntervalsDtos($malariaDtos, 2010);

        for ($x=0;$x<=4;$x++)
        {
            $dto=$sortedSubset[$x];
            $intervalProp="interval".$x;
            foreach ($gridRows as $gr){
                $prop=$gr->name;
                $propValue=$dto->$prop;
                $gr->$intervalProp=$propValue;
            }
        }
        return $gridRows;
    }

    public static function GetDataAsFieldList($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel, $start, $limit,$filter){
        if ($timeLevel==0 && $geographyLevel==0 && $ageLevel==0 && $genderLevel==0)
        {
            return AggregatedDataLogic::GetRawDataAsDtos($subjectId, $start, $limit);
        }
        else {
            return AggregatedDataLogic::GetAggregatedDataAsDtos($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel,$filter);
        }
    }
    private static function CreateAggregateMalariaObject($arr){
        $malariaDto = new Malaria();
        $malariaDto->TimeLevel=$arr["timeLevel"];
        $malariaDto->GeographyLevel=$arr["geographyLevel"];
        $malariaDto->AgeLevel=$arr["ageLevel"];
        $malariaDto->GenderLevel=$arr["genderLevel"];
        $malariaDto->malariadxa=$arr["malariadxa"];
        $malariaDto->malariadx=$arr["malariadx"];
        $malariaDto->ispregnant=$arr["ispregnant"];
        $malariaDto->feverless2=$arr["feverless2"];
        $malariaDto->chloroquine=$arr["chloroquine"];
        $malariaDto->quinine=$arr["quinine"];
        $malariaDto->primaquine=$arr["primaquine"];
        $malariaDto->rapidresultpositive=$arr["rapidresultpositive"];
        $malariaDto->rapidresultnegative=$arr["rapidresultnegative"];
        $malariaDto->smearresultpositive=$arr["smearresultpositive"];
        $malariaDto->smearresultnegative=$arr["smearresultnegative"];
        $malariaDto->hospitalisation=$arr["hospitalisation"];
        $malariaDto->ft=$arr["ft"];
        $malariaDto->fg=$arr["fg"];
        $malariaDto->vx=$arr["vx"];
        $malariaDto->ov=$arr["ov"];
        $malariaDto->mai=$arr["mai"];
        $malariaDto->confirmedcase=$arr["confirmedcase"];
        $malariaDto->alltreatments=$arr["alltreatments"];
        $malariaDto->singletreatment=$arr["singletreatment"];
        $malariaDto->anytreatment=$arr["anytreatment"];
        $malariaDto->positivefalciparumtest=$arr["positivefalciparumtest"];
        $malariaDto->positiveotherparasitetest=$arr["positiveotherparasitetest"];        
        return $malariaDto;
    }

    private static function CreateRawMalariaObject($arr){
        $malariaDto = new MalariaRaw();
        $malariaDto->visitDate=$arr["visitdate"];
        $malariaDto->patientId=$arr["patientid"];
        $malariaDto->malariadxa=$arr["malariadxa"];
        $malariaDto->malariadx=$arr["malariadx"];
        $malariaDto->ispregnant=$arr["ispregnant"];
        $malariaDto->feverless2=$arr["feverless2"];
        $malariaDto->chloroquine=$arr["chloroquine"];
        $malariaDto->quinine=$arr["quinine"];
        $malariaDto->primaquine=$arr["primaquine"];
        $malariaDto->rapidresultpositive=$arr["rapidresultpositive"];
        $malariaDto->rapidresultnegative=$arr["rapidresultnegative"];
        $malariaDto->smearresultpositive=$arr["smearresultpositive"];
        $malariaDto->smearresultnegative=$arr["smearresultnegative"];
        $malariaDto->hospitalisation=$arr["hospitalisation"];
        $malariaDto->ft=$arr["ft"];
        $malariaDto->fg=$arr["fg"];
        $malariaDto->vx=$arr["vx"];
        $malariaDto->ov=$arr["ov"];
        $malariaDto->mai=$arr["mai"];
        $malariaDto->confirmedcase=$arr["confirmedcase"];
        $malariaDto->alltreatments=$arr["alltreatments"];
        $malariaDto->singletreatment=$arr["singletreatment"];
        $malariaDto->anytreatment=$arr["anytreatment"];
        $malariaDto->positivefalciparumtest=$arr["positivefalciparumtest"];
        $malariaDto->positiveotherparasitetest=$arr["positiveotherparasitetest"];
        $malariaDto->department=$arr["department"];
        $malariaDto->commune=$arr["commune"];
        $malariaDto->clinic=$arr["clinic"];
        $malariaDto->category=$arr["category"];
        $malariaDto->type=$arr["type"];
        $malariaDto->sitecode=$arr["sitecode"];        
        return $malariaDto;
    }
}
