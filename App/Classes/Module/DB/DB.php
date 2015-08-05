<?php namespace Module\DB;

use PDO;

use Core\Exception\Exception;

class DB
{
    protected static $uInstance = null;

    private $uHost     = '';
    private $uBase     = '';
    private $uLogin    = '';
    private $uPassword = '';

    public static function instance()
    {
        return null !== self::$uInstance
            ? self::$uInstance
            : new self;
    }

    public function query($uSql, array $uData = [])
    {

        if ($uQuery = self::$uInstance->prepare($uSql))
        {
            $uQuery->execute($uData);

            return $uQuery;
        }
    }

    public function fetch($uSql, array $uData = [])
    {
        if ($uFetch = $this->query($uSql, $uData))
        {
            return $uFetch->fetch(PDO::FETCH_ASSOC);
        }
    }

    private function __construct()
    {
        if (empty($this->uHost) || empty($this->uBase) || empty($this->uLogin) || empty($this->uPassword))
        {
            throw new Exception('Один из параметров пуст');
        }

        self::$uInstance = new PDO('mysql:host=' . $this->uHost . ';dbname=' . $this->uBase . ';charset=utf8', $this->uLogin, $this->uPassword, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_EMULATE_PREPARES   => true,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8 COLLATE utf8_general_ci'
        ]);
    }

    private function __clone()
    {

    }
    
}
