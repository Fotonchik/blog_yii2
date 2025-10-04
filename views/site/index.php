<?php

/** @var yii\web\View $this */

$this->title = 'Главная | Мой Блог';
?>

<!-- Герой секция -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Добро пожаловать в МойБлог</h1>
                <p class="lead mb-4">Платформа для творческих людей, где можно делиться своими мыслями, идеями и вдохновением с миром.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/post/index']) ?>" class="btn btn-light btn-lg px-4 gap-3">
                        📖 Читать блог
                    </a>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/auth/register']) ?>" class="btn btn-outline-light btn-lg px-4">
                            🚀 Присоединиться
                        </a>
                    <?php else: ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/post/create']) ?>" class="btn btn-outline-light btn-lg px-4">
                            ✍️ Написать пост
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Особенности -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold">Почему выбирают нас?</h2>
                <p class="text-muted">Современная платформа с множеством возможностей для ведения блога</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3" style="font-size: 3rem;">🎨</div>
                        <h5 class="card-title">Красивый дизайн</h5>
                        <p class="card-text">Современный и адаптивный дизайн, который отлично выглядит на любом устройстве.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card feature-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3" style="font-size: 3rem;">⚡</div>
                        <h5 class="card-title">Высокая скорость</h5>
                        <p class="card-text">Оптимизированная платформа, которая работает быстро и без задержек.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card feature-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3" style="font-size: 3rem;">🔒</div>
                        <h5 class="card-title">Безопасность</h5>
                        <p class="card-text">Ваши данные защищены современными методами шифрования и безопасности.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Статистика -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="fw-bold text-primary"><?= \app\models\Post::find()->count() ?>+</h3>
                    <p class="text-muted">Опубликованных постов</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="fw-bold text-primary"><?= \app\models\User::find()->count() ?>+</h3>
                    <p class="text-muted">Зарегистрированных пользователей</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="fw-bold text-primary">24/7</h3>
                    <p class="text-muted">Доступность платформы</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="fw-bold text-primary">100%</h3>
                    <p class="text-muted">Удовлетворенных пользователей</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Последние посты -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold">Последние публикации</h2>
                <p class="text-muted">Самые свежие посты от нашего сообщества</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            $recentPosts = \app\models\Post::find()
                ->orderBy(['created_at' => SORT_DESC])
                ->limit(3)
                ->all();
            
            foreach ($recentPosts as $post): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <?php if ($post->image): ?>
                        <img src="<?= Yii::getAlias('@web/uploads/' . $post->image) ?>" 
                             class="card-img-top" 
                             alt="<?= yii\helpers\Html::encode($post->title) ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= yii\helpers\Html::encode($post->title) ?></h5>
                        <p class="card-text flex-grow-1">
                            <?= nl2br(yii\helpers\Html::encode(mb_substr($post->content, 0, 100))) ?>...
                        </p>
                        <div class="mt-auto">
                            <small class="text-muted">
                                Автор: <?= yii\helpers\Html::encode($post->author->username) ?><br>
                                <?= Yii::$app->formatter->asDatetime($post->created_at) ?>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/post/view', 'id' => $post->id]) ?>" 
                           class="btn btn-primary btn-sm">
                            Читать далее
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($recentPosts) > 0): ?>
        <div class="text-center mt-4">
            <a href="<?= Yii::$app->urlManager->createUrl(['/post/index']) ?>" class="btn btn-outline-primary">
                Смотреть все посты
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>