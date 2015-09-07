<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\WechatBaseController;

class WechatController extends WechatBaseController{
    public function actionTest(){
        $user_m = User::findAll(['username'=>'13699273824']);
        var_dump($user_m);exit;
    }

    public function actionIndex(){
        // 第一次接入微信，做验证
        if( Yii::$app->request->get("echostr") ){
            echo Yii::$app->request->get("echostr");
            exit;
        }
        $this->responseMsg();
    }

    private function responseMsg(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
                libxml_disable_entity_loader(true);
                $postObj        = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername   = $postObj->FromUserName;   // 微信用户ID
                $toUsername     = $postObj->ToUserName;     // 开发者账号
                $keyword        = trim($postObj->Content);  // 用户输入信息
                $time           = $postObj->CreateTime;     // 请求时间
                $msgtype        = $postObj->MsgType;        // 请求类型
                $event          = $postObj->Event ? $postObj->Event : '';   // 事件类型

                $re_contentStr  = '';                       // 返回消息
                $re_time        = time();                   // 返回时间
                $re_msgType     = "text";                   // 返回消息类型

                $userinfo       = $this->getUserInfoByOpenid($fromUsername);

                // 返回消息模板
                $re_textTpl     = "
                                <xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>
                "; 

                if( $msgtype == 'text' ){
                    $re_contentStr = $userinfo->openid;
                }else{
                    $re_contentStr = '444';
                }
                $resultStr = sprintf($re_textTpl, $fromUsername, $toUsername, $re_time, $re_msgType, $re_contentStr);
                echo $resultStr;
        }else {
            echo "access denied";
            exit;
        }
        
    }
}
?>