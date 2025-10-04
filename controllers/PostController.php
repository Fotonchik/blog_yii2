<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PostController extends Controller
{
    /**
     * @inheritDoc
     */
   public function behaviors()
{
    return array_merge(
        parent::behaviors(),
        [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'], // Все пользователи (гости и авторизованные)
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'], // Только авторизованные
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $postId = Yii::$app->request->get('id');
                            $post = Post::findOne($postId);
                            return $post && $post->canEdit();
                        }
                    ],
                ],
            ],
        ]
    );
}

    /**
     * Lists all Post models.
     *
     * @return string
     */

 public function actionIndex()
{
    $searchModel = new PostSearch(); 
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $authors = \app\models\User::find()
        ->select(['id', 'username'])
        ->indexBy('id')
        ->column();

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'authors' => $authors,
    ]);
}
    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
   public function actionCreate()
{
    $model = new Post();

    if ($model->load(Yii::$app->request->post())) {
        $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
        
        if ($model->validate()) {
            // Загружаем изображение если есть
            if ($model->imageFile) {
                $model->upload();
            }
            
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Пост успешно создан!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}
    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionUpdate($id)
{
    $model = $this->findModel($id);

    // Проверяем, может ли пользователь редактировать этот пост
    if (!$model->canEdit()) {
        Yii::$app->session->setFlash('error', 'Вы не можете редактировать этот пост.');
        return $this->redirect(['index']);
    }

    // Сохраняем старое изображение
    $oldImage = $model->image;

    if ($this->request->isPost && $model->load($this->request->post())) {
        $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
        
        if ($model->validate()) {
            // Если загружено новое изображение
            if ($model->imageFile) {
                // Удаляем старое изображение
                if ($oldImage) {
                    $oldImagePath = Yii::getAlias('@webroot/uploads/') . $oldImage;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                // Загружаем новое
                $model->upload();
            } else {
                // Сохраняем старое изображение
                $model->image = $oldImage;
            }
            
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Пост успешно обновлен!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}
    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionDelete($id)
{
    $model = $this->findModel($id);

    // Проверяем, может ли пользователь удалить этот пост
    if (!$model->canEdit()) {
        Yii::$app->session->setFlash('error', 'Вы не можете удалить этот пост.');
        return $this->redirect(['index']);
    }

    // Удаляем изображение если есть
    if ($model->image) {
        $imagePath = Yii::getAlias('@webroot/uploads/') . $model->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $model->delete();
    Yii::$app->session->setFlash('success', 'Пост успешно удален!');

    return $this->redirect(['index']);
}

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}