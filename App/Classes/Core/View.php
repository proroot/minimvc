<?php namespace Core;

use Core\Exception\Exception;
use Module\Twig\Twig;

class View
{
    private static $_uGData = [];

    private $_uFile  = '';
    private $_uEXT   = EXT;
    private $_uData  = [];
    private $uRender = '';

    public static function gData(array $uData = [])
    {
        self::$_uGData = ! empty($uData) ? array_merge(self::$_uGData, $uData) : [];
    }

    public function __construct($uFile, array $uData = [], $uEXT = null)
    {
        $this->uFile = $uFile;
        $this->uData = $uData;

        if (null !== $uEXT)
        {
            $this->_uEXT = $uEXT;
        }
    }

    public function render()
    {
        $uPathFile = APPPATH . 'Views' . DS;

        $uFileName = str_replace('.', DS, $this->uFile) . $this->_uEXT;

        $uFullPathFile = $uPathFile . $uFileName;

        if ( ! is_readable($uFullPathFile))
        {
            throw new Exception('Не существует вид: :uFile, полный путь: :uPathFile', [
                ':uFile'     => $this->uFile,
                ':uFullPathFile' => $uFullPathFile
            ]);
        }

        return (new Twig($uPathFile))->render($uFileName, array_merge($this->uData, self::$_uGData));
    }
    
}
