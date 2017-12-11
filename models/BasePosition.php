<?php

namespace app\models;

/**
 * Class BasePosition
 * @package app\models
 */
abstract class BasePosition extends DefaultModel
{
    const SIZE_MR = 'mr';
    const SIZE_HANDY = 'handy';
    const SIZE_LR = 'lr';

    const CONDITION_CLEAN = 'clean';
    const CONDITION_DIRTY = 'dirty';

    /**
     * @param $records
     * @param array $includes
     * @param bool $api_endpoint
     * @return array
     */
    public static function format($records, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($records)) {
            foreach ($records as $record) {
                $result[] = self::format($record, $includes);
            }

            return $result;

        } else {

            $res = self::formatData($records, self::className(), false, $api_endpoint);

            if (isset($includes['broker']) && $includes['broker'] == true) {
                if (!$records->broker_id)
                    $res['broker'] = null;
                else
                    $res['broker'] = AppUser::format($records->broker, [], true);
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
            [['name', 'size', 'grade', 'built', 'status', 'open_date', 'sire', 'tema_suitable'], 'required'],
            [['size', 'grade', 'status', 'location', 'last', 'hull', 'sire', 'tema_suitable', 'cabotage', 'nigerian_cab', 'comments'], 'string'],
            [['size'], 'in', 'range' => [self::SIZE_HANDY, self::SIZE_LR, self::SIZE_MR]],
            [['grade'], 'in', 'range' => [self::CONDITION_CLEAN, self::CONDITION_DIRTY]],
            [['built', 'open_date', 'last_update'], 'safe'],
            [['cbm', 'dwt', 'imo', 'intake', 'broker_id', 'positions_visible'], 'integer'],
            [['loa'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vessel_id' => 'Vessel ID',
            'name' => 'Name',
            'size' => 'Size',
            'grade' => 'Grade',
            'built' => 'Built',
            'status' => 'Status',
            'open_date' => 'Open Date',
            'location' => 'Location',
            'cbm' => 'Cbm',
            'dwt' => 'Dwt',
            'loa' => 'Loa',
            'last' => 'Last',
            'imo' => 'Imo',
            'hull' => 'Hull',
            'sire' => 'Sire',
            'intake' => 'Intake',
            'tema_suitable' => 'Tema Suitable',
            'nigerian_cab' => 'Nigerian Cab',
            'comments' => 'Comments',
            'last_update' => 'Last Update',
            'broker_id' => 'Broker ID',
            'positions_visible' => 'Positions Visible',
            'cabotage' => 'Cabotage',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBroker()
    {
        return $this->hasOne(AppUser::className(), ['user_id' => 'broker_id']);
    }
}