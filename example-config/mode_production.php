<?php

/**
 * Production configuration
 * Usage:
 * - Online website
 * - Production DB
 * - Standard production error pages (404, 500, etc.)
 */

return [

    'yiiDebug' => false,

    // This is the specific Web application configuration for this mode.
    // Supplied config elements will be merged into the main config array.
    'configWeb' => [
        'components' => [
            'db' => [
                'dsn' => '...',
                'username' => '...',
                'password' => '...',
                'enableSchemaCache' => true,
            ],
            'log' => [
                'traceLevel' => 0,
                'targets' => [
                    [
                        'class' => yii\log\FileTarget::class,
                        'levels' => ['error', 'warning'],
                    ],
                ],
            ],
        ],
    ],
    
    // This is the Console application configuration. Any writable
    // console application properties can be configured here.
    // Leave array empty if not used.
    // Use value 'inherit' to copy from generated configWeb.
    'configConsole' => []
    
];
