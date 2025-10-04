<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Посты пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Посты';
?>
<div class="profile-posts">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <span class="badge bg-primary fs-6">Всего постов: <?= $dataProvider->totalCount ?></span>
    </div>

    <?php if ($dataProvider->totalCount > 0): ?>
        <div class="row">
            <?php foreach ($dataProvider->getModels() as $post): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <?php if ($post->image): ?>
                        <img src="<?= Yii::getAlias('@web/uploads/' . $post->image) ?>" 
                             class="card-img-top" 
                             alt="<?= Html::encode($post->title) ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= Html::encode($post->title) ?></h5>
                        <p class="card-text flex-grow-1">
                            <?= nl2br(Html::encode(mb_substr($post->content, 0, 150))) ?><?= mb_strlen($post->content) > 150 ? '...' : '' ?>
                        </p>
                        
                        <div class="text-muted small mt-auto">
                            <div>Создан: <?= Yii::$app->formatter->asDatetime($post->created_at) ?></div>
                            <?php if ($post->updated_at != $post->created_at): ?>
                                <div>Обновлен: <?= Yii::$app->formatter->asDatetime($post->updated_at) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="btn-group btn-group-sm">
                            <?= Html::a('Читать', ['/post/view', 'id' => $post->id], ['class' => 'btn btn-primary']) ?>
                            <?php if ($post->canEdit()): ?>
                                <?= Html::a('Редактировать', ['/post/update', 'id' => $post->id], ['class' => 'btn btn-warning']) ?>
                                <?= Html::a('Удалить', ['/post/delete', 'id' => $post->id], [
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

        <!-- Пагинация -->
        <div class="mt-4">
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => ['class' => 'pagination justify-content-center'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
            ]) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <h4>📝 Пока нет постов</h4>
            <p>У этого пользователя еще нет опубликованных постов.</p>
            <?php if (Yii::$app->user->id == $user->id): ?>
                <?= Html::a('Написать первый пост', ['/post/create'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>