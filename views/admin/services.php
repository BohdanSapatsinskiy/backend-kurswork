<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'ПОСЛУГИ';
?>

<div class="base-block">
    <div class="container-fluid">
        <div class="row">

            <?= $this->render('@app/views/components/adminpanel.php') ?>

            <div class="col-md-10">
                <h3>Послуги</h3>

                <h5>Додати нову послугу</h5>
                <form id="service-form" enctype="multipart/form-data" class="row g-2 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="tittle" class="form-control" placeholder="Заголовок" required>
                    </div>
                    <div class="col-md-4">
                        <textarea name="about" class="form-control" placeholder="Опис" required></textarea>
                    </div>
                    <div class="col-md-3">
                        <input type="file" name="img" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success w-100">Додати</button>
                    </div>
                    <div class="col-12">
                        <div id="form-message"></div>
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
                    <tbody id="services-table">
                        <?php foreach ($services as $service): ?>
                            <tr data-id="<?= $service->id ?>">
                                <td><?= $service->id ?></td>
                                <td>
                                    <?php if ($service->img): ?>
                                        <img src="<?= Url::to("@web/img/services/{$service->img}") ?>" width="80">
                                    <?php else: ?>
                                        Немає
                                    <?php endif; ?>
                                </td>
                                <td contenteditable="true" data-field="tittle"><?= Html::encode($service->tittle) ?></td>
                                <td contenteditable="true" data-field="about"><?= Html::encode($service->about) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-service">Видалити</button>
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
$createUrl = Url::to(['admin/create-service']);
$updateUrl = Url::to(['admin/update-service']);
$deleteUrl = Url::to(['admin/delete-service']);
$csrf = Yii::$app->request->getCsrfToken();
?>

<script>
document.getElementById('service-form').addEventListener('submit', function (e) {
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
        const messageDiv = document.getElementById('form-message');
        if (d.success) {
            messageDiv.innerHTML = '<p class="text-success">Сервіс додано успішно!</p>';
            setTimeout(() => location.reload(), 1000);
        } else {
            messageDiv.innerHTML = '<p class="text-danger">' + (d.message || 'Помилка') + '</p>';
        }
    })
    .catch(() => {
        document.getElementById('form-message').innerHTML = '<p class="text-danger">Щось пішло не так...</p>';
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

document.querySelectorAll('.delete-service').forEach(btn => {
    btn.addEventListener('click', function () {
        if (!confirm('Ви впевнені, що хочете видалити цей сервіс?')) return;

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
