<?php

use Core\Exception\Exception;
use Core\View;

class Controller_Welcome extends Core\Controller
{
	public function actionIndex()
	{
		//$this->uResponse = $this->uRequest->userAgent();

        // $uWelcome = new Model_Welcome();

        // $uTest = $uWelcome->test();

        // echo $uTest;

        View::$_uGData = ['test2' => 12];

        $this->uResponse = View::init('test.test', ['uTest' => 'dd'], '.txt');
	}
}
