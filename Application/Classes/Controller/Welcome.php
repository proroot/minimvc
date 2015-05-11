<?php

use Core\Exception\Exception;
use Core\View;
use Core\Model;
use Module\Curl\Curl;

class Controller_Welcome extends Core\Controller
{
    public function actionIndex()
    {
		//$this->uResponse = $this->uRequest->userAgent();

        // $uWelcome = new Model_Welcome();
    
        // $uTest = $uWelcome->test();
    
        // echo $uTest;
    
        //View::$_uGData = ['test2' => 12];
    
        //$this->uResponse = View::init('test.test', ['uTest' => 'dd'], '.txt');
    
        //$uCurl = new Curl();
    
        // $this->uResponse = $uCurl
        //     ->get('https://proroot.net')
        //     ->getResponse();
    
        $uWelcome = Model::init('Test.Welcome');


    
        $this->uResponse .= $uWelcome->test();

        // $uData = [
        //     1 => 'ddd',
        //     5 => 'ddd'
        // ];

        // d($uData);

        // $uData = [
        //     1 => 'ddd',
        //     5 => 'ddd'
        // ];

        // dd($uData, 'ddd');
    }

    public function before()
    {
        $this->uResponse = 'dd';
    }
}
