<?php

/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    kevin
 */

namespace admin\modules\site\controllers;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * 登录控制器
 */
class LoginController extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class'   => \yii\filters\VerbFilter::className(),
            'actions' => [
                'do' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * 登录
     * @return type
     */
    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \admin\models\AuthUser();
        $model->attributes = [
            'account' => 'admin',
            'email' => 'admin@gmail.com'
        ];
        $model->save();
        print_r($model->errors);
        echo $model->getId();
        exit;
        //return $this->render('index.tpl', ['redirect' => \Yii::$app->request->get("redirect", "/")]);
    }

    /**
     * 验证码
     */
    public function actionCaptcha() {
        $this->layout = false;
        $captcha = new \lib\vendor\captcha\Captcha([
            'width'     => 126,
            'height'    => 32,
            'fontsize'  => 16,
            'backcolor' => '#e5edef',
        ]);
        $captcha->getReckonImg();
        \Yii::$app->session->set('captchaCode', $captcha->getCode());
    }

    /**
     * 执行登录
     * @return type
     */
    public function actionDo() {
        if (!\Yii::$app->request->isAjax || !\Yii::$app->request->isPost) {
            return Json::encode(['status' => 0, 'msg' => 'Sorry, Request must be POST']);
        }

        $captcha = \Yii::$app->request->post('captcha', '');
        $redirect = \Yii::$app->request->post('redirect', 'string');

        // 校验验证码
        if (!\Yii::$app->session->has('captchaCode') || \Yii::$app->session->get('captchaCode') != $captcha) {
            return Json::encode(['status' => 0, 'msg' => 'Captcha Error']);
        }

        $model = new \admin\models\FormLogin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return Json::encode(['status' => 1, 'redirect' => $redirect]);
        }

        return Json::encode(['status' => 0, 'msg' => 'Login Failed']);
    }

    /**
     * 退出
     * @return type
     */
    public function actionOut() {
        unset(\Yii::$app->session['auth']);
        \Yii::$app->session->destroy();
        $this->redirect(['/']);
    }

    /**
     * 错误处理
     * @author kevin
     * @return type
     */
    public function actionError() {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error.tpl', ['message' => $exception->getMessage()]);
        }
    }

}
