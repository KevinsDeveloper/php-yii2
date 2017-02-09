<?php
/**
 * Created by PhpStorm.
 * User: Yimpor
 * Date: 2017/1/10
 * Time: 16:03
 */

namespace admin\modules\sys\controllers;

use admin\components\Base;
use admin\models\DbAdminMenu;
use admin\models\DbAdminPower;
use admin\modules\sys\handler\MenuHandler;
use admin\modules\sys\handler\RoleHandler;
use Yii;
use admin\components\BaseController;
use admin\models\DbAdminRole;
use yii\helpers\Json;
use yii\widgets\Menu;

class RoleController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月11日 16:31:40
     * Description: 列表
     * @return string
     */
    public function actionIndex(){
        $RoleModel = new DbAdminRole();
        $query = $RoleModel->find();

        $count = $query->count();
        $page = parent::page($count);
        $order = "id asc";
        $roles = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['roles'] = $roles;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 16:31:53
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post('DbAdminRole');
            $model = new DbAdminRole();
            $model->attributes = $data;
            $model->adtime = time();
            if (!$model->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
            }
            $model->save();
            //添加成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加角色组,角色组ID：' . Yii::$app->db->getLastInsertID());
            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }

        $this->_data['model'] = new DbAdminRole();
        $this->_data['model'] -> status = 1;
        $this->_data['model'] -> type = 0;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 16:32:06
     * Description: 修改
     * @return string
     */
    public function actionEdit(){
        $roleInfo = DbAdminRole::find()->where(['id' => Yii::$app->request->get('id')])->one();
        if (empty($roleInfo))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post('DbAdminRole');
            $roleInfo->attributes = $data;
            if (!$roleInfo->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($roleInfo->errors)]);
            }
            if ($roleInfo->save())
            {
                //修改成功写入操作日志
                \admin\components\LogComponents::saveDolog('修改角色组,角色组ID：' . $roleInfo->id);
                return Json::encode(['msg' => '修改成功', 'status' => 1]);
            }
            return Json::encode(['msg' => '修改失败', 'status' => 0]);
        }
        $this->_data['model'] = $roleInfo;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 16:32:16
     * Description: 删除
     * @return string
     * @throws \Exception
     * @throws \yii\web\HttpException
     */
    public function actionDel(){
        $role = DbAdminRole::find()->where(['id' => Yii::$app->request->post('id')])->one();
        if (empty($role))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }

        if ($role && $role->delete())
        {
            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除角色组,角色组ID：' . $role->id);
            return Json::encode(['status' => 1]);
        }
        //删除失败或者栏目不存在
        return Json::encode(['status' => 0]);
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 16:32:26
     * Description: 权限分配
     * @return string
     */
    public function actionGroupadd(){
        $roleInfo = DbAdminRole::find()->with('power')->where(['id' => Yii::$app->request->get('id')])->one();
        if (empty($roleInfo))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax)
        {
            $plist = Yii::$app->request->post('plist', []);
            $childlist = Yii::$app->request->post('childlist');
            try {
                $model = new DbAdminPower();
                $mPower = DbAdminPower::find()->where(['role_id' => $roleInfo->id])->one();
                if ($mPower) {
                    DbAdminPower::deleteAll(['role_id' => $roleInfo->id]);
                }
                foreach ($plist as $val) {    //是菜单
                    $mInfo = DbAdminMenu::find()->where(['id' => $val])->one();
                    $model->isNewRecord = true;
                    $model->role_id = $roleInfo->id;
                    $model->menu_id = $mInfo->id;
                    $model->type = 0;
                    $model->name = $mInfo->title;
                    $model->url = $mInfo->url;
                    if (!$model->validate()) {
                        return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
                    }
                    $model->save() && $model->id = 0;
                }
                if($childlist){
                    foreach ($childlist as $k => $cval) {    //是操作
                        foreach ($cval as $u => $n) {
                            $model->isNewRecord = true;
                            $model->role_id = $roleInfo->id;
                            $model->menu_id = $k;
                            $model->type = 1;
                            $model->name = rtrim($n);
                            $model->url = rtrim($u);
                            if (!$model->validate()) {
                                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
                            }
                            $model->save() && $model->id = 0;
                        }
                    }
                }
                //修改成功写入操作日志
                \admin\components\LogComponents::saveDolog('修改角色组权限信息！');
                return Json::encode(['status' => 1, 'msg' => '修改成功']);
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        $powerInfo = DbAdminPower::find()->where(['role_id'=>$roleInfo->id])->all();
        $poweri = [];
        foreach($powerInfo as $pinfo){
            $poweri[] = $pinfo->url;
        }
        $this->_data['model'] = $roleInfo;
        $this->_data['powerinfo'] = $poweri;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['plist'] = Yii::$app->params['roles'];
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月17日 16:32:34
     * Description: 刷新权限
     * @return string
     */
    public function actionRefresh(){
        //生成权限文件
        $roles = RoleHandler::getAppRoutes();
        $roles_path = CONFIG_DIR . "roles.php";
        $roles_content = "<?php \r\n";
        $roles_content .= 'return ' . var_export($roles, true) . ";\r\n";
        $roles_content .= "?>";

        if (file_put_contents($roles_path, $roles_content))
        {
            return Json::encode(['status' => 1]);
        }
        return Json::encode(['status' => 0]);
    }
}