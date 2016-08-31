<?php

namespace app\modules\airline\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Schedule;

/**
 * ScheduleSearch represents the model behind the search form about `app\models\Schedule`.
 */
class ScheduleSearch extends Schedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['flight', 'dep', 'arr', 'aircraft', 'dep_utc_time', 'arr_utc_time', 'dep_lmt_time', 'arr_lmt_time', 'eet', 'day_of_weeks', 'start', 'stop', 'added'], 'safe'],
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
        $query = Schedule::find();

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
            'dep_utc_time' => $this->dep_utc_time,
            'arr_utc_time' => $this->arr_utc_time,
            'dep_lmt_time' => $this->dep_lmt_time,
            'arr_lmt_time' => $this->arr_lmt_time,
            'eet' => $this->eet,
            'start' => $this->start,
            'stop' => $this->stop,
            'added' => $this->added,
        ]);

        $query->andFilterWhere(['like', 'flight', $this->flight])
            ->andFilterWhere(['like', 'dep', $this->dep])
            ->andFilterWhere(['like', 'arr', $this->arr])
            ->andFilterWhere(['like', 'aircraft', $this->aircraft])
            ->andFilterWhere(['like', 'day_of_weeks', $this->day_of_weeks]);

        return $dataProvider;
    }
}
