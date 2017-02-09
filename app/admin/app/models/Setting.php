<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "db_setting".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $key
 * @property string $value
 * @property integer $input_type
 * @property string $remark
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'input_type'], 'integer'],
            [['key'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['key'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 200],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'key' => 'Key',
            'value' => 'Value',
            'input_type' => 'Input Type',
            'remark' => 'Remark',
        ];
    }
}
