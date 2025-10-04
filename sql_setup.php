<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    // Создаем таблицу users
    Yii::$app->db->createCommand()->createTable('users', [
        'id' => 'pk',
        'username' => 'string(100) NOT NULL UNIQUE',
        'email' => 'string(100) NOT NULL UNIQUE',
        'password_hash' => 'string(255) NOT NULL',
        'auth_key' => 'string(32) NOT NULL',
        'role' => 'string(20) DEFAULT "user"',
        'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    ])->execute();

    echo "✅ Таблица users создана!\n";

    // Добавляем тестовых пользователей
    Yii::$app->db->createCommand()->insert('users', [
        'username' => 'admin',
        'email' => 'admin@blog.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
        'auth_key' => Yii::$app->security->generateRandomString(),
        'role' => 'admin',
    ])->execute();

    Yii::$app->db->createCommand()->insert('users', [
        'username' => 'author',
        'email' => 'author@blog.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('author123'),
        'auth_key' => Yii::$app->security->generateRandomString(),
        'role' => 'author',
    ])->execute();

    echo "✅ Тестовые пользователи добавлены!\n";
    echo "👤 admin / admin123\n";
    echo "👤 author / author123\n";

} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}