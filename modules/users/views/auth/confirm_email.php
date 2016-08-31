<?php
use yii\helpers\BaseHtml; ?>

<h1 class="register-header">
    <?php if (Yii::$app->request->get(
            'lang'
        ) == 'RU'
    ): ?>Регистрация
    <?php else: ?>Sign Up
    <?php endif; ?>
    <small><?php if (Yii::$app->request->get(
                'lang'
            ) == 'RU'
        ): ?>Создайте свой аккаунт в ВА "АФЛ". Это бесплатно и навсегда.<?php else: ?>Create your VA AFL Account. It’s free and always will be.<?php endif; ?></small>
</h1>
<div class="register-content">

    <form action="<?= Yii::$app->request->url ?>" method="POST" class="margin-bottom-0">
        <label class="control-label">Email</label>
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
        <div class="row row-space-10">
            <div class="col-md-6 m-b-15">
                <input required type="text" name="email" class="form-control" placeholder="Email address">
            </div>1
        </div>
        <div class="register-buttons">
            <button type="submit" class="btn btn-primary btn-block btn-lg">    <?php if (Yii::$app->request->get(
                        'lang'
                    ) == 'RU'
                ): ?>Отправить ещё раз
                <?php else: ?>Again
                <?php endif; ?>
                </button>
                <small><?php if (Yii::$app->request->get(
                            'lang'
                        ) == 'RU'
                    ): ?>Обновите ваш email или скажите нам отправить сообщение для подтверждения ещё раз<?php else: ?>Update your email address or tell us to send confirm message again<?php endif; ?></small></button>
            <a class="btn btn-primary btn-block btn-lg" data-method="post" href="/users/auth/logout"><?= Yii::t('app',
                    'Go back') ?></a>
        </div>
        <hr>
        <p class="text-center text-inverse">
            VA AFL
            <br/>&copy; 2012-<?= date('Y') ?>
        </p>
    </form>
</div>