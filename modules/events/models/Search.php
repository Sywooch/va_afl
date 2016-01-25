<?php

namespace app\modules\events\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\models\Events;

/**
 * Search represents the model behind the search form about `app\models\Events`.
 */
class Search extends Events
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content', 'author'], 'integer'],
            [['start', 'stop', 'created'], 'safe'],
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
        $query = Events::find();

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
            'content' => $this->content,
            'start' => $this->start,
            'stop' => $this->stop,
            'author' => $this->author,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
