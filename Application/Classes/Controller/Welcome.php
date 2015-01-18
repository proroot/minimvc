<?php

class Controller_Welcome extends Core\Controller
{
	public function ActionIndex()
	{
		$this->response = 'Hello';
	}

	public function Action_2Index()
	{
		$this->response = 'Test';
	}
}