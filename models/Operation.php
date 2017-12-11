<?php

namespace app\models;

use Yii;
use yii\helpers\Url as Url;

/**
 * This is the model class for table "Operation".
 *
 * @property string $operation_id
 * @property string $reference_id
 * @property string $status_id
 * @property string $location_id
 * @property string $discharging_ship_id
 * @property string $receiving_ship_id
 * @property string $start_time
 * @property string $end_time
 * @property string $invoice_id
 * @property string $user_id
 * @property string $report
 *
 * @property Ship $dischargingShip
 * @property Invoice $invoice
 * @property Location $location
 * @property Ship $receivingShip
 * @property State $status
 * @property User $user
 * @property OperationState[] $operationStates
 */
class Operation extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Operation';
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/operation/', true);
    }

    public static function formatShort($operations)
    {

        $result = [];

        if (is_array($operations)) {
            foreach ($operations as $operation) {
                $result[] = self::formatShort($operation);
            }

            return $result;

        } else {

            $res = self::formatData($operations, self::className());
            $res['discharging_ship'] = Ship::findOne($res['discharging_ship_id'])->name;
            $res['receiving_ship'] = Ship::findOne($res['discharging_ship_id'])->name;

            $res['status'] = OperationState::format($operations->getOperationState(), [], true);
            $res['location'] = Location::findOne($res['location_id'])->title;
            $res['report'] = PostOperationReport::findOne($res['report_id'])->file;


            return $res;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference_id', 'location_id', 'discharging_ship_id', 'receiving_ship_id', 'user_id'], 'required'],
            [['status_id', 'location_id', 'discharging_ship_id', 'receiving_ship_id', 'invoice_id', 'user_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['reference_id'], 'string', 'max' => 255],
            [['reference_id'], 'unique'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'operation_id' => 'Operation ID',
            'reference_id' => 'Reference ID',
            'status_id' => 'Status ID',
            'location_id' => 'Location ID',
            'discharging_ship_id' => 'Discharging Ship ID',
            'receiving_ship_id' => 'Receiving Ship ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'invoice_id' => 'Invoice ID',
            'user_id' => 'User ID',
            'report' => 'Report',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDischargingShip()
    {
        return $this->hasOne(Ship::className(), ['ship_id' => 'discharging_ship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['location_id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivingShip()
    {
        return $this->hasOne(Ship::className(), ['ship_id' => 'receiving_ship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(State::className(), ['state_id' => 'status_id']);
    }

    public function getOperationState()
    {
        $state = $this->getOperationStates()->where(['state_id' => $this->status_id])->one();
        return $state; //?OperationState::format($state, [], true):null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationStates()
    {
        return $this->hasMany(OperationState::className(), ['operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AppUser::className(), ['user_id' => 'user_id']);
    }

    public function getReport()
    {
        return $this->hasOne(PostOperationReport::className(), ['report_id' => 'report_id']);
    }

    public function viewRecord($user_id = null, $return = false)
    {

        $includes = ['statuses' => true];

        if ($this->invoice_id != null) {
            $includes['invoice'] = true;
        }

        $data = self::format($this, $includes);

        return Yii::$app->api->_sendResponse(200, $data, true, $return);

    }

    public static function format($operations, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($operations)) {
            foreach ($operations as $operation) {
                $result[] = self::format($operation, $includes);
            }

            return $result;

        } else {


            $res = self::formatData($operations, self::className());
            $res['discharging_ship'] = Ship::format(Ship::findOne($res['discharging_ship_id']));
            $res['receiving_ship'] = Ship::format(Ship::findOne($res['receiving_ship_id']));

            $res['status'] = OperationState::format($operations->getOperationState(), [], true);
            $res['location'] = Location::format(Location::findOne($res['location_id']));


            if (isset($includes['statuses']) && $includes['statuses']) {

                $res['statuses'] = OperationState::format($operations->getOperationStates()->all(), ['api' => isset($includes['api']) && $includes['api']], false);
            }

            if (isset($includes['invoice']) && $includes['invoice'] && $operations->invoice_id != null) {
                $res['invoice'] = Invoice::format($operations->getInvoice()->one(), [], false);
            }

            if (isset($includes['report']) && $includes['report'] && $operations->report_id != null) {
                $res['report'] = PostOperationReport::format($operations->getReport()->one(), [], false);
            }

            if (isset($includes['user']) && $includes['user']) {
                $res['user'] = AppUser::format($operations->getUser()->one(), []);
            }


            return $res;
        }
    }
}
