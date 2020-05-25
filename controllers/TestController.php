<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Account;
use app\models\Plan;

require_once '../vendor/thrift/Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', '../vendor/thrift');
$loader->registerDefinition('TTG', __DIR__ . '/Gen');
$loader->register();
//var_dump($loader);exit;

//require_once '../vendor/thrift/QueryClient.php';
require_once '../vendor/thrift/Types.php';

class TestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
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
        $start_date = '2016-02-20';
        $end_date = '2016-02-21';

        $query = new \vendor\thrift\QueryClient(2);
        $re = $query->queryClickActiveNativeNumber($start_date, $end_date, 'click'); 

        var_dump($re);exit;
    }
}
