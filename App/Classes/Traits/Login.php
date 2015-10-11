<?php namespace Traits;

use Core\Exception\CoreException;

trait Login
{
    public function before()
    {
        if ( ! empty($_COOKIE['test']))
        {
            dd(['Error auth']);
        }
    }
    
}
