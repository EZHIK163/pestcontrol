<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5db821c3ed9fcc488b667289338a5bb5
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Yaml\\' => 23,
            'Symfony\\Component\\EventDispatcher\\' => 34,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $prefixesPsr0 = array (
        'W' => 
        array (
            'WebDriver' => 
            array (
                0 => __DIR__ . '/..' . '/instaclick/php-webdriver/lib',
            ),
        ),
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/process',
            ),
            'Symfony\\Component\\Finder\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/finder',
            ),
            'Symfony\\Component\\DomCrawler\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/dom-crawler',
            ),
            'Symfony\\Component\\CssSelector' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/css-selector',
            ),
            'Symfony\\Component\\BrowserKit\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/browser-kit',
            ),
            'Selenium' => 
            array (
                0 => __DIR__ . '/..' . '/alexandresalome/php-selenium/src',
            ),
        ),
        'P' => 
        array (
            'PhpAmqpLib' => 
            array (
                0 => __DIR__ . '/..' . '/videlalvaro/php-amqplib',
            ),
        ),
        'G' => 
        array (
            'Guzzle\\Stream' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/stream',
            ),
            'Guzzle\\Parser' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/parser',
            ),
            'Guzzle\\Http' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/http',
            ),
            'Guzzle\\Common' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/common',
            ),
            'Goutte' => 
            array (
                0 => __DIR__ . '/..' . '/fabpot/goutte',
            ),
        ),
        'C' => 
        array (
            'Codeception' => 
            array (
                0 => __DIR__ . '/..' . '/codeception/codeception/src',
            ),
        ),
        'B' => 
        array (
            'Behat\\Mink\\Driver' => 
            array (
                0 => __DIR__ . '/..' . '/behat/mink-browserkit-driver/src',
                1 => __DIR__ . '/..' . '/behat/mink-goutte-driver/src',
                2 => __DIR__ . '/..' . '/behat/mink-selenium-driver/src',
                3 => __DIR__ . '/..' . '/behat/mink-selenium2-driver/src',
                4 => __DIR__ . '/..' . '/behat/mink-zombie-driver/src',
            ),
            'Behat\\Mink' => 
            array (
                0 => __DIR__ . '/..' . '/behat/mink/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5db821c3ed9fcc488b667289338a5bb5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5db821c3ed9fcc488b667289338a5bb5::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit5db821c3ed9fcc488b667289338a5bb5::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
