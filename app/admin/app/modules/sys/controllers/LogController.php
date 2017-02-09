<?php
/**
 * Author: yimpor
 * Date: 2017/1/17    18:01
 * Description:
 */

namespace admin\modules\sys\controllers;

use  Yii;
use admin\components\BaseController;
use admin\models\DbAdminLogin;
use admin\models\Dolog;

class LogController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月17日 18:03:50
     * Description: 登录日志
     * @return string
     */
    public function actionIndex(){
        $search = Yii::$app->request->get('search');
        $where = '';

        if (!empty($search['type']) && !empty($search['keyword']))
        {
            $where = $search['type'] . " like '%" . $search['keyword'] . "%'";
        }
        if (!empty($search['stime']))
        {
            $stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
            $where = 'login_time BETWEEN ' . $stime . ' and ' . $etime;
        }

        $LogModel = new DbAdminLogin();
        $query = $LogModel->find()->where($where);

        $count = $query->count();
        $page = parent::page($count);
        $order = "id DESC";
        $logInfo = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['logInfo'] = $logInfo;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月17日 18:03:50
     * Description: 操作日志
     * @return string
     */
    public function actionDolog(){
        $search = Yii::$app->request->get('search');
        $where = '';

        if (!empty($search['type']) && !empty($search['keyword']))
        {
            $where = $search['type'] . " like '%" . $search['keyword'] . "%'";
        }
        if (!empty($search['stime']))
        {
            $stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
            $where = 'time BETWEEN ' . $stime . ' and ' . $etime;
        }
        $LogModel = new Dolog();
        $query = $LogModel->find()->where($where);

        $count = $query->count();
        $page = parent::page($count);
        $order = "id DESC";
        $logInfo = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['logInfo'] = $logInfo;
        return parent::autoRender();
    }

}