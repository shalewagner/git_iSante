<?php

class EquationFormatter {
    Const FIELD_FRONT_DELIMITER='{';
    Const FIELD_BACK_DELIMITER='}';

    public static function formatEquation($equation){
        $pattern="/\){1}/";
        preg_match_all($pattern,$equation,$matches);
        foreach ($matches[0] as $match) {
            $val= $match.">0)";
            $equation = str_replace($match, $val, $equation);
        }

        $pattern="/\({1}/";
        preg_match_all($pattern,$equation,$matches);
        foreach ($matches[0] as $match) {
            $val=$match."(";
            $equation = str_replace($match, $val, $equation);
        }

        $pattern="/\{{1}[a-zA-Z0-9]+\}{1}[^\-\+\)]/";
        preg_match_all($pattern,$equation,$matches);
        foreach ($matches[0] as $match) {
            $reformatted=substr($match,0, strlen($match) -1);
            $val="(".$reformatted.">0)";
            $equation = str_replace($reformatted, $val, $equation);
        }

        $pattern="/\{{1}[a-zA-Z0-9]+\}{1}$/";
        preg_match_all($pattern,$equation,$matches);
        foreach ($matches[0] as $match) {
            $reformatted=$match;
            $val="(".$reformatted.">0)";
            $equation = str_replace($match, $val, $equation);
        }

        $pattern="/NOT\s{1}\(+[a-zA-Z0-9\{\}\>\<]+\)+/";
        preg_match_all($pattern,$equation,$matches);
        foreach ($matches[0] as $match) {
            $val= str_replace(">","=", $match);            
            $val= str_replace("NOT ","", $val);              
            $equation = str_replace($match, $val, $equation);
        }

        return EquationFormatter::RemoveFieldTokenDelimiters($equation);
    }    
    
    public static function RemoveFieldTokenDelimiters($equation){
        $pattern="/\{{1}[a-zA-Z0-9]+\}{1}/";
        preg_match_all($pattern,$equation,$matches);
        foreach ($matches[0] as $match) {            
            $fieldName=strtolower(substr($match,1,strlen($match)-2));
            $equation = str_replace($match, $fieldName, $equation);
        }

        return $equation;
    }        
}