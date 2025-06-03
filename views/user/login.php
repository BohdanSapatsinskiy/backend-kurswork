<?php
use yii\helpers\Html;

$this->title = 'ВХІД НА САЙТ';
?>

<div id="login" class="base-block">
    <form action="" method="post" class="uniForm contact-form-block">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">

        <div class="title-line"></div>
        <h2 class="block-title-text">Вхід на сайт</h2>

        <input
            type="email"
            name="LoginForm[email]"
            placeholder="Email"
            class="input-el"
            required
            value="<?= htmlspecialchars($model->email ?? '') ?>"
        >
        <?php if ($model->hasErrors('email')): ?>
            <div class="error-message"><?= implode('<br>', $model->getErrors('email')) ?></div>
        <?php endif; ?>

        <input
            type="password"
            name="LoginForm[password]"
            placeholder="Пароль"
            class="input-el"
            required
        >
        <?php if ($model->hasErrors('password')): ?>
            <div class="error-message"><?= implode('<br>', $model->getErrors('password')) ?></div>
        <?php endif; ?>



        <button type="submit">Увійти</button>

        <p>
            Нема акаунта? <?= Html::a('Зареєструватися', ['user/register']) ?>
        </p>
    </form>
</div>
