<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "db_dolog".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property string $title
 * @property string $action
 * @property string $doing
 * @property string $ip
 * @property integer $time
 */
class Dolog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_dolog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'time'], 'integer'],
            [['username', 'action'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 80],
            [['doing'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'title' => 'Title',
            'action' => 'Action',
            'doing' => 'Doing',
            'ip' => 'Ip',
            'time' => 'Time',
        ];
    }
}
