<?php

namespace app\models;

/**
 * This is the model class for table "CharteringStatuses".
 *
 * @property string $chartering_status_id
 * @property string $chartering_id
 * @property string $status_id
 * @property string $datetime
 *
 * @property Status $status
 * @property Chartering $chartering
 */
class CharteringStatuses extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CharteringStatuses';
    }

    public static function format($records, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($records)) {
            foreach ($records as $record) {
                $result[] = self::format($record, $includes, $api_endpoint);
            }

            return $result;

        } else {

            $res = self::formatData($records, self::className(), false, $api_endpoint);

            if (isset($includes["status"]) && $includes["status"] == true) {
                $res['status'] = Status::format($records->status, [], $api_endpoint);
            }

            return $res;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chartering_id', 'status_id'], 'required'],
            [['chartering_id', 'status_id'], 'integer'],
            [['datetime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chartering_status_id' => 'Chartering Status ID',
            'chartering_id' => 'Chartering ID',
            'status_id' => 'Status ID',
            'datetime' => 'Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['status_id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartering()
    {
        return $this->hasOne(Chartering::className(), ['chartering_id' => 'chartering_id']);
    }
}
