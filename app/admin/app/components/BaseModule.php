<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\components;

/**
 * 模块入口基类
 * Class BaseModule
 * @package webs\admin\components
 */
class BaseModule extends \yii\base\Module
{

    /**
     * 初始化
     * @author kevin
     */
    public function init()
    {
        parent::init();

        $this->defaultRoute = 'index/index';
        $this->layout = '@admin/themes/views/layouts/main.tpl';
    }

}
