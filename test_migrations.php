<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "=== ПРОВЕРКА МИГРАЦИЙ ===\n\n";
    
    // Проверяем таблицу миграций
    $migrations = Yii::$app->db->createCommand('SELECT * FROM migration')->queryAll();
    echo "Примененные миграции:\n";
    foreach ($migrations as $migration) {
        echo "- {$migration['version']}\n";
    }
    echo "\n";
    
    // Проверяем users
    $users = Yii::$app->db->createCommand('SELECT * FROM users')->queryAll();
    echo "Пользователи: " . count($users) . "\n";
    
    // Проверяем posts
    $posts = Yii::$app->db->createCommand('SELECT * FROM posts')->queryAll();
    echo "Посты: " . count($posts) . "\n";
    
    echo "\n✅ ВСЕ РАБОТАЕТ!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}