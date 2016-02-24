<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

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
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $rememberMe = true;

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
            'status' => 'status',
            'auth_key' => 'auth_key',
        ];
    }
    
    /**
     *
     * 通过微信登录，目前阶段使用URL传参形式
     *
     */
    public function loginFromWechat()
    {
        $params = Yii::$app->request->get();
        if( $this->wechatValidata($params) ){
            return Yii::$app->user->login($this->getUserByOpenid($params['openid']), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }else{
            throw new \yii\web\HttpException(401, '请先关注微信 糊涂记账');
        }
    }

    public function wechatValidata( $params )
    {
        return true;
    }

    public function getUserByOpenid( $openid )
    {
        $user = User::findOne(['openid' => $openid]);
        if( $user ){
            return $user;
        }else{
            throw new \yii\web\HttpException(401, '请先关注微信 糊涂记账');
        }
    }

    /**** inplement the interface start ****/
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($auth_key)
    {
        return $this->auth_key === $auth_key;
    }
    /**** inplement the interface end ****/
}
