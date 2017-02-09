<?php
/**
 * Created by PhpStorm.
 * User: yimpor
 * Date: 2017/1/10
 * Time: 14:02
 */

namespace admin\modules\sys\controllers;


use Yii;
use admin\components\BaseController;
use admin\models\Setting;
use yii\helpers\Json;

class SettingController extends BaseController
{

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 09:35:27
     * Description: 列表
     * @return string
     */
    public function actionIndex(){
        $settingData = [];
        $settingType = [0 => '默认设置', 1 => '上传设置'];
        foreach ($settingType as $type => $val)
        {
            $settingData[$type]['name'] = $val;

                $settingData[$type]['data'] = Setting::find()->where(['type' => $type])->orderBy('id ASC')->asArray()->all();
        }
        $this->_data['settingData'] = $settingData;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月17日 13:53:43
     * Description: 保存
     * @return mixed
     */
    public function actionSave()
    {
        if (!Yii::$app->request->isPost)
        {
            return Json::encode(['status' => 1, 'msg' => '更新配置成功']);
        }

        // 获取POST数据
        $post = Yii::$app->request->post('system');
        if (!is_array($post) || empty($post))
        {
            return Json::encode(['status' => 0, 'msg' => '抱歉，无配置项可更新']);
        }
        foreach ($post as $k => $v)
        {
            Setting::updateAll(['value' => $v], ['key' => $k]);
        }

        //修改成功写入操作日志
        \admin\components\LogComponents::saveDolog('修改系统配置,管理员账号：' . Yii::$app->session['admin']['account']);

        return Json::encode(['status' => 1, 'msg' => '更新配置成功']);
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月17日 14:34:07
     * Description: 更新系统配置
     * @return string
     */
    public function actionUpdate()
    {
        $system = new \lib\System;
        $system->updateFile();
        $updatetime = @filemtime(\yii::$app->params['system_file']);
        $time = empty($updatetime) ? '暂无' : date('Y-m-d H:i:s', $updatetime);
        return Json::encode(['status' => 1, 'msg' => '更新配置成功，更新时间：' . $time]);
    }
}