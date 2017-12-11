<?php

namespace app\models;

use yii\helpers\Url as Url;

/**
 * This is the model class for table "{{%AraPositions}}".
 *
 * @property string $vessel_id
 * @property string $name
 * @property string $size
 * @property string $grade
 * @property string $built
 * @property string $status
 * @property string $open_date
 * @property string $location
 * @property integer $cbm
 * @property integer $dwt
 * @property double $loa
 * @property string $last
 * @property integer $imo
 * @property string $hull
 * @property string $sire
 * @property integer $intake
 * @property string $tema_suitable
 * @property string $cabotage
 * @property string $nigerian_cab
 * @property string $comments
 * @property string $last_update
 * @property string $broker_id
 * @property integer $positions_visible
 *
 * @property User $broker
 */
class AraPosition extends BasePosition
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%AraPositions}}';
    }

    /**
     * @return string
     */
    public static function rootUrl()
    {
        return Url::toRoute('/api/ara-positions/', true);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function freeVessels()
    {
        return self::find()->where('not exists (select * from Chartering where vessel_id = Vessel.vessel_id 
            and state <> \'completed\')')->all();
    }
}
