<?php

namespace admin\modules\user\controllers;

use admin\components\Base;
use lib\models\member\UserMain;
use lib\modules\Realuser;
use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class UserController extends BaseController
{
    private $key='hasdf7348jdfo7kr2p3ujdft34ujt54tu';
    private $_passwd = '123456' ; //默认密码

    /**
     * Author: Yimpor
     * Date: 2017年1月19日 18:21:20
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $where = ' 1 = 1 ';

        if (!empty($search['type']) && !empty($search['keyword']))
        {
            $type = $search['type']?$search['type']:'';
            if($type == "mobile"){
                $where .= " AND el_user_main.phonemd5='".md5($search['keyword'].$this->key)."'";
            }else{
                $where .= " AND el_user_main.". $search['type'] . " like '%" . $search['keyword'] . "%'";
            }
        }
        if (!empty($search['user_status']) && $search['user_status']) {
            if($search['user_status'] == 100){
                $where .= $where ? ' AND el_user_main.status = 0' : "el_user_main.status = 0";
            }else {
                $where .= $where ? ' AND el_user_main.status like "%' . $search['user_status'] . '"' : "el_user_main.status like %" . $search['user_status'];
            }
        }

        if (!empty($search['source']) && $search['source']) {
            if($search['source'] == 100){
                $where .= $where ? ' AND isNUll(el_user_main.register_source)' : "isNUll(el_user_main.register_source)";
            }elseif($search['source'] == 'hbweb'){
                $where .= $where ? ' AND el_user_main.register_source like "%web过年红包活动"' : 'el_user_main.register_source like "%web过年红包活动"';
            }elseif($search['source'] == 'hbwap'){
                $where .= $where ? ' AND el_user_main.register_source like "%wap过年红包活动"' : 'el_user_main.register_source like "%wap过年红包活动"';
            }else {
                $where .= $where ? ' AND el_user_main.register_source = "' . $search['source'] . '"' : "el_user_main.register_source = " . $search['source'];
            }
        }

        if (!empty($search['start']))
        {
            $stime = strtotime($search['start']);
            $etime = empty($search['end']) ? time() : strtotime($search['end']);
            $where .= ' AND el_user_main.register_time BETWEEN ' . $stime . ' and ' . $etime;
        }

        $UserMainModel = new UserMain();
        $query = $UserMainModel->find()->select(['el_user_main.*', 'a.user_name as a_name', 'b.real_name as b_name'])
            ->leftJoin('el_user_agent AS a', 'el_user_main.parent_id = a.user_id')
            ->leftJoin('el_user_main AS b', 'el_user_main.recomend_id = b.user_id')
            ->where($where);

        $count = $query->count();
        $page = parent::page($count);
        $order = "el_user_main.register_time DESC";
        $userInfo = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

        if ($userInfo) {
            foreach($userInfo as $key => $value){
                $userInfo [$key] ['register_time'] = $value ['register_time'] ? date('Y-m-d H:i:s', $value ['register_time']) : "";
                $userInfo [$key] ['mobile'] = $value ['mobile'] ? Yii::$app->encrypt->decode($value ['mobile']) : '';
                $userInfo [$key] ['parent_id'] = $value ['parent_id'] ? $value ['parent_id'] : '';
                $userInfo [$key] ['recomend_id'] = $value ['recomend_id'] ? $value ['recomend_id'] : '';
            }
        }
        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['userInfo'] = $userInfo;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月19日 18:19:31
     * Description: 查看手机号
     * @return bool
     */
    public function actionMobile(){
        return true;
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月20日 15:18:11
     * Description: 查看身份证
     * @return bool
     */
    public function actionIdcard(){
        return true;
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月20日 15:37:55
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        $UserModel = new UserMain();

        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $newsForm = Yii::$app->request->post('UserMain');
            $UserModel->attributes = $newsForm;

            $UserModel->login_md5 = md5($UserModel->mobile);
            $UserModel->mobile = Yii::$app->mcrypt->encode($UserModel->mobile, '99elon') ;
//            print_r($UserModel);die;
            if (!$UserModel->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($UserModel->errors)]);
            }

//            $UserModel->save();

            $realuser = new Realuser();
            $res = $realuser -> insert($UserModel);
            //添加成功写入操作日志
//            \admin\components\LogComponents::saveDolog('添加,文章标题：' . $newsForm['title']);

            return Json::encode($res);
//            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }

        $this->_data['model'] = $UserModel;
        $this->_data['model'] -> sex = 1;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月20日 15:38:24
     * Description: 编辑
     * @return string
     */
    public function actionEdit(){
        return parent::autoRender();
    }
}
