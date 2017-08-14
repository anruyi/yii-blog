<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
//这句话 用来调用appAsset。php中的css文件
AppAsset::register($this);
?>
<!--这句话是上面的延续一样，也是引用css文件-->
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('common','My Company'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
//    导航中，分为左导航和右导航，这样做确实好看
    $leftMenus = [
        ['label' => Yii::t('common','Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('common','About'), 'url' => ['/site/about']],
        ['label' => Yii::t('common', '文章'), 'url' => ['/post/index']],
//        联系我们组件
//        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
//    滑稽，学习到了，如果他是游客，那么我就显示注册登陆按钮
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('common','Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('common','Login'), 'url' => ['/site/login']];
    } else {
        /*
         * '<li>'
            //导入布局，上下居中和样式,点击关闭
            . 'label' => '<img src="statics/imgs/avatar/avatar-small.jpg" alt="'.Yii::$app->user->identity->username .'" >'
//            . Html::beginForm(['/site/logout'], 'post')
            //导入内容
//            . Html::submitButton(
//                '<img style="width:40px" src="statics/imgs/avatar/avatar-small.jpg" alt="'. Yii::$app->user->identity->username .'">',
////                 .Yii::t('common','退出'). '(' . Yii::$app->user->identity->username . ')'
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
            . '</li>';
         *
         * */
        $menuItems[] = [
            'label' => '<img src="'.Yii::$app->params['avatar']['small'].'" alt="'.Yii::$app->user->identity->username .'" >',
            'linkOptions' => ['class' => 'avatar'],
            'items' => [
                    ['label' => '<span class="glyphicon glyphicon-log-out"></span>退出' ,
                        'url' => ['/site/logout'],'linkOptions' => ['data-method'=>'post'] ],
            ]
        ];
    }
    echo Nav::widget([
        //options 将navbar推向左边
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenus,
    ]);
    echo Nav::widget([
        //options 将navbar推向右边
        'options' => ['class' => 'navbar-nav navbar-right'],
        //防止代码不转编码，lanbels用的，暂时用不上，
         'encodeLabels' => false,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
