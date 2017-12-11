<?php

namespace app\models;

use yii\helpers\Url as Url;

/**
 * This is the model class for table "OperationState".
 *
 * @property string $operation_state_id
 * @property string $description
 * @property string $operation_id
 * @property string $state_id
 * @property string $time
 *
 * @property Operation $operation
 * @property State $state
 */
class OperationState extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OperationState';
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/operation_state/', true);
    }

    public static function format($operation_states, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($operation_states)) {

            foreach ($operation_states as $operation_state) {

                if (isset($includes['api']) && $includes['api']) {
                    $date = date('m-d-Y', strtotime($operation_state->time));

                    if (!$result[$date]) {
                        $result[$date] = [self::format($operation_state, $includes, false)];
                    } else {
                        $result[$date][] = self::format($operation_state, $includes, false);
                    }
                } else {
                    $result[] = self::format($operation_state, $includes, false);
                }


            }

            return $result;

        } else {

            $res = self::formatData($operation_states, self::className(), false, false);

            return $res;
        }
    }

    public static function formatData($data, $model, $arr = false, $api_endpoint = true)
    {

        // if data is array of entities - process those one by one
        if (is_array($data)) {

            $result = [];
            foreach ($data as $resource) {
                $result[] = self::formatData($resource, $model);
            }

            return $result;
        } else {


            if ($data) {

                $desc = $data->description;
                $status_desc = $data->getState()->one()->description;
                $prefix = $data->desc_prefix_sufix != null && $data->desc_prefix_sufix == 1;

                $res['description'] = $prefix ? $desc . ' ' . $status_desc : $status_desc . ' ' . $desc;
                $res['time'] = $data->time;

                $pk = (new $model)->tableSchema->primaryKey[0];


                $data = $res;
            }


        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_id', 'state_id'], 'required'],
            [['description'], 'string'],
            [['operation_id', 'state_id', 'desc_prefix_sufix'], 'integer'],
            [['time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'operation_state_id' => 'Operation State ID',
            'description' => 'Description',
            'operation_id' => 'Operation ID',
            'state_id' => 'State ID',
            'time' => 'Time',
            'desc_prefix_sufix' => 'Description prefix/sufix'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['state_id' => 'state_id']);
    }
}
