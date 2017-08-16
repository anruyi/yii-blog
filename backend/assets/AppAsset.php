<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'statics/css/layout.css',
        'statics/css/font-awesome-4.4.0/css/front-awesome.min.css',
        'statics/css/site.css',
    ];
    public $js = [
        //注意顺序
        'statics/js/jquery-ui.js',
        'statics/js/toggles.js',
        'statics/js/layout.js',
        'statics/js/sites.js',
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
