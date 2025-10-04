<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    // Проверяем, есть ли столбец author_id
    $tableSchema = Yii::$app->db->getTableSchema('posts');
    $hasAuthorId = isset($tableSchema->columns['author_id']);
    
    if (!$hasAuthorId) {
        echo "Добавляем author_id в таблицу posts...\n";
        
        Yii::$app->db->createCommand()->addColumn('posts', 'author_id', 'integer NOT NULL DEFAULT 1')->execute();
        
        // Обновляем существующие посты - назначаем их админу
        Yii::$app->db->createCommand()->update('posts', ['author_id' => 1])->execute();
        
        echo "✅ author_id добавлен!\n";
    } else {
        echo "✅ author_id уже существует!\n";
    }
    
    // Показываем структуру таблицы
    $columns = Yii::$app->db->getTableSchema('posts')->columns;
    echo "Структура таблицы posts:\n";
    foreach ($columns as $column) {
        echo " - {$column->name} ({$column->dbType})\n";
    }
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}