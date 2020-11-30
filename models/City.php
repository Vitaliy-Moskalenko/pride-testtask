<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $c_id
 * @property string $c_name
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_name'], 'required'],
            [['c_name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'c_id'   => 'Id',
            'c_name' => 'Name',
        ];
    }
}
