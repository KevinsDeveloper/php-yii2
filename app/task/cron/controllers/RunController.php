<?php

namespace task\cron\controllers;

use Yii;
use yii\console\Controller;


/**
 * Class QueueController
 * @package app\controllers
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
        $cronTab = new \yii\crontab\CronTab();
        $cronTab->setJobs([
            [
                'min' => '0',
                'hour' => '0',
                'command' => 'php /path/to/project/yii some-cron',
            ],
            [
                'line' => '0 0 * * * php /path/to/project/yii another-cron'
            ]
        ]);
        $cronTab->apply();
    }

}
