<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Профиль: ' . $model->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="<?= $model->getAvatarUrl() ?>" 
                         alt="Аватар" 
                         class="rounded-circle mb-3"
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                    <h4><?= Html::encode($model->username) ?></h4>
                    <p class="text-muted"><?= Html::encode($model->email) ?></p>
                    
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <h5 class="text-primary"><?= $model->getPosts()->count() ?></h5>
                            <small class="text-muted">Постов</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success"><?= Yii::$app->formatter->asDate($model->created_at) ?></h5>
                            <small class="text-muted">С нами с</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">📝 Последние посты</h5>
                </div>
                <div class="card-body">
                    <?php
                    $recentPosts = $model->getPosts()
                        ->orderBy(['created_at' => SORT_DESC])
                        ->limit(5)
                        ->all();
                    
                    if ($recentPosts): ?>
                        <?php foreach ($recentPosts as $post): ?>
                            <div class="post-item mb-3 pb-3 border-bottom">
                                <h6>
                                    <?= Html::a(Html::encode($post->title), ['/post/view', 'id' => $post->id]) ?>
                                </h6>
                                <p class="text-muted small mb-1">
                                    <?= nl2br(Html::encode(mb_substr($post->content, 0, 100))) ?>...
                                </p>
                                <small class="text-muted">
                                    <?= Yii::$app->formatter->asDatetime($post->created_at) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                        
                        <?= Html::a('📖 Все посты пользователя', ['posts', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-sm mt-2']) ?>
                    <?php else: ?>
                        <p class="text-muted">У пользователя пока нет постов.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>