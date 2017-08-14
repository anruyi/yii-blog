<?php
namespace frontend\views\site;
/* @var $this yii\web\View */

use frontend\widgets\banner\BannerWidget;
use frontend\widgets\chart\ChartWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\post\PostWidget;
use frontend\widgets\tag\TagWidget;

$this->title = '博客';
?>
<div class="row">
    <div class="col-lg-9">
        <!--    图片联播    -->
        <?= BannerWidget::widget() ?>
        <?= PostWidget::widget() ?>
    </div>
    <div class="col-lg-3">
        <?= ChartWidget::widget() ?>
        <?= HotWidget::widget() ?>
        <?= TagWidget::widget() ?>
    </div>
</div>