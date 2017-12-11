<?php

namespace app\components;

use app\models\AraPosition;
use app\models\WafPosition;
use yii\base\Component;

/**
 * Class PositionHelper
 * @package app\components
 */
class PositionHelper extends Component
{
    /**
     * @return array
     */
    public function getVesselNames()
    {
        $wafPositions = WafPosition::find()->asArray()->all();
        $araPositions = AraPosition::find()->asArray()->all();

        $vessels = [];
        foreach ($wafPositions as $position) {
            $vessels[$position['name']] = $position['name'];
        }

        foreach ($araPositions as $position) {
            $vessels[$position['name']] = $position['name'];
        }

        return $vessels;
    }
}