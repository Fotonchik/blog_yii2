<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Post $model */
?>
<div class="col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
            <p class="card-text"><?= nl2br(Html::encode(mb_substr($model->content, 0, 150) . '...')) ?></p>
            <div class="text-muted small">
                Автор: <?= Html::encode($model->author->username) ?><br>
                Создан: <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
            </div>
        </div>
        <div class="card-footer">
            <?= Html::a('Читать', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?php if ($model->canEdit()): ?>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Вы уверены?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
            <?php if ($model->image): ?>
    <img src="<?= $model->getImageUrl() ?>" class="card-img-top" alt="<?= Html::encode($model->title) ?>">
<?php endif; ?>
        </div>
    </div>
</div>