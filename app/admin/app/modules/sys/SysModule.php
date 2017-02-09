<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\modules\sys;

use Yii;

/**
 * Class Module
 * @package app\modules
 */
class SysModule extends \admin\components\BaseModule
{
    public function init()
    {
        parent::init();

        $this->viewPath = '@admin/themes/views/sys';
    }

}
