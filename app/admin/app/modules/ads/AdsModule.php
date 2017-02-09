<?php

namespace admin\modules\ads;

use admin\components\BaseModule;

class AdsModule extends BaseModule
{
    public $controllerNamespace = 'admin\modules\ads\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->viewPath = '@admin/themes/views/ads';
    }
}
