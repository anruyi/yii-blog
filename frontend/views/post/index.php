<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-7-30
 * Time: 18:42
 */

use yii\helpers\Html;
use frontend\widgets\post\PostWidget;

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => '文章','url'=>'post\index'];
$this->params['breadcrumbs'][] = $this->title;
    echo 'THis index.php file ,hello world!';
?>

<div class="row">
    <div class="col-lg-9">
        <?= PostWidget::widget() ?>
    </div>
    <div class="col-lg-3">

    </div>
</div>