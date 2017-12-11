<?php

namespace app\models;

/**
 * This is the model class for table "InvoiceDocumentations".
 *
 * @property string $claim_documentation_id
 * @property string $file
 * @property string $filename
 * @property int $claim_id
 *
 * @property Invoice $invoice
 */
class ClaimDocumentations extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ClaimDocumentations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file', 'claim_id'], 'required'],
            [['file', 'filename'], 'string'],
            [['claim_id', 'claim_documentation_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'claim_documentation_id' => 'Claim Documentation ID',
            'file' => 'File',
            'filename' => 'Filename',
            'claim_id' => 'claim ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaim()
    {
        return $this->hasOne(Invoice::className(), ['claim_id' => 'claim_id']);
    }
}
