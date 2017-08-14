<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 17-8-2
 * Time: 18:17
 */
$this->title = $data['title'];
$this->params['breadcrumbs'][] = ['label'=>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][] = $data['title'];
?>

<div class="row">
    <div></div>
    <div class="col-lg-9">
        <div class="page-title ">
            <h1><?=$data['title']?></h1>
            <span>作者：<?=$data['user_name']?></span>
            <span>发布：<?=date('Y-m-d',$data['created_at']);?></span>
            <span>浏览：<?= isset($data['extend']['browser'])?$data['extend']['browser']:0?> </span>
<!--            <span></span>-->
        </div>

        <div class="page-content">
            <?=$data['content']?>
        </div>
        <div class="page-tag">
        标签：
            <?php foreach($data['tags'] as $tag): ?>
            <span>
                <a href="#">
                    <?=$tag?>
                </a>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>
