<?php
use yii\widgets\LinkPager;
?>

<div class="pagination-container" style="margin-top: 30px; text-align: center;">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'options' => ['class' => 'pagination'],
        'prevPageLabel' => '«',
        'nextPageLabel' => '»',
    ]) ?>
</div>
