<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "Проверяем структуру таблицы posts...\n";
    
    $tableSchema = Yii::$app->db->getTableSchema('posts');
    if (!$tableSchema) {
        echo "❌ Таблица posts не существует!\n";
        exit;
    }
    
    echo "✅ Таблица posts существует\n";
    
    $requiredColumns = ['id', 'title', 'content', 'author_id', 'created_at', 'updated_at'];
    foreach ($requiredColumns as $column) {
        if (isset($tableSchema->columns[$column])) {
            echo "✅ Столбец '$column' существует (" . $tableSchema->columns[$column]->dbType . ")\n";
        } else {
            echo "❌ Столбец '$column' отсутствует!\n";
        }
    }
    
    // Покажем несколько записей если есть
    $posts = Yii::$app->db->createCommand('SELECT * FROM posts LIMIT 3')->queryAll();
    echo "\nПервые записи в таблице posts:\n";
    print_r($posts);
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}