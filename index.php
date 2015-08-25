<?php

/**
 * Время запуска системы
 */

define('START_TIME', microtime(true));

/**
 * Количество памяти выделенной PHP, при запуске
 */

define('START_MEMORY', memory_get_usage());

/**
 * Режим отлаживания кода
 */

const DEBUG = true;

/**
 * Сепаратор
 */

const DS = DIRECTORY_SEPARATOR;

/**
 * Расширение по умолчанию для файлов ресурса
 */

const EXT = '.php';

/**
 * Полный путь
 */

define('DOCROOT', __DIR__ . DS);

/**
 * Полный путь до приложения
 */

define('APPPATH', realpath(DOCROOT . 'App') . DS);

if (DEBUG)
{
	error_reporting(-1);

	ini_set('display_errors', true);
}
else
{
	error_reporting(0);
}

require_once APPPATH . 'Bootstrap.php';
