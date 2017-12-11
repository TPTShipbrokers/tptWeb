<?php

namespace app\models;

use yii\helpers\Url as Url;

/**
 * This is the model class for table "CharterParty".
 *
 * @property string $charter_party_id
 * @property string $datetime
 * @property string $description
 *
 * @property Chartering[] $charterings
 */
class CharterParty extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CharterParty';
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/charter_party/', true);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime'], 'required'],
            [['datetime'], 'safe'],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'charter_party_id' => 'Charter Party ID',
            'datetime' => 'Datetime',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharterings()
    {
        return $this->hasMany(Chartering::className(), ['charter_party' => 'charter_party_id']);
    }
}
