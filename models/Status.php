<?php

namespace app\models;

use yii\helpers\Url as Url;

/**
 * This is the model class for table "Status".
 *
 * @property string $status_id
 * @property integer $description
 * @property integer $final
 * @property integer $on_subs
 *
 * @property Operation[] $operations
 * @property OperationState[] $operationStatuses
 */
class Status extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Status';
    }

    public static function info()
    {

        $parent = parent::info();

        return array_merge([
            'controller_id' => 'statuses',
            'create_url' => Url::toRoute('statuses/create'),
            'index_url' => Url::toRoute('statuses/')
        ], $parent);
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/state/', true);
    }

    public static function format($states, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($states)) {
            foreach ($states as $state) {
                $result[] = self::format($state, $includes, false);
            }

            return $result;

        } else {

            $res = self::formatData($states, self::className(), false, false);


            $info = $states::info();

            if (isset($includes['update_url']) && $includes['update_url'] == true) {
                $res['update_url'] = Url::toRoute($info['controller_id'] . '/update/' . $states->{$info['primary_key']});
            }

            if (isset($includes['delete_url']) && $includes['delete_url'] == true) {
                $res['delete_url'] = Url::toRoute($info['controller_id'] . '/delete/' . $states->{$info['primary_key']});
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
            [['description'], 'required'],
            [['description'], 'string'],
            [['final', 'on_subs', 'start_status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'description' => 'Description',
            'final' => 'Final Status',
            'on_subs' => 'On Subs Status',
            'start_status' => 'Start Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharteringStatuses()
    {
        return $this->hasMany(CharteringStatuses::className(), ['status_id' => 'status_id']);
    }
}
