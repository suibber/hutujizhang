<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\BaseController;
use yii\filters\VerbFilter;
use app\models\Account;
use app\models\Plan;

class MyController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user;
        
        $month_plan = Plan::getMonthPlan($user->id);
        $month_account_all = Account::getMonthAccountAll($user->id);
        $week_account_all = Account::getWeekAccountAll($user->id);
        $month_balance = $month_plan - $month_account_all;

        $month_account_income_all = Account::getMonthAccountIncomeAll($user->id);
        $month_account_list = Account::getMonthAccountList($user->id);
        return $this->render('index', [
            'month_plan' => $month_plan,
            'month_account_all' => $month_account_all,
            'month_balance' => $month_balance,
            'month_account_income_all' => $month_account_income_all,
            'month_account_list' => $month_account_list,
        ]);
    }
}
