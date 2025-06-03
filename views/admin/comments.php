<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'КОМЕНТАРІ';
?>
<div class="base-block">
    <div class="container-fluid">
        <div class="row">
            <?= $this->render('@app/views/components/adminpanel.php') ?>
            <div class="col-md-10">
                <h3>Коментарі</h3>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Користувач</th>
                            <th>Оцінка</th>
                            <th>Текст</th>
                            <th>Коректний</th>
                            <th>Дата</th>
                            <th>Дія</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr data-id="<?= $comment->id ?>">
                                <td><?= $comment->id ?></td>
                                <td><?= Html::encode($comment->user->name) ?></td>
                                <td contenteditable="true" data-field="mark"><?= $comment->mark ?></td>
                                <td contenteditable="true" data-field="text"><?= Html::encode($comment->text) ?></td>
                                <td contenteditable="true" data-field="is_correct"><?= $comment->is_correct ?></td>
                                <td><?= $comment->date ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-comment">Видалити</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php $updateUrl = Url::to(['admin/update-comment']); ?>
<script>
document.querySelectorAll('td[contenteditable=true]').forEach(td => {
    td.addEventListener('blur', function() {
        const tr = td.closest('tr');
        const id = tr.dataset.id;
        const field = td.dataset.field;
        const value = td.textContent.trim();

        fetch('<?= $updateUrl ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>'
            },
            body: new URLSearchParams({
                id: id,
                field: field,
                value: value
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Помилка оновлення');
            }
        })
        .catch(() => alert('Помилка з\'єднання'));
    });
});

</script>
<?php $deleteUrl = Url::to(['admin/delete-comment']); ?>
<script>
document.querySelectorAll('.delete-comment').forEach(button => {
    button.addEventListener('click', function () {
        if (!confirm('Ви впевнені, що хочете видалити цей коментар?')) return;

        const tr = this.closest('tr');
        const id = tr.dataset.id;

        fetch('<?= $deleteUrl ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>'
            },
            body: new URLSearchParams({ id: id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tr.remove();
            } else {
                alert(data.message || 'Не вдалося видалити');
            }
        })
        .catch(() => alert('Помилка з\'єднання'));
    });
});
</script>

