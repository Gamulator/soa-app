<?php

use yii\db\Migration;

class m201021_212715_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%data}}', [
            'id' => $this->primaryKey(),
            'page_uid' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'content' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('idx-data-page_uid', '{{%data}}', 'page_uid');
    }

    public function down()
    {
        $this->dropTable('{{%data}}');
    }
}
