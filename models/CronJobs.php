<?php

namespace app\models;

/**
 * This is the model class for table "CronJobs".
 *
 * @property string $cron_id
 * @property string $executed_at
 * @property integer $succeeded
 * @property string $action
 * @property string $parameters
 * @property integer $execution_result
 * @property string $users
 * @property string $chartering_id
 * @property string $datetime
 *
 * @property Chartering $chartering
 */
class CronJobs extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CronJobs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['executed_at', 'datetime'], 'safe'],
            [['succeeded', 'execution_result', 'chartering_id'], 'integer'],
            [['action'], 'required'],
            [['action', 'parameters', 'users'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cron_id' => 'Cron ID',
            'executed_at' => 'Executed At',
            'succeeded' => 'Succeeded',
            'action' => 'Action',
            'parameters' => 'Parameters',
            'execution_result' => 'Execution Result',
            'users' => 'Users',
            'chartering_id' => 'Chartering ID',
            'datetime' => 'Datetime',
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
