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

class IndexController extends \admin\components\BaseController
{

    public function actionIndex()
    {
        $this->_data['logindata'] = $this->auth;
        $this->_data['groupdata'] = \admin\models\DbAdminRole::findOne(['id' => $this->auth['group_id']]);
        return parent::autoRender();
    }

}
