<?php 
$curDir = getcwd();
chdir ("../..");
include "backend.php"; 
chdir ($curDir);

class Repository
{
    public static function GetConnection(){
        $con=mysqli_connect("localhost","itechapp",DB_PASS,"itech");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $con;
    }

    public static function CloseConnection($con){
        $closed = mysqli_close($con);

        if (!$closed) {
            echo "Failed to close MySQL connection: " . mysqli_error($con);
        }
    }

    public static function RunDeleteQuery($sql){
        $con=Repository::GetConnection();
        $query = mysqli_query($con,$sql);
        Repository::CloseConnection($con);
        return true;
    }

    public static function RunInsertQuery($sql){
        $con=Repository::GetConnection();
        $query = mysqli_query($con,$sql);
        $insertedId=mysqli_insert_id($con);
        Repository::CloseConnection($con);
        return $insertedId;
    }

    public static function FetchAll($sql){
        $con=Repository::GetConnection();
        $query = mysqli_query($con,$sql); 
        $rows = array();
        while ($row = $query->fetch_assoc()) {
            array_push($rows, $row);
        }
        Repository::CloseConnection($con);
        return $rows;
    }

    public static function GetFieldsForRawBySubjectId($subjectId){
        $sql = "SELECT * FROM fieldlookup where subjectid = 1 and aggregateonly=0";
        $fields = Repository::FetchAll($sql);
        return $fields;
    }

    public static function GetFieldsForAggregatedBySubjectId($subjectId){
        $sql = "SELECT * FROM fieldlookup where subjectid = 1 and rawonly=0";
        $fields = Repository::FetchAll($sql);
        return $fields;
    }

    public static function GetSubjectById($subjectId){
        $sql = "SELECT * FROM subjectlookup where subjectid = ".$subjectId;
        $subject = Repository::FetchAll($sql);
        return $subject[0]["subjectname"];
    }

    public static function GetRawCount($subjectId){
        $sql ="SELECT count(1) as count  FROM dw_malaria_snapshot m";
        $row = Repository::FetchAll($sql);
        return $row[0]["count"];
    }

    public static function GetRawData($subjectId, $start, $limit){
        $sql = "Select * from vw_malaria";
        if (isset($start,$limit)){
            $sql =$sql." LIMIT "." ".$start.", ".$limit;
        }
        $snapshotRows = Repository::FetchAll($sql);
        return $snapshotRows;
    }

    // TODO: use subject id to get correct sproc
    public static function GetAggregatedData($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel){
        $sprocString = "Call GetMalariaData(".$timeLevel.", ".$geographyLevel.", ".$ageLevel.", ".$genderLevel.")";
        $aggregateRows = Repository::FetchAll($sprocString);
        return $aggregateRows;
    }

    // TODO: use subject id to get correct sproc
    public static function GetAggregatedDataWithWhereClause($subjectId, $timeLevel, $geographyLevel, $ageLevel, $genderLevel,$whereClause){
        $sprocString = "Call GetMalariaDataWithWhereClause(".$timeLevel.", ".$geographyLevel.", ".$ageLevel.", ".$genderLevel.", '".$whereClause."')";
        $aggregateRows = Repository::FetchAll($sprocString);
        return $aggregateRows;
    }

    public static function GetAggregatedDataFilteredByAgeAndGender($timeLevel, $geographyLevel, $ageLevel, $genderLevel){
        $geographyLevel=is_null($geographyLevel)?0:$geographyLevel;
        $ageLevel=is_null($ageLevel)?0:$ageLevel;
        $genderLevel=is_null($genderLevel)?0:$genderLevel;
        $sprocString = "Call GetMalariaDataFilteredByAgeAndGender(".$timeLevel.", ".$geographyLevel.", ".$ageLevel.", ".$genderLevel.")";
        $aggregateRows = Repository::FetchAll($sprocString);
        return $aggregateRows;
    }

    public static function GetIndicatorsForUser($subjectId, $userIdentifier){
        $sql = "SELECT * FROM userindicator where subjectid=".$subjectId." and (userindicatortypeid = 1 or useridentifier='".$userIdentifier."')";
        $indicatorRows = Repository::FetchAll($sql);
        return $indicatorRows;
    }

    public static function GetIndicatorsById($indicatorIds){
        $idListAsString = implode(',', $indicatorIds);        
        $sql = "SELECT * FROM userindicator where userindicatorid in (".$idListAsString.")";
        $indicatorRows = Repository::FetchAll($sql);
        return $indicatorRows;
    }

    public static function DeleteIndicator($subjectId, $userIdentifier, $userindicatorid){        
        $sql = "Delete FROM userindicator where userindicatorid=".$userindicatorid;
        Repository::RunDeleteQuery($sql);
        return true;
    }

    public static function CreateIndicator($indicator){        
        $sql = "INSERT INTO `userindicator`
        (`userindicatortypeid`,
        `useridentifier`,
        `subjectid`,
        `userindicatorname`,
        `agelevel`,
        `genderlevel`,
        `numeratorequation`,
        `denominatorequation`)
        VALUES 
        (".$indicator->userIndicatorTypeId.",'".$indicator->userIdentifier."',".$indicator->subjectId.",'".$indicator->userIndicatorName."',".$indicator->ageLevel.",".$indicator->genderLevel.",'".$indicator->numeratorEquation."','".$indicator->denominatorEquation."')";
        $indicator->userIndicatorId = Repository::RunInsertQuery($sql);
        return $indicator;
    }

    
    public static function SetNullParameterToZero($value){
        if (is_null($value)){
            return 0;
        }
        return $value;
    }
}