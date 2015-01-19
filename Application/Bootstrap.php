<?php

/**
 * Load the core class
 */

require_once APPPATH . 'Classes/Core/Core.php';

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

Core\Core::Init();

use Core\Route;

Route::Set('home')
	->Defaults([
		'controller' => 'Welcome'
	])
	->Home();

Route::Set('test')
	->Defaults([
		'controller' => 'Welcome',
		'action'     => 'Index'
	]);

Route::Set('test_2')
	->Defaults([
		'controller' => 'Test',
		'action'     => 'Index'
	]);

Route::Set('errorPage')
	->Defaults([
		'controller' => 'Error'
	])
	->Error();