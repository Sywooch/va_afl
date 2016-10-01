<?php

namespace app\models\Top;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Top\Top;

/**
 * TopSearch represents the model behind the search form about `app\models\Top\Top`.
 */
class TopSearch extends Top
{

    public static function all()
    {
        return self::findOne(['mouth' => 0, 'year' => 0]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'user_id',
                    'mouth',
                    'year',
                    'exp_count',
                    'exp_pos',
                    'flights_count',
                    'flights_pos',
                    'hours_count',
                    'hours_pos',
                    'pax_count',
                    'pax_pos'
                ],
                'integer'
            ],
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
    public function search($params, $query = null)
    {
        if($query == null){
            $query = Top::find();
        }

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
            'user_id' => $this->user_id,
            'mouth' => $this->mouth,
            'year' => $this->year,
            'exp_count' => $this->exp_count,
            'exp_pos' => $this->exp_pos,
            'flights_count' => $this->flights_count,
            'flights_pos' => $this->flights_pos,
            'hours_count' => $this->hours_count,
            'hours_pos' => $this->hours_pos,
            'pax_count' => $this->pax_count,
            'pax_pos' => $this->pax_pos,
        ]);

        return $dataProvider;
    }
}
