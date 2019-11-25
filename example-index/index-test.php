<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

require __DIR__ . '/../vendor/autoload.php';

$env = new \marcovtwout\YiiEnvironment\Environment('TEST');

defined('YII_ENV') or define('YII_ENV', $env->getYiiEnv());
defined('YII_DEBUG') or define('YII_DEBUG', $env->yiiDebug);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

(new yii\web\Application($env->configWeb))->run();