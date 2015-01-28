<?php

class LinqMethods {
    public static function Exists($objects, $prop, $value){
        foreach($objects as $obj){
            if ($obj->$prop==$value){
                return true;
            }
        }
        return false;
    }
}