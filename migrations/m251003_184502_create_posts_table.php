<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m251003_184502_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        // Добавляем внешний ключ
        $this->addForeignKey(
            'fk-posts-author_id',
            'posts',
            'author_id',
            'users',
            'id',
            'CASCADE'
        );

        // Добавляем тестовые посты
        $this->insert('posts', [
            'title' => 'Добро пожаловать в наш блог!',
            'content' => 'Это первый пост в нашем замечательном блоге. Здесь мы будем делиться интересными статьями и новостями.',
            'author_id' => 1,
        ]);

        $this->insert('posts', [
            'title' => 'О проекте',
            'content' => 'Этот блог создан на Yii2 framework. Мы рады приветствовать вас!',
            'author_id' => 2,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-posts-author_id', 'posts');
        $this->dropTable('posts');
    }
}