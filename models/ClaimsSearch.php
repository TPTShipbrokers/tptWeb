<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClaimsSearch represents the model behind the search form about `app\models\Claims`.
 */
class ClaimsSearch extends Claims
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['claim_id', 'chartering_id'], 'integer'],
            [['owners_claim', 'charterers_claim'], 'number'],
            [['owners_claim_reason', 'charterers_claim_reason', 'comments', 'status'], 'safe'],
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
        $query = Claims::find();

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
            'claim_id' => $this->claim_id,
            'owners_claim' => $this->owners_claim,
            'charterers_claim' => $this->charterers_claim,
            'chartering_id' => $this->chartering_id,
        ]);

        $query->andFilterWhere(['like', 'owners_claim_reason', $this->owners_claim_reason])
            ->andFilterWhere(['like', 'charterers_claim_reason', $this->charterers_claim_reason])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
