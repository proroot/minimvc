<?php

use Core\Exception\Exception;
use Core\View;
use Core\Model;
use Module\Curl\Curl;

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
    
        // $this->uResponse = $uCurl
        //     ->get('https://play.google.com/store/apps')
        //     ->getResponse();

    
        // $uWelcome = Model::init('Test.Welcome');


    
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

    public function test()
    {
        //dd(file_get_contents('php://input'));

// The result
        // print_r($_GET);
        // $this->uResponse = 'actionTest';

        // Twig_Autoloader::register(true);

        // $loader = new Twig_Loader_Filesystem(APPPATH . 'Views' . DS);

        // $twig = new Twig_Environment($loader, array(
        //     'cache'       => 'compilation_cache',
        //     'auto_reload' => true
        // ));

        // echo $twig->render('Welcome.php', array('list' => array(1,2,3,4,5)));
        //header('Location: https://vk.com');

        //dd(file_get_contents('php://input'));

        return view('Welcome', ['test' => $this->uRequest->host()]);
    }

    public function test2()
    {
       return 'test2';
    }

}
