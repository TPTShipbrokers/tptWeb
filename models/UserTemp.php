<?php

namespace app\models;

/**
 * This is the model class for table "User".
 *
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $position
 * @property string $phone
 * @property string $status
 *
 * @property Operation[] $operations
 */
class UserTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'role', 'position', 'phone', 'status'], 'required'],
            [['role', 'position', 'status'], 'string'],
            [['first_name', 'last_name', 'email', 'password', 'phone'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'position' => 'Position',
            'phone' => 'Phone',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operation::className(), ['user_id' => 'user_id']);
    }
}
