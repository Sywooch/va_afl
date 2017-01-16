<?php

namespace app\modules\airline\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fleet;

/**
 * FleetSearch represents the model behind the search form about `app\models\Fleet`.
 */
class FleetSearch extends Fleet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'user_id', 'squadron_id', 'max_pax', 'max_hrs', 'profile'], 'integer'],
            [['regnum', 'type_code', 'full_type', 'home_airport', 'location', 'image_path', 'selcal'], 'safe'],
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
     * @param null $query
     * @return ActiveDataProvider
     */
    public function search($params, $query = null)
    {
        if($query == null){
            $query = Fleet::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'squadron_id' => $this->squadron_id,
            'max_pax' => $this->max_pax,
            'max_hrs' => $this->max_hrs,
            'profile' => $this->profile,
        ]);

        $query->andFilterWhere(['like', 'regnum', $this->regnum])
            ->andFilterWhere(['like', 'type_code', $this->type_code])
            ->andFilterWhere(['like', 'full_type', $this->full_type])
            ->andFilterWhere(['like', 'home_airport', $this->home_airport])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'selcal', $this->selcal]);

        return $dataProvider;
    }
}
