<?php
/**
 * Author: wangc
 * Date: 2017/1/10
 * Time: 14:04
 * Description: 群消息管理功能
 */

namespace admin\modules\live\controllers;

use Yii;
use admin\components\BaseController;
use lib\models\live\LiveRoom;
use lib\models\live\ChatOperatingLog;
use admin\components\Base;
use yii\helpers\Json;

class OperatingController extends BaseController
{
    public $desc='222222222';
    
    /**
     * @desc  操作类型 1 踢人 2 禁言 3 禁言解禁 4 IP屏蔽  5IP解禁
     */
    public $type = [1 => '踢人', 2 => '禁言', 3 => '禁言解禁', 4 => 'IP屏蔽', 5 => 'IP解禁'];
    
    /**
     * Author: wangc
     * Date: 2017年1月11日 11:25:13
     * Description: 管理员列表
     * @return string
     */
    public function actionIndex(){
        $this->_data['list'] = ChatOperatingLog::find()->asArray()->all();
        $this->_data['type'] = $this->type;
        return parent::autoRender();
    }

   

    /**
     * Author: wangc
     * Date: 2017年1月11日 17:54:24
     * Description: 修改管理员
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEdit(){
        
        $model = LiveRoomManager::find()->where(['user_id' => Yii::$app->request->get('id')])->one();
        if (empty($model))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        // 接受POST修改管理员
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post('LiveRoomManager');
            $formData['updatetime'] = time();
            $formData['birthday'] = $formData['birthday'] && strlen($formData['birthday']) <= 20 ? md5($formData['birthday'] . SIYAO) : $model['birthday'];
            $model->attributes = $formData;
            if (!$model->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
            }
            $model->save();
            return Json::encode(['status' => 1]);
        }
        $this->_data['model'] = $model;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = $this->group;
        return parent::autoRender();
    }
    
    

    /**
     * Author: wangc
     * Date: 2017年1月11日 17:54:35
     * Description: 删除管理员
     * @return string
     * @throws \Exception
     * @throws \yii\web\HttpException
     */
    public function actionDel(){
        $admin = LiveRoomManager::find()->where(['user_id' => Yii::$app->request->post('id')])->one();
        if (empty($admin))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }

        if ($admin && $admin->delete())
        {
            return Json::encode(['status' => 1]);
        }
        //删除失败或者栏目不存在
        return Json::encode(['status' => 0]);
    }

}
