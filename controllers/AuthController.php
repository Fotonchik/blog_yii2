<?php
namespace app\controllers;

use Yii;
use app\models\User;
use app\models\LoginForm;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Вы успешно вошли в систему!');
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Вы вышли из системы.');
        return $this->goHome();
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        $model->scenario = 'register';

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            $model->role = User::ROLE_USER;
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Регистрация успешна! Теперь вы можете войти.');
                return $this->redirect(['login']);
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
}