<?php

namespace admin\modules\trade\controllers;

use lib\models\member\AccountTransaction;
use Yii;
use admin\components\BaseController;

class OutController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月18日 10:14:03
     * Description: 出金记录
     * @return string
     */
    public function actionIndex(){
        $search = Yii::$app->request->get('search');

        $where = ' platform_type=1  and el_account_transaction.transaction_type =3 ';
        $tp = $search['tp'];
        if ($tp == 1) {
            $where .= " and (el_account_transaction.status=10 or el_account_transaction.status=12)";
        }
        if ($tp == 2) {
            $where .= " and (el_account_transaction.status=4 or el_account_transaction.status=5 or el_account_transaction.status=11)";
        }

        $type = $search ['type'];
        $typeStatus = $search['typeStatus'];
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
            }else if($type == 'real_name'){
                $where .= $where ? ' AND m.' . $type . ' = "' . $word . '"' : 'm.' . $type . ' = "' . $word;
            }else {
                $where .= $where ? ' AND el_account_transaction.' . $type . ' = "' . $word . '"' : "el_account_transaction".$type . ' = "' . $word;
            }
        }

        if (!empty($typeStatus)) {
            if ("all" == $typeStatus) {
                $where .= ' and 1=1';
            }
            else if ('unusual' == $typeStatus) {
                $time = time() - 18000;
                $where .= " and el_account_transaction.transaction_time < {$time} and el_account_transaction.status = 1";
            }
            else {
                $where .= ' and el_account_transaction.status = ' . $typeStatus;
            }
        }

        if (isset($info['mtStatus']) && $info['mtStatus'] != '') {
            $where .= " and mt_status=" . $info['mtStatus'];
        }

        $query = AccountTransaction::find()->where($where)->select(['el_account_transaction.*', 'm.real_name', 'm.mobile', 'm.bank_address'])->leftJoin('el_user_main AS m', 'm.user_id = el_account_transaction.user_id');
        $count = $query->count();
        $page = parent::page($count);
        $order = "t_id DESC";
        $tradeOut = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->asArray()->all();
        if ($tradeOut) {
            $userId = array();
            foreach($tradeOut as $key => $value){
                array_push($userId, $value ['user_id']);
                $tradeOut [$key] ['sh_time'] = date('Y-m-d H:i:s', $value ['sh_time']);
                $tradeOut [$key] ['transaction_time'] = date('Y-m-d H:i:s', $value ['transaction_time']);
                $tradeOut [$key] ['finish_time'] = $value ['finish_time'] ? date('Y-m-d H:i:s', $value ['finish_time']) : "";
                $tradeOut [$key] ['injection_match'] = $value ['status'] != 4 ? $value['match_mt4'] : '';
                $tradeOut [$key] ['order_info_name'] = explode('|', $value['order_info']);
                $tradeOut [$key] ['mobile'] = $value ['mobile'] ? Yii::$app->encrypt->decode($value ['mobile']) : '';
                $tradeOut [$key] ['unusual'] = 0;
                if (($value['status'] == 1 || $value['status'] == 2 || $value['status'] == 7 || $value['status'] == 8 || $value['status'] == 9 || $value['status'] == 10) && ($value['transaction_time'] < (time() - 18000))) {
                    $tradeOut [$key] ['unusual'] = 1;
                }
            }
        }
        $this->_data['trade_list'] = $tradeOut;
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
