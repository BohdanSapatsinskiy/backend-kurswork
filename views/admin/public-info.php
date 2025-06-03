<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ПУБЛІЧНА ІНФОРМАЦІЯ';
?>

<div class="base-block">
    <div class="container-fluid">
        <div class="row">
            <?= $this->render('@app/views/components/adminpanel.php') ?>
            <div class="col-md-10">
                <h3>Публічна інформація</h3>

                <h5>Додати запис</h5>
                <form id="public-info-form" enctype="multipart/form-data" class="row g-2 mb-4">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Назва" required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Додати</button>
                    </div>
                    <div class="col-12">
                        <div id="public-info-message"></div>
                    </div>
                </form>

                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Дата</th>
                            <th>Файл</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody id="public-info-table">
                        <?php foreach ($items as $item): ?>
                            <tr data-id="<?= $item->id ?>">
                                <td><?= $item->id ?></td>
                                <td contenteditable="true" data-field="name"><?= Html::encode($item->name) ?></td>
                                <td contenteditable="true" data-field="date"><?= Html::encode($item->date) ?></td>
                                <td>
                                    <?php if ($item->download_path): ?>
                                        <a href="<?= Url::to('@web/files/public_info/' . $item->download_path) ?>" target="_blank">Завантажити</a>
                                    <?php else: ?>
                                        Немає файлу
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-public-info">Видалити</button>
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
$createUrl = Url::to(['admin/create-public-info']);
$updateUrl = Url::to(['admin/update-public-info']);
$deleteUrl = Url::to(['admin/delete-public-info']);
$csrf = Yii::$app->request->getCsrfToken();
?>

<script>
document.getElementById('public-info-form').addEventListener('submit', function (e) {
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
        const msg = document.getElementById('public-info-message');
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

document.querySelectorAll('.delete-public-info').forEach(btn => {
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
