<?php

namespace app\models;

/**
 * This is the model class for table "Newsletter".
 *
 * @property string $newsletter_id
 * @property string $title
 * @property string $date
 * @property string $file
 */
class Newsletter extends DefaultModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Newsletter';
    }

    public static function format($invoices, $includes = [], $api_endpoint = true)
    {
        $result = [];

        if (is_array($invoices)) {
            foreach ($invoices as $invoice) {
                $result[] = self::format($invoice, $includes, $api_endpoint);
            }

            return $result;

        } else {

            $res = self::formatData($invoices, self::className(), false, $api_endpoint);
            $res['date'] = date('d M Y', strtotime($invoices->date));

            return $res;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'file'], 'required'],
            [['title', 'file'], 'string'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newsletter_id' => 'Newsletter ID',
            'title' => 'Title',
            'date' => 'Date',
            'file' => 'File',
        ];
    }
}
