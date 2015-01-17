<?php

namespace Core;

use Core\Exception\Exception;

class Route
{
	public static $defaultAction = 'Index';

	/**
	 * @var array
	 */

	private static $_routes 	 = [];

	public static function Set($name)
	{
		if (isset(self::$_routes[$name]))
			throw new Exception('Данный маршрут: :route существует', [
				':route' => $name
			]);

		return self::$_routes[$name] = new self;
	}

	public static function All()
	{
		return self::$_routes;
	}

	public static function Get($name)
	{
		if ( ! isset(self::$_routes[$name]))
			throw new Exception('Не существует данный маршрут: :route', [
				':route' => $name
			]);

		return self::$_routes[$name];
	}

	private $_defaults = [];

	public function Defaults(array $defaults = null)
	{
		if ($defaults === null)
			return $this->_defaults;

		$this->_defaults = $defaults;

		return $this;
	}

	public function Home ()
	{
		$this->_defaults['home'] = true;
	}

	public function Error ()
	{
		$this->_defaults['error'] = true;
	}
}