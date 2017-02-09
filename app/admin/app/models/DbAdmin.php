<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $account
 * @property string $phone
 * @property string $email
 * @property string $nickname
 * @property string $codes
 * @property string $passwd
 * @property string $jobs
 * @property integer $status
 * @property string $token
 * @property integer $adtime
 * @property integer $uptime
 */
class DbAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'account', 'passwd'], 'required'],
            [['group_id', 'status', 'adtime', 'uptime'], 'integer'],
            [['account'], 'string', 'max' => 36],
            [['phone'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 20],
            [['nickname'], 'string', 'max' => 30],
            [['codes'], 'string', 'max' => 32],
            [['passwd'], 'string', 'max' => 33],
            [['jobs'], 'string', 'max' => 10],
            [['token'], 'string', 'max' => 64],
            [['account'], 'unique'],
            [['codes'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '管理员ID'),
            'group_id' => Yii::t('app', '角色ID'),
            'account' => Yii::t('app', '登陆账号'),
            'phone' => Yii::t('app', '电话'),
            'email' => Yii::t('app', '邮箱'),
            'nickname' => Yii::t('app', '昵称'),
            'codes' => Yii::t('app', '登陆密码验证'),
            'passwd' => Yii::t('app', '登录密码'),
            'jobs' => Yii::t('app', '职位'),
            'status' => Yii::t('app', '状态'),    //1=为可用，0=不可用
            'token' => Yii::t('app', '单点登录Key'),
            'adtime' => Yii::t('app', '添加时间'),
            'uptime' => Yii::t('app', '更新时间'),
        ];
    }

    public function getRole()
    {
        return $this->hasOne(DbAdminRole::className(), ['id' => 'group_id']);
    }
}
