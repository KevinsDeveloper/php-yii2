<?php
/**
 * Author: wangc
 * Date: 2017/1/10
 * Time: 14:04
 * Description: 管理员管理功能
 */

namespace admin\modules\live\controllers;

use admin\modules\sys\handler\MenuHandler;
use Yii;
use admin\components\BaseController;
use lib\models\live\LiveRoom;
use lib\models\live\LiveRoomSetting;
use admin\components\Base;
use yii\helpers\Json;

class RoomController extends BaseController
{
    public $desc='222222222';
    /**
     * Author: wangc
     * Date: 2017年1月11日 11:25:13
     * Description: 管理员列表
     * @return string
     */
    public function actionIndex(){
        $this->_data['list'] = LiveRoom::find()->asArray()->all();
        return parent::autoRender();
    }

    /**
     * Author: wangc
     * Date: 2017年1月11日 17:54:13
     * Description: 添加管理员
     * @return string
     */
    public function actionAdd(){
        $model = new LiveRoom();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post('LiveRoom');

            $model->attributes = [
                'room_name'  => $formData['room_name'],
                'room_title' => $formData['room_title'],
                'room_image' => $formData['room_image'],
                'room_desc'  => $formData['room_desc'],
                'inputtime'  => time(),
                'updatetime' => time(),
            ];
            if (!$model->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
            }
            $model->save();
            $setting = new LiveRoomSetting();
            $setting->attributes = [
                'room_id'  => $model->room_id
            ];
            $setting->save();
            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }
        $this->_data['model'] = $model;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = MenuHandler::getRoleGroups();
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
        
        $row = LiveRoom::find()->where(['room_id' => Yii::$app->request->get('id')])->one();
        
        if (empty($row))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        // 接受POST修改管理员
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post('LiveRoom');
            $formData['update'] = time();
            $row->attributes = $formData;
            if (!$row->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($row->errors)]);
            }
            $row->save();
            return Json::encode(['status' => 1]);
        }
        $this->_data['model'] = $row;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = MenuHandler::getRoleGroups();
        return parent::autoRender();
    }
    
     /**
     * Author: wangc
     * Date: 2017年1月11日 17:54:24
     * Description: 房间设置
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionSetting(){
        
        $model = LiveRoomSetting::find()->where(['room_id' => Yii::$app->request->get('id')])->one();
        
        if (empty($model))
        {
            $model = new LiveRoomSetting();
        }
        
        // 接受POST修改管理员
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post('LiveRoomSetting');
            
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
        $this->_data['groups'] = MenuHandler::getRoleGroups();
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
        $admin = LiveRoom::find()->where(['room_id' => Yii::$app->request->post('id')])->one();
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
