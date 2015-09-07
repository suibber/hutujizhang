<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_113150_user extends Migration
{
    public function up()
    {
        $sqls = "
CREATE TABLE `ht_user`(
	`id` INT(11) NOT NULL auto_increment COMMENT '用户ID',
	`username` VARCHAR(200) DEFAULT 0 COMMENT '用户名',
	`password` VARCHAR(500) DEFAULT 0 COMMENT '密码',
	`openid` VARCHAR(200) DEFAULT 0 COMMENT '微信ID',
	`nickname` VARCHAR(200) DEFAULT NULL COMMENT '用户昵称',
	`avatar` VARCHAR(200) DEFAULT NULL COMMENT '头像地址',
	`ctime` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
	`utime` timestamp COMMENT '修改时间',
	`ltime` timestamp COMMENT '登录时间',
	PRIMARY KEY(`id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
        return $this->execute($sqls);
    }

    public function down()
    {
        echo "m150906_113150_user cannot be reverted.\n";

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
