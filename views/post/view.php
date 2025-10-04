<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <div class="card">
        <?php if ($model->image): ?>
            <img src="<?= Yii::getAlias('@web/uploads/' . $model->image) ?>" class="card-img-top" alt="<?= Html::encode($model->title) ?>">
        <?php endif; ?>
        
        <div class="card-body">
            <h1 class="card-title"><?= Html::encode($model->title) ?></h1>
            
            <div class="post-meta text-muted mb-3">
                <small>
                    Автор: <strong><?= Html::encode($model->author->username) ?></strong> | 
                    Создан: <?= Yii::$app->formatter->asDatetime($model->created_at) ?> |
                    Обновлен: <?= Yii::$app->formatter->asDatetime($model->updated_at) ?>
                </small>
            </div>

            <div class="post-content">
                <?= nl2br(Html::encode($model->content)) ?>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="btn-group">
                <?= Html::a('Назад к списку', ['index'], ['class' => 'btn btn-secondary']) ?>
                
                <?php if ($model->canEdit()): ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот пост?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>