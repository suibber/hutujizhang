<?php

use yii\db\Schema;
use yii\db\Migration;

class m150907_072105_account extends Migration
{
    public function up()
    {
        $sql = "
        CREATE TABLE `ht_account`(
            `id` INT(11) NOT NULL auto_increment COMMENT '账单ID',
            `user_id` INT(11) DEFAULT NULL COMMENT '用户ID',
            `io_type` TINYINT(4) DEFAULT NULL COMMENT '收支类型',
            `type_id` INT(11) DEFAULT NULL COMMENT '我的类型',
            `value` decimal(10,2) DEFAULT NULL COMMENT '金额',
            `comment` VARCHAR(400) DEFAULT NULL COMMENT '备注',
            `origin_msg` VARCHAR(500) DEFAULT NULL COMMENT '输入信息',
            `date` DATE DEFAULT NULL COMMENT '记账日',
            `ctime` TIMESTAMP COMMENT '创建时间',
            `utime` TIMESTAMP COMMENT '更新时间',
            PRIMARY KEY(`id`)
        )ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m150907_072105_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
