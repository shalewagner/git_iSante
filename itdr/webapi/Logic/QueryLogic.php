<?php

class QueryLogic {
    public static function Query($subjectId, $request){
        $indicators=IndicatorLogic::GetIndicatorsByIdAsDtos($request->indicatorIds); 
        $gridRows=array();
        $indicatorArray=array();
        foreach($indicators as $ind){
            $ind->numeratorEquation=EquationFormatter::formatEquation($ind->numeratorEquation);
            $dtos = QueryLogic::RunQuery($subjectId,$request->timeLevel,$request->geographyLevel,$ind->ageLevel,$ind->genderLevel, $ind->numeratorEquation);
            $dtos = Sorting::GetSortedIntervalsDtos($dtos,2005);
            // TODO: this is hard-coded to recognize this single denominator.  Need to allow dynamic
            if ($ind->denominatorEquation=="{allpatients}"){
                $denomDtos=QueryLogic::RunAllPatientsQuery($subjectId,$request->timeLevel,$request->geographyLevel,$ind->ageLevel,$ind->genderLevel);
                QueryLogic::makeRatio($dtos, $denomDtos);            
            }
            $gr=new GridRow();
            $gr->name=$ind->userIndicatorName;
            foreach ($dtos as $dto){
                $intervalProp=QueryLogic::GetIntervalName($request->timeLevel, $dto->TimeLevel);
                $gr->$intervalProp=$dto->Count;
                for($i=0;$i<=9;$i++){
                    $intervalProp="interval".$i;
                    if(is_null($gr->$intervalProp)){
                        $gr->$intervalProp=0;
                    }
                }            
            }            
            array_push($gridRows,$gr);
        }
        return $gridRows;
    }

    private static function makeRatio($numeratorResults, $denominatorResults){
        foreach ($numeratorResults as $n){
            foreach($denominatorResults as $d){
                if ($n->TimeLevel==$d->TimeLevel && $n->GeographyLevel==$d->GeographyLevel && $n->AgeLevel==$d->AgeLevel && $n->GenderLevel==$d->GenderLevel){
                    if ($d->Count!=0){
                        $n->Count= round(100*$n->Count/$d->Count,2)."%";
                        continue;
                    }
                }            
            }
        }
    
    }
    
    private static function RunQuery($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel, $equation){
        $queryRows = Repository::GetAggregatedDataWithWhereClause($subjectId, $timeLevel, $geographyLevel,$ageLevel,$genderLevel,$equation);
        $queryResults=array_map("QueryLogic::CreateQueryResultObject", $queryRows);
        return $queryResults;
    }

    private static function RunAllPatientsQuery($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel){
        $equation = "1=1";
        $queryRows = Repository::GetAggregatedDataWithWhereClause($subjectId, $timeLevel, $geographyLevel,$ageLevel,$genderLevel,$equation);
        $queryResults=array_map("QueryLogic::CreateQueryResultObject", $queryRows);
        return $queryResults;
    }

    //TODO: This is fixed at the last 10 intervals and works only for year
    private static function GetIntervalName($timeLevel, $timeString){
        $value = "";
        $currentYear=Date('Y');
        $inYear=(int)substr($timeString,0,4);
        switch ($timeLevel){
            case 1:
            {
                $value=9 -($currentYear-$inYear); 
                break;
            }
            case 2:
            {
                $value=9;
                break;
            }
            default:{
                $value=9;
            }
        }
        
        return "interval".$value;
    }

    public static function GetSubsetBasedOnAgeAndGenderFilter($ind, $dtos){
        $ageIsFiltered=!Helpers::IsNullOrEmptyString($ind->ageLevel) && $ind->ageLevel!=0;
        $genderIsFiltered=!Helpers::IsNullOrEmptyString($ind->genderLevel) && $ind->genderLevel!=0;

        if($ageIsFiltered && $genderIsFiltered){
            foreach($dtos as $dto){
                if ($dto->ageGroup==$ind->ageLevel && $dto->genderGroup==$ind->genderLevel){
                    array_push($subsetDtos,$dto);
                }
            }
        }
        else if ($ageIsFiltered){
            foreach($dtos as $dto){
                if ($dto->ageGroup==$ind->ageLevel){
                    array_push($subsetDtos,$dto);
                }
            }
        }
        else if ($genderIsFiltered){
            foreach($dtos as $dto){
                if ($dto->genderGroup==$ind->genderLevel){
                    array_push($subsetDtos,$dto);
                }
            }
        }
        else{
            $subsetDtos=$dtos;
        }

        return $subsetDtos;
    }
    
    private static function CreateQueryResultObject($arr){
        $queryResult = new QueryResult();
        $queryResult->TimeLevel=$arr["timeLevel"];
        $queryResult->GeographyLevel=$arr["geographyLevel"];
        $queryResult->AgeLevel=$arr["ageLevel"];
        $queryResult->GenderLevel=$arr["genderLevel"];
        $queryResult->Count=$arr["count"];
        return $queryResult;
    }

} 