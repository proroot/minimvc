<?php

/**
 * Load the core class
 */

require_once APPPATH . 'Classes/Core/Core.php';

use Core\Core;

/**
 * Enable the Core auto Loader
 */

spl_autoload_register([
	'Core\Core',
	'AutoLoad'
]);

set_exception_handler([
	'Core\Exception\Exception',
	'Handler'
]);

Core::init();
