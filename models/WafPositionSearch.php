<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WafPositionSearch represents the model behind the search form about `app\models\WafPosition`.
 */
class WafPositionSearch extends WafPosition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vessel_id', 'cbm', 'dwt', 'loa', 'imo', 'intake', 'positions_visible'], 'integer'],
            [['name', 'size', 'grade', 'built', 'status', 'open_date', 'location', 'last', 'hull', 'sire',
                'tema_suitable', 'cabotage', 'nigerian_cab', 'comments', 'last_update'], 'safe'],
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
        $query = WafPosition::find();

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
            'vessel_id' => $this->vessel_id,
            'built' => $this->built,
            'open_date' => $this->open_date,
            'cbm' => $this->cbm,
            'dwt' => $this->dwt,
            'loa' => $this->loa,
            'imo' => $this->imo,
            'intake' => $this->intake,
            'last_update' => $this->last_update,
            'positions_visible' => $this->positions_visible,
        ]);

        //    die(var_dump($params));

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'last', $this->last])
            ->andFilterWhere(['like', 'hull', $this->hull])
            ->andFilterWhere(['like', 'sire', $this->sire])
            ->andFilterWhere(['like', 'tema_suitable', $this->tema_suitable])
            ->andFilterWhere(['like', 'cabotage', $this->cabotage])
            ->andFilterWhere(['like', 'nigerian_cab', $this->nigerian_cab])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
