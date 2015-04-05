<?php

namespace Core;

use Core\Route;
use Core\Exception\Exception;

class Request
{
	private static $uTrustedProxies = [
		'127.0.0.1',
		'localhost',
		'localhost.localdomain'
	];

	public static function Factory()
	{
		$uRequest = new self;

		$uRequest->Method (isset ($_SERVER['REQUEST_METHOD'])
			? $_SERVER['REQUEST_METHOD']
			: 'GET'
        );

		// Check HTTPS
		if ( ! empty ($_SERVER['HTTPS']) && (filter_var ($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
			|| isset ($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
				&& in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies))
			$uRequest->Secure (true);

		// Referrer
		if (isset ($_SERVER['HTTP_REFERER']))
			$uRequest->Referrer ($_SERVER['HTTP_REFERER']);

		// User agent
		if (isset ($_SERVER['HTTP_USER_AGENT']))
			$uRequest->UserAgent ($_SERVER['HTTP_USER_AGENT']);

		// Check ajax
		if (isset ($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower ($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			$uRequest->Ajax (true);

		// Get IP
		if (isset ($_SERVER['HTTP_X_FORWARDED_FOR']) && isset ($_SERVER['REMOTE_ADDR'])
			&& in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies))
			// Определяем реальный IP - адрес
			$uClientIp = array_shift (explode (',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		elseif ((isset($_SERVER['HTTP_CLIENT_IP'])) && (isset($_SERVER['REMOTE_ADDR']))
			&& (in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies)))
			// Определяем реальный IP - адрес
			$uClientIp = array_shift (explode (',', $_SERVER['HTTP_CLIENT_IP']));
		elseif (isset($_SERVER['REMOTE_ADDR']))
			$uClientIp = $_SERVER['REMOTE_ADDR'];

		if (isset ($uClientIp))
			$uRequest->ClientIp ($uClientIp);

		if ( ! empty ($_GET['uRoute']))
			$uRequest->ClientRoute ($_GET['uRoute']);

		return $uRequest;
	}

	public static function Proccess (Request $uRequest)
	{
		$uClientRoute = $uRequest->ClientRoute();

		$uParams 	  = [];

		foreach (Route::All() as $uName => $uRoute)
		{
			$uRouteDefaults = $uRoute->Defaults();

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

			if ($uClientRoute == $uName)
				$params['clientParams'] = $routeDefaults;

            if (count ($uParams) === 2)
				break;
		}

		return $uParams;
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

		$this->Controller($params['Controller']);

		$this->Action((isset($params['Action']))
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
