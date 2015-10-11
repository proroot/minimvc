<?php namespace Module\Twig;

class Twig
{
    private $_uTwig;

    public function __construct($uTemplate)
    {
        Twig\Autoloader::register();

        $this->_uTwig = new \Twig_Environment(new \Twig_Loader_Filesystem($uTemplate), [
            'cache'       => APPPATH . 'Cache' . DS . 'Twig_Compilation_Cache',
            // 'auto_reload' => true,
            'debug'       => DEBUG
        ]);

        $this->_uTwig->addGlobal('pathApp', \Core\Request::getInstance()->pathApp());
    }

    public function render($uFileName, $uData)
    {
        return (string) $this->_uTwig->render($uFileName, $uData);
    }
    
}
