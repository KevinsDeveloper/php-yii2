<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace app\config;

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require CONFIG_DATA . 'rules.php', [
            '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
            '/<controller:\w+>/<id:\d+>.html'        => '/home/index/list',
        ]);
