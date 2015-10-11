<?php namespace Core\Exception;

use Exception;

class CoreException extends Exception
{
	public function __construct($uMessage = '', array $uVariables = [],
                                $uCode = 0, Exception $uPrevious = null)
	{
        $uMessage = ! empty($uVariables)
            ? strtr($uMessage, $uVariables)
            : $uMessage;

		parent::__construct($uMessage, (int) $uCode, $uPrevious);
	}

	public static function handler(Exception $uE)
	{
		if (DEBUG)
        {
            echo sprintf(
                '%s [ %s ]: %s ~ %s [ %d ]',
                get_class($uE), $uE->getCode(), strip_tags($uE->getMessage()),
                $uE->getFile(), $uE->getLine()
            );
        }
	}
    
}
