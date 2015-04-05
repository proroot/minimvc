<?php

namespace Core;

class Core
{
	/**
	 * @var Content type
	 */

	public static $uContentType = 'text/html';

	/**
	 * @var Charset
	 */

	public static $uCharset     = 'utf-8';

	/**
	 * @var Config
	 */

	public static $uConfig;

	/**
	 * @return  void
	 */

	public static function Init (array $uSettings = [])
	{
		ob_start();

		if ( ! empty ($uSetting['uCharset']))
			// Set the charset
			self::$uCharset = strtolower ($uSettings['uCharset']);

		// Сканируем все переменные запроса
		$_GET    = self::Sanitize ($_GET);
		$_POST   = self::Sanitize ($_POST);
		$_COOKIE = self::Sanitize ($_COOKIE);
		$_SERVER = self::Sanitize ($_SERVER);
	}

	/**
	 * Защита от XSS - атак
	 *
	 * @param  string $uValue
	 * @return array
	 */

	public static function Sanitize ($uValue)
	{
		if (is_array ($uValue) || is_object ($uValue))
		{
			foreach ($uValue as $uKey => $uVal)
				$uValue[$uKey] = self::Sanitize ($uVal);
		}
		elseif (is_string ($uValue))
			$uValue = trim (
				strip_tags (
					htmlentities ($uValue, ENT_QUOTES)
				)
			);

		return $uValue;
	}

	/**
	 * @param  string $uClass
	 * @return boolen
	 */

	public static function AutoLoad ($uClass)
	{
		$uClass     = ltrim ($uClass, '\\');
		$uPathClass = APPPATH . 'Classes' . DS;
		$uNamespace = '';

		if ($uLastNamespacePosition = strripos ($uClass, '\\'))
		{
			$uNamespace  = substr ($uClass, 0, $uLastNamespacePosition);
			$uClass      = substr ($uClass, $uLastNamespacePosition + 1);
			$uPathClass .= str_replace ('\\', DS, $uNamespace) . DS;
		}

		$uPathClass .=  str_replace ('_', DS, $uClass) . '.php';

		if (is_readable ($uPathClass))
			return self::Load ($uPathClass);

		return;
	}

	/**
	 * @param  string $uFile
	 * @return boolen
	 */

	public static function Load ($uFile)
	{
		return require_once $uFile;
	}
}
