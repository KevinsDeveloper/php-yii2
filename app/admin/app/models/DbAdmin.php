<?php

namespace admin\models;

use Yii;
use yii\web\IdentityInterface;

class DbAdmin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @param  array $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
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
            [['password_hash', 'access_token'], 'string', 'max' => 256],
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
            'id'                   => Yii::t('app', '管理员ID'),
            'group_id'             => Yii::t('app', '角色ID'),
            'account'              => Yii::t('app', '登陆账号'),
            'phone'                => Yii::t('app', '电话'),
            'email'                => Yii::t('app', '邮箱'),
            'nickname'             => Yii::t('app', '昵称'),
            'password_hash'        => Yii::t('app', '登陆密码验证'),
            'access_token'         => Yii::t('app', '登陆标识'),
            'passwd'               => Yii::t('app', '登录密码'),
            'jobs'                 => Yii::t('app', '职位'),
            'status'               => Yii::t('app', '状态'), //1=为可用，0=不可用
            'token'                => Yii::t('app', '单点登录Key'),
            'adtime'               => Yii::t('app', '添加时间'),
            'uptime'               => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->pwd = md5($password);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByAccount($account)
    {
        return static::findOne(['account' => $account]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->pwd === md5($this->password_hash . $password . SAFE_KEY);
    }

}
