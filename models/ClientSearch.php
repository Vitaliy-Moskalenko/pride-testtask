<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Client;

/**
 * CustomerRecordSearch represents the model behind the search form about `app\models\customer\CustomerRecord`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['cl_hexid', 'cl_name'], 'string'],
            [['cl_age', 'cl_city'], 'integer'],
            [['cl_hexid', 'cl_name', 'cl_age', 'cl_city', 'cl_membership_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {   
        $query = Client::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('phone');
		
        $query->joinWith('city');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

     	  $query->andFilterWhere([
            'client.cl_id'    => $this->cl_id,
            'client.cl_hexid' => $this->cl_hexid,
            'client.cl_name'  => $this->cl_name,
            'client.cl_age'   => $this->cl_age,
            'client.cl_city'  => $this->cl_city,
        ]);

        return $dataProvider;
    }
}
