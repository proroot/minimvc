<?php namespace Module\Twig;

use Module\Twig\Twig\Autoloader;

class Twig
{
    private $_uTwig;

    public function __construct($uTemplate)
    {
        Autoloader::register();

        $this->_uTwig = new \Twig_Environment(new \Twig_Loader_Filesystem($uTemplate), array(
            'cache'       => APPPATH . 'Cache' . DS . 'Twig_Compilation_Cache',
            // 'auto_reload' => true,
            'debug'       => DEBUG
        ));

        $this->_uTwig->addGlobal('pathApp', \Core\Request::getInstance()->pathApp());
    }

    public function render($uFileName, $uData)
    {
        return (string) $this->_uTwig->render($uFileName, $uData);
    }
    
}
