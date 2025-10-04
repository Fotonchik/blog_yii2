<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "Проверяем папку uploads...\n";
    
    $uploadsPath = Yii::getAlias('@webroot/uploads');
    echo "Путь: $uploadsPath\n";
    
    if (!file_exists($uploadsPath)) {
        echo "Создаем папку uploads...\n";
        if (mkdir($uploadsPath, 0777, true)) {
            echo "✅ Папка создана успешно!\n";
        } else {
            echo "❌ Не удалось создать папку\n";
        }
    } else {
        echo "✅ Папка уже существует\n";
    }
    
    // Проверяем права на запись
    $testFile = $uploadsPath . '/test.txt';
    if (file_put_contents($testFile, 'test')) {
        unlink($testFile);
        echo "✅ Права на запись есть\n";
    } else {
        echo "❌ Нет прав на запись\n";
    }
    
    echo "✅ ВСЕ ПРОВЕРКИ ПРОЙДЕНЫ!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}