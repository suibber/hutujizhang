<?php
namespace app;

use Yii;
use yii\web\Controller;
use app\models\User;

class WechatBaseController extends Controller
{

    public $layout = 'bootstrap';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function getUserInfoByOpenid($openid){
        $user = User::findOne(['openid' => $openid]);
        if( !isset($user->id) ){
            $user = $this->registByOpenId($openid);
        }
        return $user;
    }

    public function registByOpenId($openid){
        $user_model = new User;
        $date_time  = date("Y-m-d H:i:s");
        $user_model->openid = strval($openid);
        $user_model->ctime  = $date_time;
        $user_model->utime  = $date_time;
        $user_model->ltime  = $date_time;
        if( $user_model->save() ){
            return $user_model;
        }
    }
}