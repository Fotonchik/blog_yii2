<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post())) {
            $model->avatarFile = \yii\web\UploadedFile::getInstance($model, 'avatarFile');
            
            // Валидируем только основные поля (без файла)
            if ($model->validate(['username', 'email', 'role', 'avatar'])) {
                
                // Если загружен новый аватар
                if ($model->avatarFile) {
                    if ($model->uploadAvatar()) {
                        Yii::$app->session->setFlash('success', 'Аватар успешно обновлен!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при загрузке аватара.');
                    }
                }
                
                // Сохраняем модель (без валидации, так как уже проверили)
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Профиль успешно обновлен!');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
        public function actionPosts($id)
        {
            $user = $this->findModel($id);
            
            // Создаем DataProvider для постов
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $user->getPosts(),
                'pagination' => [
                    'pageSize' => 6,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                    ]
                ],
            ]);

            return $this->render('posts', [
                'user' => $user,
                'dataProvider' => $dataProvider,
            ]);
        }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Пользователь не найден.');
    }
}