<?php

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $authors */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Создать пост', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <?= $this->render('_search', [
        'model' => $searchModel,
        'authors' => $authors,
    ]); ?>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <?php if ($model->image): ?>
                    <img src="<?= Yii::getAlias('@web/uploads/' . $model->image) ?>" class="card-img-top" alt="<?= Html::encode($model->title) ?>" style="height: 200px; object-fit: cover;">
                <?php endif; ?>
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
                    <p class="card-text flex-grow-1">
                        <?= nl2br(Html::encode(mb_substr($model->content, 0, 150))) ?><?= mb_strlen($model->content) > 150 ? '...' : '' ?>
                    </p>
                    
                    <div class="text-muted small mt-auto">
                        <div>Автор: <?= Html::encode($model->author->username) ?></div>
                        <div>Создан: <?= Yii::$app->formatter->asDatetime($model->created_at) ?></div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="btn-group btn-group-sm">
                        <?= Html::a('Читать', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        
                        <?php if ($model->canEdit()): ?>
                            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledPageCssClass' => 'page-item disabled',
        ]) ?>
    </div>

</div>