<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="col-md-2 bg-light p-3">

<h5>Панель</h5>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active" href="<?= Url::to(['admin/comments']) ?>">Коментарі</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= Url::to(['admin/services']) ?>">Сервіси</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= Url::to(['admin/about-us']) ?>">Про нас</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= Url::to(['admin/project']) ?>">Проєкти</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= Url::to(['admin/public-info']) ?>">Публічна інформація</a></li>
    </ul>
</div>