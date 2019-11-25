<?php

/**
 * Main configuration.
 * All properties can be overridden in mode_<mode>.php files
 */

return [

    'yiiDebug' => true,

    // This is the main Web application configuration. Any writable
    // CWebApplication properties can be configured here.
    'configWeb' => [
        'basePath' => __DIR__ . '/..',
        'name' => 'My Web Application',
        'components' => [
            // ...
        ]
    ],

    // This is the Console application configuration. Any writable
    // console application properties can be configured here.
    // Leave array empty if not used.
    // Use value 'inherit' to copy from generated configWeb.
    'configConsole' => [
        'basePath' => 'inherit',
        'name' => 'My Console Application',
        'aliases' => 'inherit',
        'components' => [
            // ...
        ],
    ],

];
