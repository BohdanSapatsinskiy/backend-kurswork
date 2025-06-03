<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'SCORPY';
?>

<div id="hello" class="hello-block base-block">
    <div>
        <h1 class="hello-title">
             SCORPY
        </h1>            
    </div>
    <div>
        <h2 class="hello-text">
            Ваші мрії – наші проєкти
        </h2>
    </div>
</div>


<div id="service" class="service-block base-block">
    <div class="title-line"></div>
    <h2 class="block-title-text">НАШІ ПОСЛУГИ</h2>
    <div class="service-cards-block">
        <?php foreach ($services as $service): ?>
            <div class="service-card">
                <div class="service-card-img-part">
                    <img class="service-card-img" src="<?= Yii::getAlias('@web/img/services/') . ($service->img ?: 'default.png') ?>" alt="">
                </div>
                <div class="service-card-text-part">
                    <h3 class="card-title"><?= htmlspecialchars($service->tittle) ?></h3>
                    <div class="card-about-text"><?= nl2br(htmlspecialchars($service->about)) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="users-messages-block fix-block-color text-color-fix">
    <div class="title-line"></div>
    <h2 class="block-title-text">ВІДГУКИ КЛІЄНТІВ</h2>

    <div class="user-message-list">
        <?php foreach ($comments as $comment): ?>
            <div class="user-message-card">
                <div class="user-message-header">
                    <span class="user-name"><?= htmlspecialchars($comment->user->name ?? 'Користувач') ?></span>
                    <span class="user-date"><?= Yii::$app->formatter->asDate($comment->date, 'php:d.m.Y') ?></span>
                </div>
                <div class="user-rating">
                    <?php
                        $fullStars = (int)$comment->mark; // просто ціле число
                        $emptyStars = 5 - $fullStars;

                        echo str_repeat('⭐', $fullStars);
                        echo str_repeat('☆', $emptyStars);
                    ?>
                </div>
                <div class="user-message-text">
                    <?= nl2br(htmlspecialchars($comment->text)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    const slider = document.querySelector('.user-message-list');
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 1.5; // коефіцієнт швидкості
        slider.scrollLeft = scrollLeft - walk;
    });
</script>




<div id="contacts" class="contact-block">
        
    <form id="comment-form" class="uniForm contact-form-block" method="post">
        <div class="title-line"></div>
        <h2 class="block-title-text">
            ЗАЛИШИТИ ВІДГУК
        </h2>

        <input name="Mark" class="input-el" placeholder="Оцінка якості" type="number" min="0" max="5" required>         
        <textarea name="Text" class="input-el" placeholder="Ваше повідомлення" rows="5" maxlength="500" required></textarea>
        <button type="submit">Надіслати</button>
    </form>
    <script>
    document.querySelector('textarea[name="Text"]').addEventListener('input', function () {
        if (this.value.length > 500) {
            this.value = this.value.slice(0, 500);
        }
    });


    document.getElementById('comment-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('<?= \yii\helpers\Url::to(['site/add-comment']) ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Ваш коментар відправлено на перевірку");
                form.reset();
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.errors) {
                alert("Помилка: " + Object.values(data.errors).join(', '));
            } else {
                alert("Невідома помилка.");
            }
        })
        .catch(err => {
            alert("Помилка при відправці форми.");
            console.error(err);
        });
    });
    </script>

        
    <?= $this->render('@app/views/components/contact-block.php') ?>
</div>