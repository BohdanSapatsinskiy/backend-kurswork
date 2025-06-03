<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="base-block">
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p class="user-message-text">
            Будь ласка, 
            <a href="<?= Yii::$app->urlManager->createUrl(['site/contacts']) ?>">зв'яжіться з нами, якщо ви вважаєте, що це помилка сервера</a>. Дякуємо вам!.
        </p>

    </div>
</div>
