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
