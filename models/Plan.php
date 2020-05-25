<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%plan}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string $value
 * @property string $ctime
 * @property string $utime
 */
class Plan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plan}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'integer'],
            [['value'], 'number'],
            [['ctime', 'utime'], 'safe'],
            [['user_id', 'type'], 'unique', 'targetAttribute' => ['user_id', 'type'], 'message' => 'The combination of User ID and Type has already been taken.']
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
            'type' => 'Type',
            'value' => 'Value',
            'ctime' => 'Ctime',
            'utime' => 'Utime',
        ];
    }

    public static function getMonthPlan( $user_id )
    {
        $plan = self::findOne(['user_id' => $user_id]);
        if (!$plan) {
            $plan = new Plan();
            $plan->user_id = $user_id;
            $plan->value = 5000;
            $plan->save();
        }
        return $plan->value;
    }
}
