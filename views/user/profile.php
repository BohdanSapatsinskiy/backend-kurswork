<?php
    $this->title = 'ПРОФІЛЬ';
?>


<div id="profile" class="base-block">
    <form action="" method="post" class="uniForm contact-form-block">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">

        <div class="title-line"></div>
        <h2 class="block-title-text">Профіль</h2>

        <input
            type="text"
            name="User[name]"
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
            name="User[email]"
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
            name="User[password]"
            placeholder="Новий пароль (залиште пустим, щоб не змінювати)"
            class="input-el"
            minlength="8"
        >
        <?php if ($model->hasErrors('password')): ?>
            <div class="error-message"><?= implode('<br>', $model->getErrors('password')) ?></div>
        <?php endif; ?>

        <button type="submit">Зберегти зміни</button>
    </form>
    
    <form action="<?= Yii::$app->urlManager->createUrl(['user/logout']) ?>" method="post" style="margin-top: 1rem;">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">
        <button type="submit" class="logout-button">Вийти</button>
    </form>

</div>
