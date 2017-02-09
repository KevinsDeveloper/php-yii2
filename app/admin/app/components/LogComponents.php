<?php

/**
 * Author: yimpor
 * Date: 2017/1/11    14:23
 * Description:
 */

namespace admin\components;

use admin\models\Dolog;
use Yii;
use admin\models\DbAdminLogin;
use yii\base\Component;
use yii\helpers\Json;

class LogComponents extends Component
{

    /**
     * Date: 2017年1月11日 14:27:21
     * Description: 管理员登录日志
     * @return bool
     */
    public static function saveAdminLoginlog()
    {
        $admin = \Yii::$app->session->get('auth');
        $dolog = new DbAdminLogin();
        $dolog->admin_id = $admin->id;
        $dolog->account = $admin->account;
        $dolog->nickname = $admin->nickname;
        $dolog->login_info = Json::encode(\yii\helpers\ArrayHelper::toArray(\Yii::$app->request->headers));
        $dolog->login_ip = Yii::$app->request->userIP;
        $dolog->login_time = time();
        return $dolog->save();
    }

    /**
     * Date: 2017年1月11日 14:27:21
     * Description: 管理员操作日志
     * @return bool
     */
    public static function saveDolog($doing)
    {
        $admin = \Yii::$app->session->get('auth');

        $dolog = new Dolog();
        $dolog->uid = $admin['id'];
        $dolog->username = $admin['nickname'];
        $dolog->title = Yii::$app->controller->id;
        $dolog->action = Yii::$app->controller->action->id;
        $dolog->doing = $doing;
        $dolog->ip = Yii::$app->request->userIP;
        $dolog->time = time();
        return $dolog->save();
    }

}
