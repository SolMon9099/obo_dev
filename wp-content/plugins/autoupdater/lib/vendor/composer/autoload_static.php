<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit66700fc932df1dd1e9de5cf929a361af
{
    public static $files = array (
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        '3109cb1a231dcd04bee1f9f620d46975' => __DIR__ . '/..' . '/paragonie/sodium_compat/autoload.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit66700fc932df1dd1e9de5cf929a361af::$classMap;

        }, null, ClassLoader::class);
    }
}
