<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/svg+xml', 'href' => Yii::getAlias('@web/img/logo1.svg')]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/style/style.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/style/fonts.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/style/menu.css') ?>">

    <link rel="stylesheet" href="<?= Yii::getAlias('@web/style/aboutUs.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/style/gallery.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/style/public.css') ?>">
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <div class="header-block">
        <div class="header-logo">
            <img class="header-logo-img" src="<?= Yii::getAlias('@web/img/logo1.svg') ?>" alt="logo">
            <a class="header-logo-text" href="<?= Yii::$app->homeUrl ?>">SKORPY</a>
        </div>

        <input id="menu-toggle" type="checkbox" />
        <label class='menu-button-container' for="menu-toggle">
            <div class='menu-button'></div>
        </label>
        <ul class="menu">
            <li><a class="header-nav-item" href="<?= Yii::$app->urlManager->createUrl(['site/about']) ?>">ПРО НАС</a></li>
            <li><a class="header-nav-item" href="<?= Yii::$app->urlManager->createUrl(['site/projects']) ?>">НАШІ ПРОЕКТИ</a></li>
            <li><a class="header-nav-item" href="<?= Yii::$app->urlManager->createUrl(['site/public']) ?>">ПУБЛІЧНА ІНФОРМАЦІЯ</a></li>
            <li><a class="header-nav-item" href="<?= Yii::$app->urlManager->createUrl(['site/contacts']) ?>">КОНТАКТИ</a></li>

            <?php if (Yii::$app->user->isGuest): ?>
                <li><a class="header-nav-item" href="<?= Yii::$app->urlManager->createUrl(['user/login']) ?>">УВІЙТИ</a></li>
            <?php else: ?>
                <li><a class="header-nav-item" href="<?= Yii::$app->urlManager->createUrl(['user/profile']) ?>">ПРОФІЛЬ</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>

<section>
    <?= $content ?>
</section>

<footer class="footer-block">
    <a class="footer-text" href="#hello">© SKORPY <?= date('Y') ?></a>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
