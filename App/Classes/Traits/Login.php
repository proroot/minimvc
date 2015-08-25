<?php namespace Model\Traits;

use Core\Exception\Exception;

trait Login
{
    public function before()
    {
        if ( ! empty($_GET['test']))
        {
            dd(['Error']);
        }
    }
    
}
