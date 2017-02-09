<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace apps\modules\home\controllers;

use apps\base\Controller;

/**
 * 默认控制器
 * Class IndexController
 * @package apps\modules\home\controllers
 */
class IndexController extends Controller
{
    public function init()
    {
        parent::init();
        #获取通用栏目
        $this->getRestCate(\Yii::$app->request->url);
    }

    public function actionIndex()
    {
        return $this->render('index.tpl');
    }

}
