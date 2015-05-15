<?php

/**
 * Load the core class
 */

require_once APPPATH . 'Classes/Core/Core.php';

use Core\Core;
use Core\Route;

/**
 * Enable the Core autoLoader.
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

Route::set('POST|GET', '', 'Welcome@Test2')->aHome();

Route::group(function()
{
	Route::set('GET', 'test', 'Welcome');

	Route::set('GET', 'test2', 'Welcome');
});

Route::set('GET', 'errorPage', 'Error');
