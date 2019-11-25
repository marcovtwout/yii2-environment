#!/usr/bin/env php
<?php

require __DIR__ . '/../../vendor/autoload.php';

$env = \marcovtwout\YiiEnvironment\Environment('TEST');

defined('YII_DEBUG') or define('YII_DEBUG', $env->yiiDebug);
defined('YII_ENV') or define('YII_ENV', $env->getYiiEnv());

require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

$application = new yii\console\Application($env->configConsole);
$exitCode = $application->run();
exit($exitCode);
