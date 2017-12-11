<?php

namespace app\models;

/**
 * This is the model class for table "CharteringClient".
 *
 * @property string $chartering_client_id
 * @property string $client_id
 * @property string $chartering_id
 * @property string $status
 * @property string $scheduled_date
 *
 * @property Chartering $chartering
 * @property User $client
 */
class CharteringClient extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CharteringClient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'chartering_id'], 'required'],
            [['client_id', 'chartering_id'], 'integer'],
            [['status'], 'string'],
            [['scheduled_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chartering_client_id' => 'Chartering Client ID',
            'client_id' => 'Client ID',
            'chartering_id' => 'Chartering ID',
            'status' => 'Status',
            'scheduled_date' => 'Scheduled Date',
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
    public function getClient()
    {
        return $this->hasOne(AppUser::className(), ['user_id' => 'client_id']);
    }
}
