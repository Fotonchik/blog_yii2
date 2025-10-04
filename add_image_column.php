<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "Добавляем поле image в таблицу posts...\n";
    
    // Проверяем, есть ли уже поле image
    $tableSchema = Yii::$app->db->getTableSchema('posts');
    if (isset($tableSchema->columns['image'])) {
        echo "✅ Поле image уже существует\n";
    } else {
        // Добавляем поле image
        Yii::$app->db->createCommand()->addColumn('posts', 'image', 'varchar(255) NULL')->execute();
        echo "✅ Поле image успешно добавлено!\n";
    }
    
    // Обновляем существующие посты - добавляем тестовое изображение для демонстрации
    Yii::$app->db->createCommand()->update('posts', ['image' => 'demo.jpg'], ['image' => null])->execute();
    echo "✅ Существующие посты обновлены\n";
    
    // Проверяем результат
    $posts = Yii::$app->db->createCommand('SELECT id, title, image FROM posts')->queryAll();
    echo "\nТекущие посты:\n";
    foreach ($posts as $post) {
        echo "- ID: {$post['id']}, Заголовок: {$post['title']}, Изображение: " . ($post['image'] ? $post['image'] : 'нет') . "\n";
    }
    
    echo "\n🎉 ВСЕ ГОТОВО! Теперь можно загружать изображения!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
    
    // Покажем структуру таблицы для диагностики
    echo "\nСтруктура таблицы posts:\n";
    $columns = Yii::$app->db->getTableSchema('posts')->columns;
    foreach ($columns as $column) {
        echo "- {$column->name} ({$column->dbType})\n";
    }
}