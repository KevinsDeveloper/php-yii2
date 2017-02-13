<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\modules\setting;

use Yii;

/**
 * Class SettingModule
 * @package admin\modules\setting
 */
class SettingModule extends \admin\base\BaseModule
{

    public function init()
    {
        parent::init();

        $this->viewPath = '@admin/views/setting';
    }

}
