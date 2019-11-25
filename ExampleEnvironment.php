<?php

/**
 * This is an example Environment, for when you want to use a custom $envVar
 * or want to use other than the predefined modes.
 *
 * If you use the extended class, don't forget to modify your bootstrap file as well
 * to call this class.
 */
class ExampleEnvironment extends \marcovtwout\YiiEnvironment\Environment
{
    /**
     * @var string name of env var to check
     */
    public $envVar = 'MY_ENVIRONMENT';

    /**
     * @var array list of valid modes
     */
    public $validModes = [
        100 => 'DEVELOPMENT',
        200 => 'TEST',
        250 => 'QUALITY_ASSURANCE',
        300 => 'STAGING',
        400 => 'PRODUCTION'
    ];
        
    /**
     * @var array @see https://www.yiiframework.com/doc/guide/2.0/en/concept-configurations#environment-constants
     */
    public $modeToYiiEnvMap = [
        'DEVELOPMENT' => 'dev',
        'TEST' => 'test',
        'QUALITY_ASSURANCE' => 'prod',
        'STAGING' => 'prod',
        'PRODUCTION' => 'prod'
    ];
}
