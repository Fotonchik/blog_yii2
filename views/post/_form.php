<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>
    
    <?= $form->field($model, 'content')->textarea(['rows' => 8])->label('Содержание') ?>
    
    <?= $form->field($model, 'imageFile')->fileInput()->label('Загрузить изображение') ?>
    
    <?php if (!$model->isNewRecord && $model->image): ?>
        <div class="form-group">
            <label>Текущее изображение:</label>
            <div>
                <img src="<?= Yii::getAlias('@web/uploads/' . $model->image) ?>" 
                     alt="Current image" 
                     style="max-width: 300px; height: auto; border: 1px solid #ddd; padding: 5px;">
                <div class="mt-2">
                    <small class="text-muted">Файл: <?= $model->image ?></small>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-lg']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>