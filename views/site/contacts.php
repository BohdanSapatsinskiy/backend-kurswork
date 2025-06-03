<?php
$this->title = 'КОНТАКТИ';
?>


<div id="contacts" class="contact-block">   
    <form id="contacts-form" class="uniForm contact-form-block" method="post">

        <?= yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div class="title-line"></div>
        <h2 class="block-title-text">
            ЗВ'ЯЗАТИСЯ З НАМИ
        </h2>
        <!-- Hidden Required Fields -->
	    <input class="input-el" type="hidden" name="project_name" value="Scorpy">
		<input class="input-el" type="hidden" name="admin_email" value="sapatsinskiy@ukr.net">
		<input class="input-el" type="hidden" name="form_subject" value="Пропозиція стосовно роботи">
		<!-- END Hidden Required Fields -->
            
            
        <input name="E-mail" class="input-el" placeholder="Email" type="text" required>
        <input name="Phone"  class="input-el" placeholder="Номер телефону" type="text" required>
        <input name="Name" class="input-el" placeholder="Ім'я" type="text" required>            
        <textarea name="Text" class="input-el" placeholder="Ваше повідомлення" rows="5" required></textarea>
        <button>Надіслати</button>
    </form>
    <script>
    document.getElementById('contacts-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(location.href, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
            } else {
                alert('Помилка: ' + (data.message || 'Щось пішло не так.'));
            }
        })
        .catch(() => alert('Помилка відправки. Спробуйте ще раз.'));
    });
    </script>


    <?= $this->render('@app/views/components/contact-block.php') ?>
</div>

