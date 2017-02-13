<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\base;

use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * 控制器入口基类
 * Class BaseController
 * @package admin\base
 */
class BaseController extends \yii\web\Controller
{
    public $data = [];
    public $auth = [];

    /**
     * 初始化
     * @return type
     */
    public function init()
    {
        parent::init();

        $this->data['Url'] = new Url();
        $this->data['Html'] = new Html();
    }

    /**
     * 执行Action之前
     * @param  string $action 动作
     * @author kevin
     * @return bool
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    /**
     * 自动调用模板文件
     * @param null $action 动作名称
     * @param string $suffix 模板后缀
     * @author kevin
     * @return string
     */
    protected function autoRender($action = null, $suffix = '.tpl')
    {
        $template = empty($action) ? strtolower($this->action->id) : $action;
        return $this->render($template . $suffix, $this->data);
    }

    /**
     * 获取当前url
     * @param $action
     * @author kevin
     * @return string
     */
    public function getThisUrl($action = null)
    {
        return $action == null ? Yii::$app->request->getHostInfo() : Yii::$app->request->getHostInfo() . Url::toRoute(array_merge([$action], $_GET));
    }

    /**
     * 分页程序
     * @param  int $count 总条数
     * @return object
     */
    protected function page($count)
    {
        return $pagination = new Pagination([
            'pageSize'   => \yii::$app->params['pageSize'],
            'totalCount' => $count,
        ]);
    }

}
