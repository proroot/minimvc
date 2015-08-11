<?php

/**
 * Load the core class
 */

require_once APPPATH . 'Classes/Core/Core.php';

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

Core\Core::init();

/**
 * Helpers
 */

require_once APPPATH . 'Helpers.php';

/**
 * Routes
 */

require_once APPPATH . 'Routes.php';

/**
 * Run core
 */

echo Core\Request::init()->execute();
