<?php

use yii\db\Schema;
use yii\db\Migration;

class m160203_053800_plan extends Migration
{
    public function up()
    {
        $sql = "
            CREATE TABLE `ht_plan` (
                    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
                    `user_id` int(11) DEFAULT '0' COMMENT '用户ID',
                    `type` tinyint(4) DEFAULT '0' COMMENT '类型，0月、1年度。。。',
                    `value` decimal(10,2) DEFAULT '0.00' COMMENT '目标',
                    `ctime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
                    `utime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `plan_user_type` (`user_id`,`type`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        $this->execute($sql);      
    }

    public function down()
    {
        echo "m160203_053800_plan cannot be reverted.\n";

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
