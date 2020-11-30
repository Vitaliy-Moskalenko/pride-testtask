<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phone".
 *
 * @property int $p_id
 * @property int $p_clientId
 * @property string $p_number
 */
class Phone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['p_clientId', 'p_number'], 'required'],
            [['p_clientId'], 'integer'],
            [['p_number'], 'string', 'max' => 32],
			[['p_clientId', 'p_number'], 'safe'],
        ];
    }
	
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['p_clientId'=>'cl_id']);
    }	

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'p_id'       => 'P ID',
            'p_clientId' => 'P Client ID',
            'p_number'   => 'P Number',
        ];
    }
}
