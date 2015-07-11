<?php namespace Core;

use Core\Exception\Exception;

class Model
{
    public static function init($uName)
    {
        return new 'Model_' . str_replace('.', '_', $uName);
    }
    
}
