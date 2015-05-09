<?php namespace Core;

use Core\Exception\Exception;

class Route
{
	public static $uDefaultAction = 'Index';

	private static $_uRoutes 	  = [];

	public static function set($uName)
	{
		if ( ! empty(self::$_uRoutes[$uName]))
			throw new Exception('Данный маршрут: :uRoute существует', [
				':uRoute' => $uName
			]);

		return self::$_uRoutes[$uName] = new self;
	}

	public static function all()
	{
		return self::$_uRoutes;
	}

	public static function get($uName)
	{
		if (empty(self::$_uRoutes[$uName]))
			throw new Exception('Не существует данный маршрут: :uRoute', [
				':uRoute' => $uName
			]);

		return self::$_uRoutes[$uName];
	}

	private $_uDefaults = [];

	public function defaults(array $uDefaults = [])
	{
		if (empty($uDefaults))
			return $this->_uDefaults;

		$this->_uDefaults = $uDefaults;

		return $this;
	}

	public function setHome()
	{
		$this->_uDefaults['Home'] = true;

		return $this;
	}

	public function setError()
	{
		$this->_uDefaults['Error'] = true;

		return $this;
	}
}
