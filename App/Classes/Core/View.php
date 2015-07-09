<?php namespace Core;

use Core\Exception\Exception;
use Module\Twig\Twig;

class View
{
    public static $_uGData    = [];
    public static $_uGDataEXT = null;

    private $_uFile = '';
    private $_uEXT  = EXT;
    private $_uData = [];

    public function __construct($uFile, array $uData = [], $uEXT = null)
    {
        $this->uFile = $uFile;
        $this->uData = $uData;

        if ($uEXT !== null)
        {
            $this->_uEXT = $uEXT;
        }

        $this->render();
    }

    public function __toString()
    {
        return (string) $this->render();
    }

    public function render()
    {
        if ($this->uFile === null)
        {
            throw new Exception('Не удалось определить вид');
        }

        $uPathFile = APPPATH . 'Views' . DS;

        $uFileName = str_replace('.', DS, $this->uFile) . $this->getEXT();

        $uFullPathFile = $uPathFile . $uFileName;

        if ( ! is_readable($uFullPathFile))
        {
            throw new Exception('Не существует вид: :uFile, полный путь: :uPathFile', [
                ':uFile'     => $this->uFile,
                ':uFullPathFile' => $uFullPathFile
            ]);
        }

        return new Twig($uPathFile, $uFileName, array_merge($this->uData, self::$_uGData));
    }

    public function getEXT()
    {
        return ( ! empty(self::$_uGDataEXT)) ? self::$_uGDataEXT : $this->_uEXT;
    }
    
}
