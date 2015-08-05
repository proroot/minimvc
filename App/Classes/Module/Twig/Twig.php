<?php namespace Module\Twig;

use Module\Twig\Twig\Autoloader;

class Twig
{
    private $uTwig;

    public function __construct($uTemplate)
    {
        Autoloader::register();

        $uLoader = new \Twig_Loader_Filesystem($uTemplate);

        $this->uTwig   = new \Twig_Environment($uLoader, array(
            'cache'       => APPPATH . 'Cache' . DS . 'Twig_Compilation_Cache',
            // 'auto_reload' => true,
            'debug'       => DEBUG
        ));
    }

    public function render($uFileName, $uData)
    {
        return (string) $this->uTwig->render($uFileName, $uData);
    }
    
}
