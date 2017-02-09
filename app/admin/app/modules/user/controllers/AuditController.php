<?php
/**
 * Author: yimpor
 * Date: 2017/1/19    15:37
 * Description:
 */

namespace admin\modules\user\controllers;

use lib\models\member\UserAttach;
use lib\models\member\UserMain;
use Yii;
use admin\components\BaseController;

class AuditController extends BaseController
{
    private $key='hasdf7348jdfo7kr2p3ujdft34ujt54tu';
    /**
     * Author: Yimpor
     * Date: 2017年1月19日 18:21:41
     * Description: 列表
     * @return string
     */
    public function actionIndex(){
        $search = Yii::$app->request->get('search');
        $where = '  uid is not null ';

        if (!empty($search['type']) && !empty($search['keyword']))
        {
            $type = $search['type']?$search['type']:'';
            if($type == "mobile"){
                $where .= " AND m.phonemd5='".md5($search['keyword'].$this->key)."'";
            }else{
                $where .= " AND m.". $search['type'] . " like '%" . $search['keyword'] . "%'";
            }
        }
        if (!empty($search['bankStatus']) && $search['bankStatus']) {
            if($search['bankStatus'] == 100){
                $where .= $where ? ' AND el_user_attach.examine_bank = 0' : "el_user_attach.examine_bank = 0";
            }else {
                $where .= $where ? ' AND el_user_attach.examine_bank = "' . $search['bankStatus'] . '"' : "el_user_attach.examine_bank = " . $search['bankStatus'];
            }
        }
        if (!empty($search['idStatus']) && $search['idStatus']) {
            if($search['idStatus'] == 100){
                $where .= $where ? ' AND el_user_attach.examine_id_ard = 0' : "el_user_attach.examine_id_ard = 0";
            }else {
                $where .= $where ? ' AND el_user_attach.examine_id_ard = "' . $search['idStatus'] . '"' : "el_user_attach.examine_id_ard = " . $search['idStatus'];
            }
        }

        $UserAttachModel = new UserAttach();
        $query = $UserAttachModel->find()
            ->select(['el_user_attach.*', 'm.user_id', 'm.user_name', 'm.real_name', 'm.mobile', 'm.phonemd5', 'm.evidence_type', 'm.evidence_num', 'm.bank_name', 'm.account_num', 'm.account_name'])
            ->rightJoin('el_user_main AS m', 'el_user_attach.uid = m.user_id')
            ->where($where);

        $count = $query->count();
        $page = parent::page($count);
        $order = "el_user_attach.idadd_time DESC";
        $userAttachInfo = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();
        if ($userAttachInfo) {
            foreach($userAttachInfo as $key => $value){
                $userAttachInfo [$key] ['idadd_time'] = $value ['idadd_time'] ? date('Y-m-d H:i:s', $value ['idadd_time']) : "";
                $userAttachInfo [$key] ['bankadd_time'] = $value ['bankadd_time'] ? date('Y-m-d H:i:s', $value ['bankadd_time']) : "";
                $userAttachInfo [$key] ['mobile'] = $value ['mobile'] ? Yii::$app->encrypt->decode($value ['mobile']) : '';

                # 身份证正面附件地址
                $idcard1 = '';
                if($value['id_card1'])
                {
                    if(strpos($value['id_card1'], 'uploads') !== false)
                    {
                        $idcard1 = WEB_USER."/".$value['id_card1'];
                    }
                    else
                    {
                        $idcard1 = "http://static.kfd9999.com/".$value['id_card1'];
                    }
                }
                # 身份证反面附件地址
                $idcard2 = '';
                if($value['id_card2'])
                {
                    if(strpos($value['id_card2'], 'uploads') !== false)
                    {
                        $idcard2 = WEB_USER."/".$value['id_card2'];
                    }
                    else
                    {
                        $idcard2 = "http://static.kfd9999.com/".$value['id_card2'];
                    }
                }
                $bankfile = '';
                if($value['bank_scanning'])
                {
                    if(strpos($value['bank_scanning'], 'uploads') !== false)
                    {
                        $bankfile = WEB_USER."/".$value['bank_scanning'];
                    }
                    else
                    {
                        $bankfile = "http://static.kfd9999.com/".$value['bank_scanning'];
                    }
                }
                $userAttachInfo[$key]['id_card1'] = $idcard1;
                $userAttachInfo[$key]['id_card2'] = $idcard2;
                $userAttachInfo[$key]['bank_scanning'] = $bankfile;
            }
        }
        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['userAttachInfo'] = $userAttachInfo;
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
     * Date: 2017年1月20日 15:08:00
     * Description: 查看身份证
     * @return bool
     */
    public function actionIdcard(){
        return true;
    }
}