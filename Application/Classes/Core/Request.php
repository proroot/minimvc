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

			if (isset ($uRouteDefaults['Home']))
			{
				unset ($uRouteDefaults['Home']);

				$uParams['uHomeParams'] = $uRouteDefaults;
			}

			if (isset ($uRouteDefaults['Error']))
			{
				unset ($uRouteDefaults['Error']);

				$uParams['uErrorParams'] = $uRouteDefaults;
			}

			if ($uClientRoute == $uName)
				$uParams['uClientParams'] = $uRouteDefaults;

            if (count ($uParams) === 2)
				break;
		}

		return $uParams;
	}

	private $_uController;

	private $_uAction;

	private $_uClientRoute = '';

	private $_uMethod      = 'GET';

	private $_uUserAgent   = '';

	private $_uClientIp    = '0.0.0.0';

	private $_uSecure      = false;

	private $_uReferrer    = '';

	private $_uAjax        = false;

	public function Execute()
	{
		$uProcessed = self::Proccess ($this);

		if (isset ($uProcessed['uClientParams']))
			$uParams = $uProcessed['uClientParams'];
		elseif (isset ($uProcessed['uErrorParams']) && ! empty ($this->ClientRoute()))
			$uParams = $uProcessed['uErrorParams'];
		elseif (isset ($uProcessed['uHomeParams']))
			$uParams = $uProcessed['uHomeParams'];
		else
			throw new Exception ('Не удалось определить параметры маршрута..');

		$this->Controller($uParams['Controller']);

		$this->Action (( ! empty ($uParams['Action']))
			? $uParams['Action']
			: Route::$uDefaultAction
		);

		$uNameController = 'Controller_' . $this->Controller();

		if ( ! class_exists ($uNameController))
			throw new Exception ('Не существует класс контроллера: :uController', [
				':uController' => $uNameController
			]);

		return new $uNameController ($this);
	}

	public function ClientRoute ($uClientRoute = null)
	{
		if ($uClientRoute === null)
			return $this->_uClientRoute;

		$this->_uClientRoute = ( ! empty ($uClientRoute))
			? strtolower ($uClientRoute)
			: ''
		;

		return $this;
	}

	public function Secure ($uSecure = null)
	{
		if ($uSecure === null)
			return $this->_uSecure;

		$this->_uSecure = (bool) $uSecure;

		return $this;
	}

	public function Controller ($uController = null)
	{
		if ($uController === null)
			return $this->_uController;

		$this->_uController = (string) $uController;

		return $this;
	}

	public function Action ($uAction = null)
	{
		if ($uAction === null)
			return $this->_uAction;

		$this->_uAction = (string) $uAction;

		return $this;
	}

	public function Method ($uMethod = null)
	{
		if ($uMethod === null)
			return $this->_uMethod;

		$this->_uMethod = strtoupper ($uMethod);

		return $this;
	}

	public function ClientIp ($uClientIp = null)
	{
		if ($uClientIp === null)
			return $this->_uClientIp;

		$this->_uClientIp = (string) $uClientIp;

		return $this;
	}

	public function UserAgent ($uUserAgent = null)
	{
		if ($uUserAgent === null)
			return $this->_uUserAgent;

		$this->_uUserAgent = (string) $uUserAgent;

		return $this;
	}

	public function Referrer ($uReferrer = null)
	{
		if ($uReferrer === null)
			return $this->_uReferrer;

		$this->_uReferrer = (string) $uReferrer;

		return $this;
	}

	public function Ajax ($uAjax = null)
	{
		if ($uAjax === null)
			return $this->_uAjax;

		$this->_uAjax = (bool) $uAjax;

		return $this;
	}
}
