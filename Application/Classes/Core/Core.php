<?php

namespace Core;

class Core
{
	/**
	 * @var Content type
	 */

	public static $contentType = 'text/html';

	/**
	 * @var Charset
	 */

	public static $charset     = 'utf-8';

	/**
	 * @var Config
	 */

	public static $config;

	/**
	 * @return  void
	 */

	public static function Init(array $settings = [])
	{
		ob_start();

		if (isset($setting['charset']))
			// Set the charset
			self::$charset = strtolower($settings['charset']);

		// Сканируем все переменные запроса
		$_GET    = self::Sanitize($_GET);
		$_POST   = self::Sanitize($_POST);
		$_COOKIE = self::Sanitize($_COOKIE);
		$_SERVER = self::Sanitize($_SERVER);
	}

	/**
	 * Защита от XSS - атак
	 *
	 * @param  string $uValue
	 * @return array
	 */

	public static function Sanitize($value)
	{
		if ((is_array($value)) || (is_object($value)))
			foreach ($value as $key => $val)
				$value[$key] = self::Sanitize($val);
		elseif (is_string($value))
			$value = trim(strip_tags(htmlentities($value, ENT_QUOTES)));

		return $value;
	}

	/**
	 * @param  string $uClass
	 * @return boolen
	 */

	public static function AutoLoad($class)
	{
		$class     = ltrim($class, '\\');
		$pathClass = APPPATH . 'Classes' . DS;
		$namespace = '';

		if ($lastNamespacePosition = strripos($class, '\\'))
		{
			$namespace  = substr($class, 0, $lastNamespacePosition);
			$class      = substr($class, $lastNamespacePosition + 1);
			$pathClass  .= str_replace('\\', DS, $namespace) . DS;
		}

		$pathClass .=  str_replace('_', DS, $class) . '.php';

		if (is_readable($pathClass))
			return self::Load($pathClass);

		return false;
	}

	/**
	 * @param  string $uFile
	 * @return boolen
	 */

	public static function Load($file)
	{
		return require_once ($file);
	}
}