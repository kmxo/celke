<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
            'Adms\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Adms\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/adms',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6e0636e0f47e0871f2e90377a6748aa1::$classMap;

        }, null, ClassLoader::class);
    }
}
