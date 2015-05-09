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

Route::set('home')
	->defaults([
		'Controller' => 'Welcome'
	])
	->setHome()
	->setError();

Route::set('test')
	->defaults([
		'Controller' => 'Welcome',
		'Action'     => 'Index'
	]);

Route::set('test_2')
	->defaults([
		'Controller' => 'Test',
		'Action'     => 'Index'
	]);

Route::set('errorPage')
	->defaults([
		'Controller' => 'Error'
	]);
