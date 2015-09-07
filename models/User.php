<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $openid
 * @property string $nickname
 * @property string $avatar
 * @property string $ctime
 * @property string $utime
 * @property string $ltime
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ctime', 'utime', 'ltime'], 'safe'],
            [['username', 'openid', 'nickname', 'avatar'], 'string', 'max' => 200],
            [['password'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'avatar' => 'Avatar',
            'ctime' => 'Ctime',
            'utime' => 'Utime',
            'ltime' => 'Ltime',
        ];
    }
}
