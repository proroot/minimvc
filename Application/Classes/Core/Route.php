<?php

namespace Core;

use Core\Exception\Exception;

class Route
{
	public static $uDefaultAction = 'Index';

	private static $_uRoutes 	  = [];

	public static function Set ($uName)
	{
		if ( ! empty (self::$_uRoutes[$uName]))
			throw new Exception('Данный маршрут: :uRoute существует', [
				':uRoute' => $uName
			]);

		return self::$_uRoutes[$uName] = new self;
	}

	public static function All()
	{
		return self::$_uRoutes;
	}

	public static function Get ($uName)
	{
		if (empty (self::$_uRoutes[$uName]))
			throw new Exception('Не существует данный маршрут: :uRoute', [
				':uRoute' => $uName
			]);

		return self::$_uRoutes[$uName];
	}

	private $_uDefaults = [];

	public function Defaults (array $uDefaults = [])
	{
		if (empty ($uDefaults))
			return $this->_uDefaults;

		$this->_uDefaults = $uDefaults;

		return $this;
	}

	public function SetHome()
	{
		$this->_uDefaults['Home'] = true;

		return $this;
	}

	public function SetError()
	{
		$this->_uDefaults['Error'] = true;

		return $this;
	}
}