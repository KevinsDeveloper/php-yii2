<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace server\workerman\app\controllers;

use Yii;
use yii\console\Exception;
use yii\console\Controller;
use Workerman\Worker;

/**
 * 默认控制器
 * Class ChatController
 * @package server\workerman\app\controllers
 */
class ChatController extends Controller
{
    /**
     * @var type 
     */
    protected $argv;

    /**
     * init继承
     */
    public function init()
    {
        parent::init();

        // 为workman准备argv
        unset($_SERVER['argv'][0]);
        sort($_SERVER['argv']);
        Yii::$app->params['argv'] = $_SERVER['argv'];
    }

    /**
     * 执行action后数据处理
     * @param \yii\base\Action $action
     * @param mixed $result
     */
    public function afterAction($action, $result)
    {
        $string = is_array($result) ? implode(" ", $result) : $result;
        echo TaskCommon::conversion($string);
        parent::afterAction($action, $result);
    }

    /**
     * 开启workman
     */
    public function actionWorker()
    {
        if (strpos(strtolower(PHP_OS), 'win') === 0) {
            exit("start.php not support windows, please use start_for_win.bat\n");
        }

        // 标记是全局启动
        define('GLOBAL_START', 1);

        require_once dirname(__DIR__) . '/vendor/Workerman/Autoloader.php';
        // 加载所有Applications/*/start.php，以便启动所有服务
        foreach (glob(__DIR__ . '/chat/start*.php') as $start_file) {
            require_once $start_file;
        }
        // 运行所有服务
        Worker::runAll();
    }

}
