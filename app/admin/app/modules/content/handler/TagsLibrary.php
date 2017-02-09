<?php
namespace admin\modules\content\handler;

use lib\models\news\News;
use lib\models\tag\NewsTag;
use lib\models\tag\Tag;
use yii\base\Exception;

/**
 *
 * @Copyright (C), 2014-04-03, Alisa.
 * @Name TagsLibrary.php
 * @Author Alisa 376526771@qq.com
 * @Version  Beta 1.0
 * @description  标签文章标签管理类
 **/
class TagsLibrary
{
    /**
     * [$errors 错误提示语]
     * @var string
     */
    public $errors = '';

    /**
     * 标签类型
     * @var int
     */
    public $type;

    /**
     * [app 实例化本来]
     * @param  [array] $data [参数]
     * @return [type]       [对象]
     */
    public static function app($data = array(), $type = 1)
    {
        $classNmae = __class__;
        $object = new $classNmae();
        $object->type = $type;

        if (!is_array($data) || count($data) <= 0)
        {
            return $object;
        }

        foreach ($data as $key => $value)
        {
            if (!isset(self::$key))
            {
                throw new Exception(self::$key . "参数赋值异常", 403);
            }

            self::$key = $value;
        }

        return $object;
    }

    /**
     * [add 发布文章关联标签]
     * @param [string | array] $tags   标签
     * @param [int] $newsId 文章ID
     * @param [int] $type 标签类型
     */
    public function add($tags, $newsId)
    {
        if (!$tags)
        {
            return ['status' => 1, 'msg' => \yii::t('app', 'error')];
        }
        $this->errors = '';

        if (is_string($tags))
        {
            $tags = str_replace("，", ",", $tags);
            $tags = explode(',', $tags);
        }
        $this->errors = '';
        foreach ($tags as $key => $value)
        {
            if (empty($value))
            {
                continue;
            }
            $tid = $this->isThereByName($value);
            if ($tid)
            {
                $newsTag = $this->isTag($tid, $newsId);
                if (!$newsTag)
                {
                    $tid = $this->updateNum($tid);
                }
            }
            else
            {
                $tid = $this->insert($value);
            }

            if ($tid)
            {
                $this->insertTag($tid, $newsId);
            }
            else
            {
                $this->errors .= $value . \yii::t('app', 'tag_add_error');
            }
        }
        if (!empty($this->errors))
        {
            return ['status' => 1, 'msg' => ''];
        }
        else
        {
            return ['status' => 0, 'msg' => $this->errors];
        }
    }

    /**
     * [updateTag 更新文章标签]
     * @param  string | array $tags 标签
     * @param  int $newsId 文章ID
     * @return void
     */
    public function updateTag($tags, $newsId)
    {
        if (is_string($tags))
        {
            $tags = str_replace("，", ",", $tags);
            $tags = explode(',', $tags);
        }
        $oldTags = $this->getTags($newsId);
        $delTags = array();
        $addTags = array();
        # 判断是否新增标签
        foreach ($tags as $k => $v)
        {
            if (!in_array($v, $oldTags))
            {
                array_unshift($addTags, $v);
            }
        }
        # 判断是否删除标签
        foreach ($oldTags as $k => $v)
        {
            if (!in_array($v, $tags))
            {
                array_unshift($delTags, $v);
            }
        }
        if ($addTags)
        {
            $this->add($addTags, $newsId);
        }
        if ($delTags)
        {
            $this->delAllTags($delTags, $newsId);
        }
    }

    /**
     * [insert 添加标签]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function insert($name)
    {
        $model = new Tag();
        $model->name = $name;
        $model->num = 1;
        $model->type = $this->type;
        $model->save();
        return empty($model->errors) ? $model->id : '';
    }

    /**
     * [insertNewtag 文章策略关联标签]
     * @param  int $tid 标签ID
     * @param  int $nid 文章ID
     * @return [type]      [description]
     */
    public function insertTag($tid, $nid)
    {
        $isTag = $this->isTag($tid, $nid);
        if (!$isTag)
        {
            if ($this->type == 1)
            {
                $model = new NewsTag();
                $model->nid = $nid;
            }
            else
            {
//                $model = new AnalystTrendsTag();
//                $model->aid = $nid;
            }
            $model->tid = $tid;
            $model->save();
            return empty($model->errors) ? $model->id : '';
        }
        else
        {
            return $isTag;
        }

    }

