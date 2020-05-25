<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\BaseController;
use yii\filters\VerbFilter;
use app\models\Account;
use app\models\Plan;
use app\models\User;

class SetController extends BaseController
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
        
        $user = User::findOne($user->id);
        $month_plan = Plan::getMonthPlan($user->id);
        return $this->render('index', [
            'user' => $user,
            'month_plan' => $month_plan,
        ]);
    }

    public function actionUpdate()
    {
        $nickname = Yii::$app->request->post('nickname');
        $month_plan = Yii::$app->request->post('month_plan');
        $user_id = Yii::$app->user->id;

        $user = User::findOne($user_id);
        $user->nickname = $nickname;
        $user->update();

        $plan = Plan::find()->where(['user_id' => $user_id])->one();
        $plan->value = $month_plan;
        $plan->update();
        $this->redirect('/set/index');
    }
}
