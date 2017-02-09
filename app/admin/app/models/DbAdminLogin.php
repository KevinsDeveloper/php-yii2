<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_login}}".
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $account
 * @property string $nickname
 * @property string $login_info
 * @property string $login_ip
 * @property integer $login_time
 * @property integer $login_out
 */
class DbAdminLogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id'], 'required'],
            [['admin_id', 'login_time', 'login_out'], 'integer'],
            [['account'], 'string', 'max' => 40],
            [['nickname'], 'string', 'max' => 60],
            [['login_info'], 'string'],
            [['login_ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键ID'),
            'admin_id' => Yii::t('app', '管理员ID'),
            'account' => Yii::t('app', '登录账号'),
            'nickname' => Yii::t('app', '昵称'),
            'login_info' => Yii::t('app', '登录信息'),
            'login_ip' => Yii::t('app', '登陆ip'),
            'login_time' => Yii::t('app', '登陆时间'),
            'login_out' => Yii::t('app', '退出时间'),
        ];
    }
}
