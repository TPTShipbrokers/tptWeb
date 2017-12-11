<?php

namespace app\models;

/**
 * This is the model class for table "Invoice".
 *
 * @property string $invoice_id
 * @property string $chartering_id
 * @property string $invoice_number
 * @property string $vessel_id
 * @property string $fixture_ref
 * @property string $reference
 * @property string $cp_date
 * @property string $freight
 * @property double $commission_percentage
 * @property double $VAT
 * @property double $total
 * @property string $status
 * @property string $due_date
 * @property string $start_period
 * @property string $end_period
 * @property string $filename
 *
 * @property Chartering $chartering
 * @property Vessel $vessel
 */
class Invoice extends DefaultModel
{
    public $invoice_documentations;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chartering_id', 'invoice_number', 'total', 'due_date', 'start_period', 'end_period'], 'required'],
            [['chartering_id', 'vessel_id'], 'integer'],
            [['cp_date', 'due_date', 'start_period', 'end_period'], 'safe'],
            [['freight', 'status', 'file'], 'string'],
            [['commission_percentage', 'VAT', 'total'], 'number'],
            [['invoice_number', 'fixture_ref', 'reference', 'filename'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'chartering_id' => 'Chartering ID',
            'invoice_number' => 'Invoice Number',
            'vessel_id' => 'Vessel ID',
            'fixture_ref' => 'Fixture Ref',
            'reference' => 'Reference',
            'cp_date' => 'Cp Date',
            'freight' => 'Freight',
            'commission_percentage' => 'Commission Percentage',
            'VAT' => 'Vat',
            'total' => 'Total',
            'status' => 'Status',
            'due_date' => 'Due Date',
            'start_period' => 'Start Period',
            'end_period' => 'End Period',
            'filename' => 'Invoice File Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartering()
    {
        return $this->hasOne(Chartering::className(), ['chartering_id' => 'chartering_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVessel()
    {
        return $this->hasOne(Vessel::className(), ['vessel_id' => 'vessel_id']);
    }

    public function getInvoiceDocumentations()
    {
        return $this->hasMany(InvoiceDocumentations::className(), ['invoice_id' => 'invoice_id']);
    }
}
