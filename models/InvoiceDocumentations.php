<?php

namespace app\models;

/**
 * This is the model class for table "InvoiceDocumentations".
 *
 * @property string $invoice_documentation_id
 * @property string $file
 * @property string $filename
 * @property int $invoice_id
 * @property int $chartering_id
 *
 * @property Invoice $invoice
 */
class InvoiceDocumentations extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InvoiceDocumentations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file', 'chartering_id'], 'required'],
            [['file', 'filename'], 'string'],
            [['chartering_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_documentation_id' => 'Invoice Documentation ID',
            'file' => 'File',
            'filename' => 'Filename',
            'invoice_id' => 'Invoice ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }
}
