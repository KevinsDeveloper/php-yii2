<?php

namespace admin\modules\trade;

use admin\components\BaseModule;

class TradeModule extends BaseModule
{
    public $controllerNamespace = 'admin\modules\trade\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->viewPath = '@admin/themes/views/trade';
    }
}
