<?php

/** @var yii\web\View $this */

$this->title = 'О проекте | Мой Блог';
$this->params['breadcrumbs'][] = 'О проекте';
?>

<!-- Заголовок -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold">О нашем проекте</h1>
                <p class="lead">Узнайте больше о платформе, которая меняет подход к ведению блогов</p>
            </div>
        </div>
    </div>
</section>

<!-- О проекте -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Наша миссия</h2>
                <p class="lead mb-4">
                    Мы создали МойБлог с целью предоставить каждому возможность легко и удобно делиться 
                    своими мыслями, знаниями и творчеством с широкой аудиторией.
                </p>
                <p class="text-muted">
                    Наша платформа сочетает в себе простоту использования и мощный функционал, 
                    позволяя сосредоточиться на самом важном - создании качественного контента.
                </p>
                
                <div class="mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-3" style="font-size: 1.5rem;">✅</span>
                        <span>Интуитивно понятный интерфейс</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-3" style="font-size: 1.5rem;">✅</span>
                        <span>Мгновенная публикация постов</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-3" style="font-size: 1.5rem;">✅</span>
                        <span>Поддержка изображений и медиа</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-3" style="font-size: 1.5rem;">✅</span>
                        <span>Адаптивный дизайн для всех устройств</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card feature-card">
                    <div class="card-body text-center p-5">
                        <div style="font-size: 4rem;" class="mb-3">🚀</div>
                        <h4 class="card-title">Технологии</h4>
                        <p class="card-text">
                            Наш блог построен на современных технологиях:<br>
                            <strong>Yii2 PHP Framework</strong>, 
                            <strong>Bootstrap 5</strong>, 
                            <strong>MySQL</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Команда -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold">Для кого создан наш блог?</h2>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body p-4">
                        <div style="font-size: 3rem;" class="mb-3">👩‍💻</div>
                        <h5 class="card-title">Блоггеры</h5>
                        <p class="card-text">Для тех, кто хочет делиться своим опытом и знаниями с миром.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body p-4">
                        <div style="font-size: 3rem;" class="mb-3">👨‍🎨</div>
                        <h5 class="card-title">Творческие люди</h5>
                        <p class="card-text">Писатели, художники, фотографы - все найдут здесь свою аудиторию.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body p-4">
                        <div style="font-size: 3rem;" class="mb-3">👨‍🏫</div>
                        <h5 class="card-title">Эксперты</h5>
                        <p class="card-text">Специалисты, желающие делиться профессиональными знаниями.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA секция -->
<section class="py-5 text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-4">Готовы начать?</h2>
                <p class="lead mb-4">Присоединяйтесь к нашему сообществу и начните делиться своими мыслями уже сегодня!</p>
                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/auth/register']) ?>" class="btn btn-primary btn-lg px-5">
                        Начать бесплатно
                    </a>
                <?php else: ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/post/create']) ?>" class="btn btn-primary btn-lg px-5">
                        Написать первый пост
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>