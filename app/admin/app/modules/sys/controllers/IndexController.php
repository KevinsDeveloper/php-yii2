<?php

/**
 *
 * User: Yimpor
 * Date: 2017/1/10
 * Time: 14:01
 */

namespace admin\modules\sys\controllers;

class IndexController extends \admin\components\BaseController
{

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 09:33:39
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index.tpl');
    }

}
