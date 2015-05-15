<?php namespace Core;

use Core\Exception\Exception;

class Route
{
	public static $uDefaultAction = 'Index';

	private static $_uRoutes 	  = [];

	public static function set($uMethod, $uName, $uRoute)
	{
		if ( ! empty(self::$_uRoutes[$uName]))
			throw new Exception('Данный маршрут: :uRoute существует', [
				':uRoute' => $uName
			]);

		$uRoute = explode('@', $uRoute);

		self::$_uRoutes[$uName] = new self;

		if (empty($uRoute[0]))
			throw new Exception('Не удалось определить контроллер');

		self::$_uRoutes[$uName]
			->rm($uMethod)
			->controller($uRoute[0])
			->action(( ! empty($uRoute[1]))
				? $uRoute[1]
				: self::$uDefaultAction
			);

		return self::$_uRoutes[$uName];
	}

	public static function group($uCallback)
	{
		call_user_func($uCallback);
	}

	public static function all()
	{
		return self::$_uRoutes;
	}

	private $_uDefaults = [];

	public function getDefaults()
	{
		return $this->_uDefaults;
	}

	public function aHome()
	{
		$this->_uDefaults['Home'] = true;

		return $this;
	}

	public function aError()
	{
		$this->_uDefaults['Error'] = true;

		return $this;
	}

	private function rm($uTypes)
	{
		$this->_uDefaults['RM'] = explode('|', $uTypes);

		return $this;
	}

	private function controller($uController)
	{
		$this->_uDefaults['Controller'] = $uController;

		return $this;
	}

	private function action($uAction)
	{
		$this->_uDefaults['Action'] = $uAction;

		return $this;
	}
}
