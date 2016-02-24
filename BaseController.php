<?php

namespace app;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;

class BaseController extends Controller
{
    public function beforeAction()
    {
        if( Yii::$app->user->isGuest ){        
            $user = new User();
            $user->loginFromWechat();
        }
        return $this;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public static function getMonthFirstDate($time)
    {
        return date('Y-m-01', $time);
    }

    public static function getMonthLastDate($time)
    {
        return date('Y-m-t', $time);
    }

    public static function getWeekFirstDate($time)
    {
        $date = date('Y-m-d', $time);
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        return date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
    }

    public static function getWeekLastDate($time)
    {
        $date = date('Y-m-d', $time);
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        return date('Y-m-d',strtotime("$now_start +6 days"));
    }
}
