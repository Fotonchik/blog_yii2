<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\PostSearch $model */
/** @var array $authors */
?>

<div class="post-search card mb-4">
    <div class="card-body">
        <h5 class="card-title">🔍 Поиск и фильтрация</h5>
        
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'class' => 'row g-3'
            ]
        ]); ?>

        <div class="col-md-4">
            <?= $form->field($model, 'search', [
                'inputOptions' => ['placeholder' => 'Поиск по заголовку, содержанию или автору...']
            ])->label(false) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'author_id')->dropDownList(
                ['' => 'Все авторы'] + $authors,
                ['class' => 'form-select']
            )->label(false) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'created_at')->input('date', [
                'class' => 'form-control'
            ])->label(false) ?>
        </div>

        <div class="col-md-2">
            <div class="d-grid gap-2">
                <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Сброс', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>