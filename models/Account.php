<?php

namespace app\models;

use Yii;

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
}
