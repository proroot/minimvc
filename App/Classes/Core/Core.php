<?php namespace Core;

class Core
{
	public static $uContentType = 'text/html';
	public static $uCharset     = 'utf-8';

	public static function init(array $uSettings = [])
	{
		ob_start();

		if ( ! empty($uSetting['uCharset']))
		{
			self::$uCharset = strtolower($uSettings['uCharset']);
		}

		$_GET    = self::sanitize($_GET);
		$_POST   = self::sanitize($_POST);
		$_COOKIE = self::sanitize($_COOKIE);
		$_SERVER = self::sanitize($_SERVER);
	}

	public static function sanitize($uValue)
	{
		if (is_array($uValue) || is_object($uValue))
		{
			foreach ($uValue as $uKey => $uVal)
			{
				$uValue[$uKey] = self::sanitize($uVal);
			}
		}
		elseif (is_string($uValue))
		{
			$uValue = trim($uValue);
		}

		return $uValue;
	}

	public static function autoLoad($uClass)
	{
		$uClass     = ltrim($uClass, '\\');
		$uPathClass = APPPATH . 'Classes' . DS;
		$uNamespace = '';

		if ($uLastNamespacePosition = strripos($uClass, '\\'))
		{
			$uNamespace  = substr($uClass, 0, $uLastNamespacePosition);
			$uClass      = substr($uClass, $uLastNamespacePosition + 1);
			$uPathClass .= str_replace('\\', DS, $uNamespace) . DS;
		}

		$uPathClass .= str_replace('_', DS, $uClass) . '.php';

		if (is_readable($uPathClass))
		{
			return self::load($uPathClass);
		}
	}

	public static function load($uFile)
	{
		return require_once $uFile;
	}
	
}
