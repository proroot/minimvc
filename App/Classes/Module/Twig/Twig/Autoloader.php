<?php namespace Module\Twig\Twig;

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Autoloads Twig classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Autoloader
{
    /**
     * Registers Twig_Autoloader as an SPL autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not.
     */
    public static function register($prepend = false)
    {
        if (PHP_VERSION_ID < 50300) {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        } else {
            spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        }
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload($uClass)
    {
        if (0 !== strpos($uClass, 'Twig'))
            return;

        if (is_file($uFile = __DIR__ . DS . '..' . DS . str_replace(array('_', "\0"), array('/', ''), $uClass).  '.php'))
            require $uFile;
    }
}
