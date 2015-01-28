<?php

class Http
{
    public static function AddHeaders()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
    }
    
    public static function formatEquationForHttp($equation){
        $equation= str_replace("+","-1",$equation);
        $equation= str_replace("/","-3",$equation);
        $equation= str_replace("*","-4",$equation);
        $equation= str_replace("(","-5",$equation);
        $equation= str_replace(")","-6",$equation);
        return $equation;    
    }

    public static function removeHttpFormatting($equation){
        $equation= str_replace("-1","+",$equation);
        $equation= str_replace("-3","/",$equation);
        $equation= str_replace("-4","*",$equation);
        $equation= str_replace("-5","(",$equation);
        $equation= str_replace("-6",")",$equation);
        return $equation;    
    }

}
