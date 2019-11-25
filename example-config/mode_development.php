<?php

/**
 * Development configuration
 * Usage:
 * - Local website
 * - Local DB
 * - Show all details on each error
 * - Gii and debug modules enabled
 */

return [

    'yiiDebug' => true,

    // This is the specific Web application configuration for this mode.
    // Supplied config elements will be merged into the main config array.
    'configWeb' => [
        'bootstrap' => ['debug', 'gii'],
        'components' => [
            'assetManager' => [
                'linkAssets' => true,
            ],
            'db' => [
                'dsn' => '...',
                'username' => '...',
                'password' => '...',
            ],
            'log' => [
                'traceLevel' => 3,
                'targets' => [
                    [
                        'class' => yii\log\FileTarget::class,
                        'levels' => ['error', 'warning', 'info'],
                    ],
                ],
            ],
            'mailer' => [
                'useFileTransport' => true,
            ],
        ],
        'modules' => [
            'debug' => [
                'class' => yii\debug\Module::class,
            ],
            'gii' => [
                'class' => yii\gii\Module::class,
            ],
        ],
    ],
    
    // This is the Console application configuration. Any writable
    // console application properties can be configured here.
    // Leave array empty if not used.
    // Use value 'inherit' to copy from generated configWeb.
    'configConsole' => []
];
