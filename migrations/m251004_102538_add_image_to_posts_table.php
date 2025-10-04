<?php

use yii\db\Migration;

class m251004_102538_add_image_to_posts_table extends Migration

{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'image', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'image');
    }
}