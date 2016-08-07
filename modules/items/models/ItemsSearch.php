<?php

namespace app\modules\items\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Items\Items;

/**
 * ItemsSearch represents the model behind the search form about `app\models\Items\Items`.
 */
class ItemsSearch extends Items
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'user_id', 'available', 'cost', 'temporary'], 'integer'],
            [['temporary_stop', 'created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Items::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'available' => $this->available,
            'cost' => $this->cost,
            'temporary' => $this->temporary,
            'temporary_stop' => $this->temporary_stop,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
