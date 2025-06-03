<?php
use yii\helpers\Html;

$this->title = 'РЕЄСТРАЦІЯ';
?>

<div id="register" class="base-block">
    <form action="" method="post" class="uniForm contact-form-block">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">

        <div class="title-line"></div>
        <h2 class="block-title-text">Реєстрація</h2>

        <input
            type="text"
            name="RegisterForm[name]"
            placeholder="Ім'я"
            class="input-el"
            required
            value="<?= htmlspecialchars($model->name ?? '') ?>"
        >
        <?php if ($model->hasErrors('name')): ?>
            <div class="error-message"><?= implode('<br>', $model->getErrors('name')) ?></div>
        <?php endif; ?>

        <input
            type="email"
            name="RegisterForm[email]"
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
            name="RegisterForm[password]"
            placeholder="Пароль"
            class="input-el"
            minlength="8"
            required
        >
        <?php if ($model->hasErrors('password')): ?>
            <div class="error-message"><?= implode('<br>', $model->getErrors('password')) ?></div>
        <?php endif; ?>

        <input
            type="password"
            name="RegisterForm[password_repeat]"
            placeholder="Повторіть пароль"
            class="input-el"
            minlength="8"
            required
        >
        <?php if ($model->hasErrors('password_repeat')): ?>
            <div class="error-message"><?= implode('<br>', $model->getErrors('password_repeat')) ?></div>
        <?php endif; ?>

        <button type="submit">Зареєструватися</button>


        <p>
            Є акаунта? <?= Html::a('Увійти', ['user/login']) ?>
        </p>
    </form>

</div>
