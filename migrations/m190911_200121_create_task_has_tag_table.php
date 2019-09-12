<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_has_tag}}`.
 */
class m190911_200121_create_task_has_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        
        $this->createTable('{{%task_has_tag}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull()
        ], $tableOptions);
        
        $this->addForeignKey('task_has_tag_ibfk_task', 'task_has_tag', 'task_id', 'task', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('task_has_tag_ibfk_tag', 'task_has_tag', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_has_tag}}');
    }
}
