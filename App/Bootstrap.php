<?php

/**
 * Load the core class
 */

require_once APPPATH . 'Classes/Core/Core.php';

/**
 * Enable the core auto loader
 */

spl_autoload_register([
    'Core\Core',
    'AutoLoad'
]);

/**
 * Enable the composer auto loader
 */

if (is_readable($uLoadPathComposer = APPPATH . 'Classes/Composer/autoload.php'))
{
    require_once $uLoadPathComposer;
}

/**
 * Set exception handler
 */

set_exception_handler([
	'Core\Exception\Exception',
	'Handler'
]);

/**
 * Initialization core
 */

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
