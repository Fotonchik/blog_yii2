<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "=== ПРОВЕРКА БАЗЫ ДАННЫХ ===\n\n";
    
    // Проверяем users
    echo "Таблица users:\n";
    $users = Yii::$app->db->createCommand('SELECT * FROM users')->queryAll();
    foreach ($users as $user) {
        echo "- {$user['username']} ({$user['role']})\n";
    }
    echo "Всего пользователей: " . count($users) . "\n\n";
    
    // Проверяем posts
    echo "Таблица posts:\n";
    $posts = Yii::$app->db->createCommand('SELECT * FROM posts')->queryAll();
    foreach ($posts as $post) {
        echo "- {$post['title']} (автор: {$post['author_id']})\n";
    }
    echo "Всего постов: " . count($posts) . "\n\n";
    
    // Проверяем структуру posts
    echo "Структура posts:\n";
    $columns = Yii::$app->db->getTableSchema('posts')->columns;
    foreach ($columns as $column) {
        echo "- {$column->name} ({$column->dbType})\n";
    }
    
    echo "\n✅ ВСЕ ПРОВЕРКИ ПРОЙДЕНЫ!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}