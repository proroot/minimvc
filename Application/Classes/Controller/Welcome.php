<?php

class Controller_Welcome extends Core\Controller
{
	public function ActionIndex()
	{
		$this->response = 'Hello test';
	}
}