<?php

class Controller_Welcome extends Core\Controller
{
	public function ActionIndex()
	{
		$this->response = 'Hello test 2';

		// test
	}

	public function Action_2Index()
	{
		$this->response = 'Test';

		$this->response = 'Test';

		// Test
		$this->response = 'Test';
	}
}