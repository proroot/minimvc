<?php namespace Module\Twig;

use Module\Twig\Twig\Autoloader;

class Twig
{
    private $uResponse = '';

    public function __construct($uTemplate, $uFileName, $uData)
    {
        Autoloader::register();

        $uLoader = new \Twig_Loader_Filesystem($uTemplate);

        $uTwig   = new \Twig_Environment($uLoader, array(
            'cache'       => APPPATH . 'Cache' . DS . 'Twig_Compilation_Cache',
            // 'auto_reload' => true,
            'debug'       => DEBUG
        ));

        $this->uResponse = $uTwig->render($uFileName, $uData);
    }

    public function __toString()
    {
        return (string) $this->uResponse;
    }
}
