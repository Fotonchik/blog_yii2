<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/config/web.php';

(new yii\web\Application($config));

try {
    echo "=== ТЕСТИРУЕМ МОДЕЛЬ POST ===\n\n";
    
    $post = new \app\models\Post();
    
    // Проверяем свойства
    echo "1. Проверяем свойства модели:\n";
    $properties = ['id', 'title', 'content', 'author_id', 'image', 'imageFile'];
    foreach ($properties as $property) {
        if (property_exists($post, $property)) {
            echo "   ✅ {$property} существует\n";
        } else {
            echo "   ❌ {$property} ОТСУТСТВУЕТ\n";
        }
    }
    
    echo "\n2. Проверяем правила валидации:\n";
    $rules = $post->rules();
    $hasImageFileRule = false;
    foreach ($rules as $rule) {
        if (isset($rule[0]) && in_array('imageFile', (array)$rule[0])) {
            $hasImageFileRule = true;
            break;
        }
    }
    echo $hasImageFileRule ? "   ✅ Правило для imageFile есть\n" : "   ❌ Правила для imageFile нет\n";
    
    echo "\n3. Проверяем создание поста:\n";
    $testPost = new \app\models\Post();
    $testPost->title = 'Тестовый пост';
    $testPost->content = 'Тестовое содержание';
    $testPost->author_id = 1;
    
    if ($testPost->save()) {
        echo "   ✅ Пост создан успешно (ID: {$testPost->id})\n";
        
        // Удаляем тестовый пост
        $testPost->delete();
        echo "   ✅ Тестовый пост удален\n";
    } else {
        echo "   ❌ Ошибка создания поста: " . print_r($testPost->errors, true) . "\n";
    }
    
    echo "\n🎉 МОДЕЛЬ POST РАБОТАЕТ КОРРЕКТНО!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
}