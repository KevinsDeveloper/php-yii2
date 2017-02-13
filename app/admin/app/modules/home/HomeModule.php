<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\modules\home;

use Yii;

/**
 * Class HomeModule
 * @package admin\modules\site
 */
class HomeModule extends \admin\base\BaseModule
{

    public function init()
    {
        parent::init();

        $this->viewPath = '@admin/views/home';
    }

}
