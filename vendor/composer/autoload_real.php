<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc0a8a95560ec22f728f27f6a19f7c5d5
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitc0a8a95560ec22f728f27f6a19f7c5d5', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc0a8a95560ec22f728f27f6a19f7c5d5', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc0a8a95560ec22f728f27f6a19f7c5d5::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}