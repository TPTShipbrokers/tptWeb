<?php

namespace app\models;

/**
 * This is the model class for table "CharteringCompany".
 *
 * @property string $chartering_company_id
 * @property string $chartering_id
 * @property string $company_id
 *
 * @property Chartering $chartering
 * @property Company $company
 */
class CharteringCompany extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CharteringCompany';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chartering_id', 'company_id'], 'required'],
            [['chartering_id', 'company_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chartering_company_id' => 'Chartering Company ID',
            'chartering_id' => 'Chartering ID',
            'company_id' => 'Company ID',
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_id']);
    }
}
