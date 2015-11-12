<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 12.11.15
 * Time: 15:41
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
        <a href="site/login">
            <span class="hidden-xs">Login</span>
        </a>
