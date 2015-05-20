<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_074416_alter_rating_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%rating}}', "rating", Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('{{%rating}}', "rating");
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
