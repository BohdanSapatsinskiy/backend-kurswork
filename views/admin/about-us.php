<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ПРО НАС';
?>

<div class="base-block">
    <div class="container-fluid">
        <div class="row">
            <?= $this->render('@app/views/components/adminpanel.php') ?>
            <div class="col-md-10">
                <h3>Про нас</h3>

                <h5>Додати запис</h5>
                <form id="about-form" enctype="multipart/form-data" class="row g-2 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="tittle" class="form-control" placeholder="Заголовок" required>
                    </div>
                    <div class="col-md-4">
                        <textarea name="text" class="form-control" placeholder="Опис" required></textarea>
                    </div>
                    <div class="col-md-3">
                        <input type="file" name="img" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success w-100">Додати</button>
                    </div>
                    <div class="col-12">
                        <div id="about-message"></div>
                    </div>
                </form>

                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Зображення</th>
                            <th>Заголовок</th>
                            <th>Опис</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody id="about-table">
                        <?php foreach ($items as $item): ?>
                            <tr data-id="<?= $item->id ?>">
                                <td><?= $item->id ?></td>
                                <td>
                                    <?php if ($item->img): ?>
                                        <img src="<?= Url::to("@web/img/about/{$item->img}") ?>" width="80">
                                    <?php else: ?>
                                        Немає
                                    <?php endif; ?>
                                </td>
                                <td contenteditable="true" data-field="tittle"><?= Html::encode($item->tittle) ?></td>
                                <td contenteditable="true" data-field="text"><?= Html::encode($item->text) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-about">Видалити</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$createUrl = Url::to(['admin/create-about']);
$updateUrl = Url::to(['admin/update-about']);
$deleteUrl = Url::to(['admin/delete-about']);
$csrf = Yii::$app->request->getCsrfToken();
?>

<script>
document.getElementById('about-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch('<?= $createUrl ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-Token': '<?= $csrf ?>'
        },
        body: formData
    })
    .then(r => r.json())
    .then(d => {
        const msg = document.getElementById('about-message');
        if (d.success) {
            msg.innerHTML = '<p class="text-success">Запис додано!</p>';
            setTimeout(() => location.reload(), 1000);
        } else {
            msg.innerHTML = '<p class="text-danger">' + (d.message || 'Помилка') + '</p>';
        }
    });
});

document.querySelectorAll('td[contenteditable=true]').forEach(td => {
    td.addEventListener('blur', function () {
        const tr = td.closest('tr');
        const id = tr.dataset.id;
        const field = td.dataset.field;
        const value = td.textContent.trim();

        fetch('<?= $updateUrl ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': '<?= $csrf ?>'
            },
            body: new URLSearchParams({ id, field, value })
        })
        .then(r => r.json())
        .then(d => {
            if (!d.success) alert(d.message || 'Помилка при збереженні');
        });
    });
});

document.querySelectorAll('.delete-about').forEach(btn => {
    btn.addEventListener('click', function () {
        if (!confirm('Видалити запис?')) return;

        const tr = btn.closest('tr');
        const id = tr.dataset.id;

        fetch('<?= $deleteUrl ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': '<?= $csrf ?>'
            },
            body: new URLSearchParams({ id })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                tr.remove();
            } else {
                alert(d.message || 'Не вдалося видалити');
            }
        });
    });
});
</script>
