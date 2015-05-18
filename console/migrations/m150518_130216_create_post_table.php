<?php

use yii\db\Schema;
use yii\db\Migration;

class m150518_130216_create_post_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createTable("{{%post}}", [
            'id' => Schema::TYPE_PK,
            'userId' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'slug' => Schema::TYPE_STRING . '(255) NOT NULL UNIQUE KEY',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post}}');
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
