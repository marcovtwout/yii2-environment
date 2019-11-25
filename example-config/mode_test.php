<?php

/**
 * Test configuration
 * Usage:
 * - Local website
 * - Local DB
 * - Standard production error pages (404, 500, etc.)
 */

return [

    'yiiDebug' => true,

    // This is the specific Web application configuration for this mode.
    // Supplied config elements will be merged into the main config array.
    'configWeb' => [
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
    ],
    
    // This is the Console application configuration. Any writable
    // console application properties can be configured here.
    // Leave array empty if not used.
    // Use value 'inherit' to copy from generated configWeb.
    'configConsole' => []
    
];
