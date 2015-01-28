<?php
function __autoload($class_name)
{
    //class directories
    $directories = array(
        'DataAccess/',
        'Logic/',
        'Models/',
        'Utilities/'
    );

    //for each directory
    foreach($directories as $directory)
    {
        //see if the file exsists
        if(file_exists($directory.$class_name . '.php'))
        {
            require_once($directory.$class_name . '.php');
            return;
        }
    }
}