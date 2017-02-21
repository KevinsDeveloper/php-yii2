<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\modules\site\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;

/**
 * 默认控制器
 */
class IndexController extends \admin\base\BaseController
{
    /**
     * 默认页
     * @return type
     */
    public function actionIndex()
    {
        return parent::autoRender();
    }

    /**
     * 右边默认页面
     * @return type
     */
    public function actionMain()
    {
        $this->data['time'] = time();
        return parent::autoRender();
    }

}
