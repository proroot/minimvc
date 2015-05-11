<?php namespace Core;

use Core\Exception\Exception;

class View
{
    public static $_uGData    = [];
    public static $_uGDataEXT = null;

    public static function init($uFile = null, array $uData = [], $uEXT = null)
    {
        return new self($uFile, $uData, $uEXT);
    }

    private $_uFile = '';
    private $_uEXT  = EXT;
    private $_uData = [];

    public function __construct($uFile = null, array $uData = [], $uEXT = null)
    {
        $this->uFile = $uFile;
        $this->uData = $uData;

        if ($uEXT !== null)
            $this->_uEXT = $uEXT;

        return $this->render();
    }

    public function __toString()
    {
        return (string) $this->render();
    }

    public function render()
    {
        if ($this->uFile === null)
            throw new Exception('Не удалось определить вид');

        $uPathFile = APPPATH . 'Views' . DS . str_replace('.', DS, $this->uFile) . $this->getEXT();

        if ( ! is_readable($uPathFile))
            throw new Exception('Не существует вид: :uFile, полный путь: :uPathFile', [
                ':uFile'     => $this->uFile,
                ':uPathFile' => $uPathFile
            ]);

        extract($this->uData, EXTR_SKIP);

        if ( ! empty(self::$_uGData))
            extract(self::$_uGData, EXTR_SKIP | EXTR_REFS);

        ob_start();

        try
        {
            require $uPathFile;
        }
        catch (Exception $uE)
        {
            ob_end_clean();

            throw $uE;
        }

        return ob_get_clean();
    }

    public function getEXT()
    {
        return ( ! empty(self::$_uGDataEXT)) ? self::$_uGDataEXT : $this->_uEXT;
    }
}
