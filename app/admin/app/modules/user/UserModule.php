<?php

namespace admin\modules\user;

use admin\components\BaseModule;

class UserModule extends BaseModule
{
    public $controllerNamespace = 'admin\modules\user\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->viewPath = '@admin/themes/views/user';
    }
}
