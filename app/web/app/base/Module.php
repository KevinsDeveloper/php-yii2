<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace apps\base;

/**
 * 模块入口基类
 * Class Module
 * @package apps\base
 */
class Module extends \yii\base\Module
{

    /**
     * 初始化
     * @author kevin
     */
    public function init()
    {
        parent::init();

        $this->defaultRoute = 'index/index';
        $this->layout = '@apps/themes/views/layouts/main.tpl';
    }

}
