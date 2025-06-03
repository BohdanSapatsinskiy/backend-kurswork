<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'НАШІ ПРОЄКТИ';
?>

<div id="our-projects" class="our-projects base-block">
    <div class="title-line"></div>
    <h2 class="block-title-text">
        НАШІ ПРОЄКТИ
    </h2>
    <?= $this->render('@app/views/components/sortpanel.php',['currentSort' => $currentSort]) ?>
    <div class="gallery">
        <?php foreach ($projects as $project): ?>
            <div class="gallery-item" data-date="<?= Html::encode($project->date) ?>" data-title="<?= Html::encode($project->name) ?>">
                <img src="<?= Yii::getAlias('@web/img/project/') . ($project->img ?: 'default.jpg') ?>">
                
                <div class="info-gallery">
                    <h3 class="gallery-title"><?= Html::encode($project->name) ?></h3>
                    <p class="gallery-about"><?= Html::encode(mb_strimwidth($project->text, 0, 80, '...')) ?></p>
                    <span class="gallery-date"><?= Html::encode($project->date) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?= $this->render('@app/views/components/pagination.php', ['pagination' => $pagination]) ?>

</div>
