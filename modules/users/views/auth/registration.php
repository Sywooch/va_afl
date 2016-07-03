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
                <input type="text" name="email" class="form-control" placeholder="First name">
            </div>
            <div class="col-md-6 m-b-15">
                <input type="text" name="language" class="form-control" placeholder="Last name">
            </div>
        </div>
        <!--<label class="control-label">Email</label>
        <div class="row m-b-15">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Email address">
            </div>
        </div>
        <label class="control-label">Re-enter Email</label>
        <div class="row m-b-15">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Re-enter email address">
            </div>
        </div>
        <label class="control-label">Password</label>
        <div class="row m-b-15">
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Password">
            </div>
        </div>


        <div class="checkbox m-b-30">
            <label>
                <input type="checkbox"> By clicking Sign Up, you agree to our <a href="#">Terms</a> and that
                you have read our <a href="#">Data Policy</a>, including our <a href="#">Cookie Use</a>.
            </label>
        </div>-->
        <div class="register-buttons">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
        </div>
        <div class="m-t-20 m-b-40 p-b-40">
            Already a member? Click <a href="login_v3.html">here</a> to login.
        </div>
        <hr>
        <p class="text-center text-inverse">
            © Color Admin All Right Reserved 2015
        </p>
    </form>
</div>