<?php

/**
 * Подключаем основной класс
 */

require_once APPPATH . 'Classes/Core/Core.php';

/**
 * Регистрируем функцию Core\Core::autoLoad в качестве реализации метода __autoload()
 */

spl_autoload_register([
    'Core\Core',
    'autoLoad'
]);

/**
 * Подключаем autoload сomposer'a, если есть
 */

if (is_readable($uLoadPathComposer = APPPATH . 'Classes/Composer/autoload.php'))
{
    require_once $uLoadPathComposer;
}

/**
 * Задаем пользовательский обработчик исключений
 */

set_exception_handler([
	'Core\Exception\Exception',
	'Handler'
]);

/**
 * Инициализируем ядро
 */

Core\Core::init();

/**
 * Помощники
 */

require_once APPPATH . 'Helpers.php';

/**
 * Маршруты
 */

require_once APPPATH . 'Routes.php';

/**
 * Запуск ядра
 */

echo Core\Request::init()->execute();
