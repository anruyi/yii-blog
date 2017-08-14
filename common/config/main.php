<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        /*
//         * URL美化设置
//         * */
//        'urlManager' => [
//            'class' => 'yii\web\UrlManager',
//        //开启url美化开关
//            'enablePrettyUrl' => true,
//        //关闭一个脚本文件
//            'showScriptName' => fale,
//        //追加后缀
//            'suffix' => '.html',
//            'rules' => array(
//            ),
//        ],
        /* END */
        /*
         * 语言包
         * */
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'common' => 'common.php'
                    ],
                ],
            ],
        ],
        /* END */
    ],
];
