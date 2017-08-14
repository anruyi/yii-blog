<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'statics/css/site.css',
        'statics/css/base.css',
    ];
    public $js = [
        'statics/js/site.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'api\assets\AppAsset']);
    }
    //没有这个方法引入的css无效
    public static function addCss($view, $cssfile){
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'api\assets\AppAsset']);
    }
}
