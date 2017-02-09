<?php

namespace admin\modules\act;

class ActModule extends \admin\components\BaseModule
{
    public $controllerNamespace = 'admin\modules\act\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->viewPath = '@admin/themes/views/act';
    }
}
