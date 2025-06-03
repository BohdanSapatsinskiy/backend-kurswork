<?php

use yii\helpers\Html;

$this->title = 'ПУБЛІЧНА ІНФОРМАЦІЯ';
?>

<div id="public-block" class="public-block base-block">
    <div class="title-line"></div>
    <h2 class="block-title-text text-color-fix">
        ПУБЛІЧНА ІНФОРМАЦІЯ
    </h2>
    <?= $this->render('@app/views/components/sortpanel.php',['currentSort' => $currentSort]) ?>

    <div class="file-card-list">
        <?php foreach ($files as $file): ?>
            <div class="file-card" data-title="<?= Html::encode($file->name) ?>" data-date="<?= Html::encode($file->date) ?>">
                <div class="file-info">
                    <span class="file-name"><?= Html::encode($file->name) ?></span>
                    <span class="file-date"><?= date('d.m.Y', strtotime($file->date)) ?></span>
                </div>
                <a href="<?= Yii::getAlias('@web/files/public_info/') . ($file->download_path) ?>" download class="download-btn">Завантажити</a>
                
            </div>
        <?php endforeach; ?>
    </div>

    <?= $this->render('@app/views/components/pagination.php', ['pagination' => $pagination]) ?>
</div>



