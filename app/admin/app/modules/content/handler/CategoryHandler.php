<?php

namespace admin\modules\content\handler;
/**
 * Author: yimpor
 * Date: 2017/1/13    18:15
 * Description: 栏目管理助手
 */

use lib\models\Category;

class CategoryHandler
{
    /**
     * @Author js
     * 栏目按照关系重新排序
     * @param $arr1 要排序的数组
     * @param $arr2 排序完成的数组
     * @param $index 从栏目ID为index的栏目开始排序
     * @param $icon 是否显示关系图标
     */
    public static function catSort(&$arr1, &$arr2, $index = 0, $icon = true)
    {
        foreach ($arr1 as $k => $v)
        {
            if ($v['parentid'] == $index)
            {
                if ($index != 0)
                {
                    $pid = explode(",", $v['arrparentid']);
                    if ($icon)
                    {
                        $v['catname'] = str_repeat('　', count($pid)) . '┣ ' . $v['catname'];
                    }
                }
                $arr2[] = $v;
                self::catSort($arr1, $arr2, $v['catid'], $icon);
            }
        }
    }

    /**重新建立栏目父子关系
     * @param $Category 要修改的栏目模型实例
     */
    public static function rebuild(&$Category)
    {
        if ($Category->arrparentid != '')
        {
            $arrparentid = explode(',', $Category->arrparentid);
        }

        //在原父栏目的下级ID组剔除自身
        if (!empty($arrparentid) && is_array($arrparentid))
        {
            foreach ($arrparentid as $k => $v)
            {
                $_cat = \lib\models\category\Category::find()->where(['catid' => $v])->one();
                $_arrchildid = explode(',', $_cat->arrchildid);
                unset($_arrchildid[array_search($Category->catid, $_arrchildid)]);
                $_cat->arrchildid = implode(',', $_arrchildid);
                $_cat->update();
            }
        }

        //添加新的上级ID组并更新上级ID组的下级ID组
        if ($Category->parentid != 0)
        {
            $_cat = \lib\models\category\Category::find()->where(['catid' => $Category->parentid])->one();
            $Category->arrparentid = $_cat->arrparentid == '' ? $_cat->catid : $_cat->catid . ',' . $_cat->arrparentid;

            foreach (explode(',', $Category->arrparentid) as $k => $v)
            {
                $_cat = \lib\models\category\Category::find()->where(['catid' => $v])->one();
                $_arrchildid = explode(',', $_cat->arrchildid);
                if (!in_array($Category->catid, $_arrchildid))
                {
                    $_cat->arrchildid = $_cat->arrchildid == '' ? $Category->catid : $Category->catid . ',' . $_cat->arrchildid;
                }
                $_cat->update(false);
            }
        }
        else
        {
            $Category->arrparentid = '';
        }
        $Category->update(false);

        //修改现有下级ID组的栏目继承关系
        if ($Category->arrchildid != '')
        {
            $childid = explode(',', $Category->arrchildid);
            foreach ($childid as $k => $v)
            {
                $_cat = \lib\models\category\Category::find()->where(['catid' => $v])->one();
                self::rebuild($_cat);
            }
        }
    }
}