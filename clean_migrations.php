<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "Очищаем историю миграций...\n";
    
    // Удаляем таблицу миграций если существует
    Yii::$app->db->createCommand('DROP TABLE IF EXISTS migration')->execute();
    echo "✅ Таблица migration удалена\n";
    
    // Удаляем основные таблицы
    Yii::$app->db->createCommand('DROP TABLE IF EXISTS posts')->execute();
    echo "✅ Таблица posts удалена\n";
    
    Yii::$app->db->createCommand('DROP TABLE IF EXISTS users')->execute();
    echo "✅ Таблица users удалена\n";
    
    echo "✅ База данных полностью очищена!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}