<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1fa53de40274d4b23814d6f153ad6bc9
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1fa53de40274d4b23814d6f153ad6bc9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1fa53de40274d4b23814d6f153ad6bc9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1fa53de40274d4b23814d6f153ad6bc9::$classMap;

        }, null, ClassLoader::class);
    }
}
