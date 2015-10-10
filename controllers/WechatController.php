<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Account;
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

                $userinfo       = $this->getUserInfoByOpenid($fromUsername);
                if( $msgtype == 'text' ){
                    $result = $this->saveAccount($userinfo->id, $keyword);
                    $re_contentStr = $result['msg'];
                }else{
                    $re_contentStr = "使用以下格式记账：\n吃饭，24";
                }
                $resultStr = sprintf($re_textTpl, $fromUsername, $toUsername, $re_time, $re_msgType, $re_contentStr);
                echo $resultStr;
        }else {
            echo "access denied";
            exit;
        }
        
    }

    private function saveAccount($user_id, $origin_msg, $date = ''){
        $date = $date ? $date : date("Y-m-d");
        $comment = '';
        $value = '';

        $origin_msg = str_ireplace('，',',',htmlspecialchars(strip_tags(trim($origin_msg))));
        $origin_msg = preg_replace('/\s/is',',',$origin_msg);
        $explode = explode(',', $origin_msg);
        if(count($explode) == 2){
            list($comment, $value) = $explode;
        }

        if( is_numeric($value) ){
            $account_model = new Account();
            $account_model->user_id = $user_id;
            $account_model->origin_msg = $origin_msg;
            $account_model->date = $date;
            $account_model->value = $value;
            $account_model->comment = $comment;
            $account_model->save();
            $month_stat = $this->getMonthStat($user_id);
            $result = [
                'success' => true,
                'msg' => '成功记录：'.$account_model->comment.'，'.$account_model->value
                    ."\r\n本月消费：".$month_stat['sum']
                    ."\r\n本月日均：".$month_stat['average']
                    ."\r\n回复“撤销”删除本次录入",
            ];
        }else{
            if( stripos('撤销',$origin_msg) !== false ){
                $account_model = Account::find()
                    ->where(['user_id'=>$user_id])
                    ->orderBy(['id'=>SORT_DESC])
                    ->one();
                $account_model->delete();
                $result = [
                    'success' => true,
                    'msg' => "已删除上一条记录",
                ];
            }else{
                $result = [
                    'success' => false,
                    'msg' => "格式有误，请使用：\n吃饭，24",
                ];
            }
        }

        return $result;
    }

    public function getMonthStat($user_id){
        $account_query = Account::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['>=', 'date', date("Y-m-01")]);
        $sum = round($account_query->sum('value'),2);
        $month_days = intval(( strtotime(date("Y-m-d")) - strtotime(date("Y-m-01")) + 3600*24 ) / (3600*24));
        $average = round($sum/$month_days,2);
        return [
            'sum' => $sum,
            'average' => $average,
        ];
    }
}
?>
