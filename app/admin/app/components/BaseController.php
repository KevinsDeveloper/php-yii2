<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\components;

use admin\models\DbAdminPower;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\helpers\Url;

class BaseController extends \yii\web\Controller
{

    public $_data = [];
    public $auth = [];

    /**
     * 初始化
     * @return type
     */
    public function init()
    {
        parent::init();

        // AJAX请求必须是POST
//        if (Yii::$app->request->isAjax == true && Yii::$app->request->isPost == false) {
//            return Json::encode(['status' => 0, 'message' => 'Sorry, Request must be POST']);
//        }
        $this->auth = Yii::$app->session->get('auth');
        $this->_data['admin'] = $this->auth;
    }

    /**
     * 执行Action之前
     * @param  string $action 动作
     * @author kevin
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->loginRedirect();

        $this->_data['menudata'] = self::getMenuData();
        return parent::beforeAction($action);
    }

    /**
     * 登录跳转
     * @author kevin
     * @return bool
     */
    public function loginRedirect()
    {
        if (empty($this->auth)) {
            if (Yii::$app->request->isAjax) {
                exit(json_encode(['status' => 0, 'msg' => '请重新登录！']));
            }
            else {
                $this->redirect(['/site/login', 'redirect' => Url::to([
                        '/' . $this->action->controller->module->id .
                        '/' . $this->action->controller->id .
                        '/' . $this->action->id
                ])]);
            }
        }
        return true;
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
        $titleName = \Yii::$app->controller->id . '_' . $this->action->id;
        $pageTitle = empty($action) && isset(\Yii::$app->params['seo'][$titleName]['name']) ? \Yii::$app->params['seo'][$titleName]['name'] : '';
        $this->view->title = !empty($pageTitle) ? $pageTitle . '-' . \Yii::$app->name : \Yii::$app->name;
        return $this->render($template . $suffix, $this->_data);
    }

    /**
     * 获取当前URL
     * @param $action 当前ACTION
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

    /**
     * 查询所有记录
     * @param  object $model [模型]
     * @param  string $with [联表]
     * @param  array $where [条件]
     * @param  string $order [排序]
     * @return array
     */
    protected function query($model, $with = '', $where = '', $order = 'id desc')
    {
        $query = $model->find();
        if ($with != '') {
            $query = $query->innerJoinWith($with);
        }
        if ($where != '') {
            $query = $query->where($where);
        }

        $count = $query->count();
        $page = $this->page($count);
        $query = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['data'] = $query;
        return ['count' => $count, 'page' => $page, 'data' => $query];
    }

    /**
     * 获取管理员菜单
     * @return array|void
     * @throws \yii\web\HttpException
     */
    protected function getMenuData()
    {
        $admin = \Yii::$app->session->get('auth');
        $power = DbAdminPower::find()->select('url')->where(['role_id' => $admin->group_id])->asArray()->all();
        $powerArr = [];
        foreach ($power as $v) {
            $powerArr[] = $v['url'];
        }
        if (empty($admin)) {
            return $this->redirect(['/site/login', 'redirect' => \Yii::$app->request->url]);
        }
        if ($admin->group_id == 1) {
            $powerArr = [];
        }
        else if (empty($power)) {
            throw new \yii\web\HttpException(500, '抱歉， 权限信息有误');
        }

        if ($admin->group_id == 1) {
            $roleInfo = \admin\modules\sys\handler\RoleHandler::getAppRoutes();
            $roles = [];
            foreach ($roleInfo as $topk => $topv) {
                if (isset($topv['parentid'])) {
                    foreach ($topv['parentid'] as $mek => $mev) {
                        if (isset($mev['parentid'])) {
                            foreach ($mev['parentid'] as $ack => $acv) {
                                $roles[] = $acv['url'];
                            }
                        }
                    }
                }
            }
            Yii::$app->params['powers'] = $roles;
        }
        else {
            Yii::$app->params['powers'] = \admin\modules\sys\handler\MenuHandler::getActions($admin);
        }
        return \admin\modules\sys\handler\MenuHandler::getMenuID(['status' => '1'], $powerArr);
    }

}
