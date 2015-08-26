<?php namespace Core;

use Core\Exception\Exception;
use Module\Twig\Twig;

class View
{
    private static $_uGData = [];

    private $_uFile   = '';
    private $_uEXT    = EXT;
    private $_uData   = [];

    public static function gData(array $uData = [])
    {
        self::$_uGData = ! empty($uData) ? array_merge(self::$_uGData, $uData) : [];
    }

    public function __construct($uFile, array $uData = [], $uEXT = null)
    {
        $this->_uFile = $uFile;
        $this->_uData = $uData;

        if (null !== $uEXT)
        {
            $this->_uEXT = $uEXT;
        }
    }

    public function render()
    {
        $uPathFile = APPPATH . 'Views' . DS;

        $uFileName = str_replace('.', DS, $this->_uFile) . $this->_uEXT;

        if ( ! is_readable($uFullPathFile = $uPathFile . $uFileName))
        {
            throw new Exception('Не существует вид: :uFile, полный путь: :uFullPathFile', [
                ':uFile'         => $this->_uFile,
                ':uFullPathFile' => $uFullPathFile
            ]);
        }

        return (new Twig($uPathFile))->render($uFileName, array_merge($this->_uData, self::$_uGData));
    }
    
}
