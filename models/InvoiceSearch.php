<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InvoiceSearch represents the model behind the search form about `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'chartering_id', 'vessel_id'], 'integer'],
            [['invoice_number', 'fixture_ref', 'reference', 'cp_date', 'freight', 'status', 'due_date', 'start_period', 'end_period'], 'safe'],
            [['commission_percentage', 'VAT', 'total'], 'number'],
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
        $query = Invoice::find();

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
            'invoice_id' => $this->invoice_id,
            'chartering_id' => $this->chartering_id,
            'vessel_id' => $this->vessel_id,
            'cp_date' => $this->cp_date,
            'commission_percentage' => $this->commission_percentage,
            'VAT' => $this->VAT,
            'total' => $this->total,
            'due_date' => $this->due_date,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
        ]);

        $query->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'fixture_ref', $this->fixture_ref])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'freight', $this->freight])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
