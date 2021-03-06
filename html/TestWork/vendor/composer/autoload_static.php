<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb687b096901b8e7cb2c82e26d2ebe28f
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TestWork\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TestWork\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'TestWork\\Controller\\FirstController' => __DIR__ . '/../..' . '/src/Controller/FirstController.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb687b096901b8e7cb2c82e26d2ebe28f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb687b096901b8e7cb2c82e26d2ebe28f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb687b096901b8e7cb2c82e26d2ebe28f::$classMap;

        }, null, ClassLoader::class);
    }
}
