<?php

namespace app\models;

use yii\helpers\Url;

/**
 * This is the model class for table "Company".
 *
 * @property string $company_id
 * @property string $company_name
 *
 * @property OperationCompany[] $operationCompanies
 */
class Company extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Company';
    }

    public static function info()
    {

        $parent = parent::info();

        return array_merge([
            'controller_id' => 'companies',
            'create_url' => Url::toRoute('companies/create'),
            'index_url' => Url::toRoute('companies/')
        ], $parent);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name'], 'required'],
            [['company_name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'company_name' => 'Company Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharteringCompanies()
    {
        return $this->hasMany(CharteringCompany::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartering()
    {
        return Chartering::find()->where('exists (select * from CharteringCompany where company_id=:company_id and chartering_id=Chartering.chartering_id)', [':company_id' => $this->company_id]);
    }


}
