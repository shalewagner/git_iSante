<?php

class IndicatorLogic
{
    private static function CreateIndicatorFromIndicatorRow($indicatorRow){
        $indicatorDto = new Indicator();
        $indicatorDto->userIndicatorId=$indicatorRow["userindicatorid"];
        $indicatorDto->userIndicatorTypeId=$indicatorRow["userindicatortypeid"];
        $indicatorDto->subjectId=$indicatorRow["subjectid"];
        $indicatorDto->userIdentifier=$indicatorRow["useridentifier"];
        $indicatorDto->userIndicatorName=$indicatorRow["userindicatorname"];
        $indicatorDto->ageLevel=$indicatorRow["agelevel"];
        $indicatorDto->ageLevelText=IndicatorLogic::GetTextForAgeLevel($indicatorDto->ageLevel);
        $indicatorDto->genderLevel=$indicatorRow["genderlevel"];
        $indicatorDto->genderLevelText=IndicatorLogic::GetTextForGenderLevel($indicatorDto->genderLevel);
        $indicatorDto->numeratorEquation=$indicatorRow["numeratorequation"];
        $indicatorDto->denominatorEquation=$indicatorRow["denominatorequation"];
        
        
        return $indicatorDto;
    }

    private static function GetTextForGenderLevel($genderLevel){
        switch ($genderLevel){
            case 0:{
                return "All";
            }
            case 1:{
                return "Male";
            }
            case 2:{
                return "Female";
            }
            default:{
                return "All";
            }
        }
    }

    //TODO: make the age levels dynamic and get from db.
    private static function GetTextForAgeLevel($ageLevel){
        switch ($ageLevel){
            case 0:{
                    return "All";
                }
            case 1:{
                    return "LT1";
                }
            case 2:{
                    return "1-4";
                }
            case 2:{
                    return "5-9";
                }
            case 3:{
                    return "10-14";
                }
            case 4:{
                    return "15-24";
                }
            case 5:{
                    return "25-49";
                }
            case 6:{
                    return "GT49";
                }
            default:{
                    return "All";
                }
        }
    }

    public static function GetIndicatorsAsDtos($subjectid, $userIdentifier){
        $indicatorRows = Repository::GetIndicatorsForUser($subjectid, $userIdentifier);
        $indicatorDtos=array_map("IndicatorLogic::CreateIndicatorFromIndicatorRow", $indicatorRows);
        return $indicatorDtos;
    }

    public static function GetIndicatorsByIdAsDtos($indicatorIds){
        $indicatorRows = Repository::GetIndicatorsById($indicatorIds);
        $indicatorDtos=array_map("IndicatorLogic::CreateIndicatorFromIndicatorRow", $indicatorRows);
        return $indicatorDtos;
    }

    public static function DeleteIndicator($subjectid, $userIdentifier, $userIndicatorId){
        Repository::DeleteIndicator($subjectid, $userIdentifier, $userIndicatorId);
        return true;
    }
    
    public static function CreateIndicator($indicator){
        $indicator=Repository::CreateIndicator($indicator);
        return $indicator;
    }
}
