<?php

namespace app\models;

use yii\helpers\Url as Url;

/**
 * This is the model class for table "Chat".
 *
 * @property string $chat_id
 * @property string $from_id
 * @property string $to_id
 * @property string $message
 * @property string $date
 * @property string $status
 *
 * @property User $from
 * @property User $to
 */
class Chat extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Chat';
    }

    public static function rootUrl()
    {
        return Url::toRoute('/api/chat/', true);
    }

    public static function format($chats, $includes = [], $api_endpoint = true)
    {

        $result = [];

        if (is_array($chats)) {
            foreach ($chats as $chat) {
                $result[] = self::format($chat, $includes, false);
            }

            return $result;

        } else {

            $res = self::formatData($chats, self::className(), false, false);
            $res['date'] = date('d M, Y H:i', strtotime($res['date']));

            if (isset($includes['from']) && $includes['from']) {
                $res['from'] = AppUser::format($chats->getFrom()->one(), [], false);
            }

            if (isset($includes['to']) && $includes['to']) {
                $res['to'] = AppUser::format($chats->getTo()->one(), [], false);
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
            [['from_id', 'to_id', 'message'], 'required'],
            [['from_id', 'to_id'], 'integer'],
            [['message', 'status'], 'string'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'message' => 'Message',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(AppUser::className(), ['user_id' => 'from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(AppUser::className(), ['user_id' => 'to_id']);
    }
}
