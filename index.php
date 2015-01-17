<?php

/**
 * Start time
 */

define ('START_TIME', microtime (true));

/**
 * Start memory
 */

define ('START_MEMORY', memory_get_usage ());

/**
 * Debug code
 */

const DEBUG = true;

/**
 * Reconstruction site
 */

const RECONSTRUCTION = false;

/**
 * Directory separator
 */

const DS = DIRECTORY_SEPARATOR;

/**
 * Full path
 */

define ('DOCROOT', __DIR__ . DS);

/**
 * The full path to the application -> Application
 */

define ('APPPATH', realpath (DOCROOT . 'Application') . DS);

/**
 * Error output
 */

if (DEBUG)
{
	error_reporting (E_ALL);

	ini_set ('display_errors', true);
}
else
	error_reporting (0);


/**
 * Bootstrap the application
 */

require_once APPPATH . 'Bootstrap.php';

echo Core\Request::Factory ()
	->Execute ();