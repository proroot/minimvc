<?php

use Core\Exception\CoreException;

class Controller_Api extends Core\Controller
{
    public function index()
    {
        dd($this->_uRequest->body());
        return 'Api test';
    }

}
