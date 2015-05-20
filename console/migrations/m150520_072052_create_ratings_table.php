<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_072052_create_ratings_table extends Migration
{
    public function up()
    {

        $tableOptions = null;
        $this->createTable('{{%rating}}',[
            'id' => Schema::TYPE_PK,
            'postId' => Schema::TYPE_INTEGER.' NOT NULL',
            'userId' => Schema::TYPE_INTEGER.' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%rating}}');
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
