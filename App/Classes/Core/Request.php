<?php namespace Core;

use Core\Route;
use Core\Exception\Exception;

class Request
{
	private static $_uInstance;

	private static $_uTrustedProxies = [
		'127.0.0.1',
		'localhost',
		'localhost.localdomain'
	];

	public static function init()
	{
		self::$_uInstance = new self;
	
		self::$_uInstance->host($_SERVER['HTTP_HOST']);

		self::$_uInstance->pathApp($_SERVER['SCRIPT_NAME']);

		self::$_uInstance->method(
			! empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET'
		);
	
		if ( ! empty($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN)
			|| ! empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
				&& 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO']
					&& in_array($_SERVER['REMOTE_ADDR'], self::$_uTrustedProxies)
		)
		{
			self::$_uInstance->secure(true);
		}
	
		if (isset($_SERVER['HTTP_REFERER']))
		{
			self::$_uInstance->referrer($_SERVER['HTTP_REFERER']);
		}
	
		if (isset($_SERVER['HTTP_USER_AGENT']))
		{
			self::$_uInstance->userAgent($_SERVER['HTTP_USER_AGENT']);
		}
	
		if ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
		{
			self::$_uInstance->ajax(true);
		}
	
		if ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])
			&& ! empty($_SERVER['REMOTE_ADDR'])
			&& in_array($_SERVER['REMOTE_ADDR'], self::$_uTrustedProxies)
		)
		{
			$uClientIp = array_shift(
				explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])
			);
		}
		elseif ( ! empty($_SERVER['HTTP_CLIENT_IP'])
			&&  ! empty($_SERVER['REMOTE_ADDR'])
			&& in_array($_SERVER['REMOTE_ADDR'], self::$_uTrustedProxies)
		)
		{
			$uClientIp = array_shift(
				explode(',', $_SERVER['HTTP_CLIENT_IP'])
			);
		}
		elseif ( ! empty($_SERVER['REMOTE_ADDR']))
		{
			$uClientIp = $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			$uClientIp = null;
		}
	
		self::$_uInstance->clientIP($uClientIp);
	
		if ( ! empty($_GET['_uRoute']))
		{
			self::$_uInstance->clientRoute($_GET['_uRoute']);
		}

		return self::$_uInstance;
	}

	public static function proccess(Request $uRequest)
	{
		$uClientRoute = $uRequest->clientRoute();

		$uParams 	  = [];

		foreach (Route::All() as $uName => $uRoute)
		{
			$uRouteDefaults = $uRoute->getDefaults();

			if ( ! empty($uRouteDefaults['RM']) &&
				$uRouteDefaults['RM'][0] != 'ANY' &&
				! in_array($uRequest->method(), $uRouteDefaults['RM'])
			)
			{
				continue;
			}

			if ($uClientRoute == $uName)
			{
				return $uRouteDefaults;
			}

			if (isset($uRouteDefaults['uHome']))
			{
				$uParams['uHome'] = $uRouteDefaults;
			}

			if (isset($uRouteDefaults['uError']))
			{
				$uParams['uError'] = $uRouteDefaults;
			}
		}

		if (isset($uParams['uError']) && ! empty($uClientRoute))
		{
			return $uParams['uError'];
		}

		if (isset($uParams['uHome']))
		{
			return $uParams['uHome'];
		}

		return;
	}

	public static function getInstance()
	{
		return self::$_uInstance;
	}

	private $_uController  = null;

	private $_uAction	   = null;

	private $_uClientRoute = null;

	private $_uHost		   = null;

	private $_uPathApp     = null;

	private $_uMethod      = null;

	private $_uUserAgent   = null;

	private $_uClientIP    = null;

	private $_uSecure      = false;

	private $_uReferrer    = null;

	private $_uAjax        = false;

	public function execute()
	{
		$uParams = self::proccess($this);

		if (empty($uParams))
		{
			throw new Exception('Не удалось определить параметры маршрута..');
		}

		$this->setContentTypeAndCharset();
		
        if (isset($uParams['uCallback']) && is_callable($uParams['uCallback']))
        {
            return call_user_func($uParams['uCallback']);
        }

		$this->controller($uParams['uController']);

		$this->action(
			! empty($uParams['uAction']) ? $uParams['uAction'] : Route::$uDefaultAction
		);

		$uNameController = 'Controller_' . $this->controller();

		if ( ! class_exists($uNameController))
		{
			throw new Exception('Не существует класс контроллера: :uController', [
				':uController' => $uNameController
			]);
		}

		return new $uNameController($this);
	}

	public function setContentTypeAndCharset()
	{
		header ('Content-Type: ' . Core::$uContentType . '; charset=' . Core::$uCharset);
	}

	public function clientRoute($uClientRoute = null)
	{
		if (null === $uClientRoute)
		{
			return $this->_uClientRoute;
		}

		$this->_uClientRoute = ! empty($uClientRoute) ? strtolower($uClientRoute) : null;

		return $this;
	}

	public function secure($uSecure = null)
	{
		if (null === $uSecure)
		{
			return $this->_uSecure;
		}

		$this->_uSecure = (bool) $uSecure;

		return $this;
	}

	public function controller($uController = null)
	{
		if (null === $uController)
		{
			return $this->_uController;
		}

		$this->_uController = (string) $uController;

		return $this;
	}

	public function action($uAction = null)
	{
		if (null === $uAction)
		{
			return $this->_uAction;
		}

		$this->_uAction = (string) $uAction;

		return $this;
	}

	public function host($uHost = null)
	{
		if (null === $uHost)
		{
			return $this->_uHost;
		}

		$this->_uHost = $uHost;

		return $this;
	}

	public function pathApp($uPathApp = null)
	{
		if (null === $uPathApp)
		{
			return $this->_uPathApp;
		}

		$this->_uPathApp = str_replace('index.php', '', $uPathApp);

		return $this;
	}

	public function method($uMethod = null)
	{
		if (null === $uMethod)
		{
			return $this->_uMethod;
		}

		$this->_uMethod = strtoupper($uMethod);

		return $this;
	}

	public function clientIP($uClientIP = null)
	{
		if (null === $uClientIP)
		{
			return $this->_uClientIP;
		}

		$this->_uClientIP = (string) $uClientIP;

		return $this;
	}

	public function userAgent($uUserAgent = null)
	{
		if (null === $uUserAgent)
		{
			return $this->_uUserAgent;
		}

		$this->_uUserAgent = (string) $uUserAgent;

		return $this;
	}

	public function referrer($uReferrer = null)
	{
		if (null === $uReferrer)
		{
			return $this->_uReferrer;
		}

		$this->_uReferrer = (string) $uReferrer;

		return $this;
	}

	public function ajax($uAjax = null)
	{
		if (null === $uAjax)
		{
			return $this->_uAjax;
		}

		$this->_uAjax = (bool) $uAjax;

		return $this;
	}
	
}
