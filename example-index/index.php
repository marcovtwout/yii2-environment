<?php

require __DIR__ . '/../vendor/autoload.php';

$env = new \marcovtwout\YiiEnvironment\Environment();

defined('YII_ENV') or define('YII_ENV', $env->getYiiEnv());
defined('YII_DEBUG') or define('YII_DEBUG', $env->yiiDebug);

require __DIR__ . '/../application/vendor/yiisoft/yii2/Yii.php';

(new yii\web\Application($env->configWeb))->run();
