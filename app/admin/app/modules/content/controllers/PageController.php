<?php
/**
 * Author: yimpor
 * Date: 2017/1/13    21:22
 * Description:
 */

namespace admin\modules\content\controllers;

use admin\components\Base;
use lib\models\page\Page;
use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class PageController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月13日 21:29:05
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        /* 单页面分类 */
        $moduleid = \lib\models\category\Category::find()->where(['moduleid' => 0])->select(['catid', 'catname'])->asArray()->all();
        $search = Yii::$app->request->get('search');
        $where = ' moduleid = 0 ';
        if (!empty($search['keyword']))
        {
            if ($where)
            {
                $where .= " and   db_category.catname like '%" . $search['keyword'] . "%'";
            }
            else
            {
                $where = "   db_category.catname like '%" . $search['keyword'] . "%'";
            }
        }
        $PageModel = new \lib\models\page\Page();
        $query = $PageModel->find()->joinWith('category')->orderBy('id DESC')->where($where);

        $count = $query->count();
        $page = parent::page($count);
        $order = "id DESC";
        $pagelist = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();

        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['moduleid'] = $moduleid;
        $this->_data['pagelist'] = $pagelist;

        //$PageModel->find()->createCommand()->getRawSql();

        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 21:29:14
     * Description: 修改
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEdit()
    {
        $Page = Page::find()->where(['id' => Yii::$app->request->get('id', 0)])->one();

        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            if (empty($Page))
            {
                return Json::encode(['status' => 0, 'msg' => '请求异常']);
            }
            $post = yii::$app->request->post('Page');
            $Page->content = $post['content'];
            $Page->updatetime = time();
            if (!$Page->save())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Page->errors)]);
            }

            //写入操作日志
            \admin\components\LogComponents::saveDolog("编辑单页面, 单页面：{$Page->id}");

            //修改成功刷新页面
            return Json::encode(['status' => 1]);
        }
        if (empty($Page))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        $this->_data['model'] = $Page;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 21:29:25
     * Description: 修改wap
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEditwap()
    {
        $Page = Page::find()->where(['id' => Yii::$app->request->get('id', 0)])->one();

        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            if (empty($Page))
            {
                return Json::encode(['status' => 0, 'msg' => '请求异常']);
            }
            $post = yii::$app->request->post('Page');
            $Page->wap_content = $post['wap_content'];
            $Page->updatetime = time();
            if (!$Page->save())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Page->errors)]);
            }

            //写入操作日志
            \admin\components\LogComponents::saveDolog("编辑wap单页面, wap单页面：{$Page->id}");

            //修改成功刷新页面
            return Json::encode(['status' => 1]);
        }
        if (empty($Page))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        $this->_data['model'] = $Page;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 21:29:41
     * Description: 删除
     * @return string
     * @throws \Exception
     */
    public function actionDel()
    {
        //判断合法提交
        if (!Yii::$app->request->isPost || Yii::$app->request->post('id') == null)
        {
            return Json::encode(['status' => 0, 'msg' => '请求异常']);
        }
        $Page = Page::find()->where(['id' => Yii::$app->request->post('id', 0)])->one();
        if ($Page && $Page->delete())
        {
            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除单页面,单页面名：' . $Page->id);
            return Json::encode(['status' => 1]);
        }
        //删除失败或者单页面不存在
        return Json::encode(['status' => 0]);
    }
}