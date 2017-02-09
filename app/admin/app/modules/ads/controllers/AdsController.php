<?php
/**
 * author: Yimpor
 * addtime: 2017年1月17日 10:31:31
 * desc: 广告管理功能
 */

namespace admin\modules\ads\controllers;

use admin\components\Base;
use lib\models\ads\Ads;
use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class AdsController extends BaseController
{

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:17:44
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $where = '';
        //字段搜索
        if (!empty($search['keyword']))
        {
            $where = " name like '%" . $search['keyword'] . "%'";
        }
        //时间搜索
        if (!empty($search['stime']))
        {
            $where = '`start` > ' . strtotime($search['stime']);
        }

        if (!empty($search['etime']))
        {
            $where = '`end` < ' . strtotime($search['etime']);
        }

        if (!empty($search['stime']) && !empty($search['etime']))
        {
            $where = '`start` > ' . strtotime($search['stime']) . ' and `end` < ' . strtotime($search['etime']);
        }

        $query = Ads::find()->where($where);
        $count = $query->count();
        $page = parent::page($count);
        $order = "orderby ASC, addtime desc";
        $this->_data['ads_list'] = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->asArray()->all();
        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:17:52
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        if (Yii::$app->request->isGet)
        {
            $this->_data['model'] = new Ads();
            $this->_data['model'] -> sitetype = 1;
            $this->_data['model'] -> type = 1;
            $this->_data['model'] -> isshow = 1;
            $this->_data['model'] -> status = 1;
            $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();

            return parent::autoRender();
        }
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $Ads = new Ads();
            $Ads->attributes = Yii::$app->request->post('Ads');

            $Ads->start = strtotime($Ads->start);
            $Ads->end = strtotime($Ads->end);
            //获取添加人信息
            $Ads->adminid = Yii::$app->session['auth']['id'];
            $Ads->adminname = Yii::$app->session['auth']['nickname'];
            $Ads->addtime = time();

            //验证表单数据
            if (!$Ads->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Ads->errors)]);
            }

            //插入数据
            if (!$Ads->save())
            {
                return Json::encode(['status' => 0, 'msg' => '添加广告失败，请联系管理员']);
            }

            //写入操作日志
            \admin\components\LogComponents::saveDolog('添加广告,广告名：' . Yii::$app->request->post('Ads')['name'] . ',广告ID：' . Yii::$app->db->getLastInsertID());

            return Json::encode(['status' => 1]);
        }
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:18:00
     * Description: 编辑
     * @return string
     */
    public function actionEdit(){
        if (Yii::$app->request->isGet)
        {
            $Ads = Ads::find()->where(['id' => Yii::$app->request->get('id')])->one();
            if (empty($Ads))
            {
                throw new \yii\web\HttpException(500, "异常请求");
            }
            $this->_data['model'] = $Ads;
            $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
            return parent::autoRender();
        }
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $Ads = Ads::find()->where(['id' => Yii::$app->request->post('id')])->one();
            if (!$Ads)
            {
                return Json::encode(['status' => 0, 'msg' => '广告不存在']);
            }

            $Ads->attributes = Yii::$app->request->post('Ads');
            $Ads->start = strtotime($Ads->start);
            $Ads->end = strtotime($Ads->end);

            //验证表单数据
            if (!$Ads->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Ads->errors)]);
            }

            //插入数据
            if (!$Ads->save())
            {
                return Json::encode(['status' => 0, 'msg' => '修改广告失败，请联系管理员']);
            }

            //写入操作日志
            \admin\components\LogComponents::saveDolog('修改广告,广告名：' . Yii::$app->request->post('Ads')['name'] . ',广告ID：' . Yii::$app->request->post('id'));

            return Json::encode(['status' => 1]);

        }
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:18:10
     * Description: 删除
     * @return string
     */
    public function actionDel(){
        //判断合法提交
        if (!Yii::$app->request->isPost || Yii::$app->request->post('id') == null)
        {
            return Json::encode(['status' => 0, 'msg' => '请求异常']);
        }

        $Ads = Ads::find()->where(['id' => Yii::$app->request->post('id')])->one();

        if ($Ads && $Ads->delete())
        {
            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除广告,广告名：' . $Ads['name'] . ',广告ID：' . Yii::$app->request->post('id'));

            return Json::encode(['status' => 1]);
        }
        //删除失败或者广告不存在
        return Json::encode(['status' => 0]);
    }
}
