<?php

use Core\Exception\Exception;
use Core\View;
use Core\Model;
use Module\DB\DB;

use Prt\Curl\Curl;

class Controller_Welcome extends Core\Controller
{
    // use Traits\Login;

    public function index()
    {
		//$this->uResponse = $this->uRequest->userAgent();

        // $uWelcome = new Model_Welcome();
    
        // $uTest = $uWelcome->test();
    
        // echo $uTest;
    
        //View::$_uGData = ['test2' => 12];
    
        //$this->uResponse = View::init('test.test', ['uTest' => 'dd'], '.txt');
    
        // $uCurl = new Curl();
    
        // return $uCurl->get('https://proroot.net', [], true);
        
        View::gData(['test' => 'sddd']);

        View::gData(['test2' => 'sdsdd']);

        return view('Welcome', ['test2' => $this->_uRequest->pathApp()]);


    
        // $this->uResponse = 'ss';

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

    public function post()
    {
        dd(file_get_contents('php://input'));
    }

    public function test()
    {
        $uDB = DB::instance();

        dd($uDB->fetchAll('
            SELECT *
                FROM `users`
                    LIMIT 50
        ', [], PDO::FETCH_COLUMN | PDO::FETCH_GROUP));

        return view('Welcome', ['test' => $this->uRequest->host()]);
    }

    public function test2()
    {
       return 'test2';
    }

}
