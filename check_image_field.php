<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "Проверяем поле image в таблице posts...\n";
    
    $tableSchema = Yii::$app->db->getTableSchema('posts');
    if (isset($tableSchema->columns['image'])) {
        echo "✅ Поле image существует в таблице posts\n";
    } else {
        echo "❌ Поле image отсутствует в таблице posts\n";
    }
    
    // Показываем текущие посты и их изображения
    $posts = Yii::$app->db->createCommand('SELECT id, title, image FROM posts')->queryAll();
    echo "\nТекущие посты:\n";
    foreach ($posts as $post) {
        echo "- ID: {$post['id']}, Заголовок: {$post['title']}, Изображение: " . ($post['image'] ? $post['image'] : 'нет') . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}