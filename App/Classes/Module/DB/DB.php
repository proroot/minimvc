<?php namespace Module\DB;

use PDO;

use Core\Exception\CoreException;

class DB
{
    protected static $_uInstance = null;
    protected $_uDB;

    private $_uHost     = '127.0.0.1';
    private $_uBase     = 'vk';
    private $_uLogin    = 'root';
    private $_uPassword = '';

    public static function instance()
    {
        return null === self::$_uInstance
            ? self::$_uInstance = new self
            : self::$_uInstance;
    }

    public function query($uSql, array $uData = [])
    {
        if ($uQuery = $this->_uDB->prepare($uSql))
        {
            $uQuery->execute($uData);

            return $uQuery;
        }
    }

    public function fetch($uSql, array $uData = [], $uFlag = PDO::FETCH_ASSOC)
    {
        if ($uFetch = $this->query($uSql, $uData))
        {
            return $uFetch->fetch($uFlag);
        }
    }

    public function fetchAll($uSql, array $uData = [], $uFlag = PDO::FETCH_ASSOC)
    {
        if ($uFetch = $this->query($uSql, $uData))
        {
            return $uFetch->fetchAll($uFlag);
        }
    }

    public function rowCount($uSql, array $uData = [])
    {
        if ($uCount = $this->query($uSql, $uData))
        {
            return $uCount->rowCount();
        }
    }

    private function __construct()
    {
        $this->_uDB = new PDO(
            'mysql:host=' . $this->_uHost . ';dbname=' . $this->_uBase . ';charset=utf8',
            $this->_uLogin, $this->_uPassword, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT         => true,
                PDO::ATTR_EMULATE_PREPARES   => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8 COLLATE utf8_general_ci'
            ]
        );
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }
    
}
