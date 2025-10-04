<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?> | Мой Блог</title>
    <?php $this->head() ?>
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .footer {
            background: #2c3e50;
            color: white;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<!-- Навигация -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
            📝 МойБлог
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site/index']) ?>">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/post/index']) ?>">Блог</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site/about']) ?>">О проекте</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/auth/register']) ?>">Регистрация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/auth/login']) ?>">Войти</a>
                    </li>
                <?php else: ?>
                    <!-- ДОБАВЛЯЕМ ССЫЛКУ НА ЛИЧНЫЙ КАБИНЕТ -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/profile/index']) ?>">
                            👤 Личный кабинет
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/auth/logout']) ?>" 
                           data-method="post">Выйти (<?= Yii::$app->user->identity->username ?>)</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Основной контент -->
<main class="flex-shrink-0" role="main">
    <?= Breadcrumbs::widget([
        'links' => $this->params['breadcrumbs'] ?? [],
        'options' => ['class' => 'breadcrumb mt-4']
    ]) ?>
    
    <?= Alert::widget() ?>
    
    <?= $content ?>
</main>
<!-- Футер -->
<footer class="footer mt-auto py-4 ">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold">📝 МойБлог</h5>
                <p class="text-muted">Лучшая платформа для ведения личного блога и обмена мыслями.</p>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold">Навигация</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/index']) ?>" class="text-primary text-decoration-none">Главная</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/post/index']) ?>" class="text-primary text-decoration-none">Блог</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/about']) ?>" class="text-primary text-decoration-none">О проекте</a></li>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/profile/index']) ?>" class="text-primary text-decoration-none">Личный кабинет</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold">Контакты</h5>
                <ul class="list-unstyled">
                    <li><a href="mailto:info@myblog.com" class="text-primary text-decoration-none">info@myblog.com</a></li>
                    <li><a href="tel:+79999999999" class="text-primary text-decoration-none">+7 (999) 999-99-99</a></li>
                </ul>
            </div>
        </div>
        <div class="row mt-4 pt-3 border-top">
            <div class="col-12 text-center">
                <p class="text-muted small mb-0">&copy; <?= date('Y') ?> МойБлог. Все права защищены.</p>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>