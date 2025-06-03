<?php
$this->title = 'ПРО НАС';
?>


<div id="about-us" class="about-us-blcok base-block">
    <?php foreach ($about as $index => $item): ?>
        <div class="about-us-info-blcok <?= $index % 2 !== 0 ? 'reverse' : '' ?>">
            <div class="about-us-text">
                <div class="title-line"></div>
                <h2 class="block-title-text title-fix">
                    <?= htmlspecialchars($item->tittle) ?>
                </h2>
                <p><?= nl2br(htmlspecialchars($item->text)) ?></p>
            </div>
            <img class="about-us-img <?= $index % 2 !== 0 ? 'large-img' : '' ?>" 
                 src="<?= Yii::getAlias('@web/img/about/') . ($item->img ?: 'default.jpg') ?>" 
                 alt="">
        </div>
    <?php endforeach; ?>
</div>
