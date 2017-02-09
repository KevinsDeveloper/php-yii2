<?php

namespace task\queue\controllers;

use Yii;
use yii\console\Controller;

/**
 * Class RunController
 * @package task\queue\controllers
 */
class RunController extends Controller
{

    /**
     * 要处理的作业队列
     * @var
     */
    public $queue;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        $options = parent::options($actionID);
        $newOptions = ['queue'];
        return array_merge($options, $newOptions);
    }

    public function actionIndex()
    {
        if (empty($this->queue)) {
            Logger::error("Set queue containing the list of queues to work.");
            return 0;
        }
        $redis = $pidFile = null;
        $logLevel = 'warning';
        //空闲时休眠时间，默认5秒
        $interval = 5;
        //启动的进程数，1个
        $count = 1;
        if (isset(Yii::$app->params['queue'][$this->queue])) {
            $config = Yii::$app->params['queue'][$this->queue];
            //redis配置优先使用公共配置
            $redisComponent = Yii::$app->redis;
            if ($redisComponent instanceof Connection) {
                $redis = $redisComponent->hostname . ':' . $redisComponent->port;
            }
            elseif (isset($config['redis'])) {
                $redis = $config['redis'];
            }
            if (isset($config['logLevel'])) {
                $logLevel = $config['logLevel'];
            }
            if (isset($config['interval'])) {
                $interval = $config['interval'];
            }
            if (isset($config['count'])) {
                $count = $config['count'];
            }
            if (isset($config['pidFile'])) {
                $pidFile = $config['pidFile'];
            }
        }
        //设置redis实例
        if (!empty($redis)) {
            Resque::setBackend($redis);
        }
        //日志级别
        switch ($logLevel) {
            case 'profile' :
                $logLevel = Logger::LEVEL_PROFILE;
                break;
            case 'info' :
                $logLevel = Logger::LEVEL_INFO;
                break;
            case 'error' :
                $logLevel = Logger::LEVEL_ERROR;
                break;
            case 'warning' :
            default :
                $logLevel = Logger::LEVEL_WARNING;
                break;
        }
        Logger::$level = $logLevel;
        Logger::$path = Yii::getAlias('@runtime/logs');

        //开始监听队列
        if ($count > 1) {
            for ($i = 0; $i < $count; ++$i) {
                $pid = pcntl_fork();
                if ($pid == -1) {
                    Logger::error("Could not fork worker " . $i);
                    return 0;
                }
                // Child, start the worker
                else if (!$pid) {
                    $queues = explode(',', $this->queue);
                    $worker = new Worker($queues);
                    Logger::info('Starting worker ' . $worker);
                    $worker->work($interval);
                    break;
                }
            }
        }
        else {
            // Start a single worker
            $queues = explode(',', $this->queue);
            $worker = new Worker($queues);

            if ($pidFile && is_writable($pidFile)) {
                file_put_contents($pidFile, getmypid()) or
                        Logger::error('Could not write PID information to ' . $pidFile);
                return 0;
            }

            Logger::info('Starting worker ' . $worker);
            $worker->work($interval);
        }
        return 0;
    }

    public function actionCheckStatus($name)
    {
        $status = new Status($name);
        if (!$status->isTracking()) {
            echo 'Resque is not tracking the status of this job.', PHP_EOL;
            return 1;
        }

        echo 'Tracking status of ' . $name . '. Press [break] to stop.', PHP_EOL, PHP_EOL;
        while (true) {
            fwrite(STDOUT, 'Status of ' . $name . ' is: ' . $status->get() . PHP_EOL);
            sleep(1);
        }
        return 0;
    }

}
