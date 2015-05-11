<?php namespace Core;

use Core\Exception\Exception;

abstract class Model
{
    public static function init($uName)
    {
        $uClass = 'Model_' . str_replace('.', '_', $uName);

        return new $uClass;
    }
}