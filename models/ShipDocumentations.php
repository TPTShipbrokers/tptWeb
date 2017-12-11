<?php

namespace app\models;

/**
 * This is the model class for table "ShipDocumentations".
 *
 * @property string $ship_documentation_id
 * @property string $file
 * @property string $chartering_id
 * @property string $filename
 *
 * @property Chartering $chartering
 */
class ShipDocumentations extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ShipDocumentations';
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
            'ship_documentation_id' => 'Ship Documentation ID',
            'file' => 'File',
            'filename' => 'Filename',
            'chartering_id' => 'Chartering ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartering()
    {
        return $this->hasOne(Chartering::className(), ['chartering_id' => 'chartering_id']);
    }
}
