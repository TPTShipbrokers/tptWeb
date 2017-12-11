<?php

namespace app\models;

use yii\helpers\Url as Url;


/**
 * This is the model class for table "Chartering".
 *
 * @property string $chartering_id
 * @property string $vessel_name
 * @property string $subs_due
 * @property string $ship_documentation
 * @property string $invoice_documentations
 * @property string $stowage_plan
 * @property string $charter_party
 * @property string $sof_comments
 * @property int $broker_id
 *
 * @property CharterParty $charterParty
 * @property ShipDocumentations[] $shipDocumentations
 * @property InvoiceDocumentations[] $invoiceDocumentations
 * @property CharteringClient[] $charteringClients
 * @property CharteringStatuses[] $charteringStatuses
 * @property CharteringStatuses $status
 */
class Chartering extends DefaultModel
{
    public $ship_documentations;
    public $invoice_documentations;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Chartering';
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/chartering/', true);
    }

    /**
     * @param Chartering $records
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

            if (isset($includes["vessel"]) && $includes["vessel"] == true) {
                $res['vessel'] = $records->vessel == null ? null : Vessel::format($records->vessel, [], true);
            }

            if (isset($includes["statuses"]) && $includes["statuses"] == true) {
                $res['statuses'] = CharteringStatuses::format($records->getCharteringStatuses()->orderby('datetime desc')->all(), ['status' => true], false);
            }

            if (isset($includes["status"]) && $includes["status"] == true) {
                $res['status'] = $records->status ? CharteringStatuses::format($records->status, ['status' => true], false) : null;
            }

            if (isset($includes["charter_party"]) && $includes["charter_party"] == true) {
                $res['charter_party'] = $records->charterParty ? CharterParty::format($records->charterParty, [], true) : null;
            }

            if (isset($includes["charter_party_date"]) && $includes["charter_party_date"] == true) {
                $res['charter_party'] = $records->charterParty ? $records->charterParty->datetime : null;
            }

            if (isset($includes["invoices"]) && $includes["invoices"] == true) {
                $res['invoices'] = Invoice::format($records->invoices, [], false);
            }

            if (isset($includes["claims"]) && $includes["claims"] == true) {
                $res['claims'] = Claims::format($records->claims, ['claim_documentations' => true], false);
            }

            if (isset($includes["title"]) && $includes["title"] == true) {
                $res['title'] = $records->vessel == null ? "" : $records->vessel_name;
            }

            if (isset($includes["ship_documentations"]) && $includes["ship_documentations"] == true) {
                $res['ship_documentations'] = ShipDocumentations::format($records->shipDocumentations, [], false);
            }

            if (isset($includes["invoice_documentations"]) && $includes["invoice_documentations"] == true) {
                $res['invoice_documentations'] = InvoiceDocumentations::format($records->invoiceDocumentations, [], false);
            }

            if (isset($includes["broker"]) && $includes["broker"] == true) {

                if ($records->broker_id)
                    $res['broker'] = AppUser::format($records->broker, [], false);
                else
                    $res["broker"] = null;
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
            [['vessel_name', 'subs_due'], 'required'],
            [['charter_party', 'status_id', 'locked'], 'integer'],
            [['subs_due'], 'safe'],
            [['vessel_name', 'ship_documentation', 'stowage_plan', 'sof_comments', 'state'], 'string'],
            [['ship_documentations', 'invoice_documentations'], 'file', 'skipOnEmpty' => true,
                'extensions' => 'pdf, xls, csv, docx', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chartering_id' => 'Chartering ID',
            'vessel_name' => 'Vessel name',
            'subs_due' => 'Subs Due',
            'ship_documentation' => 'Ship Documentation',
            'invoice_documentation' => 'Invoice Documentation',
            'stowage_plan' => 'Stowage Plan',
            'charter_party' => 'Charter Party',
            'status_id' => 'Status ID',
            'sof_comments' => 'SOF comments',
            'state' => 'State',
        ];
    }

    public function isCompleted()
    {
        return $this->state == 'completed';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharterParty()
    {
        return $this->hasOne(CharterParty::className(), ['charter_party_id' => 'charter_party']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVessel()
    {
        return $this->hasOne(Vessel::className(), ['vessel_id' => 'vessel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharteringClients()
    {
        return $this->hasMany(CharteringClient::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getShipDocumentations()
    {
        return $this->hasMany(ShipDocumentations::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getInvoiceDocumentations()
    {
        return $this->hasMany(InvoiceDocumentations::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getCharteringStatuses()
    {
        return $this->hasMany(CharteringStatuses::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getCharteringCompanies()
    {
        return $this->hasMany(CharteringCompany::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(CharteringStatuses::className(), ['chartering_status_id' => 'status_id']);
    }

    public function getClaims()
    {
        return $this->hasMany(Claims::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getBroker()
    {
        return $this->hasOne(AppUser::className(), ['user_id' => 'broker_id']);
    }

    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['chartering_id' => 'chartering_id']);
    }
}
