<?php

namespace app\models;

/**
 * This is the model class for table "Claims".
 *
 * @property string $claim_id
 * @property double $owners_claim
 * @property string $owners_claim_reason
 * @property double $charterers_claim
 * @property integer $charterers_claim_reason
 * @property string $comments
 * @property string $status
 * @property string $chartering_id
 * @property string $file
 *
 * @property Chartering $chartering
 */
class Claims extends DefaultModel
{
    public $claim_documentations;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Claims';
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
        }

        if (isset($includes["claim_documentations"]) && $includes["claim_documentations"] == true) {
            $res['claim_documentations'] = ClaimDocumentations::format($records->claimDocumentations, [], false);
        }

        return $res;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'chartering_id'], 'required'],
            // [['owners_claim', 'charterers_claim', 'comments', 'status', 'chartering_id'], 'required'],
            [['owners_claim', 'charterers_claim'], 'number'],
            [['owners_claim_reason', 'comments', 'status', 'file', 'charterers_claim_reason'], 'string'],
            [['chartering_id'], 'integer'],
            //[['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, doc'],
            [['claim_documentations'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, xls, csv, docx', 'maxFiles' => 10],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'claim_id' => 'Claim ID',
            'owners_claim' => 'Owners Claim',
            'owners_claim_reason' => 'Owners Claim Reason',
            'charterers_claim' => 'Charterers Claim',
            'charterers_claim_reason' => 'Charterers Claim Reason',
            'comments' => 'Comments',
            'status' => 'Status',
            'chartering_id' => 'Chartering ID',
            'file' => 'File',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChartering()
    {
        return $this->hasOne(Chartering::className(), ['chartering_id' => 'chartering_id']);
    }

    public function getClaimDocumentations()
    {
        return $this->hasMany(ClaimDocumentations::className(), ['claim_id' => 'claim_id']);
    }
}
