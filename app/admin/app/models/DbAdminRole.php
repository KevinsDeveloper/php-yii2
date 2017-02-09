<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_role}}".
 *
 * @property integer $id
 * @property string $role_name
 * @property integer $type
 * @property integer $status
 * @property integer $adtime
 */
class DbAdminRole extends \yii\db\ActiveRecord
{
    public $parentid;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'adtime'], 'integer'],
            [['role_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '自增ID'),
            'role_name' => Yii::t('app', '角色组名称'),
            'type' => Yii::t('app', '0=其它 1=超级管理员 2=普通管理员'),
            'status' => Yii::t('app', '1=可用 0=不可用'),
            'adtime' => Yii::t('app', '添加时间'),
        ];
    }

    public function getPower()
    {
        return $this->hasOne(DbAdminPower::className(), ['role_id' => 'id']);
    }
}
