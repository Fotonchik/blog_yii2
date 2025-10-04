<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "=== ПРОВЕРКА СИСТЕМЫ ИЗОБРАЖЕНИЙ ===\n\n";
    
    // 1. Проверяем поле в базе
    $tableSchema = Yii::$app->db->getTableSchema('posts');
    if (isset($tableSchema->columns['image'])) {
        echo "✅ Поле image существует в БД\n";
        echo "   Тип: {$tableSchema->columns['image']->dbType}\n";
    } else {
        echo "❌ Поле image ОТСУТСТВУЕТ в БД\n";
        exit;
    }
    
    // 2. Проверяем папку uploads
    $uploadsPath = Yii::getAlias('@webroot/uploads');
    if (!file_exists($uploadsPath)) {
        mkdir($uploadsPath, 0777, true);
        echo "✅ Папка uploads создана\n";
    } else {
        echo "✅ Папка uploads существует\n";
    }
    
    // 3. Проверяем права на запись
    $testFile = $uploadsPath . '/test_write.txt';
    if (file_put_contents($testFile, 'test')) {
        unlink($testFile);
        echo "✅ Права на запись в папку есть\n";
    } else {
        echo "❌ Нет прав на запись в папку\n";
    }
    
    // 4. Показываем текущие посты
    $posts = Yii::$app->db->createCommand('SELECT id, title, image FROM posts')->queryAll();
    echo "\n📝 ТЕКУЩИЕ ПОСТЫ:\n";
    foreach ($posts as $post) {
        $imageStatus = $post['image'] ? "✅ Есть: {$post['image']}" : "❌ Нет";
        echo "- ID: {$post['id']}, Заголовок: {$post['title']}, Изображение: {$imageStatus}\n";
    }
    
    echo "\n🎉 СИСТЕМА ГОТОВА К ЗАГРУЗКЕ ИЗОБРАЖЕНИЙ!\n";
    echo "👉 Теперь можно создавать посты с изображениями!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}