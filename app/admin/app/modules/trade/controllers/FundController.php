<?php

namespace admin\modules\trade\controllers;

use lib\models\member\AccountTransaction;
use Yii;
use admin\components\BaseController;

class FundController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月18日 10:13:28
     * Description: 入金记录
     * @return string
     */
    public function actionIndex(){
        $search = Yii::$app->request->get('search');
        $where = ' transaction_type = 2 AND platform_type = 1 ';
        $type = $search ['type'];
        $status = $search['status'];
        $word = trim($search ['keyword']);
        $start = trim($search ['start']) ? trim($search ['start']) : null;
        $end = trim($search ['end']) ? trim($search ['end']) : null;

        if (!empty($end) || !empty($start)) {
            if (!empty($finishTime)) {    // 按交易完成时间查询
                $where .= $start ? ' AND finish_time >' . strtotime($start) : null;
                if ($end) {
                    $where = $where ? $where . ' AND finish_time <' . strtotime($end) : $where;
                }
            }
            else {
                $where .= $start ? ' AND transaction_time >' . strtotime($start) : null;
                if ($end) {
                    $where = $where ? $where . ' AND transaction_time <' . strtotime($end) : $where;
                }
            }
        }
        if (!empty($word) && $word) {
            if ($type == 'remarks') {
                $where .= " and remarks like '%" . $word . "%'";
            }else if($type == 'm.real_name'){
                $where .= $where ? ' AND ' . $type . ' = "' . $word . '"' : $type . ' = "' . $word;
            }else {
                $where .= $where ? ' AND el_account_transaction.' . $type . ' = "' . $word . '"' : "el_account_transaction".$type . ' = "' . $word;
            }
        }

        if (!empty($status)) {
            $where .= " AND el_account_transaction.status=" . $status;
        }
        if (isset($info['mtStatus']) && $info['mtStatus'] != '') {
            $where .= " and mt_status=" . $info['mtStatus'];
        }
        $query = AccountTransaction::find()->where($where)->select(['el_account_transaction.*', 'm.real_name', 'm.mobile'])->leftJoin('el_user_main AS m', 'm.user_id = el_account_transaction.user_id');
        $count = $query->count();
        $page = parent::page($count);
        $order = "t_id DESC";
        $this->_data['trade_list'] = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->asArray()->all();
        if ($this->_data['trade_list']) {
            $userId = array();
            foreach ($this->_data['trade_list'] as $key => $value) {
                array_push($userId, $value ['user_id']);
                $this->_data['trade_list'] [$key] ['sh_time'] = date('Y-m-d H:i:s', $value ['sh_time']);
                $this->_data['trade_list'] [$key] ['transaction_time'] = date('Y-m-d H:i:s', $value ['transaction_time']);
                $this->_data['trade_list'] [$key] ['finish_time'] = $value ['finish_time'] ? date('Y-m-d H:i:s', $value ['finish_time']) : "";
                $this->_data['trade_list'] [$key] ['injection_match'] = $value ['status'] != 4 ? $value['match_mt4'] : '';
                $this->_data['trade_list'] [$key] ['order_info_name'] = explode('|', $value['order_info']);
                $this->_data['trade_list'] [$key] ['mobile'] = $value ['mobile'] ? Yii::$app->encrypt->decode($value ['mobile']) : '';
            }
        }

        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月20日 17:45:18
     * Description: 查看手机号
     * @return bool
     */
    public function actionMobile(){
        return true;
    }
}
