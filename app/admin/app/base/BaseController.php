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
     * 返回JSON数据给模板
     * @author kevin
     * @param  integer $statusCode   状态码
     * @param  string  $message      提示语
     * @param  string  $navTabId     
     * @param  string  $rel          
     * @param  string  $callbackType 回调callbackType如果是closeCurrent就会关闭当前tab ，callbackType="forward"时需要forwardUrl值
     * @param  string  $forwardUrl   跳转地址
     * @return json
     */
    protected function autoJson($statusCode = 200, $message = "操作成功", $navTabId = "", $rel="", $callbackType="closeCurrent", $forwardUrl = "")
    {
        return Json::encode([
                "statusCode" => $statusCode,
                "message" => $message,
                "navTabId" => $navTabId,
                "rel" => $rel,
                "callbackType" => $callbackType,
                "forwardUrl" => $forwardUrl,
        ]);
    }

    /**
     * 获取当前url
     * @param $action 动作名称
     * @author kevin
     * @return string
     */
    protected function getThisUrl($action = null)
    {
        return $action == null ? Yii::$app->request->getHostInfo() : Yii::$app->request->getHostInfo() . Url::toRoute(array_merge([$action], $_GET));
    }

    /**
     * 分页程序
     * @author kevin
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
