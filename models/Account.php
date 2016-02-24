<?php

namespace app\models;

use Yii;
use app\BaseController;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $io_type
 * @property integer $type_id
 * @property string $value
 * @property string $comment
 * @property string $origin_msg
 * @property string $date
 * @property string $ctime
 * @property string $utime
 */
class Account extends \yii\db\ActiveRecord
{
    public static $IO_TYPES = [
        0 => '支出',
        1 => '收入',
    ];
    const IO_TYPE_EXPENDITURE = 0;
    const IO_TYPE_INCOME = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'io_type', 'type_id'], 'integer'],
            [['value'], 'number'],
            [['date', 'ctime', 'utime'], 'safe'],
            [['comment'], 'string', 'max' => 400],
            [['origin_msg'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'io_type' => 'Io Type',
            'type_id' => 'Type ID',
            'value' => 'Value',
            'comment' => 'Comment',
            'origin_msg' => 'Origin Msg',
            'date' => 'Date',
            'ctime' => 'Ctime',
            'utime' => 'Utime',
        ];
    }

    public static function getMonthAccountAll($user_id)
    {
        $start_date = BaseController::getMonthFirstDate(time());
        $end_date = BaseController::getMonthLastDate(time());
        $datas = self::find()
            ->where(['user_id' => $user_id, 'io_type' => self::IO_TYPE_EXPENDITURE])
            ->andWhere(['>=', 'date', $start_date])
            ->andWhere(['<=', 'date', $end_date])
            ->sum('value');
        return $datas;
    }

    public static function getMonthAccountList($user_id)
    {
        $start_date = BaseController::getMonthFirstDate(time());
        $end_date = BaseController::getMonthLastDate(time());
        $datas = self::find()
            ->select("date, sum(value) value")
            ->where(['user_id' => $user_id, 'io_type' => self::IO_TYPE_EXPENDITURE])
            ->andWhere(['>=', 'date', $start_date])
            ->andWhere(['<=', 'date', $end_date])
            ->orderBy(['date' => SORT_DESC])
            ->groupBy('date')
            ->all();
        return $datas;
    }

    public static function getMonthAccountIncomeAll($user_id)
    {
        $start_date = BaseController::getMonthFirstDate(time());
        $end_date = BaseController::getMonthLastDate(time());
        $datas = self::find()
            ->where(['user_id' => $user_id, 'io_type' => self::IO_TYPE_INCOME])
            ->andWhere(['>=', 'date', $start_date])
            ->andWhere(['<=', 'date', $end_date])
            ->sum('value');
        return ($datas*-1);
    }

    public static function getWeekAccountAll($user_id)
    {
        $start_date = BaseController::getWeekFirstDate(time());
        $end_date = BaseController::getWeekLastDate(time());
        $datas = self::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['>=', 'date', $start_date])
            ->andWhere(['<=', 'date', $end_date])
            ->sum('value');
        return $datas;
    }
}