    /**
     * [update 修改标签]
     * @param  [type] $id   [description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function updateNum($id)
    {
        $model = Tag::findOne(['id' => $id, 'type' => $this->type]);
        $model->num = $model->num + 1;
        $model->save();
        return empty($model->errors) ? $model->id : '';
    }

    /**
     * [isThereByName 根据标签名称查询是否存在]
     * @return boolean [description]
     */
    public function isThereByName($tags)
    {
        $query = Tag::findOne(['name' => $tags, 'type' => $this->type]);
        return $query['id'] ? $query['id'] : '';
    }

    /**
     * [isThereById 根据标签ID查询是否存在]
     * @return boolean [description]
     */
    public function isThereById($tagId)
    {
        $query = Tag::findOne(['id' => $tagId, 'type' => $this->type]);
        return $query['id'] ? $query['id'] : '';
    }

    /**
     * [isTag 标签是否存在]
     * @param  int $tid 标签ID
     * @param  int $nid 文章ID
     * @return boolean      [description]
     */
    public function isTag($tid, $nid)
    {
        if ($this->type == 1)
        {
            $query = NewsTag::findOne(['tid' => $tid, 'nid' => $nid]);
        }
        elseif ($this->type == 2)
        {
//            $query = AnalystTrendsTag::findOne(['tid' => $tid, 'aid' => $nid]);
        }
        return $query['id'] ? $query['id'] : '';
    }

    /**
     * [getTags 查询文章、策略所关联的标签]
     * @param  int $nid 文章ID
     * @return array
     */
    public function getTags($nid)
    {
        if ($this->type == 1)
        {
            $query = Tag::findBySql("SELECT b.id,name FROM " . NewsTag::tableName() . " a JOIN " . Tag::tableName() . " b ON a.tid=b.id WHERE nid=" . $nid)->all();
            $tags = array();
        }
        elseif ($this->type == 2)
        {
//            $query = Tag::findBySql("SELECT b.id,name FROM " . AnalystTrendsTag::tableName() . " a JOIN " . Tag::tableName() . " b ON a.tid=b.id WHERE aid=" . $nid)->all();
//            $tags = array();
        }

        if ($query)
        {
            foreach ($query as $key => $value)
            {
                $tags[$value['id']] = $value['name'];
            }
        }
        return $tags;
    }

    /**
     * [delAllTags 删除文章、策略标签]
     * @param   string|array $tags 标签
     * @param   int $newId 文章ID
     * @return  void
     */
    public function delAllTags($tags, $newId)
    {
        if (is_string($tags))
        {
            $tags = str_replace('，', ',', $tags);
            $tags = explode(',', $tags);
        }
        foreach ($tags as $key => $value)
        {
            $model = Tag::findOne(['name' => $value, 'type' => $this->type]);
            if ($model['id'])
            {
                if ($this->type == 1)
                {
                    $query = NewsTag::deleteAll(['nid' => $newId, 'tid' => $model['id']]);
                }
                else
                {
//                    $query = AnalystTrendsTag::deleteAll(['aid' => $newId, 'tid' => $model['id']]);
                }

                if ($query)
                {
                    $model->num = $model->num - 1;
                    $model->save();
                }
            }
        }
    }

    /**
     * [delTags 删除标签（同时删除相关联的所有文章）]
     * @param  int $id 标签ID
     * @return [type] [description]
     */
    public function delTags($id)
    {
        $query = Tag::findOne(['id' => $id, 'type' => $this->type]);
        if (empty($query['id']))
        {
            $this->error(\yii::t('app', 'noRow'));
        }
        $delTagName = $query['name'];
        $result = $query->delete();
        if ($result)
        {
            $news = \lib\models\News::findBySql("SELECT a.id, tags FROM `kfd_news` a JOIN `kfd_news_tag` b ON a.id=b.nid WHERE b.tid=" . $id)->all();
            if ($news)
            {
                foreach ($news as $key => $value)
                {
                    if ($value['tags'])
                    {
                        $articleTag = explode(',', $value['tags']);
                        $key = array_search($delTagName, $articleTag);
                        if ($key)
                        {
                            unset($articleTag[$key]);
                        }
                        $newArticleTag = implode(',', $articleTag);
                        News::updateAll(['tags' => $newArticleTag], 'id=' . $value['id']);
                    }

                }
            }
            NewsTag::deleteAll(['tid' => $id]);
        }
        return $result;
    }
}           