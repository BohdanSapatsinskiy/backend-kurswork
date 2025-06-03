<div class="sort-panel">
    <?php
    $sortOptions = [
        'date-desc' => 'Нові → Старі',
        'date-asc' => 'Старі → Нові',
        'title-asc' => 'A → Я',
        'title-desc' => 'Я → A',
    ];

    foreach ($sortOptions as $value => $label):
        $url = Yii::$app->urlManager->createUrl([
            Yii::$app->controller->id . '/' . Yii::$app->controller->action->id,
            'sort' => $value
        ]);
    ?>
        <button
            class="sort-button <?= $currentSort === $value ? 'active' : '' ?>"
            type="button"
            data-url="<?= $url ?>"
        >
            <?= $label ?>
        </button>
    <?php endforeach; ?>
</div>

<script>
document.querySelectorAll('.sort-button').forEach(button => {
    button.addEventListener('click', () => {
        const url = button.getAttribute('data-url');
        if (url) {
            window.location.href = url;
        }
    });
});
</script>
