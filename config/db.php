<?php

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';dbname=' . (getenv('DB_NAME') ?: 'yii2basic'),
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
    'charset' => 'utf8',
];

// Docker environment
if (getenv('DB_HOST')) {
    $db['dsn'] = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME');
    $db['username'] = getenv('DB_USER');
    $db['password'] = getenv('DB_PASS');
}

return $db;