<?php
/**
 * 菜单管理
 * Author: Yimpor
 * Date: 2017/1/10
 * Time: 14:01
 * Description: 菜单相关管理功能
 */
namespace admin\modules\sys\controllers;

use Yii;
use admin\components\BaseController;
use admin\models\DbAdminMenu;
use admin\modules\sys\handler\MenuHandler;
use yii\helpers\Json;
use admin\components\Base;
use yii\widgets\Menu;

class MenuController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月11日 11:19:13
     * Description: 列表
     * @return string
     */
    public function actionIndex(){
        $this -> _data['menus'] = MenuHandler::getPageList(MenuHandler::getMenuID());
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 11:19:30
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post('DbAdminMenu');
            $model = new DbAdminMenu();
            $model->attributes = $data;
            if (!$model->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
            }
            $model->save();
            //添加成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加菜单,菜单ID：' . Yii::$app->db->getLastInsertID());
            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }
        $this->_data['model'] = new DbAdminMenu();
        $this->_data['model'] -> status = 1;
        $this->_data['model'] -> orderby = 0;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['res'] = MenuHandler::getDropDownList(MenuHandler::getMenuID());
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 11:19:42
     * Description: 修改
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEdit(){
        $id = intval(Yii::$app->request->get('id', 0));
        $menuData = DbAdminMenu::find()->where(['id' => $id])->one();
        if (!$id || empty($menuData))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        if (Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post('DbAdminMenu');
            $menuData->attributes = $data;
            if (!$menuData->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($menuData->errors)]);
            }
            if ($menuData->save())
            {
                //修改成功写入操作日志
                \admin\components\LogComponents::saveDolog('修改菜单,菜单ID：' . $menuData->id);
                return Json::encode(['msg' => '修改成功', 'status' => 1]);
            }
            return Json::encode(['msg' => '修改失败', 'status' => 0]);
        }
        $this->_data['res'] = MenuHandler::getDropDownList(MenuHandler::getMenuID());
        $this->_data['model'] = $menuData;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 11:19:54
     * Description: 删除
     * @return string
     * @throws \Exception
     */
    public function actionDel(){
        $id = intval(Yii::$app->request->get('id', 0));
        if (empty($id))
        {
            Json::encode(['msg' => '参数错误', 'status' => 0]);
        }
        $existSon = DbAdminMenu::find()->where(['pid' => $id])->count();
        if ($existSon > 0)
        {
            return Json::encode(['status' => 0, 'msg' => '该菜单下有子菜单，请先处理子菜单']);
        }
        $res = DbAdminMenu::findOne(['id' => $id])->delete();
        if ($res)
        {
            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除菜单,菜单ID：' . $res->id);

            return Json::encode(['msg' => '删除成功', 'status' => 1]);
        }
        return Json::encode(['msg' => '删除失败', 'status' => 0]);
    }

}