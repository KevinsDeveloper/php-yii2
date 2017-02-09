<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace apps\base;

use Yii;
use yii\helpers\Url;

/**
 * 控制器入口基类
 * Class Controller
 * @package apps\base
 */
class Controller extends \yii\web\Controller
{
    /**
     * 项目模板传递数据数组
     * @var array
     */
    protected $data;

    public function init()
    {
        parent::init();

        //$this->enableCsrfValidation = false;
    }

    /**
     * 根据action设置模板文件
     * @param null $action 可以自定义
     * @return string
     */
    public function autoview($action = null, $suffix = '.tpl')
    {
        $template = empty($action) ? strtolower($this->action->id) : $action;
        return $this->render($template . $suffix, $this->data);
    }

    /**
     * 错误信息
     * @param type $type
     * @param type $msg
     */
    public function error($type = 404, $msg)
    {
        $this->data['message'] = $msg;
        $this->redirect(Url::to(['help/error', 'type' => $type, 'msg' => $msg]));
    }

    /**
     * isPost 是否Post方式提交
     * @return boolean 返回值
     */
    public function isPost()
    {
        return \Yii::$app->request->getIsPost();
    }

    /**
     * isGet 是否GET方式提交
     * @return boolean
     */
    public function isGet()
    {
        return \Yii::$app->request->getIsAjax();
    }

    /**
     * isAjax 是否Ajax提交
     * @return boolean
     */
    public function isAjax()
    {
        return \Yii::$app->request->getIsAjax();
    }

    /**
     * 获取GET数据
     * @param  string $key
     * @return string
     */
    public function get($key = '')
    {
        $get = \Yii::$app->request->get($key);
        if (is_array($get)) {
            foreach ($get as $k => $v) {
                $get[$k] = trim($v);
            }
            return $get;
        }
        return trim($get);
    }

    /**
     * 获取POST数据
     * @param  string $key
     * @return string
     */
    public function post($key = '')
    {
        $post = \Yii::$app->request->post($key);
        if (is_array($post)) {
            foreach ($post as $k => $v) {
                $post[$k] = trim($v);
            }
            return $post;
        }
        return trim($post);
    }
}