<?php
/**
 * Author: yimpor
 * Date: 2017/1/13    21:43
 * Description:
 */

namespace admin\modules\content\controllers;

use admin\components\Base;
use admin\modules\content\handler\CategoryHandler;
use admin\modules\content\handler\TagsLibrary;
use lib\models\category\Category;
use lib\models\news\News;
use lib\models\tag\Tag;
use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class NewsController extends BaseController
{

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:01:43
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        $search = Yii::$app->request->get('search');
        $keyword = trim($search['keyword']);
        $where = 'status = 1 ';
        if (!empty($search['catid']))
        {
            $cat = Yii::$app->params['category'];
            if (!empty($cat[$search['catid']]['arrchildid']))
            {
                $where .= " and  db_category.catid IN (" . $search['catid'] . ',' . $cat[$search['catid']]['arrchildid'] . ")";
            }
            else
            {
                $where .= " and  db_category.catid = " . $search['catid'];
            }
        }
        if (!empty($search['type']) && !empty($search['keyword']))
        {
            if ($search['type'] == 'alticle_id')
            {
                $where_keyword = " id = " . intval($keyword);
            }
            else
            {
                $where_keyword = " title like '%" . $keyword . "%'";
            }
            $where .= " and  " . $where_keyword;
        }
        if (!empty($search['stime']))
        {
            $stime = strtotime($search['stime']);
            $etime = empty($search['etime']) ? time() : strtotime($search['etime']);
            $where_date = ' inputtime BETWEEN ' . $stime . ' and ' . $etime;
            $where .= " and  " . $where_date;
        }
        $query = News::find()->joinWith('category')->orderBy('id DESC')->where($where);
        $count = $query->count();
        $page = parent::page($count);
        $order = "id DESC";
        $pagelist = $query->orderBy($order)->offset($page->offset)->limit($page->limit)->all();
        $this->_data['count'] = $count;
        $this->_data['page'] = $page;
        $this->_data['pagelist'] = $pagelist;
        $moduleid = $this->category();
        $this->_data['moduleid'] = $moduleid;
        //$PageModel->find()->createCommand()->getRawSql();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:01:55
     * Description: 添加
     * @return string
     */
    public function actionAdd()
    {
        $News = new News();
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $newsForm = Yii::$app->request->post('News');
            $News->attributes = $newsForm;
            $News->small_thumb = $News->thumb;
            $News->adduser = Yii::$app->session['auth']['id'];
            $News->addname = Yii::$app->session['auth']['nickname'];
            $News->author = Yii::$app->session['auth']['nickname'];
            $News->inputtime = time();
            $News->updatetime = time();
            if (!$News->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($News->errors)]);
            }
            $News->save();
            $artitle_id = $News->attributes['id'];
            //添加tags标签
            if ($News->tags)
            {
                //更新标签
                TagsLibrary::app()->add($News->tags, $artitle_id);
            }
            //添加成功写入操作日志
            \admin\components\LogComponents::saveDolog('添加文章,文章标题：' . $newsForm['title']);

            return Json::encode(['status' => 1, 'msg' => '添加成功']);
        }
        $this->_data['model'] = $News;
        $this->_data['model'] -> sitetype = 0;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = $this->category();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:02:05
     * Description: 修改
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionEdit()
    {
        $News = News::find()->where(['id' => Yii::$app->request->get('id', 0)])->one();
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            if (empty($News))
            {
                return Json::encode(['status' => 0, 'msg' => '请求异常']);
            }
            $newsForm = Yii::$app->request->post('News');
            $News->attributes = $newsForm;
            $News->small_thumb = $News->thumb;
            $News->adduser = Yii::$app->session['admin']['id'];
            $News->addname = Yii::$app->session['admin']['nickname'];
            $News->author = Yii::$app->session['admin']['nickname'];
            $News->updatetime = time();
            if (!$News->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($News->errors)]);
            }
            $News->save();
            //更新标签
            TagsLibrary::app()->updateTag($News->attributes['tags'], $News->attributes['id']);

            //写入操作日志
            \admin\components\LogComponents::saveDolog("编辑文章, 文章ID：{$News->id}");
            //修改成功刷新页面
            return Json::encode(['status' => 1, 'msg' => '修改成功']);
        }
        if (empty($News))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        $News->updatetime = empty($News->updatetime) ? '' : date('Y-m-d H:i:s', $News->updatetime);
        $this->_data['model'] = $News;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        $this->_data['groups'] = $this->category();
        return parent::autoRender();
    }


    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:02:14
     * Description: 删除
     * @return string
     */
    public function actionDel()
    {
        //判断合法提交
        if (!Yii::$app->request->isPost || Yii::$app->request->post('id') == null)
        {
            return Json::encode(['status' => 0, 'msg' => '请求异常']);
        }
        $News = News::find()->where(['id' => Yii::$app->request->post('id', 0)])->one();
        if ($News)
        {
            $News->status = 0;
            $News->save(false);

            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除文章,文章ID：' . $News->id);
            return Json::encode(['status' => 1]);
        }
        //删除失败或者单页面不存在
        return Json::encode(['status' => 0]);
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:02:22
     * Description: 推荐
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRem()
    {
        $News = News::find()->where(['id' => Yii::$app->request->get('id', 0)])->one();
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            if (empty($News))
            {
                return Json::encode(['status' => 0, 'msg' => '请求异常']);
            }
            $newsForm = Yii::$app->request->post('News');
            $News->attributes = $newsForm;
            $News->style = '';
            $News->adduser = Yii::$app->session['admin']['id'];
            $News->addname = Yii::$app->session['admin']['nickname'];
            if (!$News->validate())
            {
                return Json::encode(['status' => -1, 'msg' => Base::modelError($News->errors)]);
            }
            $News->save();
            //写入操作日志
            \admin\components\LogComponents::saveDolog("推荐文章, 文章ID：{$News->id}");
            //修改成功刷新页面
            return Json::encode(['status' => 1]);
        }
        if (empty($News))
        {
            throw new \yii\web\HttpException(500, "异常请求");
        }
        $this->_data['model'] = $News;
        $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月16日 18:02:43
     * Description: 文章分类查询
     * @return mixed
     */
    private function category()
    {
        $moduleid = Category::find()->orderBy('listorder ASC')->asArray()->all();
        $lastCat = [];
        CategoryHandler::catSort($moduleid, $lastCat, false, true);
        foreach ($lastCat as $key => $val)
        {
            if ($val['moduleid'] == 1)
            {
                $categorydata[$val['catid']] = $val;
            }
        }

        foreach ($categorydata as $k => $v)
        {
            if (!isset($categorydata[$v['parentid']]))
            {
                $v['catname'] = str_replace('　', '', $v['catname']);
                $categorydata[$k]['catname'] = str_replace('┣ ', '', $v['catname']);
            }
        }

        foreach ($categorydata as $k => $v)
        {
            $_categorydata[$v['catid']] = $v['catname'];
        }


        return $_categorydata;
    }

}