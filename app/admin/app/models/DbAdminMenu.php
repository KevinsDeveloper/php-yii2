<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_menu}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $title
 * @property string $url
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $icon
 * @property integer $rank
 * @property integer $orderby
 * @property integer $status
 * @property integer $adtime
 */
class DbAdminMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'rank', 'orderby', 'status', 'adtime'], 'integer'],
            [['title', 'icon'], 'string', 'max' => 40],
            [['url'], 'string', 'max' => 60],
            [['module', 'controller', 'action'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键ID'),
            'pid' => Yii::t('app', '父级'),
            'title' => Yii::t('app', '菜单名称'),
            'url' => Yii::t('app', '菜单URL'),
            'module' => Yii::t('app', '模块'),
            'controller' => Yii::t('app', '控制器'),
            'action' => Yii::t('app', '动作'),
            'icon' => Yii::t('app', '菜单图标'),
            'rank' => Yii::t('app', '菜单等级'),
            'orderby' => Yii::t('app', '菜单排序'),
            'status' => Yii::t('app', '1=显示 0=不显示'),
            'adtime' => Yii::t('app', '添加时间'),
        ];
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 13:55:21
     * Description: 保存前数据处理
     * @param bool $model
     * @return bool
     */
    function beforeSave($model)
    {
        $act = explode('/',$this->url);
        $this->module = isset($act['1'])?$act['1']:'#';
        $this->controller = isset($act['2'])?$act['2']:'#';
        $this->action = isset($act['3'])?$act['3']:'#';
        $this->adtime = time();
        if($this->pid){
            $this->rank = 1;
        }
        return true;
    }
}
