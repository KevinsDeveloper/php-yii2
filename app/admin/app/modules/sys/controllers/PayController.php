<?php
/**
 * Author: yimpor
 * Date: 2017/1/25    13:55
 * Description:
 */

namespace admin\modules\sys\controllers;

use admin\components\Base;
use lib\models\PaySetting;
use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class PayController extends BaseController
{
    public $_type = 0;

    /**
     * Author: Yimpor
     * Date: 2017年1月25日 14:46:10
     * Description: 列表
     * @return string
     */
    public function actionIndex(){
//        $where = ['sitetype' => $this->_type];
        $model = new \lib\models\PaySetting;
        $this->query($model, '', '', 'pid asc');
        $this->_data['psetting'] = $this->getPsetting();
        $this->_data['type']     = $this->_type;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月25日 14:49:24
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        $model = new \lib\models\PaySetting;
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost)
        {
            $admin = \Yii::$app->session->get('auth');
            $data = Yii::$app->request->post('PaySetting');
            $model->attributes = $data;
            $model -> addtime = time();
            $model -> admin = $admin['nickname'];
            if (!$model->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($model->errors)]);
            }
            $model->save();
            //添加成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加支付配置,配置ID：' . Yii::$app->db->getLastInsertID());
            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }
        $this->_data['psetting'] = $this->getPsetting();
        $this->_data['model']     = $model;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月25日 14:49:33
     * Description: 编辑
     * @return string
     */
    public function actionEdit(){
        $pid = intval(Yii::$app->request->get('pid', 0));
        $payData = PaySetting::find()->where(['pid' => $pid])->one();
        if (!$pid || empty($payData))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        if (Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post('PaySetting');
            $payData->attributes = $data;
            if (!$payData->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($payData->errors)]);
            }
            if ($payData->save())
            {
                //修改成功写入操作日志
                \admin\components\LogComponents::saveDolog('修改支付设置,配置ID：' . $payData->pid);
                return Json::encode(['msg' => '修改成功', 'status' => 1]);
            }
            return Json::encode(['msg' => '修改失败', 'status' => 0]);
        }
        $this->_data['psetting'] = $this->getPsetting();
        $this->_data['model'] = $payData;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }
    /**
     * @desc   获取支付设置
     * @author mango
     * @access public
     * @param  void
     * @return array
     */
    private function getPsetting()
    {
        $setting = \yii::$app->params['pay_setting'];
        $pay = [];
        //$this->_type == 3(2016-9-19取消)
        if($this->_type == 0)
        {
            foreach ($setting as $key => $value) {
                $pay[$key] = $value['name'];
            }
        }
        else
        {
            $namKey = 'WAP';
            if($this->_type == 2)
            {
                $namKey = 'WeiXin';
            }
            foreach ($setting as $key => $value) {
                if(isset($value[$namKey]))
                {
                    $pay[$key] = $value[$namKey]['name'];
                }
            }
        }

        return $pay;
    }
}