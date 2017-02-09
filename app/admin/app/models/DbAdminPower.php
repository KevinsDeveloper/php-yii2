<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_power}}".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $menu_id
 * @property integer $type
 * @property string $name
 * @property string $url
 */
class DbAdminPower extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_power}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'menu_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增ID'),
            'role_id' => Yii::t('app', '管理员ID'),
            'menu_id' => Yii::t('app', '菜单ID'),
            'type' => Yii::t('app', '0=菜单 1=动作'),
            'name' => Yii::t('app', '权限名字'),
            'url' => Yii::t('app', '权限URL'),
        ];
    }
}
