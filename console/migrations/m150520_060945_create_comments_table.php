<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_060945_create_comments_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createTable("{{%comment}}", [
            'id' => Schema::TYPE_PK,
            'postId' => Schema::TYPE_INTEGER.' NOT NULL',
            'userId' => Schema::TYPE_INTEGER.' NOT NULL',
            'comment' => Schema::TYPE_TEXT.' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
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
