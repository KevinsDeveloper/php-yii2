<?php

namespace admin\modules\content;

use admin\components\BaseModule;

class ContentModule extends BaseModule
{
    public $controllerNamespace = 'admin\modules\content\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->viewPath = '@admin/themes/views/content';
    }
}
