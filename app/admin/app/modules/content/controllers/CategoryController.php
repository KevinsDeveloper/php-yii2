<?php

namespace admin\modules\content\controllers;

use Yii;
use admin\components\BaseController;
use admin\modules\content\handler\CategoryHandler;
use lib\models\category\Category;
use yii\helpers\Json;
use admin\components\Base;
use lib\models\news\News;
use lib\models\page\Page;

class CategoryController extends BaseController
{
    /**
     * Author: Yimpor
     * Date: 2017年1月13日 21:04:11
     * Description: 列表
     * @return string
     */
    public function actionIndex()
    {
        $lastCat = [];
        //栏目按照父子关系重新排序
        if (!is_array(Yii::$app->params['category']))
        {
            $this->actionRefresh();
            $this->redirect(['/content/category/index']);
        }
        CategoryHandler::catSort(Yii::$app->params['category'], $lastCat, false);

        //搜索
        $search = Yii::$app->request->get('catname');
        if (!empty($search))
        {
            foreach ($lastCat as $k => $v)
            {
                if (strpos($v['catname'], Yii::$app->request->get('catname')) === false)
                {
                    unset($lastCat[$k]);
                }
            }
        }

        $this->_data['catList'] = $lastCat;
        return parent::autoRender();
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 19:20:22
     * Description: 添加
     * @return string
     */
    public function actionAdd(){
        if (Yii::$app->request->isGet)
        {
            $this->_data['model'] = new Category();
            $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
            $lastCat = [];
            $parentid[0] = '默认顶级栏目';

            //栏目按照父子关系重新排序
            CategoryHandler::catSort(Yii::$app->params['category'], $lastCat);

            //生成栏目ID和栏目名的键值对
            foreach ($lastCat as $k => $v)
            {
                $parentid[$v['catid']] = $v['catname'];
            }

            $this->_data['parentid'] = $parentid;
            $this->_data['tmp'] = Yii::$app->params['template'];
            $this->_data['tmp']['tpl'][0] = '无';
            $this->_data['model']->moduleid = 0;
            $this->_data['model']->isshow = 1;
            $this->_data['model']->ismenu = 1;
            $this->_data['model']->style = 'none';
            $this->_data['model']->sitetype = 0;
            return parent::autoRender();
        }
        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $Category = new Category();
            $Category->attributes = Yii::$app->request->post('Category');
//            $Category->setScenario('create');

            //验证表单数据
            if (!$Category->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Category->errors)]);
            }

            //生成上级ID组
            if ($Category['parentid'] != 0)
            {
                $arrparentid = Category::find()->where(['catid' => $Category['parentid']])->one();
                $Category->arrparentid = $arrparentid['arrparentid'] == '' ? $Category['parentid'] : $Category['parentid'] . ',' . $arrparentid['arrparentid'];
            }

            //获取添加人信息
            $Category->addid = Yii::$app->session['auth']['id'];
            $Category->addname = Yii::$app->session['auth']['nickname'];
            $Category->addtime = time();

            //插入数据
            if (!$Category->save())
            {
                return Json::encode(['status' => 0, 'msg' => '创建栏目失败，请联系管理员']);
            }

            //生成下级ID组
            $lastId = Yii::$app->db->getLastInsertID();
            if ($Category->arrparentid != null)
            {
                $pids = explode(",", $Category->arrparentid);
                if (is_array($pids))
                {
                    foreach ($pids as $v)
                    {
                        $cat = Category::find()->where(['catid' => $v])->one();
                        $cat->arrchildid = empty($cat->arrchildid) ? $lastId : $lastId . ',' . $cat->arrchildid;
                        $cat->update();
                    }
                }
            }

            //写入操作日志
            \admin\components\LogComponents::saveDolog('创建栏目,栏目名：' . Yii::$app->request->post('Category')['catname'] . ',栏目ID' . $lastId);

            //修改单页面表数据
            if ($Category->moduleid == 0)
            {
                //执行插入
                $sgPage = new Page();
                $sgPage->catid = $lastId;
                $sgPage->content = 'content';
                $sgPage->wap_content = 'wap_content';
                $sgPage->updatetime = time();
                if (!$sgPage->insert())
                {
                    return Json::encode(['status' => 0, 'msg' => '栏目添加成功，但单页面列表添加失败']);
                }
            }

            //创建成功刷新栏目
            $this->actionRefresh();
            return Json::encode(['status' => 1]);
        }
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 20:57:19
     * Description: 编辑
     * @return string
     * @throws \Exception
     * @throws \yii\web\HttpException
     */
    public function actionEdit(){
        if (Yii::$app->request->isGet)
        {
            $Category = Category::find()->where(['catid' => Yii::$app->request->get('catid')])->one();
            if (empty($Category))
            {
                throw new \yii\web\HttpException(500, "异常请求");
            }
            $lastCat = [];
            $parentid[0] = '终极栏目';
            //栏目按照父子关系重新排序
            CategoryHandler::catSort(Yii::$app->params['category'], $lastCat);
            //生成栏目ID和栏目名的键值对
            foreach ($lastCat as $k => $v)
            {
                $parentid[$v['catid']] = $v['catname'];
            }
            $this->_data['model'] = $Category;
            $this->_data['parentid'] = $parentid;
            $this->_data['attributeLabels'] = $this->_data['model']->attributeLabels();
            $this->_data['tmp'] = Yii::$app->params['template'];
            $this->_data['tmp']['tpl'][0] = '无';
            $this->_data['tmp']['wap_tpl'][0] = '无';
            return parent::autoRender();
        }

        if (Yii::$app->request->isAjax || Yii::$app->request->isPost)
        {
            $changePartid = false;
            $singlePage = false;
            $Category = Category::find()->where(['catid' => Yii::$app->request->post('catid')])->one();
            if (!$Category)
            {
                return Json::encode(['status' => 0, 'msg' => '栏目不存在']);
            }
            //父栏目不能是自身
            if (Yii::$app->request->post('catid') == Yii::$app->request->post('Category')['parentid'])
            {
                return Json::encode(['status' => 0, 'msg' => '不能选择自身作为父栏目']);
            }
            if ($Category->parentid != Yii::$app->request->post('Category')['parentid'])
            {
                //判断是否改变了栏目继承关系
                $changePartid = true;
            }
            if ($Category->moduleid == 0)
            {
                $singlePage = true;
            }
            $Category->attributes = Yii::$app->request->post('Category');
            //验证表单数据
            if (!$Category->validate())
            {
                return Json::encode(['status' => 0, 'msg' => Base::modelError($Category->errors)]);
            }

            //更新数据
            if ($changePartid)
            {
                CategoryHandler::rebuild($Category);
            }
            elseif ($Category->update() === false)
            {
                return Json::encode(['status' => 0, 'msg' => '保存栏目失败，请联系管理员']);
            }

            //写入操作日志
            \admin\components\LogComponents::saveDolog('编辑栏目,栏目名：' . Yii::$app->request->post('Category')['catname'] . ',栏目ID' . Yii::$app->request->post('catid'));

            //修改单页面表数据
            if (!$singlePage && $Category->moduleid == 0)
            {
                //执行插入
                $sgPage = new Page();
                $sgPage->catid = Yii::$app->request->post('catid');
                $sgPage->content = 'content';
                $sgPage->wap_content = 'wap_content';
                $sgPage->updatetime = time();
                if (!$sgPage->insert())
                {
                    return Json::encode(['status' => 0, 'msg' => '栏目编辑成功，但单页面列表添加失败']);
                }
            }
            elseif ($singlePage && $Category->moduleid != 0)
            {
                //执行删除
                $sgPage = Page::find()->where(['catid' => Yii::$app->request->post('catid')])->one();
                if (!$sgPage->delete())
                {
                    return Json::encode(['status' => 0, 'msg' => '栏目编辑成功，但单页面列表删除失败']);
                }
            }

            //编辑成功刷新栏目
            $this->actionRefresh();
            return Json::encode(['status' => 1]);
        }
        return Json::encode(['status' => 0, 'msg' => '请求异常']);
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月13日 21:00:43
     * Description: 删除
     * @return mixed
     * @throws \Exception
     */
    public function actionDel(){
        //判断合法提交
        if (!Yii::$app->request->isPost || Yii::$app->request->post('catid') == null)
        {
            return Json::encode(['status' => 0, 'msg' => '请求异常']);
        }

        $Category = Category::find()->where(['catid' => Yii::$app->request->post('catid')])->one();
        //如果有子栏目就不能删除
        if ($Category->arrchildid != '')
        {
            return Json::encode(['status' => 0, 'msg' => '有下级栏目，不能直接删除!']);
        }
        //如果有该栏目的列表页就不能删除
        if (News::find()->where(['catid' => Yii::$app->request->post('catid')])->one())
        {
            return Json::encode(['status' => 0, 'msg' => '存在该栏目的列表页，不能直接删除!']);
        }
        //如果有该栏目的简单列表页就不能删除
//        if (Single::find()->where(['catid' => Yii::$app->request->post('catid')])->one())
//        {
//            return Json::encode(['status' => 0, 'msg' => '存在该栏目的简单列表页，不能直接删除!']);
//        }
        if ($Category && $Category->delete())
        {
            //删除单页面列表数据
            if ($Category->moduleid == 0 && $singlePage = Page::find()->where(['catid' => Yii::$app->request->post('catid')])->one())
            {
                $singlePage->delete();
            }
            //删除父栏目的下级ID组
            if ($Category->arrparentid != 0)
            {
                $arrparentid = explode(',', $Category->arrparentid);
                foreach ($arrparentid as $k => $v)
                {
                    $_cat = Category::find()->where(['catid' => $v])->one();
                    $arrchildid = explode(',', $_cat->arrchildid);
                    if (!is_array($arrparentid) || !in_array($Category->catid, $arrchildid))
                    {
                        continue;
                    }
                    unset($arrchildid[array_search($Category->catid, $arrchildid)]);
                    $_cat->arrchildid = implode(',', $arrchildid);
                    $_cat->update();

                }
            }

            //删除成功写入操作日志
            \admin\components\LogComponents::saveDolog('删除栏目,栏目名：' . $Category->catname . ',栏目ID' . Yii::$app->request->post('catid'));

            //重新生成栏目文件
            $this->actionRefresh();

            return Json::encode(['status' => 1]);
        }
        //删除失败或者栏目不存在
        return Json::encode(['status' => 0]);
    }
    /**
     * Author: Yimpor
     * Date: 2017年1月13日 20:50:00
     * Description: 刷新栏目
     * @return string
     */
    public function actionRefresh()
    {
        $Category = Category::find()->orderBy('listorder ASC')->asArray()->all();
        $catlist = [];
        $lastCat = [];
        $rules = [];

        CategoryHandler::catSort($Category, $lastCat, false, false);

        //把栏目ID转成数组的键
        foreach ($lastCat as $k => $v)
        {
            $catlist[$v['catid']] = $v;
        }

        //生成栏目路由数组
        foreach ($Category as $k => $v)
        {
            if (!empty($v['url']))
            {
//                if (in_array($v['moduleid'], [0]))
//                {
//                    $pageurl = \lib\Common::setPageUrl($v['url']);
//                    $rules[$pageurl] = $v['template'];
//                }
//                if (in_array($v['moduleid'], [1]))
//                {
//                    $pageurl = \lib\Common::setDetailUrl($v['url']);
//                    $rules[$pageurl] = \Yii::$app->params['categorydetail'][$v['moduleid']];
//                }
                if (in_array($v['moduleid'], [1]))
                {
                    $pageurl = \lib\Common::setPageUrl($v['url']);
                    $rules[$pageurl] = $v['template'];
                }
                $rules[$v['url']] = $v['template'];
            }
        }

        //生成栏目文件
        $catlist = var_export($catlist, true);
        $cat_path = CONFIG_DIR . "category.php";
        $cat_content = "<?php \r\n";
//        $cat_content .= "namespace lib\\" . APP_CONFIG . "; \r\n";
        $cat_content .= "namespace lib\config; \r\n";
        $cat_content .= 'return ' . $catlist . ";\r\n";
        $cat_content .= "?>";

        //生成路由文件
        $rules = var_export($rules, true);
        $rules_path = CONFIG_DIR . "rules.php";
        $rules_content = "<?php \r\n";
//        $rules_content .= "namespace lib\\" . APP_CONFIG . "; \r\n";
        $rules_content .= "namespace lib\config; \r\n";
        $rules_content .= 'return ' . $rules . ";\r\n";
        $rules_content .= "?>";

        if (file_put_contents($cat_path, $cat_content) && file_put_contents($rules_path, $rules_content))
        {
            return Json::encode(['status' => 1]);
        }
        return Json::encode(['status' => 0]);
    }
}
