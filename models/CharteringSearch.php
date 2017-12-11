<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CharteringSearch represents the model behind the search form about `app\models\Chartering`.
 */
class CharteringSearch extends Chartering
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chartering_id', 'vessel_id', 'charter_party', 'status_id'], 'integer'],
            [['subs_due', 'ship_documentation', 'stowage_plan', 'state'], 'safe'],
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
        $query = Chartering::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $charteringStatus = CharteringStatuses::find()->where(['status_id' => $this->status_id])->select('chartering_status_id')->all();
        $status = $charteringStatus ? array_map(function ($el) {
            return $el->chartering_status_id;
        }, $charteringStatus) : $this->status_id;

        if ($this->state == '')
            $this->state = 'live';
        elseif ($this->state == 'all')
            $this->state = '';

        $query->andFilterWhere([
            'chartering_id' => $this->chartering_id,
            'vessel_id' => $this->vessel_id,
            'subs_due' => $this->subs_due,
            'charter_party' => $this->charter_party,
            'status_id' => $status,
            'state' => $this->state,
        ]);

        $query->andFilterWhere(['like', 'ship_documentation', $this->ship_documentation])
            ->andFilterWhere(['like', 'stowage_plan', $this->stowage_plan]);

        return $dataProvider;
    }
}
