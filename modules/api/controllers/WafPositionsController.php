<?php

namespace app\modules\api\controllers;

use app\models\WafPosition;
use Yii;

/**
 * Class WafPositionsController
 * @package app\modules\api\controllers
 */
class WafPositionsController extends BasePositionsController
{

    public function init()
    {
        $this->model = WafPosition::className();
    }

    /**
     * @return mixed
     */
    public function actionAll()
    {
        $get = Yii::$app->request->get();

        if (empty($get)) {
            return $this->allVessels();
        }

        $model = new WafPosition;
        $cond = ['positions_visible' => 1];
        $andCond = '';
        $size_specified = false;

        foreach ($get as $attribute => $value) {
            $attribute_exists = $model->hasAttribute($attribute) || $attribute == 'age';

            if (!$attribute_exists) {
                return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid filter.', 'error_description' => 'Filter attribute ' . $attribute . ' not valid.'], false);
            }

            if ($attribute == 'age') {
                $andCond = "YEAR(CURDATE()) - built <= $value";
            } else {
                $cond[$attribute] = $value;
            }

            $size_specified = $size_specified || ($attribute == 'size');

            if ($attribute == 'tema_suitable')
                $cond[$attribute] = strtoupper($value);

        }

        if (!$size_specified) {
            return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid filter.', 'error_description' => 'Size value required.'], false);
        }


        $records = WafPosition::find()
            ->where($cond)
            ->andWhere($andCond)
            ->orderBy('open_date asc')
            ->all();

        return Yii::$app->api->_sendResponse(200, WafPosition::format($records, ['broker' => true], true), true);
    }

    /**
     * @return mixed
     */
    public function allVessels()
    {
        return Yii::$app->api->_sendResponse(200, WafPosition::format(
            WafPosition::find()
                ->where(['positions_visible' => 1])
                ->orderBy('open_date asc')
                ->all(), ['broker' => true]), true, false);

    }

    /**
     * @return mixed
     */
    public function actionLocations()
    {
        $locations = (new \yii\db\Query)
            ->distinct(true)
            ->select('location')
            ->from('WafPositions')
            ->all();

        return Yii::$app->api->_sendResponse(200, $locations);
    }

    /**
     * @param null $user_id
     * @param bool $return
     * @return mixed
     */
    public function viewRecord($user_id = null, $return = false)
    {
        $record = WafPosition::findOne($this->pkId);
        Yii::$app->utils->checkExistence($record);

        return Yii::$app->api->_sendResponse(200, WafPosition::format($record, ['broker' => true], true), true, $return);
    }
}
