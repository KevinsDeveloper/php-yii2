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
        echo time();
    }

}
