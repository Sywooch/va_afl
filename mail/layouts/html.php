<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Newsletter</title>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <style>
            @font-face {
                font-family: 'Open Sans';
                font-style: normal;
                font-weight: 400;
                src: local('Open Sans'), local('OpenSans'), url('http://fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
            }

            * {
                font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 100%;
                line-height: 1.6em;
                margin: 0;
                padding: 0;
            }

            img {
                max-width: 600px;
                width: auto;
            }

            body {
                -webkit-font-smoothing: antialiased;
                height: 100%;
                -webkit-text-size-adjust: none;
                width: 100% !important;
            }

            a {
                color: #348eda;
            }

            .btn-primary {
                Margin-bottom: 10px;
                width: auto !important;
            }

            .btn-primary td {
                background-color: #348eda;
                border-radius: 25px;
                font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 14px;
                text-align: center;
                vertical-align: top;
            }

            .btn-primary td a {
                background-color: #348eda;
                border: solid 1px #348eda;
                border-radius: 25px;
                border-width: 10px 20px;
                display: inline-block;
                color: #ffffff;
                cursor: pointer;
                font-weight: bold;
                line-height: 2;
                text-decoration: none;
            }

            .last {
                margin-bottom: 0;
            }

            .first {
                margin-top: 0;
            }

            .padding {
                padding: 10px 0;
            }

            table.body-wrap {
                padding: 20px;
                width: 100%;
            }

            table.body-wrap .container {
                border: 1px solid #f0f0f0;
            }

            /* -------------------------------------
                FOOTER
            ------------------------------------- */
            table.footer-wrap {
                clear: both !important;
                width: 100%;
            }

            .footer-wrap .container p {
                color: #666666;
                font-size: 12px;

            }

            table.footer-wrap a {
                color: #999999;
            }

            h1,
            h2,
            h3 {
                color: #111111;
                font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-weight: 200;
                line-height: 1.2em;
                margin: 40px 0 10px;
            }

            h1 {
                font-size: 36px;
            }

            h2 {
                font-size: 28px;
            }

            h3 {
                font-size: 22px;
            }

            p,
            ul,
            ol {
                font-family: "Open Sans", Verdana, Arial, Helvetica, sans-serif;
                font-size: 16px;
                line-height: 1.6875;
                font-weight: normal;
                margin-bottom: 10px;
            }

            ul li,
            ol li {
                margin-left: 5px;
                list-style-position: inside;
            }

            .container {
                clear: both !important;
                display: block !important;
                Margin: 0 auto !important;
                max-width: 600px !important;
            }

            .body-wrap .container {
                padding: 20px;
            }

            .content {
                display: block;
                margin: 0 auto;
                max-width: 600px;
            }

            .content table {
                width: 100%;
            }
        </style>
        <?php $this->head() ?>
    </head>
    <body bgcolor="#f6f6f6">
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>