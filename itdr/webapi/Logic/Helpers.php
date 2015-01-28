<?php

class Helpers {
    public static function IsNullOrEmptyString($strObj){
        if (is_null($strObj) || strlen($strObj)==0){
            return true;
        }
    }
} 