<?php
/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

/**
 * 环境模式
 * development|production
 */
defined('ENVIRONMENT') or define('ENVIRONMENT', 'development');

/**
 * 项目基础路径
 */
defined('ROOT') or define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * 应用路径
 */
defined('APPROOT') or define('APPROOT', ROOT . 'app');

/**
 * 生产模式设为False
 * 
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);

/**
 * 堆栈等级
 */
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

/**
 * 定义STDIN
 */
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

/**
 * 定义STDOUT
 */
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'production':
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

// 框架路径，配置信息
$yii = dirname(__FILE__) . '/../../../frame/Yii.php';
$main = dirname(__FILE__) . '/config/main.' . ENVIRONMENT . '.php';
$constants = dirname(__FILE__) . '/../../lib/constants.php';

require_once($constants);
require_once($yii);
$config = require_once($main);

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
