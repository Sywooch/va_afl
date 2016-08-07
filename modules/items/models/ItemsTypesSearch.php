<?php

namespace app\modules\items\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Items\ItemsTypes;

/**
 * ItemsTypesSearch represents the model behind the search form about `app\models\Items\ItemsTypes`.
 */
class ItemsTypesSearch extends ItemsTypes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'type', 'content_id'], 'integer'],
            [['created'], 'safe'],
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
        $query = ItemsTypes::find();

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
            'type_id' => $this->type_id,
            'type' => $this->type,
            'content_id' => $this->content_id,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
