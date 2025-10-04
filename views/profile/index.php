<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <div class="row">
        <div class="col-md-4">
            <!-- Боковая панель профиля -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="<?= $model->getAvatarUrl() ?>" 
                             alt="Аватар" 
                             class="rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                    </div>
                    <h4 class="card-title"><?= Html::encode($model->username) ?></h4>
                    <p class="text-muted"><?= Html::encode($model->email) ?></p>
                    
                    <div class="d-grid gap-2">
                        <?= Html::a('📖 Мои посты', ['posts', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
                        <?= Html::a('👁️ Публичный профиль', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-secondary']) ?>
                    </div>
                </div>
            </div>

            <!-- Статистика -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">📊 Статистика</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary"><?= $model->getPosts()->count() ?></h4>
                            <small class="text-muted">Постов</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success"><?= Yii::$app->formatter->asDate($model->created_at) ?></h4>
                            <small class="text-muted">С нами с</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Форма редактирования профиля -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">✏️ Редактирование профиля</h5>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Имя пользователя') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email') ?>
                        </div>
                    </div>

                    <!-- Загрузка аватара -->
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'avatarFile')->fileInput()->label('Сменить аватар') ?>
                            <small class="form-text text-muted">
                                Рекомендуемый размер: 150x150px. Поддерживаемые форматы: JPG, PNG, GIF.
                            </small>
                        </div>
                    </div>

                    <!-- Информация о профиле -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Роль</label>
                                <input type="text" class="form-control" value="<?= $model->role ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Зарегистрирован</label>
                                <input type="text" class="form-control" value="<?= Yii::$app->formatter->asDatetime($model->created_at) ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <?= Html::submitButton('💾 Сохранить изменения', ['class' => 'btn btn-success btn-lg']) ?>
                        <?= Html::a('❌ Отмена', ['index'], ['class' => 'btn btn-secondary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <!-- Быстрые действия -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">⚡ Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= Html::a('✍️ Написать новый пост', ['/post/create'], ['class' => 'btn btn-primary w-100']) ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= Html::a('📖 Мои посты', ['posts', 'id' => $model->id], ['class' => 'btn btn-outline-primary w-100']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>