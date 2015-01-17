<?php

namespace Core;

use Core\Route;
use Core\Exception\Exception;

class Request
{
	private static $trustedProxies = [
		'127.0.0.1',
		'localhost',
		'localhost.localdomain'
	];

	public static function Factory()
	{
		$request = new self;

		$request->Method(isset($_SERVER['REQUEST_METHOD'])
			? $_SERVER['REQUEST_METHOD']
			: 'GET'
		);

		// Проверка на безопасное подключение https
		if ((( ! empty($_SERVER['HTTPS'])) && (filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN)))
			|| ((isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'))
				&& (in_array($_SERVER['REMOTE_ADDR'], self::$trustedProxies)))
			$request->Secure(true);

		// Получаем referrer
		if (isset($_SERVER['HTTP_REFERER']))
			$request->Referrer($_SERVER['HTTP_REFERER']);

		// Получаем user agent
		if (isset($_SERVER['HTTP_USER_AGENT']))
			$request->UserAgent($_SERVER['HTTP_USER_AGENT']);

		// Проверка на Ajax - запрос
		if ((isset($_SERVER['HTTP_X_REQUESTED_WITH'])) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
			$request->Ajax(true);

		// Получаем IP - адрес пользователя
		if ((isset($_SERVER['HTTP_X_FORWARDED_FOR'])) && (isset($_SERVER['REMOTE_ADDR']))
			&& (in_array($_SERVER['REMOTE_ADDR'], self::$trustedProxies)))
			// Определяем реальный IP - адрес
			$clientIp = array_shift(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		elseif ((isset($_SERVER['HTTP_CLIENT_IP'])) && (isset($_SERVER['REMOTE_ADDR']))
			&& (in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies)))
			// Определяем реальный IP - адрес
			$clientIp = array_shift(explode(',', $_SERVER['HTTP_CLIENT_IP']));
		elseif (isset($_SERVER['REMOTE_ADDR']))
			$clientIp = $_SERVER['REMOTE_ADDR'];

		if (isset ($clientIp))
			$request->ClientIp($clientIp);

		if (isset($_GET['route']))
			$request->ClientRoute($_GET['route']);

		return $request;
	}

	public static function Proccess(Request $request)
	{
		$clientRoute = $request->ClientRoute();

		$params 	  = [];

		foreach (Route::All() as $name => $route)
		{
			$routeDefaults = $route->Defaults();

			if (isset($routeDefaults['home']))
			{
				unset($routeDefaults['home']);

				$params['homeParams'] = $routeDefaults;
			}

			if (isset($routeDefaults['error']))
			{
				unset($routeDefaults['error']);

				$params['errorParams'] = $routeDefaults;
			}

			if ($clientRoute == $name)
				$params['clientParams'] = $routeDefaults;

			if (count($params) == 2)
				break;
		}

		return $params;
	}

	private $_controller;

	private $_action;

	private $_clientRoute = '';

	private $_method      = 'GET';

	private $_userAgent   = '';

	private $_clientIp    = '0.0.0.0';

	private $_secure      = false;

	private $_referrer    = '';

	private $_ajax        = false;

	public function Execute()
	{
		$processed = self::Proccess($this);

		if (isset($processed['clientParams']))
			$params = $processed['clientParams'];
		elseif ((isset($processed['errorParams'])) && ( ! empty($this->ClientRoute())))
			$params = $processed['errorParams'];
		elseif (isset($processed['homeParams']))
			$params = $processed['homeParams'];

		if ( ! isset($params))
			throw new Exception('Не удалось определить параметры маршрута..');

		$this->Controller($params['controller']);

		$this->Action((isset($params['action']))
			? $params['action']
			: Route::$defaultAction
		);

		$nameController = 'Controller_' . $this->Controller();

		if ( ! class_exists($nameController))
			throw new Exception('Не существует класс контроллера: :controller', [
				':controller' => $nameController
			]);

		return new $nameController($this);
	}

	public function ClientRoute($clientRoute = null)
	{
		if ($clientRoute === null)
			return $this->_clientRoute;

		$this->_clientRoute = (! empty($clientRoute))
			? strtolower($clientRoute)
			: '';

		return $this;
	}

	public function Secure($secure = null)
	{
		if ($secure === null)
			return $this->_secure;

		$this->_secure = (bool) $secure;

		return $this;
	}

	public function Controller($controller = null)
	{
		if ($controller === null)
			return $this->_controller;

		$this->_controller = (string) $controller;

		return $this;
	}

	public function Action($action = null)
	{
		if ($action === null)
			return $this->_action;

		$this->_action = (string) $action;

		return $this;
	}

	public function Method($method = null)
	{
		if ($method === null)
			return $this->_method;

		$this->_method = strtoupper($method);

		return $this;
	}

	public function ClientIp($clientIp = null)
	{
		if ($clientIp === null)
			return $this->_clientIp;

		$this->_clientIp = (string) $clientIp;

		return $this;
	}

	public function UserAgent($userAgent = null)
	{
		if ($userAgent === null)
			return $this->_userAgent;

		$this->_userAgent = (string) $userAgent;

		return $this;
	}

	public function Referrer($referrer = null)
	{
		if ($referrer === null)
			return $this->_referrer;

		$this->_referrer = (string) $referrer;

		return $this;
	}

	public function Ajax($ajax = null)
	{
		if ($ajax === null)
			return $this->_ajax;

		$this->_ajax = (bool) $ajax;

		return $this;
	}
}