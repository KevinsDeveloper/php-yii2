<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace apps\modules\home;

use Yii;
use apps\base\Module;

/**
 * 默认模块
 * Class HomeModule
 * @package apps\modules\home
 */
class HomeModule extends Module
{

    public function init()
    {
        parent::init();

        $this->viewPath = '@apps/themes/views/home';
    }

}
