<?php

use Core\Controller;

class Controller_Welcome extends Controller
{
	public function ActionIndex()
	{
		$this->response = 'Test';
	}
}