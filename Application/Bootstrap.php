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

Route::Set ('home')
	->Defaults ([
		'Controller' => 'Welcome'
	])
	->SetHome()
	->SetError();

Route::Set ('test')
	->Defaults ([
		'Controller' => 'Welcome',
		'Action'     => 'Index'
	]);

Route::Set ('test_2')
	->Defaults ([
		'Controller' => 'Test',
		'Action'     => 'Index'
	]);

Route::Set ('errorPage')
	->Defaults ([
		'Controller' => 'Error'
	]);
