<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $cl_id
 * @property string $cl_hexid
 * @property string $cl_name
 * @property int $cl_age
 * @property int $cl_city
 * @property string $cl_membership_date
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cl_hexid', 'cl_name', 'cl_age', 'cl_city'], 'required'],
            [['cl_age', 'cl_city'], 'integer'],
            [['cl_membership_date'], 'safe'],
            [['cl_hexid'], 'string', 'max' => 32],
            [['cl_name'], 'string', 'max' => 128],
        ];
    }

    public function getPhone()
    {
        return $this->hasMany(Phone::className(), ['p_clientId'=>'cl_id']);
    }	
	
    public function getCity()
    {
        return $this->hasOne(City::className(), ['c_id'=>'cl_city']);
    }		
	
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cl_id'    => 'Cl ID',
            'cl_hexid' => 'Cl Hexid',
            'cl_name'  => 'Cl Name',
            'cl_age'   => 'Cl Age',
            'cl_city'  => 'Cl City',
            'cl_membership_date' => 'Cl Membership Date',
        ];
    }
}
