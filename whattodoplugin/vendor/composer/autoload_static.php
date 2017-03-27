<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd2fd9586b8eb8b6f98abdddc415a7b78
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Parse\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Parse\\' => 
        array (
            0 => __DIR__ . '/..' . '/parse/php-sdk/src/Parse',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd2fd9586b8eb8b6f98abdddc415a7b78::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd2fd9586b8eb8b6f98abdddc415a7b78::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitd2fd9586b8eb8b6f98abdddc415a7b78::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}