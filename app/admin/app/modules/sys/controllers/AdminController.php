<?php
/**
 * Author: Yimpor
 * Date: 2017/1/10
 * Time: 14:04
 * Description: 管理员管理功能
 */

namespace admin\modules\sys\controllers;

use admin\modules\sys\handler\MenuHandler;
use Yii;
use admin\components\BaseController;
use admin\models\DbAdmin;
use admin\components\Base;
use yii\helpers\Json;

class AdminController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月11日 11:25:13
     * Description: 列表
     * @return string
     */
    public function actionIndex(){
        $this->_data['adminList'] = DbAdmin::find()->with("role")->asArray()->all();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 17:54:13
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        $admin = new DbAdmin();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $adminForm = Yii::$app->request->post('DbAdmin');

            $codes = Base::uniqueGuid();
            $admin->attributes = $adminForm;
            $admin->attributes = [
                'group_id'  => $adminForm['group_id'],
                'account' => $adminForm['account'],
                'phone' => $adminForm['phone'],
                'email' => $adminForm['email'],
                'nickname' => $adminForm['nickname'],
                'codes' => $codes,
                'passwd' => md5($codes . $adminForm['passwd'] . SAFE_KEY),
                'jobs' => $adminForm['jobs'],
                'status' => $adminForm['status'],
                'adtime' => time(),
                'uptime' => time(),
            ];
            if (!$admin->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($admin->errors)]);
            }
            $admin->save();
            //添加成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加管理员,管理员ID：' . Yii::$app->db->getLastInsertID());
            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }
        $this->_data['model'] = $admin;
        $this->_data['model'] -> status = 1;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = MenuHandler::getRoleGroups();

        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 17:54:24
     * Description: 修改
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEdit(){
        $admin = DbAdmin::find()->where(['id' => Yii::$app->request->get('id')])->one();
        if (empty($admin))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        // 接受POST修改管理员
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $adminForm = Yii::$app->request->post('DbAdmin');
            if (!empty($adminForm['passwd']) && $adminForm['passwd'] != $admin->passwd)
            {
                $adminForm['passwd'] = md5($admin->codes . $adminForm['passwd'] . SAFE_KEY);
            }
            else
            {
                unset($adminForm['passwd']);
            }

            $admin->attributes = $adminForm;
            $admin->token = '';
            if (!$admin->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($admin->errors)]);
            }
            $admin->save();
            //修改成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加管理员,管理员ID：' . $admin->id);
            return Json::encode(['status' => 1]);
        }
        $this->_data['model'] = $admin;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = MenuHandler::getRoleGroups();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 17:54:35
     * Description: 删除
     * @return string
     * @throws \Exception
     * @throws \yii\web\HttpException
     */
    public function actionDel(){
        $admin = DbAdmin::find()->where(['id' => Yii::$app->request->post('id')])->one();
        if (empty($admin))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }

        if ($admin && $admin->delete())
        {

            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加管理员,管理员ID：' . $admin->id);

            return Json::encode(['status' => 1]);
        }
        //删除失败或者栏目不存在
        return Json::encode(['status' => 0]);
    }

}