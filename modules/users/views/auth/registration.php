<?php
use yii\helpers\BaseHtml;?>

<h1 class="register-header">
    Sign Up
    <small>Create your Color Admin Account. It’s free and always will be.</small>
</h1>
<!-- end register-header -->
<!-- begin register-content -->
<div class="register-content">

    <form action="<?= Yii::$app->request->url ?>" method="POST" class="margin-bottom-0">
        <label class="control-label">Name</label>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="row row-space-10">
            <div class="col-md-6 m-b-15">
                <input type="text" name="email" class="form-control" placeholder="Email address">
            </div>
            <div class="col-md-6 m-b-15">
                <input type="text" name="language" class="form-control" placeholder="Language">
            </div>
        </div>
        <div class="register-buttons">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
        </div>
        <hr>
        <p class="text-center text-inverse">
            © Color Admin All Right Reserved 2015
        </p>
    </form>
</div>