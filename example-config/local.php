<?php

/**
 * Local configuration override.
 * Use this to override elements in the config array (combined from main.php and mode_x.php)
 * NOTE: When using a version control system, do NOT commit this file to the repository.
 */

return [

    //'yiiDebug' => false,

    // This is the specific Web application configuration for this mode.
    // Supplied config elements will be merged into the main config array.
    'configWeb' => [
        'components' => [
            //...
        ],
    ],
    
    // This is the Console application configuration. Any writable
    // console application properties can be configured here.
    // Leave array empty if not used.
    // Use value 'inherit' to copy from generated configWeb.
    'configConsole' => []
    
];
