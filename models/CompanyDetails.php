<?php

namespace app\models;

/**
 * This is the model class for table "CompanyDetails".
 *
 * @property string $company_details_id
 * @property string $meta_key
 * @property string $meta_label
 * @property string $meta_value
 * @property string $meta_type
 */
class CompanyDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CompanyDetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta_key', 'meta_label', 'meta_value', 'meta_type'], 'required'],
            [['meta_label', 'meta_value', 'meta_type'], 'string'],
            [['meta_key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_details_id' => 'Company Details ID',
            'meta_key' => 'Meta Key',
            'meta_label' => 'Meta Label',
            'meta_value' => 'Meta Value',
            'meta_type' => 'Meta Type',
        ];
    }
}
