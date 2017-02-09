<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

namespace admin\modules\site\controllers;

use yii\helpers\Json;
use yii\helpers\Url;

class LoginController extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class'   => \yii\filters\VerbFilter::className(),
            'actions' => [
                'do' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    /**
     * 登录
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index.tpl', ['redirect' => \Yii::$app->request->get("redirect", "/")]);
    }

    /**
     * 验证码
     */
    public function actionCaptcha()
    {
        $this->layout = false;
        $captcha = new \lib\vendor\captcha\Captcha([
            'width'     => 124,
            'height'    => 35,
            'fontsize'  => 16,
            'backcolor' => '#f3f3f4',
        ]);
        $captcha->getReckonImg();
        \Yii::$app->session->set('captchaCode', $captcha->getCode());
    }

    /**
     * 执行登录
     * @return type
     */
    public function actionDo()
    {
        if (!\Yii::$app->request->isAjax || !\Yii::$app->request->isPost) {
            return Json::encode(['status' => 0, 'msg' => 'Sorry, Request must be POST']);
        }

        $account = trim(\Yii::$app->request->post('account', 'string'));
        $passwd = trim(\Yii::$app->request->post('passwd', 'string'));
        $captcha = \Yii::$app->request->post('captcha', '');
        $redirect = \Yii::$app->request->post('redirect', 'string');

        // 校验验证码
        if (!\Yii::$app->session->has('captchaCode') || \Yii::$app->session->get('captchaCode') != $captcha) {
            return Json::encode(['status' => 0, 'msg' => 'Captcha Error']);
        }

        // 执行登录
        $adminData = \admin\models\DbAdmin::findOne(['account' => $account]);
        if (empty($adminData)) {
            return Json::encode(['status' => 0, 'msg' => 'Account Error']);
        }
        // 账号禁止登陆
        if ($adminData->status != 1) {
            return Json::encode(['status' => 0, 'msg' => 'Account Close']);
        }
        // 校验密码
        if ($adminData->passwd != md5($adminData->codes . $passwd . SAFE_KEY)) {
            return Json::encode(['status' => 0, 'msg' => 'Passwd Error']);
        }
        // 账号权限组别
        $groupData = \admin\models\DbAdminRole::findOne($adminData->group_id);
        if (empty($groupData)) {
            return Json::encode(['status' => 0, 'msg' => 'Group Error']);
        }
        // 更新管理员token
        $adminData->token = \admin\components\Base::uniqueGuid();
        if (!$adminData->save()) {
            return Json::encode(['status' => 0, 'msg' => 'Login Fail']);
        }
        // 写入登陆日志
        $adminLogin = new \admin\models\DbAdminLogin();
        $adminLogin->save([
            'admin_id'   => $adminData->id,
            'group_id'   => $adminData->group_id,
            'account'    => $adminData->account,
            'nickname'   => $adminData->nickname,
            'login_info' => Json::encode(\yii\helpers\ArrayHelper::toArray(\Yii::$app->request->headers)),
            'login_ip'   => \Yii::$app->request->getUserIP(),
            'login_time' => time(),
        ]);
        //$adminData->group_name = $groupData->role_name;
        //登录用户权限
        $powerData = \admin\models\DbAdminPower::findAll(['role_id' => $adminData->group_id]);
        if(empty($powerData) && $adminData -> group_id != 1){
            return Json::encode(['status' => 0, 'msg' => 'Role Error']);
        }else{
            $powerinfo = [];
            foreach($powerData as $v){
                $powerinfo[] = $v->url;
            }
        }

        // 写入SESSION
        \Yii::$app->session->set('auth', $adminData);
        \Yii::$app->session->set('token', $adminData->token);
        \Yii::$app->session->set('role', $powerinfo);
        \admin\components\LogComponents::saveAdminLoginlog();
        // 返回数据
        return Json::encode([
                    'status' => 1,
                    'data'   => [
                        'tourl'    => !empty($redirect) ? $redirect : '/',
                        'id'       => $adminData->id,
                        'group_id' => $adminData->group_id,
                        'account'  => $adminData->account,
                        'nickname' => $adminData->nickname,
                        'token'    => $adminData->token,
                    ],
        ]);
    }

    /**
     * 退出
     * @return type
     */
    public function actionOut()
    {
        unset(\Yii::$app->session['auth']);
        \Yii::$app->session->destroy();
        $this->redirect(['/']);
    }

    /**
     * 错误处理
     * @author kevin
     * @return type
     */
    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error.tpl', ['message' => $exception]);
        }
    }

}
