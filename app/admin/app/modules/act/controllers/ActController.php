<?php

namespace admin\modules\act\controllers;

use admin\components\Base;
use lib\models\act\Act;
use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class ActController extends BaseController
{

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 11:44:54
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $where = '';

        //字段搜索
        if (!empty($search['type']) && !empty($search['keyword']))
        {
            $where = $search['type'] . " like '%" . $search['keyword'] . "%'";
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

        $query = Act::find()->where($where);
        $count = $query->count();
        $page = parent::page($count);
        $order = "id DESC";
        $this->_data['act_list'] = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->asArray()->all();
        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 13:57:17
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $Act = new Act();
            $Act->attributes = Yii::$app->request->post('Act');

            $Act->start = strtotime($Act->start);
            $Act->end = strtotime($Act->end);
            //获取添加人信息
            $Act->adduser = Yii::$app->session['auth']['id'];
            $Act->addname = Yii::$app->session['auth']['nickname'];
            $Act->addtime = time();

            //如果是模板活动，按钮名字不能为空
//            if ($Act->attributes['is_tmp'] == 1 && ($Act->attributes['join_url_name'] == '' || $Act->attributes['template'] == '')) {
//                return Json::encode(['status' => 0, 'msg' => '报名链接和模板内容不能为空']);
//            }

            //验证表单数据
            if (!$Act->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Act->errors)]);
            }

            //插入数据
            if (!$Act->save())
            {
                return Json::encode(['status' => 0, 'msg' => '创建活动失败，请联系管理员']);
            }

            //如果是有自定义链接的模板活动，将链接写入文件
/*            if ($Act->attributes['is_tmp'] == 1 && $Act->attributes['url'] != '') {
                $act_path = CONFIG_DIR . "actdetail.php";
                $path_arr = require $act_path;
                $path_arr[$Act->attributes['url']] = 'active/detail';
                //生成活动链接文件
                $actlist = var_export($path_arr, true);
                $act_content = "<?php \r\n";
                $act_content .= "namespace lib\\" . APP_CONFIG . "; \r\n";
                $act_content .= 'return ' . $actlist . ";\r\n";
                $act_content .= "?>";
                file_put_contents($act_path, $act_content);
            }
*/
            //写入操作日志
            \admin\components\LogComponents::saveDolog('创建活动,活动名：' . Yii::$app->request->post('Act')['name'] . ',活动ID：' . Yii::$app->db->getLastInsertID());

            return Json::encode(['status' => 1]);
        }

        $this->_data['model'] = new Act();
        $this->_data['model'] -> isshow = 1;
        $this->_data['model'] -> status = 1;
        $this->_data['model'] -> recommend = 1;
        $this->_data['model'] -> sitetype = 1;
        $this->_data['model'] -> subtype = 1;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['act_list'] = [];
        $this->_data['act_list_select'] = [];
        $actlist = Act::find()->where('`start` < ' . time() . ' AND `end` > ' . time())->asArray()->all();
        foreach ($actlist as $key => $value) {
            $this->_data['act_list'][$value['id']] = $value['name'];
        }

        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 14:57:41
     * Description: 修改
     * @return string
     */
    public function actionEdit(){
        if (Yii::$app->request->isGet)
        {
            $Act = Act::find()->where(['id' => Yii::$app->request->get('id')])->one();
            if (empty($Act))
            {
                throw new \yii\web\HttpException(500, "异常请求");
            }
            $this->_data['model'] = $Act;
            $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
            $this->_data['act_list'] = [];
            $this->_data['act_list_select'] = [];
//            $this->_data['model'] -> subtype = Yii::$app->params['subtype'];
//            $actlist = Act::find()->where('`start` < ' . time() . ' AND `end` + `transaction_days` * 86400 > ' . time())->andWhere('id != ' . Yii::$app->request->get('id'))->asArray()->all();
            $actlist = Act::find()->Where('id != ' . Yii::$app->request->get('id'))->asArray()->all();
            foreach ($actlist as $key => $value) {
                $this->_data['act_list'][$value['id']] = $value['name'];
            }
            return parent::autoRender();
        }
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $Act = Act::find()->where(['id' => Yii::$app->request->post('id')])->one();
            if (!$Act)
            {
                return Json::encode(['status' => 0, 'msg' => '活动不存在']);
            }

            $Act->attributes = Yii::$app->request->post('Act');
            $Act->start = strtotime($Act->start);
            $Act->end = strtotime($Act->end);

            //验证表单数据
            if (!$Act->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Act->errors)]);
            }

            //如果是模板活动，按钮名字不能为空
//            if ($Act->attributes['is_tmp'] == 1 && ($Act->attributes['join_url_name'] == '' || $Act->attributes['template'] == '')) {
//                return Json::encode(['status' => 0, 'msg' => '报名链接和模板内容不能为空']);
//            }

            //修改更新信息
            $Act->updatetime = time();

            //插入数据
            if (!$Act->save())
            {
                return Json::encode(['status' => 0, 'msg' => '修改活动失败，请联系管理员']);
            }

            //如果是有自定义链接的模板活动，将链接写入文件
/*            if ($Act->attributes['is_tmp'] == 1 && $Act->attributes['url'] != '') {
                $act_path = CONFIG_DIR . "actdetail.php";
                $path_arr = require $act_path;
                if (isset($path_arr[$Act->getOldAttribute('url')])) {
                    unset($path_arr[$Act->getOldAttribute('url')]);
                }
                $path_arr[$Act->attributes['url']] = 'active/detail';
                //生成活动链接文件
                $actlist = var_export($path_arr, true);
                $act_content = "<?php \r\n";
                $act_content .= "namespace lib\\" . APP_CONFIG . "; \r\n";
                $act_content .= 'return ' . $actlist . ";\r\n";
                $act_content .= "?>";
                file_put_contents($act_path, $act_content);
            }
*/


            //写入操作日志
            \admin\components\LogComponents::saveDolog('修改活动,活动名：' . Yii::$app->request->post('Act')['name'] . ',活动ID：' . Yii::$app->request->post('id'));

            return Json::encode(['status' => 1]);

        }
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:01:09
     * Description: 删除
     * @return string
     * @throws \Exception
     */
    public function actionDel(){
        //判断合法提交
        if (!Yii::$app->request->isPost || Yii::$app->request->post('id') == null)
        {
            return Json::encode(['status' => 0, 'msg' => '请求异常']);
        }
        $Acts = Act::find()->where(['id' => Yii::$app->request->post('id', 0)])->one();
        if ($Acts && $Acts->delete())
        {

            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除活动,活动ID：' . $Acts->id);
            return Json::encode(['status' => 1]);
        }
        //删除失败或者单页面不存在
        return Json::encode(['status' => 0]);
    }
}
