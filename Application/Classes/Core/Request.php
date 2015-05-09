<?php namespace Core;

use Core\Route;
use Core\Exception\Exception;

class Request
{
	private static $uTrustedProxies = [
		'127.0.0.1',
		'localhost',
		'localhost.localdomain'
	];

	public static function factory()
	{
		$uRequest = new self;

		$uRequest->Method ( ! empty($_SERVER['REQUEST_METHOD'])
			? $_SERVER['REQUEST_METHOD']
			: 'GET'
        );

		// Check HTTPS
		if ( ! empty($_SERVER['HTTPS']) && (filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
			|| ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
				&& in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies))
			$uRequest->secure(true);

		// Referrer
		if (isset($_SERVER['HTTP_REFERER']))
			$uRequest->referrer($_SERVER['HTTP_REFERER']);

		// User agent
		if (isset($_SERVER['HTTP_USER_AGENT']))
			$uRequest->userAgent($_SERVER['HTTP_USER_AGENT']);

		// Check ajax
		if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
			$uRequest->ajax(true);

		// Get IP
		if ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])
			&& ! empty($_SERVER['REMOTE_ADDR'])
			&& in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies)
			)
			// Определяем реальный IP - адрес
			$uClientIp = array_shift(
				explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])
			);
		elseif ( ! empty($_SERVER['HTTP_CLIENT_IP'])
			&&  ! empty($_SERVER['REMOTE_ADDR'])
			&& in_array($_SERVER['REMOTE_ADDR'], self::$uTrustedProxies)
			)
			// Определяем реальный IP - адрес
			$uClientIp = array_shift(
				explode(',', $_SERVER['HTTP_CLIENT_IP'])
			);
		elseif ( ! empty($_SERVER['REMOTE_ADDR']))
			$uClientIp = $_SERVER['REMOTE_ADDR'];
		else
			$uClientIp = null;

		$uRequest->clientIp($uClientIp);

		if ( ! empty($_GET['uRoute']))
			$uRequest->clientRoute($_GET['uRoute']);

		return $uRequest;
	}

	public static function proccess(Request $uRequest)
	{
		$uClientRoute = $uRequest->clientRoute();

		$uParams 	  = [];

		foreach (Route::All() as $uName => $uRoute)
		{
			$uRouteDefaults = $uRoute->defaults();

			if ($uClientRoute === $uName)
			{
				$uParams['uClient'] = $uRouteDefaults;
				break;
			}

			if (isset($uRouteDefaults['Home']))
				$uParams['uHome'] = $uRouteDefaults;

			if (isset($uRouteDefaults['Error']))
				$uParams['uError'] = $uRouteDefaults;
		}

		if ( ! empty($uParams['uClient']))
			return $uParams['uClient'];

		if ( ! empty($uParams['uError']) &&  ! empty($uClientRoute))
			return $uParams['uError'];

		if ( ! empty($uParams['uHome']))
			return $uParams['uHome'];

		return;
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

	public function execute()
	{
		$uParams = self::proccess($this);

		if (empty($uParams))
			throw new Exception('Не удалось определить параметры маршрута..');

		$this->controller($uParams['Controller']);

		$this->action(( ! empty($uParams['Action']))
			? $uParams['Action']
			: Route::$uDefaultAction
		);

		$uNameController = 'Controller_' . $this->controller();

		if ( ! class_exists($uNameController))
			throw new Exception('Не существует класс контроллера: :uController', [
				':uController' => $uNameController
			]);

		return new $uNameController($this);
	}

	public function clientRoute($uClientRoute = null)
	{
		if ($uClientRoute === null)
			return $this->_uClientRoute;

		$this->_uClientRoute = ( ! empty($uClientRoute))
			? strtolower($uClientRoute)
			: ''
		;

		return $this;
	}

	public function secure($uSecure = null)
	{
		if ($uSecure === null)
			return $this->_uSecure;

		$this->_uSecure = (bool) $uSecure;

		return $this;
	}

	public function controller($uController = null)
	{
		if ($uController === null)
			return $this->_uController;

		$this->_uController = (string) $uController;

		return $this;
	}

	public function action($uAction = null)
	{
		if ($uAction === null)
			return $this->_uAction;

		$this->_uAction = (string) $uAction;

		return $this;
	}

	public function method($uMethod = null)
	{
		if ($uMethod === null)
			return $this->_uMethod;

		$this->_uMethod = strtoupper($uMethod);

		return $this;
	}

	public function clientIp($uClientIp = null)
	{
		if ($uClientIp === null)
			return $this->_uClientIp;

		$this->_uClientIp = (string) $uClientIp;

		return $this;
	}

	public function userAgent($uUserAgent = null)
	{
		if ($uUserAgent === null)
			return $this->_uUserAgent;

		$this->_uUserAgent = (string) $uUserAgent;

		return $this;
	}

	public function referrer($uReferrer = null)
	{
		if ($uReferrer === null)
			return $this->_uReferrer;

		$this->_uReferrer = (string) $uReferrer;

		return $this;
	}

	public function ajax($uAjax = null)
	{
		if ($uAjax === null)
			return $this->_uAjax;

		$this->_uAjax = (bool) $uAjax;

		return $this;
	}
}
