<?php

class Sorting {
    public static function GetSortedIntervalsDtos($dtos, $startInterval) {
        usort($dtos, "Sorting::cmpDesc");
        $subset=array();
        foreach($dtos as $dto){
            if ($dto->TimeLevel>=$startInterval){
                array_push($subset,$dto);
            }
            else {
                break;
            }
        }
        usort($subset, "Sorting::cmpAsc");

        return $subset;
    }

    public static function cmpDesc($a, $b)
    {
        $intALevel=intVal($a->TimeLevel);
        $intBLevel=intVal($b->TimeLevel);
        if ($intALevel>$intBLevel){
            return -1;
        }
        else if ($intALevel<$intBLevel){
            return 1;
        }
        else return 0;
    }
    public static function cmpAsc($a, $b)
    {
        $intALevel=intVal($a->TimeLevel);
        $intBLevel=intVal($b->TimeLevel);
        if ($intALevel<$intBLevel){
            return -1;
        }
        else if ($intALevel>$intBLevel){
            return 1;
        }
        else return 0;
    }
} 