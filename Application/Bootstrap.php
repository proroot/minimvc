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

Core::Init();

Route::Set('home')
	->Defaults([
		'controller' => 'Welcome'
	])
	->Home();

// Core_Route::Set('test')
// 	->Defaults([
// 		'controller' => 'Welcome',
// 		'action'     => 'Index'
// 	]);

// Core_Route::Set('test_2')
// 	->Defaults([
// 		'controller' => 'Test',
// 		'action'     => 'Index'
// 	]);

// Core_Route::Set('errorPage')
// 	->Defaults([
// 		'controller' => 'Error'
// 	])
// 	->Error();