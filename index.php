<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if (strlen(getenv('YII_ENV')) != 0) define('YII_ENV', getenv('YII_ENV'));
if (strlen(getenv('YII_DEBUG')) != 0) define('YII_DEBUG', getenv('YII_DEBUG'));

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/web.php');

(new yii\web\Application($config))->run();
