<?php

namespace app\models;

/**
 * This is the model class for table "NotificationSettings".
 *
 * @property string $notification_settings_id
 * @property integer $weather_reports
 * @property integer $newsletters
 * @property integer $new_message
 *
 * @property User[] $users
 */
class NotificationSettings extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'NotificationSettings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subs_due', 'live_position_updates'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_settings_id' => 'Notification Settings ID',
            'subs_due' => 'Subs Due',
            'live_position_updates' => 'Live Position Updates',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['notification_settings_id' => 'notification_settings_id']);
    }
}
