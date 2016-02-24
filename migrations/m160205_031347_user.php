<?php

use yii\db\Schema;
use yii\db\Migration;

class m160205_031347_user extends Migration
{
    public function up()
    {
        $sql = "Alter table ht_user add auth_key varchar(500) default '' comment 'auth key';";
        $sql .= "alter table ht_user add status tinyint(4) default '0' comment '状态';";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m160205_031347_user cannot be reverted.\n";

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
