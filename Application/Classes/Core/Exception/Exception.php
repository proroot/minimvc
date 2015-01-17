<?php

namespace Core\Exception;

class Exception extends \Exception
{
	public function __construct($message = null, array $variables = null, $code = 0, Exception $previous = null)
	{
		if ($variables)
			$message = strtr($message, $variables);

		parent::__construct ($message, (int) $code, $previous);
	}

	public static function Handler(Exception $e)
	{
		if (DEBUG)
			echo sprintf('%s [ %s ]: %s ~ %s [ %d ]', get_class($e), $e->getCode(), strip_tags($e->getMessage()), $e->getFile(), $e->getLine());
	}
}