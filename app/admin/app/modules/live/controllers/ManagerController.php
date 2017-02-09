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
use lib\models\live\LiveRoomManager;
use admin\components\Base;
use yii\helpers\Json;

class ManagerController extends BaseController
{
    public $desc='222222222';
    
    public $group = [2 => '管理', 3 => '老师', '4' => '客服'];
    /**
     * Author: wangc
     * Date: 2017年1月11日 11:25:13
     * Description: 管理员列表
     * @return string
     */
    public function actionIndex(){
        $this->_data['list'] = LiveRoomManager::find()->asArray()->all();
        $this->_data['groups'] = $this->group;
        return parent::autoRender();
    }

    /**
     * Author: wangc
     * Date: 2017年1月11日 17:54:13
     * Description: 添加管理员
     * @return string
     */
    public function actionAdd(){
        $model = new LiveRoomManager();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post('LiveRoomManager');

            $model->attributes = [
                'group_id'  => $formData['group_id'],
                'user_name'  => $formData['user_name'],
                'real_name' => $formData['real_name'],
                'nickname' => $formData['nickname'],
                'sex' => $formData['sex'],
                'email'  => $formData['email'],
                'mobile'  => $formData['mobile'],
                'phonemd5'  => md5($formData['mobile'] . SIYAO),
                'birthday'  => md5($formData['birthday'] . SIYAO),
                'inputtime'  => time(),
                'updatetime' => time(),
            ];
            if (!$model->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
            }
            $model->save();
            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }
        $this->_data['model'] = $model;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = $this->group;
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
