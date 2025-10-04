<?php
namespace app\controllers;

use Yii;
use app\models\Post;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\Post';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        // Добавляем аутентификацию по Bearer токену
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['create', 'update', 'delete'],
        ];
        
        // Разрешаем CORS
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        
        // Настраиваем подготовку провайдера данных
        $actions['index']['prepareDataProvider'] = function ($action) {
            return new \yii\data\ActiveDataProvider([
                'query' => Post::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ]
                ],
            ]);
        };

        return $actions;
    }

    // Дополнительный endpoint для статистики
    public function actionStats()
    {
        return [
            'total_posts' => Post::find()->count(),
            'total_users' => \app\models\User::find()->count(),
            'latest_post' => Post::find()->orderBy(['created_at' => SORT_DESC])->one(),
        ];
    }
}